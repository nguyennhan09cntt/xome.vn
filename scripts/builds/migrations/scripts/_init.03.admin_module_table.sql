CREATE TABLE `admin_module`
(
  admin_module_id tinyint(4) not null auto_increment,
  admin_module_name varchar(50) not null,
  admin_module_name_created_at timestamp default current_timestamp,
  primary key (admin_module_id)
) ENGINE=InnoDb AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT 'Module / Main tab for Admin Tool';

Insert Into admin_module(admin_module_id, admin_module_name)
values ('1', 'Administration');