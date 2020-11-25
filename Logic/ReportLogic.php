<?php

$ReportStatus = ["انتظار", "محول", "انتهاء", "مكتمل"];
$Rates = ["جيد", "سيئ", "جيد جدا"];
$Importances = ["عادي", "هام", "عاجل", "طارئ"];

function InsertReport($ReportText, $CreatedBy, $Importance, $lat, $lang, $Url) {

    $query = "INSERT into reports(`ReportText`, `Url`,`CreatedBy`  ,`CreatedAt`,`Importance`,`lat`,`lang`) values(?,?,?,?,?,?,?)";
    $CreatedAt = time();
    $db = new DbConnection();
    $result = $db->RunQuery($query, array(
        $ReportText,
        $Url,
        $CreatedBy,
        $CreatedAt,
        $Importance,
        $lat,
        $lang
    ));
    return GetReportById($result);
}

function UpdateReport($report) {
    $query = "update reports set ReportText=?,ReportStatus=?,MaintenanceTeam=?,SetDoneBy=?,Rate=?,RateMessage=?,RedirectedBy=?,Importance=? where Id=?";
    $report->CreatedAt = time();
    $db = new DbConnection();
    $result = $db->RunQuery($query, array(
        $report->ReportText,
        $report->ReportStatus,
        $report->MaintenanceTeam,
        $report->SetDoneBy,
        $report->Rate,
        $report->RateMessage,
        $report->RedirectedBy,
        $report->Importance,
        $report->Id
    ));
    return GetReportById($result);
}

function GetReportById($Id) {
    $query = "SELECT * from reports where Id=?";
    $db = new DbConnection();
    $Report = $db->SelectData($query, array($Id), "Report");
    $users = ListAllUsers();
    if (count($Report) == 0) {
        return null;
    } else {
        $report = $Report[0];
        $images = ListReportImages($Id);
        PrepareReportImages($images, $report);
        PrepareReportUsers($users, $report);
        return $report;
    }
}

function GetDetailsOfReport($Id) {
    $query = "SELECT * from reports where Id=?";
    $db = new DbConnection();
    $Report = $db->SelectData($query, array($Id), "Report");
    $users = ListAllUsers();
    if (count($Report) == 0) {
        return null;
    } else {
        $report = $Report[0];
        $images = ListReportImages($Id);
        PrepareReportImages($images, $report);
        $CompletionImages = ListReportCompletionImages($Id);
        PrepareReportCompletionImages($CompletionImages, $report);
        PrepareReportUsers($users, $report);
        return $report;
    }
}

function GetReportsFilterByStatus($status) {
    $query = "SELECT * from reports where ReportStatus=? order by id desc";
    $db = new DbConnection();
    $reports = $db->SelectData($query, array($status), "Report");
    $images = ListReportImages();
    $CompletionImages = ListReportCompletionImages();
    $users = ListAllUsers();
    foreach ($reports as $report) {
        PrepareReportImages($images, $report);
        //PrepareReportCompletionImages($CompletionImages, $report);
        PrepareReportUsers($users, $report);
    }
    return $reports;
}

function GetReportsOfUserFilterByStatus($status, $UserId, $UserType, $buildingId) {
    $db = new DbConnection();
    if ($UserType == 1) {//المبنى
        $query = "SELECT * from reports where ReportStatus=? and createdby=? order by id desc";
        $reports = $db->SelectData($query, array($status, $UserId), "Report");
    } else if ($UserType == 2) {//مستقبلين البلاغ
        $ReportsIds = GetBuildingsByReceiver($UserId);
        $ReportsIdsStr = implode(",", $ReportsIds);
        $query = "SELECT * from reports where createdby in (" . $ReportsIdsStr . ") and  ReportStatus=?   order by id desc";
        $reports = $db->SelectData($query, array($status), "Report");
    } else if ($UserType == 3) {//فرق الصيانة
        $query = "SELECT * from reports where ReportStatus=? and MaintenanceTeam=? order by id desc";
        $reports = $db->SelectData($query, array($status, $UserId), "Report");
    } else if ($UserType == 4) {//مطلعين الجودة
        $ReportsIds = GetBuildingsBySupervisor($UserId);
        $ReportsIdsStr = implode(",", $ReportsIds);
        $query = "SELECT * from reports where createdby in (" . $ReportsIdsStr . ") and  ReportStatus=?   order by id desc";
        $reports = $db->SelectData($query, array($status), "Report");
    }

    $images = ListReportImages();
    $CompletionImages = ListReportCompletionImages();
    $users = ListAllUsers();
    $filterdReports = array();
    foreach ($reports as $report) {
        if ($buildingId != 0) {
            if ($report->CreatedBy != $buildingId) {
                continue;
            }
        }
        PrepareReportImages($images, $report);
        //  PrepareReportCompletionImages($CompletionImages, $report);
        PrepareReportUsers($users, $report);
        array_push($filterdReports, $report);
    }
    return $filterdReports;
}

