<?php
require "functions/functions.php";

$id = $_POST['id'];
$query = query("SELECT * FROM students WHERE id = $id");
$student = mysqli_fetch_assoc($query);

echo json_encode($student);
