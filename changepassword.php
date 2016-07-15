<?php
require_once 'core/init.php';
$validations = "";
$count = 0;
$user = new User();
$link = $user->data()->username;
if (!$user->isLoggedIn()) {
    Redirect::to('./login.php');
}
if (Input::exist()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'password_current' => array(
                'min' => 4
            ),
            'password_new' => array(
                'min' => 4
            ),
            'password_new_again' => array(
                'min' => 4,
                'match' => 'password_new'
            )
        ));

        if ($validation->passed()) {

            if (Hash::make(Input::get('password_current'), $user->data()->salt) != $user->data()->password) {
                $count = 1;
                $validations .= "Current password is incorrect";
            } else {
                $salt = Hash::salt(32);
                $user->update(array(
                    'password' => Hash::make(Input::get('password_new'), $salt),
                    'salt' => $salt
                ));

                Session::flash('home', 'Updated Password Successfully');
                Redirect::to("user/profile/$link");
            }
        }
        else {
            foreach ($validation->errors() as $error) {
                $count++;
            }
            foreach ($validation->errors() as $error) {
                $validations .= "- {$error} <br>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<head>
    <title>Imaguana | Change Password</title>
    
    <!-- CSS, Meta, Ajax, etc. -->
    <?php include 'view/head.php' ?>
</head>

</head>
<body>
    <!-- Navigation Bar -->
    <?php include 'view/nav-bar.php'; ?>

    <div class="container" style="margin-bottom: 10px; text-align: center; align-content: center;">
        <div class="ws-works-title clearfix">
            <br>
            <div class="col-sm-12">
                <h3 style="font-size: 25px">Change Password: <?php echo $user->data()->username; ?></h3>
                <div class="ws-separator"></div> 
            </div>
        </div> 
        <div class="row" style="text-align: center; align-content: center;">
            <?php
            if ($count != 0) {
                echo "<p style='text-align: center; color: red;'>{$count} errors </p>";
                echo "<p style='text-align: center; color: red;'>{$validations} </p>";
            }
            ?>
            <!-- edit form column -->
            <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
                <form action="" method="post"  class="col-md-8 col-sm-6 col-xs-12 personal-info" style="margin-left:350px;">
                    <div class="form-group" >
                        <label for="password">Current Password</label>
                        <input required="true" class="form-control" type="password" name="password_current" id="password_current">
                    </div>

                    <div class="form-group">
                        <label for="password_new">New Password</label>
                        <input required="true" class="form-control" type="password" name="password_new" id="password_new">
                    </div>

                    <div class="form-group">
                        <label  for="password_new_again">Password Confirmation</label>
                        <input required="true" class="form-control" type="password" name="password_new_again" id="password_new_again">
                    </div><br>
                    
                    <div class="col-sm-11" style="margin-right: 30px;">
                        <!-- Button -->
                        <input class="btn ws-btn-fullwidth" style=" width: 200px;" type="submit" value="Change Password" name="submit">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="user/profile/<?php echo $user->data()->username; ?>" class="btn ws-btn-black" style="color: white; width: 150px" >Cancel</a>
                    </div>

                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                </form>
            </div>
        </div>
    </div>
    <br><br>
    
    <!-- Scripts -->
    <?php include 'view/scripts.php' ?>
    
    <!-- Foot Bar -->
    <?php include 'view/foot-bar.php'; ?>
</body>
</html>
