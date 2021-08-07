create table if not exists `ip_counter` (
  `ip`                  text not null primary key,
  `time`                integer not null,
  `count`               integer not null
);
