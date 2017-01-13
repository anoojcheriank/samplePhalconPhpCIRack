<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class TblInternalQueueController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for tbl_internal_queue
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'TblInternalQueue', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "uint_job_mapping_index";

        $tbl_internal_queue = TblInternalQueue::find($parameters);
        if (count($tbl_internal_queue) == 0) {
            $this->flash->notice("The search did not find any tbl_internal_queue");

            $this->dispatcher->forward([
                "controller" => "tbl_internal_queue",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $tbl_internal_queue,
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
     * Edits a tbl_internal_queue
     *
     * @param string $uint_job_mapping_index
     */
    public function editAction($uint_job_mapping_index)
    {
        if (!$this->request->isPost()) {

            $tbl_internal_queue = TblInternalQueue::findFirstByuint_job_mapping_index($uint_job_mapping_index);
            if (!$tbl_internal_queue) {
                $this->flash->error("tbl_internal_queue was not found");

                $this->dispatcher->forward([
                    'controller' => "tbl_internal_queue",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->uint_job_mapping_index = $tbl_internal_queue->uint_job_mapping_index;

            $this->tag->setDefault("uint_job_mapping_index", $tbl_internal_queue->uint_job_mapping_index);
            $this->tag->setDefault("uint_job_id", $tbl_internal_queue->uint_job_id);
            $this->tag->setDefault("uint_seq_order", $tbl_internal_queue->uint_seq_order);
            $this->tag->setDefault("uint_test_index", $tbl_internal_queue->uint_test_index);
            $this->tag->setDefault("uint_slot_index", $tbl_internal_queue->uint_slot_index);
            $this->tag->setDefault("datetime_test_start", $tbl_internal_queue->datetime_test_start);
            $this->tag->setDefault("datetime_test_finish", $tbl_internal_queue->datetime_test_finish);
            $this->tag->setDefault("uint_test_status", $tbl_internal_queue->uint_test_status);
            $this->tag->setDefault("uint_test_check_job_type", $tbl_internal_queue->uint_test_check_job_type);
            $this->tag->setDefault("time_test_wait", $tbl_internal_queue->time_test_wait);
            
        }
    }

    /**
     * Creates a new tbl_internal_queue
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "tbl_internal_queue",
                'action' => 'index'
            ]);

            return;
        }

        $tbl_internal_queue = new TblInternalQueue();
        $tbl_internal_queue->uint_job_id = $this->request->getPost("uint_job_id");
        $tbl_internal_queue->uint_seq_order = $this->request->getPost("uint_seq_order");
        $tbl_internal_queue->uint_test_index = $this->request->getPost("uint_test_index");
        $tbl_internal_queue->uint_slot_index = $this->request->getPost("uint_slot_index");
        $tbl_internal_queue->datetime_test_start = $this->request->getPost("datetime_test_start");
        $tbl_internal_queue->datetime_test_finish = $this->request->getPost("datetime_test_finish");
        $tbl_internal_queue->uint_test_status = $this->request->getPost("uint_test_status");
        $tbl_internal_queue->uint_test_check_job_type = $this->request->getPost("uint_test_check_job_type");
        $tbl_internal_queue->time_test_wait = $this->request->getPost("time_test_wait");
        

        if (!$tbl_internal_queue->save()) {
            foreach ($tbl_internal_queue->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_internal_queue",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("tbl_internal_queue was created successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_internal_queue",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a tbl_internal_queue edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "tbl_internal_queue",
                'action' => 'index'
            ]);

            return;
        }

        $uint_job_mapping_index = $this->request->getPost("uint_job_mapping_index");
        $tbl_internal_queue = TblInternalQueue::findFirstByuint_job_mapping_index($uint_job_mapping_index);

        if (!$tbl_internal_queue) {
            $this->flash->error("tbl_internal_queue does not exist " . $uint_job_mapping_index);

            $this->dispatcher->forward([
                'controller' => "tbl_internal_queue",
                'action' => 'index'
            ]);

            return;
        }

        $tbl_internal_queue->uint_job_id = $this->request->getPost("uint_job_id");
        $tbl_internal_queue->uint_seq_order = $this->request->getPost("uint_seq_order");
        $tbl_internal_queue->uint_test_index = $this->request->getPost("uint_test_index");
        $tbl_internal_queue->uint_slot_index = $this->request->getPost("uint_slot_index");
        $tbl_internal_queue->datetime_test_start = $this->request->getPost("datetime_test_start");
        $tbl_internal_queue->datetime_test_finish = $this->request->getPost("datetime_test_finish");
        $tbl_internal_queue->uint_test_status = $this->request->getPost("uint_test_status");
        $tbl_internal_queue->uint_test_check_job_type = $this->request->getPost("uint_test_check_job_type");
        $tbl_internal_queue->time_test_wait = $this->request->getPost("time_test_wait");
        

        if (!$tbl_internal_queue->save()) {

            foreach ($tbl_internal_queue->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_internal_queue",
                'action' => 'edit',
                'params' => [$tbl_internal_queue->uint_job_mapping_index]
            ]);

            return;
        }

        $this->flash->success("tbl_internal_queue was updated successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_internal_queue",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a tbl_internal_queue
     *
     * @param string $uint_job_mapping_index
     */
    public function deleteAction($uint_job_mapping_index)
    {
        $tbl_internal_queue = TblInternalQueue::findFirstByuint_job_mapping_index($uint_job_mapping_index);
        if (!$tbl_internal_queue) {
            $this->flash->error("tbl_internal_queue was not found");

            $this->dispatcher->forward([
                'controller' => "tbl_internal_queue",
                'action' => 'index'
            ]);

            return;
        }

        if (!$tbl_internal_queue->delete()) {

            foreach ($tbl_internal_queue->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_internal_queue",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("tbl_internal_queue was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_internal_queue",
            'action' => "index"
        ]);
    }

}
