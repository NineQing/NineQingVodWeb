$(function(){
var tc = $("#tcjs").val();
var tchttp = $("#tchttp").val();
var tctext = $("#tctext").val();
var tcimg = $("#tcimg").val();
var tchttp2 = $("#tchttp2").val();
var tctext2 = $("#tctext2").val();
var tcimg2 = $("#tcimg2").val();
var tchttp3 = $("#tchttp3").val();
var tctext3 = $("#tctext3").val();
var tcimg3 = $("#tcimg3").val();
var click24 = false;
if(MAC.Cookie.Get("Aiblog") != "1"){
    $("#gga").html('<div class="popup"><div class="row"><ul><li><a href="'+tchttp+'" target="_blank" title="'+tctext+'"><img src="'+tcimg+'" atl="'+tctext+'"></a></li><li><a href="'+tchttp2+'" target="_blank" title="'+tctext2+'"><img src="'+tcimg2+'" atl="'+tctext2+'"></a></li><li><a href="'+tchttp3+'" target="_blank" title="'+tctext3+'"><img src="'+tcimg3+'" atl="'+tctext3+'"></a></li></ul><div class="bottom"><div class="check"><span><i class="iconfont i-you"></i></span><p>点击不显示</p></div><i id="iconfont" class="iconfont">&#xe616;</i></div></div></div>');
}else{
    $(".popup").css("display","none");
}
$(".popup .check").click(function(){
    $(this).addClass("on");
	click24 = true;
})
$(".popup #iconfont").click(function(){
    $(".popup").css("display","none");
	if(click24){
		MAC.Cookie.Set("Aiblog","1",tc);
	}
});
});


var ggjs = $("#ggjs").val();
var ggjs2 = $("#ggjs2").val();
var ggjs3 = $("#ggjs3").val();
var ggjs4 = $("#ggjs4").val();
var ggjs5 = $("#ggjs5").val();
var ggjs6 = $("#ggjs6").val();
var ggjs7 = $("#ggjs7").val();
var ggjs8 = $("#ggjs8").val();
var ggjs9 = $("#ggjs9").val();
var ggjs10 = $("#ggjs10").val();
var ggjs11 = $("#ggjs11").val();
var ggjs12 = $("#ggjs12").val();
var ggjs13 = $("#ggjs13").val();
var ggjs14 = $("#ggjs14").val();
var ggjs15 = $("#ggjs15").val();
var ggjs16 = $("#ggjs16").val();
var ggjs17 = $("#ggjs17").val();
var ggjs18 = $("#ggjs18").val();
var ggjs19 = $("#ggjs19").val();
var ggjs20 = $("#ggjs20").val();
var ggjs21 = $("#ggjs21").val();
var ggjs22 = $("#ggjs22").val();
var ggjs23 = $("#ggjs23").val();
var ggjs24 = $("#ggjs24").val();
var ggjs25 = $("#ggjs25").val();
var ggjs26 = $("#ggjs26").val();
var ggjs27 = $("#ggjs27").val();
var ggjs28 = $("#ggjs28").val();
var ggjs29 = $("#ggjs29").val();
var ggjs30 = $("#ggjs30").val();
var ggjs31 = $("#ggjs31").val();
var ggjs32 = $("#ggjs32").val();
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg").css("display","none");
            $("#sgg11").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs2;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg2").css("display","none");
            $("#sgg12").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs3;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg3").css("display","none");
            $("#sgg13").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs4;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg4").css("display","none");
            $("#sgg14").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs5;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg5").css("display","none");
            $("#sgg15").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs6;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg6").css("display","none");
            $("#sgg16").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs7;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg7").css("display","none");
            $("#sgg17").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs8;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg8").css("display","none");
            $("#sgg18").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs9;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg9").css("display","none");
            $("#sgg19").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs10;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg10").css("display","none");
            $("#sgg20").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs11;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg21").css("display","none");
            $("#sgg31").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs12;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg22").css("display","none");
            $("#sgg32").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs13;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg23").css("display","none");
            $("#sgg33").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs14;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg24").css("display","none");
            $("#sgg34").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs15;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg25").css("display","none");
            $("#sgg35").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs16;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg26").css("display","none");
            $("#sgg36").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs17;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg27").css("display","none");
            $("#sgg37").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs18;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg28").css("display","none");
            $("#sgg38").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs19;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg29").css("display","none");
            $("#sgg39").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs20;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg30").css("display","none");
            $("#sgg40").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs21;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg41").css("display","none");
            $("#sgg51").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs22;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg42").css("display","none");
            $("#sgg52").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs23;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg43").css("display","none");
            $("#sgg53").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs24;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg44").css("display","none");
            $("#sgg54").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs25;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg45").css("display","none");
            $("#sgg55").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs26;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg46").css("display","none");
            $("#sgg56").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs27;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg47").css("display","none");
            $("#sgg57").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs28;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg48").css("display","none");
            $("#sgg58").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs29;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg49").css("display","none");
            $("#sgg59").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs30;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg50").css("display","none");
            $("#sgg60").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs31;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg61").css("display","none");
            // $("#sgg60").css("display","none");
        }
});
$(function(){
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var str = ggjs32;
        var endDate = new Date(str);
        var end = endDate.getTime();
        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
        s = Math.floor(leftTime/1000%60);
        if (leftTime>1) {
        } else {
            $("#sgg62").css("display","none");
            // $("#sgg60").css("display","none");
        }
});