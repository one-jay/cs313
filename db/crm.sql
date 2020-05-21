
-- ************************************** Account

CREATE TABLE Account
(
 id     serial NOT NULL,
 Name   varchar(50) NOT NULL,
 Street varchar(50) NOT NULL,
 City   varchar(50) NOT NULL,
 State  varchar(50) NOT NULL,
 Zip    varchar(50) NOT NULL,
 CONSTRAINT PK_Account PRIMARY KEY ( id )
);


-- ************************************** Contact

CREATE TABLE Contact
(
 id        serial NOT NULL,
 Account   integer NOT NULL,
 FirstName varchar(50) NOT NULL,
 LastName  varchar(50) NOT NULL,
 Phone     varchar(50) NULL,
 Email     varchar(50) NULL,
 CONSTRAINT PK_Contact PRIMARY KEY ( id ),
 CONSTRAINT FK_14 FOREIGN KEY ( Account ) REFERENCES Account ( id )
);

CREATE INDEX fkIdx_14 ON Contact
(
 Account
);

-- ************************************** Opportunity

CREATE TABLE Opportunity
(
 id      serial NOT NULL,
 Account integer NOT NULL,
 Stage   varchar(50) NOT NULL,
 CONSTRAINT PK_Opportunity PRIMARY KEY ( id ),
 CONSTRAINT FK_24 FOREIGN KEY ( Account ) REFERENCES Account ( id )
);

CREATE INDEX fkIdx_24 ON Opportunity
(
 Account
);


-- ************************************** Product

CREATE TABLE Product
(
 id          serial NOT NULL,
 Name        varchar(50) NOT NULL,
 Description text NOT NULL,
 ListPrice   money NOT NULL,
 CONSTRAINT PK_Product PRIMARY KEY ( id )
);


-- ************************************** Quote

CREATE TABLE Quote
(
 id          serial NOT NULL,
 Opportunity integer NOT NULL,
 Amount      money NOT NULL,
 CONSTRAINT PK_Quote PRIMARY KEY ( id ),
 CONSTRAINT FK_30 FOREIGN KEY ( Opportunity ) REFERENCES Opportunity ( id )
);

CREATE INDEX fkIdx_30 ON Quote
(
 Opportunity
);


-- ************************************** QuoteLine

CREATE TABLE QuoteLine
(
 id       serial NOT NULL,
 Quote    integer NOT NULL,
 Product  integer NOT NULL,
 Price    money NOT NULL,
 Quantity int NOT NULL,
 CONSTRAINT PK_QuoteLine PRIMARY KEY ( id ),
 CONSTRAINT FK_36 FOREIGN KEY ( Quote ) REFERENCES Quote ( id ),
 CONSTRAINT FK_45 FOREIGN KEY ( Product ) REFERENCES Product ( id )
);

CREATE INDEX fkIdx_36 ON QuoteLine
(
 Quote
);

CREATE INDEX fkIdx_45 ON QuoteLine
(
 Product
);

