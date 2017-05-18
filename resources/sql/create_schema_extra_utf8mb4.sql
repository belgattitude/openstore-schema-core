DELIMITER //
DROP FUNCTION IF EXISTS `slugify` //
DELIMITER ;
DELIMITER //
        CREATE FUNCTION `slugify` (dirty_string VARCHAR(255))
        RETURNS VARCHAR(255) CHARSET latin1
        DETERMINISTIC
        BEGIN
            DECLARE x, y , z INT;
            DECLARE temp_string, new_string VARCHAR(255);
            DECLARE is_allowed BOOL;
            DECLARE c, check_char VARCHAR(1);

            SET temp_string = LOWER(dirty_string);

            SET temp_string = REPLACE(temp_string, '&', ' and ');

            SELECT temp_string REGEXP('[^a-z0-9\-]+') INTO x;
            IF x = 1 THEN
                SET z = 1;
                WHILE z <= CHAR_LENGTH(temp_string) DO
                    SET c = SUBSTRING(temp_string, z, 1);
                    SET is_allowed = FALSE;
                    IF !((ascii(c) = 45) or (ascii(c) >= 48 and ascii(c) <= 57) or (ascii(c) >= 97 and ascii(c) <= 122)) THEN
                        SET temp_string = REPLACE(temp_string, c, '-');
                    END IF;
                    SET z = z + 1;
                END WHILE;
            END IF;

            SELECT temp_string REGEXP("^-|-$|'") INTO x;
            IF x = 1 THEN
                SET temp_string = REPLACE(temp_string, "'", '');
                SET z = CHAR_LENGTH(temp_string);
                SET y = CHAR_LENGTH(temp_string);
                Dash_check: WHILE z > 1 DO
                    IF STRCMP(SUBSTRING(temp_string, -1, 1), '-') = 0 THEN
                        SET temp_string = SUBSTRING(temp_string,1, y-1);
                        SET y = y - 1;
                    ELSE
                        LEAVE Dash_check;
                    END IF;
                    SET z = z - 1;
                END WHILE;
            END IF;

            REPEAT
                SELECT temp_string REGEXP("--") INTO x;
                IF x = 1 THEN
                    SET temp_string = REPLACE(temp_string, "--", "-");
                END IF;
            UNTIL x <> 1 END REPEAT;

            IF LOCATE('-', temp_string) = 1 THEN
                SET temp_string = SUBSTRING(temp_string, 2);
            END IF;

            RETURN temp_string;
        END         //
DELIMITER ;
DELIMITER //
DROP FUNCTION IF EXISTS `strip_tags` //
DELIMITER ;
DELIMITER //
        CREATE FUNCTION strip_tags( DIRTY VARCHAR(3000) )
        RETURNS VARCHAR(3000) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci
        DETERMINISTIC
        BEGIN
          DECLARE iStart, iEnd, iLength int;
            WHILE LOCATE( '<', DIRTY ) > 0 And LOCATE( '>', DIRTY, LOCATE( '<', DIRTY )) > 0 DO
              BEGIN
                SET iStart = LOCATE( '<', DIRTY ), iEnd = LOCATE( '>', DIRTY, LOCATE('<', DIRTY ));
                SET iLength = ( iEnd - iStart) + 1;
                IF iLength > 0 THEN
                  BEGIN
                    SET DIRTY = INSERT( DIRTY, iStart, iLength, '');
                  END;
                END IF;
              END;
            END WHILE;
            RETURN DIRTY;
        END//
DELIMITER ;
DELIMITER //
DROP FUNCTION IF EXISTS `delete_double_spaces` //
DELIMITER ;
DELIMITER //
        CREATE FUNCTION delete_double_spaces ( title VARCHAR(3000) )
        RETURNS VARCHAR(3000) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci DETERMINISTIC
        BEGIN
            DECLARE result VARCHAR(3000);
            SET result = REPLACE( title, '  ', ' ' );
            WHILE (result <> title) DO
                SET title = result;
                SET result = REPLACE( title, '  ', ' ' );
            END WHILE;
            RETURN result;
        END//
