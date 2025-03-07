<?php # index.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$page_title = 'Home';
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $page_title; ?> - Import</title>
</head>

<body>
	<h1>Import</h1>
	<p>From CSV to SQLite.</p>
	<p>Click <a href='import.php' title='Import'>here</a> to import your file.</p>
</body>

</html>
