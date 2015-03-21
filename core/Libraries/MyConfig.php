<?php
/**
 * Config class helper
 * 
 * @author Vee W.
 */

namespace Libraries;

class MyConfig extends \Phalcon\Config
{


    /**
     * get base uri automatically.
     * 
     * @return string return base uri that this application installed.
     */
    public function getBaseUri()
    {
        $replaced_slash_fullpath = str_replace('\\', '/', ROOTFULLPATH);
        $request_uri_no_slash_trail = rtrim($_SERVER["REQUEST_URI"], '/');
        
        return $this->findMatchUri($replaced_slash_fullpath, $request_uri_no_slash_trail);
    }// getBaseUri


    /**
     * find matched uris.<br>
     * example: full path of root is c:\wwwroot\myphalcon and uri to find is /myphalcon/thispage/subpage/query. matched value will be /myphalcon/.
     * 
     * @param string $str1 full path
     * @param string $str2 uri to find match.
     * @return string return matched uri only.
     */
    private function findMatchUri($str1 = '', $str2 = '')
    {
        if (strpos($str1, '/') === false || strpos($str2, '/') === false) {
            return '/';
        }
        
        $str1_arr = explode('/', $str1);
        $str2_arr = explode('/', $str2);
        $found_matched = [];
        
        foreach ($str1_arr as $uri_target) {
            foreach ($str2_arr as $uri_find) {
                if (strcmp($uri_find, $uri_target) === 0 && $uri_find != null) {
                    $found_matched[] = $uri_find;
                }
            }
        }
        
        unset($str1_arr, $str2_arr);
        
        if (empty($found_matched)) {
            $found_matched_string = '/';
        } else {
            $found_matched_string = '/'.implode('/', $found_matched).'/';
        }
        
        unset($found_matched);
        return $found_matched_string;
    }// findMatchUri


}