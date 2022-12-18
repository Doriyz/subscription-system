```mysql
create database SubscriptionSystem;

use SubscriptionSystem;

create table Guest(
    gno varchar(8) not null ,
    gname varchar(30) not null ,
    gpassword varchar(20) not null ,
    gemail varchar(30),
    gaddress varchar(100) not null ,
    gtelephone varchar(20),
    gpostcode varchar(6) not null ,
    primary key (gno)
);

alter table Guest
modify gtelephone varchar(20) not null ;

alter table Guest
modify gemail varchar(20) not null ;

create table Paper(
    pno varchar(4) not null ,
    pname varchar(30) not null ,
    pprice decimal(5,2) not null ,
    pwidth int,
    pheight int,
    ppublisher varchar(30),
    primary key (pno)
);

alter table Paper
add column frequency int default 30 not null after pprice;


use SubscriptionSystem;

create table Orders(
    ono varchar(10) not null ,
    gno varchar(8) not null ,
    pno varchar(4) not null ,
    onumber int not null ,
    primary key (ono),
    foreign key (gno) references Guest(gno),
    foreign key (pno) references Paper(pno)
);

alter table Orders
add column period int default 1 not null after onumber;

create table Bill(
   btime datetime not null,
   ono varchar(10) not null ,
   primary key (btime,ono),
   foreign key (ono) references Orders(ono)
);

delimiter //
create procedure addPaper(
    in no varchar(4) ,
    in name varchar(30) ,
    in price decimal(5,2),
    in width int,
    in height int,
    in publisher varchar(30)
    )
begin
    insert into Paper(pno, pname, pprice, pwidth, pheight, ppublisher)
        values(no,name,price,width,height,publisher);
end//
delimiter ;

call addPaper(1, '泉州晚报', 1.5,null,null,null);
call addPaper(2, '羊城晚报', 1.3,300,450,'羊城出版社');

delimiter //
create procedure addGuest(
    in no varchar(8),
    in name varchar(30),
    in passWord varchar(20),
    in email varchar(30),
    in address varchar(100),
    in telephone varchar(20),
    in postcode varchar(6)
)
begin
    insert into Guest(gno, gname, gpassword, gemail, gaddress, gtelephone, gpostcode)
        VALUES(no, name, passWord,email, address, telephone, postcode);
end //
delimiter ;

call addGuest(1, '小张', '123456', null, '地球村', '16677778888', '666666');
call addGuest(2, '小美', '123456', 'xiaomei@mail.com', '北极村', '123456', '111111');

INSERT INTO Guest VALUES('3', 'xiaoxuan', '123456', 'xiaoxuan@qq.com', 'some place', '15805953958', '040252');

use SubscriptionSystem;

delete from Guest
    where gno = '3';


delimiter //
create procedure addOrder(
    in no varchar(10),
    in gno varchar(8),
    in pno varchar(4),
    in number int
)
begin
    insert into Orders(ono, gno, pno, onumber)
        values (no, gno, pno, number);
end //
delimiter ;

call addOrder(1, 1, 1, 1);
call addOrder(2, 2, 1, 2);
call addOrder(3, 1, 2, 4);

delimiter //
create procedure addBill(
    in time datetime,
    in no varchar(10)
)
begin
    insert into Bill(btime, ono)
        values (time, no);
end //

call addBill(NOW(), 1);

# get price by paper's serial number
delimiter //
create procedure getPriceByPno(
    in pno varchar(10)
)
begin
    select pprice
        from Paper
            where Paper.pno = pno;
end //
delimiter ;

call getPriceByPno(1);

# count the number of papers
delimiter //
create procedure countTotalPaper()
begin
    select count(pno)
        from Paper;
end //
delimiter ;

call countTotalPaper();


# get the total subscription message of all papers order by total number
delimiter //
create procedure getTotalSubscriptionMessageOrderByTotalNumber()
begin
    select sum(onumber) as totalNumber, pno, pname, pprice, pwidth, pheight, ppublisher, sum(onumber)*pprice as totalPrice
        from Orders natural join Paper
            group by pno
                order by totalNumber desc;
end //


# get the total subscription message of all papers order by pno
delimiter //
create procedure getPaperMessageOrderByPno()
begin
    select  pno, pname, pprice, pwidth, pheight, ppublisher,sum(onumber) as totalNumber,sum(onumber)*pprice as totalPrice
        from Orders natural join Paper
            group by pno
                order by pno;
end //

call getPaperMessageOrderByPno();
call getTotalSubscriptionMessageOrderByTotalNumber();

delete from Guest where gno = '4';

use SubscriptionSystem;

ALTER TABLE Guest MODIFY gpassword varchar(60);

delete from Orders where not ono = '1' ;

use SubscriptionSystem;

select distinct btime from Bill natural join Orders
where gno = '8';

select * from Bill natural join Orders natural join Paper
where btime = "2022-12-17 16:14:08";

```

