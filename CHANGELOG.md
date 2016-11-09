# CHANGELOG

## 0.25.0 (2016-11-09)

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

  