DELIMITER ;
DELIMITER //
DROP FUNCTION IF EXISTS `get_searchable_reference` //
DELIMITER ;
DELIMITER //
        CREATE FUNCTION `get_searchable_reference` (`in_str` VARCHAR(2048)) RETURNS VARCHAR(2048) CHARSET utf8mb4
        BEGIN
            /*
              This function escape a string from any non alphanumeric chars (A_Z0_9)
              to get a searchable reference. Also try to remove any first
              non-significative zero.

              FOR example 'BA-0114-22' -> 'BA11422'

            */
            DECLARE out_str VARCHAR(2048) DEFAULT '';
            DECLARE c VARCHAR(1) DEFAULT '';
            DECLARE prev_c VARCHAR(1) DEFAULT '';
            DECLARE pointer INT DEFAULT 1;

            IF ISNULL(in_str) THEN
                RETURN NULL;
            ELSE
                WHILE pointer <= LENGTH(in_str) DO
                    SET c = UPPER(MID(in_str, pointer, 1));

                    -- TAKE ONLY [A-Z0-9] characters
                    IF  ((ASCII(c) > 64 AND ASCII(c) < 92) or (ASCII(c) > 47 AND ASCII(c) < 58))
                    THEN
                        -- IF A NUMBER, try to get rid of non-significave numbers
                        IF (ASCII(c) > 47 AND ASCII(c) < 58)
                        THEN
                            -- IF C is a zero and PREVIOUS CHARACTER IS NUMERIC
                            IF (c = 0 and NOT (ASCII(prev_c) > 47 AND ASCII(prev_c) < 58))
                            THEN
                                -- NOTHING
                                SET c = c;
                            ELSE
                                SET out_str = CONCAT(out_str, c);
                            END IF;
                        ELSE
                            SET out_str = CONCAT(out_str, c);
                        END IF;
                    END IF;
                    SET prev_c = c;
                    SET pointer = pointer + 1;
                END WHILE;
            END IF;

            RETURN UPPER(out_str);
        END//
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS `rebuild_catalog_search` //
DELIMITER ;
DELIMITER //
        CREATE PROCEDURE `rebuild_catalog_search` ()
        BEGIN
                SET @updated_at = NOW();
                SET @default_lang := (SELECT lang FROM `language` where flag_default = 1);
                IF (@default_lang is null) THEN
                     SET @default_lang = 'en';
                END IF;
                INSERT INTO product_search (product_id, lang, keywords, updated_at)
                SELECT DISTINCT
                    p.product_id,
                    IF (p18.lang is null, @default_lang, p18.lang) as lang,
                    UPPER(
                        delete_double_spaces(
                            REPLACE(
                                strip_tags(
                                        TRIM(
                                                CONCAT_WS(' ',
                                                        COALESCE(p.reference, ''),
                                                        COALESCE(pb.title, ''),
                                                        COALESCE(p18.title, p.title, ''),
                                                        COALESCE(p18.invoice_title, p.invoice_title, ''),
                                                        IF(p2.product_id is not null,
                                                            COALESCE(p18_2.description, p2.description, ''),
                                                            COALESCE(p18.description, p.description, '')
                                                        ),
                                                        COALESCE(p18.characteristic, p.characteristic, ''),
                                                        COALESCE(p18.keywords, p.keywords, ''),
                                                        COALESCE(pc18.breadcrumb, pc.breadcrumb, ''),
                                                        COALESCE(pg18.title, pg.title, '')
                                                )
                                        )
                                )
                            , '
', ' ')
                        )
                    )
                    as keywords,
                    @updated_at as updated_at
                from
                    product p
                        left outer join
                    product_translation p18 ON p18.product_id = p.product_id
                        left outer join
                    product_brand pb ON p.brand_id = pb.brand_id
                        left outer join
                    product p2 ON p2.product_id = p.parent_id
                        left outer join
                    product_translation p18_2 ON p18_2.product_id = p2.product_id
                        and p18_2.lang = p18.lang
                        left outer join
                    product_group pg ON p.group_id = pg.group_id
                        left outer join
                    product_group_translation pg18 ON pg18.group_id = pg.group_id
                        and pg18.lang = p18.lang
                        left outer join
                    product_category pc on pc.category_id = p.category_id
                        left outer join
                    product_category_translation pc18 on pc18.category_id = p.category_id
                        and pc18.lang = p18.lang
                        left outer join
                    product_pricelist ppl on (p.product_id = ppl.product_id and ppl.flag_active=1)
                            left outer join
                    pricelist pl on (pl.pricelist_id = ppl.pricelist_id and pl.flag_active=1)
                where
                    1=1
                    and p.flag_active = 1
                    and pl.flag_active = 1
                order by IF (p18.lang is null, @default_lang, p18.lang), p.product_id
            on duplicate key update
                    keywords = UPPER(
                        delete_double_spaces(
                            REPLACE(
                                strip_tags(
                                        TRIM(
                                                CONCAT_WS(' ',
                                                        COALESCE(p.reference, ''),
                                                        COALESCE(pb.title, ''),
                                                        COALESCE(p18.title, p.title, ''),
                                                        COALESCE(p18.invoice_title, p.invoice_title, ''),
                                                        IF(p2.product_id is not null,
                                                            COALESCE(p18_2.description, p2.description, ''),
                                                            COALESCE(p18.description, p.description, '')
                                                        ),
                                                        COALESCE(p18.characteristic, p.characteristic, ''),
                                                        COALESCE(p18.keywords, p.keywords, ''),
                                                        COALESCE(pc18.breadcrumb, pc.breadcrumb, ''),
                                                        COALESCE(pg18.title, pg.title, '')
                                                )
                                        )
                                )
                            , '
', ' ')
                        )
                    )
                    ,
                    updated_at = @updated_at;

                -- REMOVE OLDER DATA
                DELETE FROM product_search where updated_at < @updated_at and updated_at is not null;
        END //
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS `rebuild_product_search` //
DELIMITER ;
DELIMITER //
        CREATE PROCEDURE `rebuild_product_search` (IN product_id BIGINT)
        BEGIN
                SET @updated_at = NOW();
                SET @product_id = product_id;
                SET @default_lang := (SELECT lang FROM `language` where flag_default = 1);
                IF (@default_lang is null) THEN
                     SET @default_lang = 'en';
                END IF;
                PREPARE stmt FROM
                "INSERT INTO product_search (product_id, lang, keywords, updated_at)
                SELECT DISTINCT
                    p.product_id,
                    IF (p18.lang is null, @default_lang, p18.lang) as lang,
                    UPPER(
                        delete_double_spaces(
                            REPLACE(
                                strip_tags(
                                        TRIM(
                                                CONCAT_WS(' ',
                                                        COALESCE(p.reference, ''),
                                                        COALESCE(pb.title, ''),
                                                        COALESCE(p18.title, p.title, ''),
                                                        COALESCE(p18.invoice_title, p.invoice_title, ''),
                                                        IF(p2.product_id is not null,
                                                            COALESCE(p18_2.description, p2.description, ''),
                                                            COALESCE(p18.description, p.description, '')
                                                        ),
                                                        COALESCE(p18.characteristic, p.characteristic, ''),
                                                        COALESCE(p18.keywords, p.keywords, ''),
                                                        COALESCE(pc18.breadcrumb, pc.breadcrumb, ''),
                                                        COALESCE(pg18.title, pg.title, '')
                                                )
                                        )
                                )
                            , '
', ' ')
                        )
                    )
                    as keywords,
                    @updated_at as updated_at
                from
                    product p
                        left outer join
                    product_translation p18 ON p18.product_id = p.product_id
                        left outer join
                    product_brand pb ON p.brand_id = pb.brand_id
                        left outer join
                    product p2 ON p2.product_id = p.parent_id
                        left outer join
                    product_translation p18_2 ON p18_2.product_id = p2.product_id
                        and p18_2.lang = p18.lang
                        left outer join
                    product_group pg ON p.group_id = pg.group_id
                        left outer join
                    product_group_translation pg18 ON pg18.group_id = pg.group_id
                        and pg18.lang = p18.lang
                        left outer join
                    product_category pc on pc.category_id = p.category_id
                        left outer join
                    product_category_translation pc18 on pc18.category_id = p.category_id
                        and pc18.lang = p18.lang
                        left outer join
                    product_pricelist ppl on (p.product_id = ppl.product_id and ppl.flag_active=1)
                            left outer join
                    pricelist pl on (pl.pricelist_id = ppl.pricelist_id and pl.flag_active=1)
                where
                    1=1
                    and p.flag_active = 1
                    and pl.flag_active = 1
                    and p.product_id = ?
                order by IF (p18.lang is null, @default_lang, p18.lang), p.product_id
                on duplicate key update
                    keywords = UPPER(
                        delete_double_spaces(
                            REPLACE(
                                strip_tags(
                                        TRIM(
                                                CONCAT_WS(' ',
                                                        COALESCE(p.reference, ''),
                                                        COALESCE(pb.title, ''),
                                                        COALESCE(p18.title, p.title, ''),
                                                        COALESCE(p18.invoice_title, p.invoice_title, ''),
                                                        IF(p2.product_id is not null,
                                                            COALESCE(p18_2.description, p2.description, ''),
                                                            COALESCE(p18.description, p.description, '')
                                                        ),
                                                        COALESCE(p18.characteristic, p.characteristic, ''),
                                                        COALESCE(p18.keywords, p.keywords, ''),
                                                        COALESCE(pc18.breadcrumb, pc.breadcrumb, ''),
                                                        COALESCE(pg18.title, pg.title, '')
                                                )
                                        )
                                )
                            , '
', ' ')
                        )
                    )
                    ,
                    updated_at = @updated_at";
                EXECUTE stmt USING @product_id;
                DEALLOCATE PREPARE stmt;
        END //
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS `rebuild_category_breadcrumbs` //
DELIMITER ;
DELIMITER //
        CREATE PROCEDURE `rebuild_category_breadcrumbs` ()
        BEGIN
            -- 1. Category
            UPDATE product_category
                    INNER JOIN
                (
                            SELECT
                                    pc1.category_id,
                                            GROUP_CONCAT(
                                                    pc2.title
                                                    ORDER BY pc1.lvl , pc2.lvl
                                                    --     could be utf8 - &rarr; →
                                                    SEPARATOR ' | '
                                    ) AS `breadcrumb`
                            FROM
                                    `product_category` AS `pc1`
                            LEFT JOIN `product_category` AS `pc2` ON pc1.lft BETWEEN pc2.lft AND pc2.rgt
                            WHERE
                                    pc2.lvl > 0
                            GROUP BY 1
                            ORDER BY pc1.category_id
                    ) AS tmp
                    ON tmp.category_id = product_category.category_id
            SET product_category.breadcrumb = tmp.breadcrumb;

            -- 2. Category translations
            UPDATE product_category_translation
                    INNER JOIN
                (
                            SELECT
                                    pc1.category_id,
                                    pc18.lang,
                                            GROUP_CONCAT(
                                                    IF(pc18.title is null, pc2.title, pc18.title)
                                                    ORDER BY pc1.lvl , pc2.lvl
                                                    --     could be utf8 - &rarr; →
                                                    SEPARATOR ' | '
                                    ) AS `breadcrumb`
                            FROM
                                    `product_category` AS `pc1`
                            LEFT JOIN `product_category` AS `pc2` ON pc1.lft BETWEEN pc2.lft AND pc2.rgt
                            LEFT JOIN `product_category_translation` AS `pc18` ON pc18.category_id = pc2.category_id
                            WHERE
                                    pc2.lvl > 0
                            GROUP BY 1 , 2
                            ORDER BY pc1.category_id
                    ) AS tmp
                    ON tmp.category_id = product_category_translation.category_id
                    AND tmp.lang = product_category_translation.lang
            SET product_category_translation.breadcrumb = tmp.breadcrumb;
        END//
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS `rebuild_category_keywords` //
DELIMITER ;
DELIMITER //
        CREATE PROCEDURE `rebuild_category_keywords` ()
        BEGIN
            -- 2. Product category translation keywords

            UPDATE product_category_translation
                    INNER JOIN
                (
                            SELECT
                                    pc1.category_id,
                                    pc18.lang,
                                            GROUP_CONCAT(
                                                    IF(pc18.title is null, pc2.title, pc18.title)
                                                    ORDER BY pc1.lvl , pc2.lvl
                                                    SEPARATOR ' '
                                    ) AS `keywords`
                            FROM
                                    `product_category` AS `pc1`
                            LEFT JOIN `product_category` AS `pc2` ON pc1.lft BETWEEN pc2.lft AND pc2.rgt
                            LEFT JOIN `product_category_translation` AS `pc18` ON pc18.category_id = pc2.category_id
                            WHERE
                                    pc2.lvl > 0
                            GROUP BY 1 , 2
                            ORDER BY pc1.category_id
                    ) AS tmp
                    ON tmp.category_id = product_category_translation.category_id
                    AND tmp.lang = product_category_translation.lang
            SET product_category_translation.keywords = tmp.keywords;
        END//
DELIMITER ;
DELIMITER ;
