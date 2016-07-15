<?php
require 'core/init.php';

//Connection
mysql_connect("sfsuswe.com", "twinpair", "csc2016") or die(mysql_error());
mysql_select_db("student_twinpair") or die(mysql_error());

$user = new User();
?>

<!doctype html>
<head>
    <title>Imaguana | F.A.Q</title>
    
    <!-- CSS, Meta, Ajax, etc. -->
    <?php include 'view/head.php' ?>
</head>
<body>

    <!-- Navigation Bar -->
    <?php include 'view/nav-bar.php'; ?>

    <!-- Page Content -->
    <div class="container ws-page-container" style="margin-top: -65px">
        <div class="row">            
            <div class="ws-faq-page">
                <div class="ws-works-title clearfix">
                    <div class="col-sm-12">
                        <h3 style="font-size: 30px">Frequently Asked Questions  </h3> 
                        <div class="ws-separator"></div>   
                    </div>
                </div> 
                <div class="col-md-8 col-md-offset-2">
                    
                    <!-- Tab Navabar -->                
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#service" aria-controls="service" role="tab" data-toggle="tab">Services</a></li>
                        <li role="presentation"><a href="#account" aria-controls="account" role="tab" data-toggle="tab">Account</a></li>
                        <li role="presentation"><a href="#privacy" aria-controls="privacy" role="tab" data-toggle="tab">Privacy &amp; Policy</a></li>
                        
                        <li role="presentation"><a href="#demo" aria-controls="demo" role="tab" data-toggle="tab">Demonstration Purposes</a></li>
                    </ul>

                    <!-- Tab Panes -->
                    <div class="tab-content">

                        <!-- Services Panel -->
                        <div role="tabpanel" class="tab-pane fade in active ws-faq-pane-holder" id="service" style="margin-top: -35px;">   

                            <div class="text-center">
                                <h3>Services</h3>
                                <div class="ws-separator"></div> 
                            </div>

                            <!-- Accordion Panel --> 
                            <div class="ws-accordion">

                                <!-- Group -->
                                <div class="accordion-group">
                                    <div class="accordion-heading">
                                        <a class="accordion-toggle active" data-toggle="collapse" href="#collapseOne">
                                            What is Imaguana?
                                        </a>
                                    </div>

                                    <div id="collapseOne" class="accordion-body collapse in">
                                        <div class="accordion-inner" >
                                            <p>Imaguana is an image hosting website which aims to tackle the issues CII is currently having concerning the licensing of artist’s images, and the sale of these images to potential customers.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Group -->
                                <div class="accordion-group">
                                    <div class="accordion-heading">
                                        <a class="accordion-toggle" >
                                            What does Imaguana sell?
                                        </a>
                                    </div>

                                    <div id="collapseTwo" class="accordion-body collapse in" data-toggle="collapse" href="#collapseTwo">
                                        <div class="accordion-inner">
                                            <p>Imaguana sells licenses of artworks from artists of CII for different uses. Customers can choose images licenses for using on web or physical printout</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Group -->
                                <div class="accordion-group">
                                    <div class="accordion-heading">
                                        <a class="accordion-toggle" data-toggle="collapse" href="#collapseThree">
                                            How can I trust buying on Imaguana?
                                        </a>
                                    </div>

                                    <div id="collapseThree" class="accordion-body collapse in">
                                        <div class="accordion-inner">
                                            <p>We know that safety and trust are really important to you and being frequent online shoppers ourselves we take it seriously. When you purchase an item on Imaguana, we hold your payment safe until you tell us you’ve received your order. Only then do we release your payment to the seller. We select our creators with care and we stand behind every purchase made on Imaguana so that you can buy with confidence.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Group -->
                                <div class="accordion-group">
                                    <div class="accordion-heading">
                                        <a class="accordion-toggle" data-toggle="collapse" href="#collapseFour">
                                            Can I sell at Imaguana?
                                        </a>
                                    </div>

                                    <div id="collapseFour" class="accordion-body collapse in">
                                        <div class="accordion-inner">
                                            <p>We’re always looking for interesting creators making great design creations that comes with a story to tell. Currently, only featured creators are allowed to sell with Imaguana. We are working towards launching the open section of our marketplace. If you are interested in being featured, or want to sell on Imaguana, please apply here.</p>
                                        </div>
                                    </div>
                                </div>

                            </div>  
                            <!-- End Accordion Panel --> 
                        </div>
                        <!-- End Service Panel -->

                        <!-- Account Panel -->
                        <div role="tabpanel" class="tab-pane fade ws-faq-pane-holder" id="account" style="margin-top: -35px;">   

                            <div class="text-center">
                                <h3>Account</h3>
                                <div class="ws-separator"></div> 
                            </div>  

                            <!-- Accordion Panel --> 
                            <div role="tablist" aria-multiselectable="true" class="ws-accordion">
                                <div class="accordion">

                                    <!-- Group -->
                                    <div class="accordion-group">
                                        <div class="accordion-heading">
                                            <a class="accordion-toggle" data-toggle="collapse" href="#collapseFive">
                                                Why am I required to register before making a purchase?
                                            </a>
                                        </div>

                                        <div id="collapseFive" class="accordion-body collapse in">
                                            <div class="accordion-inner">
                                                <p>Registering is quick and easy, we require only a password in addition to the username that you provide. Having an account lets you keep track of your orders’ status from your dashboard easily.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Group -->
                                    <div class="accordion-group">

                                        <div class="accordion-heading">
                                            <a class="accordion-toggle" data-toggle="collapse" href="#collapseSix">
                                                How do I change my account information?
                                            </a>
                                        </div>

                                        <div id="collapseSix" class="accordion-body collapse in">
                                            <div class="accordion-inner">
                                                <p>To change your information, follow the steps below:<br><br>
                                                    On the upper right hand corner of any page you’ll see a link with your name. Click on your name to access your user account dashboard. (You can also click on "My Account" in the navbar) <br><br>
                                                   Once you are in your profile dashboard, select "Edit Profile". You are then able to change your account information.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Group -->
                                    <div class="accordion-group">

                                        <div class="accordion-heading">
                                            <a class="accordion-toggle" data-toggle="collapse" href="#collapseSeven">
                                                I forgot my password, how do I recover it?
                                            </a>
                                        </div>

                                        <div id="collapseSeven" class="accordion-body collapse in">
                                            <div class="accordion-inner">
                                                <p>Please <a href="./#contact">  contact us</a> with you information, such as your name, and email. (NOTICE: We might ask you to provide valid identification)</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>   
                            <!-- End Accordion Panel -->
                        </div>
                        <!-- Account Panel -->

                        <!-- Buying Panel -->
                        <div role="tabpanel" class="tab-pane fade ws-faq-pane-holder" id="demo" style="margin-top: -35px;"> 

                            <div class="text-center">
                                <h3>DEMO</h3>
                                <div class="ws-separator"></div> 
                            </div>

                            <!-- Accordion Panel --> 
                            <div role="tablist" aria-multiselectable="true" class="ws-accordion">
                                <div class="accordion">

                                    <!-- Group --> 
                                    <div class="accordion-group">
                                        <div class="accordion-heading">
                                            <a class="accordion-toggle" data-toggle="collapse" href="#collapseNine">
                                                What is this website? 

                                            </a>
                                        </div>

                                        <div id="collapseNine" class="accordion-body collapse in">
                                            <div class="accordion-inner">
                                                <p>This website was made for demonstration purposes only. It is part of a course curriculum at San Francisco State University</p><br>
                                                <p style="text-align: center;">Check out the Documentation and Source Code below: </p>
                                                <p style="text-align: center;"><a style="color: #C2A476; margin-right:50px;" href="https://drive.google.com/file/d/0B-4Vah9LEYrLeXhuZG1VZ0ViMVJlV01pR1o3NGlUOEUzeW53/view?usp=sharing" target="blank">Documentation</a><a style="color: #C2A476;" href="https://github.com/Twinpair/Imaguana" target="blank">Source Code</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <!-- End Accordion Panel -->
                        </div>
                        <!-- End Buying Panel -->



                        <!-- Privacy Policy Panel Panel -->
                        <div role="tabpanel" class="tab-pane fade ws-faq-pane-holder" id="privacy" style="margin-top: -35px;">   

                            <div class="text-center">
                                <h3>Privacy &amp; Policy</h3>
                                <div class="ws-separator"></div> 
                            </div>

                            <!-- Accordion Panel --> 
                            <div class="ws-accordion">

                                <!-- Group -->
                                <div class="accordion-group">
                                    <div class="accordion-heading">
                                        <a class="accordion-toggle active" data-toggle="collapse" href="#collapseSeventeen">
                                            Information Collected or Received
                                        </a>
                                    </div>

                                    <div id="collapseSeventeen" class="accordion-body collapse in">
                                        <div class="accordion-inner">
                                            <p>Imaguana may collect personally identifiable information, such as your name. Imaguana may also collect anonymous demographic information, which is not unique to you, such as your age and gender. We may gather additional personal or non-personal information in the future.</p>
                                            <br>
                                            <p>Information about your computer hardware and software may be automatically collected by Imaguana. This information can include: your IP address browser type, domain names, access times and referring website addresses. This information is used for the operation of the service, to maintain quality of the service, and to provide general statistics regarding use of the Imaguana website.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Group -->
                                <div class="accordion-group">
                                    <div class="accordion-heading">
                                        <a class="accordion-toggle" data-toggle="collapse" href="#collapseEighteen">
                                            Collection and use of personal information
                                        </a>
                                    </div>

                                    <div id="collapseEighteen" class="accordion-body collapse in">
                                        <div class="accordion-inner">
                                            <p>Imaguana collects and uses your personal information to operate its website(s) and deliver the services you have requested.</p>
                                            <br>
                                            <p>When you place an order on the Site, you must provide your first and last name, a valid email address, phone number, billing address, shipping address, and credit card number. We will use this information to fulfill the order you place and to communicate with you about it.</p>
                                            <br>
                                            <p>Imaguana uses your information for four purposes: (1) to fulfill the orders you place on the Site, (2) to answer any customer service inquiries that you may have, (3) to contact you about special offers, Imaguana news and new products and (4) to understand the shopping habits of our customers to better serve them in the future.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Group -->
                                <div class="accordion-group">
                                    <div class="accordion-heading">
                                        <a class="accordion-toggle" data-toggle="collapse" href="#collapseNineteen">
                                            Use of Cookies
                                        </a>
                                    </div>

                                    <div id="collapseNineteen" class="accordion-body collapse in">
                                        <div class="accordion-inner">
                                            <p>The Imaguana uses cookie to improve and personalize your experience on our site by remembering you or your preferences during your visit(s) to the site. </p>
                                            <br>
                                            <p>If a Site doesn’t use cookies, it will think you are a new visitor every time you move to a new page on the Site. Our Site uses cookies to remember things like your preferences, shopping cart or to remember who you are on return visits.</p>
                                            <br>
                                            <p>You have the ability to accept or decline cookies. Most Web browsers automatically accept cookies, but you can usually modify your browser setting to decline cookies if you prefer. If you choose to decline cookies, you may not be able to fully experience the interactive features of the Imaguana services or websites you visit.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Group -->
                                <div class="accordion-group">
                                    <div class="accordion-heading">
                                        <a class="accordion-toggle" data-toggle="collapse" href="#collapseTwenty">
                                            Children Under Thirteen
                                        </a>
                                    </div>

                                    <div id="collapseTwenty" class="accordion-body collapse in">
                                        <div class="accordion-inner">
                                            <p>Imaguana does not knowingly collect personally identifiable information from children under the age of thirteen. If you are under the age of thirteen, you must ask your parent or guardian for permission to use this website.</p>
                                        </div>
                                    </div>
                                </div>

                            </div>  
                            <!-- End Accordion Panel --> 
                        </div>
                        <!-- End Privacy Policy Panel -->

                    </div>
                    <!-- End Tab Panes -->

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
