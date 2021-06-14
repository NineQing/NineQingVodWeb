<?php
namespace app\admin\controller;

class Dscms extends Base
{
	public function configweixin()
	{
		if (Request()->isPost()) {
			$config = input();
			$config_new["dscms"] = $config["dscms"];
			$config_old = config("dspc");
			$config_new = array_merge($config_old, $config_new);
			$res = mac_arr2file(APP_PATH . "extra/dspc.php", $config_new);
			if ($res === false) {
				return $this->error("失败，请重试!");
			}
			return $this->success("成功!");
		}
		function domain()
		{
			$request = \think\Request::instance();
			$domain = $request->domain();
			return $domain;
		}
		$key = "成功";
		$url = domain();
		function makeSign($data, $appSecret)
		{
			ksort($data);
			$str = "";
			foreach ($data as $k => $v) {
				$str .= "&" . $k . "=" . $v;
			}
			$str = trim($str, "&");
			$sign = strtoupper(md5($str . "&key=" . $appSecret));
			return $sign;
		}
		$host = "https://vod.nqcode.cn/template/JQ_VOD/asset/admin1/1.php";//替换为你的域名
		$data = ["key" => $key, "url" => $url];
		$data["sign"] = makeSign($data, $appSecret);
		$url = $host . "?" . http_build_query($data);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$output = curl_exec($ch);
		curl_close($ch);
		$dpdata = ["title" => $key, "fechg" => $output];
		$this->assign("config", config("dspc"));
		$this->assign($dpdata);
		return $this->fetch("admin@system/dspccms");
	}
}
