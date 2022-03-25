<?php
namespace app\Api\controller;

use app\BaseController;
use think\facade\Log;
use think\facade\Request;
class Send extends BaseController
{
    /**
     * 接收消息
     * @author Why
     * @return array $resArr 返回结果
     */
    public function recMsg(){
        //接收微信发送的XML数据包
        $postObj =  file_get_contents("php://input");
        // Log::write('postObj:'.$postObj);
        //解析XML数据包为数组格式:SimpleXMLElement::__set_state(array())
        $postArr = simplexml_load_string($postObj);
        // Log::write('postArr:'.$postArr);
        //获取数组中用户发送的内容
        $content = $postArr->Content;

        //将获取的内容转换为普通数组，方便以后的业务逻辑编写
        $jsonStr = json_encode($content);
        $resArr  = json_decode($jsonStr,true);

        return $resArr;
    }

    /**
     * 回复消息
     * @author Why
     * @param  string $content  回复内容
     * @return xml    $resMsg   返回结果
     */
    public function resTextMsg($content)
    {
        //接收微信发送的XML数据包
        $postObj =  file_get_contents("php://input");

        //解析XML数据包为数组格式:SimpleXMLElement::__set_state(array())
        $postArr = simplexml_load_string($postObj, "SimpleXMLElement", LIBXML_NOCDATA);

        //获取数组中的ToUserName
        $toUserName = $postArr->ToUserName;

        //获取数组中的FromUserName
        $fromUserName = $postArr->FromUserName;

        //config辅助函数调用config/extend目录下的回复消息格式
        $text = '<xml>
                      <ToUserName><![CDATA[%s]]></ToUserName>
                      <FromUserName><![CDATA[%s]]></FromUserName>
                      <CreateTime>'.time().'</CreateTime>
                      <MsgType><![CDATA[text]]></MsgType>
                      <Content><![CDATA[%s]]></Content>
               </xml>';
        $tempText = config($text);
        Log::write($tempText);
        //依次替换XML数据包模板中的%s
        $resMsg = sprintf($tempText, $fromUserName, $toUserName, $content);

        return $resMsg;
    }

    /**
     * @author Why
     * @param  Request    $request 请求对象
     * @return xml|string $resMsg
     */
    public function index(Request $request){
        // $data = file_get_contents("php://input");
        // Log::write($request::post());
        // Log::write($data);
        $echoStr = $request::param('echostr');
        // Log::write($request::param());
        //随机字符串$echostr不为空
        if($echoStr&&$this->isWechat($request)){
            //校验微信公众号

            echo $echoStr;
            exit;

        }

        //随机字符串$echostr为空，接收消息
        $content = $this->recMsg($request);

        //将数组转换为字符串
        $conStr = implode($content);
        Log::write($conStr);
        //字符串拼接
        $resStr = '您说：'.$conStr;

        //回复消息
        $resMsg = $this->resTextMsg($resStr);
        return $resMsg;
    }

    /**
     * 校验微信公众号
     * @author Why
     * @param  Request $request 请求对象
     * @return string          校验结果
     */
    public function isWechat($request)
    {
        //Token
        $token = 'yankai';

        //获取签名
        $signature = $request::param('signature');

        //获取随机字符串
        // $echostr   = $request::param('echostr');

        //获取时间戳
        $timestamp = $request::param('timestamp');

        //获取随机数
        $nonce     = $request::param('nonce');

        //1）将token、timestamp、nonce三个参数进行字典序排序
        $array = array($timestamp, $nonce, $token);
        sort($array);

        //2）将三个参数字符串拼接成一个字符串进行sha1加密
        $temp = implode($array);
        $temp = sha1($temp);
        // Log::write($temp.'-'.$signature);
        //3）开发者获得加密后的字符串可与signature对比，标识该请求来源于微信
        if($temp === $signature)
        {
            // Log::write($echostr);
            return true;
        }else{
            return false;
        }
    }

}