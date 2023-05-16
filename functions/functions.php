<?php
require_once("db_connection.php");

function query($query)
{
  global $connection;
  $result = mysqli_query($connection, $query);

  return $result;
}

function filter($input)
{
  return trim(stripslashes(htmlspecialchars($input)));
}

function add_student($method)
{
  $name = filter($method["name"]);
  $gender = filter($method["gender"]);
  $address = filter($method["address"]);

  query("INSERT INTO students SET nama = '$name', jenis_kelamin = '$gender', alamat = '$address'");
}

function search_student($keyword)
{
  if (trim(strtolower($keyword)) === "all") {
    return query("SELECT * FROM students");
  } else {
    $query = "SELECT * FROM students WHERE id LIKE '%$keyword%' OR nama LIKE '%$keyword%' OR jenis_kelamin LIKE '%$keyword%' OR alamat LIKE '%$keyword%'";

    return query($query);
  }
}

function edit_student($method)
{
  $id = $method["id"];
  $name = filter($method["name"]);
  $gender = filter($method["gender"]);
  $address = filter($method["address"]);

  query("UPDATE students SET nama = '$name', jenis_kelamin = '$gender', alamat = '$address' WHERE id = $id");
}

function delete_student($id)
{
  query("DELETE FROM students WHERE id = $id");
}
