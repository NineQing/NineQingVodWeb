<?php
namespace app\common\extend\sms;


class Sms978w {

    public $name = '978w';
    public $ver = '1.0';

    public function submit($phone,$code,$type_flag,$type_des='',$text='')
    {
        if(empty($phone) || empty($code) || empty($type_flag)){
            return ['code'=>101,'msg'=>'参数错误'];
        }

        $appkey = $GLOBALS['config']['sms']['appkey'];
        $sign = $GLOBALS['config']['sms']['sign'];
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


            $url = "http://api.978w.cn/yzmsms/index";
            $params = array(
                'appkey'   => $appkey, //您申请的APPKEY
                'phone'    => $phone, //接受短信的用户手机号码
                'moban'    => $tpl, //您申请的短信模板ID，根据实际情况修改
                'code' => $code,
                'app' => '萝卜视频',
            );

            $paramstring = http_build_query($params);
            $content = self::juheCurl($url, $paramstring);
            $result = json_decode($content, true);
            if ($result) {
                // var_dump($result);
                if($result['status'] == '200'){
                    return ['code'=>1,'msg'=>'ok'];
                }else{
                    return ['code'=>101,'msg'=>$result['reason']];
                }
            } else {
                //请求异常
                return ['code'=>102,'msg'=>'发生异常请重试'];
            }
        }
        catch(\Exception $e) {
            return ['code'=>102,'msg'=>'发生异常请重试'];
        }
    }

    /**
     * 请求接口返回内容
     * @param  string $url [请求的URL地址]
     * @param  string $params [请求的参数]
     * @param  int $ipost [是否采用POST形式]
     * @return  string
     */
    function juheCurl($url, $params = false, $ispost = 0)
    {
        $httpInfo = array();
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'JuheData');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if ($ispost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            if ($params) {
                curl_setopt($ch, CURLOPT_URL, $url.'?'.$params);
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }
        $response = curl_exec($ch);
        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        curl_close($ch);
        return $response;
    }
}
