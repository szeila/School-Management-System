<?php
// Transitional PHP 8 compatibility layer for the legacy application.
// TODO: Replace remaining mysql_* calls with parameterized mysqli queries.
if (!isset($GLOBALS['legacy_db']) || !($GLOBALS['legacy_db'] instanceof mysqli)) {
    $GLOBALS['legacy_db'] = new mysqli('localhost', 'root', '', 'online_enroll', 3306);
    $GLOBALS['legacy_db']->set_charset('utf8mb4');
}
$conn = $GLOBALS['legacy_db'];
$mysqli = $conn;
if (!function_exists('mysql_query')) {
    function mysql_query($sql) { return $GLOBALS['legacy_db']->query($sql); }
    function mysql_fetch_array($res) { return $res ? $res->fetch_array(MYSQLI_BOTH) : false; }
    function mysql_num_rows($res) { return $res ? $res->num_rows : 0; }
    function mysql_real_escape_string($value) { return $GLOBALS['legacy_db']->real_escape_string((string)$value); }
    function mysql_insert_id() { return $GLOBALS['legacy_db']->insert_id; }
}
