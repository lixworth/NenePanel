alter table `server` add `cpus` integer not null default 0;
alter table `schedule` add `condition` varchar(16) not null default '';
