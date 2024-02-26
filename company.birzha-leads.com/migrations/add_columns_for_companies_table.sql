alter table companies
    add address varchar(255) null,
    add owner_id int default 1,
    add operation_type int default 1,
    add phone bigint null,
    add comment varchar(255) null,
    add comment_adm varchar(255) null,
    add submission_date datetime default CURRENT_TIMESTAMP,
    add sent_date datetime default null,
    add registration_exit_date datetime default (CURRENT_TIMESTAMP + interval 3 day),
    add alfabank_data json,
    add tinkoff_data json,
    add sberbank_data json,
    add psb_data json
;