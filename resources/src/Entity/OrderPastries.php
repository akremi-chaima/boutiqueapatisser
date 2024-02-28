<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderPastries
 *
 * @ORM\Table(name="order_pastries")
 * @ORM\Entity
 */
class OrderPastries
{
    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var Format
     *
     * @ORM\ManyToOne(targetEntity="Format")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="format_id", referencedColumnName="id")
     * })
     */
    private $format;

    /**
     * @var Order
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Order")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     * })
     */
    private $order;

    /**
     * @var Pastry
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Pastry")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pastry_id", referencedColumnName="id")
     * })
     */
    private $pastry;

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return OrderPastries
     */
    public function setQuantity(int $quantity): OrderPastries
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return Format
     */
    public function getFormat(): Format
    {
        return $this->format;
    }

    /**
     * @param Format $format
     * @return OrderPastries
     */
    public function setFormat(Format $format): OrderPastries
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     * @return OrderPastries
     */
    public function setOrder(Order $order): OrderPastries
    {
        $this->order = $order;
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
     * @return OrderPastries
     */
    public function setPastry(Pastry $pastry): OrderPastries
    {
        $this->pastry = $pastry;
        return $this;
    }
}
