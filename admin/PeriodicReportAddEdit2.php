<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/Shared/Logic.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        $PageTitle = "اضافة بلاغ دوري";
        include 'Shared/Head.php';
        ?>
    </head>
    <body  id="page-top">
        <?php
        include 'Shared/Nav.php';
        include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/FilesUploading.php';
        ?>
        <form  method="Post" enctype="multipart/form-data"   action="<?php $_PHP_SELF ?>" role="form"  >
            <div id="wrapper">
                <!-- Menu Here -->
                <?php
                include 'Shared/Menu.php';
                $report = new PeriodicReport();
                $report->SendDate = time();
                $result;
                $resultSuccess = false;

                if (isset($_POST["Id"])) {
                    $report->BuildingId = $_POST["BuildingId"];
                    $report->TeamId = $_POST["TeamId"];
                    $report->ReportStatus = $_POST["ReportStatus"];
                    $report->PdfPath = UploadFile($_POST["PdfPath"]);
                    $report->TemplateId = $_POST["TemplateId"];
                    $report->SendDate = $_POST["SendDate"];
                    $report->Id = $_POST["Id"];
                    if ($_POST["Id"] != "0" && $_POST["Id"] != "") {
                        UpdatePeriodicReport($report);
                        $resultSuccess = true;
                    } else {
                        AddPeriodicReport($report);
                        $resultSuccess = true;
                    }
                    if ($resultSuccess) {
                        $result = "تم الحفظ";
                    }
                }
                if (isset($_GET["id"]) || isset($_POST["id"])) {
                    $PageTitle = "تعديل بلاغ دوري";
                    $id = $_GET["id"];
                    $report = GetPeriodicReportById($id);
                }
                ?>
                <div id="content-wrapper"> 
                    <div class="container-fluid">
                        <!--content here-->
                        <div class="page-head">
                            <div class="pull-right">     
                                <button class="btn btn-info" type="submit"><i class="fa fa-save"></i>  حفظ</button>
                                <a class="btn btn-warning" href="/admin/PeriodicReportAddEdit2.php"><i class="fa fa-plus-circle"></i> جديد  </a>
                                <a class="btn btn-success" href="/admin/PeriodicReports2.php"><i class="fa fa-reply"></i></a>
                            </div>
                            <div class="pull-left">
                                <h2><i class="fa fa-file-signature"></i>
                                    <?php echo $PageTitle; ?></h2>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="card-body"> 
                            <div class="form-group">
                                <input type="hidden" id="Id" name="Id" class="form-control" value="<?php echo $report->Id; ?>"> 
                                <div class="form-row">
                                    <?php if (isset($result)) { ?>
                                        <div class="col-lg-12">
                                            <div class="alert alert-info"><?php echo $result; ?></div>
                                        </div>
                                    <?php } ?> 
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-4">
                                                المبنى 
                                                <div class="">
                                                    <select class="form-control" name="BuildingId" style="height: 50px;">
                                                        <?php
                                                        $buildings = GetUsersFilterByType(1);

                                                        foreach ($buildings as $building) {
                                                            $selected = $building->Id == $report->BuildingId ? "selected='selected'" : "";

                                                            echo '<option ' . $selected . ' value="' . $building->Id . '">' . $building->Name . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div> 
                                            </div>
                                            <div class="col-md-4">
                                                الفريق 
                                                <div class="">
                                                    <select class="form-control" name="TeamId" style="height: 50px;">
                                                        <?php
                                                        $teams = GetUsersFilterByType(3);

                                                        foreach ($teams as $Team) {
                                                            $selected = $Team->Id == $report->TeamId ? "selected='selected'" : "";

                                                            echo '<option ' . $selected . ' value="' . $Team->Id . '">' . $Team->Name . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div> 
                                            </div>
                                            <div class="col-md-4">
                                                قالب الصيانات 
                                                <div class="">   <input type="hidden" name="TemplateId"/>
                                                    <select <?php echo $report->Id != 0 && $report->Id != null ? 'disabled="disabled"' : ""; ?> class="form-control" name="TemplateId" style="height: 50px;">
                                                        <?php
                                                        $templates = GetMaintenanceTemplates();

                                                        foreach ($templates as $template) {
                                                            $selected = $template["Id"] == $report->TemplateId ? "selected='selected'" : "";

                                                            echo '<option ' . $selected . ' value="' . $template["Id"] . '">' . $template["TemplateName"] . '</option>';
                                                        }
                                                        ?>
                                                    </select>

                                                </div>  
                                            </div>
                                            <div class="col-md-4 condView CondView1">
                                                PDF
                                                <div class="form-label-group">
                                                    <input type="file" id="fileuploader" name="fileuploader" class="form-control" style="width: 80%;display: inline-block;">
                                                    <input type="hidden" id="PdfPath" name="PdfPath" class="form-control" value="<?php echo $report->PdfPath; ?>"> 
                                                    <?php if (isset($report->PdfPath) && $report->PdfPath != "") { ?>
                                                        <a class="btn btn-info" target="_blank"  href="<?php echo $report->PdfPath; ?>" ><i class='fa fa-file-pdf'></i></a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                &nbsp;
                                                <div class="form-label-group">
                                                    <input type="hidden" id="SendDate" name="SendDate" class="form-control" placeholder="الاسم"   value="<?php echo $report->SendDate; ?>">

                                                    <input type="text" id="SendDateCalendat" class="form-control" placeholder="الاسم"  value="<?php echo date("m/d/Y", $report->SendDate); ?>" required="required">
                                                    <label for="SendDateCalendat">تاريخ الارسال</label>
                                                </div>
                                            </div> 
                                            <div class="col-md-4">
                                                حالة البلاغ
                                                <div class="">
                                                    <select  class="form-control" name="ReportStatus" style="height: 50px;">
                                                        <?php
                                                        for ($i = 0; $i < count($PeriodicReportsStatus); $i++) {
                                                            $selected = $i == $report->ReportStatus ? "selected='selected'" : "";
                                                            echo '<option ' . $selected . ' value="' . $i . '">' . $PeriodicReportsStatus[$i] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>  
                                            </div>
                                        </div> 
                                    </div> 
                                    <div class="col-md-4">
                                        <div class="tree">
                                            <ul id="TreeRoot"></ul> 
                                        </div>
                                    </div>       
                                </div>     

                            </div> 
                        </div>   
                    </div>
                </div>
            </div>     
        </form>

        <!-- Footer Here -->
        <?php
        include 'Shared/Footer.php';
        ?>
        <link href="jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        <script src="jquery-ui/jquery-ui.min.js" type="text/javascript"></script>


        <script>
            $(document).ready(function () {
                $ReportId = '<?php echo $report->Id ?>';
                $("#SendDateCalendat").datepicker({
                    onSelect: function () {
                        var selecteddate = $('#SendDateCalendat').datepicker("getDate");
                        selecteddate.setDate(selecteddate.getDate() + 1);
                        selecteddate = Math.floor(selecteddate / 1000);
                        $('#SendDate').val(selecteddate);
                    }
                });
                $("title").text('Sama Al Afaq - <?php echo $PageTitle; ?>');
                var treeview = $('.tree').jstree({
                    "core": {
                        "multiple": false,
                        "check_callback": true,
                    }, "checkbox": {
                        "keep_selected_style": false
                    },
                    "plugins": [
                        "checkbox",
                    ]
                });
                if ($ReportId != "") {
                    $.ajax({
                        url: "/api.php/GetPeriodReportMaintenanceStatus",
                        type: "Post",
                        datatype: "json",
                        data: {ReportId: $ReportId},
                        success: function (data) {
                            data = JSON.parse(data);
                            $(data).each(function (i, c) {
                                var ParentId = c.ParentId;
                                if (ParentId == "" || ParentId == null)
                                    ParentId = "#";
                                var Title = c.Title;
                                if (c.Value == 1) {
                                    var date = new Date(c.UpdateDate * 1000).toLocaleString();
                                    ;
                                    Title = c.Title + " - " + date;
                                }
                                $('.tree').jstree().create_node(ParentId, {"id": c.Id, "text": Title, "state": {"checkbox_disabled": true}});
                                $('.tree').jstree("open_node", ParentId);

                            });
                            $(data).each(function (i, c) {
                                if (c.Value == 1) {
                                    $('.tree').jstree(true).select_node(c.Id);
                                }
                            })
                        }
                    });
                }
            });
        </script>
        <style>
            .jstree-default .jstree-clicked{
                background: inherit;
                border-radius: inherit;
                box-shadow: inherit;    
            }
        </style>
    </body>
</html>
