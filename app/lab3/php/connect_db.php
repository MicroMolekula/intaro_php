<?php
// Подключение к БД
try {
    $pdo = new PDO("pgsql:host=db;port=5432;dbname=test3_db", "postgres", "postgres");
    return $pdo;
} catch (PDOException $e) {
    echo "Error connect db";
}