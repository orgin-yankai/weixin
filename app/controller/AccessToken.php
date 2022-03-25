<?php


namespace app\controller;


use think\facade\Cache;
use think\cache\driver\Redis;
class AccessToken
{
    public function  getCurl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $out = curl_exec($ch);
        curl_close($ch);
        return $out;
    }
    //access_token的获取
    public function  getAccessToken(){
        $url = "https://api.weixin.qq.com/cgi-bin/token?";
        $arr = [
            'grant_type' => 'client_credential',
            'appid' => 'wxe6b173dfe6848600',
            'secret' => '0060672689dd9c0eeb738acd49c38110',
        ];
        $jsonOut = $this->getCurl($url.http_build_query($arr));
        $jsonArr = json_decode($jsonOut,true);
        echo $jsonArr['access_token'];
//        return $jsonArr;
        //保存至缓存
//        Cache::set('access_token',$jsonArr['access_token']);
//        Cache::set('expires_in',$jsonArr['expires_in']);
    }


//    public function getAccessTokenCache(){
//       dump(['access_token'=>Cache::get('access_token'),'expires_in'=>Cache::get('expires_in')]);
//    }

}