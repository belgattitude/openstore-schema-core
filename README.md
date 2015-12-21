# Openstore Schema Core

[![Dependency Status](https://www.versioneye.com/user/projects/5677ba2b107997003e0011c3/badge.svg?style=flat)](https://www.versioneye.com/user/projects/5677ba2b107997003e0011c3)

Openstore core database schema.

## Install

Via composer

```sh
$ composer require openstore/schema-core:dev-master
```
    
## Standalone setup

For standalone setup, you must ensure a local configuration exists with
correct database parameters.

```sh
$ mkdir config
$ cp ./vendor/openstore/schema-core/config/openstore-schema-core.config.php.dist ./config/openstore-schema-core.config.php
# Edit database parameters
$ vi ./config/openstore-schema-core.config.php
```

## List commands

```sh
$ ./vendor/bin/openstore-schema-core
```

## Get SQL to create database

```sh
$ vendor/bin/openstore-schema-core.php orm:schema-tool:create --dump-sql
```

	
	