CREATE TABLE schema_updated
(
  schema_updated_id int not null auto_increment,
  schema_updated_file varchar(100) not null,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  primary key (schema_updated_id)
) ENGINE=InnoDb AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;