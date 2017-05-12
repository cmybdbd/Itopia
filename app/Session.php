<?php
/**
 * Created by PhpStorm.
 * User: lance
 * Date: 4/9/17
 * Time: 6:21 PM
 */

namespace App;


class Session {

    private static $session_live = false; #Control register_shutdown_function call to write_close

    private function __construct() {
        self::start();
    }

    private function start() {
        //ini_set('session.gc_maxlifetime', 72000);
        //ini_set('session.cache_expire', 72000);
        //ini_set('session.gc_divisor', 10000);
        //session_set_cookie_params(0);
        //针对部分360安全浏览器识别PHPSESSID cookie有困难设置
        //if (strpos($_SERVER['HTTP_USER_AGENT'], 'haoread') !== false)
        {
            ini_set("session.name", "PHPSESSIDITOPIA");
            ini_set("session.cookie_domain", ".".Constant::$SESSION_DOMAIN);
            ini_set("session.cookie_lifetime", 3600*24*10);
        }
        session_start();
        self::$session_live = true;
    }

    static public function init() {
        if (!self::$session_live) {
            self::start();
        }
    }

    /**
     *注册session变量
     */
    static public function write($name, $value) {
        self::init();
        $_SESSION[$name] = $value;
        return (true);
    }

    static public function is_registered($name) {
        self::init();
        return (isset($_SESSION[$name]));
    }

    /**
     *注销session变量
     */
    static public function delete($name) {
        self::init();
        unset($_SESSION[$name]);
    }

    /**
     *获取session变量的值
     */
    static public function read($name, $defaultvalue = false) {
        self::init();
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        } else {
            return $defaultvalue;
        }
    }

    /**
     *判断session变量的值是否为空
     */
    static public function is_empty($name) {
        self::init();
        return (empty($_SESSION[$name]));
    }

    /**
     *Destroys all data registered to a session
     */
    static public function destroy() {
        self::init();
        $_SESSION = array();
        return session_destroy();
    }

    /**
     *Get and/or set the current session id
     */
    static public function sess_id($id = '') {
        self::init();
        if (empty($id)) {
            return session_id();
        } else {
            return session_id($id);
        }
    }
}
