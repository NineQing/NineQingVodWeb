<?php
namespace app\common\validate;
use think\Validate;

class Message extends Validate
{
    protected $rule =   [
        'title'  => 'require|max:50',
        'create_date'  => 'require',
        'content'  => 'require',
    ];

    protected $message  =   [
        'title.require' => '名称必须',
        'title.max'     => '名称最多不能超过50个字符',
        'create_date.require' => '日期必须提供',
        'content.require' => '内容必须',
    ];

    protected $scene = [
        'add'=> ['name','tag'],
        'edit'=> ['name','tag'],
    ];
}