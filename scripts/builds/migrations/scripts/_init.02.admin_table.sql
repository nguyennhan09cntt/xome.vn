CREATE TABLE admin
(
  admin_id int(11) not null auto_increment,
  admin_email varchar(100) not null,
  admin_password varchar(64) not null,
  admin_fullname varchar(100),
  admin_created_at timestamp default current_timestamp,
  admin_last_login datetime,
  admin_last_login_ip varchar(15),
  admin_active tinyint(1) default 1 comment '1=active/ 0=inactive',
  fk_admin_role tinyint not null,
  primary key (admin_id),
  unique key `uni_admin_email` (admin_email),
  constraint `fk_admin_to_admin_role` foreign key (fk_admin_role) references admin_role(admin_role_id)
) ENGINE=InnoDb AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT 'Group/ Department for Administrator';

Insert Into admin(admin_id, admin_email, admin_password, admin_fullname, fk_admin_role)
values (1, 'root', md5('123456'), 'Administrator', '1');