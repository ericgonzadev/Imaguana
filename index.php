<?php
require 'core/init.php';

//Connection
mysql_connect("127.13.13.2", "admin67KSwkr", "c6hsZzfY7pGR") or die(mysql_error());
mysql_select_db("imag") or die(mysql_error());

$user = new User();

?>

<!doctype html>
<head>
    <title>Imaguana | Home</title>

    <!-- CSS, Meta, Ajax, etc. -->
    <?php include 'view/head.php' ?>
</head>
<body>
    <!-- Loader Start -->
    <div id="preloader">

    </div>
    <!-- End Loader Start -->

    <!-- Navigation Bar -->
    <!-- Top Bar Start -->
    <div class="ws-topbar" id="home">
        <div class="pull-left">
            <div class="ws-topbar-message hidden-xs">
                <a href="./"><p style="color: white;">Find your <span>perfect</span> image!</p></a> 
            </div>
        </div>

        <div class="pull-right">
            <!-- Shop Menu -->
            <ul class="ws-shop-menu">
                <?php if (!$user->isLoggedIn()) { ?>
                    <!-- Account -->
                    <li class="ws-shop-account">
                        <a href="login.php" class="btn btn-sm">Login</a>
                    </li>
                    <li class="ws-shop-account">
                        <a href="register.php" class="btn btn-sm">Sign Up</a>
                    </li>
                <?php } else { ?>
                    <!-- Account -->
                    <li class="ws-shop-account">
                        <a href="user/profile/<?php echo $user->data()->username; ?>" class="btn btn-sm">Hello, <?php echo $user->data()->name; ?></a>
                    </li>
                    <li class="ws-shop-account">
                        <a href="logout.php" class="btn btn-sm">Logout</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <!-- Top Bar End -->

    <!-- Header Start -->
    <header class="ws-header ws-header-transparent">
        <!-- Navbar -->
        <nav class="navbar ws-navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <!-- Logo -->
                <div class="ws-logo ws-center">
                    <a href="./">
                        <img src="assets/img/iguana_ed.gif" alt="Alternative Text" class="img-responsive">
                    </a>
                </div>
                <!-- Links -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-left">
                        <li><a href="./">Home</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-hover="dropdown" data-animations="fadeIn">Browse<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="imageresults.php">Browse Images</a></li>
                                <li><a href="videoresults.php">Browse Videos</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">

                        <?php if (!$user->isLoggedIn()) { ?>
                            <li><a href="login.php" class="btn btn-sm">My Account</a></li>
                        <?php } else {
                            ?>
                            <li class="dropdown">
                            <a href="user/profile/<?php echo $user->data()->username; ?>" class="dropdown-toggle" data-hover="dropdown" data-animations="fadeIn">My Account<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="upload.php">Upload an image</a></li>
                                <li><a href="videoupload.php">Upload a video</a></li>
                                <li><a href="purchases.php">View purchases</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                        <li><a href="#contact">Contact</a></li>
                        <li><a href="faq.php">F.A.Q.</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- End Header -->

    <!-- Slider FullWidth -->
    <div id="ws-fullwidth-slider" class="rev_slider">
        <ul>
            <!-- Slide -->
            <li data-transition="fade">
                <!-- Background Image -->
                <img src="assets/img/backgrounds/hero-bg2.jpg"  alt=""  width="1920" height="1280">
                <!-- Layer -->
                <div class="tp-caption ws-hero-title hidden-xs"
                     data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                     data-y="['middle','middle','middle','middle']" data-voffset="['-72','-72','-72','-48']"
                     data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;"
                     data-mask_in="x:0px;y:0px;"
                     data-mask_out="x:0;y:0;"
                     data-start="1000"
                     data-responsive_offset="on"
                     style="z-index: 6;"><h1>Start searching for your perfect image now!</h1>
                </div>
                <!-- Layer -->
                <div class="tp-caption ws-hero-description hidden-xs"
                     data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                     data-y="['middle','middle','middle','middle']" data-voffset="['0','0','0','1']"
                     data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;"
                     data-mask_in="x:0px;y:0px;"
                     data-mask_out="x:0;y:0;"
                     data-start="1000"
                     data-responsive_offset="on"
                     style="z-index: 7;">

                     <form style="width: 610px;" method="POST" name="myform" onsubmit="return OnSubmitForm();">
                         <input class="pull-left" style="color: black; height:41px; width: 350px; font-size:20px;" name="search" <?php if (isset($_POST['search'])) {echo "value=\"" . $_POST['search'] . "\"";} ?> type="text" placeholder="Begin your search here..." required>
			     <div id="mainselection" style="float: left;">
 			         <select for="filter" name="filter" id="filter">
   			             <option value="1" style="color:black;">Images</option>
   				     <option value="2" style="color:black;">Videos</option>
				 </select>
			     </div>
                         <span class="ws-shop-cart"><input style="margin-bottom: 9px; height: 41px;" type="submit" class="btn btn-lg" value="Search"></span>
                     </form>

                     <script type="text/javascript">
                            function OnSubmitForm()
                            {
                              if(document.myform.filter[0].selected == true)
                              {
                                document.myform.action ="imageresults.php";
                              }
                              else if(document.myform.filter[1].selected == true)
                              {
                                document.myform.action ="videoresults.php";
                              }
                              return true;
                            }
                    </script>
                </div>
            </li>
        </ul>               
    </div>                
    <!-- End Slider FullWidth -->    

    <form action="imageresults.php" method="POST">
        <input hidden="true" name="search" type="text" value="Animals">
        <input style="background-color: white; border-width: 0px; color: #0000EE;" type="submit" value="">
    </form>
    <!--Featured Section -->    
    <section id ="featuredImages" class="ws-arrivals-section" style="margin-top: -30px;">
        <div class="ws-works-title clearfix">
            <div class="col-sm-12">
                <h3>Featured Images</h3> 
                <div class="ws-separator"></div>   
            </div>
        </div>        
        <!-- Carousel -->
        <div id="ws-items-carousel">
            <?php
            $output = "";
            $css = '<style type="text/css"> ';
            $rand = rand(12, 24);
            $randend = $rand + 10;
            $title_query = mysql_query("SELECT * "
                    . "FROM images "
                    . "WHERE id > $rand AND id < $randend");
            while ($row = mysql_fetch_array($title_query)) {
                $css .= '
                                .multiPic' . $row['id'] . '{ 
                                    width:330px; 
                                    height:240px;  
                                    background: url(' . $row['image'] . ') no-repeat;
                                    background-size: 350px 240px;
                                } 
                                .multiPic' . $row['id'] . ' .text' . $row['id'] . '{ 
                                    width:320px; 
                                    height:80px; 
                                    background:#FFA500; background: url(assets/img/favicon.png) no-repeat; opacity:0; } 

                                .multiPic' . $row['id'] . ':hover .text' . $row['id'] . '{ 
                                    opacity:0.9; 
                                } ';
                $output .="
                    <!-- Item -->
                    <div class='ws-works-item' data-sr='wait 0s, ease-in 20px'>
                        <a href=image/show/" . $row['id'] . ">
                            <!-- Image -->
                            <figure>
                                <div class='multiPic". $row['id'] . "'> 
                                    <div class='text" . $row['id'] . "'>                     
                                    </div>
                                </div>
                            </figure>
                            <div class='ws-works-caption text-center'>
                                <!-- Item Category -->
                                <div class='ws-item-category'>" . $row['category'] . "</div>
                                <!-- Title -->
                                <h3 class='ws-item-title'>" . $row['title'] . "</h3>  <br>
                                <!-- Buttons -->
                                <a href='image/show/" . $row['id'] . "' ><span class='ws-shop-cart'><input style='margin-left: 5px; height: 41px;' type='submit' class='btn btn-lg' value='View'></span></a>
                                <div class='ws-item-separator'></div>          
                            </div>
                        </a>
                    </div>";
            }
            echo $output;
            $css .= '</style>';
            echo $css;
            ?>
        </div>
    </section>
    <!-- End Featured Section -->  

    <!-- Featured Categories Start -->
    <section id="featuredCategories" class="ws-about-section" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                <!-- Description -->
                <div class="ws-about-content clearfix">
                    <div class="col-sm-8 col-sm-offset-2">
                        <h3>Featured Categories</h3> 
                        <div class="ws-separator"></div>                      
                    </div>                
                </div>
                
                
                <!-- Featured Collections -->
                <div class="ws-featured-collections clearfix">
                    
                    <!-- Item -->
                    <div class="col-sm-4 featured-collections-item">
                        <a href="imageresults.php#animal">
                            <div class="thumbnail">
                                <img src="assets/img/category/animals.jpg" alt="Alternative Text">
                                <div class="ws-overlay">
                                    <div class="caption">
                                        <h3>Animals</h3> 
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Item -->
                    <div class="col-sm-4 featured-collections-item">
                        <a href="imageresults.php#landmark">
                            <div class="thumbnail">
                                <img src="assets/img/category/landmarks.jpg" alt="Alternative Text">
                                <div class="ws-overlay">
                                    <div class="caption">
                                        <h3>Landmarks</h3> 
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <!-- Item -->
                    <div class="col-sm-4 featured-collections-item">
                        <a href="imageresults.php#space">
                            <div class="thumbnail">
                                <img src="assets/img/category/space.jpg" alt="Alternative Text">
                                <div class="ws-overlay">
                                    <div class="caption">
                                        <h3>Space</h3> 
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div> 

                </div>
            </div>
        </div>
    </section>
    <!-- Featured Categories End -->  

    <!-- About Section Start -->
    <section id="about" class="ws-about-section" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                <!-- Description -->
                <div class="ws-about-content clearfix">
                    <div class="col-sm-8 col-sm-offset-2">
                        <h3>ABOUT US</h3> 
                        <div class="ws-separator"></div>                      
                        <p style="font-size: 15px">Imaguana is an image hosting website that allows you to purchase the license of an  artist’s image. Imaguana has several advantages over competitors since its strength lies in its easy to use interface, its user focused design for both artists and customers, and its eye pleasing visuals. Some of our competitors websites have been full of unnecessary clutter on their webpages. At Imaguana, a commitment was made to create an extremely simple user interface that anyone will be able to navigate through. We focus on the customer and the artist, with only essential tasks being available at any given time. Our user centered design allows it to stand out above other image hosting sites.Imaguana displays information to either a customer or an artist in a very simple and easy to understand manner. This allows you to browse effortlessly without the uneccessary clutter. Our marketability and brand recognition means that users will continue to return to Imaguana for their image purchasing needs. Imaguana is keen to go to great lengths to create a product that will please anyone whom uses it.</p>
                    </div>     
                    <section id ="aboutA"></section>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section End -->   
    
   
    <!-- Social CSS -->
    <style>
        nav#footer{
            background: #222222;
            color: #ffffff;
            padding: 20px 0 15px 0;
        }
        nav#footer .fnav{ vertical-align: middle;}
        ul.footer-social li{
            display: inline-block;
            margin-right: 10px;
        }
        nav#footer p{
            font-size: 12px;
            margin-top: 10px;
        }
        #footer i.fa {
            height: 30px;
            width: 30px;
            border: 2px solid #8c8c8c;
            font-size: 20px;
            padding: 4px 5px;
            border-radius: 50%;
            color: #8c8c8c;
            transition: all 0.5s;
        }
        #footer i.fa:hover{
            background: #FCAC45;
            border-color: #FCAC45;
            color: #ffffff;
        }
    </style>

    <!--Team Section -->  
    <section class="ws-about-section" id="team" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                <div class="box">
                    <div class="col-lg-12">
                        <h3 style = "color: black;">OUR TEAM</h3> 
                        <div class="ws-separator"></div>   
                    </div>
                    <div class="col-sm-4 text-center">
                        <img class="img-responsive" src="assets/img/team/arwaterman.png" alt="">
                        <h3>Aaron Waterman<br>
                            <small style="color: black;">SCRUM Master</small>
                        </h3>
                        <p>I am a student studying Computer Science at San Francisco State University. I enjoy long hikes and ostentatious titles.</p>
                        <ul class="footer-social">
                            <li><a href="https://www.facebook.com/aaron.waterman" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="https://www.linkedin.com/in/arwaterman" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                    <div class="col-sm-4 text-center">
                        <img width="750" height="450" class="img-responsive" src="assets/img/team/eric.jpg" alt="">
                        <h3>Eric Gonzalez<br>
                            <small style="color: black;">Tech Lead / Full Stack Developer</small>
                        </h3>
                        <p >I enjoy playing video games, watching and playing sports, or anything techie! I'm always eager to learn and experience new things.</p>
                        <ul class="footer-social">
                            <li><a href="https://www.facebook.com/EricGonzalez1994" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="https://www.linkedin.com/in/ericgonzalez1994" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="https://github.com/twinpair/" target="_blank"><i class="fa fa-github"></i></a></li>
                            <li><a href="http://www.ericgonzalez1994.com/" target="_blank">Website</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-4 text-center">
                        <img class="img-responsive" src="assets/img/team/acehockey.jpg" width="750" height="450" alt="">
                        <h3>Ace Raney<br>
                            <small style="color: black;">SVN Administrator/Front End Developer</small>
                        </h3>
                        <p>Grad student and SFSU staff member. I enjoy playing hockey and skiing.</p>
                        <ul class="footer-social" style="margin-top: 25px;">
                            <li><a href="https://www.facebook.com/profile.php?id=100012472296075" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        </ul>
                    </div>

                    <div class="col-sm-4 text-center">
                        <img class="img-responsive" src="assets/img/team/mchuang.png" alt="">
                        <h3>Mon-Shih Chuang<br>
                            <small style="color: black;">Backend Developer</small>
                        </h3>
                        <p>I'm a graduate student at SFSU. I enjoy playing board games and video games.</p>
                        <ul class="footer-social">
                            <li><a href="https://www.facebook.com/magicaldonald" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        </ul>
                    </div>

                    <div class="col-sm-4 text-center">
                        <img class="img-responsive" src="assets/img/team/Monal.jpg" alt="">
                        <h3>Monal Patil<br>
                            <small style="color: black;">Front End Developer</small>
                        </h3>
                        <p>I'm Graduate student at SFSU. I like to travel and enjoy natures beauty!</p>
                        <ul class="footer-social">
                            <li><a href="https://www.facebook.com/monal.patil" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="https://www.linkedin.com/in/monal-patil-51618915" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Team Section -->

    <!-- Contact Start -->
    <section id="contact" class="ws-about-section" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                <div class="ws-works-title clearfix">
                    <div class="col-sm-12">
                        <h3>CONTACT US</h3> 
                        <div class="ws-separator"></div>   
                    </div>
                </div>   
                <div class="ws-contact-page">

                    <!-- General Information -->
                    <div class="col-sm-6">
                        <div class="ws-contact-info">
                            <h2>Email</h2>
                            <p><a href="">imaguana@gmail.com</a></p>
                            <br>
                            <h2>Questions?</h2>
                            <p><a>Feel free to contact us for any questions you have regarding the sale of a license, our privacy policy, our F.A.Q's, or etc.</a></p> <br>
                            <h2>Found a bug or have some feedback for our site?</h2>
                            <p><a>Please fill out the form with your information and will be glad to address the problem</a></p> <br>
                        </div>
                    </div>
                  
                    <!-- Contact Form -->
                    <div class="col-sm-6">
                        
                    <?php 
                    if (isset($_SESSION['notification'])){echo "<p style='text-align: center; color: green'>" .$_SESSION['notification'] . " </p><br>";
unset($_SESSION['notification']);
                    }
                    else{
                    ?>
                        <form class="form-horizontal ws-contact-form" method="POST" >
                            <!-- Name -->
                            <div class="form-group">
                                <label class="control-label">Name <span>*</span></label>
                                <input required type="text" class="form-control" name="name" id="name">                        
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label class="control-label">Email <span>*</span></label>                        
                                <input required type="email" class="form-control" name="email" id="email">                        
                            </div>

                            <!-- Message -->
                            <div class="form-group">
                                <label class="control-label">Message <span>*</span></label>      
                                <textarea required class="form-control" rows="7" name="message" id="message"></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group">              
                                <input type="hidden" name="notification" value="Thanks for your feedback!"> 
                                <input type="submit" class="btn ws-big-btn" value="submit">                        
                            </div>
                        </form>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact Section --> 
    <?php 
    if (Input::exist()) { 
        // Create connection
        $conn = new mysqli("127.13.13.2", "admin67KSwkr", "c6hsZzfY7pGR", "imag");

        die("Connection failed: " . $conn->connect_error) if ($conn->connect_error);

        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        // set parameters and execute
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        $stmt->execute();
        $stmt->close();
        $conn->close();

        $_SESSION['notification'] = "Thanks for your feedback!";
    }                  
    ?>

    <!-- Footer Start -->
    <footer class="ws-footer" style="margin-top: -20px;">
        <div class="container">
            <div class="row">

                <!-- About -->
                <div class="col-sm-6 ws-footer-col">
                    <h3 >Our commitment to you:</h3>
                    <div class="ws-footer-separator"></div>
                    <div class="ws-footer-about">
                        <p>Imaguana is an image hosting website that allows the purchase of image licenses. Imaguana has several advantages over competitors since its strength lies in its easy to use interface, its user focused design for both artists and customers, and its eye pleasing visuals.</p>
                    </div>
                </div>

                <!-- Shop -->
                <div class="col-sm-2 ws-footer-col">
                    <h3>Shop</h3>
                    <div class="ws-footer-separator"></div>
                    <ul>
                        <li><a href="imageresults.php">Browse All</a></li>
                        <li><a href="imageresults.php">Search Catalog</a></li>
                        <li><a href="#featuredImages">Featured Images</a></li>
                        <li><a href="#featuredCategories">Featured Categories</a></li>
                    </ul>
                </div>

                <!-- Social Links -->
                <div class="col-sm-2 ws-footer-col">
                    <h3>Connect with us!</h3>
                    <div class="ws-footer-separator"></div>
                    <ul class="ws-footer-social">
                        <li><a href="#team" >Our Team</a></li>
                        <li><a href="https://www.facebook.com/Imaguana" target="blank"><i class="fa fa-facebook-square fa-lg"></i> Facebook</a></li>
                        <li><a href="https://twitter.com/imaguana648" target="blank"><i class="fa fa-twitter fa-lg"></i>Twitter</a></li>
                        <li><a href="#"><i class="fa fa-instagram fa-lg"></i>Instagram</a></li>
                    </ul>
                </div>

                <!-- Shop -->
                <div class="col-sm-2 ws-footer-col">
                    <h3>Support</h3>
                    <div class="ws-footer-separator"></div>
                    <ul>
                        <li><a href="faq.php#privacy">Privacy Policy</a></li>
                        <li><a href="faq.php">F.A.Q</a></li>
                        <li><a href="#contact">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer End -->

    <section id ="contactA"></section>
    <!-- Footer Bar Start -->
    <div class="ws-footer-bar">
        <div class="container">

            <!-- Copyright -->
            <div class="pull-left">
                <p>Imaguana &copy; 2015 All rights reserved.</p>
            </div>

            <!-- Payments -->
            <div class="pull-right">
                <p><a style="color: #C2A476; margin-right:50px;" href="https://drive.google.com/file/d/0B-4Vah9LEYrLeXhuZG1VZ0ViMVJlV01pR1o3NGlUOEUzeW53/view?usp=sharing" target="blank">Documentation</a><a style="color: #C2A476;" href="https://github.com/twinpair/Imaguana" target="blank">Source Code</a></p> 
            </div>
        </div>
    </div>
    <!-- Footer Bar End -->

    <style>
        p, h3{
            color: black;
        }
    </style>
    
    <!-- Scripts -->
    <?php include 'view/scripts.php' ?>

</body>
</html>
