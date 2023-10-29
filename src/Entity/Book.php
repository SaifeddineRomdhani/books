<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $ref = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $publicationDate = null;

    #[ORM\Column(length: 255)]
    private ?string $published = null;

    #[ORM\ManyToOne(inversedBy: 'book')]
    #[ORM\JoinColumn(name:'nc_id',referencedColumnName:'id')]
    private ?Author $author = null;

    #[ORM\ManyToMany(targetEntity: Reader::class, inversedBy: 'books')]
    #[ORM\JoinColumn(name:'book_id',referencedColumnName:'ref')]
    private Collection $reader;

    public function __construct()
    {
        $this->reader = new ArrayCollection();
    }

    public function getRef(): ?int
    {
        return $this->ref;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Summary of setTitle
     * @param string $title
     * @return static
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(?\DateTimeInterface $publicationDate): static
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getPublished(): ?string
    {
        return $this->published;
    }

    public function setPublished(string $published): static
    {
        $this->published = $published;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): static
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, Reader>
     */
    public function getReader(): Collection
    {
        return $this->reader;
    }

    public function addReader(Reader $reader): static
    {
        if (!$this->reader->contains($reader)) {
            $this->reader->add($reader);
        }

        return $this;
    }

    public function removeReader(Reader $reader): static
    {
        $this->reader->removeElement($reader);

        return $this;
    }

	/**
	 * @return 
	 */
	
}
