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
        $parameters["order"] = "uint_internalQ_mapping_index";

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
     * @param string $uint_internalQ_mapping_index
     */
    public function editAction($uint_internalQ_mapping_index)
    {
        if (!$this->request->isPost()) {

            $tbl_internal_queue = TblInternalQueue::findFirstByuint_internalQ_mapping_index($uint_internalQ_mapping_index);
            if (!$tbl_internal_queue) {
                $this->flash->error("tbl_internal_queue was not found");

                $this->dispatcher->forward([
                    'controller' => "tbl_internal_queue",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->uint_internalQ_mapping_index = $tbl_internal_queue->uint_internalQ_mapping_index;

            $this->tag->setDefault("uint_internalQ_mapping_index", $tbl_internal_queue->uint_internalQ_mapping_index);
            $this->tag->setDefault("uint_job_id", $tbl_internal_queue->uint_job_id);
            $this->tag->setDefault("uint_seq_order", $tbl_internal_queue->uint_seq_order);
            $this->tag->setDefault("uint_test_index", $tbl_internal_queue->uint_test_index);
            
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

        $uint_internalQ_mapping_index = $this->request->getPost("uint_internalQ_mapping_index");
        $tbl_internal_queue = TblInternalQueue::findFirstByuint_internalQ_mapping_index($uint_internalQ_mapping_index);

        if (!$tbl_internal_queue) {
            $this->flash->error("tbl_internal_queue does not exist " . $uint_internalQ_mapping_index);

            $this->dispatcher->forward([
                'controller' => "tbl_internal_queue",
                'action' => 'index'
            ]);

            return;
        }

        $tbl_internal_queue->uint_job_id = $this->request->getPost("uint_job_id");
        $tbl_internal_queue->uint_seq_order = $this->request->getPost("uint_seq_order");
        $tbl_internal_queue->uint_test_index = $this->request->getPost("uint_test_index");
        

        if (!$tbl_internal_queue->save()) {

            foreach ($tbl_internal_queue->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_internal_queue",
                'action' => 'edit',
                'params' => [$tbl_internal_queue->uint_internalQ_mapping_index]
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
     * @param string $uint_internalQ_mapping_index
     */
    public function deleteAction($uint_internalQ_mapping_index)
    {
        $tbl_internal_queue = TblInternalQueue::findFirstByuint_internalQ_mapping_index($uint_internalQ_mapping_index);
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
