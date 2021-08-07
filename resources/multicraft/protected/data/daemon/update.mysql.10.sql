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
  `server_id` integer not null,
  `src_dmn` integer not null,
  `dst_dmn` integer not null,
  `status` varchar(32) not null,
  `message` text not null,
  primary key (`server_id`)
) default charset=utf8;
