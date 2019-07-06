<?php

namespace App\Entity;

use DateInterval;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;


/**
 * @ORM\Entity(repositoryClass="App\Repository\TokenRepository")
 */
class Token
{
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     */
    private $user;
    public function __construct(User $user){
        try {
            $this->expiresAt = new \DateTime();
        } catch (\Exception $e) {
        }
        $this->user = $user;
        $this->value = md5(uniqid());
    }  
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    // /**
    //  * @ORM\Column(type="string", length=255)
    //  */
    // private $token;

     
   
    public function getId(): ?int
    {
        return $this->id;
    }

     /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $expiresAt;
    
    public function getExpiresAt(): ?\DateTimeInterface
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?\DateTimeInterface $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
 
    public function isValid()
    {
        $interval = new \DateInterval('PT6H');
        return $this->expiresAt->add($interval) >= new \DateTime();
    }
}
