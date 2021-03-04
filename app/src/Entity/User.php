<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Umbrella\AdminBundle\Entity\BaseUser;
use Umbrella\CoreBundle\Component\Search\Annotation\Searchable;
use Umbrella\CoreBundle\Entity\UmbrellaFile;

/**
 * Class User
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @Searchable
 * @UniqueEntity("email")
 */
class User extends BaseUser
{
    /**
     * @var UmbrellaFile
     * @ORM\ManyToOne(targetEntity="Umbrella\CoreBundle\Entity\UmbrellaFile", cascade={"ALL"})
     * @ORM\JoinColumn(name="avatar_id", referencedColumnName="id", onDelete="SET NULL")
     */
    public $avatar;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="UserGroup", inversedBy="users")
     * @ORM\JoinTable(name="user_group_assoc")
     */
    public $groups;

    /**
     * @ORM\OneToMany(targetEntity=Mission::class, mappedBy="owner")
     */
    private $missions;

    public function __construct()
    {
        parent::__construct();
        $this->missions = new ArrayCollection();
    }

    /**
     * @return Collection|Mission[]
     */
    public function getMissions(): Collection
    {
        return $this->missions;
    }

    public function addMission(Mission $mission): self
    {
        if (!$this->missions->contains($mission)) {
            $this->missions[] = $mission;
            $mission->setOwner($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): self
    {
        if ($this->missions->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getOwner() === $this) {
                $mission->setOwner(null);
            }
        }

        return $this;
    }
}
