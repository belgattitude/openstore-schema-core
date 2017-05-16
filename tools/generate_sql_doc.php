#!/usr/bin/env php
<?php

$cmd = "./bin/openstore-schema-core openstore:schema:create --dump-sql";

$working_directory = realpath(__DIR__ . '/../');

chdir($working_directory);

exec($cmd, $output, $return_var);

$sql =  join("\n", $output);

file_put_contents("$working_directory/doc/sql/openstore_schema.sql", $sql);

$sql = preg_replace('/ utf8 /i', ' utf8mb4 ', $sql);        
$sql = preg_replace('/ utf8_unicode_ci /i', ' utf8mb4_unicode_ci ', $sql);        

file_put_contents("$working_directory/doc/sql/openstore_schema_utf8mb4.sql", $sql);

