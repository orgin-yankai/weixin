<?php


namespace app\model;


use think\Model;

class Article extends  Model
{
    //减少内存开销
    protected  $schema = [
            'id '=> 'int',
            'title' => 'varchar',
            'content' => 'text',
            'fenclass' => 'varchar',
            'time' => 'int',
            'browse' => 'int',
    ];
}