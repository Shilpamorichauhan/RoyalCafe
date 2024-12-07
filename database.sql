create database royal;

use royal;

Create table users(
    name varchar(20),
    email varchar(255) primary key,
    password varchar(255),
    role varchar(10) DEFAULT 'user'
);

create table products(
    imgname varchar(255),
    name varchar(255),
    description varchar(255),
    price int,
    type varchar(255)
);

create table orders(
    name varchar(255),
    quantity int,
    price int,
    totalPrice int,
    address varchar(255),
    paymentType varchar(255) DEFAULT 'CASH'
);      

