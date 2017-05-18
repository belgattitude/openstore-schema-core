# Openstore Schema Core

[![Dependency Status](https://www.versioneye.com/user/projects/5677ba2b107997003e0011c3/badge.svg?style=flat)](https://www.versioneye.com/user/projects/5677ba2b107997003e0011c3)

Openstore database schema.

> Warning: While the openstore database schema is relying on doctrine2, no work
> has been done yet to develop repositories and ensure model relationships (correct naming).
> In other words, doctrine was just used to keep a way to generate sql not to consume data
> as the datalayer has been developped with zend-db.

## Requirements

- PHP engine 5.4+, 7.0+ or HHVM >= 3.2.
- Currently supported database platforms (Mysql, MariaDb)

| Database      | Extra              |
|---------------|--------------------|
| MySQL 5.6+    | INNODB engine  )   |
| Mariadb 10+   | INNODB/XTRADB      |
| Percona 5.6+  | INNODB/XTRADB      |

> To be able to work with utf8mb4 for users of MySQL < 5.7 or MariaDB < 10.2,
> you must ensure `innodb_file_per_table=1`, `innodb_file_format=barracuda` and `innodb_large_prefix=1`.
> at the server settings level (my.cnf) AND that your tables are created with
> `CREATE TABLE .... InnoDB ROW_FORMAT=DYNAMIC`. (a default value has been introduced in MariaDB 10.2: innodb_default_row_format).
> *Note that from MariaDB 10.2.2 `barracuda` has become the default file format.* 

## Install

### In your existing project

Via composer

```sh
$ composer require openstore/schema-core
```
    
### Standalone setup

For standalone setup, you must ensure a local configuration exists with
correct database parameters.

```sh
$ mkdir config
$ cp ./vendor/openstore/schema-core/config/openstore-schema-core.config.php.dist ./config/openstore-schema-core.config.php
# Edit database parameters
$ vi ./config/openstore-schema-core.config.php
```

### Database creation

```console
mysql -e "CREATE DATABASE my_test_db;" -uroot -p
```


## Openstore schema commands

### List commands

```console
$ ./vendor/bin/openstore-schema-core
```

### Get SQL to create database (and db extras)

Use this command to dump the changes from your existing schema

```console
$ ./vendor/bin/openstore-schema-core openstore:schema:create --dump-sql
```

*Remove --dump-sql to execute query on your database*


### Get SQL to (re-)create db extras (triggers, procedures, functions, events...)

```console
$ ./vendor/bin/openstore-schema-core openstore:schema:recreate-extra --dump-sql
```

### Drop database (only testing environment)

```console
$ ./vendor/bin/openstore-schema-core openstore:schema:drop 
```

## Notes

### Compressing tables

If INNODB file_format is barracuda you can change the compression format of the following tables

```sql
ALTER TABLE product_translation ROW_FORMAT=COMPRESSED KEY_BLOCK_SIZE=8;
ALTER TABLE product_category_translation ROW_FORMAT=COMPRESSED KEY_BLOCK_SIZE=8;

ALTER TABLE sale_order_line ROW_FORMAT=COMPRESSED KEY_BLOCK_SIZE=8;
ALTER TABLE sale_order ROW_FORMAT=COMPRESSED KEY_BLOCK_SIZE=8;
```

## ERD

### Basic zoom on product group tables

![product_erd_image](https://raw.githubusercontent.com/belgattitude/openstore-schema-core/master/docs/image/erd-zoom-product.jpg "Product erd")

	