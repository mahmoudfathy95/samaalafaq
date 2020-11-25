<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/Shared/Logic.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        $PageTitle = "Home";
        include 'Shared/Head.php';
        ?>
    </head>
    <body  id="page-top">
        <?php include 'Shared/Nav.php'; ?>
        <div id="wrapper">
            <!-- Menu Here -->
            <?php
            /*
            include 'Shared/Menu.php';

            if (isset($_POST['email']) && isset($_POST['phone'])) {

                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $db = new DbConnection();
                $query = "update settings set email=?,phone=? where id=1";
                $db->RunQuery($query, [$email,$phone]);
                $MessageResult = 'تم تعديل بيانات الاتصال بشكل صحيح';
            }
            $query = "SELECT * from settings where id=1";
            $db = new DbConnection();
            $user = $db->SelectData($query, ['email']);
            */
            //echo count($test[0]);
            ?>
            <div class="container">
                <div class="card card-login mx-auto mt-5">
                    <div class="card-header">معلومات الاتصال</div>
                    <div class="card-body">
                        <form  method="Post" action="<?php $_PHP_SELF ?>" role="form" novalidate="novalidate">
                            <?php
                           // $r= SendFireBaseNotification2('fMZruliv9-o:APA91bGs60I0kBIQrQVFLHGyg9ACdqnCogg7I73rTf-_AfEUSh1foWBl1T_knXNFK6IcVKmC3-bSD_yYQmkfH27M3pgfdefPzIec7TIIig7pHR-c4gPHuK0W8EBzPgLOF29BRbEQCxCd', 'hi', 'msg', 1, 1,2);
                         // echo '<h1>'.$r.'</h1>';
                            if (isset($MessageResult)) {
                                echo ' <div class="alert alert-success">
                                           <p><strong>تم تعديل بيانات الاتصال بشكل صحيح</strong></p>
                                       </div>';
                            }
                            ?>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="email" id="inputEmail" name="email" value="<?php echo $user[0]['email'] ?>" class="form-control" placeholder="البريد الالكتروني/اسم الدخول" required="required" autofocus="autofocus">
                                    <label for="inputEmail">البريد الالكتروني للتواصل</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="text" id="inputPassword" name="phone" value="<?php echo $user[0]['phone'] ?>" class="form-control" placeholder="كلمة المرور" required="required">
                                    <label for="inputPassword">الرقم للتواصل</label>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-block" type="submit">حفظ المعلومات</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>


        <!-- Footer Here -->
        <?php
        include 'Shared/Footer.php';
        ?>

    </body>
</html>
