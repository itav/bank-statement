<?php

namespace App\Finance\Bank;

use Itav\Component\Table;
use Silex\Application;

class RecordView
{
    /**
     * 
     * @param Record[] $records
     * @return string
     */
    public static function listView($records, Application $app)
    {
        $table = new Table\Table();
        $summary = StatementLogic::calcSummary($records);
        foreach ($records as $record){
            $row = new Table\Tr();
            $row->setElements([
                new Table\Td($record->getDate()->format('Y-m-d')),
                new Table\Td($record->getSender()),
                new Table\Td($record->getReceiver()),
                new Table\Td($record->getDesctiption()),
                new Table\Td($record->getAmount()),
            ]);
            $table->addElement($row);
        }
        $row = new Table\Tr();
        $row->setElements([
                new Table\Td('plus rec: '.$summary->getTotalPlusRecords()),
                new Table\Td('total plus: '.$summary->getTotalPlus()),
                new Table\Td('minus rec: '.$summary->getTotalMinusRecords()),
                new Table\Td('total minus: '.$summary->getTotalMinus()),
                new Table\Td('balance: '. $summary->getBalace()),
        ]);
        $table->addElement($row);        
        $table = $app['serializer']->normalize($table);
        return $app['templating']->render($table['template'], array('data' => $table));
    }
    
}