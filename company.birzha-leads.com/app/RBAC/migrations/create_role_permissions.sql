create table role_permissions
(
    id                  int auto_increment,
    role_id             int,
    permission_id       int,
    constraint role_permissions_pk
        primary key (id)
);