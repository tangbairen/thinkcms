/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : thinkcms

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-11-03 01:56:09
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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='本表存放部门信息';

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
