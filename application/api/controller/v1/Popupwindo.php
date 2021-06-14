<?php

namespace app\api\controller\v1;

class Popupwindo extends Base {

    public function getIndex(){

        $type = input('type');
        $config = config('app');
        $res = null;
        if ($type == 'un_register'){
            $res = $config['popupwindo'][0];
        }elseif($type == 'registerd'){
            $res = $config['popupwindo'][1];
        }elseif($type == 'notice'){
            $res = $config['popupwindo'][2];
        }

        $data = null;
        if ($res){
            if ($res['status'] == 1){
                $data = $res;
            }
        }

        return $this->success($data);
    }



}