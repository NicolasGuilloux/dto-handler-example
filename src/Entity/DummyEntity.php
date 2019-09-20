<?php declare(strict_types=1);

namespace App\Entity;

use App\DataTransferObject\DummyDto;
use Chaplean\Bundle\DtoHandlerBundle\Utility\DtoUtility;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class DummyEntity
 *
 * @package   App\Entity
 * @author    Nicolas Guilloux <nicolas.guilloux@protonmail.com>
 * @copyright 2014 - 2019 RichCongress (https://www.richcongress.com)
 *
 * @ORM\Entity(repositoryClass="App\Repositories\DummyEntityRepository")
 */
class DummyEntity
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer", name="id", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false, name="name")
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true, name="age")
     */
    private $age;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false, name="is_beautiful", options={"default":0})
     */
    private $isBeautiful;

    /**
     * @var DummyEntity
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\DummyEntity", inversedBy="links")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $parent;

    /**
     * @var ArrayCollection|DummyEntity[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\DummyEntity", mappedBy="parent")
     */
    private $links;

    /**
     * DummyEntity constructor.
     */
    public function __construct()
    {
        $this->links = new ArrayCollection();
    }

    /**
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return integer|null
     */
    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * @return boolean
     */
    public function isBeautiful(): bool
    {
        return $this->isBeautiful === true;
    }

    /**
     * @return DummyEntity|null
     */
    public function getParent(): ?DummyEntity
    {
        return $this->parent;
    }

    /**
     * @return Collection|DummyEntity[]
     */
    public function getLinks(): ?Collection
    {
        return $this->links;
    }

    /**
     * @param DummyDto $dummyDto
     *
     * @return self
     */
    public static function createFromDto(DummyDto $dummyDto): self
    {
        $dummyEntity = new self();
        $dummyEntity->name = $dummyDto->name;
        $dummyEntity->age = $dummyDto->age;
        $dummyEntity->isBeautiful = $dummyDto->isBeautiful === true;

        if ($dummyDto->links !== null) {
            DtoUtility::updateEntityList($dummyEntity->links, $dummyDto->links);
        }

        return $dummyEntity;
    }
}