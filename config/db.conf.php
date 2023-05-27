<?php

$database["hostname"] = "";
$database["database"] = "";
$database["username"] = "";
$database["password"] = "";

$mysqli = new mysqli($database["hostname"], $database["username"], $database["password"], $database["database"]);

?>