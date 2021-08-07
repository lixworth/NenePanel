alter table `user` add `theme` text not null default '';
alter table `server_config` add `user_memory` integer not null default 0;
alter table `server_config` add `user_crash_check` integer not null default 0;
