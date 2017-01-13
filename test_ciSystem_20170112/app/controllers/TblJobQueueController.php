<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class TblJobQueueController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for tbl_job_queue
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'TblJobQueue', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "uint_job_id";

        $tbl_job_queue = TblJobQueue::find($parameters);
        if (count($tbl_job_queue) == 0) {
            $this->flash->notice("The search did not find any tbl_job_queue");

            $this->dispatcher->forward([
                "controller" => "tbl_job_queue",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $tbl_job_queue,
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
     * Edits a tbl_job_queue
     *
     * @param string $uint_job_id
     */
    public function editAction($uint_job_id)
    {
        if (!$this->request->isPost()) {

            $tbl_job_queue = TblJobQueue::findFirstByuint_job_id($uint_job_id);
            if (!$tbl_job_queue) {
                $this->flash->error("tbl_job_queue was not found");

                $this->dispatcher->forward([
                    'controller' => "tbl_job_queue",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->uint_job_id = $tbl_job_queue->uint_job_id;

            $this->tag->setDefault("uint_job_id", $tbl_job_queue->uint_job_id);
            $this->tag->setDefault("uint_priority", $tbl_job_queue->uint_priority);
            $this->tag->setDefault("uint_number_of_boxes", $tbl_job_queue->uint_number_of_boxes);
            $this->tag->setDefault("uint_build_index", $tbl_job_queue->uint_build_index);
            $this->tag->setDefault("uint_job_status", $tbl_job_queue->uint_job_status);
            
        }
    }

    /**
     * Creates a new tbl_job_queue
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "tbl_job_queue",
                'action' => 'index'
            ]);

            return;
        }

        $tbl_job_queue = new TblJobQueue();
        $tbl_job_queue->uint_priority = $this->request->getPost("uint_priority");
        $tbl_job_queue->uint_number_of_boxes = $this->request->getPost("uint_number_of_boxes");
        $tbl_job_queue->uint_build_index = $this->request->getPost("uint_build_index");
        $tbl_job_queue->uint_job_status = $this->request->getPost("uint_job_status");
        

        if (!$tbl_job_queue->save()) {
            foreach ($tbl_job_queue->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_job_queue",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("tbl_job_queue was created successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_job_queue",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a tbl_job_queue edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "tbl_job_queue",
                'action' => 'index'
            ]);

            return;
        }

        $uint_job_id = $this->request->getPost("uint_job_id");
        $tbl_job_queue = TblJobQueue::findFirstByuint_job_id($uint_job_id);

        if (!$tbl_job_queue) {
            $this->flash->error("tbl_job_queue does not exist " . $uint_job_id);

            $this->dispatcher->forward([
                'controller' => "tbl_job_queue",
                'action' => 'index'
            ]);

            return;
        }

        $tbl_job_queue->uint_priority = $this->request->getPost("uint_priority");
        $tbl_job_queue->uint_number_of_boxes = $this->request->getPost("uint_number_of_boxes");
        $tbl_job_queue->uint_build_index = $this->request->getPost("uint_build_index");
        $tbl_job_queue->uint_job_status = $this->request->getPost("uint_job_status");
        

        if (!$tbl_job_queue->save()) {

            foreach ($tbl_job_queue->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_job_queue",
                'action' => 'edit',
                'params' => [$tbl_job_queue->uint_job_id]
            ]);

            return;
        }

        $this->flash->success("tbl_job_queue was updated successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_job_queue",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a tbl_job_queue
     *
     * @param string $uint_job_id
     */
    public function deleteAction($uint_job_id)
    {
        $tbl_job_queue = TblJobQueue::findFirstByuint_job_id($uint_job_id);
        if (!$tbl_job_queue) {
            $this->flash->error("tbl_job_queue was not found");

            $this->dispatcher->forward([
                'controller' => "tbl_job_queue",
                'action' => 'index'
            ]);

            return;
        }

        if (!$tbl_job_queue->delete()) {

            foreach ($tbl_job_queue->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_job_queue",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("tbl_job_queue was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_job_queue",
            'action' => "index"
        ]);
    }

}
