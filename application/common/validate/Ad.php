<?php
namespace app\common\validate;
use think\Validate;

class Ad extends Validate
{
    protected $rule =   [
        'title'  => 'require|max:100',
        'url'  => 'require',
        'litpic' => 'require'
    ];

    protected $message  =   [
        'title.require' => '广告名称必须',
        'title.max'     => '广告名称最多不能超过100个字符',
        'url.require' => '广告位URL必须',
        'litpic.require' => '请上传图片'
    ];

    protected $scene = [
        'add'=> ['typename','url','litpic'],
        'edit'=> ['typename','url','litpic'],
    ];
}