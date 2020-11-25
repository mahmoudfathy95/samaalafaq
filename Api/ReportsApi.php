<?php

function AddReport2() {
    extract($_POST);
    $error = array();
    $extension = array("jpeg", "jpg", "png", "gif");
    $base = "https://samaalafaq.com/media/";
    $currentUser = GetCurrentLoggedUser();
    if ($currentUser != null) {
        $CreatedBy = $currentUser->Id;
        $report = InsertReport($ReportText, $CreatedBy, $Importance, $lat, $lang, $Url);
        if ($report != null) {

            foreach ($_FILES["files"]["tmp_name"] as $key => $tmp_name) {
                $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/media/";
                $file_name = $_FILES["files"]["name"][$key];
                $file_tmp = $_FILES["files"]["tmp_name"][$key];
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                $currentDate = date('Y-m-d_H-i-s');

                if (in_array($ext, $extension)) {
                    if (!file_exists("media/" . $file_name)) {
                        $newFileName = $file_name;

                        move_uploaded_file($file_tmp = $_FILES["files"]["tmp_name"][$key], "media/" . $newFileName);
                        AddReportImage($report->Id, $base . $newFileName);
                    } else {
                        $filename = basename($file_name, $ext);
                        $newFileName = $file_name;
                        move_uploaded_file($file_tmp = $_FILES["files"]["tmp_name"][$key], "media/" . $newFileName);
                        AddReportImage($report->Id, $base . $newFileName);
                    }
                } else {
                    array_push($error, "$file_name, ");
                }
            }

            SendToReportReceivers("بلاغ جديد", "يوجد بلاغ جديد ", $report->Id, 4, 0);
            SendToReportReceivers("بلاغ جديد", "يوجد بلاغ جديد ", $report->Id, 2, 0);
            echo json_encode($report, JSON_UNESCAPED_UNICODE);
        } else {
            echo '{"result":"Failed"}';
        }
    }
}

function CompleteReport2() {
    //$Id, $files = [], $Description
    extract($_POST);
    $error = array();
    $extension = array("jpeg", "jpg", "png", "gif");
    $base = "https://samaalafaq.com/media/";

    $currentUser = GetCurrentLoggedUser();
    if ($currentUser != null) {
        $report = GetReportById($Id);

        $guidId = mt_rand(0, 65535);

        if ($report != null) {

            foreach ($_FILES["files"]["tmp_name"] as $key => $tmp_name) {
                $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/media/";
                $file_name = $_FILES["files"]["name"][$key];
                $file_tmp = $_FILES["files"]["tmp_name"][$key];
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                $currentDate = date('Y-m-d_H-i-s');

                if (in_array($ext, $extension)) {
                    if (!file_exists("media/" . $file_name)) {
                        $newFileName = $file_name;

                        move_uploaded_file($file_tmp = $_FILES["files"]["tmp_name"][$key], "media/" . $newFileName);
                        AddReportCompleteImage($Id, $base . $newFileName, $Description, $guidId);
                    } else {
                        $filename = basename($file_name, $ext);
                        $newFileName = $file_name;
                        move_uploaded_file($file_tmp = $_FILES["files"]["tmp_name"][$key], "media/" . $newFileName);
                        AddReportCompleteImage($Id, $base . $newFileName, $Description, $guidId);
                    }
                } else {
                    array_push($error, "$file_name, ");
                }
            }
            $report->ReportStatus = 2;
            UpdateReport($report);
            SendToReportReceivers("تم اكتمال البلاغ", "لقد تم اكتمال البلاغ رقم " . $report->Id, $report->Id, 2, 2);
            SendToReportReceivers("تم اكتمال البلاغ", "لقد تم اكتمال البلاغ رقم " . $report->Id, $report->Id, 4, 2);
            SendFireBaseNotification($report->CreatedBy, "تم اكتمال البلاغ", "لقد تم اكتمال البلاغ رقم " . $report->Id, $report->Id, 2);

            echo '{"result":"Done"}';
        } else {
            echo '{"result":"Report Not Found"}';
        }
    }
}

