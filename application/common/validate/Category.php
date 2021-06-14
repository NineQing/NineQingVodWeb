<?php
namespace app\common\validate;
use think\Validate;

class Category extends Validate
{
    protected $rule =   [
        'cat_name'  => 'require|max:30',

    ];

    protected $message  =   [
        'cat_name.require' => '名称必须',
        'cat_name.max'     => '名称最多不能超过30个字符',
    ];

    protected $scene = [
        'add'=> ['topic_name'],
        'edit'=> ['topic_name'],
    ];
}