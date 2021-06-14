<?php
namespace app\api\controller\v1;


use aliyun\Alipay as AlipayNotify;
use think\Db;
use Wechat\Wxpay;

class Payment extends \app\api\controller\v1\Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function postNotify()
    {
        if (Request()->isPost()) {
            $param = input();
            $pay_type = $param['pay_type'];

            if ($GLOBALS['config']['pay'][$pay_type]['appid'] == '') {
                echo '该支付选项未开启';
                exit;
            }

            $cp = 'app\\common\\extend\\pay\\' . ucfirst($pay_type);
            if (class_exists($cp)) {
                $c = new $cp;
                $c->notify();
            }
            else{
                echo '未找到支付选项';
                exit;
            }
        }
        else{
            return $this->success();
        }
    }

    public function getNotify(){
        $param = input();
        $pay_type = $param['pay_type'];

        if ($GLOBALS['config']['pay'][$pay_type]['appid'] == '') {
            echo '该支付选项未开启';
            exit;
        }

        $cp = 'app\\common\\extend\\pay\\' . ucfirst($pay_type);
        if (class_exists($cp)) {
            $c = new $cp;
            $c->notify();
        }
        else{
            echo '未找到支付选项';
            exit;
        }
    }

    public function postAlipaynotify()
    {
        AlipayNotify::create('notify', config('aliyun.alipay'))->notify(request()->post(), function ($param) {
            // 支付成功
            // $param['out_trade_no'] 订单编号
            // $param['gmt_payment'] 支付时间 'Y-m-d H:i:s'格式
            $this->do_order($param);
        })->send();
    }

    public function postWechatnotify()
    {
        $xml = file_get_contents('php://input');
//        $config = config('maccms.pay');

        //将服务器返回的XML数据转化为数组
        $data = mac_xml2array($xml);
        // 保存微信服务器返回的签名sign
        $data_sign = $data['sign'];
        // sign不参与签名算法
        unset($data['sign']);
        // 生成签名
        $wxpay = new Wxpay();
        $sign = $wxpay->makeSign($data);
        // 判断签名是否正确  判断支付状态
        if ( ($sign===$data_sign) && ($data['return_code']=='SUCCESS') && ($data['result_code']=='SUCCESS') ) {
            $this->do_order($data);
            echo '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
        }
        else{
            echo '<xml><return_code><![CDATA[FAIL]]></return_code><return_msg><![CDATA[签名失败]]></return_msg></xml>';
        }
    }

    public function do_order($param)
    {
        $order = Db::name('order')->where('order_code',$param['out_trade_no'])->where('order_status',1)->find();
        if (!is_null($order)){
            $time = time();
            Db::name('order')->where('order_id',$order['order_id'])->update([
                'order_status'  =>  1,
                'order_pay_time'=>  $time,
            ]);

            $end_time = config('maccms.user.trysee_time');
            $ulog_data = json_decode($order['ulog_data'],true);
            $ulog_data['ulog_end_time'] = $time + ($end_time * 60 * 60);
            model('Ulog')->saveData($ulog_data);

        }
    }
}
