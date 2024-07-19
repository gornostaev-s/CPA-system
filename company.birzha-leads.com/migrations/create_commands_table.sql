create table commands
(
    id      int auto_increment,
    telegram_id  varchar(255) null,
    title varchar(255) null,
    created_at             datetime default CURRENT_TIMESTAMP          null,
    constraint commands_pk
        primary key (id)
);