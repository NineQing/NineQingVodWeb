<?php
namespace app\common\extend\sms;


class WebChinese {

    public $name = '网建短信通';
    public $ver = '1.0';

    public function submit($phone,$code,$type_flag,$type_des='',$text='')
    {
        if(empty($phone) || empty($code) || empty($type_flag)){
            return ['code'=>101,'msg'=>'参数错误'];
        }

        $appkey = $GLOBALS['config']['sms']['appkey'];
        $appid = $GLOBALS['config']['sms']['appid'];
        $tpl = $GLOBALS['config']['sms']['tpl_code_'.$type_flag];
        // $params = [
        //     $code
        // ];

        try {
            // $ssender = new SmsSingleSender($appid, $appkey);
            // //$result = $ssender->send(0, "86", $phone, '【'.$sign.'】'.$text, "", "");
            // $result = $ssender->sendWithParam("86", $phone, $tpl, $params, $sign, "", "");
            //
            // $rsp = json_decode($result,true);


            $url = "http://utf8.api.smschinese.cn/?Uid=".$appid."&Key=".$appkey."&smsMob=".$phone."&smsText=".'你的注册验证码为：'.$code.'，5分钟后失效,请及时验证！';
            $res = mac_curl_get($url);

            if ($res>0) {
                return ['code'=>1,'msg'=>'ok'];
            } else {
                //请求异常
                return ['code'=>102,'msg'=>'发生异常请重试'];
            }
        }
        catch(\Exception $e) {
            return ['code'=>102,'msg'=>'发生异常请重试'];
        }
    }


}
