<?php
header('Location: club.php?action=view&id=' . (int) ($_GET['id'] ?? 0));
exit;
