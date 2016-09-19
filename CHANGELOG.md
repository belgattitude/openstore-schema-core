# CHANGELOG

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

  