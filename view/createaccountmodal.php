<?php

echo
'<!-- Register Modal -->
<div class="modal fade" id="ws-login-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header" style="border-bottom: none;">
                <a class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>                                       
            </div>

            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">

                    <div class="modal-body">                                    
                        <!-- Register Form -->                                        
                        <form class="ws-register-form">

                            <h3>Create Account</h3>  
                            <!-- UserName -->
                            <div class="form-group">
                                <label class="control-label">Username <span>*</span></label>
                                <input type="text" class="form-control">
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label class="control-label">Email Address <span>*</span></label>
                                <input type="email" class="form-control">
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label class="control-label">Password <span>*</span></label>
                                <input type="password" class="form-control">
                            </div>

                            <!-- Password Conf -->
                            <div class="form-group">
                                <label class="control-label">Password COnfirmation<span>*</span></label>
                                <input type="password" class="form-control">
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox">I accept the <a href="faq.html">Terms of Service</a>
                                    </label>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="modal-footer">
                        <!-- Button -->
                        <a class="btn ws-btn-fullwidth">Create Account</a>    
                        <!-- Link -->
                        <div class="ws-register-link">
                            <a href="#ws-login-modal" data-toggle="modal" tabindex="1">Already have an account? Login here.</a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Register Modal -->'
?>