<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class TblMonitoringTaskSeqOfTestController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for tbl_monitoring_task_seq_of_test
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'TblMonitoringTaskSeqOfTest', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "uint_monitror_test_mapping_index";

        $tbl_monitoring_task_seq_of_test = TblMonitoringTaskSeqOfTest::find($parameters);
        if (count($tbl_monitoring_task_seq_of_test) == 0) {
            $this->flash->notice("The search did not find any tbl_monitoring_task_seq_of_test");

            $this->dispatcher->forward([
                "controller" => "tbl_monitoring_task_seq_of_test",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $tbl_monitoring_task_seq_of_test,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a tbl_monitoring_task_seq_of_test
     *
     * @param string $uint_monitror_test_mapping_index
     */
    public function editAction($uint_monitror_test_mapping_index)
    {
        if (!$this->request->isPost()) {

            $tbl_monitoring_task_seq_of_test = TblMonitoringTaskSeqOfTest::findFirstByuint_monitror_test_mapping_index($uint_monitror_test_mapping_index);
            if (!$tbl_monitoring_task_seq_of_test) {
                $this->flash->error("tbl_monitoring_task_seq_of_test was not found");

                $this->dispatcher->forward([
                    'controller' => "tbl_monitoring_task_seq_of_test",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->uint_monitror_test_mapping_index = $tbl_monitoring_task_seq_of_test->uint_monitror_test_mapping_index;

            $this->tag->setDefault("uint_monitror_test_mapping_index", $tbl_monitoring_task_seq_of_test->uint_monitror_test_mapping_index);
            $this->tag->setDefault("uint_internalQ_mapping_index", $tbl_monitoring_task_seq_of_test->uint_internalQ_mapping_index);
            $this->tag->setDefault("uint_monitor_task_seq_order", $tbl_monitoring_task_seq_of_test->uint_monitor_task_seq_order);
            $this->tag->setDefault("uint_monitor_test_index", $tbl_monitoring_task_seq_of_test->uint_monitor_test_index);
            $this->tag->setDefault("time_monitor_test_wait", $tbl_monitoring_task_seq_of_test->time_monitor_test_wait);
            $this->tag->setDefault("datetime_monitor_test_start", $tbl_monitoring_task_seq_of_test->datetime_monitor_test_start);
            $this->tag->setDefault("datetime_monitor_test_finish", $tbl_monitoring_task_seq_of_test->datetime_monitor_test_finish);
            $this->tag->setDefault("uint_monitor_test_status", $tbl_monitoring_task_seq_of_test->uint_monitor_test_status);
            $this->tag->setDefault("text_error_description", $tbl_monitoring_task_seq_of_test->text_error_description);
            
        }
    }

    /**
     * Creates a new tbl_monitoring_task_seq_of_test
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "tbl_monitoring_task_seq_of_test",
                'action' => 'index'
            ]);

            return;
        }

        $tbl_monitoring_task_seq_of_test = new TblMonitoringTaskSeqOfTest();
        $tbl_monitoring_task_seq_of_test->uint_internalQ_mapping_index = $this->request->getPost("uint_internalQ_mapping_index");
        $tbl_monitoring_task_seq_of_test->uint_monitor_task_seq_order = $this->request->getPost("uint_monitor_task_seq_order");
        $tbl_monitoring_task_seq_of_test->uint_monitor_test_index = $this->request->getPost("uint_monitor_test_index");
        $tbl_monitoring_task_seq_of_test->time_monitor_test_wait = $this->request->getPost("time_monitor_test_wait");
        $tbl_monitoring_task_seq_of_test->datetime_monitor_test_start = $this->request->getPost("datetime_monitor_test_start");
        $tbl_monitoring_task_seq_of_test->datetime_monitor_test_finish = $this->request->getPost("datetime_monitor_test_finish");
        $tbl_monitoring_task_seq_of_test->uint_monitor_test_status = $this->request->getPost("uint_monitor_test_status");
        $tbl_monitoring_task_seq_of_test->text_error_description = $this->request->getPost("text_error_description");
        

        if (!$tbl_monitoring_task_seq_of_test->save()) {
            foreach ($tbl_monitoring_task_seq_of_test->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_monitoring_task_seq_of_test",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("tbl_monitoring_task_seq_of_test was created successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_monitoring_task_seq_of_test",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a tbl_monitoring_task_seq_of_test edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "tbl_monitoring_task_seq_of_test",
                'action' => 'index'
            ]);

            return;
        }

        $uint_monitror_test_mapping_index = $this->request->getPost("uint_monitror_test_mapping_index");
        $tbl_monitoring_task_seq_of_test = TblMonitoringTaskSeqOfTest::findFirstByuint_monitror_test_mapping_index($uint_monitror_test_mapping_index);

        if (!$tbl_monitoring_task_seq_of_test) {
            $this->flash->error("tbl_monitoring_task_seq_of_test does not exist " . $uint_monitror_test_mapping_index);

            $this->dispatcher->forward([
                'controller' => "tbl_monitoring_task_seq_of_test",
                'action' => 'index'
            ]);

            return;
        }

        $tbl_monitoring_task_seq_of_test->uint_internalQ_mapping_index = $this->request->getPost("uint_internalQ_mapping_index");
        $tbl_monitoring_task_seq_of_test->uint_monitor_task_seq_order = $this->request->getPost("uint_monitor_task_seq_order");
        $tbl_monitoring_task_seq_of_test->uint_monitor_test_index = $this->request->getPost("uint_monitor_test_index");
        $tbl_monitoring_task_seq_of_test->time_monitor_test_wait = $this->request->getPost("time_monitor_test_wait");
        $tbl_monitoring_task_seq_of_test->datetime_monitor_test_start = $this->request->getPost("datetime_monitor_test_start");
        $tbl_monitoring_task_seq_of_test->datetime_monitor_test_finish = $this->request->getPost("datetime_monitor_test_finish");
        $tbl_monitoring_task_seq_of_test->uint_monitor_test_status = $this->request->getPost("uint_monitor_test_status");
        $tbl_monitoring_task_seq_of_test->text_error_description = $this->request->getPost("text_error_description");
        

        if (!$tbl_monitoring_task_seq_of_test->save()) {

            foreach ($tbl_monitoring_task_seq_of_test->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_monitoring_task_seq_of_test",
                'action' => 'edit',
                'params' => [$tbl_monitoring_task_seq_of_test->uint_monitror_test_mapping_index]
            ]);

            return;
        }

        $this->flash->success("tbl_monitoring_task_seq_of_test was updated successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_monitoring_task_seq_of_test",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a tbl_monitoring_task_seq_of_test
     *
     * @param string $uint_monitror_test_mapping_index
     */
    public function deleteAction($uint_monitror_test_mapping_index)
    {
        $tbl_monitoring_task_seq_of_test = TblMonitoringTaskSeqOfTest::findFirstByuint_monitror_test_mapping_index($uint_monitror_test_mapping_index);
        if (!$tbl_monitoring_task_seq_of_test) {
            $this->flash->error("tbl_monitoring_task_seq_of_test was not found");

            $this->dispatcher->forward([
                'controller' => "tbl_monitoring_task_seq_of_test",
                'action' => 'index'
            ]);

            return;
        }

        if (!$tbl_monitoring_task_seq_of_test->delete()) {

            foreach ($tbl_monitoring_task_seq_of_test->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_monitoring_task_seq_of_test",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("tbl_monitoring_task_seq_of_test was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_monitoring_task_seq_of_test",
            'action' => "index"
        ]);
    }

}
