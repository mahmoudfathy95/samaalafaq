<?php

$PeriodicReportsStatus = ["لم يبدأ", "قيد التنفيذ", "مكتمل", "منتهي"];

function GetMaintenanceTemplates() {
    $query = "SELECT * from maintenancetreetemplates";
    $db = new DbConnection();
    return $db->SelectData($query, array());
}

function GetMaintenanceTreeById($TemplateId) {
    $query = "SELECT * from maintenancetreetemplates where id=?";
    $db = new DbConnection();
    $template = $db->SelectData($query, array($TemplateId), "MaintenanceTemplate")[0];

    $query = "SELECT * from maintenancetree where TemplateId=?";
    $template->TreeNodes = $db->SelectData($query, array($TemplateId), "TreeNode");
    return $template;
}

function GetTreeNodeById($id) {
    $db = new DbConnection();
    $query = "SELECT * from maintenancetree where Id=?";
    $Nodes = $db->SelectData($query, array($id), "TreeNode");
    if (count($Nodes) > 0) {
        return $Nodes[0];
    } else
        return null;
}

function InsertMaintenanceTreeNode($node, $TreeId) {
    $query = "INSERT INTO `maintenancetree` (`Id`, `ParentId`, `TemplateId`, `Title`) VALUES (?,?,?,?)";
    $db = new DbConnection();
    $result = $db->RunQuery($query, array(
        $node["Id"],
        $node["ParentId"],
        $TreeId,
        $node["Title"]
    ));
    return $result;
}

function UpdateMaintenanceTreeNode($node) {
    $query = "update `maintenancetree` set  `Title`=? where Id=?";
    $db = new DbConnection();
    $result = $db->RunQuery($query, array(
        $node["Title"],
        $node["Id"]
    ));
    return $result;
}

function DeleteMaintenanceTreeNode($id) {
    $query = "delete from `maintenancetree`  where Id=?";
    $db = new DbConnection();
    $result = $db->RunQuery($query, array($id));
    return $result;
}

function InsertTreeTemplate($templatename) {
    $query = "INSERT INTO `maintenancetreetemplates`(`TemplateName`) VALUES (?)";
    $db = new DbConnection();
    return $db->RunQuery($query, array($templatename));
}

function UpdateTreeTemplate($id, $templatename) {
    $query = "UPDATE `maintenancetreetemplates` SET `TemplateName`=? WHERE Id=?";
    $db = new DbConnection();
    return $db->RunQuery($query, array($templatename, $id));
}

function DeleteMaintenanceTree($Id) {
    $query = "delete from maintenancetreetemplates where id=?";
    $db = new DbConnection();
    $db->RunQuery($query, array($Id));
    $query = "delete from maintenancetree where TemplateId=?";
    $db->RunQuery($query, array($Id));
}

//------------------------------- Periodic Reports

function AddPeriodicReport($report) {
    $query = "INSERT INTO `periodicreport`(`BuildingId`, `TeamId`, `PdfPath`,  `TemplateId`, `CreatedAt`, `CreatedBy`, `SendDate`, `ReportStatus` ) VALUES (?,?,?,?,?,?,?,?)";
    $db = new DbConnection();
    $reportid = $db->RunQuery($query, array(
        $report->BuildingId,
        $report->TeamId,
        $report->PdfPath,
        $report->TemplateId,
        time(),
        $_SESSION["UserId"],
        $report->SendDate,
         $report->ReportStatus,
    ));

    //Insert Into Templates
//get tree ites from template
    $query = "SELECT * FROM `maintenancetree` WHERE `TemplateId`=?";
    $RequiredMaintenance = $db->SelectData($query, array($report->TemplateId));
    foreach ($RequiredMaintenance as $maintenance) {
        $query = "INSERT INTO `reportmaintenancestatus`(`Id`, `ReportId`, `Title`, `ParentId`) VALUES (?,?,?,?)";
        $db = new DbConnection();
        $db->RunQuery($query, array(
            $maintenance["Id"],
            $reportid,
            $maintenance["Title"],
            $maintenance["ParentId"],
        ));
    }
    return $reportid;
}

function UpdatePeriodicReport($report) {
    $query = "update `periodicreport`  set `BuildingId`=?, `TeamId`=? ,`PdfPath`=?,`SendDate`=? ,`ReportStatus`=? where Id=?";
    $db = new DbConnection();
    $result = $db->RunQuery($query, array(
        $report->BuildingId,
        $report->TeamId,
        $report->PdfPath,
        $report->SendDate,
        $report->ReportStatus,
        $report->Id
    ));
    return $result;
}

function RemovePeriodicReport($id) {
    $db = new DbConnection();
    $query = "delete from `periodicreport`  where Id=?";
    $result = $db->RunQuery($query, array($id));
    $query = "delete from `reportmaintenancestatus`  where ReportId=?";
    $result = $db->RunQuery($query, array($id));
    return $result;
}

function GetPeriodicReportById($Id) {
    $query = "SELECT * from periodicreport where Id=?";
    $db = new DbConnection();
    return $db->SelectData($query, array($Id), "PeriodicReport")[0];
}

function GetReportMaintenance($ReportId) {
    $db = new DbConnection();
    $query = "SELECT * FROM `reportmaintenancestatus` WHERE `ReportId`=?";
    return $db->SelectData($query, array($ReportId), "ReportMaintenanceStatus");
}

