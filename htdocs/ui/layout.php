<?php
switch ($inc) {
    case "main":
        include_once("$inc.php");
        break;
    default:
        include_once("header.php");
        include_once("$inc.php");
        includ_once("footer.php");
}