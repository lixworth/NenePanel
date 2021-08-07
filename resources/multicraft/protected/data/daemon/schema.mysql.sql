create table if not exists `server` ( 
    `id`                integer not null primary key auto_increment,
    `name`              varchar(128) not null, 
    `ip`                varchar(128) not null default '',
    `port`              integer not null default 25565,
    `dir`               varchar(128) not null,
    `world`             varchar(128) not null default 'world',
    `players`           integer not null,
    `memory`            integer not null default 0,
    `start_memory`      integer not null default 0,
    `jarfile`           varchar(128) not null default '',
    `autostart`         varchar(128) not null default '1',
    `default_level`     integer not null default 10,
    `daemon_id`         integer not null default 1,
    `announce_save`     integer not null default 1,
    `kick_delay`        integer not null default 3000,
    `suspended`         integer not null default 0,
    `autosave`          integer not null default 1,
    `jardir`            varchar(16) not null default 'daemon',
    `template`          varchar(128) not null default '',
    `setup`             varchar(32) not null default '',
    `prev_jarfile`      varchar(128) not null default '',
    `params`            varchar(192) not null default '',
    `crash_check`       varchar(32) not null default '',
    `disk_quota`        integer not null default 0,
    `domain`            varchar(90) not null default '',
    `cpus`              integer not null default 0,
    index `idx_srv_daemon_id` (`daemon_id`),
    index `idx_srv_suspended` (`suspended`),
    index `idx_srv_deflevel` (`default_level`),
    index `idx_srv_dir` (`dir`),
    index `idx_srv_ip` (`ip`),
    index `idx_srv_name` (`name`),
    index `idx_srv_suspdmn` (`suspended`,`daemon_id`)
) default charset=utf8;
create table if not exists `player` (
    `id`                integer not null primary key auto_increment,
    `server_id`         integer not null,
    `name`              varchar(128) not null,
    `level`             integer not null default 0,
    `lastseen`          varchar(128) not null default '',
    `banned`            varchar(128) not null default '',
    `op`                varchar(128) not null default '',
    `status`            varchar(128) not null default '',
    `ip`                varchar(128) not null default '',
    `previps`           varchar(128) not null default '',
    `quitreason`        varchar(128) not null default '',
    unique (`server_id`, `name`),
    foreign key(`server_id`) references `server`(`id`) on delete cascade on update cascade,
    index `idx_plr_svname` (`server_id`,`name`),
    index `idx_plr_svstatus` (`server_id`,`status`),
    index `idx_plr_server` (`server_id`)
) default charset=utf8;
create table if not exists `command` (
    `id`                integer not null primary key auto_increment,
    `server_id`         integer not null,
    `name`              varchar(128) not null,
    `level`             integer not null default 0,
    `prereq`            integer not null default 0,
    `chat`              varchar(128) not null default '',
    `response`          varchar(128) not null default '',
    `run`               varchar(128) not null default '',
    `hidden`            integer not null default 0,
    unique (`server_id`, `name`),
    index `idx_cmd_chat` (`chat`),
    index `idx_cmd_name` (`name`),
    index `idx_cmd_server` (`server_id`),
    index `idx_cmd_svprereq` (`server_id`,`prereq`)
) default charset=utf8;
create table if not exists `setting` (
    `key`               varchar(128) not null primary key,
    `value`             varchar(128) not null
) default charset=utf8;
create table if not exists `daemon` ( 
    `id`                integer not null primary key,
    `name`              varchar(128) not null, 
    `ip`                varchar(128) not null default '',
    `port`              integer not null default 25465,
    `token`             varchar(128) not null,
    `memory`            integer not null default 0,
    `ftp_ip`            varchar(128) not null default '',
    `ftp_port`          integer not null default 21,
    index `idx_dmn_token` (`token`)
) default charset=utf8;
create table if not exists `ftp_user` (
    `id`                integer not null primary key auto_increment,
    `name`              varchar(128) not null,
    `password`          varchar(128) not null,
    unique `idx_fus_uq_name` (`name`)
) default charset=utf8;
create table if not exists `ftp_user_server` (
    `user_id`           integer not null,
    `server_id`         integer not null,
    `perms`             varchar(16) not null default 'elr',
    primary key (`user_id`, `server_id`),
    foreign key(`user_id`) references `ftp_user`(`id`) on delete cascade on update cascade,
    index `idx_fussv_perms` (`perms`)
) default charset=utf8;
create table if not exists `schedule` (
    `id`                integer primary key auto_increment,
    `server_id`         integer not null,
    `scheduled_ts`      integer not null,
    `last_run_ts`       integer not null default '0',
    `interval`          integer not null default '0',
    `name`              varchar(64) not null default '',
    `command`           integer not null,
    `run_for`           integer not null default '0',
    `status`            integer not null default '0',
    `args`              varchar(128) not null default '',
    `hidden`            integer not null default 0,
    `condition`         varchar(16) not null default '',
    index `idx_sch_server_id` (`server_id`),
    index `idx_sch_scheduled_ts` (`scheduled_ts`),
    index `idx_sch_status` (`status`),
    index `idx_sch_statusts` (`status`,`scheduled_ts`)
) default charset=utf8;
create table if not exists `bgplugin` (
    `name`              varchar(128) not null,
    `version`           varchar(32) not null,
    `installed_ts`      integer not null,
    `installed_files`   text not null,
    `server_id`         integer not null,
    `disabled`          tinyint not null,
    primary key  (`server_id`,`name`)
) default charset=utf8;
create table if not exists `move_status` (
    `server_id`         integer not null,
    `src_dmn`           integer not null,
    `dst_dmn`           integer not null,
    `status`            varchar(32) not null,
    `message`           text not null,
    primary key (`server_id`)
) default charset=utf8;
create table if not exists `server_port` (
    `server_id`         integer not null,
    `port`              integer not null,
    primary key (`server_id`,`port`)
) default charset=utf8;
insert ignore into `setting` (`key`, `value`) values('dbVersion', '19');
