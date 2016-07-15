<?php
require_once 'core/init.php';
$user = new User();
$credentials = "";
if ($user->isLoggedIn()) {
    $link = $user->data()->username;
    Redirect::to("user/profile/$link");
}
if (Input::exist()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
            ),
            'password' => array(
            )
        ));

        if ($validation->passed()) {
            $remember = (Input::get('remember') === 'on') ? true : false;
            $login = $user->login(Input::get('username'), Input::get('password'), $remember);

            if ($login) {
                $link = $user->data()->username;
                Redirect::to("user/profile/$link");
            } else {
                $credentials = '<p style="text-align: center; color: red;"> Username or Password is incorrect  </p>';
            }
        } else {
            $count = 0;
            foreach ($validation->errors() as $error) {
                $count++;
            }
            echo "{$count} errors <br>";
            foreach ($validation->errors() as $error) {
                echo "- {$error} <br>";
            }
        }
    }
}
?>

<!doctype html>
<head>
    <title>Imaguana | Login</title>

    <!-- CSS, Meta, Ajax, etc. -->
    <?php include 'view/head.php' ?>
    
</head>
<body>

    <!-- Navigation Bar -->
    <?php include 'view/nav-bar.php'; ?>

    <!-- Page Content -->
    <div class="container ws-page-container">
        <div class="ws-works-title clearfix">
            <div class="col-sm-12">
                <h3 style="font-size: 25px">Login</h3>
                <div class="ws-separator"></div> 
                <?php echo $credentials ?>
            </div>
        </div> 
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">

                <!-- Login Form --> 

                <form class="ws-login-form" action="" method="post">
                    <!-- Username -->
                    <div class="form-group">
                        <label lass="control-label" for="username">Username<span>*</span></label>
                        <input  required="true" class="form-control" type="text" name="username" id="username" value="<?php echo Input::get('username'); ?>" autocomplete="off">
                    </div>

                    <div class="field">
                        <label for="password" class="control-label">Password <span>*</span></label>
                        <input required="true" class="form-control" type="password" name="password" id="password">
                    </div>

                    <div class="pull-left">
                        <div class="checkbox">
                            <label for="remember">
                                <input type="checkbox" name="remember" id="remember">Remember Me
                            </label>
                        </div>
                    </div>

                    <div class="padding-top-x50"></div>

                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                    <input class="btn ws-btn-fullwidth" type="submit" value="Log In"><br><br>
                </form>

                <!-- Link -->
                <div class="ws-register-link">
                    <a href="register.php" >Click here to sign up for an account. </a>
                </div>                                           
            </div>
        </div>
    </div>    
    <!-- End Page Content -->

    <!-- Foot Bar -->
    <?php include 'view/foot-bar.php'; ?>

    <!-- Scripts -->
    <?php include 'view/scripts.php' ?>

</body>
</html>
