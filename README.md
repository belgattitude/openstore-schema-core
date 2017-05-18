# Openstore Schema Core

[![PHP Version](http://img.shields.io/badge/php-5.5+-ff69b4.svg)](https://packagist.org/packages/begattitude/openstore-schema-core)
[![Build Status](https://travis-ci.org/belgattitude/openstore-schema-core.svg?branch=master)](https://travis-ci.org/belgattitude/openstore-schema-core)
[![Dependency Status](https://www.versioneye.com/user/projects/5677ba2b107997003e0011c3/badge.svg?style=flat)](https://www.versioneye.com/user/projects/5677ba2b107997003e0011c3)
[![Latest Stable Version](https://poser.pugx.org/openstore/schema-core/v/stable.svg)](https://packagist.org/packages/openstore/schema-core)
[![Total Downloads](https://poser.pugx.org/openstore/schema-core/downloads.png)](https://packagist.org/packages/openstore/schema-core)
[![License](https://poser.pugx.org/openstore/schema-core/license.png)](https://packagist.org/packages/openstore/schema-core)

openstore-schema-core provides the database schema used in the openstore project. It consists of around 80 tables
specifically designed to be used in a product catalog database.
   
> **Disclaimer: this is a work-in-progress !**   

![product_erd_image](https://github.com/belgattitude/openstore-schema-core/blob/master/docs/image/erd-zoom-product.jpg "Product erd")

> Warning: the `openstore-schema-core` project relies on doctrine2 to facilitate schema generation.
> No work have been done to make entities useful through doctrine as openstore use `zend-db` for
> database access. In other words, schema generation works well but there's work to do if
> you need using doctrine for data access *(fix naming of relationship, make repositories...)*.
   
## Requirements

- PHP 5.5+, 7.0+ or HHVM >= 3.2.
- MySQL or MariaDB with InnoDB

## Features

- [x] Automatic schema generation from doctrine entities. 
- [x] Support for painless schema migrations.
- [x] Provides special triggers, procedures and functions (see [extras](https://github.com/belgattitude/openstore-schema-core/blob/master/src/OpenstoreSchema/Core/Extra/MysqlExtra.php)).
- [x] Raw sql generation. (see [generated sql](https://github.com/belgattitude/openstore-schema-core/tree/master/resources/sql))

# Install

## Clone the project

```shell
$ git clone https://github.com/belgattitude/openstore-schema-core.git
```

*Alternatively you can install the project through composer `composer require openstore/schema-core`*
        
## Setup

### Configuration

Make a copy of the [distribution config file](https://github.com/belgattitude/openstore-schema-core/blob/master/config/openstore-schema-core.config.php.dist) and
edit your database parameters:

```shell
$ cp ./config/openstore-schema-core.config.php.dist ./config/openstore-schema-core.config.php
# Edit database parameters
$ vi ./config/openstore-schema-core.config.php
```

### Database

First ensure your database server is supported and enable support for `utf8mb4` charset.

| Database      | Storage engine     | File format  | Large prefix |
|---------------|--------------------|-------------:|-------------:|
| MySQL 5.6+    | INNODB engine      | Barracuda    |          On  |
| Mariadb 10+   | INNODB/XTRADB      | Barracuda    |          On  |

> Note: to be able to work with `utf8mb4`check that the following 
> parameters are present in the mysql configuration file (`my.cnf`):
>   - [x] `innodb_file_per_table=1`
>   - [x] `innodb_file_format=barracuda`
>   - [x] `innodb_large_prefix=1`      
> *(Note that from MariaDB 10.2.2 and Mysql 5.7.7 some of those params have become default)* 

Then create a new database:

```shell
$ mysql -e "CREATE DATABASE openstore_test CHARACTER SET='utf8mb4' COLLATE='utf8mb4_unicode_ci';" -u {USER} -p
```

## Commands

You can list the registered commands by executing: 

```shell
$ ./bin/openstore-schema-core
```

Practically, use the following commands for:

| Command                            | Description                                     |
|------------------------------------|-------------------------------------------------|
| `openstore:schema:create`          | Create a schema on a new empty database.        |
| `openstore:schema:recreate-extra`  | Recreate all triggers, procedures, functions... |
| `openstore:schema:update`          | Apply schema migration on an existing database. |

> NOTE: use the option `--dump-sql` to display the DDL instead of applying onto the database.
> This is particularly useful to show migration needed over a production database, for example:
> ```shell
> $ ./bin/openstore-schema-core openstore:schema:update --dump-sql
> ```
> Will show the migrations that have to be applied on the *current* database. 

## FAQ

> Caution: backup and restore recipes described below have not been for real production 
> usage. Always be sure of what you're doing.
    
### Backup a database

With `mysqldump`, good to backup `schema` (ddl) and `data` (inserts) in separated files, it
allows to restore the data on a fresh database. As an example:

```shell
# 1. Backup of the schema (ddl: create tabes, routines...)
$ mysqldump -u {USER} -p --no-data --triggers --events --routines --default-character-set=utf8mb4 {DATABASE} > /{PATH}/{DATABASE}.schema.sql
# 2. Backup of the data (sql: inserts)
$ mysqldump -u {USER} -p --no-create-info --skip-triggers --complete-insert --disable-keys --default-character-set=utf8mb4 --lock-tables {DATABASE} > /{PATH}/{DATABASE}.data.sql 
```

### Restore data on an newly created schema

First perform a backup with `mysqldump` as illustrated above, then create a new schema:

```shell
# 1. Generate the latest openstore schema
$ ./bin/openstore-schema-core openstore:schema:create --dump-sql > /{PATH}/openstore.schema.sql
# 2. Create a new database that will hold it  
$ mysql -e "create database {NEW_DATABASE} CHARSET='utf8mb4' COLLATE='utf8mb4_unicode_ci'" -u{USER} -p
# 3. Apply the latest generated schema on your newly created database
$ mysql -u {USER} -p {NEW_DATABASE} < /{PATH}/openstore.schema.sql
# 4. Restore the 'data' backup of your old database in the new database.
$ mysql -u {USER} -p {NEW_DATABASE} < /{PATH}/{BACKUP_FILE}.data.sql
```

### Move/rename database

After having restored the database in the new schema, you might want to 
move/rename it. 
 
For development or small database, you can use `mysqldump`:
      
```shell
# 1. Create the new database (a new empty one) 
$ mysql -e "create database {NEW_DATABASE} CHARSET='utf8mb4' COLLATE='utf8mb4_unicode_ci'" -u{USER} -p
# 2. Complete backup of your database 
$ mysqldump -u {USER} -p --routines --events --triggers --default-character-set=utf8mb4 {DATABASE} > /{PATH}/{DATABASE}.all.sql
# 3. Restore the complete backup in the new database
$ mysql -u {USER} -p {NEW_DATABASE} < /{PATH}/{DATABASE}.all.sql      
```

*You can also (unix)-pipe the two last commands*      

## Future
      
- [ ] Fix entities and remove magic methods `__get` and `__set`.
- [ ] Start working on repositories.
- [ ] Document tables and conventions.
- [ ] Add doctrine validate to CI (fix wrong relations names).      
      
## Notes

### Unicode

From version 0.40.0, `openstore-schema-core` defaults to `utf8mb4` charset by default. 

If you don't have the possibility to set mysql server variables (i.e. on a continuous integration server...)
you can fall back to the [generated compatibility scripts](https://github.com/belgattitude/openstore-schema-core/tree/master/resources/sql/mysql-utf8-compat).


### Compressing tables

Optional, to reduce disk usage you can change the compression format of the following tables:

```sql
ALTER TABLE product_translation ROW_FORMAT=COMPRESSED KEY_BLOCK_SIZE=8;
ALTER TABLE product_category_translation ROW_FORMAT=COMPRESSED KEY_BLOCK_SIZE=8;

ALTER TABLE sale_order_line ROW_FORMAT=COMPRESSED KEY_BLOCK_SIZE=8;
ALTER TABLE sale_order ROW_FORMAT=COMPRESSED KEY_BLOCK_SIZE=8;
```


## Contributing

Contributions are welcome, fork the repository and make a pull request.

### Tips for contributors

Be sure to execute code style check before commit:

```shell
$ composer cs-check
```

You can also fix the code style issues automatically:

```shell
$ composer cs-fix
```

Don't forget to regenerate regenerate the [sql doc](https://github.com/belgattitude/openstore-schema-core/tree/master/resources/sql):

```shell
$ composer build
```
