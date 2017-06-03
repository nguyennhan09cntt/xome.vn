CREATE TABLE `admin_resource`
(
  admin_resource_id tinyint(4) not null auto_increment,
  admin_resource_name varchar(100) not null,
  admin_resource_controller varchar(50) not null comment 'Controller name to identify resource',
  admin_resource_priority tinyint(4) default 0,
  admin_resource_active tinyint(1) default 1,
  admin_resource_display tinyint(1) default 1 comment 'Hien thi len Menu',
  fk_admin_module tinyint(4) not null,
  admin_resource_created_at timestamp default current_timestamp,
  primary key (admin_resource_id),
  unique key `uni_admin_resource_controller` (admin_resource_controller),
  constraint `fk_admin_resource_admin_module` foreign key (fk_admin_module) references admin_module(admin_module_id)
) ENGINE=InnoDb AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT 'Resource for Admin ACL';

Insert Into `admin_resource`(admin_resource_id, admin_resource_name, admin_resource_controller, admin_resource_priority, fk_admin_module)
Values('1', 'Module/ Main Tab', 'admin-module', 100, 1);
Insert Into `admin_resource`(admin_resource_id, admin_resource_name, admin_resource_controller, admin_resource_priority, fk_admin_module)
Values('2', 'Resource', 'admin-resource', 95, 1);
Insert Into `admin_resource`(admin_resource_id, admin_resource_name, admin_resource_controller, admin_resource_priority, fk_admin_module)
Values('3', 'Privilege', 'admin-privilege', 90, 1);
Insert Into `admin_resource`(admin_resource_id, admin_resource_name, admin_resource_controller, admin_resource_priority, fk_admin_module)
Values('4', 'Nhóm quản trị', 'admin-role', 85, 1);
Insert Into `admin_resource`(admin_resource_id, admin_resource_name, admin_resource_controller, admin_resource_priority, fk_admin_module)
Values('5', 'Quản trị viên', 'admin', 80, 1);