<?php

namespace App\Entity;

use App\Repository\ATPlatformRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ATPlatformRepository::class)
 */
class ATPlatform
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=ATDevice::class, mappedBy="atPlatform")
     */
    private $aTDevices;

    public function __construct()
    {
        $this->aTDevices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, ATDevice>
     */
    public function getATDevices(): Collection
    {
        return $this->aTDevices;
    }

    public function addATDevice(ATDevice $aTDevice): self
    {
        if (!$this->aTDevices->contains($aTDevice)) {
            $this->aTDevices[] = $aTDevice;
            $aTDevice->setAtPlatform($this);
        }

        return $this;
    }

    public function removeATDevice(ATDevice $aTDevice): self
    {
        if ($this->aTDevices->removeElement($aTDevice)) {
            // set the owning side to null (unless already changed)
            if ($aTDevice->getAtPlatform() === $this) {
                $aTDevice->setAtPlatform(null);
            }
        }

        return $this;
    }
}
