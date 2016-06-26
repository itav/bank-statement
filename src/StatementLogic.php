<?php

namespace App\Finance\Bank;


class StatementLogic
{
    /**
     * 
     * @param Record[] $records
     * @return Summary
     */
    public static function calcSummary($records)
    {
        $summary = new Summary();
        $countPlus = 0;
        $countMinus = 0;
        $totalPlus = 0.00;
        $totalMinus = 0.00;
        foreach ($records as $record){
            $type = $record->getType();
            switch ($type){
                case Record::TYPE_PLUS:
                    $countPlus++;
                    $totalPlus += $record->getAmount();
                    break;
                case Record::TYPE_MINUS:
                    $countMinus++;
                    $totalMinus += $record->getAmount();
                    break;
            }
        }
        $summary
            ->setTotalPlusRecords($countPlus)
            ->setTotalPlus($totalPlus)
            ->setTotalMinusRecords($countMinus)
            ->setTotalMinus($totalMinus)
            ->setBalance($totalPlus - $totalMinus);
        
        return $summary;
    }

}

class Summary
{
    private $totalPlusRecords = 0;
    private $totalMinusRecords = 0;
    private $totalPlus = 0.00;
    private $totalMinus = 0.00;
    private $balance = 0.00;
    
    public function getBalance()
    {
        return $this->balance;
    }

    public function setBalance($balace)
    {
        $this->balance = round((float)$balace,2);
        return $this;
    }

        
    public function getTotalPlusRecords()
    {
        return $this->totalPlusRecords;
    }

    public function getTotalMinusRecords()
    {
        return $this->totalMinusRecords;
    }

    public function getTotalPlus()
    {
        return $this->totalPlus;
    }

    public function getTotalMinus()
    {
        return $this->totalMinus;
    }

    public function setTotalPlusRecords($totalPlusRecords)
    {
        $this->totalPlusRecords = $totalPlusRecords;
        return $this;
    }

    public function setTotalMinusRecords($totalMinusRecords)
    {
        $this->totalMinusRecords = $totalMinusRecords;
        return $this;
    }

    public function setTotalPlus($totalPlus)
    {
        $this->totalPlus = round((float)$totalPlus,2);
        return $this;
    }

    public function setTotalMinus($totalMinus)
    {
        $this->totalMinus = round((float)$totalMinus,2);
        return $this;
    }


}