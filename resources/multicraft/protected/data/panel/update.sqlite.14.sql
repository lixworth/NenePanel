create table if not exists `role_permission` (
  `role`                text not null,
  `permission`          text not null,
  primary key (`role`,`permission`)
);
create index `role` on `role_permission`(`role`);
alter table `user` add `gauth_secret` text not null default '';
alter table `user` add `gauth_token` text not null default '';
