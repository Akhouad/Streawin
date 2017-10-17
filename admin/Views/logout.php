<?php
$_SESSION["auth"] = null;
header("Location: " . getLink("login",[], true));
?>