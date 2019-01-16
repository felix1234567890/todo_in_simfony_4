<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TodoRepository")
 */
class Todo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(min=6,max=200, minMessage="Title should have at least 6 characters")
     */
    private $title;
    public function getTitle(){
        return $this->title;
    }
    public function setTitle($title){
        $this->title = $title;
    }
     /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotNull
     */
    private $Difficulty;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     */
    private $Duedate;
    public function getDescription(){
        return $this->description;
    }
    public function setDescription($description){
        $this->description = $description;
    }

    public function getDifficulty(): ?int
    {
        return $this->Difficulty;
    }

    public function setDifficulty(int $Difficulty): self
    {
        $this->Difficulty = $Difficulty;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->Duedate;
    }

    public function setDueDate(\DateTimeInterface $Duedate): self
    {
        $this->Duedate = $Duedate;

        return $this;
    }

}
