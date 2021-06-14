function isMatch(str1) {
    var s = 'ain19.com'
    return s.indexOf(str1) !== -1;
}
var ikan = {
	browser: {
		url: document.URL,
		domain: document.domain,
		title: document.title,
		urlpath: document.location.pathname,
		language: (navigator.browserLanguage || navigator.language).toLowerCase(),
		canvas: function() {
			return !!document.createElement("canvas").getContext
		}(),
		useragent: function() {
			var a = navigator.userAgent;
			return {
				mobile: !! a.match(/AppleWebKit.*Mobile.*/),
				ios: !! a.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/),
				android: -1 < a.indexOf("Android") || -1 < a.indexOf("Linux"),
				iPhone: -1 < a.indexOf("iPhone") || -1 < a.indexOf("Mac"),
				iPad: -1 < a.indexOf("iPad"),
				trident: -1 < a.indexOf("Trident"),
				presto: -1 < a.indexOf("Presto"),
				webKit: -1 < a.indexOf("AppleWebKit"),
				gecko: -1 < a.indexOf("Gecko") && -1 === a.indexOf("KHTML"),
				weixin: -1 < a.indexOf("MicroMessenger")
			}
		}()
	},
	mobile: {
		share: function(){
		$(".open-share").click(function(){
			$(".am-share").addClass("am-modal-active");	
			if($(".sharebg").length>0){
				$(".sharebg").addClass("sharebg-active");
			}else{
				$("body").append('<div class="sharebg"></div>');
				$(".sharebg").addClass("sharebg-active");
			}
			$(".sharebg-active,.share_btn").click(function(){
				$(".am-share").removeClass("am-modal-active");	
				setTimeout(function(){
					$(".sharebg-active").removeClass("sharebg-active");	
					$(".sharebg").remove();	
				},300);
			})
	    })
		},
		xiaoshuo: function() {
			ikan.browser.useragent.weixin ? $("#xiao").after('<li><a rel="nofollow" href="https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzU4NTY2OTQ3Ng==&scene=126&bizpsid=0#wechat_redirect" target="_blank">小说</a></li>') : $("#xiao").after()
		}
	},
	swiper: function() {
		$.getScript(maccms.path + "/template/conch/js/swiper.min.js", function() {
				var swiper = new Swiper('.banner-top', {
					autoplay: 5000,
					autoplayDisableOnInteraction : false,
					speed: 1000,
					loop: true,
					slidesPerView: 5,
					centeredSlides: true,
					mousewheelControl : true,
					prevButton: '.swiper-button-prev',
                    nextButton: '.swiper-button-next',
					lazyLoading : true,
					lazyLoadingInPrevNext : true,
					runCallbacksOnInit : false,
					onInit:function() {
						setTimeout(function () {
							var Bgimgurl = $(".banner-top .swiper-slide-active a").css("backgroundImage").replace('url(','').replace(')','');
						    document.getElementById("bgimage").style.backgroundImage="url("+Bgimgurl+")";
						},1500);
					},
					onSlideChangeStart: function() {
                       	var Bgimgurl = $(".banner-top .swiper-slide-active a").css("backgroundImage").replace('url(','').replace(')','');
						document.getElementById("bgimage").style.backgroundImage="url("+Bgimgurl+")";
                    },
					breakpoints: {
                       1024: {
                          slidesPerView: 4.6,
                       },
					   820: {
                          slidesPerView: 2.5, 
                       },
                    }
				});
			    var swiper = new Swiper('.banner-wtop', {
					autoplay: 5000,
					autoplayDisableOnInteraction : false,
					loop: true,
					prevButton: '.swiper-button-prev',
                    nextButton: '.swiper-button-next',
					pagination: '.swiper-pagination',
					paginationClickable: true,
					onInit:function() {
						setTimeout(function () {
							$.adaptiveBackground.run()	
						},1500);
					},
				});
				var swiper = new Swiper('.art_banner', {
					autoplay: 5000,
					autoplayDisableOnInteraction : false,
					spaceBetween: 1,
                    speed: 1000,
					slidesPerView: 1,
					loop: true,
					prevButton: '.swiper-button-prev',
                    nextButton: '.swiper-button-next',
					pagination: '.swiper-pagination',
					paginationClickable: true,
					lazyLoading : true,
					lazyLoadingInPrevNext : true,
				});
		});
	},
	menu: function(){
		var windowWidth = $(window).width();
		if (windowWidth < 820) {
			$(".menu").click(function(){
				$('html,body').addClass("overhidden");
				$(".all_menu").addClass("menu_block");
				$(".close_menu").click(function(){
					$('html,body').removeClass("overhidden");
					$(".all_menu").removeClass("menu_block");	
				});
			});
		}else{
			$(".head_menu_b").each(function(s){
				$(this).hover(
					function(){
						$(".all_menu").eq(s).show();
					},
					function(){
						$(".all_menu").eq(s).hide();
					})
			})
		}
	},
	fixed: function(){
		if(window.location.hash){
			var targetScroll = $(window.location.hash).offset().top - 80;
			$("html,body").animate({scrollTop:targetScroll},300);
		};
		$(window).scroll(function(){
			var $this = $(this);
			var targetTop = $(this).scrollTop();
			var height = $(window).height();
			if (targetTop >= 50){
				$("#topnav,.listnow,.art_navlist").addClass("nav_fixed ai_bk");
				$("#dhgb").addClass("dhgb nav_fixed ai_bk");
				// $("#bfqxl").addClass("xiala");
				// $("#gensui").addClass("gensui");
			}else{
				$("#topnav,.listnow,.art_navlist").removeClass("nav_fixed ai_bk");
				$("#dhgb").removeClass("dhgb nav_fixed ai_bk");
				// $("#bfqxl").removeClass("xiala");
				// $("#gensui").removeClass("gensui");
			}
		});
		$(window).scroll(function(){
			var $this = $(this);
			var targetTop = $(this).scrollTop();
			var height = $(window).height();
			if (targetTop >= 800){
			    $("#bfqxl").addClass("xiala1");
			    $("#gensui").addClass("gensui1");
			    $("#gbys34").addClass("gbys34");
			}else{
				$("#bfqxl").removeClass("xiala1");
				$("#gensui").removeClass("gensui1");
				$("#gbys34").removeClass("gbys34");
			}
		})
		$(window).scroll(function(){
			var $this = $(this);
			var targetTop = $(this).scrollTop();
			var height = $(window).height();
			if (targetTop >= 1200){
				$(".ads_rbox").addClass("adfixed");
			}else{
				$(".ads_rbox").removeClass("adfixed");
			}
		})
    },
	Search: function() {
		$("input.form_control").focus(function(){
			$(".submit").addClass("search_btn");	
		});
		$("input.form_control").blur(function(){
			$(".submit").removeClass("search_btn");
		});
	},
	wrapper: function() {
		var windowWidth = $(window).width();
		if (windowWidth < 820) {
		$.getScript(maccms.path + "/template/conch/js/iscroll.js", function() {
		  // $(".wrapper").navbarscroll();
		  // $('#ik01').navbarscroll({SelectName:'.ik-n-01'});
		  // $('#ik02').navbarscroll({SelectName:'.ik-n-02'});
		  // $('#ik03').navbarscroll({SelectName:'.ik-n-03'});
		  // $('#ik04').navbarscroll({SelectName:'.ik-n-04'});
		  // $('#ik05').navbarscroll({SelectName:'.ik-n-05'});
		  // $('#ik06').navbarscroll({SelectName:'.ik-n-06'});
		})
		}
	},
	flip: function(){
		$(".flip").click(function(){
			$(".panel").slideToggle("slow");
			$(".xs1").toggle();
			$(".xs2").toggle();
		});
    },
	closebtn: function(){
		$(".close_ads_btn").click(function(){
			$("#bottom_ads").remove();
			$(".foot").removeClass("foot_stem");
		});
		$(".close_tips").click(function(){
			$("#fd_tips").remove();
		});
	},

 //   shorturl: function(){
	// 	var short = $("#short");
	// 	// 手机页面分享
	// 	var short2 = $("#short2");
	// 	// 电脑页面分享
	// 	var url2 = "https://api.weibo.com/2/short_url/shorten.json";
	// 	var app_key = $("#app_key").val();
	// 	var shareurl = $("#shareurl").val();
	// 	if (shareurl=="") {
	// 		var cmd2 = url2 + "?source=" + app_key + "&url_long=" + encodeURIComponent(ikan.browser.url);
	// 	}else{
 //           var cmd2 = url2 + "?source=" + app_key + "&url_long=" + shareurl + encodeURIComponent(ikan.browser.urlpath);
	// 	}
	// 	$.ajax({
	// 		url: cmd2,
	// 		type: "GET",
	// 		dataType: "jsonp", 
	// 		cache: false,
	// 		success: function (data, status) {
	// 			for(x in data.data.urls[0]) ;
	// 			short.append( data.data.urls[0].url_short);
	// 			short2.append( data.data.urls[0].url_short);
	// 		}
	// 	});
	// },
	
	images: {
		lazyload: function() {
			$.getScript(maccms.path + "/template/conch/js/jquery.lazyload.min.js", function() {
				$(".lazyload").lazyload({
					effect: "fadeIn",
					threshold: 200,
					failurelimit: 20,
				});
				var windowWidth = $(window).width();
				if (windowWidth < 820) {
					$(".list_scroll .vodlist_thumb").removeClass("lazyload");
					$(".list_scroll .vodlist_thumb").addClass("boxload");
					$(".boxload").lazyload({
						effect: "fadeIn",
						threshold: 150,
						failurelimit: 5,
						container: $(".vodlist_sm,.vodlist_sh")
					});
				}
			})
		},
		qrcode: function() {
			$.getScript(maccms.path + "/template/conch/js/jquery.qrcode.min.js", function() {
				$(".cans").qrcode({
					width:120,
					height:120,
					text:encodeURI(ikan.browser.url)
				});  
				function convertCanvasToImage(canvas) {  
					var image = new Image();  
					image.src = canvas.toDataURL("image/png");  
					return image;  
				}   
				var mycans=$('canvas')[0];   
				var img=convertCanvasToImage(mycans);  
				$('.qrcode').append(img); 
			})			
		}
	},
	scrolltop: function() {
		var a = $(window);
		$scrollTopLink = $("a.backtop");
		a.scroll(function() {
			500 < $(this).scrollTop() ? $scrollTopLink.css("display", "block") : $scrollTopLink.css("display", "none")
		});
		$scrollTopLink.on("click", function() {
			$("html, body").animate({
				scrollTop: 0
			}, 400);
			return !1
		})
	},
	copy: function() {
		$.getScript(maccms.path + "/template/conch/js/clipboard.min.js", function() {
			var btn=document.getElementsByClassName('copy_btn');
			var clipboard=new Clipboard(btn);
			clipboard.on('success', function(e){
				$('#show').slideDown().delay(1500).slideUp(300);
				console.log(e);
			});
			clipboard.on('error', function(e){
				$('#show').slideDown().delay(1500).slideUp(300);
				console.log(e);
			});
		})
	},
	wxqrcode: function() {
		var wx_title = $("#wx_title").val();
		var wx_qrcode = $("#wx_qrcode").val();
		var wx_text = $("#wx_text").val();
		var zans_title = $("#zans_title").val();
		var zans_qrcode = $("#zans_qrcode").val();
		var zans_text = $("#zans_text").val();
		var zans_jjtc = $("#zans_jjtc").val();
		var gg_title = $("#gg_title").val();
		var gg_qrcode =$("#gg_qrcode").val();
		var gg_text= $("#gg_text").val();
		var gg_jjtc = $("#gg_jjtc").val();
		$(".btn_wxgzh").click(function() {
            $("body").append('<div class="ikan_wrap"><div class="mac_pop_bg"></div><div class="ikan_content"><div class="ikan_content_hd"><h4 class="ikan_content_title">' + wx_title + '</h4></div><div class="ikan_content_bd"><img class="info_img" src="' + wx_qrcode + '" alt="公众号二维码"></div><div class="ikan_content_nr">' + wx_text + '</div><div class="ikan_content_ft"><a class="close_box" href="javascript:;">下次再说</a></div></div></div>');
			$(".close_box,.mac_pop_bg").click(function() {
				$(".ikan_wrap").remove();
		    });
		});
		$(".btn_zhans").click(function() {
            $("body").append('<div class="ikan_wrap"><div class="mac_pop_bg"></div><div class="ikan_content"><div class="ikan_content_hd"><h4 class="ikan_content_title">' + zans_title + '</h4></div><div class="ikan_content_bd"><img class="info_img" src="' + zans_qrcode + '" alt="赞赏二维码"></div><div class="ikan_content_nr">' + zans_text + '</div><div class="ikan_content_ft"><a class="ikan_btn_no" href="javascript:;">残忍拒绝</a><a class="close_box" href="javascript:;">取消</a></div></div></div>');
			$(".ikan_btn_no").click(function() {
				alert('' + zans_jjtc + '')
				$(".ikan_wrap").remove();
			});
			$(".close_box,.mac_pop_bg").click(function() {
				$(".ikan_wrap").remove();
		    });
		});
		$(".ggzu").click(function(){
		    $("body").append('<div class="ikan_wrap"><div class="mac_pop_bg"></div><div class="ikan_content"><div class="ikan_content_hd"><h4 class="ikan_content_title">' + gg_title + '</h4></div><div class="ikan_content_bd"><img class="info_img" src="' + gg_qrcode + '" alt="广告咨询"></div><div class="ikan_content_nr">' + gg_text + '</div><div class="ikan_content_ft"><a class="ikan_btn_no" href="javascript:;">咨询广告</a><a class="close_box" href="javascript:;">稍后联系</a></div></div></div>');
		    $(".ikan_btn_no").click(function() {
				window.open('' + gg_jjtc + '')
				$(".ikan_wrap").remove();
			});
		    $(".close_box,.mac_pop_bg").click(function() {
				$(".ikan_wrap").remove();
		    });
		});
	}
};
$(document).ready(function() {
	ikan.browser.useragent.mobile && (ikan.mobile.share(), ikan.mobile.xiaoshuo());
	ikan.swiper();
	ikan.menu();
	ikan.fixed();
	ikan.Search();
	ikan.wrapper();
	ikan.flip();
	ikan.closebtn();
	// ikan.shorturl();
	ikan.images.lazyload();
	ikan.images.qrcode();
	ikan.scrolltop();
	ikan.copy();
	ikan.wxqrcode();
});