function GetPeriodicReports($currentUser, $CurrentUserType, $status, $BuildingId) {
    //todo filter by users
    $db = new DbConnection();
    $users = ListAllUsers();

    if ($CurrentUserType == 1) {
        //مبنى تعليمي
        $query = "SELECT * from periodicreport where  BuildingId=?";
        $reports = $db->SelectData($query, array($currentUser), "PeriodicReport");
    } else if ($CurrentUserType == 3) {
        //فرق الصيانة 
        $query = "SELECT * from periodicreport where TeamId=?";
        $reports = $db->SelectData($query, array($currentUser), "PeriodicReport");
    } else if ($CurrentUserType == 4) {
        //مشرفين الجودة
        $AllowedBuildings = GetBuildingsBySupervisor($currentUser);
        $in = str_repeat('?,', count($AllowedBuildings) - 1) . '?';
        $query = "SELECT * from periodicreport where BuildingId in ($in)";
        $reports = $db->SelectData($query, $AllowedBuildings, "PeriodicReport");
    }

//    else {
//        //Get All Reports Then Filter in forearch
//        $query = "SELECT * from periodicreport where SendDate>=? ";
//        $reports = $db->SelectData($query, array(time()), "PeriodicReport");
//    } 
    $FilterdReports = array();
    foreach ($reports as $report) {
        if ($BuildingId != 0) {
            if ($report->BuildingId != $BuildingId) {
                continue;
            }
        }
        if ($report->SendDate > time()) {
            continue;
        }
        if ($status != null && $report->ReportStatus != $status) {
            continue;
        }
        array_push($FilterdReports, $report);
    }
    foreach ($FilterdReports as $report) {
        $report->BuildingId = SelectUserById($users, $report->BuildingId)->Name;
        $report->TeamId = SelectUserById($users, $report->TeamId)->Name;
    }

    return $FilterdReports;
}

function ListAllPeriodicReports() {
    $db = new DbConnection();
    $users = ListAllUsers();
    $query = "SELECT * from periodicreport order by id desc";
    $reports = $db->SelectData($query, array(), "PeriodicReport");
    foreach ($reports as $report) {
        $report->BuildingId = SelectUserById($users, $report->BuildingId)->Name;
        $report->TeamId = SelectUserById($users, $report->TeamId)->Name;
    }

    return $reports;
}

function GetUnSentPeriodicReports() {
    $db = new DbConnection();
    $query = "SELECT * from periodicreport where `IsSent` !=1 and 1264888800 <= ?";
    $reports = $db->SelectData($query, array(time()), "PeriodicReport");
    return $reports;
}

function GetTreeSubLevel($parentId, $ReportId) {
    $query = "SELECT * from reportmaintenancestatus where ParentId=? and ReportId=?";
    $db = new DbConnection();

    $Nodes = $db->SelectData($query, array($parentId, $ReportId), "ReportMaintenanceStatus");
    foreach ($Nodes as $node) {
        $node->SubNodes = GetTreeSubLevel($node->Id, $ReportId);
    }
    return $Nodes;
}

function PeriodicReportDetails($ReportId) {
    $PeriodicReport = GetPeriodicReportById($ReportId);
    $PeriodicReport->BuildingId = GetUserById($PeriodicReport->BuildingId)->Name;
    $PeriodicReport->TeamId = GetUserById($PeriodicReport->TeamId)->Name;


    $db = new DbConnection();
    $query = "SELECT * from reportmaintenancestatus where (ParentId is null or ParentId='') and ReportId=?";
    $Nodes = $db->SelectData($query, array($ReportId), "ReportMaintenanceStatus");
    $PeriodicReport->RequiredMaintenance = array();
    foreach ($Nodes as $node) {
        $node->SubNodes = GetTreeSubLevel($node->Id, $ReportId);
        array_push($PeriodicReport->RequiredMaintenance, $node);
    }
    return $PeriodicReport;
}

function UpdatePeriodicReportMaintenance($periodicReport, $userId) {
    $db = new DbConnection();

    for ($i = 0; $i < count($periodicReport->Maintenance); $i++) {
        $query = "update `reportmaintenancestatus`  set `Value`=? ,`UpdateDate`=? ,`UpdatedBy`=? where Id=? and `ReportId`=?";
        $db->RunQuery($query, array(
            $periodicReport->Maintenance[$i]->Value,
            time(),
            $userId,
            $periodicReport->Maintenance[$i]->Id,
            $periodicReport->ReportId
        ));
    }
    $query = "update `periodicreport`  set ReportStatus=? where Id=?";
    return $db->RunQuery($query, array(
                $periodicReport->ReportStatus,
                $periodicReport->ReportId
    ));
}

function SelectUserById($users, $userid) {
    foreach ($users as $user) {
        if ($user->Id == $userid)
            return $user;
    }
    return null;
}

class TreeNode {

    public $Id;
    public $ParentId;
    public $TemplateId;
    public $Title;
    public $SubNodes;

}

class ReportMaintenanceStatus {

    public $Id;
    public $ParentId;
    public $Value;
    public $Title;
    public $SubNodes;

}

class MaintenanceTemplate {

    public $Id;
    public $TemplateName;
    public $TreeNodes;

}

class PeriodicReport {

    public $Id;
    public $BuildingId;
    public $TeamId;
    public $PdfPath;
    public $ReportStatus;
    public $TemplateId;
    public $SendDate;
    public $IsSent;
    public $CreatedAt;
    public $RequiredMaintenance;

}

?>