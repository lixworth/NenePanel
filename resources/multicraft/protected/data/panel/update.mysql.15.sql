alter table `server_config` add `user_subdomain` integer not null default 0;
update `config_file` set `file`='whitelist.json' where `id`=103 and `file`='white-list.json';
