<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderStatus
 *
 * @ORM\Table(name="order_status")
 * @ORM\Entity
 */
class OrderStatus
{
    const WAITING_FOR_VALIDATION = 'En attente de validation';
    const IN_PREPARATION = 'En cours de préparation';
    const AWAITING_DELIVERY = 'En attente de livraison';
    const PAID = 'Payée';
    const CANCELED = 'Annulée';

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
     * @return OrderStatus
     */
    public function setName(string $name): OrderStatus
    {
        $this->name = $name;
        return $this;
    }
}
