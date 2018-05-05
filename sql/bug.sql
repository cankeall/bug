/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : bug

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2018-05-05 22:31:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for t_bug
-- ----------------------------
DROP TABLE IF EXISTS `t_bug`;
CREATE TABLE `t_bug` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '报告者',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `priority` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1紧急2急3一般',
  `sid` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '站点id',
  `touid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '解决者',
  `state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1打开2已解决3关闭',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '0未处理2已解决3关闭',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_bug
-- ----------------------------
INSERT INTO `t_bug` VALUES ('13', '2', '红包', '<p>\r\n	红包功能描述：\r\n</p>\r\n<p>\r\n	<br />\r\n</p>', '2', '80', '2', '1', '1524464058', '1524464058');
INSERT INTO `t_bug` VALUES ('10', '1', '66', '55', '1', '1', '2', '1', '1523791667', '1523799201');
INSERT INTO `t_bug` VALUES ('11', '1', '88', '<img src=\"/upload/image/201804/15/1523800812469.jpg\" alt=\"\" />111', '1', '1', '1', '1', '1523792423', '1523800814');
INSERT INTO `t_bug` VALUES ('12', '3', '规则错了一个字', '<img src=\"/upload/image/201804/16/1523853679954.jpg\" alt=\"\" />555', '2', '1', '2', '1', '1523800798', '1523853680');

-- ----------------------------
-- Table structure for t_site
-- ----------------------------
DROP TABLE IF EXISTS `t_site`;
CREATE TABLE `t_site` (
  `id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '项目名称',
  `state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0停用1启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_site
-- ----------------------------

-- ----------------------------
-- Table structure for t_user
-- ----------------------------
DROP TABLE IF EXISTS `t_user`;
CREATE TABLE `t_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `pwd` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0停用1启用2冻结',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_user
-- ----------------------------
INSERT INTO `t_user` VALUES ('1', 'aa', '62bc1fb5226b71a7737c37f0330217e0', '1');
INSERT INTO `t_user` VALUES ('2', 'lajiao', 'a15e9a9ebd6103d65e8cf45cbe733a7f', '1');
INSERT INTO `t_user` VALUES ('3', 'cc', '35bb59459eb8c69f587320b9aeed9316', '1');
