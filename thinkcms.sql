/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : thinkcms

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-10-10 18:07:37
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
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

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

-- ----------------------------
-- Table structure for bt_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `bt_auth_group`;
CREATE TABLE `bt_auth_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` text COMMENT '规则id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='用户组表';

-- ----------------------------
-- Records of bt_auth_group
-- ----------------------------
INSERT INTO `bt_auth_group` VALUES ('1', '超级管理员', '1', '6,96,20,1,2,3,4,5,64,128,21,7,8,9,10,11,12,13,14,15,16,123,124,125,19,126,129,130,131,132,133,134,135,136,137,138');
INSERT INTO `bt_auth_group` VALUES ('6', '客服组', '1', null);

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
) ENGINE=MyISAM AUTO_INCREMENT=139 DEFAULT CHARSET=utf8 COMMENT='规则表';

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
INSERT INTO `bt_brands` VALUES ('3', 'asdfdf', '1507544619', '1');
INSERT INTO `bt_brands` VALUES ('4', 'AAAddfaa', '1507544960', '1');

-- ----------------------------
-- Table structure for bt_resource
-- ----------------------------
DROP TABLE IF EXISTS `bt_resource`;
CREATE TABLE `bt_resource` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增id',
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  `group_id` int(11) NOT NULL COMMENT '角色id(那个组[科应部])',
  `address` varchar(60) NOT NULL DEFAULT '' COMMENT '地址',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '客户姓名',
  `phone` varchar(13) NOT NULL DEFAULT '' COMMENT '客户电话',
  `chats` varchar(50) NOT NULL DEFAULT '' COMMENT '客户的QQ或微信',
  `brand_id` int(11) NOT NULL COMMENT '咨询的品牌id',
  `source` varchar(255) NOT NULL DEFAULT '' COMMENT '来源渠道',
  `remarks` varchar(255) NOT NULL DEFAULT '' COMMENT '添加时，备注（关键字）',
  `status` tinyint(1) DEFAULT NULL COMMENT '状态：1:可跟，0：不可跟',
  `assistant` varchar(20) NOT NULL DEFAULT '' COMMENT '审查：助理',
  `company` varchar(30) DEFAULT '' COMMENT '公司名称',
  `confirm_brand` varchar(30) DEFAULT '' COMMENT '确认品牌',
  `confirm_address` varchar(60) NOT NULL DEFAULT '' COMMENT '确认地址',
  `confirm_remark` varchar(255) NOT NULL DEFAULT '' COMMENT '确认后的配注',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '回访时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='数据来源总表';

-- ----------------------------
-- Records of bt_resource
-- ----------------------------
INSERT INTO `bt_resource` VALUES ('5', '1502332333', '0', '广州白云区', '小李子', '1302323322311', '1656562626', '1', '网站', '', null, '', '', '', '', '', '0');
INSERT INTO `bt_resource` VALUES ('10', '1502332333', '0', '广州白云区', '小李子', '1302323322332', '1656562626', '1', '网站', '', null, '', '', '', '', '', '0');
INSERT INTO `bt_resource` VALUES ('11', '1502332333', '1', '广州白云区', '小李子', '1302323322332', '1656562626', '1', '网站', '', null, '', '', '', '', '', '0');
INSERT INTO `bt_resource` VALUES ('12', '1502332333', '1', '广州白云区', '小李子水电费', '1302323322332', '1656562626', '1', '网站', '111', null, '', '', '', '', '', '0');
INSERT INTO `bt_resource` VALUES ('13', '1502332333', '0', '广州白云区', '小李子', '1302323322332', '1656562626', '1', '网站', '', null, '', '', '', '', '', '0');
INSERT INTO `bt_resource` VALUES ('14', '1502332333', '0', '广州白云区', '小李子', '1302323322332', '1656562626', '1', '网站', '', null, '', '', '', '', '', '0');
INSERT INTO `bt_resource` VALUES ('15', '1520000000', '0', '广州白云区阿斯蒂芬', '小李子', '1302323322332', '1656562626', '1', '网站', '', null, '', '', '', '', '', '0');
INSERT INTO `bt_resource` VALUES ('16', '1520000000', '0', '广州白云区', '小李子', '1302323322332', '1656562626', '1', '网站', '', null, '', '', '', '', '', '0');
INSERT INTO `bt_resource` VALUES ('17', '1520000000', '6', '广州白云区', '小李子', '1302323322332', '1656562626', '1', '网站', '', null, '', '', '', '', '', '0');

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
INSERT INTO `bt_users` VALUES ('88', 'admin', '21232f297a57a5a743894a0e4a801fc3', '', '13000000000', '1', '1449199996', '192.168.1.239', '1507600467', '5', '');
INSERT INTO `bt_users` VALUES ('89', 'admin2', 'e10adc3949ba59abbe56e057f20f883e', '', null, '1', '1449199996', '', '0', '0', '');
INSERT INTO `bt_users` VALUES ('92', 'AAA', 'e10adc3949ba59abbe56e057f20f883e', '', '150000', '1', '1507536830', '0.0.0.0', '1507540495', '1', '');
