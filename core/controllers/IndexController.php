<?php

namespace Core\Controllers;

class IndexController extends \Core\Controllers\ControllerBase
{

    public function indexAction()
    {
        $this->langLoad('index');
        $this->langLoad('core');
    }// indexAction


    public function testAssetsAction()
    {
        $this->assets
            ->collection('header')
            ->addCss('css/style.css')
            ->addCss('css/index.css');

        $this->assets
            ->collection('footer')
            ->addJs('js/jquery.js')
            ->addJs('js/bootstrap.min.js');
    }// testAssetsAction


    public function testGenUrlAction()
    {
        $output['get_base_uri'] = $this->url->getBaseUri();
        $output['get_static_base_uri'] = $this->url->getStaticBaseUri();
        $output['get'] = $this->url->get('begins-inserted-url', ['q1' => 'val1', 'q2' => 'val2']);
        $output['path'] = $this->url->path('begins-inserted-url/page');
        $output['get_current_uri'] = $this->url->getCurrentUri();
        
        $this->view->setVars($output);
    }// testGenUrlAction


    public function testLinkAction()
    {
        echo '<h1>Test links</h1>'."\n";
        echo 'Well done!'."<br>\n";
        echo 'Now, '.$this->tag->linkTo('/', 'Go home')."<br>\n";
        echo " or <br>\n";
        echo $this->tag->linkTo(array($this->url->getCurrentUrlNewLanguage('en'), 'switch to English language', 'local' => false))."\n";
        echo "<br>\n";
        echo " or <br>\n";
        echo \Phalcon\Tag::linkTo('link-to-not-exists', 'go to somewhere else that doesn\'t exists.')."<br>\n";
        echo \Phalcon\Tag::linkTo('index/action-not-exists', 'go to this controller that action doesn\'t exists.')."<br>\n";
        echo "<hr>\n";
        
        echo 'Test language:'."<br>\n";
        $this->langLoad('index');
        echo $this->lang->get('index_welcome')."<br>\n";
    }// testLinkAction


    public function testPaginationAction()
    {
        $current_page = (isset($_GET['page']) ? $_GET['page'] : 1);
        
        $data = [
            ['id' => 1, 'name' => 'Aaa'],
            ['id' => 2, 'name' => 'Aaab'],
            ['id' => 3, 'name' => 'Bbb'],
            ['id' => 4, 'name' => 'Bbbc'],
            ['id' => 5, 'name' => 'Ccc'],
            ['id' => 6, 'name' => 'Cccd'],
            ['id' => 7, 'name' => 'Ddd'],
            ['id' => 8, 'name' => 'Ddde'],
            ['id' => 9, 'name' => 'Eee'],
            ['id' => 10, 'name' => 'Eeef'],
            ['id' => 11, 'name' => 'Fff'],
            ['id' => 12, 'name' => 'Fffg'],
            ['id' => 13, 'name' => 'Ggg'],
            ['id' => 14, 'name' => 'Gggh'],
            ['id' => 15, 'name' => 'Hhh'],
        ];
        
        $paginator = new \Phalcon\Paginator\Adapter\NativeArray(
            array(
                'data' => $data,
                'limit' => 2,
                'page' => $current_page,
            )
        );
        
        $page = $paginator->getPaginate();

        // render data table
        echo 'Total items: '.$page->total_items."<br>\n";
        echo '<table style="border: 1px solid #ccc; border-collapse:collapse;"><tr><th style="border: 1px solid #ccc;">id</th><th style="border: 1px solid #ccc;">name</th></tr>';
        foreach ($page->items as $item) {
            echo '<tr>';
            echo '<td style="border: 1px solid #ccc;">'.$item['id'].'</td>';
            echo '<td style="border: 1px solid #ccc;">'.$item['name'].'</td>';
            echo '</tr>';
        }
        echo '</table>'."\n";
        echo 'Total pages: '.$page->total_pages."<br>\n";
        echo '<a href="'.$this->url->getCurrentUri().'">First</a>
        <a href="'.$this->url->getCurrentUri().'?page='.$page->before.'">Previous</a>
        <a href="'.$this->url->getCurrentUri().'?page='.$page->next.'">Next</a>
        <a href="'.$this->url->getCurrentUri().'?page='.$page->last.'">Last</a>';
        echo "<br>\n";
    }// testPaginationAction


    public function testRedirectAction()
    {
        $this->response->redirect('redirect2-that-was-not-found');
    }// testRedirectAction

}

