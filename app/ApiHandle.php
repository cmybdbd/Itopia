<?php

/**
 * Class ApiHandle
 */

namespace App;
class ApiHandle
{
    function httpGet($url,$timeout='50')
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }
    //post
    function httpPost($url,$data,$timeout='50')
    {
        $ch = curl_init ();
        // print_r($ch);

        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_HEADER, 0 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS,http_build_query($data));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $return = curl_exec($ch);
        curl_close($ch);
        //var_dump($return);
        //exit();
        return $return;
        /*//echo $url;
        //print_r($data);
        //echo http_build_query($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        /*curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        ob_start();
        curl_exec($ch);
        $return_content = ob_get_contents();
        ob_end_clean();
        var_dump($return_content);
        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        var_dump($return_code);exit();
        if ($return_code != 200)
        {
            return false;
        }
        return $return_content;
    */
    }
}