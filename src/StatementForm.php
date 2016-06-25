<?php

namespace App\Finance\Bank;

use Itav\Component\Form;

class StatementForm
{
    static public function importForm()
    {        
        $file = new Form\Input();
        $file
            ->setLabel('File:')
            ->setName('filename')
            ->setType(Form\Input::TYPE_FILE);
        
        $sourceCa = new Form\Input();
        $sourceCa
            ->setLabel('CA')
            ->setName('source')
            ->setType(Form\Input::TYPE_RADIO)
            ->setValue(ImportParser::SOURCE_CA)
            ->setChecked(true);
        
        $sourceIdea = new Form\Input();
        $sourceIdea
            ->setLabel('Idea')
            ->setName('source')
            ->setType(Form\Input::TYPE_RADIO)
            ->setValue(ImportParser::SOURCE_IDEA);        
        
        $submit = new Form\Button();
        $submit
            ->setLabel('Load File')
            ->setName('submit[file]')
            ->setType(Form\Button::TYPE_SUBMIT);
        
        
        $form = new Form\Form();
        $form
            ->setEnctype(Form\Form::ENCTYPE_FILE)
            ->setMethod(Form\Form::METHOD_POST);
        $form->addElement($file);
        $form->addElement($sourceCa);
        $form->addElement($sourceIdea);
        $form->addElement($submit);
        
        
        return $form;
    }
    
    /**
     * 
     * @param Statement $report
     */
    static public function addReportForm($report)
    {
        $name = new Form\Input();
        $name
            ->setLabel('Nazwa:')
            ->setName('report[name]')
            ->setValue($report->getName());

        
        $submit = new Form\Button();
        $submit
            ->setLabel('Save')
            ->setName('submit[add]')
            ->setType(Form\Button::TYPE_SUBMIT);
        
        $form = new Form\Form();
        $form
            ->setMethod(Form\Form::METHOD_POST)
            ->addElement($name)
            ->addElement($submit);
        
        return $form;
        
    }
    
    /**
     * @return Form\Input
     */
    public static function saveImportSubmit()
    {
        $submit = new Form\Button();
        $submit
            ->setLabel('Save Report')
            ->setName('submit[save_report]')
            ->setType(Form\Button::TYPE_SUBMIT);
        
        return $submit;        
    }
}