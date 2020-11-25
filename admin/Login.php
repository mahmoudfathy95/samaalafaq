<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/DbConnection.php';
$PageTitle = "Login";
include 'Shared/Head.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/UserLogic.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/ReportLogic.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/FireBase.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/BuildingLogic.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/PeriodicReportLogic.php';


if (isset($_POST['email']) && isset($_POST['password'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $result = AdminLogin($email, $password);
    if ($result != null) {
        ob_start();
        session_start();
        $_SESSION["UserId"] = $result->Id;
        $_SESSION["Name"] = $result->Name;
        
        //$arr = ["a" => $_SESSION["UserId"]];
        //return var_dump($arr);
        
        redirect('/admin/index4.php');
        //redirect('/admin/test2.php');
    } else {

        $MessageResult = "البريد الالكتروني او كلمة المرور غير صحيحة";
        
        //$arr = ["a" => $_SESSION["test"]];
        //return var_dump($arr);
        
        redirect('/admin/test.php');
    }
}
?>
<!DOCTYPE html>
<html>
    <head>

    </head>
    <body class="bg-dark" style="direction: rtl;text-align: right">
        <div class="container">
            <div class="card card-login mx-auto mt-5">
                <div class="card-header">تسجيل الدخول</div>
                <div class="card-body">
                    <form  method="Post" action="<?php $_PHP_SELF ?>" role="form" novalidate="novalidate">
                        <?php
                        if (isset($MessageResult)) {
                            echo ' <div class="alert alert-danger" id="contactError">
                            <p><strong>البريد الالكتروني او كلمة المرور غير صحيحة</strong></p>   من فضلك حاول مرة اخرى
                        </div>';
                        }
                        ?>
                        <div class="form-group">
                            <div class="form-label-group">
                                <input type="email" id="inputEmail" name="email" class="form-control" placeholder="البريد الالكتروني/اسم الدخول" required="required" autofocus="autofocus">
                                <label for="inputEmail">البريد الالكتروني/اسم الدخول</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <input type="password" id="inputPassword" name="password" class="form-control" placeholder="كلمة المرور" required="required">
                                <label for="inputPassword">كلمة المرور</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <!--                                <label>
                                                                    <input type="checkbox" value="remember-me">
                                                                    Remember Password
                                                                </label>-->
                                &nbsp;
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">تسجيل دخول</button>
                    </form>
                    <!--                    <div class="text-center">
                                            <a class="d-block small mt-3" href="register.html">Register an Account</a>
                                            <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
                                        </div>-->
                </div>
            </div>
        </div>

    </body>
</html>
