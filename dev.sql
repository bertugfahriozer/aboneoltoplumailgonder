create table settings
(
    pk int(11) unsigned auto_increment,
    mailaddress text not null,
    password varchar(255) not null,
    istls boolean null,
    port int(5) not null,
    constraint settings_pk
        primary key (pk)
);

create table aboneler
(
    pk int(11) unsigned auto_increment,
    mailaddress text not null,
    isActive boolean null,
    token varchar(40) not null,
    constraint aboneler_pk
        primary key (pk)
);

create unique index aboneler_mailaddress_uindex
	on aboneler (mailaddress);

alter table settings
    add host varchar(255) null;

