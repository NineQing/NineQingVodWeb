<?php
namespace addons\mycj;
use think\Addons;
/**
 * 萌芽采集插件
 */
class mycj extends Addons {
	/**
	 * 插件安装方法
	 * @return bool
	 */
	public function install() {
		return true;
	}

	/**
	 * 插件卸载方法
	 * @return bool
	 */
	public function uninstall() {
		return true;
	}

}
