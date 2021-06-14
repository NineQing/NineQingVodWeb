<?php
namespace app\common\validate;
use think\Validate;

class GroupChat extends Validate
{
    protected $rule =   [
        'title'  => 'require|max:50',
        'url'  => 'require',
    ];

    protected $message  =   [
        'title.require' => '名称必须',
        'title.max'     => '名称最多不能超过50个字符',
        'url.require' => '地址必须',
    ];

    protected $scene = [
        'add'=> ['name','tag'],
        'edit'=> ['name','tag'],
    ];
}