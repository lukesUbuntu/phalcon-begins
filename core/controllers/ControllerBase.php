<?php

namespace Core\Controllers;

use \Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{


    private $lang;
    private $lang_loaded;


    /**
     * get the translated language from language array key.
     * 
     * @param string $message language array key
     * @param array $params replacable array key => value
     * @return string translated string
     */
    protected function langGet($message = '', $params = null)
    {
        return $this->lang->_($message, $params);
    }// langGet


    /**
     * load language file. the language file construction is app/language/{lang}/{lang_file}.php
     * 
     * @global object $config global configuration
     * @param string $lang_file the language file
     */
    protected function langLoad($lang_file = '')
    {
        global $config;
        
        // get current language
        $lang_uri = $this->dispatcher->getParam('lang');
        if ($lang_uri == null) {
            $lang_uri = $config->language->fallbackLang;
        }
        
        // get language dir and translated file.
        if (strpos($lang_file, '::') === false) {
            $language_path = $config->application->languageDir;
        } else {
            $lang_exp = explode('::', $lang_file);
            $module_name = $lang_exp[0];
            $lang_file = $lang_exp[1];
            if ($module_name == 'core') {
                $language_path = $config->application->languageDir;
            } else {
                $language_path = MODULEFULLPATH.'/'.$module_name.'/language/';
            }
            
            unset($lang_exp, $module_name);
        }
        
        if (file_exists($language_path.$lang_uri.'/'.$lang_file.'.php')) {
            require $language_path.$lang_uri.'/'.$lang_file.'.php';
        } else {
            require $language_path.$config->language->fallbackLang.'/'.$lang_file.'.php';
        }
        
        // load messages into array before call to translate adapter.
        if (isset($messages)) {
            if (empty($this->lang_loaded)) {
                $this->lang_loaded = $messages;
            } else {
                $this->lang_loaded = array_merge($this->lang_loaded, $messages);
            }
        }
        
        // get language content
        $translate = new \Phalcon\Translate\Adapter\NativeArray(array(
            'content' => $this->lang_loaded
        ));
        
        $this->view->setVar('t', $translate);
        $this->lang = $translate;
        
        unset($lang_file, $lang_uri, $language_path, $translate);
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
                // get default language in config
                //$config = $this->di->getShared('config');
                //$current_lang = $config->language->defaultLang;
                $this->response->redirect(/*$current_lang.*/$this->router->getRewriteUri());
                unset($config, $current_lang);
            }
        }
        unset($matched_lang, $no_redirect, $no_redirect_exts, $url_exp);
        // end redirect to current url with language prefix ------------------------------------
    }// onConstruct


}
