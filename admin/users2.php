<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/Shared/Logic.php';

?>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/DbConnection.php';
$UserType = $_GET["type"];
if ($UserType == 0) {
    $PageTitle = "المديرين";
}
if ($UserType == 1) {
    $PageTitle = "المبنى التعليمي";
}
if ($UserType == 2) {
    $PageTitle = "مستقبلين البلاغات";
}
if ($UserType == 3) {
    $PageTitle = "فرق الصيانة";
}
if ($UserType == 4) {
    $PageTitle = "مطلعين الجودة والإدارة";
}
$OnPrint = false;
if (isset($_GET["Export"])) {
    $OnPrint = true;
    ob_start();
    include( $_SERVER['DOCUMENT_ROOT'] . '/admin/UsersTbl.php');
    $Tbl = ob_get_contents();
    ob_end_clean();
    if ($_GET["Export"] == "word") {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=" . $PageTitle . ".doc");
    } else {
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;Filename=" . $PageTitle . ".xls");
    }
    echo $Tbl;
    return;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        include 'Shared/Head.php';
        ?>
    </head>
    <body  id="page-top">
        <?php include 'Shared/Nav.php'; ?>
        <div id="wrapper">
            <!-- Menu Here -->
            <?php
            include 'Shared/Menu.php';
            ?>
            <div id="content-wrapper"> 
                <div class="container-fluid">
                    <!--content here-->
                    <div class="page-head">
                        <div class="pull-right">     <a class="btn btn-success" href="/admin/useraddedit2.php?type=<?php echo $UserType; ?>"><i class="fa fa-plus"></i> إضافة جديد</a> 

                            <a class="btn btn-info" target="_blank" href="/admin/users2.php?type=<?php echo $UserType; ?>&Export=word"><i class="fa fa-file-excel"></i> WORD</a>
                            <a class="btn btn-success" target="_blank" href="/admin/users2.php?type=<?php echo $UserType; ?>&Export=excel"><i class="fa fa-file-word"></i> EXCEL</a>  

                        </div>
                        <div class="pull-left">
                            <h2><i class="fa fa-users"></i>
<?php echo $PageTitle; ?></h2>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/UsersTbl.php'; ?>
                        </div>
                    </div>   
                </div>
            </div>
        </div>

        <!-- Footer Here -->
<?php
include 'Shared/Footer.php';
?>
        <script>
            $(document).ready(function () {
                InitDataTable('.userTbl');
            });
            function DeleteUser(e, id) {
                swal({
                    title: 'تأكيد الحذف',
                    text: 'هل انت متأكد انك تريد حذف هذا المستخدم؟',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "نعم",
                    cancelButtonText: "لا",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, (function () {
                    $.ajax({
                        url: "/api.php/Delete_User",
                        type: "POST",
                        datatype: "json",
                        beforeSend: function (request) {
                            request.setRequestHeader("Id", id);
                        },
                        data: {Id: id},
                        success: function (data) {
                            DestroyDataTable('.userTbl');
                            $(e).closest('tr').remove();
                            InitDataTable('.userTbl');
                            swal("تم الحذف");
                        },
                        error: function (ex) {
                        }
                    });

                }));
            }
        </script>
    </body>
</html>
