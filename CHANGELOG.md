# CHANGELOG

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) 
and this project adheres to [Semantic Versioning](http://semver.org/).

## 0.51.4 (2018-08-13)

### Added 

- New table `MediaVideoFile` for transcoded videos versions.

## 0.51.3 (2018-07-30)

### Added 

- `ProductTranslation` new field: `additional_description` (Additional description for products)

### Updated

- Deps requirements updated: dbal 2.8, orm 2.6

## 0.51.2 (2018-06-18)

### Added

- Added travis tests for mariadb 10.3+

### Fixed 

- [MySQLExtra] Fix creation of function `get_searchable_reference` and add `DETERMINISTIC` to avoid possible problem if binlog is enabled. 

## 0.51.1 (2018-05-29)

### Added 

- `ProductTranslation` new field: `usp` (Unique selling proposition)

### Changed

- `ProductTranslation` field `specs` now `varchar(5000)` instead of `text`

### Fixed 

- Minor typehint fixes for `ProductTranslation` entity.

### Example of migration:

```sql
ALTER TABLE product_translation ADD usp VARCHAR(200) DEFAULT NULL COMMENT 'Unique Selling Proposition', CHANGE description description VARCHAR(5000) DEFAULT NULL COMMENT 'Product description', CHANGE specs specs VARCHAR(5000) DEFAULT NULL COMMENT 'Product specifications';
```

## 0.51.0 (2018-05-05)

### Changed

- Removed magic getter/setters in entities (possible BC-break)

## 0.50.0 (2018-04-18)

### Changed

- Updated to doctrine/dbal 2.7 for mariadb 10.2 support.

### Fixed

- Some phpdoc type-hints

## 0.40.0 (2017-05-18)

### Changed

- [BC-BREAK] updated to `utf8mb4` by default. 
  **In order to migrate, you must backup database, recreate the schema and restore the data, for development you can use:**

  ```shell
  # 1. Backup existing database
  # 1.1 Make backup of the data (sql: inserts)
  $ mysqldump -u {USER} -p --no-create-info --skip-triggers --complete-insert --disable-keys --default-character-set=utf8mb4 --lock-tables {DATABASE} > /{PATH}/{DATABASE}.data.sql
  # 1.2 Make backup of the schema (ddl: create tables, routines...)
  $ mysqldump -u {USER} -p --no-data --triggers --events --routines --default-character-set=utf8mb4 {DATABASE} > /{PATH}/{DATABASE}.schema.sql
  # 2. Create a new database and create the latest schema
  $ ./bin/openstore-schema-core openstore:schema:create --dump-sql > /{PATH}/openstore.schema.sql    
  $ mysql -e "create database {NEW_DATABASE} CHARSET='utf8mb4' COLLATE='utf8mb4_unicode_ci'" -u{USER} -p  
  $ mysql -u {USER} -p {NEW_DATABASE} < /{PATH}/openstore.schema.sql
  # 3. Import data backup in newly created database
  $ mysql -u {USER} -p {NEW_DATABASE} < /{PATH}/{BACKUP_FILE}.data.sql  
  ```
    
- Moved `doc/sql` to `resources/sql`.
- Split generated sql doc into `ddl` and extras `triggers, procedures, functions...` 

### Added

- New console `inputOption` to generate schema without extras (triggers,...)
  see `./bin/openstore-schema-core openstore:schema:create --dump-sql --no-extras`.
- Preliminary tests with phpstan    

### Fixed 

- Removed indexes made on text columns (varchar > 255 chars).
- A lot of cs-issues

### Removed

- Removed `getArrayCopy()` from all entities.


## 0.30.3 (2017-01-10)

### Added

- Added `ProductDepartment` and `ProductTarget` entities

```sql
CREATE TABLE product_target (target_id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL, reference VARCHAR(60) NOT NULL COMMENT 'Reference', title VARCHAR(80) DEFAULT NULL, description VARCHAR(15000) DEFAULT NULL, flag_exclude_enduser TINYINT(1) DEFAULT '0' NOT NULL COMMENT 'Visibility should be excluded for enduser target audience', icon_class VARCHAR(40) DEFAULT NULL, sort_index INT UNSIGNED DEFAULT NULL COMMENT 'Relative sort index', created_at DATETIME DEFAULT NULL COMMENT 'Record creation timestamp', updated_at DATETIME DEFAULT NULL COMMENT 'Record last update timestamp', created_by VARCHAR(40) DEFAULT NULL COMMENT 'Creator name', updated_by VARCHAR(40) DEFAULT NULL COMMENT 'Last updater name', legacy_mapping VARCHAR(40) DEFAULT NULL COMMENT 'Unique reference of this record taken from legacy system', legacy_synchro_at DATETIME DEFAULT NULL COMMENT 'Last synchro timestamp', INDEX sort_index_idx (sort_index), INDEX description_idx (description), UNIQUE INDEX unique_reference_idx (reference), UNIQUE INDEX unique_legacy_mapping_idx (legacy_mapping), UNIQUE INDEX unique_title_idx (title), PRIMARY KEY(target_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = 'Product target audience table' ;
CREATE TABLE product_department (department_id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL, reference VARCHAR(60) NOT NULL COMMENT 'Reference', title VARCHAR(80) DEFAULT NULL, description VARCHAR(15000) DEFAULT NULL, icon_class VARCHAR(40) DEFAULT NULL, sort_index INT UNSIGNED DEFAULT NULL COMMENT 'Relative sort index', created_at DATETIME DEFAULT NULL COMMENT 'Record creation timestamp', updated_at DATETIME DEFAULT NULL COMMENT 'Record last update timestamp', created_by VARCHAR(40) DEFAULT NULL COMMENT 'Creator name', updated_by VARCHAR(40) DEFAULT NULL COMMENT 'Last updater name', legacy_mapping VARCHAR(40) DEFAULT NULL COMMENT 'Unique reference of this record taken from legacy system', legacy_synchro_at DATETIME DEFAULT NULL COMMENT 'Last synchro timestamp', INDEX sort_index_idx (sort_index), INDEX description_idx (description), UNIQUE INDEX unique_reference_idx (reference), UNIQUE INDEX unique_legacy_mapping_idx (legacy_mapping), UNIQUE INDEX unique_title_idx (title), PRIMARY KEY(department_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = 'Product departments' ;
ALTER TABLE product ADD department_id SMALLINT UNSIGNED DEFAULT NULL, ADD target_id SMALLINT UNSIGNED DEFAULT NULL;
ALTER TABLE product ADD CONSTRAINT FK_D34A04ADAE80F5DF FOREIGN KEY (department_id) REFERENCES product_department (department_id) ON DELETE CASCADE;
ALTER TABLE product ADD CONSTRAINT FK_D34A04AD158E0B66 FOREIGN KEY (target_id) REFERENCES product_target (target_id) ON DELETE CASCADE;
CREATE INDEX IDX_D34A04ADAE80F5DF ON product (department_id);
CREATE INDEX IDX_D34A04AD158E0B66 ON product (target_id);
```

## 0.30.2 (2016-12-07)

### Added

- Added `ProductBrand::logo_url` and `ProductBrand:flag_public`

```sql
ALTER TABLE product_brand ADD logo_url VARCHAR(255) DEFAULT NULL COMMENT 'Url to logo', ADD flag_public TINYINT(1) DEFAULT '1' NOT NULL COMMENT 'Whether the brand is active in public website', CHANGE url url VARCHAR(80) DEFAULT NULL COMMENT 'Brand homepage', CHANGE flag_active flag_active TINYINT(1) DEFAULT '1' NOT NULL COMMENT 'Whether the brand is currently active';
```

## 0.30.1 (2016-12-07)

### Added

- Added `ProductBrand::sort_index`

```sql
ALTER TABLE product_brand ADD sort_index INT UNSIGNED DEFAULT NULL COMMENT 'Relative sort index';
CREATE INDEX sort_index_idx ON product_brand (sort_index);
```

## 0.30.0 (2016-12-05)

### Added

- [BC-Break] Breaking change
  
  Removal of `zf-commons/zfc-rbac` and `zf-commons/zfc-user` dependencies.
  
  User, Roles and Permissions entities are not implementing the user and rbac interfaces.
  If you rely on them, just extend the entity classes. 
             

## 0.26.0 (2016-11-22)

### Added

- Added a new procedure `CALL rebuild_category_keywords()` to rebuild product translation keywords 

Update your database with

```console
$ ./bin/openstore-schema-core openstore:schema:recreate-extra
```

## 0.25.0 (2016-11-09)

### Added 

- Added `keywords` in `ProductCategoryTranslation` that can be used with fulltext search
- Added `rank_pricelist_id` in `Pricelist` useful when you want to use `ProductRank` on another
  pricelist than current.
  
```sql
ALTER TABLE product_category_translation ADD keywords VARCHAR(255) DEFAULT NULL;
CREATE FULLTEXT INDEX keywords_ft_idx ON product_category_translation (keywords);

ALTER TABLE pricelist ADD rank_pricelist_id SMALLINT UNSIGNED DEFAULT NULL;
ALTER TABLE pricelist ADD CONSTRAINT FK_5CCFEA6D5ECD273E FOREIGN KEY (rank_pricelist_id) REFERENCES pricelist (pricelist_id) ON DELETE CASCADE;
CREATE INDEX IDX_5CCFEA6D5ECD273E ON pricelist (rank_pricelist_id);
```

## 0.24.0 (2016-11-02)

### Changed

- For `Pricelist`, added condition for marking products as 'new': `cond_product_new_max_days`
  And REMOVAL of `new_product_min_date`

```sql
ALTER TABLE pricelist ADD cond_product_new_max_days SMALLINT UNSIGNED DEFAULT NULL COMMENT 'Flag products as new if more recent than the number of days';
ALTER TABLE pricelist DROP new_product_min_date;
```

## 0.23.0 (2016-09-21)

- For 'Media', refactored media_remote_id, media_remote_url and preview_url in
  remote_media_id, remote_media_url and remote_preview_url to preserve
  consistencies
  
```sql
DROP INDEX unique_remote_media_id_idx ON media;
ALTER TABLE media ADD remote_preview_url VARCHAR(255) DEFAULT NULL COMMENT 'Remote media image preview url', DROP preview_url, CHANGE media_remote_url remote_media_url VARCHAR(385) DEFAULT NULL COMMENT 'Only for remote content (with a null container)', CHANGE media_remote_id remote_media_id VARCHAR(64) DEFAULT NULL COMMENT 'External media id, only for remote content (with a null container)';
CREATE UNIQUE INDEX unique_remote_media_id_idx ON media (type_id, remote_media_id);  
```  

- For 'ProductSerieMedia', refactored type_id in product_media_type_id.

```sql
ALTER TABLE product_serie_media DROP FOREIGN KEY FK_E0F0B87C54C8C93;
DROP INDEX IDX_E0F0B87C54C8C93 ON product_serie_media;
DROP INDEX unique_product_media_type_idx ON product_serie_media;
DROP INDEX unique_product_type_flag_primary_idx ON product_serie_media;
ALTER TABLE product_serie_media CHANGE type_id product_media_type_id INT UNSIGNED NOT NULL;
ALTER TABLE product_serie_media ADD CONSTRAINT FK_E0F0B877E761628 FOREIGN KEY (product_media_type_id) REFERENCES product_media_type (type_id) ON DELETE CASCADE;
CREATE INDEX IDX_E0F0B877E761628 ON product_serie_media (product_media_type_id);
CREATE UNIQUE INDEX unique_product_media_type_idx ON product_serie_media (serie_id, media_id, product_media_type_id);
CREATE UNIQUE INDEX unique_product_type_flag_primary_idx ON product_serie_media (product_media_type_id, serie_id, flag_primary);
```

## 0.22.0 (2016-09-19)

- Added unique constraint on container and location for media table

```sql
CREATE UNIQUE INDEX unique_container_location_idx ON media (container_id, location);
```

## 0.21.0 (2016-09-19)

- Added product_serie_media table

```sql
CREATE TABLE product_serie_media (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, serie_id INT UNSIGNED NOT NULL, media_id BIGINT UNSIGNED NOT NULL, type_id INT UNSIGNED NOT NULL, flag_primary TINYINT(1) DEFAULT NULL, sort_index INT UNSIGNED DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT 'Record creation timestamp', updated_at DATETIME DEFAULT NULL COMMENT 'Record last update timestamp', created_by VARCHAR(40) DEFAULT NULL COMMENT 'Creator name', updated_by VARCHAR(40) DEFAULT NULL COMMENT 'Last updater name', legacy_mapping VARCHAR(40) DEFAULT NULL COMMENT 'Unique reference of this record taken from legacy system', legacy_synchro_at DATETIME DEFAULT NULL COMMENT 'Last synchro timestamp', INDEX IDX_E0F0B87D94388BD (serie_id), INDEX IDX_E0F0B87EA9FDD75 (media_id), INDEX IDX_E0F0B87C54C8C93 (type_id), INDEX sort_index_idx (sort_index), UNIQUE INDEX unique_product_media_type_idx (serie_id, media_id, type_id), UNIQUE INDEX unique_product_type_flag_primary_idx (type_id, serie_id, flag_primary), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = 'Product serie media table' ;
ALTER TABLE product_serie_media ADD CONSTRAINT FK_E0F0B87D94388BD FOREIGN KEY (serie_id) REFERENCES product_serie (serie_id) ON DELETE CASCADE;
ALTER TABLE product_serie_media ADD CONSTRAINT FK_E0F0B87EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (media_id) ON DELETE CASCADE;
ALTER TABLE product_serie_media ADD CONSTRAINT FK_E0F0B87C54C8C93 FOREIGN KEY (type_id) REFERENCES product_media_type (type_id) ON DELETE CASCADE;
```

## 0.20.0 (2016-09-15)

- Added unique constraint on media type and remote_id

```sql
CREATE UNIQUE INDEX unique_remote_media_id_idx ON media (type_id, media_remote_id);
```

- Added preview picture url

```sql
ALTER TABLE media ADD preview_url VARCHAR(255) DEFAULT NULL COMMENT 'Image preview url';
```

## 0.19.0 (2016-09-15) MediaType added, possibility to null container in media (remote)  

- Added `MediaType` table in relation to `Media`
- Removed constraint of `container_id` in `Media`
- Added columns `media_remote_url` and `media_remote_id` in `Media`

## 0.18.0 (2016-06-29) Added column 

- Added `weight_gross` in product table 

```sql
ALTER TABLE product ADD weight_gross NUMERIC(12, 6) DEFAULT NULL COMMENT 'Gross weight per sales unit in Kg', CHANGE weight weight NUMERIC(12, 6) DEFAULT NULL COMMENT 'Net weight per sales unit in Kg';
```

## 0.17.0 (2016-05-15) Added is_deal, is_fresh

- Added columns into in ProductPricelist is_deal, is_fresh


## 0.14.0 (2016-01-28) Added maximum discount 1

- Added columns into in ProductPricelist 


## 0.13.0 (2016-01-15) Added minimum price

- Added sales minimum price in ProductPricelist 
- Receipts for compressing tables with INNODB file_format barracuda in README


## 0.12.0 (2016-01-14) Fulltext innodb

- Drop support for mysql < 5.6 or mariadb < 10
- ProductSearch is now InnoDb by default


## 0.11.0 (2016-01-14) Table additions

- Added ProductSerie and ProductSerieTranslation tables

  
