create table if not exists `server_port` (
    `server_id`         integer not null,
    `port`              integer not null,
    primary key (`server_id`,`port`)
) default charset=utf8;
alter table `ftp_user_server` drop foreign key `ftp_user_server_ibfk_2`, drop key `server_id`;
