<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovieRepository::class)
 */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $tvmazeId;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $urlMaze;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $urlOfficial;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $language;

    /**
     * @ORM\Column(type="date")
     */
    private $premiered;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $summary;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTvmazeId(): ?int
    {
        return $this->tvmazeId;
    }

    public function setTvmazeId(int $tvmazeId): self
    {
        $this->tvmazeId = $tvmazeId;

        return $this;
    }

    public function getUrlMaze(): ?string
    {
        return $this->urlMaze;
    }

    public function setUrlMaze(string $urlMaze): self
    {
        $this->urlMaze = $urlMaze;

        return $this;
    }

    public function getUrlOfficial(): ?string
    {
        return $this->urlOfficial;
    }

    public function setUrlOfficial(string $urlOfficial): self
    {
        $this->urlOfficial = $urlOfficial;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getPremiered(): ?\DateTimeInterface
    {
        return $this->premiered;
    }

    public function setPremiered(\DateTimeInterface $premiered): self
    {
        $this->premiered = $premiered;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }
}
