<?php
namespace app\api\controller\v1;
use think\captcha\Captcha;
use think\config;
use think\console\command\make\Controller;

class Verify extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($id='')
    {
        ob_end_clean();
        $captcha = new Captcha((array)Config::get('captcha'));
        return $captcha->entry($id);
    }

    public function check($verify,$id='')
    {
        if(!captcha_check($verify)){
            return 0;
        }
        else{
            return 1;
        }
    }

}