function GetReportsOfUser($UserId, $UserType, $buildingId) {
    $db = new DbConnection();
    if ($UserType == 1) {//المبنى
        $query = "SELECT * from reports where  createdby=? order by id desc";
        $reports = $db->SelectData($query, array($UserId), "Report");
    } else if ($UserType == 2) {//مستقبلين البلاغ
        $ReportsIds = GetBuildingsByReceiver($UserId);
        $ReportsIdsStr = implode(",", $ReportsIds);
        $query = "SELECT * from reports where createdby in (" . $ReportsIdsStr . ")    order by id desc";
        $reports = $db->SelectData($query, array(), "Report");
    } else if ($UserType == 3) {//فرق الصيانة
        $query = "SELECT * from reports where  MaintenanceTeam=? order by id desc";
        $reports = $db->SelectData($query, array($UserId), "Report");
    } else if ($UserType == 4) {//مطلعين الجودة
        $ReportsIds = GetBuildingsBySupervisor($UserId);
        $ReportsIdsStr = implode(",", $ReportsIds);
        $query = "SELECT * from reports where createdby in (" . $ReportsIdsStr . ")   order by id desc";
        $reports = $db->SelectData($query, array(), "Report");
    }
    $images = ListReportImages();
    $CompletionImages = ListReportCompletionImages();
    $users = ListAllUsers();
    $filterdReports = array();
    foreach ($reports as $report) {
        if ($buildingId != 0) {
            if ($report->CreatedBy != $buildingId) {
                continue;
            }
        }
        PrepareReportImages($images, $report);
        //  PrepareReportCompletionImages($CompletionImages, $report);
        PrepareReportUsers($users, $report);
        array_push($filterdReports, $report);
    }
    return $filterdReports;
}

function ListReports() {
    $query = "SELECT * from reports  order by id desc";
    $db = new DbConnection();
    $reports = $db->SelectData($query, array(), "Report");
    $images = ListReportImages();
    $CompletionImages = ListReportCompletionImages();
    $users = ListAllUsers();
    foreach ($reports as $report) {
        PrepareReportImages($images, $report);
        // PrepareReportCompletionImages($CompletionImages, $report);
        PrepareReportUsers($users, $report);
    }
    return $reports;
}

function PrepareReportUsers($users, $report) {
    foreach ($users as $user) {
        if ($user->Id == $report->CreatedBy) {
            $report->CreatedBy_Name = $user->Name;
            $report->Creator_MinistryNumber = $user->MinistryNumber;
        }
        if ($user->Id == $report->MaintenanceTeam) {
            $report->MaintenanceTeam_Name = $user->Name;
        }
    }
}

function PrepareReportImages($images, $report) {
    $report->Images = array();
    foreach ($images as $reportImage) {
        if ($reportImage->ReportId == $report->Id) {
            array_push($report->Images, $reportImage->PicturePath);
        }
    }
}

function PrepareReportCompletionImages($images, $report) {
    $report->CompletionHistory = array();
    $StatusHistory = GetReportStatusHistory($report->Id);
    $i = 0;
    foreach ($images as $imagesGroup) {
        $photos = array();
        $Message = "";
        $AcceptMessage = "";
        $RejectMessage = "";
        $ModifyDate;
        foreach ($imagesGroup as $img) {
            $Message = $img["Description"];
            $ModifyDate = $StatusHistory[$i]->UpdateDate;

            if (count($StatusHistory) > $i) {
                if ($StatusHistory[$i]->Status == 3) {
                    $AcceptMessage = $StatusHistory[$i]->Message;
                } else {
                    $RejectMessage = $StatusHistory[$i]->Message;
                }
            }
            array_push($photos, $img["PicturePath"]);
        }
        $history = array(
            "Message" => $Message,
            "AcceptMessage" => $AcceptMessage,
            "RejectMessage" => $RejectMessage,
            "ModifyDate" => $ModifyDate,
            "photos" => $photos
        );
        $i = $i + 1;
        array_push($report->CompletionHistory, $history);
    }
    //   echo count($StatusHistory)." | ".$i;
    if (count($StatusHistory) > $i) {
        for ($j = $i; $i < count($StatusHistory); $i++) {
            if ($StatusHistory[$i]->Status == 3) {
                $AcceptMessage = $StatusHistory[$i]->Message;
            } else {
                $RejectMessage = $StatusHistory[$i]->Message;
            }
            $history = array(
                "Message" => "",
                "AcceptMessage" => $AcceptMessage,
                "RejectMessage" => $RejectMessage,
                "photos" => []
            );
            array_push($report->CompletionHistory, $history);
        }
    }
}

