<?php
header('Content-type: text/html; charset=UTF-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

function dsn()
{
    $dsn = "mysql:host=localhost;dbname=devshop";
    $dbh = new PDO($dsn, 'root', 'mysql');
    $dbh->query('set names utf8;');
    return $dbh;
}
