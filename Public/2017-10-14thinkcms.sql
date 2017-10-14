/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : thinkcms

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-10-14 17:30:26
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for bt_admin_menus
-- ----------------------------
DROP TABLE IF EXISTS `bt_admin_menus`;
CREATE TABLE `bt_admin_menus` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '模块/控制器/方法',
  `icon` varchar(50) NOT NULL DEFAULT 'th' COMMENT '菜单图标',
  `order_number` int(11) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='后台菜单表';

-- ----------------------------
-- Records of bt_admin_menus
-- ----------------------------
INSERT INTO `bt_admin_menus` VALUES ('1', '0', '菜单管理', '', 'th', '100');
INSERT INTO `bt_admin_menus` VALUES ('2', '0', '权限控制', '', 'th', '1');
INSERT INTO `bt_admin_menus` VALUES ('3', '1', '菜单列表', 'Admin/menus/index', 'th', '101');
INSERT INTO `bt_admin_menus` VALUES ('4', '0', '设置', '', 'th', '100');
INSERT INTO `bt_admin_menus` VALUES ('5', '4', '个人信息', 'dddd', 'th', '100');
INSERT INTO `bt_admin_menus` VALUES ('6', '2', '用户组管理', '', 'th', '100');
INSERT INTO `bt_admin_menus` VALUES ('7', '2', '权限管理', 'Admin/Rule/index', 'th', '100');

-- ----------------------------
-- Table structure for bt_admin_nav
-- ----------------------------
DROP TABLE IF EXISTS `bt_admin_nav`;
CREATE TABLE `bt_admin_nav` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单表',
  `pid` int(11) unsigned DEFAULT '0' COMMENT '所属菜单',
  `name` varchar(15) DEFAULT '' COMMENT '菜单名称',
  `mca` varchar(255) DEFAULT '' COMMENT '模块、控制器、方法',
  `ico` varchar(20) DEFAULT '' COMMENT 'font-awesome图标',
  `order_number` int(11) unsigned DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bt_admin_nav
-- ----------------------------
INSERT INTO `bt_admin_nav` VALUES ('1', '0', '网站', 'Admin/ShowNav/config', 'cog', '1');
INSERT INTO `bt_admin_nav` VALUES ('2', '1', '菜单管理', 'Admin/Nav/index', null, null);
INSERT INTO `bt_admin_nav` VALUES ('7', '4', '权限管理', 'Admin/Rule/index', '', '1');
INSERT INTO `bt_admin_nav` VALUES ('4', '0', '权限控制', 'Admin/ShowNav/rule', 'expeditedssl', '2');
INSERT INTO `bt_admin_nav` VALUES ('8', '4', '用户组管理', 'Admin/Rule/group', '', '2');
INSERT INTO `bt_admin_nav` VALUES ('9', '4', '管理员列表', 'Admin/Rule/admin_user_list', '', '3');
INSERT INTO `bt_admin_nav` VALUES ('39', '0', '个人资料', 'Admin/Personal/index', 'user', null);
INSERT INTO `bt_admin_nav` VALUES ('40', '1', '控制台', 'Admin/Index/console', 'server', null);
INSERT INTO `bt_admin_nav` VALUES ('41', '0', '品牌管理', 'Admin/ShowNav/brands', 'server', null);
INSERT INTO `bt_admin_nav` VALUES ('42', '41', '品牌列表', 'Admin/Brands/index', '', null);
INSERT INTO `bt_admin_nav` VALUES ('43', '0', '客户资源', 'Admin/ShowNav/data', 'navicon', null);
INSERT INTO `bt_admin_nav` VALUES ('44', '43', '总列表', 'Admin/Resource/index', '', null);
INSERT INTO `bt_admin_nav` VALUES ('46', '43', '数据列表', 'Admin/Resource/customer', '', null);
INSERT INTO `bt_admin_nav` VALUES ('47', '41', '品牌分配规则', 'Admin/Brands/brand_auth', '', null);
INSERT INTO `bt_admin_nav` VALUES ('48', '43', '数据审核', 'Admin/Resource/audit', '', null);
INSERT INTO `bt_admin_nav` VALUES ('49', '0', '区域管理', 'Admin/ShowNav/area', 'home', null);
INSERT INTO `bt_admin_nav` VALUES ('50', '49', '区域列表', 'Admin/Area/index', '', null);
INSERT INTO `bt_admin_nav` VALUES ('51', '49', '区域分配', 'Admin/Area/province', '', null);
INSERT INTO `bt_admin_nav` VALUES ('52', '41', '分配总数', 'Admin/Brands/total', '', null);

