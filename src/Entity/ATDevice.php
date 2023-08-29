<?php
/**
 * @author Yenier Jimenez <yjmorales86@gmail.com>
 */

namespace App\Entity;

use App\Repository\ATDeviceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ATDeviceRepository::class)
 */
class ATDevice
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
     * @ORM\ManyToOne(targetEntity=ATDeviceType::class, inversedBy="aTDevices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $atDeviceType;

    /**
     * @ORM\ManyToOne(targetEntity=ATPlatform::class, inversedBy="aTDevices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $atPlatform;

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

    public function getAtDeviceType(): ?ATDeviceType
    {
        return $this->atDeviceType;
    }

    public function setAtDeviceType(?ATDeviceType $atDeviceType): self
    {
        $this->atDeviceType = $atDeviceType;

        return $this;
    }

    public function getAtPlatform(): ?ATPlatform
    {
        return $this->atPlatform;
    }

    public function setAtPlatform(?ATPlatform $atPlatform): self
    {
        $this->atPlatform = $atPlatform;

        return $this;
    }
}
