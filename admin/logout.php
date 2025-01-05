<?php
session_start();
session_destroy();
header("Location: admin/index.html");
exit;
?>
