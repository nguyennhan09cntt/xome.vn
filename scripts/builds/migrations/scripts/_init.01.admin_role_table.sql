CREATE TABLE admin_role
(
  admin_role_id tinyint(4) not null auto_increment,
  admin_role_name varchar(200) not null,
  admin_role_created_at timestamp default current_timestamp,
  primary key (admin_role_id)
) ENGINE=InnoDb AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT 'Role/ Group/ Department for Administrator';

Insert Into admin_role(admin_role_id, admin_role_name)
values ('1', 'Administrator');