<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/Shared/Logic.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        $PageTitle = "تغيير كلمة المرور";
        include 'Shared/Head.php';
        ?>
    </head>
    <body  id="page-top">
        <?php include 'Shared/Nav.php'; ?>
        <form  method="Post" action="<?php $_PHP_SELF ?>" role="form"  >
            <div id="wrapper">
                <!-- Menu Here -->
                <?php
                include 'Shared/Menu.php';
                if (isset($_GET["type"])) {
                    $UserType = $_GET["type"];
                } else {
                    $UserType = $_POST["type"];
                }
                if (isset($_GET["id"])) {
                    $Id = $_GET["id"];
                } else {
                    $Id = $_POST["Id"];
                }
                $result;
                $resultSuccess = false;
                if (isset($_POST["Password"]) && isset($_POST["PasswordConfirm"])) {
                    if ($_POST["Password"] == $_POST["PasswordConfirm"]) {
                        ChangeUserPassword($Id, $_POST["Password"]);
                        $resultSuccess = true;
                        $result = "تم تغيير كلمة المرور";
                    } else {
                        $result = "كلمة المرور غير متطابقة";
                    }
                }
                ?>
                <div id="content-wrapper"> 
                    <div class="container-fluid">
                        <!--content here-->
                        <div class="page-head">
                            <div class="pull-right">      
                                <a class="btn btn-success" href="/admin/users.php?type=<?php echo $UserType; ?>"><i class="fa fa-reply"></i></a>

                                <button class="btn btn-info" type="submit"><i class="fa fa-save"></i>  حفظ</button>


                            </div>
                            <div class="pull-left">
                                <h2><i class="fa fa-users"></i>
                                    <?php echo $PageTitle; ?></h2>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <div class="form-row">
                                    <?php if (isset($result)) { ?>
                                        <div class="col-lg-12">
                                            <div class="alert alert-<?php echo $resultSuccess ? "success" : "danger"; ?>"><?php echo $result; ?></div>
                                        </div>
                                    <?php } ?>
                                    <input type="hidden"  name="Id" value="<?php echo $Id; ?>">
                                    <input type="hidden"  name="Id" value="<?php echo $UserType; ?>">

                                    <div class="col-md-3  ">
                                        <div class="form-label-group">
                                            <input type="password" id="Password" name="Password" class="form-control"  required="required" placeholder="كلمة المرور" >
                                            <label for="Password">كلمة المرور</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3  ">
                                        <div class="form-label-group">
                                            <input type="password" id="PasswordConfirm" name="PasswordConfirm" class="form-control" required="required" placeholder="تأكيد كلمة المرور" >
                                            <label for="PasswordConfirm">تأكيد كلمة المرور</label>
                                        </div>
                                    </div> 
                                </div> 
                            </div>


                        </div>   
                    </div>
                </div>
            </div>     </form>

        <!-- Footer Here -->
        <?php
        include 'Shared/Footer.php';
        ?>

    </body>
</html>
