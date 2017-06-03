CREATE TABLE config_active
(
  config_active_id tinyint(4) not null auto_increment,
  config_active_name varchar(10) not null,
  config_seat_type_created_at timestamp default current_timestamp,
  primary key (config_active_id)
) ENGINE=InnoDb AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT 'Active value - just for reference';
Insert Into config_active(config_active_id, config_active_name) Values('0', 'Inactive');
Insert Into config_active(config_active_id, config_active_name) Values('1', 'Active');
Insert Into config_active(config_active_id, config_active_name) Values('2', 'Deleted');
Insert Into config_active(config_active_id, config_active_name) Values('3', 'Expired');