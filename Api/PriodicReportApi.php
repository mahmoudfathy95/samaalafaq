<?php

function SaveTreeTemplate() {
    extract($_POST);
    if ($TreeId == 0) {
        $TreeId = InsertTreeTemplate($TemplateName);
    } else {
        UpdateTreeTemplate($TreeId, $TemplateName);
    }
    foreach ($Nodes as $node) {
        if (isset($node["Deleted"])) {
            DeleteMaintenanceTreeNode($node["Id"]);
        } else {
            $OldNode = GetTreeNodeById($node["Id"]);
            if ($OldNode == null) {
                InsertMaintenanceTreeNode($node, $TreeId);
            } else {
                UpdateMaintenanceTreeNode($node, $TreeId);
            }
        }
    }
    echo '{"result":"Done"}';
}

function GetTreeTemplate() {
    extract($_POST);
    $template = GetMaintenanceTreeById($Id);
    echo json_encode($template, JSON_UNESCAPED_UNICODE);
}

function DeleteMaintenanceTreeTemplate() {
    foreach (getallheaders() as $name => $value) {
        if (strtolower($name) == "id") {
            DeleteMaintenanceTree($value);
            echo '{"result":"DONE"}';
        }
    }
}

function DeletePeriodicReport() {
    foreach (getallheaders() as $name => $value) {
        if (strtolower($name) == "id") {
            RemovePeriodicReport($value);
            echo '{"result":"DONE"}';
        }
    }
}

//FOr Admin Display
function GetPeriodReportMaintenanceStatus($params) {
    extract($_POST);
    $template = GetReportMaintenance($ReportId);
    echo json_encode($template, JSON_UNESCAPED_UNICODE);
}

function GetCurrentUserPeriodicReports($params) {
    $currentUser = GetCurrentLoggedUser();
    if ($currentUser != null) {
        if (isset($params->Status)) {
            $status = $params->Status;
        } else {
            $status = null;
        }
        if (!isset($params->BuildingId) || $params->BuildingId == null) {
            $params->BuildingId = 0;
        }
        $reports = GetPeriodicReports($currentUser->Id, $currentUser->UserType, $status,  $params->BuildingId);
        echo json_encode(PageArray($reports, $params->CurrentPage, $params->ItemPerPage), JSON_UNESCAPED_UNICODE);
    }
}

function GetPeriodicReportDetails($params) {
    $currentUser = GetCurrentLoggedUser();
    if ($currentUser != null) {
        echo json_encode(PeriodicReportDetails($params->ReportId), JSON_UNESCAPED_UNICODE);
    }
}

function UpdatePeriodicReportStatus($params) {
    $currentUser = GetCurrentLoggedUser();
    if ($currentUser != null) {
        UpdatePeriodicReportMaintenance($params, $currentUser->Id);
        $report = GetPeriodicReportById($params->ReportId);
        $NotificationMsg = "تم تعديل التقرير رقم " . $params->ReportId;
        SendToPeriodicReportReceivers("لقد تم تعديل حالة البلاغ", $NotificationMsg, $params->ReportId, 4, $params->ReportStatus);
        SendFireBaseNotification($report->TeamId, $params->ReportId, "لقد تم تعديل حالة البلاغ", $NotificationMsg, $params->ReportStatus);
        SendFireBaseNotification($report->BuildingId, $params->ReportId, "لقد تم تعديل حالة البلاغ", $NotificationMsg, $params->ReportStatus);

        echo '{"result":"DONE"}';
    }
}

?>