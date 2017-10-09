/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : thinkcms

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-10-09 10:26:10
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
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bt_admin_nav
-- ----------------------------
INSERT INTO `bt_admin_nav` VALUES ('1', '0', '系统设置', 'Admin/ShowNav/config', 'cog', '1');
INSERT INTO `bt_admin_nav` VALUES ('2', '1', '菜单管理', 'Admin/Nav/index', null, null);
INSERT INTO `bt_admin_nav` VALUES ('7', '4', '权限管理', 'Admin/Rule/index', '', '1');
INSERT INTO `bt_admin_nav` VALUES ('4', '0', '权限控制', 'Admin/ShowNav/rule', 'expeditedssl', '2');
INSERT INTO `bt_admin_nav` VALUES ('8', '4', '用户组管理', 'Admin/Rule/group', '', '2');
INSERT INTO `bt_admin_nav` VALUES ('9', '4', '管理员列表', 'Admin/Rule/admin_user_list', '', '3');

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='用户组表';

-- ----------------------------
-- Records of bt_auth_group
-- ----------------------------
INSERT INTO `bt_auth_group` VALUES ('1', '超级管理员', '1', '6,96,20,1,2,3,4,5,64,21,7,8,9,10,11,12,13,14,15,16,123,124,125,19,104,105,106,107,108,118,109,110,111,112,117');
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
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=utf8 COMMENT='规则表';

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
INSERT INTO `bt_auth_rule` VALUES ('20', '0', 'Admin/ShowNav/config', '系统设置', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('6', '0', 'Admin/Index/index', '后台首页', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('64', '1', 'Admin/Nav/order', '菜单排序', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('96', '6', 'Admin/Index/welcome', '欢迎界面', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('123', '11', 'Admin/Rule/add_user_to_group', '设置为管理员', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('124', '11', 'Admin/Rule/add_admin', '添加管理员', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('125', '11', 'Admin/Rule/edit_admin', '修改管理员', '1', '1', '');

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
  PRIMARY KEY (`id`),
  KEY `user_login_key` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bt_users
-- ----------------------------
INSERT INTO `bt_users` VALUES ('88', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '', null, '1', '1449199996', '127.0.0.1', '1507514801', '2');
INSERT INTO `bt_users` VALUES ('89', 'admin2', 'e10adc3949ba59abbe56e057f20f883e', '', null, '1', '1449199996', '', '0', '0');