function UpdateReportStatus($params) {
    $currentUser = GetCurrentLoggedUser();
    if ($currentUser != null) {
        $report = GetReportById($params->Id);
        if ($report != null) {
            $report->ReportStatus = $params->ReportStatus;
            UpdateReport($report);
            InsertReportCompletionHistory($report->ReportStatus, $params->Id, $params->Message
                    , $currentUser->Id);
// Send notifications
            $NotificationMsg = "تم تعديل التقرير رقم " . $params->Id;
            SendToReportReceivers("لقد تم تعديل حالة البلاغ", $NotificationMsg, $params->Id, 4, $params->ReportStatus);
            SendFireBaseNotification($report->MaintenanceTeam, $report->Id, "لقد تم تعديل حالة البلاغ", $NotificationMsg, $params->ReportStatus);
            SendFireBaseNotification($report->CreatedBy, $report->Id, "لقد تم تعديل حالة البلاغ", $NotificationMsg, $params->ReportStatus);

            echo json_encode($report, JSON_UNESCAPED_UNICODE);
        } else {
            echo '{"result":"Report Not Found"}';
        }
    }
}

function RateReport($params) {
    $currentUser = GetCurrentLoggedUser();
    if ($currentUser != null) {
        $report = GetReportById($params->Id);
        if ($report != null) {
            $report->Rate = $params->Rate;
            $report->RateMessage = $params->RateMessage;
            $report->ReportStatus = 3;
            UpdateReport($report);
            SendToReportReceivers("لقد تم تقييم البلاغ رقم " . $report->Id, "لقد تم تقييم البلاغ", $report->Id, 2, 3);
            SendFireBaseNotification($report->MaintenanceTeam, "لقد تم تقييم البلاغ رقم " . $report->Id, "لقد تم تقييم البلاغ", $report->Id, 3);

            echo json_encode($report, JSON_UNESCAPED_UNICODE);
        } else {
            echo '{"result":"Report Not Found"}';
        }
    }
}

function GetReports($params) {
    error_reporting(0);
    ini_set('display_errors', 0);
    $currentUser = GetCurrentLoggedUser();
    if (!isset($params->BuildingId) || $params->BuildingId == null) {
        $params->BuildingId = 0;
    }
    if ($currentUser != null) {
        if ($params != null && $params->ReportStatus != null) {
            $reports = GetReportsOfUserFilterByStatus($params->ReportStatus, $currentUser->Id, $currentUser->UserType, $params->BuildingId);
            echo json_encode(PageArray($reports, $params->CurrentPage, $params->ItemPerPage), JSON_UNESCAPED_UNICODE);
        } else {
            $reports = GetReportsOfUser($currentUser->Id, $currentUser->UserType, $params->BuildingId);
            echo json_encode(PageArray($reports, $params->CurrentPage, $params->ItemPerPage), JSON_UNESCAPED_UNICODE);
        }
    }
}

function GetReportDetails($params) {
    //return array for images and done messages
    $currentUser = GetCurrentLoggedUser();
    if ($currentUser != null) {

        $report = GetDetailsOfReport($params->Id);
        echo json_encode($report, JSON_UNESCAPED_UNICODE);
    }
}

function ForwardReport($params) {
    $currentUser = GetCurrentLoggedUser();
    if ($currentUser != null) {
        $report = GetReportById($params->Id);
        if ($report != null) {
            $report->MaintenanceTeam = $params->MaintenanceTeam;
            $report->Importance = $params->Importance;
            $report->RedirectedBy = $currentUser->Id;
            $report->ReportStatus = 1;
            UpdateReport($report);
            SendFireBaseNotification($params->MaintenanceTeam, 'تم توجيه طلب لك', 'يوجد لديك توجيه طلب جديد', $report->Id, 1);
            SendFireBaseNotification($report->CreatedBy, "تم توجيه البلاغ رقم " . $report->Id, "توجيه بلاغ", $report->Id, 1);

            SendToReportReceivers("تم توجيه البلاغ رقم " . $report->Id, "توجيه بلاغ", $report->Id, 4, 3);
            echo json_encode($report, JSON_UNESCAPED_UNICODE);
        } else {
            echo '{"result":"Report Not Found"}';
        }
    }
}

function AddReportImages($params) {
    $currentUser = GetCurrentLoggedUser();
    if ($currentUser != null) {
        $report = GetReportById($params->Id);
        if ($report != null) {
            foreach ($params->Images as $Image) {
                AddReportImage($params->Id, $Image);
            }
            echo '{"result":"Done"}';
        } else {
            echo '{"result":"Report Not Found"}';
        }
    }
}

function Delete_Report() {
    foreach (getallheaders() as $name => $value) {
        if (strtolower($name) == "id") {
            DeleteReport($value);
            echo '{"result":"DONE"}';
        }
    }
}

function Delete_All_Reports() {

    DeleteAllReports();
    echo '{"result":"DONE"}';
}

?>