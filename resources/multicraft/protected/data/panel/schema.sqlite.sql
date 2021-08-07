create table if not exists `server_config` (
    `server_id`         integer not null primary key,
    `ip_auth_role`      text not null default 'guest',
    `give_role`         text not null default 'mod',
    `tp_role`           text not null default 'mod',
    `summon_role`       text not null default 'mod',
    `chat_role`         text not null default 'user',
    `user_jar`          integer not null default 0,
    `user_ftp`          integer not null default 0,
    `visible`           integer not null default 1,
    `user_schedule`     integer not null default 1,
    `user_name`         integer not null default 1,
    `user_visibility`   integer not null default 1,
    `display_ip`        text not null default '',
    `user_players`      integer not null default 0,
    `user_mysql`        integer not null default 1,
    `user_jardir`       integer not null default 0,
    `user_templates`    integer not null default 1,
    `user_params`       integer not null default 0,
    `user_memory`       integer not null default 0,
    `user_crash_check`  integer not null default 0,
    `user_subdomain`    integer not null default 0,
    `user_add_ports`    integer not null default 0
);
create table if not exists `user` (
    `id`                integer not null primary key autoincrement,
    `name`              text not null,
    `password`          text not null,
    `email`             text not null,
    `global_role`       text not null default 'none',
    `api_key`           text not null default '',
    `lang`              text not null default '',
    `theme`             text not null default '',
    `reset_hash`        text not null default '',
    `gauth_secret`      text not null default '',
    `gauth_token`       text not null default ''
);
create unique index `idx_usr_uq_name` on `user` (`name`);
create unique index `idx_usr_uq_email` on `user` (`email`);
create table if not exists `user_player` (
    `user_id`           integer not null,
    `player_id`         integer not null primary key,
    foreign key (`user_id`) references `user` (`id`) on delete cascade on update cascade
);
create table if not exists `user_server` (
    `user_id`           integer not null,
    `server_id`         integer not null,
    `role`              text not null,
    primary key (`user_id`, `server_id`),
    foreign key (`user_id`) references `user` (`id`) on delete cascade on update cascade
);
create index `idx_usrsv_user` on `user_server`(`user_id`);
create index `idx_usrsv_role` on `user_server`(`role`);
create index `idx_usrsv_server` on `user_server`(`server_id`);
create table if not exists `version` (
    `id`                integer not null primary key,
    `version`           integer not null default 0
);
create table if not exists `config_file` (
    `id`                integer primary key autoincrement not null,
    `name`              text not null,
    `description`       text not null,
    `file`              text not null,
    `options`           text not null,
    `type`              text not null default '',
    `enabled`           integer not null default 1,
    `dir`               text not null default ''
);
create table if not exists `command_cache` (
    `server_id`         integer not null,
    `command`           integer not null,
    `ts`                integer not null,
    `data`              text not null,
    primary key (`server_id`, `command`)
);
create table if not exists `mysql_db` ( 
    `server_id`         integer not null primary key,
    `name`              text not null, 
    `password`          text not null
);
create table if not exists `role_permission` (
  `role`                text not null,
  `permission`          text not null,
  primary key (`role`,`permission`)
);
create index `role` on `role_permission`(`role`);
create table if not exists `ip_counter` (
  `ip`                  text not null primary key,
  `time`                integer not null,
  `count`               integer not null
);
insert or ignore into `user` (`id`, `name`, `password`, `email`) values(1, 'admin', '$1$jzz7gjyU$joMbjEumpueirScK1Z4E90', 'admin@localhost.local');
insert or ignore into `config_file` values(1,'Server Settings','Main Minecraft server settings configuration file.','server.properties','load:server_properties','properties',1,'');
insert or ignore into `config_file` values(3,'Operators','List of users with operator access to the Minecraft server.','ops.txt','','',1,'');
insert or ignore into `config_file` values(4,'Banned IPs','List of banned IP addresses for this server','banned-ips.txt','','',1,'');
insert or ignore into `config_file` values(5,'Banned Players','List of banned player names for this server.','banned-players.txt','','',1,'');
insert or ignore into `config_file` values(6,'Whitelisted Players','List of players that are allowed to connect. Note that this functionality is already provided by Multicraft.','white-list.txt','','',1,'');
insert or ignore into `config_file` values(7, '{file}','Plugin config file: {dir}{file}','[^.]+\.(txt|yml|csv)','','',1,'plugins/*/');
insert or ignore into `config_file` values(100,'Operators','List of users with operator access to the Minecraft server.','ops.json','','',1,'');
insert or ignore into `config_file` values(101,'Banned IPs','List of banned IP addresses for this server','banned-ips.json','','',1,'');
insert or ignore into `config_file` values(102,'Banned Players','List of banned player names for this server.','banned-players.json','','',1,'');
insert or ignore into `config_file` values(103,'Whitelisted Players','List of players that are allowed to connect. Note that this functionality is already provided by Multicraft.','whitelist.json','','',1,'');
insert or ignore into `config_file` values(104,'Minecraft EULA','Accept the Minecraft EULA','eula.txt','load:minecraft_eula','properties',1,'');
insert or ignore into `version` (`id`, `version`) values(1, 19);
