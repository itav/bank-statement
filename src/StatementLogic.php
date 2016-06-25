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
            ->setBalace($totalPlus - $totalMinus);
        
        return $summary;
    }

}

class Summary
{
    private $totalPlusRecords = 0;
    private $totalMinusRecords = 0;
    private $totalPlus = 0.00;
    private $totalMinus = 0.00;
    private $balace = 0.00;
    
    public function getBalace()
    {
        return $this->balace;
    }

    public function setBalace($balace)
    {
        $this->balace = $balace;
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
        $this->totalPlus = $totalPlus;
        return $this;
    }

    public function setTotalMinus($totalMinus)
    {
        $this->totalMinus = $totalMinus;
        return $this;
    }


}