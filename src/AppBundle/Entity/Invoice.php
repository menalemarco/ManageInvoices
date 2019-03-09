<?php
/**
 * Created by PhpStorm.
 * User: marcom
 * Date: 04/03/19
 * Time: 17.13
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity
 * @ORM\Table(name="invoice")
 */
class Invoice
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\Column(type="date", name="creation_date") */
    private $creationDate;

    /**
     * @ORM\Column(type="string",name="number")
     */
    private $number;

    /**
     * @ORM\Column(type="string", name="id_client")
     */
    private $idClient;


    /**
     * One invoice as many data row. This is the inverse side.
     * @OneToMany(targetEntity="InvoiceData", mappedBy="invoice")
     */
    private $invoiceData;


    /** Construct */
    public function __construct() {
        $this->invoiceData = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param mixed $creationDate
     */
    public function setCreationDate(\DateTime $creationDate)
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getIdClient()
    {
        return $this->idClient;
    }

    /**
     * @param mixed $idClient
     */
    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;
    }

    /**
     * @return mixed
     */
    public function getInvoiceData()
    {
        return $this->invoiceData;
    }

    /**
     * @param mixed $invoiceData
     */
    public function setInvoiceData($invoiceData): void
    {
        $this->invoiceData = $invoiceData;
    }





}