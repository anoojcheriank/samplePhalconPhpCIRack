<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class TblSlotConfigController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for tbl_slot_config
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'TblSlotConfig', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "uint_slot_index";

        $tbl_slot_config = TblSlotConfig::find($parameters);
        if (count($tbl_slot_config) == 0) {
            $this->flash->notice("The search did not find any tbl_slot_config");

            $this->dispatcher->forward([
                "controller" => "tbl_slot_config",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $tbl_slot_config,
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
     * Edits a tbl_slot_config
     *
     * @param string $uint_slot_index
     */
    public function editAction($uint_slot_index)
    {
        if (!$this->request->isPost()) {

            $tbl_slot_config = TblSlotConfig::findFirstByuint_slot_index($uint_slot_index);
            if (!$tbl_slot_config) {
                $this->flash->error("tbl_slot_config was not found");

                $this->dispatcher->forward([
                    'controller' => "tbl_slot_config",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->uint_slot_index = $tbl_slot_config->uint_slot_index;

            $this->tag->setDefault("uint_slot_index", $tbl_slot_config->uint_slot_index);
            $this->tag->setDefault("rack_name", $tbl_slot_config->rack_name);
            $this->tag->setDefault("rack_number", $tbl_slot_config->rack_number);
            $this->tag->setDefault("uint_slot_availability", $tbl_slot_config->uint_slot_availability);
            $this->tag->setDefault("uint_box_index", $tbl_slot_config->uint_box_index);
            $this->tag->setDefault("uint_rack_type", $tbl_slot_config->uint_rack_type);
            
        }
    }

    /**
     * Creates a new tbl_slot_config
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "tbl_slot_config",
                'action' => 'index'
            ]);

            return;
        }

        $tbl_slot_config = new TblSlotConfig();
        $tbl_slot_config->rack_name = $this->request->getPost("rack_name");
        $tbl_slot_config->rack_number = $this->request->getPost("rack_number");
        $tbl_slot_config->uint_slot_availability = $this->request->getPost("uint_slot_availability");
        $tbl_slot_config->uint_box_index = $this->request->getPost("uint_box_index");
        $tbl_slot_config->uint_rack_type = $this->request->getPost("uint_rack_type");
        

        if (!$tbl_slot_config->save()) {
            foreach ($tbl_slot_config->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_slot_config",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("tbl_slot_config was created successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_slot_config",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a tbl_slot_config edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "tbl_slot_config",
                'action' => 'index'
            ]);

            return;
        }

        $uint_slot_index = $this->request->getPost("uint_slot_index");
        $tbl_slot_config = TblSlotConfig::findFirstByuint_slot_index($uint_slot_index);

        if (!$tbl_slot_config) {
            $this->flash->error("tbl_slot_config does not exist " . $uint_slot_index);

            $this->dispatcher->forward([
                'controller' => "tbl_slot_config",
                'action' => 'index'
            ]);

            return;
        }

        $tbl_slot_config->rack_name = $this->request->getPost("rack_name");
        $tbl_slot_config->rack_number = $this->request->getPost("rack_number");
        $tbl_slot_config->uint_slot_availability = $this->request->getPost("uint_slot_availability");
        $tbl_slot_config->uint_box_index = $this->request->getPost("uint_box_index");
        $tbl_slot_config->uint_rack_type = $this->request->getPost("uint_rack_type");
        

        if (!$tbl_slot_config->save()) {

            foreach ($tbl_slot_config->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_slot_config",
                'action' => 'edit',
                'params' => [$tbl_slot_config->uint_slot_index]
            ]);

            return;
        }

        $this->flash->success("tbl_slot_config was updated successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_slot_config",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a tbl_slot_config
     *
     * @param string $uint_slot_index
     */
    public function deleteAction($uint_slot_index)
    {
        $tbl_slot_config = TblSlotConfig::findFirstByuint_slot_index($uint_slot_index);
        if (!$tbl_slot_config) {
            $this->flash->error("tbl_slot_config was not found");

            $this->dispatcher->forward([
                'controller' => "tbl_slot_config",
                'action' => 'index'
            ]);

            return;
        }

        if (!$tbl_slot_config->delete()) {

            foreach ($tbl_slot_config->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_slot_config",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("tbl_slot_config was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_slot_config",
            'action' => "index"
        ]);
    }

}
