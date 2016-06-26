<?php

namespace App\Finance\Bank;

use Itav\Component\Table;
use Silex\Application;

class RecordView
{
    /**
     * 
     * @param Statement $report
     * @return string
     */
    public static function listView($report, Application $app)
    {
        $table = new Table\Table();
        $summary = StatementLogic::calcSummary($report->getRecords());
        $id = $report->getId();
        foreach ($report->getRecords() as $record){
            $idr = $record->getId();
            $actions = "<a href='/del/record/$id/$idr'>del</a>&nbsp";        
            $row = new Table\Tr();
            $row->setElements([
                new Table\Td($record->getDate()->format('Y-m-d')),
                new Table\Td($record->getSender()),
                new Table\Td($record->getReceiver()),
                new Table\Td($record->getDescription()),
                new Table\Td($record->getType() == Record::TYPE_PLUS ? 'PLUS' : 'MINUS'),
                new Table\Td($record->getAmount()),
                new Table\Td($actions),
            ]);
            $table->addElement($row);
        }
        $row = new Table\Tr();
        $row->setElements([
                (new Table\Td('plus rec: '.$summary->getTotalPlusRecords()))->setRowspan(3),
                new Table\Td('total plus: '.$summary->getTotalPlus()),
                new Table\Td('minus rec: '.$summary->getTotalMinusRecords()),
                new Table\Td('total minus: '.$summary->getTotalMinus()),
                new Table\Td('balance: '. $summary->getBalance()),
        ]);
        $table->addElement($row);        
        $table = $app['serializer']->normalize($table);
        return $app['templating']->render($table['template'], array('data' => $table));
    }
    
}