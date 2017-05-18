# Openstore Schema Core

[![PHP Version](http://img.shields.io/badge/php-5.5+-ff69b4.svg)](https://packagist.org/packages/begattitude/openstore-schema-core)
[![Build Status](https://travis-ci.org/belgattitude/openstore-schema-core.svg?branch=master)](https://travis-ci.org/belgattitude/openstore-schema-core)
[![Dependency Status](https://www.versioneye.com/user/projects/5677ba2b107997003e0011c3/badge.svg?style=flat)](https://www.versioneye.com/user/projects/5677ba2b107997003e0011c3)
[![Latest Stable Version](https://poser.pugx.org/openstore/schema-core/v/stable.svg)](https://packagist.org/packages/openstore/schema-core)
[![Total Downloads](https://poser.pugx.org/openstore/schema-core/downloads.png)](https://packagist.org/packages/openstore/schema-core)
[![License](https://poser.pugx.org/openstore/schema-core/license.png)](https://packagist.org/packages/openstore/schema-core)

openstore-schema-core provides the database schema used in openstore. 

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
- [x] Schema migrations made easy.
- [x] Provide triggers, procedures and functions ([extras](https://github.com/belgattitude/openstore-schema-core/blob/master/src/OpenstoreSchema/Core/Extra/MysqlExtra.php)).

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
$ 
$ cp ./config/openstore-schema-core.config.php.dist ./config/openstore-schema-core.config.php
# Edit database parameters
$ vi ./config/openstore-schema-core.config.php
```

### Database

First ensure your database server is supported and enable support for `utf8mb4` charset.

| Database      | Storage engine     | Fileformat  |
|---------------|--------------------|-------------|
| MySQL 5.6+    | INNODB engine      | Barracuda   |
| Mariadb 10+   | INNODB/XTRADB      | Barracuda   |

> To be able to work with `utf8mb4`check that the following 
> parameters are present in the mysql configuration file (`my.cnf`):
>   - [x] `innodb_file_per_table=1`
>   - [x] `innodb_file_format=barracuda`
>   - [x] `innodb_large_prefix=1`    
> *(Note that from MariaDB 10.2.2 and Mysql 5.7.7, `barracuda` has become the default file format.)* 

Then create a new database:

```shell
$ mysql -e "CREATE DATABASE openstore_test CHARACTER SET='utf8mb4' COLLATE='utf8mb4_unicode_ci';" -uroot -p
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

> WARNING: use the option `--dump-sql` to display the DDL instead of applying onto the database.
> This is particularly useful to show migration needed over a production database, for example:


```shell
$ ./bin/openstore-schema-core openstore:schema:update --dump-sql
```
  
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

Be sure to execute code style check before commit:

```shell
$ composer check
```

You can also fix the code style issues:

```shell
$ composer fix
```

Don't forget to regenerate regenerate the [sql doc](https://github.com/belgattitude/openstore-schema-core/tree/master/resources/sql):

```shell
$ composer build
```
	