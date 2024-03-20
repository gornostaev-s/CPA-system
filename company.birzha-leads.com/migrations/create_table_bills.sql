create table bills
(
    id      int auto_increment,
    status  int default 0 null,
    type    int       not null,
    client_id int           null,
    partner int           null,
    comment text          null,
    date    datetime      null,
    constraint bills_pk
        primary key (id)
);