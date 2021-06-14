layui.use(['form', 'layer'], function () {
  var form = layui.form, layer = layui.layer, $ = layui.jquery;
  var laoding = layer.load(1);
  if (domain_auth()) {
    var is_vip = true;
    if (playertype == 'yun') {
      $('.jie-kou').css("display", "none");
      $('.mt10').html('<span style="font-size:20px;color:red;">当前专区无需填写解析接口，直接点击保存即可！</span>')
    } if (playertype == 'zonghe') {
      tips = '当前专区为云播和m3u8集合体<br>';
      tips += '如果你看到播放编码是带“yun”的，都可以清空解析接口，留空即可<br>';
      tips += '例如：kuyun、cjyun、jsyun；这些类型的视频链接，都自带播放器<br>';
      $('.mt10').html(tips)
    }
    $("input[name='play[apis][]']").each(function () {
      if (this.id) {
        $("#" + this.id).removeAttr("disabled"); $("#" + this.id).removeClass("layui-disabled")
      } else {
        $('body').html('<h1 style="color:red;">加载异常，请从程序根目录，打开 /static/player/ 文件夹，清理里面的所有js文件，清理后再重新打开插件！</h1>')
      }
      if (playertype == 'yun') {
        $("#" + this.id).val("")
      }
    })
  }
  $("#layui-btn-submit").removeClass("layui-btn-disabled");
  $("#layui-btn-submit").html("保 存");
  $(document).on('click', '#jiekou', function () {
    if (!is_vip) {
      layer.confirm('您当前用的免费版，<br>不支持在这里修改解析接口，<br>VIP版可以自定义修改解析接口！<br><font color="red">如想便捷修改解析接口，请升级成为VIP版！</font>', {
        'btn': ['立即登陆', '取消']
      }, function () {
        var index = parent.layer.getFrameIndex(window.name); parent.layer.close(index); parent.userLogin()
      })
    }
  });
  $(document).on('click', '.player', function () {
    var type = $(this).attr('data-type');
    if (type == 'play') {
      layer.msg('云播资源专区，视频链接均自带播放器！<br>不能使用本地播放器播放！'); return false
    } if (type == 'offi') {
      layer.msg('本播放器不能用于<br>腾讯、优酷、爱奇艺<br>等直链解析播放！'); return false
    } if (type == 'jiekou') {
      $("input[name='play[apis][]']").each(function () {
        $(this).val("//cdn.zyc888.top/?url=")
      });
      layer.msg('接口已替换，点击保存即可！');
      return false
    }
    $.get(path + 'static/player/' + type + '.html', function (data) {
      $("input[name='play[apis][]']").each(function () {
        switch (type) {
          case 'ckplayerx': $(this).val("'+maccms.path+'/static/player/ckplayerx.html"); break;
          case 'dplayer': $(this).val("'+maccms.path+'/static/player/dplayer.html"); break;
          case 'videojs': $(this).val("'+maccms.path+'/static/player/videojs.html"); break;
          case 'aliplayer': $(this).val("'+maccms.path+'/static/player/aliplayer.html"); break
        }
        layer.msg(type + '接口已替换，点击保存即可！')
      })
    }).error(function (data) {
      switch (type) {
        case 'ckplayerx': var myurl = 'http://www.vrecf.com/a/81.html'; break;
        case 'dplayer': var myurl = 'http://www.vrecf.com/a/52.html'; break;
        case 'videojs': var myurl = 'http://www.vrecf.com/a/51.html'; break;
        case 'aliplayer': var myurl = 'http://www.vrecf.com/a/51.html'; break
      }
      layer.confirm('检测到你本地没有' + type + '播放器文件！<br>此播放器源码在萌芽模板网上有出售！<br>如有需要，购买后上传即可在此安装！', {
        icon: 2, title: '提示', btn: ['了解详情', '取消']
      }, function (index, layero) {
          var btn = layero.find('.layui-layer-btn');
          btn.find('.layui-layer-btn0').attr({ href: myurl, target: '_blank' });
          layer.close(index);
          layer.alert('请在新窗口完成购买，<br>购买购买后直接上传源码<br>然后在此安装替换播放器', function (index) { layer.closeAll() })
      }, function (index) {
        layer.closeAll()
      })
    }, 'json')
  });
  layer.close(laoding);
  form.on('submit(formSubmit)', function (data) {
    $.ajax({
      url: "create.php?id=play&name=" + my.name,
      data: data.field,
      type: "post",
      dataType: 'json',
      success: function (data) {
        if (data.code == 200) {
          layer.confirm(data.msg + '<br>是否立即清理程序缓存？', {
            btn: ['清理程序缓存', '稍后再说'],
            icon: 1,
            btn1: function () {
              var urls = $('.j-ajax', parent.parent.document).attr('href');
              $.get(urls, {}, function (res) {
                layer.alert(
                  res.msg + '<br>记得手动 <b style="color:red">清理浏览器缓存</b> <br>如果网站有加CDN，还需要清理CDN缓存', 
                  { icon: 6 },
                  function () {
                    var index = parent.layer.getFrameIndex(window.name); parent.layer.close(index)
                  }
                )
              })
            },
            btn2: function () {
              var index = parent.layer.getFrameIndex(window.name);
              parent.layer.close(index)
            }
          })
        } else {
          layer.alert(data.msg, { icon: 2 }, function () { location.reload() })
        }
      },
      error: function () {
        layer.closeAll("loading");
        layer.alert("读取添加播放器文件异常!", { icon: 5 }, function () { location.reload() })
      }
    });
    return false
  })
});
