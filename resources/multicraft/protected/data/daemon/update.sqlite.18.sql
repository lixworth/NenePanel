create table if not exists `server_port` (
    `server_id`         integer not null,
    `port`              integer not null,
    primary key (`server_id`,`port`)
);
pragma foreign_keys=off;
drop index if exists `idx_fussv_perms`;
alter table `ftp_user_server` rename to `_ftp_user_server_temp`;
create table if not exists `ftp_user_server` (
    `user_id`           integer not null,
    `server_id`         integer not null,
    `perms`             text not null default 'elr',
    primary key (`user_id`, `server_id`),
    foreign key(`user_id`) references `ftp_user`(`id`) on delete cascade on update cascade
);
create index `idx_fussv_perms` on `ftp_user_server`(`perms`);
insert into `ftp_user_server` select * from `_ftp_user_server_temp`;
drop table `_ftp_user_server_temp`;
pragma foreign_keys=on;
