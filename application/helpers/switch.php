<?php

if (!function_exists('to_under_score')) {
    /**
     * Function to_under_score
     * 驼峰命名转下划线命名
     *
     * @param string $str
     * @return string
     */
    function to_under_score(string $str): string
    {
        $dStr = preg_replace_callback('/([A-Z]+)/',function($match) {
            return '_'.strtolower($match[0]);
        }, $str);
        return trim(preg_replace('/_{2,}/','_',$dStr),'_');
    }
}

if (!function_exists('to_camel_case')) {
    /**
     * Function to_camel_case
     * 下划线命名转小驼峰命名
     * @param string $str
     * @return string
     */
    function to_camel_case(string $str): string
    {
        $array = explode('_', $str);
        $result = $array[0];
        $len=count($array);
        if($len>1) {
            for($i=1;$i<$len;$i++) {
                $result.= ucfirst($array[$i]);
            }
        }
        return $result;
    }
}

if (!function_exists('to_big_camel_case')) {
    /**
     * Function to_big_camel_case
     * 下划线命名转大驼峰命名
     * @param string $str
     * @return string
     */
    function to_big_camel_case(string $str): string
    {
        $array = explode('_', $str);
        $result = '';
        $len=count($array);
        if($len>0) {
            for($i=0;$i<$len;$i++) {
                $result.= ucfirst($array[$i]);
            }
        }
        return $result;
    }
}