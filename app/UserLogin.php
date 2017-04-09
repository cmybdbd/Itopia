<?php
/**
 * Created by PhpStorm.
 * User: lance
 * Date: 4/9/17
 * Time: 6:19 PM
 */

namespace App;


class UserLogin
{

    public $m_userfiled = array('uid','headerimg','username');
    //cookie 名
    public $m_cookie_name = 'itopia_user';

    //获取当前登录信息
    function userinfo()
    {
        //echo 'okkkk';exit();
        //Session::init();

        $last_data = array();

        foreach ($this->m_userfiled as $v)
        {
            $res = Session::read($v);
            if (!empty($res))
            {
                $last_data[$v] = $res;
            }
        }

        if (empty($last_data))
        {
            $last_data = $this->getUserCookie();
            if (!empty($last_data))
            {
                $this->setUserinfo($last_data);
            }
        }
        return $last_data;
    }

    function setUserinfo($data)
    {
        //print_r($data);
        //Session::init();
        foreach ($data as $key=>$v)
        {
            $res = Session::write($key,$v);
        }
        if (isset($data['uid']))
        {
            $this->setUserCookie($data['uid']);
        }
        return true;
    }

    function setUserCookie($uid)
    {
        if (!empty($uid))
        {
            $codedata = $this->encrypt($uid, "E");
            $obj = new CookieDone();
            $obj->_setCookie('uid', $uid);
            $res = $obj->_setCookie($this->m_cookie_name, $codedata);
        }
        return true;
    }


    function getUserCookie()
    {
        $obj = new CookieDone();
        $res = $obj->_getCookie($this->m_cookie_name);
        if (!empty($res))
        {
            $uid = $this->encrypt($res, "D");
            $uid = intval($uid);
            if ($uid > 0)
            {
                //获取用户信息
                $obj_user = new UserinfoModel();
                $userinfo = $obj_user->getUserInfo($uid);
                if (is_array($userinfo) && sizeof($userinfo) > 0)
                {
                    $last_user = array();
                    $last_user['uid'] = $userinfo['uid'];
                    $last_user['channel'] = $userinfo['channel'];
                    $last_user['headerimg'] = $userinfo['headerimg'];
                    $last_user['nicker'] = $userinfo['nicker'];
                    $last_user['username'] = $userinfo['username'];
                    return $last_user;
                }
            }
        }
        return false;
    }

}