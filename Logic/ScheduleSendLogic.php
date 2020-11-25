<?php

$_SERVER['DOCUMENT_ROOT'] = dirname(__FILE__);

include_once $_SERVER['DOCUMENT_ROOT'] . '/DbConnection.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/UserLogic.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/BuildingLogic.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/PeriodicReportLogic.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/FireBase.php';

$db = new DbConnection();
//Get Unsent Periodic Reports
$Reports = GetUnSentPeriodicReports();
foreach ($Reports as $report) {

    //Send Notification Of Periodic Report 
    $NotificationMsg = "بلاغ دوري جديد رقم " . $params->ReportId;
    //SendToPeriodicReportReceivers("لقد تم تعديل حالة البلاغ", $NotificationMsg, $params->ReportId, 4, $params->ReportStatus);
    SendFireBaseNotification($report->TeamId, $params->ReportId, "يوجد بلاغ دوري جديد", $NotificationMsg, $params->ReportStatus);
    SendFireBaseNotification($report->BuildingId, $params->ReportId, "يوجد بلاغ دوري جديد", $NotificationMsg, $params->ReportStatus);
    $users = GetBuildingSupervisors($report->BuildingId);
    foreach ($users as $user) {
        SendFireBaseNotification($user, $params->ReportId, "يوجد بلاغ دوري جديد", $NotificationMsg, $params->ReportStatus);
    }
    $query = "UPDATE `periodicreport` SET `IsSent`=1 , `ReportStatus`=1 where Id=?";
    $result = $db->RunQuery($query, array($report->Id));
}

$txt = "Cron run Succesfully at " . date("Y-m-d h:i:sa") . ' ' . count($Reports) . ' Sent.';
$myfile = file_put_contents('Cronlogs.txt', $txt . PHP_EOL, FILE_APPEND | LOCK_EX);
?>