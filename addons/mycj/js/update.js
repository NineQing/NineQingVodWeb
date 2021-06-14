var downurl = 'http://caiji-api.oss-accelerate.aliyuncs.com/V10/maccmsv10-collect.zip';
var d_url = 'https://www.lanzous.com/i8bmzzg';
var update = {
	'vers': 'v10.3.1',
	'init': function () {
		if (verv10 == this.vers) {
			layer.alert('当前已经是最新版了，无需更新！');
		} else {
			var output = '<ul>';
			output += '<li class="layui-text">2019-12-28 更新日志</li>';
			output += '<li class="layui-text">1、优化插件资源站列表加载速度</li>';
			output += '<li class="layui-text">2、去掉新手引导，加快列表加载速度</li>';
			output += '<li class="layui-text">3、“采集全部”支持多线程采集</li>';
			output += '<li class="layui-text">4、优化“加入收藏”功能</li>';
			output += '</ul>';
			layer.confirm(output, {
				area: '300px',
				title: '最新版本：' + this.vers,
				btn: ['立即升级', '取消']
			}, function () {
				var index = layer.msg('正在更新，请稍等片刻...', { icon: 16, time: false });
				$.ajax({
					url: 'update.php?name=' + my.name,
					type: 'POST',
					data: { downurl: downurl },
					dataType: 'json',
					success: function (res) {
						if (res.code == '200') {
							layer.alert(res.msg, { title: '更新成功', icon: 6, closeBtn: 0 }, function (index) {
								location.reload();
							});
						} else {
							layer.alert(res.msg, { title: '更新失败，请手动离线安装包覆盖更新！', icon: 5, closeBtn: 0 }, function (index) {
								top.location.href = d_url;
							});
						}
					},
					error: function (res) {
						layer.alert(res.msg, { title: '更新失败，请手动离线安装包覆盖更新！', icon: 5, closeBtn: 0 }, function (index) {
							top.location.href = d_url;
						});
					}
				});
			});
		}
	},
	'install': function () {
		var index = layer.msg('正在安装中，请稍后...', { icon: 16, time: false });
		$.ajax({
			url: 'update.php?name=' + my.name,
			type: 'POST',
			data: { downurl: downurl },
			dataType: 'json',
			success: function (res) {
				if (res.code == '200') {
					layer.alert('安装成功！', { icon: 6, closeBtn: 0 }, function (index) {
						location.reload();
					});
				} else {
					layer.alert('下载远程插件失败，请手动下载插件，并上传到 /addons/mycj/ 覆盖！', { icon: 5, closeBtn: 0 }, function (index) {
						top.location.href = d_url;
					});
				}
			},
			error: function (res) {
				layer.alert('安装程序执行失败！请手动离线安装包覆盖更新！', { icon: 5, closeBtn: 0 }, function (index) {
					top.location.href = d_url;
				});
			}
		});
	}
}
