<?php
/* 
 * 
 *  @author Vee W.
 *  @license http://opensource.org/licenses/MIT
 * 
 */

namespace Modules\Contact\Controllers;

class IndexController extends \Core\Controllers\ControllerBase
{


    public function indexAction()
    {
        $this->langLoad('contact::contact');
        $this->langLoad('core::index');
    }// indexAction


    public function page2Action()
    {
        
    }// page2Action


}