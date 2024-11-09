<?php
$connection = new mysqli('localhost', 'root', '', 'wedego');
$id = $_GET['id'];
$connection->query("DELETE FROM sorties WHERE id = $id");
header('Location: dashboard.php');
