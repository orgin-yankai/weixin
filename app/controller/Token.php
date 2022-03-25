<?php
namespace app\controller;
use think\facade\Cache;
use think\facade\Request;

class Token
{
    public const token = 'yankai';

    public function index()
    {
        //验证来自微信的服务器
            if(Request::isGet()){
                $signature = Request::param("signature");
                $timestamp = Request::param("timestamp");
                $nonce = Request::param("nonce");

                $tmpArr = [self::token,$timestamp,$nonce];
                sort($tmpArr,SORT_STRING);
                $tmpStr =implode($tmpArr);
                $tmpStr = sha1($tmpStr);
                if($tmpStr == $signature) {
                    echo Request::param('echostr');
                    exit;
                }
            }
                    $this->responseMsg();

    }



                public  function responseMsg(){
                        $postObj = $this->xmlObject();;
                        $tpl= $this->xmlUserTmp();
                        $result = '';
                        switch ($postObj -> MsgType){
                            case  'event':
                                $result =  $this->responseEvent($postObj);
                                break;
                            case  'text':
                                $result = $this->keyWord($postObj->Content);
                                break;
                            default:
                                $result = sprintf($tpl, $postObj->FromUserName, $postObj->ToUserName, time(),'text',"请输入文本，非对象！！！");
                                break;
                        }
                        echo $result;
               }


               //用户回复的关键字
               public function  keyWord($word){
                   $postObj = $this->xmlObject();
                   $tpl = $this->xmlUserTmp();
                   $result = '';
                    switch ($word){
                        case  'php':
                            $content = "请点击以下链接：".PHP_EOL."<a href='https://www.runoob.com/php/php-ref-simplexml.html'>https://www.runoob.com/php/php-ref-simplexml.html</a>";
                            $result  = sprintf($tpl, $postObj->FromUserName, $postObj->ToUserName, time(),'text',$content);
                            break;
                        case   'javascript':
                            $content = "请点击以下链接：".PHP_EOL."<a href='https://www.runoob.com/js/js-tutorial.html'>https://www.runoob.com/js/js-tutorial.html</a>";
                            $result  = sprintf($tpl, $postObj->FromUserName, $postObj->ToUserName, time(),'text',$content);
                            break;
                        case   'thinkphp':
                            $content = "请点击以下链接：".PHP_EOL."<a href='https://www.kancloud.cn/manual/thinkphp6_0/1037479'>https://www.kancloud.cn/manual/thinkphp6_0/1037479</a>";
                            $result  = sprintf($tpl, $postObj->FromUserName, $postObj->ToUserName, time(),'text',$content);
                            break;
                        case   'linux':
                            $content = "请点击以下链接：".PHP_EOL."<a href='https://www.runoob.com/linux/linux-tutorial.html'>https://www.runoob.com/linux/linux-tutorial.html</a>";
                            $result  = sprintf($tpl, $postObj->FromUserName, $postObj->ToUserName, time(),'text',$content);
                            break;
                        case   'git':
                            $content = "请点击以下链接：".PHP_EOL."<a href='https://www.runoob.com/git/git-tutorial.html'>https://www.runoob.com/git/git-tutorial.html</a>";
                            $result  = sprintf($tpl, $postObj->FromUserName, $postObj->ToUserName, time(),'text',$content);
                            break;
                        default:
                            $tpl= $this->xmlUserTmp();
                            $result = sprintf($tpl, $postObj->FromUserName, $postObj->ToUserName, time(),'text','请输入以下关键词:'.PHP_EOL.'php、javascript、thinkphp、linux、git或其他进行查看文章');
                            break;
                    }
                    return $result;
               }


             // 事件的关注与取消
            public function  responseEvent($postObj)
            {
                $content = '';
                switch ($postObj->Event) {
                    case  'subscribe':
                        $content = '欢迎关注我们微信公众号！！！';
                        break;
                    case  'unsubscribe';
                        $content = '';
                        break;
                }
                $tpl = $this->xmlUserTmp();

               return  $resultStr = sprintf($tpl, $postObj->FromUserName, $postObj->ToUserName, time(),'text',$content);
            }

            //用户回复消息
            public function  responseText($postObj){
                $tpl= $this->xmlUserTmp();
                return sprintf($tpl, $postObj->FromUserName, $postObj->ToUserName, time(),'text','请输入关键词php、javascript、thinkphp、linux、git或其他进行查看文章'.$postObj->Content);
            }





            public function  xmlObject(){
                //获取POST数据
                $postStr = file_get_contents("php://input");
                //用SimpleXML解析POST过来的XML数据
                $postObj = simplexml_load_string($postStr);
                Cache::set('name',$postStr);
                return $postObj;
            }


            //用户回复消息模板
            public  function xmlUserTmp(){

                $textTpl = "
                            <xml><ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            </xml>";
                return $textTpl;
            }



}








