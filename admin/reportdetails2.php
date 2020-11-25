<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/Shared/Logic.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        $PageTitle = "تفاصيل البلاغ";
        include 'Shared/Head.php';
        ?>
    </head>
    <body  id="page-top">
        <?php include 'Shared/Nav.php'; ?>
        <div id="wrapper">
            <!-- Menu Here -->
            <?php
            include 'Shared/Menu.php';
            if (isset($_GET["id"])) {
                $report = GetDetailsOfReport($_GET["id"]);
                $DoneDescription = "";
//                if (count($report->CompletionImages) > 0) {
//                    $DoneDescription = $report->CompletionImages[0]->Description;
//                }
            }
            ?>
            <div id="content-wrapper"> 
                <div class="container-fluid">
                    <!--content here-->
                    <div class="page-head">
                        <div class="pull-right">
                            <a class="btn btn-success" href="/admin/reports2.php"><i class="fa fa-reply"></i></a>

                        </div>
                        <div class="pull-left">
                            <h2><i class="fa fa-copy"></i>
                                <?php echo $PageTitle; ?></h2>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-3">
                                <div>الطلب</div>
                                <div style="word-break:break-all"><?php echo $report->ReportText; ?></div> 
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div>صاحب الطلب</div>
                                <div><?php echo $report->CreatedBy_Name; ?></div> 
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div>فريق الصيانة</div>
                                <div><?php echo $report->MaintenanceTeam_Name; ?></div> 
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div>الحالة</div>
                                <div><?php echo $ReportStatus[$report->ReportStatus]; ?></div> 
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div>الاهمية</div>
                                <div><?php echo $Importances[$report->Importance]; ?></div> 
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <h3>صور الطلب</h3>
                            </div>
                            <?php foreach ($report->Images as $img) { ?>
                                <div class="col-lg-3 col-md-3">
                                    <a href="<?php echo $img; ?>" target="_blank">
                                        <img class="Img" src="<?php echo $img; ?>"/>
                                    </a>
                                </div>
                            <?php } ?>
                            <div class="clearfix"></div>
                            <div class="col-lg-12 col-md-12">
                                <h3> اكتمال الطلب</h3> 

                                <?php foreach ($report->CompletionHistory as $history) { ?>
                                    <h5>رسالة اكتمال الطلب :<?php echo $history["Message"]; ?></h5>
                                    <div class="row">
                                        <?php 
                                        foreach ($history["photos"] as $img) { ?>
                                            <div class="col-lg-3 col-md-3">
                                                <a href="<?php echo $img; ?>" target="_blank">
                                                    <img class="Img" src="<?php echo $img; ?>"/>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div><div class="clearfix"></div>
                                    <?php
                                    $msg = $history["AcceptMessage"] == "" ? "رسالة الرفض : " . $history["RejectMessage"] : "رسالة القبول : " . $history["AcceptMessage"];
                                    echo $msg;
                                }
                                ?>

                            </div>
                        </div>   
                    </div>   
                </div>
            </div>
        </div>

        <!-- Footer Here -->
        <?php
        include 'Shared/Footer.php';
        ?>
        <style>
            .Img{
                width:100%;
                height:200px;
            }
        </style>
    </body>
</html>
