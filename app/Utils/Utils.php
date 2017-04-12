<?php
/**
 * Created by PhpStorm.
 * User: smallst
 * Date: 4/12/17
 * Time: 9:28 PM
 */

class Utils{
    static public function my_buid_query($prestring, $encodeUrl=false){
        $pstr= '';
        foreach ($prestring as $key => $value){
            if($encodeUrl)
            {
                $pstr.= ($key . '=' . urlencode($value) . '&');
            }
            else
            {
                $pstr.= ($key . '=' . ($value) . '&');
            }
        }
        $pstr = substr($pstr, 0, -1);
        return $pstr;
    }

    static public function createxml($ar, $cada=false) {
        $xml = '<xml>';
        foreach($ar as $k=>$v) {
            if($cada){
                $xml .= "<" . $k . "><![CDATA[" . $v . "]]></" . $k . ">";
            }
            else
            {
                $xml .= '<'.$k.'>'.$v.'</'.$k.'>';
            }
        }
        $xml .= '</xml>';
        return $xml;
    }


    static function get_server_ip()
    {
        if (!empty($_SERVER['SERVER_ADDR']))
        {
            return $_SERVER['SERVER_ADDR'];
        }
        $result = shell_exec("/sbin/ifconfig");
        if (preg_match_all("/addr:(\d+\.\d+\.\d+\.\d+)/", $result, $match) !== 0)
        {
            foreach ($match[0] as $k => $v)
            {
                if ($match[1][$k] != "127.0.0.1")
                {
                    return $match[1][$k];
                }
            }
        }

        return false;
    }


}