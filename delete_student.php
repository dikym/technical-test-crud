<?php
require "functions/functions.php";

$id = $_GET["id"];

$query = query("SELECT id FROM students WHERE id = $id");

delete_student($id);
header("location: index.php?message=delete_student_success");