function ListReportImages($reportId = null) {
    if ($reportId) {
        $query = "SELECT * from reportimages where reportid=?";
        $db = new DbConnection();
        return $db->SelectData($query, array($reportId), "ReportImage");
    } else {
        $query = "SELECT * from reportimages";
        $db = new DbConnection();
        return $db->SelectData($query, array(), "ReportImage");
    }
}

function ListReportCompletionImages($reportId = null) {
    $query = "SELECT `GroupId` , `Id`, `PicturePath`, `ReportId`, `Description` from reportcompletionimages where reportid=?";
    $db = new DbConnection();
    return $db->SelectGroupedData($query, array($reportId), "ReportCompletionImage");
}

function ListAllUsers() {
    $query = "SELECT * from users";
    $db = new DbConnection();
    return $db->SelectData($query, array(), "user");
}

function AddReportImage($reportId, $image) {
    $query = "INSERT into reportimages(`ReportId`,`PicturePath`) values(?,?)";
    $db = new DbConnection();
    $result = $db->RunQuery($query, array(
        $reportId, $image
    ));
}

function DeleteReport($Id) {
    $query = "delete from reports where id=?;delete from reportcompletionimages where ReportId=?;delete from reportimages where ReportId=?;";
    $db = new DbConnection();
    $result = $db->RunQuery($query, array($Id, $Id, $Id));
    return $result;
}

function DeleteAllReports() {
    $query = "delete from reports ;delete from reportcompletionimages ;delete from reportimages ;";
    $db = new DbConnection();
    $result = $db->RunQuery($query, array());
    return $result;
}

//-----------------------------------------------------
function GetReportStatusHistory($reportid) {
    $query = "SELECT * from reportupdatestatushistory  where ReportId=?";
    $db = new DbConnection();
    return $db->SelectData($query, array($reportid), "Report");
}

function InsertReportCompletionHistory($Status, $ReportId, $Message, $Updatedby) {
    $query = "INSERT INTO `reportupdatestatushistory`( `Status`, `ReportId`, `Message`, `Updatedby`, `UpdateDate`) VALUES (?,?,?,?,?)";
    $db = new DbConnection();
    $result = $db->RunQuery($query, array(
        $Status, $ReportId, $Message, $Updatedby,
        time()
    ));
    return $result;
}

function AddReportCompleteImage($reportId, $image, $Description, $GroupId) {
    $query = "INSERT into reportcompletionimages(`ReportId`,`PicturePath`,`Description`,`GroupId`) values(?,?,?,?)";
    $db = new DbConnection();
    $result = $db->RunQuery($query, array(
        $reportId,
        $image,
        $Description, $GroupId
    ));
    return $result;
}

class Report {

    public $Id;
    public $ReportText;
    public $ReportStatus;
    public $CreatedBy;
    public $MaintenanceTeam;
    public $DoneDescription;
    public $SetDoneBy;
    public $DonePicture;
    public $Rate;
    public $RateMessage;
    public $CreatedAt;
    public $RedirectedBy;
    public $Importance;
    public $Images;
    public $CreatedBy_Name;
    public $MaintenanceTeam_Name;
    public $Creator_MinistryNumber;
    public $lat;
    public $lang;
    public $CompletionHistory;
    public $Url;

}

class ReportImage {

    public $Id;
    public $ReportId;
    public $PicturePath;

}

class ReportCompletionImage {

    public $Id;
    public $ReportId;
    public $PicturePath;
    public $Description;

}

class ReportUpdateStatusHistory {

    public $Id;
    public $Status;
    public $ReportId;
    public $Message;
    public $Updatedby;
    public $UpdateDate;

}

function ConvertFromUnixDate($unixdate) {
    echo gmdate("Y/m/d H:i:s", $unixdate);
}

?>