<?php

namespace App\Finance\Bank;

use Itav\Component\Table;
use Silex\Application;

class StatementView
{
    /**
     * 
     * @param Statement[] $statements
     * @return string
     */
    public static function listView($statements, Application $app)
    {
        $table = new Table\Table();
        
        foreach ($statements as $statement){
            //TODO nie przeliczac za kazdym razem przy wyswietlaniu!!
            $summary = StatementLogic::calcSummary($statement->getRecords());
            $row = new Table\Tr();
            $id = $statement->getId();
            $actions = "<a href='/print/$id'>print</a>&nbsp"
                . "<a href='/list/record/$id'>records</a>&nbsp"
                . "<a href='/clone/$id'>clone</a>&nbsp"
                . "<a href='/del/$id'>del</a>";
            $row->setElements([
                new Table\Td($statement->getYear().'/'. $statement->getMonth()),
                new Table\Td($statement->getName()),
                new Table\Td($summary->getTotalPlusRecords()),
                new Table\Td($summary->getTotalPlus()),
                new Table\Td($summary->getTotalMinusRecords()),
                new Table\Td($summary->getTotalMinus()),
                new Table\Td($summary->getBalance()),                
                new Table\Td($actions),
            ]);
            $table->addElement($row);
        }
        $table = $app['serializer']->normalize($table);
        return $app['templating']->render($table['template'], array('data' => $table));
    }
    
}