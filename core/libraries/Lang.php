<?php
/* 
 * 
 * @author Vee W.
 * @license http://opensource.org/licenses/MIT
 * 
 */

namespace Libraries;

class Lang
{


    public $dispatcher;
    private $lang;
    private $lang_loaded;


    /**
     * get the translated language from language array key.
     * 
     * @param string $message language array key
     * @param array $params replacable array key => value
     * @return string translated string
     */
    public function get($message = '', $params = null)
    {
        return $this->lang->_($message, $params);
    }// get


    /**
     * get loaded messages
     * 
     * @return array
     */
    public function getLoaded()
    {
      return $this->lang_loaded;  
    }// getLoaded


    /**
     * load language file. the language file construction is app/language/{lang}/{lang_file}.php
     * 
     * @global object $config global configuration
     * @param string $lang_file the language file
     */
    public function load($lang_file = '')
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
        
        $this->lang = $translate;
        
        unset($lang_file, $lang_uri, $language_path);
        return $translate;
    }// load


    /**
     * set loaded messages.
     * 
     * @param array $lang_loaded
     */
    public function setLoaded($lang_loaded)
    {
        $this->lang_loaded = $lang_loaded;
    }// setLoaded


}