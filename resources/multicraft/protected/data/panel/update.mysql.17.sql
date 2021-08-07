create table if not exists `ip_counter` (
  `ip`                  varchar(128) not null primary key,
  `time`                integer not null,
  `count`               tinyint unsigned not null
) default charset=utf8;
