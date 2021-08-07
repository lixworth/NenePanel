create table if not exists `role_permission` (
  `role`                varchar(16) not null,
  `permission`          varchar(16) not null,
  primary key (`role`,`permission`),
  index `role` (`role`)
) default charset=utf8;
alter table `user` add `gauth_secret` varchar(32) not null default '';
alter table `user` add `gauth_token` varchar(16) not null default '';
