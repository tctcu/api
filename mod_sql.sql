 CREATE TABLE `admin_user` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(12) NOT NULL DEFAULT '' COMMENT '姓名',
  `mobile` char(11) NOT NULL DEFAULT '0' COMMENT '手机号',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码 md5(md5($password).$salt)',
  `salt` char(4) NOT NULL DEFAULT '' COMMENT '盐 (0000-9999)',
  `type` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '类型 1-普通 6-管理员',
  `status` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1-正常 2-禁止登录',
  `created_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间戳',
  `updated_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间戳',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `mobile` (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='后台用户表';

 CREATE TABLE `admin_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户唯一id',
  `access_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限id',
  `created_at` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间戳',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `access_id` (`access_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户权限关联表';

CREATE TABLE `admin_access` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL DEFAULT '' COMMENT '权限',
  `m` varchar(20) NOT NULL DEFAULT '' COMMENT 'module',
  `c` varchar(20) NOT NULL DEFAULT '' COMMENT 'controller',
  `a` varchar(30) NOT NULL DEFAULT '' COMMENT 'action',
  PRIMARY KEY (`id`),
  KEY `m` (`m`),
  KEY `c` (`c`),
  KEY `a` (`a`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='后台权限表';


-- 第一个用户插入
insert into admin_user (uid, name, password, mobile, salt, type, created_at, updated_at)
values ('1', 'admin', '43e708ad2d43852f8c496f83b05a2f13', '15305634799', '1234', '9', '1530981900', '1530981900');

-- 第一批权限插入

insert into admin_access (id, title, m, c, a) values (2001, '用户列表', 'admin', 'user', 'index');

insert into admin_access (id, title, m, c, a) values (3001, '统计列表', 'admin', 'stat', 'index');

insert into admin_access (id, title, m, c, a) values (8001, '后台用户管理', 'admin', 'adminuser', 'index');
insert into admin_access (id, title, m, c, a) values (8002, '编辑用户', 'admin', 'adminuser', 'create');
insert into admin_access (id, title, m, c, a) values (8003, '权限控制', 'admin', 'adminuser', 'role');
insert into admin_access (id, title, m, c, a) values (8004, '密码重置', 'admin', 'adminuser', 'reset');


INSERT INTO admin_roles (uid,access_id,created_at) VALUES (1,2001,1530981900);
INSERT INTO admin_roles (uid,access_id,created_at) VALUES (1,3001,1530981900);
INSERT INTO admin_roles (uid,access_id,created_at) VALUES (1,8001,1530981900);
INSERT INTO admin_roles (uid,access_id,created_at) VALUES (1,8002,1530981900);
INSERT INTO admin_roles (uid,access_id,created_at) VALUES (1,8003,1530981900);
INSERT INTO admin_roles (uid,access_id,created_at) VALUES (1,8004,1530981900);



CREATE TABLE `user` (
   `uid` int(11) unsigned NOT NULL AUTO_INCREMENT,
   `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
   `idcard` char(18) NOT NULL DEFAULT '' COMMENT '身份证号',
   `openid` varchar(50) NOT NULL DEFAULT '' COMMENT '授权标识',
   `status` tinyint(1)  NOT NULL DEFAULT '1' COMMENT '1-正常 2-禁封',
   `role` varchar(10) NOT NULL DEFAULT '' COMMENT '角色 [1,2] 1-doctor 2-patient',
   `password` char(32) NOT NULL DEFAULT '' COMMENT '密码 md5(md5($password).$salt)',
   `salt` char(4) NOT NULL DEFAULT '' COMMENT '盐 (0000-9999)',
   `created_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间戳',
   `updated_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间戳',
   PRIMARY KEY (`id`),
   KEY `mobile` (`mobile`),
   KEY `idcard` (`idcard`),
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

 CREATE TABLE `map` (
   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
   `type` varchar(20) NOT NULL DEFAULT '' COMMENT '类型',
   `key` varchar(30) NOT NULL DEFAULT '' COMMENT '键',
   `value` varchar(30) NOT NULL DEFAULT ''  COMMENT '值',
   `created_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间戳',
   `updated_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间戳',
   PRIMARY KEY (`id`),
   UNIQUE KEY `mobile` (`mobile`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='字典表';

 INSERT INTO `map` (`type`,`key`,`value`,`created_at`,`updated_at`) VALUES ('channel','real_world','idcard',1530981900,1530981900);

CREATE TABLE `auth` (
   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
   `type` varchar(20) NOT NULL DEFAULT '' COMMENT '类型',
   `key` varchar(30) NOT NULL DEFAULT '' COMMENT '键',
   `value` varchar(30) NOT NULL DEFAULT ''  COMMENT '值',
   `created_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间戳',
   `updated_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间戳',
   PRIMARY KEY (`id`),
   UNIQUE KEY `mobile` (`mobile`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='授权记录表';



CREATE TABLE `doctor` (
   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
   `uid` int(11) NOT NULL COMMENT '用户唯一id',
   `name` varchar(11) NOT NULL DEFAULT '' COMMENT '姓名',
   `sex` tinyint(1)  NOT NULL DEFAULT '1' COMMENT '性别 1-男 2-女',

   `created_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间戳',
   `updated_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间戳',
   PRIMARY KEY (`id`),
   UNIQUE KEY `uid` (`uid`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='医生表';

CREATE TABLE `patient` (
   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
   `uid` int(11) NOT NULL COMMENT '用户唯一id',
   `name` varchar(11) NOT NULL DEFAULT '' COMMENT '姓名',
   `sex` tinyint(1)  NOT NULL DEFAULT '1' COMMENT '性别 1-男 2-女',

   `created_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间戳',
   `updated_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间戳',
   PRIMARY KEY (`id`),
   UNIQUE KEY `uid` (`uid`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='患者表';


