-- auto-generated definition
create table zvonok_clients
(
    id                     int auto_increment primary key,
    created_at             datetime default CURRENT_TIMESTAMP          null,
    phone                  varchar(255)                                null,
    status                 int      default 1                          null,
    project_id             int                                         null
);