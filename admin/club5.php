<?php
header('Location: club.php?action=delete&id=' . (int) ($_GET['id'] ?? 0));
exit;
