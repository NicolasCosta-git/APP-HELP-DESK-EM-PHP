create database HelpDesk;
go

use HelpDesk;
go

create table Users(
id int identity,
name varchar(80) not null,
email varchar(50) not null,
password varchar(100) not null,
avatar varchar(600) null,
primary key(id)
);

create table Calls(
id int identity,
userId int not null,
title varchar(100) not null,
description text not null,
type varchar(40) not null,
status int null,
createdAt varchar(30) null,
closedAt varchar(30) null,
primary key(id),
foreign key(userId) references Users(id) on delete cascade
);

create table Messages(
id int identity,
userId int not null,
callId int not null,
message text not null,
primary key(id),
foreign key(userId) references Users(id),
foreign key(callId) references Calls(id) on delete cascade
);

 
