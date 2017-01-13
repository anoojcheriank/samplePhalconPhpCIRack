<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class TblBoxDetailsController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for tbl_box_details
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'TblBoxDetails', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "uint_box_index";

        $tbl_box_details = TblBoxDetails::find($parameters);
        if (count($tbl_box_details) == 0) {
            $this->flash->notice("The search did not find any tbl_box_details");

            $this->dispatcher->forward([
                "controller" => "tbl_box_details",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $tbl_box_details,
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
     * Edits a tbl_box_detail
     *
     * @param string $uint_box_index
     */
    public function editAction($uint_box_index)
    {
        if (!$this->request->isPost()) {

            $tbl_box_detail = TblBoxDetails::findFirstByuint_box_index($uint_box_index);
            if (!$tbl_box_detail) {
                $this->flash->error("tbl_box_detail was not found");

                $this->dispatcher->forward([
                    'controller' => "tbl_box_details",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->uint_box_index = $tbl_box_detail->uint_box_index;

            $this->tag->setDefault("uint_box_index", $tbl_box_detail->uint_box_index);
            $this->tag->setDefault("char_box_ip", $tbl_box_detail->char_box_ip);
            $this->tag->setDefault("uint_box_platform", $tbl_box_detail->uint_box_platform);
            $this->tag->setDefault("char_mac", $tbl_box_detail->char_mac);
            
        }
    }

    /**
     * Creates a new tbl_box_detail
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "tbl_box_details",
                'action' => 'index'
            ]);

            return;
        }

        $tbl_box_detail = new TblBoxDetails();
        $tbl_box_detail->char_box_ip = $this->request->getPost("char_box_ip");
        $tbl_box_detail->uint_box_platform = $this->request->getPost("uint_box_platform");
        $tbl_box_detail->char_mac = $this->request->getPost("char_mac");
        

        if (!$tbl_box_detail->save()) {
            foreach ($tbl_box_detail->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_box_details",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("tbl_box_detail was created successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_box_details",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a tbl_box_detail edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "tbl_box_details",
                'action' => 'index'
            ]);

            return;
        }

        $uint_box_index = $this->request->getPost("uint_box_index");
        $tbl_box_detail = TblBoxDetails::findFirstByuint_box_index($uint_box_index);

        if (!$tbl_box_detail) {
            $this->flash->error("tbl_box_detail does not exist " . $uint_box_index);

            $this->dispatcher->forward([
                'controller' => "tbl_box_details",
                'action' => 'index'
            ]);

            return;
        }

        $tbl_box_detail->char_box_ip = $this->request->getPost("char_box_ip");
        $tbl_box_detail->uint_box_platform = $this->request->getPost("uint_box_platform");
        $tbl_box_detail->char_mac = $this->request->getPost("char_mac");
        

        if (!$tbl_box_detail->save()) {

            foreach ($tbl_box_detail->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_box_details",
                'action' => 'edit',
                'params' => [$tbl_box_detail->uint_box_index]
            ]);

            return;
        }

        $this->flash->success("tbl_box_detail was updated successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_box_details",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a tbl_box_detail
     *
     * @param string $uint_box_index
     */
    public function deleteAction($uint_box_index)
    {
        $tbl_box_detail = TblBoxDetails::findFirstByuint_box_index($uint_box_index);
        if (!$tbl_box_detail) {
            $this->flash->error("tbl_box_detail was not found");

            $this->dispatcher->forward([
                'controller' => "tbl_box_details",
                'action' => 'index'
            ]);

            return;
        }

        if (!$tbl_box_detail->delete()) {

            foreach ($tbl_box_detail->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_box_details",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("tbl_box_detail was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_box_details",
            'action' => "index"
        ]);
    }

}
