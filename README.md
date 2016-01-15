# Openstore Schema Core

[![Dependency Status](https://www.versioneye.com/user/projects/5677ba2b107997003e0011c3/badge.svg?style=flat)](https://www.versioneye.com/user/projects/5677ba2b107997003e0011c3)

Openstore core database schema.

## Requirements

- PHP engine 5.4+, 7.0+ or HHVM >= 3.2.
- Currently supported database platforms (Mysql, MariaDb)

| Database      | Extra              |
|---------------|--------------------|
| MySQL 5.6+    | INNODB engine      |
| Mariadb 10+   | INNODB/XTRADB      |
| Percona 5.6+  | INNODB/XTRADB      |


## Install

### In your existing project

Via composer

```sh
$ composer require openstore/schema-core:dev-master
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

```console
$ ./vendor/bin/openstore-schema-core.php openstore:schema:create --dump-sql
```

*Remove --dump-sql to execute query on your database*


### Get SQL to (re-)create db extras (triggers, procedures, functions, events...)

```console
$ ./vendor/bin/openstore-schema-core.php openstore:schema:recreate-extra --dump-sql
```

### Drop database (only testing environment)

```console
$ ./vendor/bin/openstore-schema-core.php openstore:schema:drop 
```

## Notes

### Compressing tables

If INNODB file_format is barracuda you can change the compression format of the following tables

```sql
ALTER TABLE product_translation ROW_FORMAT=COMPRESSED KEY_BLOCK_SIZE=16;
ALTER TABLE product_category_translation ROW_FORMAT=COMPRESSED KEY_BLOCK_SIZE=8;

ALTER TABLE sale_order_line ROW_FORMAT=COMPRESSED KEY_BLOCK_SIZE=16;
ALTER TABLE sale_order ROW_FORMAT=COMPRESSED KEY_BLOCK_SIZE=8;
```
	