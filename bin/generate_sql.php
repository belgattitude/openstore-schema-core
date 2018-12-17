#!/usr/bin/env php
<?php
/**
 * Utility script to generate raw sql in directory ./resources/sql.
 * Only in dev mode !!!
 *
 * @author Vanvelthem Sébastien
 */
$working_directory = dirname(__DIR__);
$doc_directory = "$working_directory/resources/sql";
chdir($working_directory);

require $working_directory . '/vendor/autoload.php';

/*
####################################
Step 1: ddl generation
####################################
*/

$ddl_cmd = './bin/openstore-schema-core openstore:schema:create --dump-sql --no-extras';

$ddl_output = [];
exec($ddl_cmd, $ddl_output, $return_var);
if ($return_var !== 0) {
    echo 'Cannot generate ddl:' . implode(PHP_EOL, $ddl_output);
    exit(1);
}

$ddl = array_reduce($ddl_output, function ($carry, $value) {
    if ($carry !== '') {
        $header = implode("\n", [
            '-- ',
            '-- schema object',
            '-- '
        ]);
    } else {
        $header = '';
    }

    return sprintf("%s$header\n %s\n", $carry, SqlFormatter::format($value, false));
}, '');

file_put_contents("$doc_directory/create_schema_utf8mb4.sql", $ddl);

$ddl_utf8mb4 = preg_replace('/utf8mb4_unicode_ci/i', 'utf8_unicode_ci', $ddl) ?: '';

/** @see why http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci/766996#766996 */
$ddl_utf8mb4 = preg_replace('/utf8mb4/i', 'utf8', $ddl_utf8mb4) ?: '';
file_put_contents("$doc_directory/mysql-utf8-compat/create_schema_utf8_compat.sql", $ddl_utf8mb4);

/*
#######################################
Step 2: extra triggers, ... generation
#######################################
*/

$extra_cmd = './bin/openstore-schema-core openstore:schema:recreate-extra --dump-sql';

exec($extra_cmd, $extra_output, $return_var);
if ($return_var !== 0) {
    echo 'Cannot generate extras:' . implode(PHP_EOL, $extra_output);
    exit(1);
}

$extra_ddl = implode("\n", $extra_output);

file_put_contents("$doc_directory/create_schema_extra_utf8mb4.sql", $extra_ddl);

$extra_ddl_utf8mb4 = preg_replace('/utf8mb4_unicode_ci/i', 'utf8_unicode_ci', $extra_ddl) ?: '';
$extra_ddl_utf8mb4 = preg_replace('/utf8mb4/i', 'utf8', $extra_ddl_utf8mb4) ?: '';

file_put_contents("$doc_directory/mysql-utf8-compat/create_schema_extra_utf8_compat.sql", $extra_ddl_utf8mb4);

echo "Successfully created sql in $doc_directory" . PHP_EOL;
exit(0);
