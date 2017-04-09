<?php
/*
 *  微信授权
*/
namespace App;
class WeiXinAuth extends ApiHandle
{
    //基础链接
    public $m_baseurl = 'https://api.weixin.qq.com/';
    //测试
    public $m_client_id = 'wx477af15527597952';
    public $m_client_secret = 'e7497caa77d6912cbd648874754973ad';
    //授权地址
    public $m_authorizeURL = 'https://open.weixin.qq.com/connect/oauth2/authorize';
    public $m_accessTokenURL = 'https://api.weixin.qq.com/sns/oauth2/access_token';
    //
    function getAuthorizeURL($url)
    {
        $params = array();
        $params['appid'] = $this->m_client_id;
        $params['redirect_uri'] = $url;
        $params['response_type'] = 'code';
        $params['scope'] = 'snsapi_userinfo';
        $params['state'] = 'haoread';
        //$params['display'] = 'page';
        return $this->m_authorizeURL. "?" . http_build_query($params);
    }
    function getAccessToken($code,$url = "")
    {
        $params = array();
        $params['appid'] = $this->m_client_id;
        $params['secret'] = $this->m_client_secret;
        $params['grant_type'] = 'authorization_code';
        $params['code'] = $code;
        //echo $url;
        $params['redirect_uri'] = $url;


        $response = $this->httpGet($this->m_accessTokenURL.'?'.http_build_query($params));//($this->m_accessTokenURL, 'POST', $params);
        //var_dump($response);
        $token = json_decode($response, true);
        //var_dump($token);
        if ( !is_array($token) || isset($token['error']) )
        {
            return false;
        }
        return $token;
    }
    
    //获取用户信息
    function getUserInfo($token,$openid)
    {
        //https://api.weibo.com/2/users/show.json
        $url = $this->m_baseurl.'sns/userinfo';
        $url .='?access_token='.$token.'&openid='.$openid;
        //access_token=YOUR_ACCESS_TOKEN&oauth_consumer_key=YOUR_APP_ID&openid=YOUR_OPENID
        echo $url;
        $res_data = $this->httpGet($url);
        var_dump($res_data);
        if ($res_data === false)
        {
            return false;
        }
        $data = json_decode($res_data, true);

        if ( !is_array($data) || isset($data['error']) )
        {
            return false;
        }
        return $data;
    }
}
