<?php
function DB() {
	$host = '127.0.0.1';
	$db   = 'somentus';
	$user = 'root';
	$pass = '';
	$charset = 'utf8';
	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	$opt = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false,
	];
	$pdo = new PDO($dsn, $user, $pass, $opt);
	return $pdo;
}
function query($pdo, $query, $params = array()) {
	$statement = $pdo->prepare($query);
	$statement->execute($params);
	$data = $statement->fetchAll();
	return $data;
}
?>
