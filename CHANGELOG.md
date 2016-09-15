# CHANGELOG

## 0.20.0 (2016_09_15)

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

  