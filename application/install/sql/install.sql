-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2020-11-17 13:20:35
-- 服务器版本： 5.6.49-log
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `luob_app`
--

-- --------------------------------------------------------

--
-- 表的结构 `mac_actor`
--

CREATE TABLE IF NOT EXISTS `mac_actor` (
  `actor_id` int(10) unsigned NOT NULL,
  `actor_name` varchar(255) NOT NULL DEFAULT '',
  `actor_en` varchar(255) NOT NULL DEFAULT '',
  `actor_alias` varchar(255) NOT NULL DEFAULT '',
  `actor_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `actor_lock` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `actor_letter` char(1) NOT NULL DEFAULT '',
  `actor_sex` char(1) NOT NULL DEFAULT '',
  `actor_color` varchar(6) NOT NULL DEFAULT '',
  `actor_pic` varchar(255) NOT NULL DEFAULT '',
  `actor_blurb` varchar(255) NOT NULL DEFAULT '',
  `actor_remarks` varchar(100) NOT NULL DEFAULT '',
  `actor_area` varchar(20) NOT NULL DEFAULT '',
  `actor_height` varchar(10) NOT NULL DEFAULT '',
  `actor_weight` varchar(10) NOT NULL DEFAULT '',
  `actor_birthday` varchar(10) NOT NULL DEFAULT '',
  `actor_birtharea` varchar(20) NOT NULL DEFAULT '',
  `actor_blood` varchar(10) NOT NULL DEFAULT '',
  `actor_starsign` varchar(10) NOT NULL DEFAULT '',
  `actor_school` varchar(20) NOT NULL DEFAULT '',
  `actor_works` varchar(255) NOT NULL DEFAULT '',
  `actor_level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `actor_time` int(10) unsigned NOT NULL DEFAULT '0',
  `actor_time_add` int(10) unsigned NOT NULL DEFAULT '0',
  `actor_time_hits` int(10) unsigned NOT NULL DEFAULT '0',
  `actor_time_make` int(10) unsigned NOT NULL DEFAULT '0',
  `actor_hits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor_hits_day` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor_hits_week` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor_hits_month` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor_score` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `actor_score_all` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor_score_num` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `actor_up` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor_down` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor_tpl` varchar(30) NOT NULL DEFAULT '',
  `actor_jumpurl` varchar(150) NOT NULL DEFAULT '',
  `actor_content` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `mac_admin`
--

CREATE TABLE IF NOT EXISTS `mac_admin` (
  `admin_id` smallint(6) unsigned NOT NULL,
  `admin_name` varchar(30) NOT NULL DEFAULT '',
  `admin_pwd` char(32) NOT NULL DEFAULT '',
  `admin_random` char(32) NOT NULL DEFAULT '',
  `admin_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `admin_auth` text NOT NULL,
  `admin_login_time` int(10) unsigned NOT NULL DEFAULT '0',
  `admin_login_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `admin_login_num` int(10) unsigned NOT NULL DEFAULT '0',
  `admin_last_login_time` int(10) unsigned NOT NULL DEFAULT '0',
  `admin_last_login_ip` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='管理员账户';

-- --------------------------------------------------------

--
-- 表的结构 `mac_adtype`
--

CREATE TABLE IF NOT EXISTS `mac_adtype` (
  `id` int(10) unsigned NOT NULL,
  `typename` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '类别名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1-正常；0：禁用',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `tag` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '广告位标识',
  `description` varchar(2000) CHARACTER SET utf8 DEFAULT NULL COMMENT '描述',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间'
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='APP广告管理';

--
-- 转存表中的数据 `mac_adtype`
--

INSERT INTO `mac_adtype` (`id`, `typename`, `status`, `sort`, `tag`, `description`, `create_time`, `update_time`) VALUES
(52, '中心', 1, 0, 'user_center', 'https://cloudrevebynineqing.oss-cn-qingdao.aliyuncs.com/uploads%2F2021%2F01%2F04%2FvfgjASAg_levelup.png', 1560965440, 1593330630),
(53, '搜索页广告位', 0, 0, 'searcher', '<a href="https://ys.nineqing.net/" target="_blank"><img src="https://ysfile.jiuqing97.top/2020/08/20200807100604473.png" width="100%" height="100%" border="0" /></a>', 1560965460, 1595157884),
(54, '播放器暂停广告', 0, 0, 'player_pause', 'https://jiuqing97.top,https://wwfile.jiuqing97.top/2020/08/1597146281-527ef3f0af7f14b.png', 1560965485, 1572960349),
(55, '播放器下方广告', 0, 0, 'player_down', '<a href="https://nineqing.com/" target="_blank"><img src="https://nineqing-com-file-1253682899.cos.ap-beijing.myqcloud.com/2020/08/1597080182-b03f960de6c7939.png" width="100%" height="100%" border="0" /></a>', 1560965505, 1584348125),
(56, '综艺广告位', 0, 0, 'variety', '<a href="https://ww.nineqing.com/" target="_blank"><img src="https://wwfile.nineqing.com/2020/08/1597079130-97b5bc9f18fec08.png" width="100%" height="100%" border="0" /></a>', 1560965569, 1583861143),
(57, '动漫广告位', 0, 0, 'cartoon', '<a href="#" target="_blank"><img src="https://wwfile.jiuqing97.top/2020/08/1597146281-527ef3f0af7f14b.png" width="100%" height="100%" border="0" /></a>', 1560965583, 1583861131),
(58, '连续剧广告位', 0, 0, 'sitcom', '<a href="#" target="_blank"><img src="https://wwfile.jiuqing97.top/2020/08/1597146281-527ef3f0af7f14b.png" width="100%" height="100%" border="0" /></a>\r\n', 1560965601, 1583861119),
(59, '电影广告位', 0, 0, 'vod', '<a href="https://nineqing.com/" target="_blank"><img src="https://nineqing-com-file-1253682899.cos.ap-beijing.myqcloud.com/2020/08/1597080182-b03f960de6c7939.png" width="100%" height="100%" border="0" /></a>', 1560965614, 1583861103),
(60, '首页广告位', 0, 0, 'index', '<a href="https://nineqing.com/" target="_blank"><img src="https://nineqing-com-file-1253682899.cos.ap-beijing.myqcloud.com/2020/08/1597080182-b03f960de6c7939.png" width="100%" height="100%" border="0" /></a> \r\n', 1560965629, 1584348142),
(61, '启动页广告位', 1, 0, 'startup_adv', '<a href="#" target="_blank"><img src="https://cloudrevebynineqing.oss-cn-qingdao.aliyuncs.com/uploads%2F2021%2F01%2F03%2FqDjm1QJ4_lunching.gif"  /></a>', 1560965647, 1594491349),
(62, 'QQ客服', 1, 0, 'service_qq', '1036706612', 1560965677, 1598795259);

-- --------------------------------------------------------

--
-- 表的结构 `mac_app_install_record`
--

CREATE TABLE IF NOT EXISTS `mac_app_install_record` (
  `app_install_record_id` int(11) NOT NULL,
  `client_ip` varchar(255) NOT NULL DEFAULT '',
  `invite_user_id` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `is_pull` int(255) NOT NULL DEFAULT '0',
  `extra` varchar(255) NOT NULL DEFAULT '',
  `os` varchar(255) NOT NULL DEFAULT '',
  `os_version` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `mac_app_version`
--

CREATE TABLE IF NOT EXISTS `mac_app_version` (
  `app_version_id` int(11) NOT NULL,
  `os` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `is_required` int(11) NOT NULL,
  `type` int(255) DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='APP更新';

--
-- 转存表中的数据 `mac_app_version`
--

INSERT INTO `mac_app_version` (`app_version_id`, `os`, `version`, `summary`, `url`, `create_time`, `update_time`, `is_required`, `type`) VALUES
(1, '2', 'v0.0.0', '1.升级播放器内核v3.0.2到v3.2.6；2.优化界面流程度；3.更新接口解析，支持官解。', 'https://lbsp.lanzous.com/iqMZ7exkb2f', 1572787732, 1595558699, 1, 1),
(2, '1', 'v0.0.4', '1.升级播放器内核v3.0.2到v3.2.6； 2.修复芒果播放，支持B站解析； 3.修复点播，修复全屏/锁屏系统返回键； 4.恢复游客试看功能，支持电视直播； 5.修复前端不能删除播放记录功能。', '', 1572790342, 1605416869, 1, 2);

-- --------------------------------------------------------

--
-- 表的结构 `mac_art`
--

CREATE TABLE IF NOT EXISTS `mac_art` (
  `art_id` int(10) unsigned NOT NULL,
  `type_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `type_id_1` smallint(6) unsigned NOT NULL DEFAULT '0',
  `group_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `art_name` varchar(255) NOT NULL DEFAULT '',
  `art_sub` varchar(255) NOT NULL DEFAULT '',
  `art_en` varchar(255) NOT NULL DEFAULT '',
  `art_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `art_letter` char(1) NOT NULL DEFAULT '',
  `art_color` varchar(6) NOT NULL DEFAULT '',
  `art_from` varchar(30) NOT NULL DEFAULT '',
  `art_author` varchar(30) NOT NULL DEFAULT '',
  `art_tag` varchar(100) NOT NULL DEFAULT '',
  `art_class` varchar(255) NOT NULL DEFAULT '',
  `art_pic` varchar(255) NOT NULL DEFAULT '',
  `art_pic_thumb` varchar(255) NOT NULL DEFAULT '',
  `art_pic_slide` varchar(255) NOT NULL DEFAULT '',
  `art_blurb` varchar(255) NOT NULL DEFAULT '',
  `art_remarks` varchar(100) NOT NULL DEFAULT '',
  `art_jumpurl` varchar(150) NOT NULL DEFAULT '',
  `art_tpl` varchar(30) NOT NULL DEFAULT '',
  `art_level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `art_lock` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `art_points` smallint(6) unsigned NOT NULL DEFAULT '0',
  `art_points_detail` smallint(6) unsigned NOT NULL DEFAULT '0',
  `art_up` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `art_down` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `art_hits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `art_hits_day` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `art_hits_week` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `art_hits_month` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `art_time` int(10) unsigned NOT NULL DEFAULT '0',
  `art_time_add` int(10) unsigned NOT NULL DEFAULT '0',
  `art_time_hits` int(10) unsigned NOT NULL DEFAULT '0',
  `art_time_make` int(10) unsigned NOT NULL DEFAULT '0',
  `art_score` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `art_score_all` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `art_score_num` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `art_rel_art` varchar(255) NOT NULL DEFAULT '',
  `art_rel_vod` varchar(255) NOT NULL DEFAULT '',
  `art_pwd` varchar(10) NOT NULL DEFAULT '',
  `art_pwd_url` varchar(255) NOT NULL DEFAULT '',
  `art_title` mediumtext NOT NULL,
  `art_note` mediumtext NOT NULL,
  `art_content` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `mac_card`
--

CREATE TABLE IF NOT EXISTS `mac_card` (
  `card_id` int(10) unsigned NOT NULL,
  `card_no` varchar(16) NOT NULL DEFAULT '',
  `card_pwd` varchar(8) NOT NULL DEFAULT '',
  `card_money` smallint(6) unsigned NOT NULL DEFAULT '0',
  `card_points` smallint(6) unsigned NOT NULL DEFAULT '0',
  `card_use_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `card_sale_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `card_add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `card_use_time` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `mac_cash`
--

CREATE TABLE IF NOT EXISTS `mac_cash` (
  `cash_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cash_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cash_points` smallint(6) unsigned NOT NULL DEFAULT '0',
  `cash_money` decimal(12,2) unsigned NOT NULL DEFAULT '0.00',
  `cash_bank_name` varchar(60) NOT NULL DEFAULT '',
  `cash_bank_no` varchar(30) NOT NULL DEFAULT '',
  `cash_payee_name` varchar(30) NOT NULL DEFAULT '',
  `cash_time` int(10) unsigned NOT NULL DEFAULT '0',
  `cash_time_audit` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `mac_category`
--

CREATE TABLE IF NOT EXISTS `mac_category` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(60) NOT NULL COMMENT '分类名',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父类id',
  `void_id` text NOT NULL COMMENT '电影id',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否开启：0：否；1：开启',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间'
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='APP栏目分类';

--
-- 转存表中的数据 `mac_category`
--

INSERT INTO `mac_category` (`id`, `cat_name`, `pid`, `void_id`, `status`, `sort`, `create_time`, `update_time`) VALUES
(1, '电影抢先看', 0, '108498,108487,108486,108478,108477,108475,108476,108470,108465,108464', 1, 0, 1577729705, 1595380938),
(2, '追剧乐翻天', 0, '108483,108482,108471,108472,108469,108466,106070,108460,108458,105760', 1, 0, 1577729866, 1595380965),
(3, '腾讯视频专区', 0, '41574,108442,36749,51553,56303,107339,51283,50797,50932,50643', 1, 0, 1577729909, 1595380992),
(4, '优酷视频专区', 0, '6994,50009,2969,42450,50011,49988,49548,47453,48618', 1, 0, 1577729960, 1583927634),
(5, '最热喜剧大片', 0, '107401,108502,108501,108500,108499,50956,108498,108495,108491,108494,108493', 1, 0, 1577730105, 1595381021);

-- --------------------------------------------------------

--
-- 表的结构 `mac_cj_content`
--

CREATE TABLE IF NOT EXISTS `mac_cj_content` (
  `id` int(10) unsigned NOT NULL,
  `nodeid` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `url` char(255) NOT NULL,
  `title` char(100) NOT NULL,
  `data` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `mac_cj_history`
--

CREATE TABLE IF NOT EXISTS `mac_cj_history` (
  `md5` char(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- --------------------------------------------------------

--
-- 表的结构 `mac_cj_node`
--

CREATE TABLE IF NOT EXISTS `mac_cj_node` (
  `nodeid` smallint(6) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `lastdate` int(10) unsigned NOT NULL DEFAULT '0',
  `sourcecharset` varchar(8) NOT NULL,
  `sourcetype` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `urlpage` text NOT NULL,
  `pagesize_start` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `pagesize_end` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `page_base` char(255) NOT NULL,
  `par_num` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `url_contain` char(100) NOT NULL,
  `url_except` char(100) NOT NULL,
  `url_start` char(100) NOT NULL DEFAULT '',
  `url_end` char(100) NOT NULL DEFAULT '',
  `title_rule` char(100) NOT NULL,
  `title_html_rule` text NOT NULL,
  `type_rule` char(100) NOT NULL,
  `type_html_rule` text NOT NULL,
  `content_rule` char(100) NOT NULL,
  `content_html_rule` text NOT NULL,
  `content_page_start` char(100) NOT NULL,
  `content_page_end` char(100) NOT NULL,
  `content_page_rule` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `content_page` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `content_nextpage` char(100) NOT NULL,
  `down_attachment` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `watermark` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `coll_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `customize_config` text NOT NULL,
  `program_config` text NOT NULL,
  `mid` tinyint(1) unsigned NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `mac_collect`
--

CREATE TABLE IF NOT EXISTS `mac_collect` (
  `collect_id` int(10) unsigned NOT NULL,
  `collect_name` varchar(30) NOT NULL DEFAULT '',
  `collect_url` varchar(255) NOT NULL DEFAULT '',
  `collect_type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `collect_mid` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `collect_appid` varchar(30) NOT NULL DEFAULT '',
  `collect_appkey` varchar(30) NOT NULL DEFAULT '',
  `collect_param` varchar(100) NOT NULL DEFAULT '',
  `collect_opt` int(2) NOT NULL,
  `collect_filter` int(2) NOT NULL DEFAULT '0',
  `collect_filter_from` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='APP数据采集';

--
-- 转存表中的数据 `mac_collect`
--

INSERT INTO `mac_collect` (`collect_id`, `collect_name`, `collect_url`, `collect_type`, `collect_mid`, `collect_appid`, `collect_appkey`, `collect_param`, `collect_opt`, `collect_filter`, `collect_filter_from`) VALUES
(21, '百度云m3u8采集', 'https://m3u8.apibdzy.com/api.php/provide/vod/?ac=list', 2, 1, '', '', '', 0, 0, ''),
(22, '萝卜视频超清接口采集', 'http://www.luob.app/api.php/provide/vod/?ac=list', 2, 1, '', '', '', 0, 0, ''),
(23, '小小影视采集', 'http://m.ikmovie.xyz/xx.php?ac=list', 2, 1, '', '', '', 0, 0, ''),
(24, 'M3U8蓝光资源 m3u8采集', 'https://ya.kongbuya.com/api.php/provide/vod/from/kbym3u8/at/xml/ ', 1, 1, '', '', '', 0, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `mac_comment`
--

CREATE TABLE IF NOT EXISTS `mac_comment` (
  `comment_id` int(10) unsigned NOT NULL,
  `comment_mid` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `comment_rid` int(10) unsigned NOT NULL DEFAULT '0',
  `comment_pid` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `comment_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `comment_name` varchar(60) NOT NULL DEFAULT '',
  `comment_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `comment_time` int(10) unsigned NOT NULL DEFAULT '0',
  `comment_content` varchar(255) NOT NULL DEFAULT '',
  `comment_up` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `comment_down` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `comment_reply` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `comment_report` mediumint(8) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='APP评论数据';

-- --------------------------------------------------------

--
-- 表的结构 `mac_danmu`
--

CREATE TABLE IF NOT EXISTS `mac_danmu` (
  `danmu_id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `vod_id` int(11) NOT NULL,
  `at_time` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `danmu_time` int(11) NOT NULL,
  `status` int(255) NOT NULL DEFAULT '1',
  `dianzan_num` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='弹幕';

-- --------------------------------------------------------

--
-- 表的结构 `mac_gbook`
--

CREATE TABLE IF NOT EXISTS `mac_gbook` (
  `gbook_id` int(10) unsigned NOT NULL,
  `gbook_rid` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `gbook_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `gbook_name` varchar(60) NOT NULL DEFAULT '',
  `gbook_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `gbook_time` int(10) unsigned NOT NULL DEFAULT '0',
  `gbook_reply_time` int(10) unsigned NOT NULL DEFAULT '0',
  `gbook_content` varchar(255) NOT NULL DEFAULT '',
  `gbook_reply` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='APP留言反馈';

-- --------------------------------------------------------

--
-- 表的结构 `mac_glog`
--

CREATE TABLE IF NOT EXISTS `mac_glog` (
  `glog_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id_1` int(10) NOT NULL DEFAULT '0',
  `glog_type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `glog_gold` smallint(6) unsigned NOT NULL DEFAULT '0',
  `glog_time` int(10) unsigned NOT NULL DEFAULT '0',
  `glog_remarks` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='发起提现';

-- --------------------------------------------------------

--
-- 表的结构 `mac_gold_withdraw_apply`
--

CREATE TABLE IF NOT EXISTS `mac_gold_withdraw_apply` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `num` decimal(8,2) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0 审批中 1 提现成功 2 提现失败',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `created_time` int(11) NOT NULL COMMENT '创建时间',
  `updated_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `success_time` int(11) NOT NULL DEFAULT '0' COMMENT '// 提现成功时间',
  `fail_time` int(11) NOT NULL DEFAULT '0' COMMENT '// 结束时间',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '提现方式',
  `account` varchar(255) NOT NULL DEFAULT '0' COMMENT '账户',
  `realname` varchar(255) NOT NULL DEFAULT '''''' COMMENT '真实姓名'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='金币提现申请';

-- --------------------------------------------------------

--
-- 表的结构 `mac_group`
--

CREATE TABLE IF NOT EXISTS `mac_group` (
  `group_id` smallint(6) NOT NULL,
  `group_name` varchar(30) NOT NULL DEFAULT '',
  `group_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `group_type` varchar(255) NOT NULL DEFAULT '',
  `group_popedom` text NOT NULL,
  `group_points_day` smallint(6) unsigned NOT NULL DEFAULT '0',
  `group_points_week` smallint(6) NOT NULL DEFAULT '0',
  `group_points_month` smallint(6) unsigned NOT NULL DEFAULT '0',
  `group_points_year` smallint(6) unsigned NOT NULL DEFAULT '0',
  `group_points_free` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='会员组管理';

--
-- 转存表中的数据 `mac_group`
--

INSERT INTO `mac_group` (`group_id`, `group_name`, `group_status`, `group_type`, `group_popedom`, `group_points_day`, `group_points_week`, `group_points_month`, `group_points_year`, `group_points_free`) VALUES
(1, '游客', 1, ',1,2,3,4,', '{"1":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"2":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"3":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"4":{"1":"1","2":"2","3":"3","4":"4","5":"5"}}', 0, 0, 0, 0, 0),
(2, '默认会员', 1, ',1,2,3,4,', '{"1":{"1":"1"},"2":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"3":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"4":{"1":"1","2":"2","3":"3","4":"4","5":"5"}}', 0, 0, 0, 0, 0),
(3, 'VIP会员', 1, ',1,2,3,4,', '{"1":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"2":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"3":{"1":"1","2":"2","3":"3","4":"4","5":"5"},"4":{"1":"1","2":"2","3":"3","4":"4","5":"5"}}', 100, 500, 1500, 15000, 0);

-- --------------------------------------------------------

--
-- 表的结构 `mac_groupchat`
--

CREATE TABLE IF NOT EXISTS `mac_groupchat` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='群聊';

-- --------------------------------------------------------

--
-- 表的结构 `mac_link`
--

CREATE TABLE IF NOT EXISTS `mac_link` (
  `link_id` smallint(6) unsigned NOT NULL,
  `link_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `link_name` varchar(60) NOT NULL DEFAULT '',
  `link_sort` smallint(6) NOT NULL DEFAULT '0',
  `link_add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `link_time` int(10) unsigned NOT NULL DEFAULT '0',
  `link_url` varchar(255) NOT NULL DEFAULT '',
  `link_logo` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `mac_message`
--

CREATE TABLE IF NOT EXISTS `mac_message` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `content` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='APP公告通知';

--
-- 转存表中的数据 `mac_message`
--

INSERT INTO `mac_message` (`id`, `title`, `create_date`, `content`) VALUES
(1, '你好，感谢注册本影视', '2021-01-01 23:13:57', '即日起，全面开启邀请好友看片赚钱活动了！推广好友来看片，不仅可以升级兑换会员，还可以赚钱啦~');

-- --------------------------------------------------------

--
-- 表的结构 `mac_msg`
--

CREATE TABLE IF NOT EXISTS `mac_msg` (
  `msg_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `msg_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `msg_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `msg_to` varchar(30) NOT NULL DEFAULT '',
  `msg_code` varchar(10) NOT NULL DEFAULT '',
  `msg_content` varchar(255) NOT NULL DEFAULT '',
  `msg_time` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `mac_order`
--

CREATE TABLE IF NOT EXISTS `mac_order` (
  `order_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `order_code` varchar(30) NOT NULL DEFAULT '',
  `order_price` decimal(12,2) unsigned NOT NULL DEFAULT '0.00',
  `order_time` int(10) unsigned NOT NULL DEFAULT '0',
  `order_points` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `order_pay_type` varchar(10) NOT NULL DEFAULT '',
  `order_pay_time` int(10) unsigned NOT NULL DEFAULT '0',
  `order_remarks` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `mac_plog`
--

CREATE TABLE IF NOT EXISTS `mac_plog` (
  `plog_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id_1` int(10) NOT NULL DEFAULT '0',
  `plog_type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `plog_points` smallint(6) unsigned NOT NULL DEFAULT '0',
  `plog_time` int(10) unsigned NOT NULL DEFAULT '0',
  `plog_remarks` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `mac_role`
--

CREATE TABLE IF NOT EXISTS `mac_role` (
  `role_id` int(10) unsigned NOT NULL,
  `role_rid` int(10) unsigned NOT NULL DEFAULT '0',
  `role_name` varchar(255) NOT NULL DEFAULT '',
  `role_en` varchar(255) NOT NULL DEFAULT '',
  `role_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `role_lock` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `role_letter` char(1) NOT NULL DEFAULT '',
  `role_color` varchar(6) NOT NULL DEFAULT '',
  `role_actor` varchar(255) NOT NULL DEFAULT '',
  `role_remarks` varchar(100) NOT NULL DEFAULT '',
  `role_pic` varchar(255) NOT NULL DEFAULT '',
  `role_sort` smallint(6) unsigned NOT NULL DEFAULT '0',
  `role_level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `role_time` int(10) unsigned NOT NULL DEFAULT '0',
  `role_time_add` int(10) unsigned NOT NULL DEFAULT '0',
  `role_time_hits` int(10) unsigned NOT NULL DEFAULT '0',
  `role_time_make` int(10) unsigned NOT NULL DEFAULT '0',
  `role_hits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `role_hits_day` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `role_hits_week` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `role_hits_month` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `role_score` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `role_score_all` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `role_score_num` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `role_up` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `role_down` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `role_tpl` varchar(30) NOT NULL DEFAULT '',
  `role_jumpurl` varchar(150) NOT NULL DEFAULT '',
  `role_content` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `mac_sign`
--

CREATE TABLE IF NOT EXISTS `mac_sign` (
  `sign_id` int(10) unsigned NOT NULL,
  `user_id` int(10) NOT NULL,
  `date` varchar(20) NOT NULL,
  `reward` varchar(500) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `mac_tmpvod`
--

CREATE TABLE IF NOT EXISTS `mac_tmpvod` (
  `id1` int(10) unsigned DEFAULT NULL,
  `name1` varchar(255) NOT NULL DEFAULT '',
  `name_type` varchar(291) NOT NULL DEFAULT '',
  `tid1` smallint(6) NOT NULL DEFAULT '0',
  `year1` varchar(10) NOT NULL DEFAULT '',
  `area1` varchar(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `mac_topic`
--

CREATE TABLE IF NOT EXISTS `mac_topic` (
  `topic_id` smallint(6) unsigned NOT NULL,
  `topic_name` varchar(255) NOT NULL DEFAULT '',
  `topic_en` varchar(255) NOT NULL DEFAULT '',
  `topic_sub` varchar(255) NOT NULL DEFAULT '',
  `topic_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `topic_sort` smallint(6) unsigned NOT NULL DEFAULT '0',
  `topic_letter` char(1) NOT NULL DEFAULT '',
  `topic_color` varchar(6) NOT NULL DEFAULT '',
  `topic_tpl` varchar(30) NOT NULL DEFAULT '',
  `topic_type` varchar(255) NOT NULL DEFAULT '',
  `topic_pic` varchar(255) NOT NULL DEFAULT '',
  `topic_pic_thumb` varchar(255) NOT NULL DEFAULT '',
  `topic_pic_slide` varchar(255) NOT NULL DEFAULT '',
  `topic_key` varchar(255) NOT NULL DEFAULT '',
  `topic_des` varchar(255) NOT NULL DEFAULT '',
  `topic_title` varchar(255) NOT NULL DEFAULT '',
  `topic_blurb` varchar(255) NOT NULL DEFAULT '',
  `topic_remarks` varchar(100) NOT NULL DEFAULT '',
  `topic_level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `topic_up` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_down` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_score` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `topic_score_all` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_score_num` smallint(6) unsigned NOT NULL DEFAULT '0',
  `topic_hits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_hits_day` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_hits_week` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_hits_month` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_time` int(10) unsigned NOT NULL DEFAULT '0',
  `topic_time_add` int(10) unsigned NOT NULL DEFAULT '0',
  `topic_time_hits` int(10) unsigned NOT NULL DEFAULT '0',
  `topic_time_make` int(10) unsigned NOT NULL DEFAULT '0',
  `topic_tag` varchar(255) NOT NULL DEFAULT '',
  `topic_rel_vod` text,
  `topic_rel_art` text,
  `topic_content` text,
  `topic_extend` text
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='APP专题';

--
-- 转存表中的数据 `mac_topic`
--

INSERT INTO `mac_topic` (`topic_id`, `topic_name`, `topic_en`, `topic_sub`, `topic_status`, `topic_sort`, `topic_letter`, `topic_color`, `topic_tpl`, `topic_type`, `topic_pic`, `topic_pic_thumb`, `topic_pic_slide`, `topic_key`, `topic_des`, `topic_title`, `topic_blurb`, `topic_remarks`, `topic_level`, `topic_up`, `topic_down`, `topic_score`, `topic_score_all`, `topic_score_num`, `topic_hits`, `topic_hits_day`, `topic_hits_week`, `topic_hits_month`, `topic_time`, `topic_time_add`, `topic_time_hits`, `topic_time_make`, `topic_tag`, `topic_rel_vod`, `topic_rel_art`, `topic_content`, `topic_extend`) VALUES
(2, '圣诞节必看佳片今晚就是平安夜啦，祝大家今天平安夜快乐~', 'shengdanjiebikanjiapian', '', 1, 0, '', '', 'detail.html', '', 'https://ae01.alicdn.com/kf/Hc980ccce7a8845b5b4b1023e8fdeea08A.jpg', '', '', '', '', '', '今晚就是平安夜啦，祝大家今天平安夜快乐~明天圣诞节快乐~小编整理了18部圣诞节观看的电影。窝在被子里一个人看或者和伴侣和家人看都很适合哦~赶紧看起来吧~', '', 0, 0, 0, '0.0', 0, 0, 0, 0, 0, 0, 1590599402, 1577460719, 0, 0, '爱情', '50518,50515,50514,50511,50504,50503', '', '<p>今晚就是平安夜啦，祝大家今天平安夜快乐~明天圣诞节快乐~小编整理了18部圣诞节观看的电影。窝在被子里一个人看或者和伴侣和家人看都很适合哦~赶紧看起来吧~</p>', ''),
(4, '周末抢先电影观看一直看', 'zhoumoqiangxiandianyingguankanyizhikan', '', 1, 0, '', '', 'detail.html', '', 'https://ae01.alicdn.com/kf/U486e0c4211d741c79cf755e1677dad7cN.jpg', '', '', '', '', '', '最近“少年的你”火爆全网，周冬雨在里面也是演技大爆发，获得一致好评。张艺谋曾评价周冬雨的表演“她是老天爷赏饭吃的演员，靠的就是一个感觉，她的戏不是演出来，就是自然而然来的。”下面咱们一起来欣赏下她的作品集，看周冬雨是如何从不起眼蜕变到惊艳影后的！', '', 0, 0, 0, '0.0', 0, 0, 0, 0, 0, 0, 1587447071, 1577551494, 0, 0, '', '50894,50893,50892,50891,50890', '', '<p>最近“少年的你”火爆全网，周冬雨在里面也是演技大爆发，获得一致好评。张艺谋曾评价周冬雨的表演“她是老天爷赏饭吃的演员，靠的就是一个感觉，她的戏不是演出来，就是自然而然来的。”下面咱们一起来欣赏下她的作品集，看周冬雨是如何从不起眼蜕变到惊艳影后的！</p>', ''),
(3, '2021年贺岁档', '2020nianhesuidang', '', 1, 0, '', '', 'detail.html', '', 'https://ae01.alicdn.com/kf/H7b2c30b42ebd47668db35a4e355c1df37.jpg', '', '', '', '', '', '2021年一大波贺岁档正在向你招手：《唐人街探案3》《囧妈》《星球大战9》《中国女排》...小编为大家准备了十部春节档强片，你最期待哪一部呢？PS：小编将在第一时间，把最新的资源带给大家！准备好了吗？', '', 0, 0, 0, '0.0', 0, 0, 0, 0, 0, 0, 1587447103, 1577537633, 0, 0, '动作', '50632,50625,50620,50608,50606,50600', '', '<p>2021年一大波贺岁档正在向你招手：《唐人街探案3》《囧妈》《星球大战9》《中国女排》...小编为大家准备了十部春节档强片，你最期待哪一部呢？PS：小编将在第一时间，把最新的资源带给大家！准备好了吗？</p>', '');

-- --------------------------------------------------------

--
-- 表的结构 `mac_type`
--

CREATE TABLE IF NOT EXISTS `mac_type` (
  `type_id` smallint(6) unsigned NOT NULL,
  `type_name` varchar(60) NOT NULL DEFAULT '',
  `type_en` varchar(60) NOT NULL DEFAULT '',
  `type_sort` smallint(6) unsigned NOT NULL DEFAULT '0',
  `type_mid` smallint(6) unsigned NOT NULL DEFAULT '1',
  `type_pid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `type_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `type_tpl` varchar(30) NOT NULL DEFAULT '',
  `type_tpl_list` varchar(30) NOT NULL DEFAULT '',
  `type_tpl_detail` varchar(30) NOT NULL DEFAULT '',
  `type_tpl_play` varchar(30) NOT NULL DEFAULT '',
  `type_tpl_down` varchar(30) NOT NULL DEFAULT '',
  `type_key` varchar(255) NOT NULL DEFAULT '',
  `type_des` varchar(255) NOT NULL DEFAULT '',
  `type_title` varchar(255) NOT NULL DEFAULT '',
  `type_union` varchar(255) NOT NULL DEFAULT '',
  `type_extend` text
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='APP分类';

--
-- 转存表中的数据 `mac_type`
--

INSERT INTO `mac_type` (`type_id`, `type_name`, `type_en`, `type_sort`, `type_mid`, `type_pid`, `type_status`, `type_tpl`, `type_tpl_list`, `type_tpl_detail`, `type_tpl_play`, `type_tpl_down`, `type_key`, `type_des`, `type_title`, `type_union`, `type_extend`) VALUES
(1, '电影', 'dianying', 1, 1, 0, 1, 'type.html', 'show.html', 'detail.html', 'play.html', 'down.html', '电影,电影大全,电影天堂,最新电影,好看的电影,电影排行榜', '为您提供更新电影、好看的电影排行榜及电影迅雷下载，免费在线观看伦理电影、动作片、喜剧片、爱情片、搞笑片等全新电影。', '电影', '', '{"class":"\\u559c\\u5267,\\u52a8\\u4f5c,\\u7231\\u60c5,\\u60ca\\u609a,\\u72af\\u7f6a,\\u5192\\u9669,\\u79d1\\u5e7b,\\u60ac\\u7591,\\u5267\\u60c5,\\u52a8\\u753b,\\u6b66\\u4fa0,\\u6218\\u4e89,\\u6b4c\\u821e,\\u5947\\u5e7b,\\u4f20\\u8bb0,\\u8b66\\u532a,\\u5386\\u53f2,\\u8fd0\\u52a8,\\u4f26\\u7406,\\u707e\\u96be,\\u897f\\u90e8,\\u9b54\\u5e7b,\\u67aa\\u6218,\\u6050\\u6016,\\u8bb0\\u5f55","area":"\\u5927\\u9646,\\u7f8e\\u56fd,\\u9999\\u6e2f,\\u97e9\\u56fd,\\u82f1\\u56fd,\\u53f0\\u6e7e,\\u65e5\\u672c,\\u6cd5\\u56fd,\\u610f\\u5927\\u5229,\\u5fb7\\u56fd,\\u897f\\u73ed\\u7259,\\u6cf0\\u56fd,\\u5176\\u5b83","lang":"\\u56fd\\u8bed,\\u82f1\\u8bed,\\u7ca4\\u8bed,\\u95fd\\u5357\\u8bed,\\u97e9\\u8bed,\\u65e5\\u8bed,\\u6cd5\\u8bed,\\u5fb7\\u8bed,\\u5176\\u5b83","year":"2020,2019,2018,2017,2016,2015,2014,2013,2012,2011,2010,2009,2008,2006,2005,2004","star":"\\u738b\\u5b9d\\u5f3a,\\u9ec4\\u6e24,\\u5468\\u8fc5,\\u5468\\u51ac\\u96e8,\\u8303\\u51b0\\u51b0,\\u9648\\u5b66\\u51ac,\\u9648\\u4f1f\\u9706,\\u90ed\\u91c7\\u6d01,\\u9093\\u8d85,\\u6210\\u9f99,\\u845b\\u4f18,\\u6797\\u6b63\\u82f1,\\u5f20\\u5bb6\\u8f89,\\u6881\\u671d\\u4f1f,\\u5f90\\u5ce5,\\u90d1\\u607a,\\u5434\\u5f66\\u7956,\\u5218\\u5fb7\\u534e,\\u5468\\u661f\\u9a70,\\u6797\\u9752\\u971e,\\u5468\\u6da6\\u53d1,\\u674e\\u8fde\\u6770,\\u7504\\u5b50\\u4e39,\\u53e4\\u5929\\u4e50,\\u6d2a\\u91d1\\u5b9d,\\u59da\\u6668,\\u502a\\u59ae,\\u9ec4\\u6653\\u660e,\\u5f6d\\u4e8e\\u664f,\\u6c64\\u552f,\\u9648\\u5c0f\\u6625","director":"\\u51af\\u5c0f\\u521a,\\u5f20\\u827a\\u8c0b,\\u5434\\u5b87\\u68ee,\\u9648\\u51ef\\u6b4c,\\u5f90\\u514b,\\u738b\\u5bb6\\u536b,\\u59dc\\u6587,\\u5468\\u661f\\u9a70,\\u674e\\u5b89","state":"\\u6b63\\u7247,\\u9884\\u544a\\u7247,\\u82b1\\u7d6e","version":"\\u9ad8\\u6e05\\u7248,\\u5267\\u573a\\u7248,\\u62a2\\u5148\\u7248,OVA,TV,\\u5f71\\u9662\\u7248"}'),
(2, '连续剧', 'lianxuju', 2, 1, 0, 1, 'type.html', 'show.html', 'detail.html', 'play.html', 'down.html', '电视剧,最新电视剧,好看的电视剧,热播电视剧,电视剧在线观看', '为您提供2018新电视剧排行榜，韩国电视剧、泰国电视剧、香港TVB全新电视剧排行榜、好看的电视剧等热播电视剧排行榜，并提供免费高清电视剧下载及在线观看。', '电视剧', '', '{"class":"\\u53e4\\u88c5,\\u559c\\u5267,\\u5076\\u50cf,\\u5bb6\\u5ead,\\u8b66\\u532a,\\u8a00\\u60c5,\\u519b\\u4e8b,\\u6b66\\u4fa0,\\u60ac\\u7591,\\u5386\\u53f2,\\u519c\\u6751,\\u90fd\\u5e02,\\u795e\\u8bdd,\\u79d1\\u5e7b,\\u5c11\\u513f,\\u641e\\u7b11,\\u8c0d\\u6218,\\u6218\\u4e89,\\u5e74\\u4ee3,\\u72af\\u7f6a,\\u6050\\u6016,\\u60ca\\u609a,\\u7231\\u60c5,\\u5267\\u60c5,\\u5947\\u5e7b","area":"\\u5927\\u9646,\\u97e9\\u56fd,\\u9999\\u6e2f,\\u53f0\\u6e7e,\\u65e5\\u672c,\\u7f8e\\u56fd,\\u6cf0\\u56fd,\\u82f1\\u56fd,\\u65b0\\u52a0\\u5761,\\u5176\\u4ed6,\\u9999\\u6e2f\\u5730\\u533a","lang":"\\u56fd\\u8bed,\\u82f1\\u8bed,\\u7ca4\\u8bed,\\u95fd\\u5357\\u8bed,\\u97e9\\u8bed,\\u65e5\\u8bed,\\u5176\\u5b83","year":"2020,2019,2018,2017,2016,2015,2014,2013,2012,2011,2010,2009,2008,2006,2005,2004","star":"\\u738b\\u5b9d\\u5f3a,\\u80e1\\u6b4c,\\u970d\\u5efa\\u534e,\\u8d75\\u4e3d\\u9896,\\u5218\\u6d9b,\\u5218\\u8bd7\\u8bd7,\\u9648\\u4f1f\\u9706,\\u5434\\u5947\\u9686,\\u9646\\u6bc5,\\u5510\\u5ae3,\\u5173\\u6653\\u5f64,\\u5b59\\u4fea,\\u674e\\u6613\\u5cf0,\\u5f20\\u7ff0,\\u674e\\u6668,\\u8303\\u51b0\\u51b0,\\u6797\\u5fc3\\u5982,\\u6587\\u7ae0,\\u9a6c\\u4f0a\\u740d,\\u4f5f\\u5927\\u4e3a,\\u5b59\\u7ea2\\u96f7,\\u9648\\u5efa\\u658c,\\u674e\\u5c0f\\u7490","director":"\\u5f20\\u7eaa\\u4e2d,\\u674e\\u5c11\\u7ea2,\\u5218\\u6c5f,\\u5b54\\u7b19,\\u5f20\\u9ece,\\u5eb7\\u6d2a\\u96f7,\\u9ad8\\u5e0c\\u5e0c,\\u80e1\\u73ab,\\u8d75\\u5b9d\\u521a,\\u90d1\\u6653\\u9f99","state":"\\u6b63\\u7247,\\u9884\\u544a\\u7247,\\u82b1\\u7d6e","version":"\\u9ad8\\u6e05\\u7248,\\u5267\\u573a\\u7248,\\u62a2\\u5148\\u7248,OVA,TV,\\u5f71\\u9662\\u7248"}'),
(3, '综艺', 'zongyi', 4, 1, 0, 1, 'type.html', 'show.html', 'detail.html', 'play.html', 'down.html', '综艺,综艺节目,最新综艺节目,综艺节目排行榜', '为您提供新综艺节目、好看的综艺节目排行榜，免费高清在线观看选秀、情感、访谈、搞笑、真人秀、脱口秀等热门综艺节目。', '综艺', '', '{"class":"\\u771f\\u4eba\\u79c0,\\u8bbf\\u8c08,\\u60c5\\u611f,\\u9009\\u79c0,\\u65c5\\u6e38,\\u7f8e\\u98df,\\u53e3\\u79c0,\\u66f2\\u827a,\\u641e\\u7b11,\\u6e38\\u620f,\\u6b4c\\u821e,\\u751f\\u6d3b,\\u97f3\\u4e50,\\u65f6\\u5c1a,\\u76ca\\u667a,\\u804c\\u573a,\\u5c11\\u513f,\\u7eaa\\u5b9e,\\u76db\\u4f1a","area":"\\u5927\\u9646,\\u97e9\\u56fd,\\u9999\\u6e2f,\\u53f0\\u6e7e,\\u7f8e\\u56fd,\\u5176\\u5b83","lang":"\\u56fd\\u8bed,\\u82f1\\u8bed,\\u7ca4\\u8bed,\\u95fd\\u5357\\u8bed,\\u97e9\\u8bed,\\u65e5\\u8bed,\\u5176\\u5b83","year":"2020,2019,2018,2017,2016,2015,2014,2013,2012,2011,2010,2009,2008,2007,2006,2005,2004","star":"\\u4f55\\u7085,\\u6c6a\\u6db5,\\u8c22\\u5a1c,\\u5468\\u7acb\\u6ce2,\\u9648\\u9c81\\u8c6b,\\u5b5f\\u975e,\\u674e\\u9759,\\u6731\\u519b,\\u6731\\u4e39,\\u534e\\u5c11,\\u90ed\\u5fb7\\u7eb2,\\u6768\\u6f9c","director":"","state":"","version":""}'),
(4, '动漫', 'dongman', 3, 1, 0, 1, 'type.html', 'show.html', 'detail.html', 'play.html', 'down.html', '动漫,动漫大全,最新动漫,好看的动漫,日本动漫,动漫排行榜', '为您提供新动漫、好看的动漫排行榜，免费高清在线观看热血动漫、卡通动漫、新番动漫、百合动漫、搞笑动漫、国产动漫、动漫电影等热门动漫。', '动画片', '', '{"class":"\\u70ed\\u8840,\\u79d1\\u5e7b,\\u63a8\\u7406,\\u641e\\u7b11,\\u5192\\u9669,\\u6821\\u56ed,\\u52a8\\u4f5c,\\u673a\\u6218,\\u8fd0\\u52a8,\\u6218\\u4e89,\\u5c11\\u5e74,\\u5c11\\u5973,\\u793e\\u4f1a,\\u539f\\u521b,\\u4eb2\\u5b50,\\u76ca\\u667a,\\u52b1\\u5fd7,\\u5176\\u4ed6","area":"\\u5927\\u9646,\\u65e5\\u672c,\\u6b27\\u7f8e,\\u5176\\u4ed6","lang":"\\u56fd\\u8bed,\\u82f1\\u8bed,\\u7ca4\\u8bed,\\u95fd\\u5357\\u8bed,\\u97e9\\u8bed,\\u65e5\\u8bed,\\u5176\\u5b83","year":"2020,2019,2018,2017,2016,2015,2014,2013,2012,2011,2010,2009,2008,2007,2006,2005,2004","star":"","director":"","state":"","version":"TV\\u7248,\\u7535\\u5f71\\u7248,OVA\\u7248,\\u771f\\u4eba\\u7248"}');

-- --------------------------------------------------------

--
-- 表的结构 `mac_ulog`
--

CREATE TABLE IF NOT EXISTS `mac_ulog` (
  `ulog_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `ulog_mid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ulog_type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ulog_rid` int(10) unsigned NOT NULL DEFAULT '0',
  `ulog_sid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ulog_nid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `ulog_points` smallint(6) unsigned NOT NULL DEFAULT '0',
  `ulog_time` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- --------------------------------------------------------

--
-- 表的结构 `mac_user`
--

CREATE TABLE IF NOT EXISTS `mac_user` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(30) DEFAULT '',
  `user_pwd` varchar(32) DEFAULT '',
  `user_nick_name` varchar(30) NOT NULL DEFAULT '',
  `user_qq` varchar(16) NOT NULL DEFAULT '',
  `user_email` varchar(30) NOT NULL DEFAULT '',
  `user_phone` varchar(16) NOT NULL DEFAULT '',
  `user_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `user_portrait` varchar(100) NOT NULL DEFAULT '',
  `user_portrait_thumb` varchar(100) NOT NULL DEFAULT '',
  `user_openid_qq` varchar(40) NOT NULL DEFAULT '',
  `user_openid_weixin` varchar(40) NOT NULL DEFAULT '',
  `user_question` varchar(255) NOT NULL DEFAULT '',
  `user_answer` varchar(255) NOT NULL DEFAULT '',
  `user_points` int(10) unsigned NOT NULL DEFAULT '0',
  `user_points_froze` int(10) unsigned NOT NULL DEFAULT '0',
  `user_reg_time` int(10) unsigned NOT NULL DEFAULT '0',
  `user_reg_ip` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_login_time` int(10) unsigned NOT NULL DEFAULT '0',
  `user_login_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `user_last_login_time` int(10) unsigned NOT NULL DEFAULT '0',
  `user_login_today` int(10) NOT NULL DEFAULT '0',
  `user_last_login_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `user_login_num` smallint(6) unsigned NOT NULL DEFAULT '0',
  `user_extend` smallint(6) unsigned NOT NULL DEFAULT '0',
  `user_random` varchar(32) NOT NULL DEFAULT '',
  `user_end_time` int(10) unsigned NOT NULL DEFAULT '0',
  `user_pid` int(10) unsigned NOT NULL DEFAULT '0',
  `user_pid_2` int(10) unsigned NOT NULL DEFAULT '0',
  `user_pid_3` int(10) unsigned NOT NULL DEFAULT '0',
  `is_agents` int(11) NOT NULL DEFAULT '0',
  `user_gold` int(8) NOT NULL DEFAULT '0' COMMENT '用户拥有金币',
  `view_times` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='会员用户数据';

-- --------------------------------------------------------

--
-- 表的结构 `mac_view30m`
--

CREATE TABLE IF NOT EXISTS `mac_view30m` (
  `id` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `view_seconds` int(255) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `vod_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `mac_visit`
--

CREATE TABLE IF NOT EXISTS `mac_visit` (
  `visit_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT '0',
  `visit_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `visit_ly` varchar(100) NOT NULL DEFAULT '',
  `visit_time` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `mac_vlog`
--

CREATE TABLE IF NOT EXISTS `mac_vlog` (
  `id` int(11) NOT NULL,
  `vod_id` int(11) DEFAULT NULL,
  `nid` varchar(200) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `percent` varchar(255) DEFAULT NULL,
  `last_view_time` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `curProgress` int(11) NOT NULL,
  `urlIndex` int(11) NOT NULL,
  `playSourceIndex` int(11) NOT NULL,
  `isvip` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='APP播放记录';

-- --------------------------------------------------------

--
-- 表的结构 `mac_vod`
--

CREATE TABLE IF NOT EXISTS `mac_vod` (
  `vod_id` int(10) unsigned NOT NULL,
  `type_id` smallint(6) NOT NULL DEFAULT '0',
  `type_id_1` smallint(6) unsigned NOT NULL DEFAULT '0',
  `group_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `vod_name` varchar(255) NOT NULL DEFAULT '',
  `vod_sub` varchar(255) NOT NULL DEFAULT '',
  `vod_en` varchar(255) NOT NULL DEFAULT '',
  `vod_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vod_letter` char(1) NOT NULL DEFAULT '',
  `vod_color` varchar(6) NOT NULL DEFAULT '',
  `vod_tag` varchar(100) NOT NULL DEFAULT '',
  `vod_custom_tag` varchar(100) DEFAULT NULL,
  `vod_class` varchar(255) NOT NULL DEFAULT '',
  `vod_pic` varchar(255) NOT NULL DEFAULT '',
  `vod_pic_thumb` varchar(255) NOT NULL DEFAULT '',
  `vod_pic_slide` varchar(255) NOT NULL DEFAULT '',
  `vod_actor` varchar(255) NOT NULL DEFAULT '',
  `vod_director` varchar(255) NOT NULL DEFAULT '',
  `vod_writer` varchar(100) NOT NULL DEFAULT '',
  `vod_behind` varchar(100) NOT NULL DEFAULT '',
  `vod_blurb` varchar(255) NOT NULL DEFAULT '',
  `vod_remarks` varchar(100) NOT NULL DEFAULT '',
  `vod_pubdate` varchar(100) NOT NULL DEFAULT '',
  `vod_total` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_serial` varchar(20) NOT NULL DEFAULT '0',
  `vod_tv` varchar(30) NOT NULL DEFAULT '',
  `vod_weekday` varchar(30) NOT NULL DEFAULT '',
  `vod_area` varchar(20) NOT NULL DEFAULT '',
  `vod_lang` varchar(10) NOT NULL DEFAULT '',
  `vod_year` varchar(10) NOT NULL DEFAULT '',
  `vod_version` varchar(30) NOT NULL DEFAULT '',
  `vod_state` varchar(30) NOT NULL DEFAULT '',
  `vod_author` varchar(60) NOT NULL DEFAULT '',
  `vod_jumpurl` varchar(150) NOT NULL DEFAULT '',
  `vod_tpl` varchar(30) NOT NULL DEFAULT '',
  `vod_tpl_play` varchar(30) NOT NULL DEFAULT '',
  `vod_tpl_down` varchar(30) NOT NULL DEFAULT '',
  `vod_isend` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vod_lock` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vod_level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vod_levels` int(11) NOT NULL DEFAULT '0',
  `vod_copyright` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vod_points` smallint(6) unsigned NOT NULL DEFAULT '0',
  `vod_points_play` smallint(6) unsigned NOT NULL DEFAULT '0',
  `vod_points_down` smallint(6) unsigned NOT NULL DEFAULT '0',
  `vod_hits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_hits_day` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_hits_week` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_hits_month` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_duration` varchar(10) NOT NULL DEFAULT '',
  `vod_up` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_down` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_score` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `vod_score_all` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_score_num` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_time` int(10) unsigned NOT NULL DEFAULT '0',
  `vod_time_add` int(10) unsigned NOT NULL DEFAULT '0',
  `vod_time_hits` int(10) unsigned NOT NULL DEFAULT '0',
  `vod_time_make` int(10) unsigned NOT NULL DEFAULT '0',
  `vod_trysee` smallint(6) unsigned NOT NULL DEFAULT '0',
  `vod_douban_id` int(10) unsigned NOT NULL DEFAULT '0',
  `vod_douban_score` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `vod_reurl` varchar(255) NOT NULL DEFAULT '',
  `vod_rel_vod` varchar(255) NOT NULL DEFAULT '',
  `vod_rel_art` varchar(255) NOT NULL DEFAULT '',
  `vod_pwd` varchar(10) NOT NULL DEFAULT '',
  `vod_pwd_url` varchar(255) NOT NULL DEFAULT '',
  `vod_pwd_play` varchar(10) NOT NULL DEFAULT '',
  `vod_pwd_play_url` varchar(255) NOT NULL DEFAULT '',
  `vod_pwd_down` varchar(10) NOT NULL DEFAULT '',
  `vod_pwd_down_url` varchar(255) NOT NULL DEFAULT '',
  `vod_content` text NOT NULL,
  `vod_play_from` varchar(255) NOT NULL DEFAULT '',
  `vod_play_server` varchar(255) NOT NULL DEFAULT '',
  `vod_play_note` varchar(255) NOT NULL DEFAULT '',
  `vod_play_url` mediumtext NOT NULL,
  `vod_down_from` varchar(255) NOT NULL DEFAULT '',
  `vod_down_server` varchar(255) NOT NULL DEFAULT '',
  `vod_down_note` varchar(255) NOT NULL DEFAULT '',
  `vod_down_url` mediumtext NOT NULL,
  `vod_plot` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vod_plot_name` mediumtext NOT NULL,
  `vod_plot_detail` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `mac_youxi`
--

CREATE TABLE IF NOT EXISTS `mac_youxi` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `img` varchar(500) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='APP游戏页面';

--
-- 转存表中的数据 `mac_youxi`
--

INSERT INTO `mac_youxi` (`id`, `name`, `img`, `url`) VALUES
(1, '游戏', '1', 'https://www.nineqing.net/');

-- --------------------------------------------------------

--
-- 表的结构 `mac_zhibo`
--

CREATE TABLE IF NOT EXISTS `mac_zhibo` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `img` varchar(500) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='直播';

--
-- 转存表中的数据 `mac_zhibo`
--

INSERT INTO `mac_zhibo` (`id`, `name`, `img`, `url`) VALUES
(1, '求片中心', 'https://nineqing-com-file-1253682899.cos.ap-beijing.myqcloud.com/2020/08/1597080182-b03f960de6c7939.png', 'https://ys.nineqing.net/'),
(2, '玖卿云视听', 'https://nineqing-com-file-1253682899.cos.ap-beijing.myqcloud.com/NineQing%20AudioVisual%20File/images/Logo.png', 'https://m.nineqing.com/'),
(3, '玖卿云盘', 'https://cloudreve.org/img/logo.png', 'https://pan.nineqing.net/');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mac_actor`
--
ALTER TABLE `mac_actor`
  ADD PRIMARY KEY (`actor_id`) USING BTREE,
  ADD KEY `actor_name` (`actor_name`) USING BTREE,
  ADD KEY `actor_en` (`actor_en`) USING BTREE,
  ADD KEY `actor_letter` (`actor_letter`) USING BTREE,
  ADD KEY `actor_level` (`actor_level`) USING BTREE,
  ADD KEY `actor_time` (`actor_time`) USING BTREE,
  ADD KEY `actor_time_add` (`actor_time_add`) USING BTREE,
  ADD KEY `actor_sex` (`actor_sex`) USING BTREE,
  ADD KEY `actor_area` (`actor_area`) USING BTREE,
  ADD KEY `actor_up` (`actor_up`) USING BTREE,
  ADD KEY `actor_down` (`actor_down`) USING BTREE,
  ADD KEY `actor_score` (`actor_score`) USING BTREE,
  ADD KEY `actor_score_all` (`actor_score_all`) USING BTREE,
  ADD KEY `actor_score_num` (`actor_score_num`) USING BTREE;

--
-- Indexes for table `mac_admin`
--
ALTER TABLE `mac_admin`
  ADD PRIMARY KEY (`admin_id`) USING BTREE,
  ADD KEY `admin_name` (`admin_name`) USING BTREE;

--
-- Indexes for table `mac_adtype`
--
ALTER TABLE `mac_adtype`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `mac_app_install_record`
--
ALTER TABLE `mac_app_install_record`
  ADD PRIMARY KEY (`app_install_record_id`);

--
-- Indexes for table `mac_app_version`
--
ALTER TABLE `mac_app_version`
  ADD PRIMARY KEY (`app_version_id`);

--
-- Indexes for table `mac_art`
--
ALTER TABLE `mac_art`
  ADD PRIMARY KEY (`art_id`) USING BTREE,
  ADD KEY `type_id` (`type_id`) USING BTREE,
  ADD KEY `type_id_1` (`type_id_1`) USING BTREE,
  ADD KEY `art_level` (`art_level`) USING BTREE,
  ADD KEY `art_hits` (`art_hits`) USING BTREE,
  ADD KEY `art_time` (`art_time`) USING BTREE,
  ADD KEY `art_letter` (`art_letter`) USING BTREE,
  ADD KEY `art_down` (`art_down`) USING BTREE,
  ADD KEY `art_up` (`art_up`) USING BTREE,
  ADD KEY `art_tag` (`art_tag`) USING BTREE,
  ADD KEY `art_name` (`art_name`) USING BTREE,
  ADD KEY `art_enname` (`art_en`) USING BTREE,
  ADD KEY `art_hits_day` (`art_hits_day`) USING BTREE,
  ADD KEY `art_hits_week` (`art_hits_week`) USING BTREE,
  ADD KEY `art_hits_month` (`art_hits_month`) USING BTREE,
  ADD KEY `art_time_add` (`art_time_add`) USING BTREE,
  ADD KEY `art_time_make` (`art_time_make`) USING BTREE,
  ADD KEY `art_lock` (`art_lock`) USING BTREE,
  ADD KEY `art_score` (`art_score`) USING BTREE,
  ADD KEY `art_score_all` (`art_score_all`) USING BTREE,
  ADD KEY `art_score_num` (`art_score_num`) USING BTREE;

--
-- Indexes for table `mac_card`
--
ALTER TABLE `mac_card`
  ADD PRIMARY KEY (`card_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `card_add_time` (`card_add_time`) USING BTREE,
  ADD KEY `card_use_time` (`card_use_time`) USING BTREE,
  ADD KEY `card_no` (`card_no`) USING BTREE,
  ADD KEY `card_pwd` (`card_pwd`) USING BTREE;

--
-- Indexes for table `mac_cash`
--
ALTER TABLE `mac_cash`
  ADD PRIMARY KEY (`cash_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `cash_status` (`cash_status`) USING BTREE;

--
-- Indexes for table `mac_category`
--
ALTER TABLE `mac_category`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `mac_cj_content`
--
ALTER TABLE `mac_cj_content`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `nodeid` (`nodeid`) USING BTREE,
  ADD KEY `status` (`status`) USING BTREE;

--
-- Indexes for table `mac_cj_history`
--
ALTER TABLE `mac_cj_history`
  ADD PRIMARY KEY (`md5`) USING BTREE,
  ADD KEY `md5` (`md5`) USING BTREE;

--
-- Indexes for table `mac_cj_node`
--
ALTER TABLE `mac_cj_node`
  ADD PRIMARY KEY (`nodeid`) USING BTREE;

--
-- Indexes for table `mac_collect`
--
ALTER TABLE `mac_collect`
  ADD PRIMARY KEY (`collect_id`) USING BTREE;

--
-- Indexes for table `mac_comment`
--
ALTER TABLE `mac_comment`
  ADD PRIMARY KEY (`comment_id`) USING BTREE,
  ADD KEY `comment_mid` (`comment_mid`) USING BTREE,
  ADD KEY `comment_rid` (`comment_rid`) USING BTREE,
  ADD KEY `comment_time` (`comment_time`) USING BTREE,
  ADD KEY `comment_pid` (`comment_pid`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `comment_reply` (`comment_reply`) USING BTREE;

--
-- Indexes for table `mac_danmu`
--
ALTER TABLE `mac_danmu`
  ADD PRIMARY KEY (`danmu_id`);

--
-- Indexes for table `mac_gbook`
--
ALTER TABLE `mac_gbook`
  ADD PRIMARY KEY (`gbook_id`) USING BTREE,
  ADD KEY `gbook_rid` (`gbook_rid`) USING BTREE,
  ADD KEY `gbook_time` (`gbook_time`) USING BTREE,
  ADD KEY `gbook_reply_time` (`gbook_reply_time`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `gbook_reply` (`gbook_reply`) USING BTREE;

--
-- Indexes for table `mac_glog`
--
ALTER TABLE `mac_glog`
  ADD PRIMARY KEY (`glog_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `glog_type` (`glog_type`) USING BTREE;

--
-- Indexes for table `mac_gold_withdraw_apply`
--
ALTER TABLE `mac_gold_withdraw_apply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mac_group`
--
ALTER TABLE `mac_group`
  ADD PRIMARY KEY (`group_id`) USING BTREE,
  ADD KEY `group_status` (`group_status`) USING BTREE;

--
-- Indexes for table `mac_groupchat`
--
ALTER TABLE `mac_groupchat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mac_link`
--
ALTER TABLE `mac_link`
  ADD PRIMARY KEY (`link_id`) USING BTREE,
  ADD KEY `link_sort` (`link_sort`) USING BTREE,
  ADD KEY `link_type` (`link_type`) USING BTREE,
  ADD KEY `link_add_time` (`link_add_time`) USING BTREE,
  ADD KEY `link_time` (`link_time`) USING BTREE;

--
-- Indexes for table `mac_message`
--
ALTER TABLE `mac_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mac_msg`
--
ALTER TABLE `mac_msg`
  ADD PRIMARY KEY (`msg_id`) USING BTREE,
  ADD KEY `msg_code` (`msg_code`) USING BTREE,
  ADD KEY `msg_time` (`msg_time`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `mac_order`
--
ALTER TABLE `mac_order`
  ADD PRIMARY KEY (`order_id`) USING BTREE,
  ADD KEY `order_code` (`order_code`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `order_time` (`order_time`) USING BTREE;

--
-- Indexes for table `mac_plog`
--
ALTER TABLE `mac_plog`
  ADD PRIMARY KEY (`plog_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `plog_type` (`plog_type`) USING BTREE;

--
-- Indexes for table `mac_role`
--
ALTER TABLE `mac_role`
  ADD PRIMARY KEY (`role_id`) USING BTREE,
  ADD KEY `role_rid` (`role_rid`) USING BTREE,
  ADD KEY `role_name` (`role_name`) USING BTREE,
  ADD KEY `role_en` (`role_en`) USING BTREE,
  ADD KEY `role_letter` (`role_letter`) USING BTREE,
  ADD KEY `role_actor` (`role_actor`) USING BTREE,
  ADD KEY `role_level` (`role_level`) USING BTREE,
  ADD KEY `role_time` (`role_time`) USING BTREE,
  ADD KEY `role_time_add` (`role_time_add`) USING BTREE,
  ADD KEY `role_score` (`role_score`) USING BTREE,
  ADD KEY `role_score_all` (`role_score_all`) USING BTREE,
  ADD KEY `role_score_num` (`role_score_num`) USING BTREE,
  ADD KEY `role_up` (`role_up`) USING BTREE,
  ADD KEY `role_down` (`role_down`) USING BTREE;

--
-- Indexes for table `mac_sign`
--
ALTER TABLE `mac_sign`
  ADD PRIMARY KEY (`sign_id`);

--
-- Indexes for table `mac_topic`
--
ALTER TABLE `mac_topic`
  ADD PRIMARY KEY (`topic_id`) USING BTREE,
  ADD KEY `topic_sort` (`topic_sort`) USING BTREE,
  ADD KEY `topic_level` (`topic_level`) USING BTREE,
  ADD KEY `topic_score` (`topic_score`) USING BTREE,
  ADD KEY `topic_score_all` (`topic_score_all`) USING BTREE,
  ADD KEY `topic_score_num` (`topic_score_num`) USING BTREE,
  ADD KEY `topic_hits` (`topic_hits`) USING BTREE,
  ADD KEY `topic_hits_day` (`topic_hits_day`) USING BTREE,
  ADD KEY `topic_hits_week` (`topic_hits_week`) USING BTREE,
  ADD KEY `topic_hits_month` (`topic_hits_month`) USING BTREE,
  ADD KEY `topic_time_add` (`topic_time_add`) USING BTREE,
  ADD KEY `topic_time` (`topic_time`) USING BTREE,
  ADD KEY `topic_time_hits` (`topic_time_hits`) USING BTREE,
  ADD KEY `topic_name` (`topic_name`) USING BTREE,
  ADD KEY `topic_en` (`topic_en`) USING BTREE,
  ADD KEY `topic_up` (`topic_up`) USING BTREE,
  ADD KEY `topic_down` (`topic_down`) USING BTREE;

--
-- Indexes for table `mac_type`
--
ALTER TABLE `mac_type`
  ADD PRIMARY KEY (`type_id`) USING BTREE,
  ADD KEY `type_sort` (`type_sort`) USING BTREE,
  ADD KEY `type_pid` (`type_pid`) USING BTREE,
  ADD KEY `type_name` (`type_name`) USING BTREE,
  ADD KEY `type_en` (`type_en`) USING BTREE,
  ADD KEY `type_mid` (`type_mid`) USING BTREE;

--
-- Indexes for table `mac_ulog`
--
ALTER TABLE `mac_ulog`
  ADD PRIMARY KEY (`ulog_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `ulog_mid` (`ulog_mid`) USING BTREE,
  ADD KEY `ulog_type` (`ulog_type`) USING BTREE,
  ADD KEY `ulog_rid` (`ulog_rid`) USING BTREE;

--
-- Indexes for table `mac_user`
--
ALTER TABLE `mac_user`
  ADD PRIMARY KEY (`user_id`) USING BTREE,
  ADD KEY `type_id` (`group_id`) USING BTREE,
  ADD KEY `user_name` (`user_name`) USING BTREE,
  ADD KEY `user_reg_time` (`user_reg_time`) USING BTREE;

--
-- Indexes for table `mac_view30m`
--
ALTER TABLE `mac_view30m`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `mac_visit`
--
ALTER TABLE `mac_visit`
  ADD PRIMARY KEY (`visit_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `visit_time` (`visit_time`) USING BTREE;

--
-- Indexes for table `mac_vlog`
--
ALTER TABLE `mac_vlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mac_vod`
--
ALTER TABLE `mac_vod`
  ADD PRIMARY KEY (`vod_id`),
  ADD KEY `type_id` (`type_id`) USING BTREE,
  ADD KEY `type_id_1` (`type_id_1`) USING BTREE,
  ADD KEY `vod_level` (`vod_level`) USING BTREE,
  ADD KEY `vod_hits` (`vod_hits`) USING BTREE,
  ADD KEY `vod_letter` (`vod_letter`) USING BTREE,
  ADD KEY `vod_name` (`vod_name`) USING BTREE,
  ADD KEY `vod_year` (`vod_year`) USING BTREE,
  ADD KEY `vod_area` (`vod_area`) USING BTREE,
  ADD KEY `vod_lang` (`vod_lang`) USING BTREE,
  ADD KEY `vod_tag` (`vod_tag`) USING BTREE,
  ADD KEY `vod_class` (`vod_class`) USING BTREE,
  ADD KEY `vod_lock` (`vod_lock`) USING BTREE,
  ADD KEY `vod_up` (`vod_up`) USING BTREE,
  ADD KEY `vod_down` (`vod_down`) USING BTREE,
  ADD KEY `vod_en` (`vod_en`) USING BTREE,
  ADD KEY `vod_hits_day` (`vod_hits_day`) USING BTREE,
  ADD KEY `vod_hits_week` (`vod_hits_week`) USING BTREE,
  ADD KEY `vod_hits_month` (`vod_hits_month`) USING BTREE,
  ADD KEY `vod_plot` (`vod_plot`) USING BTREE,
  ADD KEY `vod_points_play` (`vod_points_play`) USING BTREE,
  ADD KEY `vod_points_down` (`vod_points_down`) USING BTREE,
  ADD KEY `group_id` (`group_id`) USING BTREE,
  ADD KEY `vod_time_add` (`vod_time_add`) USING BTREE,
  ADD KEY `vod_time` (`vod_time`) USING BTREE,
  ADD KEY `vod_time_make` (`vod_time_make`) USING BTREE,
  ADD KEY `vod_actor` (`vod_actor`) USING BTREE,
  ADD KEY `vod_director` (`vod_director`) USING BTREE,
  ADD KEY `vod_score_all` (`vod_score_all`) USING BTREE,
  ADD KEY `vod_score_num` (`vod_score_num`) USING BTREE,
  ADD KEY `vod_total` (`vod_total`) USING BTREE,
  ADD KEY `vod_score` (`vod_score`) USING BTREE,
  ADD KEY `vod_version` (`vod_version`),
  ADD KEY `vod_state` (`vod_state`),
  ADD KEY `vod_isend` (`vod_isend`);

--
-- Indexes for table `mac_youxi`
--
ALTER TABLE `mac_youxi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mac_zhibo`
--
ALTER TABLE `mac_zhibo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mac_actor`
--
ALTER TABLE `mac_actor`
  MODIFY `actor_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_admin`
--
ALTER TABLE `mac_admin`
  MODIFY `admin_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_adtype`
--
ALTER TABLE `mac_adtype`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `mac_app_install_record`
--
ALTER TABLE `mac_app_install_record`
  MODIFY `app_install_record_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_app_version`
--
ALTER TABLE `mac_app_version`
  MODIFY `app_version_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mac_art`
--
ALTER TABLE `mac_art`
  MODIFY `art_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_card`
--
ALTER TABLE `mac_card`
  MODIFY `card_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_cash`
--
ALTER TABLE `mac_cash`
  MODIFY `cash_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mac_category`
--
ALTER TABLE `mac_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `mac_cj_content`
--
ALTER TABLE `mac_cj_content`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_cj_node`
--
ALTER TABLE `mac_cj_node`
  MODIFY `nodeid` smallint(6) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_collect`
--
ALTER TABLE `mac_collect`
  MODIFY `collect_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `mac_comment`
--
ALTER TABLE `mac_comment`
  MODIFY `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_danmu`
--
ALTER TABLE `mac_danmu`
  MODIFY `danmu_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_gbook`
--
ALTER TABLE `mac_gbook`
  MODIFY `gbook_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_glog`
--
ALTER TABLE `mac_glog`
  MODIFY `glog_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_gold_withdraw_apply`
--
ALTER TABLE `mac_gold_withdraw_apply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_group`
--
ALTER TABLE `mac_group`
  MODIFY `group_id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `mac_groupchat`
--
ALTER TABLE `mac_groupchat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_link`
--
ALTER TABLE `mac_link`
  MODIFY `link_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_message`
--
ALTER TABLE `mac_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `mac_msg`
--
ALTER TABLE `mac_msg`
  MODIFY `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_order`
--
ALTER TABLE `mac_order`
  MODIFY `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_plog`
--
ALTER TABLE `mac_plog`
  MODIFY `plog_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_role`
--
ALTER TABLE `mac_role`
  MODIFY `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_sign`
--
ALTER TABLE `mac_sign`
  MODIFY `sign_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_topic`
--
ALTER TABLE `mac_topic`
  MODIFY `topic_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `mac_type`
--
ALTER TABLE `mac_type`
  MODIFY `type_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `mac_ulog`
--
ALTER TABLE `mac_ulog`
  MODIFY `ulog_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_user`
--
ALTER TABLE `mac_user`
  MODIFY `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_view30m`
--
ALTER TABLE `mac_view30m`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_visit`
--
ALTER TABLE `mac_visit`
  MODIFY `visit_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_vlog`
--
ALTER TABLE `mac_vlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_vod`
--
ALTER TABLE `mac_vod`
  MODIFY `vod_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mac_youxi`
--
ALTER TABLE `mac_youxi`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `mac_zhibo`
--
ALTER TABLE `mac_zhibo`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;