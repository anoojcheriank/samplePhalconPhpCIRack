<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class TblBuildDetailsController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for tbl_build_details
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'TblBuildDetails', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "uint_build_index";

        $tbl_build_details = TblBuildDetails::find($parameters);
        if (count($tbl_build_details) == 0) {
            $this->flash->notice("The search did not find any tbl_build_details");

            $this->dispatcher->forward([
                "controller" => "tbl_build_details",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $tbl_build_details,
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
     * Edits a tbl_build_detail
     *
     * @param string $uint_build_index
     */
    public function editAction($uint_build_index)
    {
        if (!$this->request->isPost()) {

            $tbl_build_detail = TblBuildDetails::findFirstByuint_build_index($uint_build_index);
            if (!$tbl_build_detail) {
                $this->flash->error("tbl_build_detail was not found");

                $this->dispatcher->forward([
                    'controller' => "tbl_build_details",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->uint_build_index = $tbl_build_detail->uint_build_index;

            $this->tag->setDefault("uint_build_index", $tbl_build_detail->uint_build_index);
            $this->tag->setDefault("char_build_name", $tbl_build_detail->char_build_name);
            $this->tag->setDefault("uint_box_platform", $tbl_build_detail->uint_box_platform);
            $this->tag->setDefault("char_build_md5sum", $tbl_build_detail->char_build_md5sum);
            $this->tag->setDefault("uint_build_type", $tbl_build_detail->uint_build_type);
            $this->tag->setDefault("char_middleware_version", $tbl_build_detail->char_middleware_version);
            
        }
    }

    /**
     * Creates a new tbl_build_detail
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "tbl_build_details",
                'action' => 'index'
            ]);

            return;
        }

        $tbl_build_detail = new TblBuildDetails();
        $tbl_build_detail->char_build_name = $this->request->getPost("char_build_name");
        $tbl_build_detail->uint_box_platform = $this->request->getPost("uint_box_platform");
        $tbl_build_detail->char_build_md5sum = $this->request->getPost("char_build_md5sum");
        $tbl_build_detail->uint_build_type = $this->request->getPost("uint_build_type");
        $tbl_build_detail->char_middleware_version = $this->request->getPost("char_middleware_version");
        

        if (!$tbl_build_detail->save()) {
            foreach ($tbl_build_detail->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_build_details",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("tbl_build_detail was created successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_build_details",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a tbl_build_detail edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "tbl_build_details",
                'action' => 'index'
            ]);

            return;
        }

        $uint_build_index = $this->request->getPost("uint_build_index");
        $tbl_build_detail = TblBuildDetails::findFirstByuint_build_index($uint_build_index);

        if (!$tbl_build_detail) {
            $this->flash->error("tbl_build_detail does not exist " . $uint_build_index);

            $this->dispatcher->forward([
                'controller' => "tbl_build_details",
                'action' => 'index'
            ]);

            return;
        }

        $tbl_build_detail->char_build_name = $this->request->getPost("char_build_name");
        $tbl_build_detail->uint_box_platform = $this->request->getPost("uint_box_platform");
        $tbl_build_detail->char_build_md5sum = $this->request->getPost("char_build_md5sum");
        $tbl_build_detail->uint_build_type = $this->request->getPost("uint_build_type");
        $tbl_build_detail->char_middleware_version = $this->request->getPost("char_middleware_version");
        

        if (!$tbl_build_detail->save()) {

            foreach ($tbl_build_detail->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_build_details",
                'action' => 'edit',
                'params' => [$tbl_build_detail->uint_build_index]
            ]);

            return;
        }

        $this->flash->success("tbl_build_detail was updated successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_build_details",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a tbl_build_detail
     *
     * @param string $uint_build_index
     */
    public function deleteAction($uint_build_index)
    {
        $tbl_build_detail = TblBuildDetails::findFirstByuint_build_index($uint_build_index);
        if (!$tbl_build_detail) {
            $this->flash->error("tbl_build_detail was not found");

            $this->dispatcher->forward([
                'controller' => "tbl_build_details",
                'action' => 'index'
            ]);

            return;
        }

        if (!$tbl_build_detail->delete()) {

            foreach ($tbl_build_detail->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_build_details",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("tbl_build_detail was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_build_details",
            'action' => "index"
        ]);
    }

}
