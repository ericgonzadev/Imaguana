<?php
require_once 'core/init.php';
$count = 0;
$validations = "";
$user = new User();
if ($user->isLoggedIn()) {
    $link = $user->data()->username;
    Redirect::to("user/profile/$link");
}
if (Input::exist()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'name' => array(
                'min' => 2,
                'max' => 20
            ),
            'username' => array(
                'min' => 4,
                'max' => 20,
                'unique' => 'users'
            ),
            'email' => array(
                'unique' => 'users'
            ),
            'password' => array(
                'min' => 4
            ),
            'password_again' => array(
                'matches' => 'password'
            ),
        ));

        if (Input::get('agree') != 'on') {
            $count++;
            $validations .= "-please check the box to agree to the Terms of Service and Privacy Policy<br>";
        } else if ($validation->passed()) {
            $user = new User();
            $salt = Hash::salt(32);
            try {
                $user->create(array(
                    'name' => Input::get('name'),
                    'username' => Input::get('username'),
                    'email' => Input::get('email'),
                    'salt' => $salt,
                    'password' => Hash::make(Input::get('password'), $salt),
                    'joined' => date('Y-m-d H:i:s'),
                    'group' => Input::get('usertype')
                ));

                Session::flash('home', 'Registered Successfully');
                $login = $user->login(Input::get('username'), Input::get('password'), $remember);
                $link = $user->data()->username;
                Redirect::to("user/profile/$link");
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            foreach ($validation->errors() as $error) {
                $count++;
                $validations .= "- {$error} <br>";
            }
        }
    }
}
?>


<!doctype html>
<head>
    <title>Imaguana | Register</title>
    
    <!-- CSS, Meta, Ajax, etc. -->
    <?php include 'view/head.php' ?>
    
</head>
<body>

    <!-- Navigation Bar -->
    <?php include 'view/nav-bar.php'; ?>

    <!-- Page Content -->
    <div class="container ws-page-container" style="margin-top: -50px;">
        <div class="ws-works-title clearfix">
            <div class="col-sm-12">
                <h3 style="font-size: 25px">Create an Account</h3>
                <div class="ws-separator"></div> 
            </div>
        </div> 
        <div class="row">

            <?php
            if ($count != 0) {
                echo "<p style='text-align: center; color: red;'>{$count} error(s) </p>";
                echo "<p style='text-align: center; color: red;'>{$validations} </p>";
            }
            ?>
            
            <div class="col-sm-6 col-sm-offset-3">

                <!-- Login Form --> 

                <!-- Register Form -->
                <form class="ws-register-form" method="post">
                    <!-- Name -->
                    <div class="form-group">
                        <label class="control-label" for="name">Name<span>*</span></label>
                        <input required="true" class="form-control" type="text" name="name" id="name" value="<?php echo Input::get('name'); ?>">
                    </div>

                    <!-- UserName -->
                    <div class="form-group">
                        <label class="control-label" for="username">Username <span>*</span></label>
                        <input required="true" class="form-control" type="text" name="username" id="username" value="<?php echo Input::get('username'); ?>" autocomplete="off">
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label class="control-label" for="email">Email Address <span>*</span></label>
                        <input required="true" class="form-control" type="email" name="email" id="email" value="<?php echo Input::get('email'); ?>">
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label class="control-label" for="password">Password <span>*</span></label>
                        <input required="true" class="form-control" type="password" name="password" id="password">
                    </div>

                    <!-- Password Conf -->
                    <div class="form-group">
                        <label required="true" class="control-label"for="password_again">Password Confirmation<span>*</span></label>
                        <input required="true" class="form-control" type="password" name="password_again" id="password_again">
                    </div><br>

                    <div class="form-group">
                        <label class="control-label col-sm-3">User Type:</label>
                        <div class="col-sm-9">
                            <label class="radio-inline"><input type="radio" checked="true" name="usertype" value="1">Artist</label>
                            <label class="radio-inline"><input value="2" type="radio" name="usertype">Customer</label>&nbsp &nbsp &nbsp &nbsp
                            <img style='height:16px; width:16px;' alt='assets/img/help.gif' src='assets/img/help.gif'data-toggle="tooltip"
                                 title="Artist: You will be able to upload, sell, and buy images. &nbsp; &nbsp; &nbsp;Customer: You will be able to buy images" >

                        </div>
                    </div><br/>

                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="agree" id="agree">I accept the <a target="blank" href="faq.php">Terms of Service</a> and <a target="blank" href="faq.php#privacy">Privacy Policy</a>
                            </label>
                        </div>
                    </div>

                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                    <input class="btn ws-btn-fullwidth" type="submit" value="Register">
                </form>


                <!-- Link -->
                <div class="ws-register-link">
                    <a href="login.php">Already have an account? Sign in here.</a>
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