-- ----------------------------
-- Table structure for bt_area
-- ----------------------------
DROP TABLE IF EXISTS `bt_area`;
CREATE TABLE `bt_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `area_name` varchar(30) NOT NULL DEFAULT '' COMMENT '区域名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='区域表';

-- ----------------------------
-- Records of bt_area
-- ----------------------------
INSERT INTO `bt_area` VALUES ('1', '广州区域');
INSERT INTO `bt_area` VALUES ('3', '南京区域');

-- ----------------------------
-- Table structure for bt_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `bt_auth_group`;
CREATE TABLE `bt_auth_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` text COMMENT '规则id',
  `area_id` varchar(30) NOT NULL COMMENT '区域id,逗号分隔',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='用户组表';

-- ----------------------------
-- Records of bt_auth_group
-- ----------------------------
INSERT INTO `bt_auth_group` VALUES ('1', '超级管理员', '1', '6,96,20,1,2,3,4,5,64,128,21,7,8,9,10,11,12,13,14,15,16,123,124,125,19,126,148,129,130,131,132,133,140,141,143,144,145,155,156,157,134,135,136,137,138,139,158,159,146,147,149,150,151,152,153,154', '1,3');
INSERT INTO `bt_auth_group` VALUES ('6', '客服组', '1', null, '1,3');

-- ----------------------------
-- Table structure for bt_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `bt_auth_group_access`;
CREATE TABLE `bt_auth_group_access` (
  `uid` int(11) unsigned NOT NULL COMMENT '用户id',
  `group_id` int(11) unsigned NOT NULL COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组明细表';

-- ----------------------------
-- Records of bt_auth_group_access
-- ----------------------------
INSERT INTO `bt_auth_group_access` VALUES ('88', '1');
INSERT INTO `bt_auth_group_access` VALUES ('88', '6');
INSERT INTO `bt_auth_group_access` VALUES ('89', '6');
INSERT INTO `bt_auth_group_access` VALUES ('92', '1');
INSERT INTO `bt_auth_group_access` VALUES ('92', '6');

-- ----------------------------
-- Table structure for bt_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `bt_auth_rule`;
CREATE TABLE `bt_auth_rule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=160 DEFAULT CHARSET=utf8 COMMENT='规则表';

