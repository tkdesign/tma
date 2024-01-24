# tma

## About

Architectural studio website project based on custom PHP microframework. The site has a simple admin area for managing content.

## Copyrights

Author of the site: Petr Kovalenko, 2023.
Author of photos and renderings: architect Maria Tolypina, who holds the exclusive copyright to them. Use of these materials outside of this site is possible only with her permission.

## Getting started

### Database

Before launch this site, you must first import the `tma` database to a DBMS server that is compatible with MySql 8. For example, it can be Percona or MariaDB of appropriate versions.

The initial data of the database model `tma.mwb` and sql-script `tma.sql` to import the structure and data into the DBMS are in the `data` folder.

### Backend and frontend

All site files are located in the `htdocs` folder. Full path to the site on web-server may be same as this, for example: `/var/www/tma/htdocs`, where `htdocs` is `DOCUMENT_ROOT` folder). Additionally, you need to create a configuration file `config.php` in the `htdocs/App` folder with the following content:

```php
$config = array(
    "app_folder" => "App",
    "db_host" => "127.0.0.1",
    "db_port" => "3306",
    "db_username" => "root",
    "db_password" => "",
    "db_name" => "tma",
    "project_cards_per_page" => 9,
    "crm_records_per_page" => 10,
    "cards_records_per_page" => 10,
    "secret_key" => "Dam?U33?$7",
    'expiry' => 24
);
```

Here you must also specify the database user password (if it is used on the server).

The administrative interface of the site is hidden. The login page is available at the link `site_name/login.html`, login: `admin`, password: `admin`.

## Requirements

- PHP 7.4
- MySql Server 8 (Percona Server 8, MariaDB 10.7)
- Apache HTTP Server 2.4
- All modern desktop and mobile browsers
