<?php


namespace app\controller;


class WeixinIp
{
    //微信服务器ip地址
    public function  ip(){
        $url = 'https://api.weixin.qq.com/cgi-bin/get_api_domain_ip?';
        $accessToken = new AccessToken();
        $data = $accessToken ->getAccessToken();
        $arr =[
            'access_token' => (function($data){
                return $data['access_token'];
            })($data),
        ];
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url.http_build_query($arr));
        //设置头文件的信息作为数据流输出
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //抓取数据
        $result=curl_exec($ch);
        $jsonArr = json_decode($result,true);
        curl_close($ch);
        return $jsonArr;
    }
     //微信callback IP地址
    public function  callbackIP(){
        $url = 'https://api.weixin.qq.com/cgi-bin/getcallbackip?';
        $accessToken = new AccessToken();
        $data = $accessToken ->getAccessToken();
        $arr =[
            'access_token' => (function($data){
                return $data['access_token'];
            })($data),
        ];
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url.http_build_query($arr));
        //设置头文件的信息作为数据流输出
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //抓取数据
        $result=curl_exec($ch);
        $jsonArr = json_decode($result,true);
        curl_close($ch);
        return $jsonArr;
    }
}