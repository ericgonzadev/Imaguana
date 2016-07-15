<?php
require_once 'core/init.php';
$elements = explode('/', $_SERVER['REQUEST_URI']);
$account = $elements[1];
$validations = "";
$count = 0;
$id = $image->data()->id;
$user = new User();

if (!$user->isLoggedIn()) {
    Redirect::to('./login.php');
}

if ($user->data()->group == 2) {
    Redirect::to('./');
}

if (Input::exist()) {
    $web = $_POST['Web'];
    $print = $_POST['Print'];
    $unlimited = $_POST['Unlimited'];
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
        'Title' => array(
            'min' => 3,
            'max' => 30
        ),
        'Desc' => array(
            'min' => 5,
            'max' => 100,
        )
    ));
    
    //check that the licenses are integers
    if(!intval($web)){
        $validations .= "- web license value must be a number<br>";
        $count++; 
    }
    if(!intval($print)){
        $validations .= "- print license value must be a number<br>";
        $count++; 
    }
    if(!intval($unlimited)){
        $validations .= "- unlimited license value must be a number<br>";
        $count++; 
    }
    if ($validation->passed() && $validations == "") {
        try {
            $image->update(array(
                'title' => Input::get('Title'),
                'description' => Input::get('Desc'),
                'web' => Input::get('Web'),
                'print' => Input::get('Print'),
                'unlimited' => Input::get('Unlimited'),
                'category' => Input::get('category'),
                'tags' => Input::get('Tags')
            ), $id);

            Redirect::to("/$account/image/show/$id");
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    else{
        foreach ($validation->errors() as $error) {
            $count++;  
            $validations .= "- {$error} <br>";
        }
    }
}
?>

<!doctype html>
<head>
    <title>Imaguana | Edit Image</title>
    
    <?php
    $elements = explode('/', $_SERVER['REQUEST_URI']);
    $user = $elements[1];
    echo "<BASE href=\"/$user/\">";
    ?>
    
    <!-- CSS, Meta, Ajax, etc. -->
    <?php include 'view/head.php' ?>
    
</head>
<body>

     <!-- Navigation Bar -->
    <?php include 'view/nav-bar.php'; ?>

    <!-- Page Content Section -->
    <div class="container ws-page-container" style="margin-top: -70px;">
        <div class="row">
            <div class="row">
                <div class="ws-works-title clearfix">
                    <div class="col-sm-12">
                        <h3>Edit Image</h3> 
                        <div class="ws-separator"></div>   
                    </div>
                    <?php if ($count > 0){echo "<p style='text-align: center; color: red'>" . $count . " error(s)</p><p style='text-align: center; color: red'>" . $validations . "</p><br>";}?>
                </div>   
                <div class="ws-contact-page">

                    <!-- Left Pane -->
                    <div class="col-sm-5">
                        <div id="ws-products-carousel" class="owl-carousel">
                            <div class="item">
                                <img src="<?php echo $image->data()->image; ?>" class="img-responsive" alt="Alternative Text" height="700">
                            </div>
                        </div>
<!--                        <div class="col-sm-11">
                            <a class="btn ws-btn-fullwidth" style="margin-top: 15px;" href='#delete' data-toggle='modal' >Delete Image</a>
                        </div>-->
                    </div>
                    <!-- End Left Pane -->

                    <!-- Right Pane -->
                    <div class="col-sm-7">
                        <form action="" method="POST" class="form-horizontal ws-contact-form">
                            <div class="ws-contact-info">
                                <h2>Title<span>*</span></h2>
                                <textarea style="resize:none; color:black;" name="Title" id="Title" rows="1" cols="100"><?php echo $image->data()->title; ?></textarea><br/><br/>   
                                <h2>Description<span>*</span></h2> 
                                <textarea style="resize:none; color:black;" name="Desc" id="Desc" rows="3" cols="100"><?php echo $image->data()->description; ?></textarea><br/><br/>
                                <h2>License<span>*</span>   
                                    <a data-toggle="modal" data-target="#License" >
                                        <img style='height:16px; width:16px; ' alt='assets/img/help.gif' src='assets/img/help.gif' >
                                    </a>

                                    <table style="margin-top: 10px;">
                                        <tr>
                                            <td ><label class="control-label">Web $</label></td>
                                            <td style="padding-right: 20px"><textarea style="resize:none; color:black;" name="Web" id="Web" class="form-control-upload" rows="1" cols="10"><?php echo $image->data()->web; ?></textarea><p class="pull-right"></p></td>

                                            <td ><label class="control-label">Print $</label> </td>
                                            <td style="padding-right: 20px"><textarea style="resize:none; color:black;" name="Print" id="Print" class="form-control-upload" rows="1" cols="10"><?php echo $image->data()->print; ?></textarea> <p class="pull-right"></p></td>

                                            <td ><label class="control-label">Unlimited $</label> </td>
                                            <td style="padding-right: 20px"><textarea style="resize:none; color:black;" name="Unlimited" id="Unlimited" class="form-control-upload" rows="1" cols="10"><?php echo $image->data()->unlimited; ?></textarea><p class="pull-right"></p></td> 
                                        </tr>
                                    </table>

                                </h2><br>
                                <h2>Category*
                                    <select for="category" name="category" id="category" >
                                        <option value="Animal" <?php if($image->data()->category == "Animal"){echo "selected";}?>>Animal</option>
                                        <option value="Beauty" <?php if($image->data()->category == "Beauty"){echo "selected";}?>>Beauty</option>
                                        <option value="City" <?php if($image->data()->category == "City"){echo "selected";}?>>City</option>
                                        <option value="Education"<?php if($image->data()->category == "Education"){echo "selected";}?>>Education</option>
                                        <option value="Fashion" <?php if($image->data()->category == "Fashion"){echo "selected";}?>>Fashion</option>
                                        <option value="Food" <?php if($image->data()->category == "Food"){echo "selected";}?>>Food</option>
                                        <option value="Landmark" <?php if($image->data()->category == "Landmark"){echo "selected";}?>>Landmark</option>
                                        <option value="Nature" <?php if($image->data()->category == "Nature"){echo "selected";}?>>Nature</option>
                                        <option value="Science" <?php if($image->data()->category == "Science"){echo "selected";}?>>Science</option>
                                        <option value="Space" <?php if($image->data()->category == "Space"){echo "selected";}?>>Space</option>
                                        <option value="Sport" <?php if($image->data()->category == "Sport"){echo "selected";}?>>Sport</option>
                                        <option value="Vintage" <?php if($image->data()->category == "Vintage"){echo "selected";}?>>Vintage</option>
                                    </select></h2><br>
                                <h2>Tags</h2>
                                <textarea style="resize:none; color:black;" name="Tags" id="Tags" rows="3" cols="100"><?php echo $image->data()->tags; ?></textarea><br/>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-11">
                                    <!-- Button -->
                                    <input class="btn ws-btn-fullwidth" style="margin-top: 15px; width: 300px;" type="submit" value="Save Changes" name="submit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="image/show/<?php echo $image->data()->id; ?>" class="btn ws-btn-black" style="color: white; margin-top: 15px; width: 250px" >Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- End Right Pane -->

                </div>
            </div>

        </div>
    </div>
    <!-- End Page Content Section -->

    <!-- DEFINING WEB, Print, and Unlimited License -->
    <div id="License" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <h3 style="text-align: center; color:black;">License Descriptions:</h3>
                    <div class="ws-separator"></div> 
                    <h3 style="text-align: center; color:black;" ><u>Web</u></h3>
                    <p style="color:black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You will receive a URL that you can use on your website to display the image.</p>
                    <br>
                    <h3 style="text-align: center; color:black;" ><u>Print</u></h3>
                    <p style="color:black; text-align: center;">You will receive a downloadable file of the image.</p>
                    <br>
                    <h3 style="text-align: center; color:black;" ><u>Unlimited</u></h3>
                    <p style="color:black; text-align: center;">You will receive the URL and the downloadable file of the image.</p>
                    <br>
                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-8" style="margin-left: 300px">
                            <ul style="list-style: none;">
                                <li class="ws-shop-cart" style="display:inline;">
                                    <a data-dismiss="modal" aria-label="Close" class="btn btn-sm" style="margin-left: 25px;">Close</a>
                            </ul>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>

    <!-- Foot Bar -->
    <?php include 'view/foot-bar.php'; ?>

    <!-- Scripts -->
    <?php include 'view/scripts.php' ?>

</body>
</html>
