<?php
/* 
 * 
 * @author Vee W.
 * @license http://opensource.org/licenses/MIT
 * 
 */

namespace Modules\Dbt\Forms;

use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\Hidden,
    Phalcon\Validation\Validator\PresenceOf,
    Phalcon\Validation\Validator\StringLength,
    Phalcon\Validation\Validator\Identical;

class CommonTestDbForm extends Form
{


    public function bind($data, $entity, $whitelist = null) {
        // modify content data. (html escape, etc...)
        if (isset($data['name'])) {
            $data['name'] = htmlspecialchars($data['name']);
        }
        if (isset($data['address'])) {
            $data['address'] = htmlspecialchars($data['address']);
        }
        return parent::bind($data, $entity, $whitelist);
    }// bind


    public function initialize($db = '', array $options = [])
    {
        // csrf
        $csrf = new Hidden('csrf');
        $csrf->addValidator(
            new Identical(
                array(
                    'value' => $this->security->getSessionToken(),
                    'message' => 'CSRF validation failed'
                )
            )
        );
        $this->add($csrf);
        unset($csrf);
        
        // id
        if (isset($options['edit']) && $options['edit'] === true && isset($options['id'])) {
            $this->add(new Hidden('id', ['value' => $options['id']]));
        } else {
            $this->add(new Hidden('id'));
        }
        
        // name
        $name = new Text('name');
        $name->addValidators(
            [
                new PresenceOf(
                    ['cancelOnFail' => true]
                ),
                new StringLength(
                    ['min' => 2]
                )
            ]
        );
        if (isset($db->name)) {
            // this data is htmlspecialchars() so, it have to be decode.
            $db->name = htmlspecialchars_decode($db->name);
        }
        $this->add($name);
        unset($name);
        
        // address
        $address = new Text('address');
        $address->addValidators(
            [
                new PresenceOf(),
                new StringLength(
                    ['min' => 2]
                )
            ]
        );
        if (isset($db->address)) {
            // this data is htmlspecialchars() so, it have to be decode.
            $db->address = htmlspecialchars_decode($db->address);
        }
        $this->add($address);
        unset($address);
    }// initialize


}