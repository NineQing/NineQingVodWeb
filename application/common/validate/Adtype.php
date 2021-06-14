<?php
namespace app\common\validate;
use think\Validate;

class Adtype extends Validate
{
    protected $rule =   [
        'typename'  => 'require|max:60',
        'tag'  => 'require|max:50',
    ];

    protected $message  =   [
        'typename.require' => '广告位名称必须',
        'typename.max'     => '广告位名称最多不能超过60个字符',
        'tag.require' => '广告位标识必须',
        'tag.max'     => '广告位标识最多不能超过60个字符',
    ];

    protected $scene = [
        'add'=> ['typename','tag'],
        'edit'=> ['typename','tag'],
    ];
}