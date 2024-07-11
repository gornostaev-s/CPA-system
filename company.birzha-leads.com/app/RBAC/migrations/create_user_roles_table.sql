create table user_roles
(
    id                  int auto_increment,
    role_id             int,
    user_id             int,
    constraint user_roles_pk
        primary key (id)
);