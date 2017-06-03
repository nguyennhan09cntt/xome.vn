CREATE TABLE admin_notification
(
  admin_notification_id int(11) unsigned not null auto_increment,
  fk_ticket_note int(11) unsigned not null,
  fk_admin int(11) unsigned not null,
  admin_notification_active tinyint(1) default 5,
  admin_notification_created_at timestamp default current_timestamp,
  primary key (admin_notification_id),
  unique key `uni_admin_notification` (fk_ticket_note, fk_admin),
  constraint `fk_admin_notification_ticket_note` foreign key (fk_ticket_note) references ticket_note(ticket_note_id),
  constraint `fk_admin_notification_admin` foreign key (fk_admin) references admin(admin_id)
) ENGINE=InnoDb AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT 'Notification';