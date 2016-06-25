<?php

namespace App\Finance\Bank;

class Statement
{
    private $id;
    private $name;
    private $year;
    private $month;
    private $number;
    private $displayNumber;
    private $numberPlanId;
    private $bankId;
    /**
     *
     * @var \DateTime
     */
    private $from;
    /**
     *
     * @var \DateTime
     */    
    private $to;
    /**
     *
     * @var Record[]
     */    
    private $records = [];
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

        public function getYear()
    {
        return $this->year;
    }

    public function getMonth()
    {
        return $this->month;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getDisplayNumber()
    {
        return $this->displayNumber;
    }

    public function getNumberPlanId()
    {
        return $this->numberPlanId;
    }

    public function getBankId()
    {
        return $this->bankId;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function getRecords()
    {
        return $this->records;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setYear($year)
    {
        $this->year = $year;
        return $this;
    }

    public function setMonth($month)
    {
        $this->month = $month;
        return $this;
    }

    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    public function setDisplayNumber($displayNumber)
    {
        $this->displayNumber = $displayNumber;
        return $this;
    }

    public function setNumberPlanId($numberPlanId)
    {
        $this->numberPlanId = $numberPlanId;
        return $this;
    }

    public function setBankId($bankId)
    {
        $this->bankId = $bankId;
        return $this;
    }

    public function setFrom(\DateTime $from)
    {
        $this->from = $from;
        return $this;
    }

    public function setTo(\DateTime $to)
    {
        $this->to = $to;
        return $this;
    }

    public function setRecords(array $records)
    {
        $this->records = $records;
        return $this;
    }


    
}

