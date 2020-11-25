<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/Shared/Logic.php';

?>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/DbConnection.php';
$PageTitle = "البلاغات";
$OnPrint = false;
$type = 0;
if (isset($_GET["Export"])) {
    $OnPrint = true;
    ob_start();
    include( $_SERVER['DOCUMENT_ROOT'] . '/admin/ReportsTbl.php');
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

        function limit_text($text, $limit) {
            if (strlen($text) > $limit) {

                $text = substr($text, 0, $limit) . '...';
            }
            return $text;
        }
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
                        <div class="pull-right">
                            <a class="btn btn-success" target="_blank" href="/admin/reports2.php?type=<?php echo $type; ?>&Export=excel"><i class="fa fa-file-word"></i> EXCEL</a>  
                            <a class="btn btn-info" target="_blank" href="/admin/reports2.php?type=<?php echo $type; ?>&Export=word"><i class="fa fa-file-excel"></i> WORD</a>
                            <button class="btn btn-danger" type="button" onclick="DeleteAll();"><i class="fa fa-times-circle"></i> حذف الكل</button> 
                        </div>
                        <div class="pull-left">
                            <h2><i class="fa fa-copy"></i>
                                <?php echo $PageTitle; ?></h2>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/ReportsTbl.php'; ?>
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
                InitDataTable('.ReportTbl');
            });
            function DeleteReport(e, id) {
                swal({
                    title: 'تأكيد الحذف',
                    text: 'هل انت متأكد انك تريد حذف هذا البلاغ؟',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "نعم",
                    cancelButtonText: "لا",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, (function () {
                    $.ajax({
                        url: "/api.php/Delete_Report",
                        type: "POST",
                        datatype: "json",
                        beforeSend: function (request) {
                            request.setRequestHeader("Id", id);
                        },
                        data: {Id: id},
                        success: function (data) {
                            debugger;
                            DestroyDataTable('.ReportTbl');
                            $(e).closest('tr').remove();
                            InitDataTable('.ReportTbl');
                            swal("تم الحذف");
                        },
                        error: function (ex) {
                            debugger;
                        }
                    });

                }));
            }
            function DeleteAll() {
                swal({
                    title: 'تأكيد الحذف',
                    text: 'هل انت متأكد انك تريد حذف كل البلاغات؟',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "نعم",
                    cancelButtonText: "لا",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, (function () {
                    $.ajax({
                        url: "/api.php/Delete_All_Reports",
                        type: "POST",
                        datatype: "json",
                        success: function () {
                            window.location.reload();
                        },
                        error: function (ex) {
                        }
                    });

                }));
            }
        </script>
    </body>
</html>
