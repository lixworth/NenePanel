create table if not exists `server` ( 
    `id`                integer not null primary key autoincrement,
    `name`              text not null, 
    `ip`                text not null default '',
    `port`              integer not null default 25565,
    `dir`               text not null,
    `world`             text not null default 'world',
    `players`           integer not null,
    `memory`            integer not null default 0,
    `start_memory`      integer not null default 0,
    `jarfile`           text not null default '',
    `autostart`         text not null default '1',
    `default_level`     integer not null default 10,
    `daemon_id`         integer not null default 1,
    `announce_save`     integer not null default 1,
    `kick_delay`        integer not null default 3000,
    `suspended`         integer not null default 0,
    `autosave`          integer not null default 1,
    `jardir`            text not null default 'daemon',
    `template`          text not null default '',
    `setup`             text not null default '',
    `prev_jarfile`      text not null default '',
    `params`            text not null default '',
    `crash_check`       text not null default '',
    `disk_quota`        integer not null default 0,
    `domain`            text not null default '',
    `cpus`              integer not null default 0
);
create index `idx_srv_daemon_id` on `server`(`daemon_id`);
create index `idx_srv_suspended` on `server`(`suspended`);
create index `idx_srv_deflevel` on `server`(`default_level`);
create index `idx_srv_dir` on `server`(`dir`);
create index `idx_srv_ip` on `server`(`ip`);
create index `idx_srv_name` on `server`(`name`);
create index `idx_srv_suspdmn` on `server`(`suspended`,`daemon_id`);
create table if not exists `player` (
    `id`                integer not null primary key autoincrement,
    `server_id`         integer not null,
    `name`              text not null,
    `level`             integer not null default 0,
    `lastseen`          text not null default '',
    `banned`            text not null default '',
    `op`                text not null default '',
    `status`            text not null default '',
    `ip`                text not null default '',
    `previps`           text not null default '',
    `quitreason`        text not null default '',
    unique (`server_id`, `name`),
    foreign key(`server_id`) references `server`(`id`) on delete cascade on update cascade
);
create index `idx_plr_svname` on `player`(`server_id`,`name`);
create index `idx_plr_svstatus` on `player`(`server_id`,`status`);
create index `idx_plr_server` on `player`(`server_id`);
create table if not exists `command` (
    `id`                integer not null primary key autoincrement,
    `server_id`         integer not null,
    `name`              text not null,
    `level`             integer not null default 0,
    `prereq`            integer not null default 0,
    `chat`              text not null default '',
    `response`          text not null default '',
    `run`               text not null default '',
    `hidden`            integer not null default 0,
    unique (`server_id`, `name`)
);
create index `idx_cmd_chat` on `command`(`chat`);
create index `idx_cmd_name` on `command`(`name`);
create index `idx_cmd_server` on `command`(`server_id`);
create index `idx_cmd_svprereq` on `command`(`server_id`,`prereq`);
create table if not exists `setting` (
    `key`               text not null primary key,
    `value`             text not null
);
create table if not exists `daemon` ( 
    `id`                integer not null primary key,
    `name`              text not null, 
    `ip`                text not null default '',
    `port`              integer not null default 25465,
    `token`             text not null,
    `memory`            integer not null default 0,
    `ftp_ip`            text not null default '',
    `ftp_port`          integer not null default 21
);
create index `idx_dmn_token` on `daemon`(`token`);
create table if not exists `ftp_user` (
    `id`                integer not null primary key autoincrement,
    `name`              text not null,
    `password`          text not null
);
create unique index `idx_fus_uq_name` on `ftp_user`(`name`);
create table if not exists `ftp_user_server` (
    `user_id`           integer not null,
    `server_id`         integer not null,
    `perms`             text not null default 'elr',
    primary key (`user_id`, `server_id`),
    foreign key(`user_id`) references `ftp_user`(`id`) on delete cascade on update cascade
);
create index `idx_fussv_perms` on `ftp_user_server`(`perms`);
create table if not exists `schedule` (
    `id`                integer primary key autoincrement,
    `server_id`         integer not null,
    `scheduled_ts`      integer not null,
    `last_run_ts`       integer not null default '0',
    `interval`          integer not null default '0',
    `name`              text not null default '',
    `command`           integer not null,
    `run_for`           integer not null default '0',
    `status`            integer not null default '0',
    `args`              text not null default '',
    `hidden`            integer not null default 0,
    `condition`         text not null default ''
);
create index `idx_sch_server_id` on `schedule`(`server_id`);
create index `idx_sch_scheduled_ts` on `schedule`(`scheduled_ts`);
create index `idx_sch_status` on `schedule`(`status`);
create index `idx_sch_statusts` on `schedule`(`status`,`scheduled_ts`);
create table if not exists `bgplugin` (
    `name`              text not null,
    `version`           text not null,
    `installed_ts`      integer not null,
    `installed_files`   text not null,
    `server_id`         integer not null,
    `disabled`          integer not null,
    primary key  (`server_id`,`name`)
);
create table if not exists `move_status` (
    `server_id`         integer not null,
    `src_dmn`           integer not null,
    `dst_dmn`           integer not null,
    `status`            text not null,
    `message`           text not null,
    primary key (`server_id`)
);
create table if not exists `server_port` (
    `server_id`         integer not null,
    `port`              integer not null,
    primary key (`server_id`,`port`)
);
insert or ignore into `setting` (`key`, `value`) values('dbVersion', '19');
