<?php
namespace app\common\validate;
use think\Validate;

class Youxi extends Validate
{
    protected $rule =   [
        'name'  => 'require|max:50',
        'img'  => 'require|max:200',
        'url'  => 'require|max:500',
    ];

    protected $message  =   [
        'name.require' => '直播名称必须',
        'name.max'     => '直接名称最多不能超过50个字符',
        'img.require' => '直播图片必须',
        'img.max'     => '直播图片最多不能超过200个字符',
        'url.require' => '直播地址必须',
        'url.max'     => '直播地址最多不能超过200个字符',
    ];

    protected $scene = [
        'add'=> ['name','tag'],
        'edit'=> ['name','tag'],
    ];
}