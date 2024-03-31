-- auto-generated definition
create table challengers
(
id                     int auto_increment
primary key,
inn                    int                                         null,
created_at             datetime default CURRENT_TIMESTAMP          null,
fio                    varchar(255)                                null,
address                varchar(255)                                null,
owner_id               int      default 1                          null,
operation_type         int      default 1                          null,
phone                  bigint                                      null,
comment                varchar(255)                                null,
comment_adm            varchar(255)                                null,
status                 int      default 1                          null,
process_status         int      default 1                          null
);