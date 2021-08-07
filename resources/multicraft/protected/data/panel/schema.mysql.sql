create table if not exists `server_config` (
    `server_id`         integer not null primary key,
    `ip_auth_role`      varchar(16) not null default 'guest',
    `give_role`         varchar(16) not null default 'mod',
    `tp_role`           varchar(16) not null default 'mod',
    `summon_role`       varchar(16) not null default 'mod',
    `chat_role`         varchar(16) not null default 'user',
    `user_jar`          integer not null default 0,
    `user_ftp`          integer not null default 0,
    `visible`           integer not null default 1,
    `user_schedule`     integer not null default 1,
    `user_name`         integer not null default 1,
    `user_visibility`   integer not null default 1,
    `display_ip`        varchar(64) not null default '',
    `user_players`      integer not null default 0,
    `user_mysql`        integer not null default 1,
    `user_jardir`       integer not null default 0,
    `user_templates`    integer not null default 1,
    `user_params`       integer not null default 0,
    `user_memory`       integer not null default 0,
    `user_crash_check`  integer not null default 0,
    `user_subdomain`    integer not null default 0,
    `user_add_ports`    integer not null default 0
) default charset=utf8;
create table if not exists `user` (
    `id`                integer not null primary key auto_increment,
    `name`              varchar(128) not null,
    `password`          varchar(128) not null,
    `email`             varchar(255) not null,
    `global_role`       varchar(16) not null default 'none',
    `api_key`           varchar(40) not null default '',
    `lang`              varchar(16) not null default '',
    `theme`             varchar(16) not null default '',
    `reset_hash`        varchar(32) not null default '',
    `gauth_secret`      varchar(32) not null default '',
    `gauth_token`       varchar(16) not null default '',
    unique index `idx_usr_uq_name` (`name`),
    unique index `idx_usr_uq_email` (`email`(128))
) default charset=utf8;
create table if not exists `user_player` (
    `user_id`           integer not null,
    `player_id`         integer not null primary key,
    foreign key (`user_id`) references `user` (`id`) on delete cascade on update cascade
) default charset=utf8;
create table if not exists `user_server` (
    `user_id`           integer not null,
    `server_id`         integer not null,
    `role`              varchar(16) not null,
    primary key (`user_id`, `server_id`),
    foreign key (`user_id`) references `user` (`id`) on delete cascade on update cascade,
    index `idx_usrsv_user` (`user_id`),
    index `idx_usrsv_role` (`role`),
    index `idx_usrsv_server` (`server_id`)
) default charset=utf8;
create table if not exists `version` (
    `id`                integer not null primary key,
    `version`           integer not null default 0
) default charset=utf8;
create table if not exists `config_file` (
    `id`                integer primary key auto_increment not null,
    `name`              varchar(128) not null,
    `description`       varchar(512) not null,
    `file`              varchar(256) not null,
    `options`           text not null,
    `type`              varchar(32) not null default '',
    `enabled`           integer not null default 1,
    `dir`               varchar(128) not null default ''
) default charset=utf8;
create table if not exists `command_cache` (
    `server_id`         integer not null,
    `command`           bigint not null,
    `ts`                integer not null,
    `data`              text not null,
    primary key (`server_id`, `command`)
) default charset=utf8;
create table if not exists `mysql_db` ( 
    `server_id`         integer not null primary key,
    `name`              varchar(128) not null, 
    `password`          varchar(128) not null
) default charset=utf8;
create table if not exists `role_permission` (
  `role`                varchar(16) not null,
  `permission`          varchar(16) not null,
  primary key (`role`,`permission`),
  index `role` (`role`)
) default charset=utf8;
create table if not exists `ip_counter` (
  `ip`                  varchar(128) not null primary key,
  `time`                integer not null,
  `count`               tinyint unsigned not null
) default charset=utf8;
insert ignore into `user` (`id`, `name`, `password`, `email`) values(1, 'admin', '$1$jzz7gjyU$joMbjEumpueirScK1Z4E90', 'admin@localhost.local');
insert ignore into `config_file` values(1,'Server Settings','Main Minecraft server settings configuration file.','server.properties','load:server_properties','properties',1,'');
insert ignore into `config_file` values(3,'Operators','List of users with operator access to the Minecraft server.','ops.txt','','',1,'');
insert ignore into `config_file` values(4,'Banned IPs','List of banned IP addresses for this server','banned-ips.txt','','',1,'');
insert ignore into `config_file` values(5,'Banned Players','List of banned player names for this server.','banned-players.txt','','',1,'');
insert ignore into `config_file` values(6,'Whitelisted Players','List of players that are allowed to connect. Note that this functionality is already provided by Multicraft.','white-list.txt','','',1,'');
insert ignore into `config_file` values(7, '{file}','Plugin config file: {dir}{file}','[^.]+\.(txt|yml|csv)','','',1,'plugins/*/');
insert ignore into `config_file` values(100,'Operators','List of users with operator access to the Minecraft server.','ops.json','','',1,'');
insert ignore into `config_file` values(101,'Banned IPs','List of banned IP addresses for this server','banned-ips.json','','',1,'');
insert ignore into `config_file` values(102,'Banned Players','List of banned player names for this server.','banned-players.json','','',1,'');
insert ignore into `config_file` values(103,'Whitelisted Players','List of players that are allowed to connect. Note that this functionality is already provided by Multicraft.','whitelist.json','','',1,'');
insert ignore into `config_file` values(104,'Minecraft EULA','Accept the Minecraft EULA','eula.txt','load:minecraft_eula','properties',1,'');
insert ignore into `version` (`id`, `version`) values(1, 19);
