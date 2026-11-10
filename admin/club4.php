<?php
header('Location: club.php?action=edit&id=' . (int) ($_GET['id'] ?? 0));
exit;
