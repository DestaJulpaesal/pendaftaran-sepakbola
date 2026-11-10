<?php
header('Location: matches.php?action=view&id=' . (int) ($_GET['id'] ?? 0));
exit;
