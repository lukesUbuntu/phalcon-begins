<?php
/* 
 * 
 * @author Vee W.
 * @license http://opensource.org/licenses/MIT
 * 
 */

namespace Modules\Dbt\Controllers;

class IndexController extends \Core\Controllers\ControllerBase
{


    public function addAction()
    {
        $output = [];
        
        // add form.
        $form = new \Modules\Dbt\Forms\CommonTestDbForm(null, array());
        $this->view->setVar('form', $form);
        
        if ($this->request->isPost()) {
            if (!$form->isValid($_POST)) {
                $output['err_msg'] = '';
                foreach ($form->getMessages() as $message) {
                    $output['err_msg'] .= $message.'<br>';
                }
                unset($message);
            } else {
                // passed validated post
                $data['name'] = htmlspecialchars($this->request->getPost('name', array('trim')));
                $data['address'] = htmlspecialchars($this->request->getPost('address', 'trim'));
                $dbtest = new \Modules\Dbt\Models\Test();
                $dbtest_save = $dbtest->save($data);
                if ($dbtest_save === false) {
                    $output['err_msg'] = 'Unable to insert<br>'."\n";
                    foreach ($dbtest->getMessages() as $message) {
                        $output['err_msg'] = $message."<br>\n";
                    }
                    unset($message);
                } else {
                    $output['err_msg'] = 'Saved success! The id is '.$dbtest->id;
                }
                unset($data, $dbtest, $dbtest_save);
            }
        }
        
        $this->view->setVars($output);
        unset($form, $output);
        $this->view->pick('index/form');
    }// addAction


    public function editAction($id = '')
    {
        $output = [];
        
        $dbtest = \Modules\Dbt\Models\Test::findFirstById($id);

        // add form
        $form = new \Modules\Dbt\Forms\CommonTestDbForm($dbtest, ['edit' => true, 'id' => $id]);
        $this->view->setVar('form', $form);
        
        if ($this->request->isPost()) {
            if (!$form->isValid($_POST)) {
                $output['err_msg'] = '';
                foreach ($form->getMessages() as $message) {
                    $output['err_msg'] .= $message.'<br>';
                }
                unset($message);
            } else {
                // passed validated post
                $form->bind($this->request->getPost(), $dbtest);
                $dbtest_save = $dbtest->save();
                if ($dbtest_save === false) {
                    $output['err_msg'] = 'Unable to update<br>'."\n";
                    foreach ($dbtedst->getMessages() as $message) {
                        $output['err_msg'] = $message."<br>\n";
                    }
                    unset($message);
                } else {
                    $output['err_msg'] = 'Saved success! The id is '.$id;
                }
                unset($data, $dbtedst, $dbtest_save);
            }
        }
        
        $this->view->setVars($output);
        unset($form, $output);
        $this->view->pick('index/form');
    }// editAction


    public function indexAction()
    {
        // generate some form for delete action
        $form = new \Phalcon\Forms\Form();
        $csrf = new \Phalcon\Forms\Element\Hidden('csrf', ['value' => $this->security->getToken()]);
        $csrf->addValidator(
            new \Phalcon\Validation\Validator\Identical(
                array(
                    'value' => $this->security->getSessionToken(),
                    'message' => 'CSRF validation failed'
                )
            )
        );
        $form->add($csrf);
        $this->view->setVar('form', $form);
        unset($csrf, $form);
        
        $current_page = (int) $this->request->get('page', null, 1);
        $dbtest = \Modules\Dbt\Models\Test::query()
            ->order('id DESC')
            ->execute();
        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                'data' => $dbtest,
                'limit'=> 10,
                'page' => $current_page
            )
        );
        $this->view->setVar('page', $paginator->getPaginate());
        unset($current_page, $dbtest, $paginator);
    }// indexAction


    public function multipleAction()
    {
        $ids = $this->request->getPost('id');
        $connection = $this->_dependencyInjector->getShared('db');
        $config = $this->_dependencyInjector->getShared('config');
        
        if ($this->request->isPost()) {
            if (!$this->security->checkToken('csrf')) {
                echo 'CSRF failed.';
            } else {
                if (is_array($ids)) {
                    foreach ($ids as $id) {
                        // to use database abstraction layer, you have to manually add table prefix.
                        //$connection->execute('DELETE `'.$config->database->tablePrefix.'test` WHERE `id` = ?', [$id]);
                        $connection->delete($config->database->tablePrefix.'test', 'id = '.$id);
                    }
                }
            }
        }
        
        unset($config, $connection, $id, $ids);
        
        $this->response->redirect('dbt');
    }// multipleAction


}