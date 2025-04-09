<?php
session_start();
session_unset();
session_destroy();
header("Location: acerca-de.php");
exit;
?>
