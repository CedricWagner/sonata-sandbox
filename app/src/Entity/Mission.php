<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MissionRepository;
use Umbrella\CoreBundle\Component\Search\Annotation\Searchable;
use Umbrella\CoreBundle\Component\Search\Annotation\SearchableField;
use Umbrella\CoreBundle\Model\IdTrait;
use Umbrella\CoreBundle\Model\SearchTrait;
use Umbrella\CoreBundle\Model\TimestampTrait;

/**
 * Class Mission.
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @Searchable
 */
class Mission
{
    use IdTrait;
    use TimestampTrait;
    use SearchTrait;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @SearchableField
     */
    public $title;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @SearchableField
     */
    public $city;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     */
    public $owner;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $intro;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getIntro(): ?string
    {
        return $this->intro;
    }

    public function setIntro(?string $intro): self
    {
        $this->intro = $intro;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }
}