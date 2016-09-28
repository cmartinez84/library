# _Library

#### _A page for librarians to manage inventory and patrons to checkout books_

#### By _**Chris Martinez & Evan Stewart**_


## Description
_This page will provide an interface for librarians to edit, update, delete and manage inventory, manage checkouts and view patron information. This page will also provide and interface for patrons to search for and checkout books_


## Specifications
| Behavior | Input Ex. | Output Ex. |
| --- | --- | --- |
|Create book entry with id, Author, Title, and Book Number|Enter Title: "Age of Innocence"| Title: "Age of Innocence"|
|update book information|"Great Catsby"|"Great Gatsby"|
|delete book information|"In Trump We Trust" by Anne Coulter| delete|
|read all book information| click on book title|Title:"Great Gatsby", Author: F Scott Fitzgerald, etc|
|Search by author|Hemmingway| "The Sun Also Rises", "For whom the Belle Tolls", etc...|



## Setup/Installation Requirements
* _Clone this repository to your desktop_
* _Run composer install from root_
* _Navigate to the web folder and begin your local server (php -S localhost:8000)_
 * _Begin MAMP_
* _Iinitialize new Database by doing the following:_
* _Begin MySql Shell by running $ /Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot_
* _CREATE DATABASE stylists_
* _USE stylists_
* _CREATE TABLE stylist(id serial PRIMARY KEY, name VARCHAR(255), date_began VARCHAR(255), specialty VARCHAR(255))_
* _CREATE TABLE client(id, serial PRIMARY KEY, name VARCHAR(255), last_appointment VARCHAR(255), next_appointment VARCHAR(255))_
* _Alternatively, unzip the database contained at the top level of this folder and import from phpmyadmin (http://localhost:8888/phpmyadmin/)_
* _in phpmyadmin, you may have also create another database for use with phpunit tests files by going to Operations> Copy Database To> and remaning database "stylists_test" and chooosing "structure only"_

* _Change localhost routing in app.php (and php documents in tests folder) to localhost enabled for mySQL. ex mysql:...host=localhost:8889;dbname=....in MAMP, you can find this by going to  MAMP > Preferences > Ports> MySql Port_
* _In terminal, navigate to _
* _Open Browser and navigate to http://localhost:8000_
## Link
https://github.com/cmartinez84/string-word-search

## Known Bugs
_None yet_

## Support and contact details
_cardamomclouds@yahoo.com_

## Technologies Used
_HTML,
CSS,
Bootstrap,
JS,
jQuery
PHP,
TWIG,
Silex,
mySQL_

### License
The MIT License (MIT)

Copyright (c) 2016 **_Chris Martinez_**
