<?php

//if db was export no need to run this script.

$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Create book_store database
$sqlCreateSchema = "CREATE DATABASE IF NOT EXISTS Courses_DB;";

try {
    $dbResult = $conn->query($sqlCreateSchema);
    if (!$dbResult) {
        throw new Exception("Creating Courses_DB Has Failed");
    }
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}
// Create books Table
$sqlCreateCoursesTable = "CREATE TABLE `Courses_DB`.`courses` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `description` VARCHAR(45) NULL,
  `image` VARCHAR(45) NULL,
  `phone` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));";

$sqlCreateStudentsTable = "CREATE TABLE `Courses_DB`.`students` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `phone` INT(45) NULL,
  `email` VARCHAR(45) NULL,
  `image` VARCHAR(45) NULL,
   PRIMARY KEY (`id`));";

$sqlCreateConnectingTable = "CREATE TABLE `Courses_DB`.`overview` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `course_id` INT(10) NULL,
  `student_id` INT(10) NULL,
   PRIMARY KEY (`id`));";

$sqlCreateAdministrationTable = "CREATE TABLE `Courses_DB`.`Administrators` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(30) NULL,
  `role` VARCHAR(30) NULL,
  `phone` VARCHAR(30) NULL,
  `email` VARCHAR(45) NULL,
  `password` VARCHAR(45) NULL,
  `image` VARCHAR(45) NULL,
   PRIMARY KEY (`id`));";

try {
    $results1 = $conn->query($sqlCreateCoursesTable);
    $results2 = $conn->query($sqlCreateStudentsTable);
    $results3 = $conn->query($sqlCreateConnectingTable);
    $results4 = $conn->query($sqlCreateAdministrationTable);
    if ((!$results1) || (!$results2) || (!$results3) || (!$results4)) {
        throw new Exception("Creating tables Has Failed");
    }
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}

$conn->close();
