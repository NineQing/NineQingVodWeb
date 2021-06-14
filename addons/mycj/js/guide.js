function is_wap(){
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        return true;
    } else {
        return false;
    }	
}
if (comm.cookie.get('guide')!=1 && !is_wap()) {
	var enjoyhint_instance = new EnjoyHint({});
	var enjoyhint_script_steps = [{
		'next #mycjv10': '欢迎使用萌芽采集插件！<br>让我来引导你了解它的特点。',
		'skipButton': {
			className: "mySkip",
			text: "不了!"
		},
		'nextButton': {
			className: "myNext",
			text: "好的"
		}
	}, {
		'next #step1': '如果你是第一次使用本插件，<br>建议看一遍视频操作教程！',
		'skipButton': {
			className: "myNext",
			text: "跳过"
		},
		'nextButton': {
			className: "myNext",
			text: "下一步"
		},
	}, {
		'next #step2': '采集后，关于播放视频的一些问题，都写在了这里！',
		'skipButton': {
			className: "myNext",
			text: "跳过"
		},
		'nextButton': {
			className: "myNext",
			text: "下一步"
		},
	}, {
		'next .addzyz': '如果你有比较好的资源站，也可以分享提交给我们加入到插件中！',
		'skipButton': {
			className: "myNext",
			text: "跳过"
		},
		'nextButton': {
			className: "myNext",
			text: "下一步"
		},
	}, {
		'next .zhuanqu': '本插件收集整理了多个资源站<br>下方还有多个专区<br>点击即可展开查看更多资源站！',
		'skipButton': {
			className: "myNext",
			text: "跳过"
		},
		'nextButton': {
			className: "myNext",
			text: "下一步"
		},
	}, {
		'next .dataurl': '选中资源站后，点击进入，可以查看资源列表<br>进去之后，首先要绑定分类',
		'skipButton': {
			className: "myNext",
			text: "跳过"
		},
		'nextButton': {
			className: "myNext",
			text: "下一步"
		},
	}, {
		'next .cjall': '绑定分类后，就可以开始采集全部资源',
		'skipButton': {
			className: "myNext",
			text: "跳过"
		},
		'nextButton': {
			className: "myNext",
			text: "下一步"
		},
	}, {
		'next .players': '视频采集好后，记得配置播放器',
		'skipButton': {
			className: "myNext",
			text: "跳过"
		},
		'nextButton': {
			className: "myNext",
			text: "下一步"
		},
	}, {
		'next .duandian': '如果采集过程中退出了<br>可以用这里的断点采集',
		'skipButton': {
			className: "myNext",
			text: "跳过"
		},
		'nextButton': {
			className: "myNext",
			text: "下一步"
		},
	}, {
		'next .alljx': '这里可以对播放器批量修改设置接口',
		'skipButton': {
			className: "myNext",
			text: "跳过"
		},
		'nextButton': {
			className: "myNext",
			text: "下一步"
		},
	}, {
		'next .pic-slide': '这里可以查找一些视频幻灯大图，省去你找幻灯图的烦恼！',
		'skipButton': {
			className: "myNext",
			text: "跳过"
		},
		'nextButton': {
			className: "myNext",
			text: "下一步"
		},
	}, {
		'next .searchwd': '这里还可以一键搜索多个资源站的影片<br>比如某个新片更新了，有的资源站更新较快<br>你用这个功能就可以搜索到更新了',
		'skipButton': {
			className: "myNext",
			text: "跳过"
		},
		'nextButton': {
			className: "myNext",
			text: "下一步"
		},
	}, {
		'next #user': '以上介绍的功能中，部分需要VIP版才能使用<br>这里你登陆验证成功后，即可使用VIP版功能',
		'skipButton': {
			className: "myNext",
			text: "跳过"
		},
		'nextButton': {
			className: "myNext",
			text: "下一步"
		},
	}, {
		'click .qqlink': '更详细的教程，请观看采集插件视频使用教程<br>你也可以选择加入交流群，获取更多帮助！<br>如果发现BUG，欢迎您的反馈！',
		'skipButton': {
			className: "myNext",
			text: "好的"
		}
	}];
	enjoyhint_instance.set(enjoyhint_script_steps);
	enjoyhint_instance.run();
	comm.cookie.set('guide',1,30);
}
