<?php

/**
 *
 *                      .::::.
 *                    .::::::::.            | 
 *                    :::::::::::           | 
 *                 ..:::::::::::'           |  
 *             '::::::::::::'               | 
 *                .::::::::::               | DATETIME: 2019/10/16
 *           '::::::::::::::..
 *                ..::::::::::::.
 *              ``::::::::::::::::
 *               ::::``:::::::::'        .:::.
 *              ::::'   ':::::'       .::::::::.
 *            .::::'      ::::     .:::::::'::::.
 *           .:::'       :::::  .:::::::::' ':::::.
 *          .::'        :::::.:::::::::'      ':::::.
 *         .::'         ::::::::::::::'         ``::::.
 *     ...:::           ::::::::::::'              ``::.
 *   ```` ':.          ':::::::::'                  ::::..
 *                      '.:::::'                    ':'````..
 *
 */

namespace app\admin\controller;


class Appsetting extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (Request()->isPost()) {
            $config = input();
            $config_new['app_setting'] = $config['app_setting'];

            $config_old = config('maccms');
            $config_new = array_merge($config_old, $config_new);

            $res = mac_arr2file(APP_PATH . 'extra/maccms.php', $config_new);
            if ($res === false) {
                return $this->error('保存失败，请重试!');
            }
            return $this->success('保存成功!');
        }

        $this->assign('config', config('maccms'));
        return $this->fetch('admin@appsetting/index');
    }
}