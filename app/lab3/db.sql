create table request
(
    id serial primary key,
    surname varchar(64) not null,
    name varchar(64) not null,
    middle_name varchar(64) not null,
    phone char(10) not null,
    email varchar(64) not null,
    comment text not null,
    date timestamp not null
)