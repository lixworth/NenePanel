alter table `server` add `template` varchar(128) not null default '';
alter table `server` add `setup` varchar(32) not null default '';
alter table `server` add `prev_jarfile` varchar(128) not null default '';
alter table `server` add `params` varchar(192) not null default '';
alter table `server` modify `world` varchar(128) not null default 'world';
