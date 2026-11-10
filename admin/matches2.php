<?php
header('Location: matches.php?action=edit&id=' . (int) ($_GET['id'] ?? 0));
exit;
