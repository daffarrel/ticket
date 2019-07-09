<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if($this->session->userdata('hak_akses') != 'admin'){
    ?>
    <div class="container">
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info" >
                <div class="panel-heading">
                    <div class="panel-title">Sign In</div>
                </div>
                <div style="padding-top:30px" class="panel-body" >
                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                    <form id="loginform" class="form-horizontal" role="form" action="<?php echo base_url('admin/login')?>" method="post">
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="login-username" type="text" class="form-control" name="username" placeholder="Username Anda">
                        </div>
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="login-password" type="password" class="form-control" name="password" placeholder="Password Anda">
                        </div>
                        <div style="margin-top:10px" class="form-group">
                            <!-- Button -->
                            <div class="col-sm-12 controls">
                                <input id="btn-login" href="#" class="btn btn-success" type="submit" value="Login">
                            </div>
                        </div>
                        <?php
                        if(validation_errors() != NULL) {
                            ?>
                            <div class="form-group">
                                <div class="col-md-12 control">
                                    <?php echo validation_errors(); ?>
                                </div>
                            </div>
                            <?php
                        }

                        if($error != NULL){
                            ?>
                            <div class="form-group">
                                <div class="col-md-12 control">
                                    <?php echo $error; ?>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>

    </script>
    <?php
}
else{
    redirect('main');
}
?>