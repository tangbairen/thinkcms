/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : thinkcms

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-11-03 19:32:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for bt_role_department
-- ----------------------------
DROP TABLE IF EXISTS `bt_role_department`;
CREATE TABLE `bt_role_department` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '部门id',
  `parent_id` int(10) NOT NULL COMMENT '父类部门id',
  `name` varchar(50) NOT NULL COMMENT '部门名',
  `area_id` varchar(100) NOT NULL DEFAULT '' COMMENT '区域id,如 1,2,3',
  `group_id` int(10) NOT NULL COMMENT '角色组id',
  `description` varchar(200) NOT NULL COMMENT '部门描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='本表存放部门信息';

-- ----------------------------
-- Records of bt_role_department
-- ----------------------------
INSERT INTO `bt_role_department` VALUES ('9', '0', '111', '1', '0', '');
INSERT INTO `bt_role_department` VALUES ('10', '0', 'sdf', '1', '0', 'asdf');
INSERT INTO `bt_role_department` VALUES ('11', '10', '下级安抚', '1', '0', '');
INSERT INTO `bt_role_department` VALUES ('12', '0', '广州柏特', '1', '0', '55');
INSERT INTO `bt_role_department` VALUES ('13', '0', '点点滴滴', '1', '0', '对对对');
INSERT INTO `bt_role_department` VALUES ('14', '9', '111', '1,3', '17', '11111');
INSERT INTO `bt_role_department` VALUES ('15', '0', '啊啥地方', '1,3', '1', '斯蒂芬');
INSERT INTO `bt_role_department` VALUES ('16', '0', '办公室', '', '1', '超级管理员专用');

-- ----------------------------
-- Table structure for bt_users
-- ----------------------------
DROP TABLE IF EXISTS `bt_users`;
CREATE TABLE `bt_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `department_id` int(11) NOT NULL DEFAULT '0' COMMENT '部门id',
  `username` varchar(60) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(64) NOT NULL DEFAULT '' COMMENT '登录密码；mb_password加密',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '登录邮箱',
  `phone` varchar(13) NOT NULL DEFAULT '' COMMENT '手机号',
  `company` varchar(100) NOT NULL DEFAULT '' COMMENT '公司名称',
  `status` tinyint(1) NOT NULL DEFAULT '2' COMMENT '用户状态  1：正常 ，2：禁用；',
  `register_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login_ip` varchar(16) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `login_count` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `remarks` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `level` tinyint(1) NOT NULL DEFAULT '2' COMMENT '等级：1 超管，2，普通管理员，3，公司管理账号,4员工',
  PRIMARY KEY (`id`),
  KEY `user_login_key` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bt_users
-- ----------------------------
INSERT INTO `bt_users` VALUES ('88', '16', 'admin', '21232f297a57a5a743894a0e4a801fc3', '56565655665', '', '', '1', '1449199996', '0.0.0.0', '1509690508', '110', '超级管理员', '2');
INSERT INTO `bt_users` VALUES ('97', '0', 'gz1', 'e10adc3949ba59abbe56e057f20f883e', '', '', '科应', '1', '1508050083', '0.0.0.0', '1509502402', '32', '', '2');
INSERT INTO `bt_users` VALUES ('98', '0', 'gz2', 'e10adc3949ba59abbe56e057f20f883e', '', '', '科应', '1', '1508050103', '14.146.7.232', '1508644959', '2', '', '2');
INSERT INTO `bt_users` VALUES ('100', '0', 'sh2', 'e10adc3949ba59abbe56e057f20f883e', '', '', '科应', '1', '1508050132', '', '0', '0', '', '2');
INSERT INTO `bt_users` VALUES ('101', '0', 'sh3', 'e10adc3949ba59abbe56e057f20f883e', '', '', '科应', '1', '1508050146', '', '0', '0', '', '2');
INSERT INTO `bt_users` VALUES ('102', '0', 'sh4', 'e10adc3949ba59abbe56e057f20f883e', '', '', '科应', '1', '1508050160', '', '0', '0', '', '2');
INSERT INTO `bt_users` VALUES ('104', '0', 'nj3', 'e10adc3949ba59abbe56e057f20f883e', '', '', '科应', '1', '1508050191', '192.168.1.154', '1508059502', '4', '', '2');
INSERT INTO `bt_users` VALUES ('105', '0', 'nj4', 'e10adc3949ba59abbe56e057f20f883e', '', '', '科应', '1', '1508554798', '14.146.7.232', '1508643921', '1', '', '2');
INSERT INTO `bt_users` VALUES ('107', '0', 'nj1', 'e10adc3949ba59abbe56e057f20f883e', '', '', '科应', '1', '1508813612', '', '0', '0', '', '2');
INSERT INTO `bt_users` VALUES ('108', '11', 'gz3', 'e10adc3949ba59abbe56e057f20f883e', '', '', '科应', '1', '1508813653', '', '0', '0', '但是防守对方', '4');
INSERT INTO `bt_users` VALUES ('109', '0', 'jx2', 'e10adc3949ba59abbe56e057f20f883e', '', '', '科应', '1', '1508813691', '14.146.5.51', '1508814326', '1', '', '2');
INSERT INTO `bt_users` VALUES ('110', '0', 'seo1', 'e10adc3949ba59abbe56e057f20f883e', '', '', '', '1', '1508910176', '14.146.9.223', '1508910590', '4', '', '2');
INSERT INTO `bt_users` VALUES ('111', '0', 'sem01', 'e10adc3949ba59abbe56e057f20f883e', '', '', '', '1', '1509068534', '14.146.6.19', '1509089184', '5', '', '2');
INSERT INTO `bt_users` VALUES ('112', '0', 'sjz01', 'e10adc3949ba59abbe56e057f20f883e', '', '', '', '1', '1509088354', '14.146.9.140', '1509410465', '10', '', '2');
INSERT INTO `bt_users` VALUES ('113', '0', 'bote', 'e10adc3949ba59abbe56e057f20f883e', 'asdas', '1111', '柏特餐饮', '1', '1509443563', '', '0', '0', '', '3');
INSERT INTO `bt_users` VALUES ('116', '15', 'aqa', 'e10adc3949ba59abbe56e057f20f883e', '', '', '', '2', '1509501668', '', '0', '0', '登山泛水', '2');
INSERT INTO `bt_users` VALUES ('115', '10', 'assss', 'e10adc3949ba59abbe56e057f20f883e', '', '', '', '2', '1509447212', '', '0', '0', '撒发生的', '4');
INSERT INTO `bt_users` VALUES ('118', '14', 'demo', 'e10adc3949ba59abbe56e057f20f883e', 'sdfasdf', 'sadfsadaf', '', '1', '1509691091', '0.0.0.0', '1509695031', '1', 'dsfgfdg', '4');
INSERT INTO `bt_users` VALUES ('119', '12', '测试1', 'e10adc3949ba59abbe56e057f20f883e', '56565656', '1556565656565', '', '1', '1509702650', '', '0', '0', '是实打实的', '4');
