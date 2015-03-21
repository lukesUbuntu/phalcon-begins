<?php
/* 
 * 
 *  @author Vee W.
 *  @license http://opensource.org/licenses/MIT
 * 
 */

namespace Core\Controllers;

class ErrorController extends \Phalcon\Mvc\Controller
{


    public function e404Action()
    {
        $this->response->setStatusCode(404, 'Not Found');
        echo '<span style="color: red;">Not found!</span>'."<br>\n";
    }// e404Action


}