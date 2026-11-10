<?php
header('Location: turnamen.php?action=view&id=' . (int) ($_GET['id'] ?? 0));
exit;
