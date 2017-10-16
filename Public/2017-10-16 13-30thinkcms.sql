/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : thinkcms

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-10-16 13:38:46
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='区域表';

-- ----------------------------
-- Records of bt_area
-- ----------------------------
INSERT INTO `bt_area` VALUES ('1', '广州区域');
INSERT INTO `bt_area` VALUES ('3', '上海区域');
INSERT INTO `bt_area` VALUES ('4', '其他区域');

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
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='用户组表';

-- ----------------------------
-- Records of bt_auth_group
-- ----------------------------
INSERT INTO `bt_auth_group` VALUES ('1', '超级管理员', '1', '6,96,20,1,2,3,4,5,64,128,21,7,8,9,10,11,12,13,14,15,16,123,124,125,19,163,126,148,129,130,131,132,133,140,141,143,144,145,155,156,157,134,135,160,136,137,138,139,158,159,146,147,161,149,150,151,152,153,154,162', '');
INSERT INTO `bt_auth_group` VALUES ('22', '南京2部', '1', '6,96,126,148,134,146,147,161', '1,3,4');
INSERT INTO `bt_auth_group` VALUES ('15', '广州1部', '1', '6,96,126,148,134,146,147,161', '1,3,4');
INSERT INTO `bt_auth_group` VALUES ('16', '广州2部', '1', '6,96,126,148,134,146,147,161', '1,3,4');
INSERT INTO `bt_auth_group` VALUES ('17', '上海1部', '1', '6,96,126,148,134,146,147,161', '1,3,4');
INSERT INTO `bt_auth_group` VALUES ('18', '上海2部', '1', '6,96,126,148,134,146,147,161', '1,3,4');
INSERT INTO `bt_auth_group` VALUES ('19', '见习1部', '1', '6,96,126,148,134,146,147,161', '1,3,4');
INSERT INTO `bt_auth_group` VALUES ('20', '见习2部', '1', '6,96,126,148,134,146,147,161', '1,3,4');
INSERT INTO `bt_auth_group` VALUES ('21', '南京1部', '1', '6,96,126,148,134,146,147,161', '1,3,4');
INSERT INTO `bt_auth_group` VALUES ('14', '客服部', '1', '6,96,126,148,129,130,131,132,133,140,141,143,144,145,155,156,157,134,136,137,138,139,158,159', '');

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
INSERT INTO `bt_auth_group_access` VALUES ('92', '1');
INSERT INTO `bt_auth_group_access` VALUES ('97', '15');
INSERT INTO `bt_auth_group_access` VALUES ('98', '16');
INSERT INTO `bt_auth_group_access` VALUES ('99', '17');
INSERT INTO `bt_auth_group_access` VALUES ('100', '18');
INSERT INTO `bt_auth_group_access` VALUES ('101', '19');
INSERT INTO `bt_auth_group_access` VALUES ('102', '20');
INSERT INTO `bt_auth_group_access` VALUES ('103', '21');
INSERT INTO `bt_auth_group_access` VALUES ('104', '14');

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
) ENGINE=MyISAM AUTO_INCREMENT=164 DEFAULT CHARSET=utf8 COMMENT='规则表';

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
INSERT INTO `bt_auth_rule` VALUES ('160', '135', 'Admin/Resource/totalExport', '导出数据', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('161', '146', 'Admin/Resource/auditExport', '导出数据', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('162', '154', 'Admin/Area/add_provinc', '添加省份', '1', '1', '');
INSERT INTO `bt_auth_rule` VALUES ('163', '19', 'Admin/Rule/delete_user', '删除管理员', '1', '1', '');

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
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COMMENT='品牌表';

-- ----------------------------
-- Records of bt_brands
-- ----------------------------
INSERT INTO `bt_brands` VALUES ('15', '一点点', '1508050217', '1');
INSERT INTO `bt_brands` VALUES ('16', 'coco', '1508050226', '1');
INSERT INTO `bt_brands` VALUES ('17', '恋暖初茶', '1508050238', '1');
INSERT INTO `bt_brands` VALUES ('18', '阿姨奶茶', '1508050244', '1');
INSERT INTO `bt_brands` VALUES ('19', '喜茶', '1508051077', '1');
INSERT INTO `bt_brands` VALUES ('20', '凉先绅', '1508051089', '1');
INSERT INTO `bt_brands` VALUES ('21', '乐乐茶', '1508051097', '1');
INSERT INTO `bt_brands` VALUES ('22', '地铁站', '1508051103', '1');
INSERT INTO `bt_brands` VALUES ('23', '米芝莲', '1508051111', '1');
INSERT INTO `bt_brands` VALUES ('24', '地下铁', '1508051120', '1');
INSERT INTO `bt_brands` VALUES ('25', '奈雪的茶', '1508051126', '1');
INSERT INTO `bt_brands` VALUES ('26', '巡茶', '1508051151', '1');
INSERT INTO `bt_brands` VALUES ('27', '侯彩擂', '1508051162', '1');
INSERT INTO `bt_brands` VALUES ('28', '张三疯', '1508051172', '1');
INSERT INTO `bt_brands` VALUES ('29', '快乐柠檬', '1508051177', '1');
INSERT INTO `bt_brands` VALUES ('30', '大卡司', '1508051182', '1');
INSERT INTO `bt_brands` VALUES ('31', '阿水大杯茶', '1508051190', '1');
INSERT INTO `bt_brands` VALUES ('32', '鲜果时间', '1508051195', '1');
INSERT INTO `bt_brands` VALUES ('33', '大口九', '1508051202', '1');
INSERT INTO `bt_brands` VALUES ('34', '有茶', '1508051207', '1');
INSERT INTO `bt_brands` VALUES ('35', '泰芒了', '1508051220', '1');
INSERT INTO `bt_brands` VALUES ('36', '黒泷堂', '1508051226', '1');
INSERT INTO `bt_brands` VALUES ('37', '吾饮良品', '1508051231', '1');
INSERT INTO `bt_brands` VALUES ('38', '普盈士王子拉茶', '1508054752', '1');

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
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COMMENT='品牌资源分组（科应组）规则表';

-- ----------------------------
-- Records of bt_brands_auth
-- ----------------------------
INSERT INTO `bt_brands_auth` VALUES ('19', '15', '15', '2');
INSERT INTO `bt_brands_auth` VALUES ('20', '16', '15', '3');
INSERT INTO `bt_brands_auth` VALUES ('21', '17', '15', '1');
INSERT INTO `bt_brands_auth` VALUES ('22', '18', '15', '1');
INSERT INTO `bt_brands_auth` VALUES ('23', '19', '15', '');
INSERT INTO `bt_brands_auth` VALUES ('24', '16', '16', '1');
INSERT INTO `bt_brands_auth` VALUES ('25', '15', '16', '2');
INSERT INTO `bt_brands_auth` VALUES ('26', '20', '16', '');
INSERT INTO `bt_brands_auth` VALUES ('27', '21', '16', '');
INSERT INTO `bt_brands_auth` VALUES ('28', '22', '16', '3');
INSERT INTO `bt_brands_auth` VALUES ('29', '15', '17', '1');
INSERT INTO `bt_brands_auth` VALUES ('30', '16', '17', '5');
INSERT INTO `bt_brands_auth` VALUES ('31', '26', '17', '2');
INSERT INTO `bt_brands_auth` VALUES ('32', '25', '17', '2');
INSERT INTO `bt_brands_auth` VALUES ('33', '15', '18', '2');
INSERT INTO `bt_brands_auth` VALUES ('34', '16', '18', '8');
INSERT INTO `bt_brands_auth` VALUES ('35', '18', '18', '1');
INSERT INTO `bt_brands_auth` VALUES ('36', '35', '19', '5');
INSERT INTO `bt_brands_auth` VALUES ('37', '36', '19', '1');
INSERT INTO `bt_brands_auth` VALUES ('38', '15', '19', '1');
INSERT INTO `bt_brands_auth` VALUES ('39', '16', '19', '');
INSERT INTO `bt_brands_auth` VALUES ('40', '35', '20', '5');
INSERT INTO `bt_brands_auth` VALUES ('41', '37', '20', '2');
INSERT INTO `bt_brands_auth` VALUES ('42', '16', '20', '');
INSERT INTO `bt_brands_auth` VALUES ('43', '16', '21', '');
INSERT INTO `bt_brands_auth` VALUES ('44', '19', '21', '1');
INSERT INTO `bt_brands_auth` VALUES ('45', '15', '21', '');
INSERT INTO `bt_brands_auth` VALUES ('46', '38', '21', '1');

-- ----------------------------
-- Table structure for bt_province
-- ----------------------------
DROP TABLE IF EXISTS `bt_province`;
CREATE TABLE `bt_province` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` varchar(30) NOT NULL COMMENT '省份',
  `area_id` int(11) NOT NULL COMMENT '所属区域ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='省份所属的区域';

-- ----------------------------
-- Records of bt_province
-- ----------------------------
INSERT INTO `bt_province` VALUES ('1', '北京市', '4');
INSERT INTO `bt_province` VALUES ('2', '天津市', '4');
INSERT INTO `bt_province` VALUES ('3', '上海市', '3');
INSERT INTO `bt_province` VALUES ('4', '重庆市', '1');
INSERT INTO `bt_province` VALUES ('5', '广东省', '1');
INSERT INTO `bt_province` VALUES ('6', '广西', '1');
INSERT INTO `bt_province` VALUES ('7', '台湾省', '4');
INSERT INTO `bt_province` VALUES ('8', '辽宁省', '4');
INSERT INTO `bt_province` VALUES ('9', '吉林省', '4');
INSERT INTO `bt_province` VALUES ('10', '黑龙江省', '4');
INSERT INTO `bt_province` VALUES ('11', '江苏省', '3');
INSERT INTO `bt_province` VALUES ('12', '浙江省', '3');
INSERT INTO `bt_province` VALUES ('13', '安徽省', '3');
INSERT INTO `bt_province` VALUES ('14', '福建省', '1');
INSERT INTO `bt_province` VALUES ('15', '江西省', '1');
INSERT INTO `bt_province` VALUES ('16', '山东省', '4');
INSERT INTO `bt_province` VALUES ('17', '河南省', '3');
INSERT INTO `bt_province` VALUES ('18', '湖北省', '3');
INSERT INTO `bt_province` VALUES ('19', '湖南省', '1');
INSERT INTO `bt_province` VALUES ('20', '河北省', '4');
INSERT INTO `bt_province` VALUES ('21', '甘肃省', '4');
INSERT INTO `bt_province` VALUES ('22', '四川省', '1');
INSERT INTO `bt_province` VALUES ('23', '贵州省', '1');
INSERT INTO `bt_province` VALUES ('24', '海南省', '1');
INSERT INTO `bt_province` VALUES ('25', '云南省', '1');
INSERT INTO `bt_province` VALUES ('26', '青海省', '4');
INSERT INTO `bt_province` VALUES ('27', '陕西省', '3');
INSERT INTO `bt_province` VALUES ('28', '山西省', '4');
INSERT INTO `bt_province` VALUES ('29', '西藏', '4');
INSERT INTO `bt_province` VALUES ('30', '宁夏', '4');
INSERT INTO `bt_province` VALUES ('31', '新疆', '4');
INSERT INTO `bt_province` VALUES ('32', '内蒙古', '4');
INSERT INTO `bt_province` VALUES ('33', '澳门特别行政区', '4');
INSERT INTO `bt_province` VALUES ('34', '香港特别行政区', '4');
INSERT INTO `bt_province` VALUES ('35', '其他', '4');

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
  `confirm_address` varchar(60) NOT NULL DEFAULT '' COMMENT '确认地址',
  `types` tinyint(1) NOT NULL DEFAULT '1' COMMENT '添加类型：1，平台手动，2 ，53客服平台',
  `allocation` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否分配，1：未分配，2：已分配',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：1:可跟，2：不可跟',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COMMENT='数据来源总表';

-- ----------------------------
-- Records of bt_resource
-- ----------------------------
INSERT INTO `bt_resource` VALUES ('9', '小李子', '65656', '565656566', '15', '1', '15', '0', '百度移动', '5', '56565656', '撒地方似懂非懂是否', '一点点', '', '', '', '1508052537', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('10', '水电费', '232323', '256565656', '15', '1', '16', '0', '百度移动', '5', '5656556', '连锁店减肥了的', '水电费', '', '', '', '1508052581', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('11', '水岸东方', '6561', '65656565', '15', '1', '17', '0', '防守打法', '5', '323232396', '拉水电费绝对是了', '', '', '', '', '1508052642', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('12', '胜多负少', '省份', '1239238293', '15', '1', '18', '0', '啥东方闪电', '5', 'sdfj', 's啥东方闪电', '', '', '', '', '1508052679', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('13', '阿斯蒂芬', '阿斯蒂芬', '454545', '15', '1', '19', '0', '阿斯蒂芬是的', '5', 'sdfd', '阿斯蒂芬啥东方闪电', '撒地方', '', '', '', '1508052749', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('14', '撒地方', '546456', '撒地方地方', '15', '1', '21', '0', '看见了', '5', '撒地方', '阿斯蒂芬斯蒂芬地方', '啥地方4', '', '', '', '1508052794', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('15', '老椒手点两份', '565656', '123232', '15', '1', '15', '0', '连锁店积分两', '5', 'sdklfd', '是店家法律手段', '阿斯蒂芬', '', '', '', '1508052843', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('16', '粉我认为', '1212', '12312121', '15', '1', '16', '0', '安抚', '5', '1212', '121212阿斯蒂芬', '阿斯蒂芬', '', '', '', '1508052892', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('17', 'as的反馈', '阿斯蒂芬斯蒂芬', '546545', '15', '1', '18', '0', ' 多福多寿', '5', '撒地方', '撒地方撒地方', '山东', '', '', '', '1508052917', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('18', '省份', '就赶快', '撒地方', '15', '1', '21', '0', '第三方', '5', '撒地方', '565656', '565', '', '', '', '1508052962', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('19', '个', '大', '54654', '36', '1', '19', '0', '360', '6', '41564564', '发发的是', '黑泷堂加盟', '', '', '', '1508053141', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('20', '了申达股份', '撒地方', '656613132', '15', '1', '21', '0', '山东', '5', '665655656', 'sad', '撒地方', '', '', '', '1508053158', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('21', '傻大个', '撒地方', '撒地方撒地方', '18', '1', '15', '0', '撒地方', '5', '撒地方撒地方', '阿斯蒂芬斯蒂芬地方', '撒地方', '', '', '', '1508053302', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('22', '撒地方', 'sad', '啊', '18', '1', '18', '0', '阿斯蒂芬', '5', '撒地方', '撒地方撒地方', 'sad山东', '', '', '', '1508053323', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('23', '阿斯蒂芬', '的', '撒地方地方', '18', '1', '18', '0', '省份', '5', '啊', '撒地方撒地方', '撒地方爽肤水', '', '', '', '1508053366', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('24', '啥东方闪电', '先吃饭方法', '撒地方', '16', '1', '15', '0', '阿斯蒂芬是的', '5', '撒地方', '是非得失', '啥多福多寿', '', '', '', '1508053727', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('25', '放大', '放大镜卡回家看', '大', '25', '4', '17', '0', '百度pc', '20', '大第三方', '佛顶山覅偶', '三生三世', '', '', '', '1508053740', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('26', '撒地方', '5656', '撒地方地方撒地方', '16', '1', '16', '0', '121212121', '5', '撒地方', '56451', '啊撒地方地方', '', '', '', '1508053766', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('27', '撒地方', '撒地方', '阿斯蒂芬', '16', '1', '17', '0', '撒地方', '5', '554545', '是', '撒地方', '', '', '', '1508053810', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('28', '发的卡了减肥', '附近的拉开', '大风刀霜剑', '25', '1', '17', '0', '百度移动', '25', '的房间爱哦叫', '324324', '465645', '', '', '', '1508053812', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('29', '发顺丰', '放大发多少尽快', '大多数', '25', '4', '0', '0', '放大', '26', '大大', '房间大昆仑决', '发发', '', '', '', '1508053851', '0', '', '1', '1', '0');
INSERT INTO `bt_resource` VALUES ('30', '大经理', '发发', '放大', '17', '4', '15', '0', '百度PC', '30', '大', '放大', '1111', '', '', '', '1508053943', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('31', '地铁站', '撒地方', '地铁站', '22', '4', '16', '0', '665656', '9', '地铁站', '65656', '撒地方撒地方', '', '', '', '1508053953', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('32', '发多少', '大范德萨', '大家', '17', '4', '0', '0', '第三代', '16', '大范德萨', '发发', '地方地方', '', '', '', '1508053987', '0', '', '1', '1', '0');
INSERT INTO `bt_resource` VALUES ('33', '第三方', '地铁站', '地铁站', '22', '3', '16', '0', '地铁站', '13', '地铁站', '地铁站', '地铁站', '', '', '', '1508054018', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('34', '地铁站撒地方', '66565', '56565622112', '22', '4', '16', '0', '6545sdf54fd54', '2', '654656565', '2332323232', '566424撒地方', '', '', '', '1508054052', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('35', '地铁站撒地方地铁站', '地铁站', '地铁站', '22', '4', '0', '0', '地铁站', '1', '地铁站', '地铁站', '地铁站地铁站地铁站地铁站地铁站', '', '', '', '1508054080', '0', '', '1', '1', '0');
INSERT INTO `bt_resource` VALUES ('36', '放大', '发达', '大', '19', '4', '15', '0', '百度', '8', '打发啊', '发阿德', '', '', '', '', '1508054220', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('37', '大大', '放大', '打发', '19', '4', '21', '0', '发', '9', ' 打发', '打发啊', '', '', '', '', '1508054237', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('38', '发发', '发多少', '打发', '19', '4', '15', '0', '啊发', '10', '打发', '打发', '打发', '', '', '', '1508054254', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('39', '放大', '发达', '打发', '19', '4', '15', '0', '发', '8', '的affect', '打发啊', '', '', '', '', '1508054303', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('40', '打发', '发达', '打发', '19', '4', '15', '0', ' 发 ', '10', '打发', '打发啊', '发达', '', '', '', '1508054318', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('41', '打发', '发', '发达', '19', '1', '15', '0', ' 发', '14', '发', '发达', '打发', '456', '45645', '', '1508054350', '1508054539', '456', '1', '2', '1');
INSERT INTO `bt_resource` VALUES ('42', '发达', '打发', '打发', '19', '4', '21', '0', '发达', '16', '的发', '打发', '打发', '', '', '', '1508054672', '0', '', '1', '2', '0');
INSERT INTO `bt_resource` VALUES ('43', '泰芒了', '泰芒了', '泰芒了', '35', '1', '19', '0', '泰芒了', '4', '泰芒了', '泰芒了', '泰芒了泰芒了', '', '', '', '1508054700', '0', '', '1', '2', '0');

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
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='分配总数';

-- ----------------------------
-- Records of bt_total
-- ----------------------------
INSERT INTO `bt_total` VALUES ('7', '皇茶', '15', '10');
INSERT INTO `bt_total` VALUES ('8', '皇茶', '16', '10');
INSERT INTO `bt_total` VALUES ('9', '皇茶', '17', '10');
INSERT INTO `bt_total` VALUES ('10', '好闺蜜', '18', '10');
INSERT INTO `bt_total` VALUES ('11', '皇茶', '19', '10');
INSERT INTO `bt_total` VALUES ('12', '皇茶', '20', '10');
INSERT INTO `bt_total` VALUES ('13', '南京都可', '21', '10');

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
  `status` tinyint(1) NOT NULL DEFAULT '2' COMMENT '用户状态  1：正常 ，2：禁用；',
  `register_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login_ip` varchar(16) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `last_login_time` int(10) unsigned NOT NULL COMMENT '最后登录时间',
  `login_count` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `remarks` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `user_login_key` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bt_users
-- ----------------------------
INSERT INTO `bt_users` VALUES ('88', 'admin', '21232f297a57a5a743894a0e4a801fc3', '56565655665', '13000000000', '1', '1449199996', '172.16.1.43', '1508120032', '8', '');
INSERT INTO `bt_users` VALUES ('97', 'gz1', 'e10adc3949ba59abbe56e057f20f883e', '', null, '1', '1508050083', '192.168.1.154', '1508054154', '1', '');
INSERT INTO `bt_users` VALUES ('98', 'gz2', 'e10adc3949ba59abbe56e057f20f883e', '', null, '1', '1508050103', '', '0', '0', '');
INSERT INTO `bt_users` VALUES ('99', 'sh1', 'e10adc3949ba59abbe56e057f20f883e', '', null, '1', '1508050120', '', '0', '0', '');
INSERT INTO `bt_users` VALUES ('100', 'sh2', 'e10adc3949ba59abbe56e057f20f883e', '', null, '1', '1508050132', '', '0', '0', '');
INSERT INTO `bt_users` VALUES ('101', 'jx1', 'e10adc3949ba59abbe56e057f20f883e', '', null, '1', '1508050146', '', '0', '0', '');
INSERT INTO `bt_users` VALUES ('102', 'jx2', 'e10adc3949ba59abbe56e057f20f883e', '', null, '1', '1508050160', '', '0', '0', '');
INSERT INTO `bt_users` VALUES ('104', 'kf', 'e10adc3949ba59abbe56e057f20f883e', '', null, '1', '1508050191', '192.168.1.154', '1508059502', '4', '');

-- ----------------------------
-- Table structure for bt_visitor_info
-- ----------------------------
DROP TABLE IF EXISTS `bt_visitor_info`;
CREATE TABLE `bt_visitor_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `guest_id` int(11) NOT NULL COMMENT '访客id',
  `guest_name` varchar(100) NOT NULL DEFAULT '' COMMENT '访客名称',
  `cmd` varchar(30) NOT NULL DEFAULT '' COMMENT '命令',
  `email` varchar(30) NOT NULL DEFAULT '' COMMENT '邮箱',
  `province` varchar(10) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(10) NOT NULL DEFAULT '' COMMENT '城市',
  `qq` varchar(15) NOT NULL DEFAULT '' COMMENT 'qq',
  `mobile` varchar(13) NOT NULL DEFAULT '' COMMENT '手机号',
  `address` varchar(100) NOT NULL DEFAULT '' COMMENT '地址',
  `zipcode` varchar(10) NOT NULL DEFAULT '' COMMENT '邮编',
  `worker_id` varchar(30) NOT NULL DEFAULT '' COMMENT '客服工号',
  `tag` varchar(30) NOT NULL DEFAULT '' COMMENT '访客标签',
  `company_id` varchar(10) NOT NULL COMMENT '公司id',
  `token` varchar(20) NOT NULL COMMENT '验证码',
  `time` int(10) NOT NULL COMMENT '时间戳（秒级）',
  PRIMARY KEY (`id`) COMMENT '主键id',
  KEY `guest_id` (`guest_id`) COMMENT '访客id索引'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='访客信息表';

-- ----------------------------
-- Records of bt_visitor_info
-- ----------------------------

-- ----------------------------
-- Table structure for bt_visitor_record
-- ----------------------------
DROP TABLE IF EXISTS `bt_visitor_record`;
CREATE TABLE `bt_visitor_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `guest_id` int(11) NOT NULL COMMENT '访客ID',
  `talk_id` int(11) NOT NULL COMMENT '会话ID',
  `company_id` int(11) NOT NULL COMMENT '公司ID',
  `id6d` int(11) NOT NULL COMMENT '客服ID',
  `guest_ip` varchar(20) NOT NULL COMMENT '访客IP',
  `guest_area` varchar(30) NOT NULL COMMENT '访客所在地域',
  `referer` text NOT NULL COMMENT '来源地址',
  `talk_page` text NOT NULL COMMENT '咨询地址',
  `se` varchar(10) NOT NULL COMMENT '搜索引擎',
  `kw` varchar(50) NOT NULL COMMENT '关键字',
  `talk_type` tinyint(1) NOT NULL COMMENT '1，留言；2，机器人；3，流失；4，图标；5，邀请框；6，其他',
  `device` tinyint(1) NOT NULL COMMENT '设备 1 PC, 2 phone , 3 wechat',
  `worker_id` varchar(30) NOT NULL COMMENT '客服工号',
  `worker_name` varchar(10) NOT NULL DEFAULT '' COMMENT '客服名称',
  `message` text NOT NULL COMMENT '聊天记录  （一维数组）json',
  `talk_time` varchar(15) NOT NULL COMMENT '对话时间',
  `end_time` varchar(15) NOT NULL COMMENT '结束时间',
  `end_type` tinyint(1) NOT NULL COMMENT '1：客服结束对话，2：访客结束对话，3：超时结束对话',
  PRIMARY KEY (`id`) COMMENT '主键id',
  KEY `guest_id` (`guest_id`) COMMENT '访客id索引'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='访客记录（聊天）';

-- ----------------------------
-- Records of bt_visitor_record
-- ----------------------------
