<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Picture
 *
 * @ORM\Table(name="picture")
 * @ORM\Entity
 */
class Picture
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var Pastry
     *
     * @ORM\ManyToOne(targetEntity="Pastry")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pastry_id", referencedColumnName="id")
     * })
     */
    private $pastry;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Picture
     */
    public function setName(string $name): Picture
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Pastry
     */
    public function getPastry(): Pastry
    {
        return $this->pastry;
    }

    /**
     * @param Pastry $pastry
     * @return Picture
     */
    public function setPastry(Pastry $pastry): Picture
    {
        $this->pastry = $pastry;
        return $this;
    }
}
