<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/Shared/Logic.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        $PageTitle = "المستخدم";
        include 'Shared/Head.php';
        ?>
    </head>
    <body  id="page-top">
        <?php include 'Shared/Nav.php'; 
        include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/FilesUploading.php';?>
        <form enctype="multipart/form-data"  method="Post" action="<?php $_PHP_SELF ?>" role="form"  >
            <div id="wrapper">
                <!-- Menu Here -->
                <?php
                include 'Shared/Menu.php';
                $Maplnk = "";
                $result;
                $resultSuccess = false;
                if (isset($_GET["id"]) || isset($_POST["id"])) {
                    $PageTitle = "تعديل ";
                    $id = $_GET["id"];
                    $user = GetUserById($id);
                    $UserType = $user->UserType;
                }
                if (isset($_POST["Email"])) {

                    if (IsEmailUsed($_POST["Email"], $_POST["Id"])) {
                        $result = "البريد الالكتروني مستخدم من قبل";
                    } else if (IsMobileUsed($_POST["Mobile"], $_POST["Id"])) {
                        $result = "الجوال مستخدم من قبل";
                    } else if (IsUserNameUsed($_POST["UserName"], $_POST["Id"])) {
                        $result = "اسم الدخول مستخدم من قبل";
                    } else {
                        $user = new User();
                        $user->Name = $_POST["Name"];
                        $user->UserName = $_POST["UserName"];
                        $user->Email = $_POST["Email"];
                        $user->Mobile = $_POST["Mobile"];
                        $user->BuildingAddress = $_POST["BuildingAddress"];
                        $user->MinistryNumber = $_POST["MinistryNumber"];
                        $user->JobNumber = $_POST["JobNumber"];
                        $user->IdentityNumber = $_POST["IdentityNumber"];
                        $user->TeamType = $_POST["TeamType"];
                        $user->SupervisorName = $_POST["SupervisorName"];
                        $user->Job = $_POST["Job"];
                        $user->UserType = $_POST["UserType"];
                        $user->lat = $_POST["lat"];
                        $user->lang = $_POST["lang"];
                         
                        $user->PdfPath =UploadFile($_POST["PdfPath"]);
                        $UserType = $user->UserType;
                        $user->Id = $_POST["Id"];
                        if ($_POST["Id"] != "0" && $_POST["Id"] != "") {
                            UpdateUser($user);
                            $resultSuccess = true;
                        } else {
                            if (isset($_POST["Password"]) && isset($_POST["PasswordConfirm"])) {
                                if ($_POST["Password"] == $_POST["PasswordConfirm"]) {
                                    $user->Password = $_POST["Password"];
                                    $user->Id = InsertUser($user);
                                    $resultSuccess = true;
                                } else {
                                    $result = "كلمة المرور غير متطابقة";
                                }
                            } else {
                                $result = "من فضلك ادخل كلمة المرور";
                            }
                        }
                        if ($resultSuccess) {
                            if ($UserType == 1) {
//update Receivers
                                if (isset($_POST["ReportReceivers"])) {
                                    DeleteBuildingsReceivers($user->Id);
                                    foreach ($_POST["ReportReceivers"] as $ReportReceivers) {
                                        InsertBuildingReportReceivers($user->Id, $ReportReceivers);
                                    }
                                }
                                //update Supervisors
                                if (isset($_POST["Supervisors"])) {
                                    DeleteBuildingsSupervisors($user->Id);
                                    foreach ($_POST["Supervisors"] as $Supervisor) {
                                        InsertBuildingSupervisors($user->Id, $Supervisor);
                                    }
                                }
                            }
                            if ($UserType == 2) {
//update Receivers
                                if (isset($_POST["ReceiverTeams"])) {
                                    DeleterecieverTeams($user->Id);
                                    foreach ($_POST["ReceiverTeams"] as $ReceiverTeam) {
                                        InsertRecieverTeams($user->Id, $ReceiverTeam);
                                    }
                                }
                            }
                            $result = "تم الحفظ";
                        }
                    }
                }

                if (isset($_GET["type"]) || isset($_POST["type"])) {
                    $PageTitle = "إضافة ";
                    $UserType = $_GET["type"];
                }

                if (!isset($user)) {
                    $user = new User ();
                }
                if ($UserType == 0) {
                    $PageTitle .= "مدير";
                }
                if ($UserType == 1) {
                    $PageTitle .= "مبنى التعليمي";
                }
                if ($UserType == 2) {
                    $PageTitle .= "مستقبل البلاغات";
                }
                if ($UserType == 3) {
                    $PageTitle .= "فريق الصيانة";
                }
                if ($UserType == 4) {
                    $PageTitle .= "مطلع الجودة والإدارة";
                }
                ?>
                <div id="content-wrapper"> 
                    <div class="container-fluid">
                        <!--content here-->
                        <div class="page-head">
                            <div class="pull-right">      

                                <button class="btn btn-info" type="submit"><i class="fa fa-save"></i>  حفظ</button>
                                <a class="btn btn-warning" href="/admin/useraddedit2.php?type=<?php echo $UserType; ?>"><i class="fa fa-plus-circle"></i> جديد  </a>
                                <a class="btn btn-success" href="/admin/users2.php?type=<?php echo $UserType; ?>"><i class="fa fa-reply"></i></a>


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
                                            <div class="alert alert-<?php if ($resultSuccess) {
                                        echo 'info';
                                    } else {
                                        echo'danger';
                                    } ?>"><?php echo $result; ?></div>
                                        </div>
    <?php
}
?>
                                    <div class="col-md-3">
                                        <div class="form-label-group">
                                            <input type="text" id="Name" name="Name" class="form-control" placeholder="الاسم" required="required" value="<?php echo $user->Name; ?>">
                                            <label for="Name">الاسم</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="hidden"  name="Id" value="<?php echo $user->Id; ?>">

                                        <input type="hidden"  name="UserType" value="<?php echo $UserType; ?>">

                                        <div class="form-label-group">
                                            <input type="email" id="Email" name="Email" class="form-control" placeholder="البريد الالكتروني"  required="required" value="<?php echo $user->Email; ?>">
                                            <label for="Email">البريد الالكتروني</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-label-group">
                                            <input type="text" id="UserName" name="UserName" class="form-control" placeholder="اسم الدخول" value="<?php echo $user->UserName; ?>">
                                            <label for="UserName">اسم الدخول</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-label-group">
                                            <input type="text" id="Mobile" name="Mobile" class="form-control" placeholder="الجوال" value="<?php echo $user->Mobile; ?>">
                                            <label for="Mobile">الجوال</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 AddOnly">
                                        <div class="form-label-group">
                                            <input type="password" id="Password" name="Password" class="form-control"  placeholder="كلمة المرور" >
                                            <label for="Password">كلمة المرور</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 AddOnly">
                                        <div class="form-label-group">
                                            <input type="password" id="PasswordConfirm" name="PasswordConfirm" class="form-control"   placeholder="تأكيد كلمة المرور" >
                                            <label for="PasswordConfirm">تأكيد كلمة المرور</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 condView CondView1">
                                        <div class="form-label-group">
                                            <input type="text" id="BuildingAddress" name="BuildingAddress" class="form-control" placeholder="عنوان المبنى" value="<?php echo $user->BuildingAddress; ?>">
                                            <label for="BuildingAddress">عنوان المبنى</label>
                                        </div>
                                    </div>

                                    <div class="col-md-3 condView CondView1">
                                        <div class="form-label-group">
                                            <input type="text" id="MinistryNumber" name="MinistryNumber" class="form-control" placeholder="الرقم الوزاري" value="<?php echo $user->MinistryNumber; ?>">
                                            <label for="MinistryNumber">الرقم الوزاري</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 condView CondView1">
                                        <div class="form-label-group">
                                            <input type="text" id="lang" name="lang" class="form-control" value="<?php echo $user->lang; ?>">
                                            <label for="MinistryNumber">Map Latitude</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 condView CondView1">
                                        <div class="form-label-group">
                                            <input type="text" id="lat" name="lat" class="form-control" value="<?php echo $user->lat; ?>">
                                            <label for="MinistryNumber">Map Longitude</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 condView CondView1">
                                        <div class="form-label-group">
                                            <input type="file" id="fileuploader" name="fileuploader" class="form-control" style="width: 80%;display: inline-block;">
                                            <input type="hidden" id="PdfPath" name="PdfPath" class="form-control" value="<?php echo $user->PdfPath; ?>">
                                            <label for="PdfPath">PDF</label>
                                            <?php if(isset($user->PdfPath)&&$user->PdfPath!=""){?>
                                            <a class="btn btn-info" target="_blank"  href="<?php echo $user->PdfPath;?>" ><i class='fa fa-file-pdf'></i></a>
                                            <?php }?>
                                        </div>
                                    </div>



                                    <div class="col-md-3 condView CondView2">
                                        <div class="form-label-group">
                                            <input type="text" id="IdentityNumber" name="IdentityNumber" class="form-control" placeholder="رقم الهوية" value="<?php echo $user->IdentityNumber; ?>">
                                            <label for="IdentityNumber">رقم الهوية</label>
                                        </div>
                                    </div>


                                    <div class="col-md-4 condView CondView3">
                                        <div class="form-label-group">
                                            <div class="row">
                                                <div class="col-md-4" style="text-align: center;    padding-top: 14px;">
                                                    نوع الفريق </div>
                                                <div class="col-md-8">
                                                    <select class="form-control" name="TeamType" style="height: 50px;">
                                                        <?php
                                                        $Teams = GetTeamTypes();
                                                        foreach ($Teams as $Team) {
                                                            echo '<option value="' . $Team["Id"] . '">' . $Team["Name"] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div></div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 condView CondView3">
                                        <div class="form-label-group">
                                            <input type="text" id="SupervisorName" name="SupervisorName" class="form-control" placeholder="اسم المشرف" value="<?php echo $user->SupervisorName; ?>">
                                            <label for="SupervisorName">اسم المشرف</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 condView CondView3 CondView2">
                                        <div class="form-label-group">
                                            <input type="text" id="JobNumber" name="JobNumber" class="form-control" placeholder="الرقم الوظيفي" value="<?php echo $user->JobNumber; ?>">
                                            <label for="JobNumber">الرقم الوظيفي</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 condView CondView4">
                                        <div class="form-label-group">
                                            <input type="text" id="Job" name="Job" class="form-control" placeholder="الوظيفة" value="<?php echo $user->Job; ?>">
                                            <label for="Job">الوظيفة</label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>

                                    <?php
                                    if ($UserType == 1) {
                                        if ($user->Id > 0) {
                                            $BuildingReceivers = GetBuildingReceivers($user->Id);
                                            $BuildingSupervisors = GetBuildingSupervisors($user->Id);
                                        } else {
                                            $BuildingReceivers = [];
                                            $BuildingSupervisors = [];
                                        }
                                        echo '<div class="col-lg-12"><h3>مستقبلين البلاغات</h1></div>';
                                        $ReportReceivers = GetUsersFilterByType(2);
                                        foreach ($ReportReceivers as $ReportReceiver) {
                                            if (in_array($ReportReceiver->Id, $BuildingReceivers)) {
                                                $checked = "checked='checked'";
                                            } else {
                                                $checked = "";
                                            }
                                            echo '<label class="col-lg-3"><input type="checkbox" name="ReportReceivers[]" ' . $checked . ' value="' . $ReportReceiver->Id . '" />' . $ReportReceiver->Name . '</label>';
                                        }
                                        echo '<div class="col-lg-12"><h3>مشرفين الجودة</h1></div>';
                                        $Supervisors = GetUsersFilterByType(4);
                                        foreach ($Supervisors as $Supervisor) {
                                            if (in_array($Supervisor->Id, $BuildingSupervisors)) {
                                                $checked = "checked='checked'";
                                            } else {
                                                $checked = "";
                                            }
                                            echo '<label class="col-lg-3"><input type="checkbox" name="Supervisors[]" ' . $checked . ' value="' . $Supervisor->Id . '" />' . $Supervisor->Name . '</label>';
                                        }
                                    }

                                    if ($UserType == 2) {
                                        if ($user->Id > 0) {
                                            $ReceiverTeams = GetRecieverTeams($user->Id);
                                        } else {
                                            $ReceiverTeams = [];
                                        }
                                        echo '<div class="col-lg-12"><h3>فرق الصيانة</h1></div>';
                                        $teams = GetUsersFilterByType(3);
                                        foreach ($teams as $team) {
                                            if (in_array($team->Id, $ReceiverTeams)) {
                                                $checked = "checked='checked'";
                                            } else {
                                                $checked = "";
                                            }
                                            echo '<label class="col-lg-3"><input type="checkbox" name="ReceiverTeams[]" ' . $checked . ' value="' . $team->Id . '" />' . $team->Name . '</label>';
                                        }
                                    }
                                    ?>
                                </div> 
                            </div>


                        </div>   
                    </div>
                </div>
            </div>     </form>
        <style>
            .condView{
                display:none;
            }
            .CondView<?php echo $UserType; ?>{
                display:table-cell !important
            }
            .form-row > .col, .form-row > [class*="col-"]{
                padding: 5px;
            }
            <?php if ($user->Id != 0) { ?>
                .AddOnly{
                    display:none;
                }
        <?php } ?>
        </style>
        <!-- Footer Here -->
<?php
include 'Shared/Footer.php';
?>
        <script>
            $(document).ready(function () {
                $("title").text('Sama Al Afaq - <?php echo $PageTitle; ?>');

            });
        </script>

    </body>
</html>
