<?php
return array (
  'db' => 
  array (
    'type' => 'mysql',
    'path' => '',
    'server' => '127.0.0.1',
    'port' => '3306',
    'name' => 'maccms8',
    'user' => 'root',
    'pass' => 'root',
    'tablepre' => 'mac_',
    'backup_path' => './application/data/backup/database/',
    'part_size' => 20971520,
    'compress' => 1,
    'compress_level' => 4,
  ),
  'site' => 
  array (
    'site_name' => '玖卿乐播-享你所想-看你所看',
    'site_url' => 'vod.nqcode.cn',
    'site_wapurl' => 'vod.nqcode.cn',
    'site_keywords' => '玖卿乐播-享你所想-看你所看',
    'site_description' => '提供最新最快的影视资讯和在线播放',
    'site_icp' => 'icp123',
    'site_qq' => '123456',
    'site_email' => '1036706612@qq.com',
    'install_dir' => '/',
    'site_logo' => 'static/images/logo.jpg',
    'site_waplogo' => 'static/images/logo.jpg',
    'template_dir' => 'JQ_VOD',
    'html_dir' => 'html',
    'mob_status' => '2',
    'mob_template_dir' => 'conch',
    'mob_html_dir' => 'html',
    'site_tj' => '统计代码',
    'site_status' => '1',
    'site_close_tip' => '玖卿乐播',
    'ads_dir' => 'ads',
    'mob_ads_dir' => 'ads',
  ),
  'app' => 
  array (
    'pathinfo_depr' => '/',
    'suffix' => 'html',
    'popedom_filter' => '0',
    'cache_type' => 'file',
    'cache_host' => '127.0.0.1',
    'cache_port' => '11211',
    'cache_username' => '',
    'cache_password' => '',
    'cache_flag' => 'a6bcf9aa58',
    'cache_core' => '0',
    'cache_time' => '3600',
    'cache_page' => '0',
    'cache_time_page' => '3600',
    'compress' => '1',
    'search' => '1',
    'search_timespan' => '1',
    'search_vod_rule' => 'vod_en|vod_sub|vod_actor',
    'search_art_rule' => 'art_en|art_sub',
    'copyright_status' => '2',
    'copyright_notice' => '该视频由于版权限制，暂不提供播放。',
    'collect_timespan' => '4',
    'pagesize' => '20',
    'makesize' => '30',
    'admin_login_verify' => '0',
    'editor' => 'ueditor',
    'player_sort' => '1',
    'encrypt' => '0',
    'share_url' => 'http://vod.nqcode.cn/reg/reg.html',
    'share_logo' => 'https://s2.ax1x.com/2019/12/25/liwuvt.png',
    'search_hot' => '变形金刚,火影忍者,复仇者联盟,战狼,红海行动,学警旋风',
    'art_extend_class' => '段子手,私房话,八卦精,爱生活,汽车迷,科技咖,美食家,辣妈帮',
    'vod_extend_class' => '爱情,动作,喜剧,战争,科幻,剧情,武侠,冒险,枪战,恐怖,微电影,其它',
    'vod_extend_state' => '正片,预告片,花絮',
    'vod_extend_version' => '高清版,剧场版,抢先版,OVA,TV,影院版',
    'vod_extend_area' => '大陆,香港,台湾,美国,韩国,日本,泰国,新加坡,马来西亚,印度,英国,法国,加拿大,西班牙,俄罗斯,其它',
    'vod_extend_lang' => '国语,英语,粤语,闽南语,韩语,日语,法语,德语,其它',
    'vod_extend_year' => '2020,2019,2018,2017,2016,2015,2014,2013,2012,2011,2010,2009,2008,2007,2006,2005,2004,2003,2002,2001,2000',
    'vod_extend_weekday' => '一,二,三,四,五,六,日',
    'actor_extend_area' => '大陆,香港,台湾,美国,韩国,日本,泰国,新加坡,马来西亚,印度,英国,法国,加拿大,西班牙,俄罗斯,其它',
    'filter_words' => 'www,http,com,net',
    'extra_var' => '',
  ),
  'app_setting' => 
  array (
    'start_img' => 'https://cloudrevebynineqing.oss-cn-qingdao.aliyuncs.com/uploads%2F2021%2F01%2F03%2FqDjm1QJ4_lunching.gif?',
    'before_play_url' => 'https://vod.nqcode.cn',
    'before_play_img' => '',
    'water_url' => '',
    'water_img' => 'https://cloudrevebynineqing.oss-cn-qingdao.aliyuncs.com/uploads/2021/01/04/logo_white.png',
    'has_logout' => '0',
  ),
  'user' => 
  array (
    'status' => '1',
    'reg_open' => '1',
    'reg_status' => '1',
    'reg_autoname_prefix' => 'JQ',
    'reg_phone_sms' => '1',
    'reg_email_sms' => '0',
    'reg_verify' => '0',
    'login_verify' => '0',
    'user_level' => 
    array (
      'v1' => 
      array (
        'people_count' => '0',
        'view_count' => '10',
      ),
      'v2' => 
      array (
        'people_count' => '1',
        'view_count' => '15',
      ),
      'v3' => 
      array (
        'people_count' => '5',
        'view_count' => '25',
      ),
      'v4' => 
      array (
        'people_count' => '10',
        'view_count' => '100',
      ),
      'v5' => 
      array (
        'people_count' => '30',
        'view_count' => '500',
      ),
    ),
    'reg_times' => '0',
    'reg_points' => '100',
    'reg_num' => '1',
    'invite_reg_points' => '10',
    'invite_visit_points' => '1',
    'invite_visit_num' => '1',
    'reward_status' => '1',
    'reward_ratio' => '1.1',
    'reward_ratio_2' => '0.6',
    'reward_ratio_3' => '0.3',
    'cash_status' => '0',
    'cash_ratio' => '10',
    'cash_min' => '10',
    'gold_ratio' => '100',
    'gold_min' => '20',
    'trysee' => '10',
    'trysee_points' => '30',
    'trysee_time' => '72',
    'vod_points_type' => '1',
    'art_points_type' => '0',
    'portrait_status' => '1',
    'portrait_size' => '100x100',
    'filter_words' => 'admin,cao,sex,xxx',
  ),
  'gbook' => 
  array (
    'status' => '1',
    'audit' => '0',
    'login' => '0',
    'verify' => '0',
    'pagesize' => '20',
    'timespan' => '10',
  ),
  'comment' => 
  array (
    'status' => '1',
    'audit' => '0',
    'login' => '0',
    'verify' => '0',
    'pagesize' => '20',
    'timespan' => '3',
  ),
  'upload' => 
  array (
    'thumb' => '0',
    'thumb_size' => '300x300',
    'thumb_type' => '1',
    'watermark' => '0',
    'watermark_location' => '7',
    'watermark_content' => '',
    'watermark_size' => '40',
    'watermark_color' => '#FF0000',
    'protocol' => 'https',
    'mode' => 'Qiniu',
    'remoteurl' => '',
    'api' => 
    array (
      'ftp' => 
      array (
        'host' => '',
        'port' => '21',
        'user' => 'test',
        'pwd' => 'test',
        'path' => '/',
        'url' => '',
      ),
      'qiniu' => 
      array (
        'bucket' => 'tv-bynineqing-image',
        'accesskey' => 'iZXlPMiVB6B-05tfUaJOQI7E7D5Qx0Zm_8UwgnTy',
        'secretkey' => '9bumD_dVOBV268GMZJ4V0thDf1xuMxnUbenjgqis',
        'url' => 'https://tv-img.nineqing.com',
      ),
      'upyun' => 
      array (
        'bucket' => '',
        'username' => '',
        'pwd' => '',
        'url' => '',
      ),
      'weibo' => 
      array (
        'user' => '',
        'pwd' => '',
        'size' => 'large',
        'cookie' => '',
        'time' => '1546239694',
      ),
    ),
  ),
  'interface' => 
  array (
    'status' => '1',
    'pass' => '9J6DEHESJOCF60OT',
    'vodtype' => '中国香港=香港#中国台湾=台湾',
    'arttype' => '',
  ),
  'pay' => 
  array (
    'min' => '1',
    'scale' => '100',
    'card' => 
    array (
      'url' => '',
    ),
    'qqepay' => 
    array (
      'appid' => '1089',
      'appkey' => 'YL4775B0hKe054738JZYJKlkZf05J4ss',
      'apiurl' => 'https://pay.xiaobaibk.cn/',
      'type' => '1',
      'name' => '微信',
    ),
    'epay' => 
    array (
      'appid' => '1089',
      'appkey' => 'YL4775B0hKe054738JZYJKlkZf05J4ss',
      'apiurl' => 'https://pay.xiaobaibk.cn/',
      'type' => '2',
      'name' => '支付宝',
    ),
    'weixin' => 
    array (
      'appid' => '222',
      'mchid' => '',
      'appkey' => '',
    ),
    'alipay' => 
    array (
      'account' => '',
      'appid' => '',
      'appkey' => '',
      'public_key' => '',
      'private_key' => '',
    ),
  ),
  'collect' => 
  array (
    'vod' => 
    array (
      'status' => '1',
      'hits_start' => '30',
      'hits_end' => '9591',
      'updown_start' => '0',
      'updown_end' => '30',
      'score' => '0',
      'pic' => '0',
      'tag' => '1',
      'class_filter' => '1',
      'psernd' => '0',
      'psesyn' => '1',
      'inrule' => ',b,c',
      'uprule' => ',a,b,c,d',
      'filter' => '色戒,色即是空',
      'thesaurus' => '',
      'words' => '',
    ),
    'art' => 
    array (
      'status' => '1',
      'hits_start' => '1',
      'hits_end' => '1000',
      'updown_start' => '1',
      'updown_end' => '1000',
      'score' => '1',
      'pic' => '0',
      'tag' => '0',
      'psernd' => '1',
      'psesyn' => '1',
      'inrule' => ',b',
      'uprule' => ',a,d',
      'filter' => '无奈的人',
      'thesaurus' => '',
      'words' => '',
    ),
    'actor' => 
    array (
      'status' => '0',
      'hits_start' => '1',
      'hits_end' => '999',
      'updown_start' => '1',
      'updown_end' => '999',
      'score' => '0',
      'pic' => '0',
      'psernd' => '0',
      'psesyn' => '0',
      'uprule' => ',a,b,c',
      'filter' => '无奈的人',
      'thesaurus' => '',
      'words' => '',
      'inrule' => ',a',
    ),
    'role' => 
    array (
      'status' => '0',
      'hits_start' => '1',
      'hits_end' => '999',
      'updown_start' => '1',
      'updown_end' => '999',
      'score' => '0',
      'pic' => '0',
      'psernd' => '0',
      'psesyn' => '0',
      'uprule' => 
      array (
        0 => 'a',
        1 => 'b',
        2 => 'c',
      ),
      'filter' => '',
      'thesaurus' => '',
      'words' => '',
    ),
  ),
  'api' => 
  array (
    'vod' => 
    array (
      'status' => '0',
      'charge' => '0',
      'pagesize' => '30',
      'imgurl' => '',
      'typefilter' => '',
      'datafilter' => ' vod_status=1',
      'cachetime' => '',
      'from' => '',
      'auth' => '',
    ),
    'art' => 
    array (
      'status' => '1',
      'charge' => '0',
      'pagesize' => '20',
      'imgurl' => '',
      'typefilter' => '',
      'datafilter' => 'art_status=1',
      'cachetime' => '',
      'auth' => 'qq.com#baidu.com',
    ),
    'actor' => 
    array (
      'status' => '1',
      'charge' => '0',
      'pagesize' => '20',
      'imgurl' => '',
      'datafilter' => 'actor_status=1',
      'cachetime' => '',
      'auth' => '',
    ),
  ),
  'connect' => 
  array (
    'qq' => 
    array (
      'status' => '0',
      'key' => 'aa',
      'secret' => 'bb',
    ),
    'weixin' => 
    array (
      'status' => '0',
      'key' => 'cc',
      'secret' => 'dd',
    ),
  ),
  'weixin' => 
  array (
    'status' => '1',
    'duijie' => 'wx.nineqing.com',
    'sousuo' => 'wx.nineqing.com',
    'token' => 'nineqing',
    'guanzhu' => '欢迎关注',
    'wuziyuan' => '没找到资源，请更换关键词或等待更新',
    'wuziyuanlink' => 'demo.nineqing.com',
    'bofang' => '0',
    'gjc1' => '关键词1',
    'gjcm1' => '长城',
    'gjci1' => 'http://img.aolusb.com/im/201610/2016101222371965996.jpg',
    'gjcl1' => 'http://www.loldytt.com/Dongzuodianying/CC/',
    'gjc2' => '关键词2',
    'gjcm2' => '生化危机6',
    'gjci2' => 'http://img.aolusb.com/im/201702/20172711214866248.jpg',
    'gjcl2' => 'http://www.loldytt.com/Kehuandianying/SHWJ6ZZ/',
    'gjc3' => '关键词3',
    'gjcm3' => '湄公河行动',
    'gjci3' => 'http://img.aolusb.com/im/201608/201681719561972362.jpg',
    'gjcl3' => 'http://www.loldytt.com/Dongzuodianying/GHXD/',
    'gjc4' => '关键词4',
    'gjcm4' => '王牌逗王牌',
    'gjci4' => 'http://img.aolusb.com/im/201601/201612723554344882.jpg',
    'gjcl4' => 'http://www.loldytt.com/Xijudianying/WPDWP/',
  ),
  'view' => 
  array (
    'index' => '0',
    'map' => '0',
    'search' => '0',
    'rss' => '0',
    'label' => '0',
    'vod_type' => '0',
    'vod_show' => '0',
    'art_type' => '0',
    'art_show' => '0',
    'topic_index' => '0',
    'topic_detail' => '0',
    'vod_detail' => '0',
    'vod_play' => '0',
    'vod_down' => '0',
    'art_detail' => '0',
  ),
  'path' => 
  array (
    'topic_index' => 'topic/index',
    'topic_detail' => 'topic/{id}/index',
    'vod_type' => 'vodtypehtml/{id}/index',
    'vod_detail' => 'vodhtml/{id}/index',
    'vod_play' => 'vodplayhtml/{id}/index',
    'vod_down' => 'voddownhtml/{id}/index',
    'art_type' => 'arttypehtml/{id}/index',
    'art_detail' => 'arthtml/{id}/index',
    'page_sp' => '_',
    'suffix' => 'html',
  ),
  'rewrite' => 
  array (
    'suffix_hide' => '0',
    'route_status' => '0',
    'status' => '0',
    'vod_id' => '0',
    'art_id' => '0',
    'type_id' => '0',
    'topic_id' => '0',
    'actor_id' => '0',
    'role_id' => '0',
    'route' => 'map   => map/index
rss   => rss/index

index-<page?>   => index/index

gbook-<page?>   => gbook/index
gbook$   => gbook/index

topic-<page?>   => topic/index
topic$  => topic/index
topicdetail-<id>   => topic/detail

actor-<page?>   => actor/index
actor$ => actor/index
actordetail-<id>   => actor/detail
actorshow/<area?>-<blood?>-<by?>-<letter?>-<level?>-<order?>-<page?>-<sex?>-<starsign?>   => actor/show

role-<page?>   => role/index
role$ => role/index
roledetail-<id>   => role/detail
roleshow/<by?>-<letter?>-<level?>-<order?>-<page?>-<rid?>   => role/show


vodtype/<id>-<page?>   => vod/type
vodtype/<id>   => vod/type
voddetail/<id>   => vod/detail
vodrss-<id>   => vod/rss
vodplay/<id>-<sid>-<nid>   => vod/play
voddown/<id>-<sid>-<nid>   => vod/down
vodshow/<id>-<area?>-<by?>-<class?>-<lang?>-<letter?>-<level?>-<order?>-<page?>-<state?>-<tag?>-<year?>   => vod/show
vodsearch/<wd?>-<actor?>-<area?>-<by?>-<class?>-<director?>-<lang?>-<letter?>-<level?>-<order?>-<page?>-<state?>-<tag?>-<year?>   => vod/search


arttype/<id>-<page?>   => art/type
arttype/<id>   => art/type
artshow-<id>   => art/show
artdetail-<id>-<page?>   => art/detail
artdetail-<id>   => art/detail
artrss-<id>-<page>   => art/rss
artshow/<id>-<by?>-<class?>-<level?>-<letter?>-<order?>-<page?>-<tag?>   => art/show
artsearch/<wd?>-<by?>-<class?>-<level?>-<letter?>-<order?>-<page?>-<tag?>   => art/search

label-<file> => label/index',
  ),
  'email' => 
  array (
    'host' => 'smtp.qq.com',
    'port' => '587',
    'username' => 'cloud.nineqingcom@qq.com',
    'password' => 'lluwaabeyrppjbdg',
    'nick' => '玖卿乐播',
    'test' => '1036706612@qq.com',
  ),
  'play' => 
  array (
    'width' => '100%',
    'height' => '100%',
    'widthmob' => '100%',
    'heightmob' => '100%',
    'widthpop' => '0',
    'heightpop' => '600',
    'second' => '3',
    'app_logo' => '',
    'prestrain' => '',
    'buffer' => '',
    'parse' => '',
    'autofull' => '1',
    'showtop' => '1',
    'showlist' => '1',
    'flag' => '0',
    'colors' => '000000,F6F6F6,F6F6F6,333333,666666,FFFFF,FF0000,2c2c2c,ffffff,a3a3a3,2c2c2c,adadad,adadad,48486c,fcfcfc',
  ),
  'sms' => 
  array (
    'type' => 'Aliyun',
    'appid' => 'LTAI4GJ61AXhPRwU8hnrC6sr',
    'appkey' => 'F7ABMbA48UXnmypiv3rybiKFY1El8K',
    'sign' => '玖居暗巷',
    'tpl_code_reg' => 'SMS_210077890',
    'tpl_code_bind' => '',
    'tpl_code_findpass' => '',
  ),
  'extra' => 
  array (
  ),
  'zhibo' => 
  array (
    'app_third_ui_name' => '发现',
  ),
);