CREATE DATABASE IF NOT EXISTS crmtool;
use crmtool;

CREATE TABLE IF NOT EXISTS Person(
ID integer not null AUTO_INCREMENT,
PRIMARY KEY(ID),
Name TEXT(30) not null,
Lastname TEXT(30) not null
);
CREATE TABLE IF NOT EXISTS Shop(
ShopID integer not null AUTO_INCREMENT,
Name TEXT(30) not null,
City TEXT(30) not null,
PRIMARY KEY(ShopID),
CONSTRAINT Check_city CHECK (City in ('WIEN', 'GRAZ', 'LINZ', 'INNSBRUCK', 'BREGENZ'))
);
CREATE TABLE IF NOT EXISTS Employee(
EmployeeID integer not null AUTO_INCREMENT,
Wage integer not null,
Workinghours integer not null,
ID integer not null,
ShopID integer not null,
Chief_ID integer,
FOREIGN KEY(Chief_ID) REFERENCES Employee(EmployeeID),
CONSTRAINT fkperson_ID FOREIGN KEY(ID) REFERENCES Person(ID) ON DELETE CASCADE,
FOREIGN KEY(ShopID) REFERENCES Shop(ShopID),
PRIMARY KEY(EmployeeID)
);
CREATE TABLE IF NOT EXISTS Customer(
CustomerID integer not null AUTO_INCREMENT,
phonenumber TEXT(30) not null,
Discountrate TEXT(30) not null,
ID integer not null REFERENCES Person(ID),
CONSTRAINT Check_discountrate CHECK (Discountrate in ('%0','%10','%15','%20','%25')),
Primary key(CustomerID)
);
CREATE TABLE IF NOT EXISTS Accessories(
ID integer not null AUTO_INCREMENT,
Brand TEXT(30) not null,
Price integer not null,
CustomerID integer not null REFERENCES Customer(CustomerID),
EmployeeID integer not null REFERENCES Employee(EmployeeID),
PRIMARY KEY(ID)
);
CREATE TABLE IF NOT EXISTS BikeService(
ServiceID integer not null,
AvailablePlace integer not null,
Roomsize integer not null,
ShopID integer not null REFERENCES Shop(ShopID) ON DELETE CASCADE ,
PRIMARY KEY(ShopID,ServiceID)
);
CREATE TABLE IF NOT EXISTS Bike(
BikeID integer not null AUTO_INCREMENT,
CustomerID integer not null,
Price integer not null,
Modelname TEXT(30) not null,
ServiceID integer not null REFERENCES BikeService(ServiceID),
ShopID integer not null REFERENCES BikeService(ShopID),
FOREIGN KEY(CustomerID) REFERENCES Customer(CustomerID),
PRIMARY KEY(BikeID)
);
CREATE TABLE IF NOT EXISTS Repairs(
BikeID integer not null,
EmployeeID integer not null,
Repairdate Date,
FOREIGN KEY(BikeID) REFERENCES Bike(BikeID),
FOREIGN KEY(EmployeeID) REFERENCES Employee(EmployeeID),
PRIMARY KEY(BikeID,EmployeeID,Repairdate)
);
