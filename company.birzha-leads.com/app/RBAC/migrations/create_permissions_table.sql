create table permissions
(
    id             int auto_increment,
    name           varchar(255),
    description    varchar(255),
    constraint permissions_pk
        primary key (id)
);