<?php

namespace app\api\controller\v1;

class Sign extends Base {

    public function postIndex(){
        $this->checkLogin();
        $res = model('Sign')->saveData();

        if ($res['code'] == 1){
            return $this->success(['score'=>$res['score']]);
        }else{
            return $this->error($res['msg'], $res['code']);
        }
        return $this->success();
    }



}