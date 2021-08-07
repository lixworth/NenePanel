alter table `server` add `cpus` integer not null default 0;
alter table `schedule` add `condition` text not null default '';
