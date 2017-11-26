<?php
session_start();
session_destroy();
header('Location:prompt.php?x=5');
?>