<?php
switch ($inc) {
    case "home":
        include_once("$inc.php");
        break;
    default:
        include_once("header.php");
        include_once("$inc.php");
        include_once("footer.php");
}