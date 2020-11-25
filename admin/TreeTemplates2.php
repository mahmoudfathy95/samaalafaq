<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/Shared/Logic.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        
        $PageTitle = "قوالب الصيانة";
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
                        <div class="pull-right">     
                            <a class="btn btn-success" href="/admin/treetemplateaddedit2.php"><i class="fa fa-plus"></i> إضافة جديد</a> 

                        </div>
                        <div class="pull-left">
                            <h2><i class="fa fa-wrench"></i>
                                <?php echo $PageTitle; ?></h2>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="MaintenanceTreeTbl table table-bordered" dir="rtl" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>الاسم</th> 
                                        <th class="printDelete">تعديل</th>
                                        <th class="printDelete">حذف</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/Shared/Logic.php';
                                    $MaintenanceTrees = GetMaintenanceTemplates();
                                    foreach ($MaintenanceTrees as $MaintenanceTree) {
                                        ?>
                                        <tr>
                                            <td><?php echo $MaintenanceTree["TemplateName"]; ?></td>  

                                            <td class="printDelete text-center"><a class="btn btn-info"  href="/admin/treetemplateaddedit2.php?id=<?php echo $MaintenanceTree["Id"]; ?>"><i class="fa fa-pencil-alt"></i></a></td>
                                            <td class="printDelete text-center"><button class="btn btn-danger" onclick="DeleteMaintenanceTree(this,<?php echo $MaintenanceTree["Id"]; ?>)"><i class="fa fa-times"></i></button></td>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

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
                InitDataTable('.MaintenanceTreeTbl');
            });
            function DeleteMaintenanceTree(e, id) {
                swal({
                    title: 'تأكيد الحذف',
                    text: 'هل انت متأكد انك تريد حذف هذا القالب؟',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "نعم",
                    cancelButtonText: "لا",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, (function () {
                    $.ajax({
                        url: "/api.php/DeleteMaintenanceTreeTemplate",
                        type: "POST",
                        datatype: "json",
                        beforeSend: function (request) {
                            request.setRequestHeader("Id", id);
                        },
                        data: {Id: id},
                        success: function (data) { 
                            DestroyDataTable('.MaintenanceTreeTbl');
                            $(e).closest('tr').remove();
                            InitDataTable('.MaintenanceTreeTbl');
                            swal("تم الحذف");
                        },
                        error: function (ex) {
                            debugger;
                        }
                    });

                }));
            }
        </script>
    </body>
</html>
