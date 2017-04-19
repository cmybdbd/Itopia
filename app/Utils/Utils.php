<?php
/**
 * Created by PhpStorm.
 * User: smallst
 * Date: 4/12/17
 * Time: 9:28 PM
 */
namespace App\Utils;

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
    static public function generatePasswd($len){
        $strpol = '0123456789';
        $passwd = '';
        for ($i = 0; $i < $len; $i++)
        {
            $passwd .= $strpol[mt_rand(0, strlen($strpol) - 1)];
        }
        return $passwd;
    }
    static public function curDay(){
        $time = time();

        return strtotime(date('Y-m-d 00:00:00'));

    }
    static public function curNight(){
        $time = time();
        if(date('H',$time) <= 5)
        {
            return strtotime(date('Y-m-d 00:00:00'));
        }
        else
        {
            return strtotime(date('Y-m-d 00:00:00'))+ 24 * 60 * 60;
        }
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


    public static function AES_encrypt($str, $seed)
    {
        $res = exec('java -jar ../java/AESUtils.jar e '.$seed. ' '. $str);
        return $res;
    }



    public static function sign($arr, $sort = false, $uppercase = false)
    {
        if($sort)
        {
            sort($arr);
        }
        $sig="";
        foreach ($arr as $var)
        {
            $sig.=$var;
        }
        $ret = md5($sig);
        if($uppercase)
        {
            $ret = strtoupper($ret);
        }
        return $ret;
    }
}