<?php

if ($user->isLoggedIn()) {
    echo '
    <div class="modal fade" id="ws-buy-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="border: none;">
                    <a class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
                </div>
                <div class="row" >
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="modal-body">                                    
                            <!-- Register Form -->                                        
                            <form class="ws-buy-form">
                                <h4>Choose the license you would like to purchase</h4>
                                <div class="ws-separator"></div>   
                                <div class="form-group">
                                    <label class="control-label col-sm-3">
                                        Licenses <img style="height:16px; width:16px;" alt="assets/img/help.gif" src="assets/img/help.gif" data-toggle="tooltip" data-placement="bottom"
                                                      title="Web License : You will receive a URL that you can use on your website to display the image  &#13;
                                                             Print License: You will receive a downloadable file of the image &#13;
                                                             Unlimited License: You will receive the URL and the downloadable file of the image" >
                                    </label>
                                    <label class="radio-inline"><input type="radio" checked="true" name="license" value="1">Web $25</label>
                                    <label class="radio-inline"><input value="2" type="radio" name="license">Print $25</label>
                                    <label class="radio-inline"><input value="3" type="radio" name="license">Unlimited $25</label>
                                    <br><br>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"></label>
                                        <div class="col-md-8" style="margin-left: -100px">
                                            <ul style="list-style: none;">
                                                <li class="ws-shop-cart" style="display:inline;">
                                                <input class="btn btn-sm" type="submit" value="Buy" name="submit" value="Save Changes">
                                                <span></span>
                                                <li class="ws-shop-cart" style="display:inline;">
                                                <a data-dismiss="modal" aria-label="Close" class="btn btn-sm" style="margin-left: 25px;">Cancel</a>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>';
} else {
    echo '
    <div class="modal fade" id="ws-buy-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="border: none;">
                    <a class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
                </div>
                <div class="row" >
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="modal-body">
                            <!-- Register Form -->
                            <form class="ws-buy-form">
                                <h3>Thank you for your interest!</h3>
                                <div class="ws-separator"></div>   
                                <div class="form-group">
                                    <h4>to complete your purchase,</h4>
				    <br>
                                    <h4>write down the title and type of license</h4>
                                    <h4>and contact CII at <span style="color: black;">(415)855-8555</span></h4>
                                    <br>
                                    <h4>or <a href="login.php"><span>log in</span></a> to your account</h4>
                                    <br>
                                    <h4>dont have an account? <a href="register.php"><span>sign in</span></a> today!</h4>
                                    <div class="ws-separator"></div>
                                    <p>Image Title: ' . $image->data()->title . '</p>
                                    <p style="margin-top: 10px;">Image ID: ' . $image->data()->id . '</p>
                                    <br>
                                    <label class="control-label col-sm-3">
                                        Licenses
                                        <img style="height:16px; width:16px;" alt="assets/img/help.gif" src="assets/img/help.gif" data-toggle="tooltip"
                                             title="Web License : You will receive a URL that you can use on your website to display the image  &#13;
                                                    Print License: You will receive a downloadable file of the image &#13;
                                                    Unlimited License: You will receive the URL and the downloadable file of the image" >
                                    </label>
                                    <label>Web $25</label>
                                    <label style="margin-left: 25px;">Print $25</label>
                                    <label style="margin-left: 25px;">Unlimited $35</label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>';
}
?>
