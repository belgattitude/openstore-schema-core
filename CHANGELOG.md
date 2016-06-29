# CHANGELOG

## 0.18.0 Added column 

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

  