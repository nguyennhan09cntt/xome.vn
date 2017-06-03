CREATE TABLE `admin_acl`
(
  admin_acl_id int(11) not null auto_increment,
  admin_acl_created_at  timestamp default current_timestamp,
  fk_admin_role tinyint(4) not null,
  fk_admin_privilege int not null,
  primary key (admin_acl_id),
  constraint `fk_admin_acl_admin_role` foreign key (fk_admin_role) references admin_role(admin_role_id),
  constraint `fk_admin_acl_admin_privilege` foreign key (fk_admin_privilege) references admin_privilege(admin_privilege_id)
) ENGINE=InnoDb AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT 'Admin ACL';

Insert Into `admin_acl`(fk_admin_role, fk_admin_privilege) Values (1, 1);
Insert Into `admin_acl`(fk_admin_role, fk_admin_privilege) Values (1, 2);
Insert Into `admin_acl`(fk_admin_role, fk_admin_privilege) Values (1, 3);
Insert Into `admin_acl`(fk_admin_role, fk_admin_privilege) Values (1, 4);
Insert Into `admin_acl`(fk_admin_role, fk_admin_privilege) Values (1, 5);
Insert Into `admin_acl`(fk_admin_role, fk_admin_privilege) Values (1, 6);
Insert Into `admin_acl`(fk_admin_role, fk_admin_privilege) Values (1, 7);
Insert Into `admin_acl`(fk_admin_role, fk_admin_privilege) Values (1, 8);
Insert Into `admin_acl`(fk_admin_role, fk_admin_privilege) Values (1, 9);
Insert Into `admin_acl`(fk_admin_role, fk_admin_privilege) Values (1, 10);