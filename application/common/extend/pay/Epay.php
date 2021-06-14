<?php
namespace app\common\extend\pay;

use EpayExtend\EpayNotify;
use EpayExtend\EpaySubmit;
use think\Exception;

class Epay {

    public $name = '易支付1';
    public $ver = '1.0';

    private $config;
    public function __construct() {

    }

    public function submit($user,$order,$param){
        $pay_type = 1;
        if(!empty($param['paytype'])){
            $pay_type = intval($param['paytype']);
        }
        
        /**************************请求参数**************************/
        $notify_url = $GLOBALS['http_type'] . $_SERVER['HTTP_HOST'] . '/api.php/v1.payment/notify/pay_type/epay';
        //需http://格式的完整路径，不能加?id=123这类自定义参数        //页面跳转同步通知页面路径
        $return_url = $GLOBALS['http_type'] . $_SERVER['HTTP_HOST'] . '/api.php/v1.payment/notify/pay_type/epay';
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/        //商户订单号
        $out_trade_no = $order['order_code'];
        //商户网站订单系统中唯一订单号，必填
        //支付方式
        $pay_type = $GLOBALS['config']['pay']['epay']['type'];
        $pay_type = explode(',', $pay_type);
        $pay_type = $pay_type[0];

        if ($pay_type == 1){
            $type = 'wxpay';
        }elseif ($pay_type == 2){
            $type = 'alipay';
        }elseif($pay_type == 3){
            $type = 'qqpay';
        }else{
            throw new Exception('不支持的支付方式');
        }

        //商品名称
        $name = '积分充值（UID：'.$user['user_id'].'）';
        //付款金额
        $money = sprintf("%.2f",$order['order_price']);;
        //站点名称
        $sitename = '318hb视频';
        //必填        //订单描述
        /************************************************************/
        $alipay_config['partner'] = $GLOBALS['config']['pay']['epay']['appid'];
        $alipay_config['key'] = $GLOBALS['config']['pay']['epay']['appkey'];
        $alipay_config['sign_type']    = strtoupper('MD5');
        $alipay_config['input_charset']= strtolower('utf-8');
        $alipay_config['transport'] = $GLOBALS['http_type'];
        $alipay_config['apiurl'] = $GLOBALS['config']['pay']['epay']['apiurl'];
//构造要请求的参数数组，无需改动
        $parameter = array(
            "pid" => trim($GLOBALS['config']['pay']['epay']['appid']),
            "type" => $type,
            "notify_url"	=> $notify_url,
            "return_url"	=> $return_url,
            "out_trade_no"	=> $out_trade_no,
            "name"	=> $name,
            "money"	=> $money,
            "sitename"	=> $sitename
        );


        //建立请求
        $alipaySubmit = new EpaySubmit($alipay_config);

        $html_text = $alipaySubmit->buildRequestForm($parameter);
        echo $html_text;
    }

    public function notify(){
        $alipay_config['partner'] = $GLOBALS['config']['pay']['epay']['appid'];
        $alipay_config['key'] = $GLOBALS['config']['pay']['epay']['appkey'];
        $alipay_config['sign_type']    = strtoupper('MD5');
        $alipay_config['input_charset']= strtolower('utf-8');
        $alipay_config['transport'] = $GLOBALS['http_type'];
        $alipay_config['apiurl'] = $GLOBALS['config']['pay']['epay']['apiurl'];

        //计算得出通知验证结果
        $alipayNotify = new EpayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();
        if($verify_result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代


            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

            //商户订单号

            $out_trade_no = $_GET['out_trade_no'];

            //数掘科技支付交易号

            $trade_no = $_GET['trade_no'];

            //交易状态
            $trade_status = $_GET['trade_status'];

            //支付方式
            $type = $_GET['type'];


            if ($_GET['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
                //如果有做过处理，不执行商户的业务程序
                $res = model('Order')->notify($out_trade_no,'epay');
                if($res['code'] >1){
                    echo 'fail"'; exit;
                }
                else {
                    echo 'success'; exit;
                }
                //注意：
                //付款完成后，支付宝系统发送该交易状态通知
            }

            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

            echo "success";	   exit;	//请不要修改或删除

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
        else {
            //验证失败
            echo "fail";   exit;
        }
    }




}