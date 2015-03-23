<?php

namespace Core\Controllers;

use \Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{


    public $lang;
    private $lang_loaded;


    /**
     * load language file. the language file construction is app/language/{lang}/{lang_file}.php
     * 
     * @global object $config global configuration
     * @param string $lang_file the language file
     */
    protected  function langLoad($lang_file = '')
    {
        $lang = new \Libraries\Lang();
        // set things in language class
        $lang->dispatcher = $this->dispatcher;
        $lang->setLoaded($this->lang_loaded);
        // load language file.
        $translate = $lang->load($lang_file);
        // set properties for use in controllers.
        $this->lang_loaded = $lang->getLoaded();
        $this->view->setVar('t', $translate);
        $this->lang = $lang;
        unset($lang, $translate);
    }// langLoad


    protected function beforeExecuteRoute($dispatcher)
    {
        // if url contain no language uri, redirect to current url with language uri prefix.
        $no_redirect_exts = ['css', 'js', 'gif', 'jpg', 'jpeg', 'png'];
        preg_match('#/[a-z]{2}/# iu', $this->router->getRewriteUri(), $matched_lang);
        if ($dispatcher->getParam('lang') == null && count($matched_lang) <= 0) {
            // check that do not redirect url that has extension matched on 'no_redirect_exts'
            if (strpos($this->router->getRewriteUri(), '.') !== false) {
                $url_exp = explode('.', $this->router->getRewriteUri());
                if (
                    is_array($url_exp) && 
                    array_key_exists(count($url_exp)-1, $url_exp) && 
                    in_array(strtolower($url_exp[count($url_exp)-1]), $no_redirect_exts)
                ) {
                    $no_redirect = true;
                }
            }
            
            if (!isset($no_redirect) || (isset($no_redirect) && $no_redirect === false)) {
                $this->response->redirect($this->router->getRewriteUri());
                unset($config, $current_lang);
            }
        }
        unset($matched_lang, $no_redirect, $no_redirect_exts, $url_exp);
        // end redirect to current url with language prefix ------------------------------------
    }// beforeExecuteRoute


}
