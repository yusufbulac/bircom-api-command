<?php

namespace App\Command;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class InsertMovieCommand extends Command
{
    /**
     * @var HttpClientInterface
     */
    private $client;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param HttpClientInterface $client
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(HttpClientInterface $client, EntityManagerInterface $entityManager)
    {
        $this->client = $client;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:insert-command-movie')
            ->setDescription('Import comedy movie from tvmaze');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $response = $this->client->request(
            'GET',
            'http://api.tvmaze.com/search/shows?q=comedy'
        );

        $statusCode = $response->getStatusCode();

        switch ($statusCode) {
            case 200:
                $io->success('Successful. Status code: ' . $statusCode);
                break;
            case 403:
                $io->error('Forbidden. Status code: ' . $statusCode);
                return 1;
            case 404:
                $io->error('Not Found. Status code: ' . $statusCode);
                return 1;
            default:
                $io->error('Something is wrong. Status code: ' . $statusCode);
                return 1;
        }

        $content = $response->toArray();

        $io->success('Starting to import movies from tvmaze to database.');

        $table = new Table($output);
        $table
            ->setHeaders(['No', 'Name']);

        $no = 1;

        foreach ($content as $movie) {

            $tvmazeId = $movie['show']['id'];
            $urlMaze = $movie['show']['url'];
            $officialUrl = $movie['show']['officialSite'];
            $name = $movie['show']['name'];
            $language = $movie['show']['language'];
            $premiered = $movie['show']['premiered'];
            $image = $movie['show']['image']['original'];
            $summary = ($movie['show']['summary']) ? $movie['show']['summary'] : 'No info';

            $movie = new Movie();
            $movie->setTvmazeId($tvmazeId);
            $movie->setUrlMaze($urlMaze);
            $movie->setUrlOfficial($officialUrl);
            $movie->setName($name);
            $movie->setLanguage($language);
            $movie->setPremiered(\DateTime::createFromFormat(('Y-m-d'),$premiered));
            $movie->setImage($image);
            $movie->setSummary($summary);

            $this->entityManager->persist($movie);

            $table->addRow([$no, $name]);
            $no++;
        }

        $this->entityManager->flush();

        $table->render();
        $io->success('Import complete.');

        return Command::SUCCESS;
    }
}