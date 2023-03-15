Product TABLE
- productid PRIMARY KEY
- productname
- categoryid FOREIGN KEY
- price
- imgURL
- sale <- null OR percentage

Category TABLE
- categoryid PRIMARY KEY
- categoryname

Orders TABLE
- ordernum PRIMARY KEY
- clientid FOREIGN KEY
- orderdate
- orderstate

Orderrow TABLE
- ordernum PRIMARY KEY
- rownum PRIMARY KEY
- productid FOREIGNKEY
- pcs

Client TABLE
- clientid PRIMARY KEY
- clientname
- postalcode
- clientaddress
- phonenumber