-- ----------------------------
-- Records of bt_auth_rule
-- ----------------------------
INSERT INTO `bt_auth_rule` VALUES ('1', '20', 'Admin/ShowNav/nav', '菜单管理', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('2', '1', 'Admin/Nav/index', '菜单列表', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('3', '1', 'Admin/Nav/add', '添加菜单', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('4', '1', 'Admin/Nav/edit', '修改菜单', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('5', '1', 'Admin/Nav/delete', '删除菜单', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('21', '0', 'Admin/ShowNav/rule', '权限控制', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('7', '21', 'Admin/Rule/index', '权限管理', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('8', '7', 'Admin/Rule/add', '添加权限', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('9', '7', 'Admin/Rule/edit', '修改权限', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('10', '7', 'Admin/Rule/delete', '删除权限', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('11', '21', 'Admin/Rule/group', '用户组管理', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('12', '11', 'Admin/Rule/add_group', '添加用户组', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('13', '11', 'Admin/Rule/edit_group', '修改用户组', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('14', '11', 'Admin/Rule/delete_group', '删除用户组', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('15', '11', 'Admin/Rule/rule_group', '分配权限', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('16', '11', 'Admin/Rule/check_user', '添加成员', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('19', '21', 'Admin/Rule/admin_user_list', '管理员列表', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('20', '0', 'Admin/ShowNav/config', '网站', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('6', '0', 'Admin/Index/index', '后台首页', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('64', '1', 'Admin/Nav/order', '菜单排序', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('96', '6', 'Admin/Index/welcome', '欢迎界面', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('126', '0', 'Admin/Personal/index', '个人资料', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('128', '20', 'Admin/Index/console', '控制台', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('129', '0', 'Admin/ShowNav/brands', '品牌管理', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('130', '129', 'Admin/Brands/index', '品牌列表', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('131', '130', 'Admin/Brands/delete', '删除品牌', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('133', '130', 'Admin/Brands/edit', '修改品牌', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('134', '0', 'Admin/ShowNav/data', '客户资源', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('135', '134', 'Admin/Resource/index', '总列表', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('136', '134', 'Admin/Resource/customer', '数据列表', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('137', '136', 'Admin/Resource/delete', '删除数据', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('132', '130', 'Admin/Brands/add', '品牌添加', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('123', '11', 'Admin/Rule/add_user_to_group', '设置为管理员', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('124', '11', 'Admin/Rule/add_admin', '添加管理员', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('125', '11', 'Admin/Rule/edit_admin', '修改管理员', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('138', '136', 'Admin/Resource/modify', '修改数据', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('139', '136', 'Admin/Resource/add_resource', '添加数据', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('140', '129', 'Admin/Brands/brand_auth', '品牌分配规则', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('141', '140', 'Admin/Brands/detail', '分配详情', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('143', '140', 'Admin/Brands/del_brand', '删除分配品牌', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('144', '140', 'Admin/Brands/edit_brand', '修改分配数量', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('145', '140', 'Admin/Brands/allot', '分配数据', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('146', '134', 'Admin/Resource/audit', '数据审核', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('147', '146', 'Admin/Resource/group_modify', '修改数据', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('148', '126', 'Admin/Personal/edit', '修改密码', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('149', '0', 'Admin/ShowNav/area', '区域管理', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('150', '149', 'Admin/Area/index', '区域列表', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('151', '150', 'Admin/Area/delete', '删除区域', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('152', '150', 'Admin/Area/add', '添加数据', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('153', '150', 'Admin/Area/edit', '修改数据', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('154', '149', 'Admin/Area/province', '区域分配', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('155', '129', 'Admin/Brands/total', '分配总数', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('156', '155', 'Admin/Brands/add_total', '添加数据', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('157', '155', 'Admin/Brands/edit_total', '修改数据', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('158', '136', 'Admin/Resource/customerExport', '导出数据', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('159', '136', 'Admin/Resource/group', '获取用户组', '1', '1', '');

-- ----------------------------
-- Table structure for bt_brands
-- ----------------------------
DROP TABLE IF EXISTS `bt_brands`;
CREATE TABLE `bt_brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增id',
  `name` varchar(30) NOT NULL COMMENT '品牌名称',
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1正常，0：禁用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='品牌表';

-- ----------------------------
-- Records of bt_brands
-- ----------------------------
INSERT INTO `bt_brands` VALUES ('1', '拉水电费', '1500000000', '1');
INSERT INTO `bt_brands` VALUES ('3', '南京区域', '1507544619', '1');
INSERT INTO `bt_brands` VALUES ('4', 'AAAddfaa', '1507544960', '1');

-- ----------------------------
-- Table structure for bt_brands_auth
-- ----------------------------
DROP TABLE IF EXISTS `bt_brands_auth`;
CREATE TABLE `bt_brands_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增id',
  `brands_id` int(11) NOT NULL COMMENT '品牌id',
  `gid` int(11) NOT NULL COMMENT '角色id（组id）',
  `count` varchar(10) NOT NULL DEFAULT '' COMMENT '分配个数',
  PRIMARY KEY (`id`),
  KEY `brand_group` (`brands_id`,`gid`) USING BTREE,
  KEY `brand_id` (`brands_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='品牌资源分组（科应组）规则表';

-- ----------------------------
-- Records of bt_brands_auth
-- ----------------------------
INSERT INTO `bt_brands_auth` VALUES ('1', '1', '6', '10');
INSERT INTO `bt_brands_auth` VALUES ('5', '4', '6', '20');
INSERT INTO `bt_brands_auth` VALUES ('3', '1', '1', '10');
INSERT INTO `bt_brands_auth` VALUES ('6', '3', '6', '');

-- ----------------------------
-- Table structure for bt_province
-- ----------------------------
DROP TABLE IF EXISTS `bt_province`;
CREATE TABLE `bt_province` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` varchar(30) NOT NULL COMMENT '省份',
  `area_id` int(11) NOT NULL COMMENT '所属区域ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COMMENT='省份所属的区域';

-- ----------------------------
-- Records of bt_province
-- ----------------------------
INSERT INTO `bt_province` VALUES ('1', '北京市', '1');
INSERT INTO `bt_province` VALUES ('2', '天津市', '1');
INSERT INTO `bt_province` VALUES ('3', '上海市', '1');
INSERT INTO `bt_province` VALUES ('4', '重庆市', '3');
INSERT INTO `bt_province` VALUES ('5', '广东省', '1');
INSERT INTO `bt_province` VALUES ('6', '广西', '1');
INSERT INTO `bt_province` VALUES ('7', '台湾省', '1');
INSERT INTO `bt_province` VALUES ('8', '辽宁省', '1');
INSERT INTO `bt_province` VALUES ('9', '吉林省', '1');
INSERT INTO `bt_province` VALUES ('10', '黑龙江省', '3');
INSERT INTO `bt_province` VALUES ('11', '江苏省', '3');
INSERT INTO `bt_province` VALUES ('12', '浙江省', '0');
INSERT INTO `bt_province` VALUES ('13', '安徽省', '0');
INSERT INTO `bt_province` VALUES ('14', '福建省', '0');
INSERT INTO `bt_province` VALUES ('15', '江西省', '0');
INSERT INTO `bt_province` VALUES ('16', '山东省', '0');
INSERT INTO `bt_province` VALUES ('17', '河南省', '0');
INSERT INTO `bt_province` VALUES ('18', '湖北省', '0');
INSERT INTO `bt_province` VALUES ('19', '湖南省', '0');
INSERT INTO `bt_province` VALUES ('20', '河北省', '0');
INSERT INTO `bt_province` VALUES ('21', '甘肃省', '0');
INSERT INTO `bt_province` VALUES ('22', '四川省', '0');
INSERT INTO `bt_province` VALUES ('23', '贵州省', '0');
INSERT INTO `bt_province` VALUES ('24', '海南省', '0');
INSERT INTO `bt_province` VALUES ('25', '云南省', '0');
INSERT INTO `bt_province` VALUES ('26', '青海省', '0');
INSERT INTO `bt_province` VALUES ('27', '陕西省', '0');
INSERT INTO `bt_province` VALUES ('28', '山西省', '0');
INSERT INTO `bt_province` VALUES ('29', '西藏', '0');
INSERT INTO `bt_province` VALUES ('30', '宁夏', '0');
INSERT INTO `bt_province` VALUES ('31', '新疆', '0');
INSERT INTO `bt_province` VALUES ('32', '内蒙古', '3');
INSERT INTO `bt_province` VALUES ('33', '澳门特别行政区', '1');
INSERT INTO `bt_province` VALUES ('34', '香港特别行政区', '1');

-- ----------------------------
-- Table structure for bt_resource
-- ----------------------------
DROP TABLE IF EXISTS `bt_resource`;
CREATE TABLE `bt_resource` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增id',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '客户姓名',
  `customer_info` varchar(20) NOT NULL DEFAULT '' COMMENT '客服名称 / ID',
  `phone` varchar(13) NOT NULL DEFAULT '' COMMENT '客户电话',
  `brand_id` int(11) NOT NULL DEFAULT '0' COMMENT '咨询的品牌id',
  `area_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属区域ID',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '归属组(用户组)id',
  `talk_id` int(11) NOT NULL DEFAULT '0' COMMENT '53客服（会话ID）（53客服才有）',
  `source` varchar(255) NOT NULL DEFAULT '' COMMENT '来源渠道',
  `province` varchar(10) NOT NULL DEFAULT '' COMMENT '省份',
  `chats` varchar(50) NOT NULL DEFAULT '' COMMENT '其他联系：QQ或微信',
  `address` varchar(50) NOT NULL DEFAULT '' COMMENT '详细地址',
  `keyword` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `assistant` varchar(20) NOT NULL DEFAULT '' COMMENT '审查：助理（跟进人）',
  `company` varchar(30) NOT NULL DEFAULT '' COMMENT '公司名称',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '配注（助理）',
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '回访时间',
  `types` tinyint(1) NOT NULL DEFAULT '1' COMMENT '添加类型：1，平台手动，2 ，53客服平台',
  `allocation` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否分配，1：未分配，2：已分配',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：1:可跟，2：不可跟',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='数据来源总表';

-- ----------------------------
-- Records of bt_resource
-- ----------------------------
INSERT INTO `bt_resource` VALUES ('1', '小李子', ' bote53kf01@163.com', '1330000000000', '1', '5', '1', '0', '百度', '1', '5656565', ' 山东省青岛市[电信]', 'coco奶茶加盟费多少', '', '柏特', '', '1502323232', '0', '1', '1', '0');
INSERT INTO `bt_resource` VALUES ('2', '在撒地方', '6565656', '6565656', '1', '1', '1', '0', '啥东方闪电', '', '565656', '撒地方', '撒地方', '', '', '', '1507965135', '0', '1', '1', '0');
INSERT INTO `bt_resource` VALUES ('3', '阿尔潍坊市多福多寿', '谁知道费多少', '撒地方', '1', '1', '1', '0', '撒地方撒地方', '1', '撒地方', '阿斯蒂芬as佛挡杀佛', 'as多福多寿', '', '', '', '1507965394', '0', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('4', '撒地方', '阿斯蒂芬撒地方', '撒地方啥东方闪电', '1', '1', '1', '0', 'の呃呃呃', '1', '阿斯蒂芬', '撒地方', '说的', '', '', '', '1507968059', '0', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('5', '撒地方sd', '说的', '说的', '1', '1', '6', '0', '说的', '1', '说的', '说的', '说的 ', '', '', '', '1507968081', '0', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('6', '撒地方sd', '5645445', '51512', '1', '1', '6', '0', '撒地方说的', '1', '12121', '45451as3dfdsfd', '阿斯蒂芬', '', '', '', '1507972914', '0', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('7', 'sdf ', '撒地方', '155656', '1', '1', '6', '0', 'AAS撒地方', '2', '32121212', '撒地方', '阿斯蒂芬', '', '', '', '1507973147', '0', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('8', '啥的看法呢', '', '45454545', '1', '1', '0', '0', '656565', '1', '撒地方', '', '', '', '', '', '1507973198', '0', '1', '1', '0');

-- ----------------------------
-- Table structure for bt_total
-- ----------------------------
DROP TABLE IF EXISTS `bt_total`;
CREATE TABLE `bt_total` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `title` varchar(30) NOT NULL COMMENT '标题',
  `group_id` int(11) NOT NULL COMMENT '用户组',
  `total` int(11) NOT NULL COMMENT '总数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='分配总数';

-- ----------------------------
-- Records of bt_total
-- ----------------------------
INSERT INTO `bt_total` VALUES ('1', '皇茶', '6', '3');
INSERT INTO `bt_total` VALUES ('2', '皇茶', '1', '2');

-- ----------------------------
-- Table structure for bt_users
-- ----------------------------
DROP TABLE IF EXISTS `bt_users`;
CREATE TABLE `bt_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(64) NOT NULL DEFAULT '' COMMENT '登录密码；mb_password加密',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '登录邮箱',
  `phone` bigint(11) unsigned DEFAULT NULL COMMENT '手机号',
  `status` tinyint(1) NOT NULL DEFAULT '2' COMMENT '用户状态 0：禁用； 1：正常 ',
  `register_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login_ip` varchar(16) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `last_login_time` int(10) unsigned NOT NULL COMMENT '最后登录时间',
  `login_count` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `remarks` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `user_login_key` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bt_users
-- ----------------------------
INSERT INTO `bt_users` VALUES ('88', 'admin', '21232f297a57a5a743894a0e4a801fc3', '56565655665', '13000000000', '1', '1449199996', '192.168.1.239', '1507600467', '5', '');
INSERT INTO `bt_users` VALUES ('89', 'admin2', 'e10adc3949ba59abbe56e057f20f883e', '', null, '1', '1449199996', '', '0', '0', '');
INSERT INTO `bt_users` VALUES ('92', 'AAA', 'e10adc3949ba59abbe56e057f20f883e', '', '150000', '1', '1507536830', '0.0.0.0', '1507540495', '1', '');
