<?php
namespace app\controller;

use app\BaseController;
use app\model\Article;
use think\facade\Request;
use think\facade\View;

class Index extends BaseController
{
    /**
     * 首页
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
   public function  index(){
       $result = Article::order('time desc')->limit(3)->select()->toArray();
       View::assign('result',$result);
       //首页阅读排行榜
       View::assign('read', $this->read());
       return  View::fetch();

   }

    /**
     * 来自某个关键字 进行显示页面
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function   keyword(){
       $name=Request::param(trim('name'));
        $result = Article::where('fenclass',$name)->order('time asc')->limit(0,3)->select()->toArray();
        View::assign('result',$result);

        //获取标签
        View::assign('tag',$name);
        //阅读排行榜
        View::assign('read',$this->read());


        return  View::fetch();

    }

    /**
     * 阅读排行榜
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public  function read(){
        return  Article::order('browse desc')->limit(6)->select()->toArray();
    }


    /**
     * 查看文章
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public  function  article(){
       $id = Request::param('id');
       $result =Article::where('id',$id)->find()->toArray();
       View::assign('result',$result);
       View::assign('read',$this->read());
       return View::fetch();
    }


    /**
     * 分页
     * @param $name 标签类型
     * @param $pageNum  当前页
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function  page(){
        $name=Request::param(trim('tag'));
        $page = Request::param('pageNum');
       //计算总页数
        $totle = Article::where('fenclass',$name)->count();
        $totle  = ceil($totle)/3;

        if(empty($page)){
            $pageNum = 1;
        }
        //计算当前页
        $pageNum = ($page-1)*3;

//       if($pageNum == 0 || $pageNum == $totle){
//           //($pageNum-1)*3   等于 当前页
//           $result = Article::where('fenclass',$name)->order('time asc')->limit($pageNum,3)->select()->toArray();
//
//       }
        $result = Article::where('fenclass',$name)->order('time asc')->limit($pageNum,3)->select()->toArray();
       View::assign('result',$result);
        View::assign('tag',$name);
        //阅读排行榜
        View::assign('read',$this->read());

        //总页
        View::assign('totle',$totle);
        //当前页
        View::assign('page',$page);
        return View::fetch();
    }

}
