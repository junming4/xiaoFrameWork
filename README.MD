# 入职练习
    开始时间为： 2017-05-15 09:47
# 开发目标：能自动加载 model+controller
# App 存放 数据源码

#访问地址： http://xxxx.com/index.php?m=user

#用户表
CREATE TABLE `user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL DEFAULT '' COMMENT '用户名',
  `nick_name` varchar(100) NOT NULL DEFAULT '' COMMENT '昵称',
  `real_name` varchar(100) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `birthday` date DEFAULT NULL COMMENT '出生日期',
  `province` varchar(255) NOT NULL DEFAULT '' COMMENT '省市id',
  `city` varchar(255) NOT NULL DEFAULT '' COMMENT '市区',
  `hobby` varchar(100) NOT NULL DEFAULT '' COMMENT '爱好',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '注册时间',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`user_name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;