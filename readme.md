# TM Architektura

---

## About

TM Architektura is a website of the architectural bureau

## Copyrights

The author of the program code of this site is Peter Kovalenko.

Photos of completed projects and renderings of architectural concepts are provided for this site by architect Maria Tolypina, who holds the exclusive copyright to them. Use of these materials outside of this site is possible only with her permission.

## Getting started

### Database

For the site to work, you must first import the `tma` database to a DBMS server that is compatible with MySql 8. For example, it can be Percona or MariaDB of appropriate versions.

The initial data of the database model `tma.mwb` and sql-script `tma.sql` to import the structure and data into the DBMS are in the `data` folder.

### Backend and frontend

The backend of the site is written in php and is compatible with version 7.4. The frontend uses a template with vanilla JavaScript, as well as Bootstrap 5 library to style the interface and implement various special effects.

The server side of the site does not use any frameworks or CMS, only pure php. Especially for this project wrote its own implementation of the concept of MVC and routing requests.

All site files are located in the `htdocs` folder. Additionally, you need to create a configuration file `config.php` in the `htdocs/App` folder with the following content:

```php
$config = array(
    "app_folder" => "App",
    "db_host" => "127.0.0.1",
    "db_port" => "3306",
    "db_username" => "root",
    "db_password" => "",
    "db_name" => "tma",
    "project_cards_per_page" => 9
);
```

Here you must also specify the database user password (if it is used on the server).

## Requirements

- PHP 7.4
- MySql 8
- Apache 2.4
- All modern desktop and mobile browsers