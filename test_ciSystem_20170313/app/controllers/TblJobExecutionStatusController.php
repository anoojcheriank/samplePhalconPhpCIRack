<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class TblJobExecutionStatusController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for tbl_job_execution_status
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'TblJobExecutionStatus', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "unit_job_execution_status";

        $tbl_job_execution_status = TblJobExecutionStatus::find($parameters);
        if (count($tbl_job_execution_status) == 0) {
            $this->flash->notice("The search did not find any tbl_job_execution_status");

            $this->dispatcher->forward([
                "controller" => "tbl_job_execution_status",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $tbl_job_execution_status,
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
     * Edits a tbl_job_execution_statu
     *
     * @param string $unit_job_execution_status
     */
    public function editAction($unit_job_execution_status)
    {
        if (!$this->request->isPost()) {

            $tbl_job_execution_statu = TblJobExecutionStatus::findFirstByunit_job_execution_status($unit_job_execution_status);
            if (!$tbl_job_execution_statu) {
                $this->flash->error("tbl_job_execution_statu was not found");

                $this->dispatcher->forward([
                    'controller' => "tbl_job_execution_status",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->unit_job_execution_status = $tbl_job_execution_statu->unit_job_execution_status;

            $this->tag->setDefault("unit_job_execution_status", $tbl_job_execution_statu->unit_job_execution_status);
            $this->tag->setDefault("uint_job_id", $tbl_job_execution_statu->uint_job_id);
            $this->tag->setDefault("uint_slot_index", $tbl_job_execution_statu->uint_slot_index);
            $this->tag->setDefault("datetime_test_start", $tbl_job_execution_statu->datetime_test_start);
            $this->tag->setDefault("datetime_test_finish", $tbl_job_execution_statu->datetime_test_finish);
            $this->tag->setDefault("uint_execution_status", $tbl_job_execution_statu->uint_execution_status);
            $this->tag->setDefault("text_msg", $tbl_job_execution_statu->text_msg);
            
        }
    }

    /**
     * Creates a new tbl_job_execution_statu
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "tbl_job_execution_status",
                'action' => 'index'
            ]);

            return;
        }

        $tbl_job_execution_statu = new TblJobExecutionStatus();
        $tbl_job_execution_statu->uint_job_id = $this->request->getPost("uint_job_id");
        $tbl_job_execution_statu->uint_slot_index = $this->request->getPost("uint_slot_index");
        $tbl_job_execution_statu->datetime_test_start = $this->request->getPost("datetime_test_start");
        $tbl_job_execution_statu->datetime_test_finish = $this->request->getPost("datetime_test_finish");
        $tbl_job_execution_statu->uint_execution_status = $this->request->getPost("uint_execution_status");
        $tbl_job_execution_statu->text_msg = $this->request->getPost("text_msg");
        

        if (!$tbl_job_execution_statu->save()) {
            foreach ($tbl_job_execution_statu->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_job_execution_status",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("tbl_job_execution_statu was created successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_job_execution_status",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a tbl_job_execution_statu edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "tbl_job_execution_status",
                'action' => 'index'
            ]);

            return;
        }

        $unit_job_execution_status = $this->request->getPost("unit_job_execution_status");
        $tbl_job_execution_statu = TblJobExecutionStatus::findFirstByunit_job_execution_status($unit_job_execution_status);

        if (!$tbl_job_execution_statu) {
            $this->flash->error("tbl_job_execution_statu does not exist " . $unit_job_execution_status);

            $this->dispatcher->forward([
                'controller' => "tbl_job_execution_status",
                'action' => 'index'
            ]);

            return;
        }

        $tbl_job_execution_statu->uint_job_id = $this->request->getPost("uint_job_id");
        $tbl_job_execution_statu->uint_slot_index = $this->request->getPost("uint_slot_index");
        $tbl_job_execution_statu->datetime_test_start = $this->request->getPost("datetime_test_start");
        $tbl_job_execution_statu->datetime_test_finish = $this->request->getPost("datetime_test_finish");
        $tbl_job_execution_statu->uint_execution_status = $this->request->getPost("uint_execution_status");
        $tbl_job_execution_statu->text_msg = $this->request->getPost("text_msg");
        

        if (!$tbl_job_execution_statu->save()) {

            foreach ($tbl_job_execution_statu->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_job_execution_status",
                'action' => 'edit',
                'params' => [$tbl_job_execution_statu->unit_job_execution_status]
            ]);

            return;
        }

        $this->flash->success("tbl_job_execution_statu was updated successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_job_execution_status",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a tbl_job_execution_statu
     *
     * @param string $unit_job_execution_status
     */
    public function deleteAction($unit_job_execution_status)
    {
        $tbl_job_execution_statu = TblJobExecutionStatus::findFirstByunit_job_execution_status($unit_job_execution_status);
        if (!$tbl_job_execution_statu) {
            $this->flash->error("tbl_job_execution_statu was not found");

            $this->dispatcher->forward([
                'controller' => "tbl_job_execution_status",
                'action' => 'index'
            ]);

            return;
        }

        if (!$tbl_job_execution_statu->delete()) {

            foreach ($tbl_job_execution_statu->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_job_execution_status",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("tbl_job_execution_statu was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_job_execution_status",
            'action' => "index"
        ]);
    }

}
