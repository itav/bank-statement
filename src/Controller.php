<?php

namespace App\Finance\Bank;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Controller
{

    public function importAction(Application $app, Request $request)
    {
        $submit = $request->get('submit');
        $source = $request->get('source');
        $reportData = $request->get('report');
        $report = new Statement();
        $form = StatementForm::importForm();
        if (isset($submit['file'])) {
            $filename = $_FILES['filename']['tmp_name'];
            $records = ImportParser::getRecordsFromFile($filename, $source);
            $report->setRecords($records);
            if(count($records) > 0){
                $repo = new StatementRepo($app);
                $repo->saveInCache($report);
                $addReportForm = StatementForm::addReportForm($report);
                $addReportForm->removeSubmits();
                $form->addElement($addReportForm);
                $form->addElement(StatementForm::saveImportSubmit());
            }
        }
        if(isset($submit['save_report'])){
            $repo = new StatementRepo($app);
            $report = $repo->loadFromCache();
            if (count($reportData) > 0) {
                $app['serializer']->unserialize($reportData, Statement::class, $report);
            }
            $ret = $repo->save($report);
        }
        $form = $app['serializer']->normalize($form);
        return $app['twig']->render('import.twig', [
                'form' => $form,
                'table' => RecordView::listView($report, $app)
        ]);
    }

    public function listReportAction(Application $app, Request $request)
    {
        $repo = new StatementRepo($app);
        $reports = $repo->findAll();
        return $app['twig']->render('list.twig', [
            'table' => StatementView::listView($reports, $app),
            ]);
    }
    
    public function listRecordAction(Application $app, Request $request, $id)
    {
        $repo = new StatementRepo($app);
        $report = $repo->find($id);
        return $app['twig']->render('list.twig', [
            'table' => RecordView::listView($report, $app),
            ]);
    }

    public function deleteReportAction(Application $app, $id)
    {
        $repo = new StatementRepo($app);
        $repo->delete($id);
        return $app->redirect("/list");
    }
    
    public function deleteRecordAction(Application $app, $id, $idr)
    {
        $repo = new StatementRepo($app);
        $report = $repo->find($id);
        foreach($report->getRecords() as $k => $record){
            if($idr == $record->getId()){
                $report->deleteRecord($k);
                $repo->save($report);
                break;
            }
        }
        return $app->redirect("/list/record/$id");
    }    
    
    public function cloneReportAction(Application $app, $id)
    {
        $repo = new StatementRepo($app);
        $original = $repo->find($id);
        $report = clone($original);
        $report->setName('copy_'.$original->getName());
        $report->setId(null);
        $repo->save($report);
        return $app->redirect("/list");
    }     
}
