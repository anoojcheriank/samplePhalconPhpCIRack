<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class TblTestController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for tbl_test
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'TblTest', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "uint_test_index";

        $tbl_test = TblTest::find($parameters);
        if (count($tbl_test) == 0) {
            $this->flash->notice("The search did not find any tbl_test");

            $this->dispatcher->forward([
                "controller" => "tbl_test",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $tbl_test,
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
     * Edits a tbl_test
     *
     * @param string $uint_test_index
     */
    public function editAction($uint_test_index)
    {
        if (!$this->request->isPost()) {

            $tbl_test = TblTest::findFirstByuint_test_index($uint_test_index);
            if (!$tbl_test) {
                $this->flash->error("tbl_test was not found");

                $this->dispatcher->forward([
                    'controller' => "tbl_test",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->uint_test_index = $tbl_test->uint_test_index;

            $this->tag->setDefault("uint_test_index", $tbl_test->uint_test_index);
            $this->tag->setDefault("uint_test_type", $tbl_test->uint_test_type);
            $this->tag->setDefault("uint_test_mode", $tbl_test->uint_test_mode);
            $this->tag->setDefault("text_test_description", $tbl_test->text_test_description);
            $this->tag->setDefault("char_test_name", $tbl_test->char_test_name);
            
        }
    }

    /**
     * Creates a new tbl_test
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "tbl_test",
                'action' => 'index'
            ]);

            return;
        }

        $tbl_test = new TblTest();
        $tbl_test->uint_test_type = $this->request->getPost("uint_test_type");
        $tbl_test->uint_test_mode = $this->request->getPost("uint_test_mode");
        $tbl_test->text_test_description = $this->request->getPost("text_test_description");
        $tbl_test->char_test_name = $this->request->getPost("char_test_name");
        

        if (!$tbl_test->save()) {
            foreach ($tbl_test->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_test",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("tbl_test was created successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_test",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a tbl_test edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "tbl_test",
                'action' => 'index'
            ]);

            return;
        }

        $uint_test_index = $this->request->getPost("uint_test_index");
        $tbl_test = TblTest::findFirstByuint_test_index($uint_test_index);

        if (!$tbl_test) {
            $this->flash->error("tbl_test does not exist " . $uint_test_index);

            $this->dispatcher->forward([
                'controller' => "tbl_test",
                'action' => 'index'
            ]);

            return;
        }

        $tbl_test->uint_test_type = $this->request->getPost("uint_test_type");
        $tbl_test->uint_test_mode = $this->request->getPost("uint_test_mode");
        $tbl_test->text_test_description = $this->request->getPost("text_test_description");
        $tbl_test->char_test_name = $this->request->getPost("char_test_name");
        

        if (!$tbl_test->save()) {

            foreach ($tbl_test->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_test",
                'action' => 'edit',
                'params' => [$tbl_test->uint_test_index]
            ]);

            return;
        }

        $this->flash->success("tbl_test was updated successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_test",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a tbl_test
     *
     * @param string $uint_test_index
     */
    public function deleteAction($uint_test_index)
    {
        $tbl_test = TblTest::findFirstByuint_test_index($uint_test_index);
        if (!$tbl_test) {
            $this->flash->error("tbl_test was not found");

            $this->dispatcher->forward([
                'controller' => "tbl_test",
                'action' => 'index'
            ]);

            return;
        }

        if (!$tbl_test->delete()) {

            foreach ($tbl_test->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "tbl_test",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("tbl_test was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "tbl_test",
            'action' => "index"
        ]);
    }

}
