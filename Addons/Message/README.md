### 安装将自动添加【Message】勾子
### 数据表创建语句
CREATE TABLE IF NOT EXISTS `Message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '留言名称',
  `summary` varchar(255) NOT NULL DEFAULT '' COMMENT '留言内容',
  `username` varchar(100) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '电子邮件',
  `qq` varchar(100) NOT NULL DEFAULT '' COMMENT 'QQ',
  `phone` varchar(100) NOT NULL DEFAULT '' COMMENT '电话',
  `addr` varchar(100) NOT NULL DEFAULT '' COMMENT '地址',
  `sort` int(3) unsigned NOT NULL DEFAULT 0 COMMENT '排序',
  `type` tinyint(3) unsigned NOT NULL DEFAULT 1 COMMENT '类型分组 1:投诉、建议 2:问题咨询 3:其他',
  `status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '状态（0：禁用，1：正常）',
  `create_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '添加时间',
  `reply_info` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '回复内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='留言板表';
### 勾子调用方法
在线留言页面添加勾子 `{:hook('Message')}`
