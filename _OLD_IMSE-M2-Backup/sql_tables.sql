CREATE DATABASE IF NOT EXISTS db;
USE db;

CREATE TABLE IF NOT EXISTS LOCATIONS(
LOCATION_ID INTEGER PRIMARY KEY NOT NULL,
ZIP_CODE INTEGER,
STREET VARCHAR(100),
CITY VARCHAR(100)
);


CREATE TABLE IF NOT EXISTS COSTUMER(
EMAIL VARCHAR(100) UNIQUE NOT NULL,
PHONE_NUMBER INTEGER PRIMARY KEY,
FIRSTNAME VARCHAR(100),
SURNAME VARCHAR(100),
LOCATIONID INTEGER,
FOREIGN KEY (LOCATIONID) REFERENCES LOCATIONS (LOCATION_ID)
);

CREATE TABLE IF NOT EXISTS ARE_FRIENDS(
friend_costumer_email_1 VARCHAR(100),
friend_costumer_email_2 VARCHAR(100),
FOREIGN KEY (friend_costumer_email_1) REFERENCES COSTUMER (EMAIL),
FOREIGN KEY (friend_costumer_email_2) REFERENCES COSTUMER (EMAIL)
);


CREATE TABLE IF NOT EXISTS BILLING(
BILL_NUMBER INTEGER PRIMARY KEY NOT NULL,
TOTAL_PRICE INTEGER check(TOTAL_PRICE>=30),
BILLDATE DATE,
C_EMAIL VARCHAR(100),
FOREIGN KEY (C_EMAIL) REFERENCES COSTUMER (EMAIL)
);


CREATE TABLE IF NOT EXISTS RESERVATION(
RESERVATION_NUMBER INTEGER PRIMARY KEY NOT NULL,
FROM_DATE DATE,
RETURN_DATE DATE,
AMOUNT INTEGER,
RESERVATION_BILL_NUMBER INTEGER REFERENCES BILLING (BILL_NUMBER)
);

CREATE TABLE IF NOT EXISTS INSURANCE(
INSURANCE_NUMBER INTEGER PRIMARY KEY REFERENCES RESERVATION(RESERVATION_NUMBER) ON DELETE CASCADE ,
NAME VARCHAR(100)
);


CREATE TABLE IF NOT EXISTS CAR(
REGISTRATION_NUMBER INTEGER PRIMARY KEY NOT NULL,
CAR_MODEL VARCHAR(100),
MODEL_YEAR INTEGER,
DAILY_PRICE INTEGER DEFAULT 40
);

CREATE TABLE IF NOT EXISTS SPORT_CAR(
SPORT_REGISTRATION_NUMBER INTEGER PRIMARY KEY REFERENCES CAR (REGISTRATION_NUMBER)
);

CREATE TABLE IF NOT EXISTS NORMAL_CAR(
NORMAL_REGISTRATION_NUMBER INTEGER PRIMARY KEY REFERENCES CAR (REGISTRATION_NUMBER)
);

CREATE TABLE IF NOT EXISTS FAMILY_CAR(
FAMILY_REGISTRATION_NUMBER INTEGER PRIMARY KEY REFERENCES CAR (REGISTRATION_NUMBER)
);

CREATE TABLE IF NOT EXISTS RENT(
RENT_EMAIL VARCHAR(100),
RENT_CAR INTEGER,
RENT_RESERVATION INTEGER,
FOREIGN KEY (RENT_EMAIL) REFERENCES COSTUMER (EMAIL),
FOREIGN KEY (RENT_CAR) REFERENCES CAR (REGISTRATION_NUMBER),
FOREIGN KEY (RENT_RESERVATION) REFERENCES RESERVATION (RESERVATION_NUMBER)
);



