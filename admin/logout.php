<?php
session_start();
session_destroy();
header("Location: acerca-de.php");
exit;
?>
