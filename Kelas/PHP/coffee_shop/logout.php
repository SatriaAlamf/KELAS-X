<?php
session_start();
session_destroy();
header('Location: index.php');
exit();
?><script src="assets/js/script.js"></script>