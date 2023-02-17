<p>
    this is a message
<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    require_once ('DB/DBConnection.php');

    $db = (new DBConnection());
    $pdo = $db->connect();
    echo "success!";

    print_r($_ENV);

?>
</p>
