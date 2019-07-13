<?php
include '../config/config.php';

try {
    $pdo = new PDO('mysql:host=' . HOST . ';dbname=' . NAME, USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

$cond = array(
    'name' => 'hridoy', 'description' => 'Good boy', 'price' => 23.00, 'category_id' => 2
);

$columns = implode(',', array_keys($cond));
$values = ':' . implode(', :', array_keys($cond));

$query = "INSERT INTO products({$columns}) VALUES({$values})";

if ($stmt = $pdo->prepare($query)) {
    foreach ($cond as $key => $value) {
        $stmt->bindParam(':' . $key, $value);
    }
    if ($stmt->execute()) {
        echo 'OK';
    }
}


var_dump($query);
