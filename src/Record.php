<?php

namespace App\Finance\Bank;

class Record
{
    const TYPE_PLUS = 1;
    const TYPE_MINUS = 2;
    
    private $id;
    private $number;
    private $displayNumber;
    private $numerPlanId;
    private $type;
    /**
     *
     * @var \DateTime
     */
    private $date;
    private $amount; 
    private $description;
    private $interesantId;
    
    private $sender;
    private $receiver;
    private $senderBankAccount;
    private $receiverBankAccount;
    private $md5CheckSum;
    
    public function getId()
    {
        return $this->id;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getDisplayNumber()
    {
        return $this->displayNumber;
    }

    public function getNumerPlanId()
    {
        return $this->numerPlanId;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getAmount()
    {
        return round((float)$this->amount,2);
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getInteresantId()
    {
        return $this->interesantId;
    }

    public function getSenderBankAccount()
    {
        return $this->senderBankAccount;
    }

    public function getReceiverBankAccount()
    {
        return $this->receiverBankAccount;
    }

    public function getMd5CheckSum()
    {
        return $this->md5CheckSum;
    }

    public function setId($id)
    {
        $this->id = $id;
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

    public function setNumerPlanId($numerPlanId)
    {
        $this->numerPlanId = $numerPlanId;
        return $this;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function setDate(\DateTime $date)
    {
        $this->date = $date;
        return $this;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function setDescription($desctiption)
    {
        $this->description = $desctiption;
        return $this;
    }

    public function setInteresantId($interesantId)
    {
        $this->interesantId = $interesantId;
        return $this;
    }

    public function setSenderBankAccount($senderBankAccount)
    {
        $this->senderBankAccount = $senderBankAccount;
        return $this;
    }

    public function setReceiverBankAccount($receiverBankAccount)
    {
        $this->receiverBankAccount = $receiverBankAccount;
        return $this;
    }

    public function setMd5CheckSum($md5CheckSum)
    {
        $this->md5CheckSum = $md5CheckSum;
        return $this;
    }


    public function getSender()
    {
        return $this->sender;
    }

    public function getReceiver()
    {
        return $this->receiver;
    }

    public function setSender($sender)
    {
        $this->sender = $sender;
        return $this;
    }

    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
        return $this;
    }


}