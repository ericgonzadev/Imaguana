<?php
require_once 'core/init.php';

//Connection
mysql_connect("127.13.13.2", "admin67KSwkr", "c6hsZzfY7pGR") or die(mysql_error());
mysql_select_db("imag") or die(mysql_error());

$elements = explode('/', $_SERVER['REQUEST_URI']);
$account = $elements[1];
echo $account . " " . $username;
if (!$username)
    if (!$username = Input::get('user'))
        Redirect::to("/$account/");

$user = new User($username);
if (!$user->exists()) {
    Redirect::to(404);
} 
else {
    $data = $user->data();
    $user = new User();
}
?>

<!doctype html>
<head>
    <title>Imaguana | Profile</title>
    
    <?php
    $elements = explode('/', $_SERVER['REQUEST_URI']);
    $account = $elements[1];
    echo $account;
    echo "<BASE href=\"/$account/\">";
    ?>
    
        
</head>
<body>

    <!-- Navigation Bar -->
    <?php include 'view/nav-bar.php'; ?>

    <p>worked</p>
    
</body>
</html>

