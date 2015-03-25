<?php
/* 
 * 
 * @author Vee W.
 * @license http://opensource.org/licenses/MIT
 * 
 */

namespace Modules\Dbt\Models;

class Test extends \Phalcon\Mvc\Model
{


    /**
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * @Column(type="string", length=255, nullable=true)
     */
    public $name;


    /**
     * @Column(type="string", length=1000, nullable=true)
     */
    public $address;


    public function getSource()
    {
        $config = $this->_dependencyInjector->getShared('config');
        return $config->database->tablePrefix.'test';
    }// getSource


    public function initialize()
    {
        // $this->belongsTo();// more info about relations, see the document.
    }// initialize


}