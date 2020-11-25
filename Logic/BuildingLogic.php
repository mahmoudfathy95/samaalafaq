<?php

function GetBuildingReceivers($buildingId) {
    $query = "SELECT userid FROM buildingreportreceiver where buildingid=?";
    $db = new DbConnection();
    $IdsArray = [];
    foreach ($db->SelectData($query, array($buildingId)) as $r) {
        array_push($IdsArray, $r["userid"]);
    }
    return $IdsArray;
}

function GetBuildingsByReceiver($userid) {
    $query = "SELECT buildingid FROM buildingreportreceiver where userid=?";
    $db = new DbConnection();
    $IdsArray = [];
    foreach ($db->SelectData($query, array($userid)) as $r) {
        array_push($IdsArray, $r["buildingid"]);
    }
    return $IdsArray;
}

function GetReceiversOfBuildings($userid) {
    $buildingsIds = GetBuildingsByReceiver($userid);
    if (count($buildingsIds) > 0) {
        $db = new DbConnection();
        $in = str_repeat('?,', count($buildingsIds) - 1) . '?';
        $query = "SELECT Id,Name from users where id in ($in)";
        $users = $db->SelectData($query, $buildingsIds, "IdNameModel");
        return $users;
    }
    return array();
}

function GetSupervisorsOfBuildings($userid) {
    $buildingsIds = GetBuildingsBySupervisor($userid);
    if (count($buildingsIds) > 0) {
        $db = new DbConnection();
        $in = str_repeat('?,', count($buildingsIds) - 1) . '?';
        $query = "SELECT Id,Name from users where id in ($in)";
        $users = $db->SelectData($query, $buildingsIds, "IdNameModel");
        return $users;
    }
    return array();
}

function InsertBuildingReportReceivers($BuildingId, $UserId) {
    $query = "insert into buildingreportreceiver (userid,buildingid) values (?,?)";
    $db = new DbConnection();
    return $db->RunQuery($query, array(
                $UserId,
                $BuildingId
    ));
}

function DeleteBuildingsReceivers($buildingId) {
    $query = "delete FROM buildingreportreceiver where buildingid=?";
    $db = new DbConnection();
    return $db->RunQuery($query, array($buildingId));
}

//------------------------------- Building Supervisors

function GetBuildingSupervisors($buildingId) {
    $query = "SELECT userid FROM buildingsupervisor where buildingid=?";
    $db = new DbConnection();
    $IdsArray = [];
    foreach ($db->SelectData($query, array($buildingId)) as $r) {
        array_push($IdsArray, $r["userid"]);
    }
    return $IdsArray;
}

function InsertBuildingSupervisors($BuildingId, $UserId) {
    $query = "insert into buildingsupervisor (userid,buildingid) values (?,?)";
    $db = new DbConnection();
    return $db->RunQuery($query, array(
                $UserId,
                $BuildingId
    ));
}

function GetBuildingsBySupervisor($userid) {
    $query = "SELECT buildingid FROM buildingsupervisor where userid=?";
    $db = new DbConnection();
    $IdsArray = [];
    foreach ($db->SelectData($query, array($userid)) as $r) {
        array_push($IdsArray, $r["buildingid"]);
    }
    return $IdsArray;
}

function DeleteBuildingsSupervisors($buildingId) {
    $query = "delete FROM buildingsupervisor where buildingid=?";
    $db = new DbConnection();
    return $db->RunQuery($query, array($buildingId));
}

//---------------------------
function GetRecieverTeams($RecieverId) {
    $query = "SELECT userid FROM recieverteam where recieverid=?";
    $db = new DbConnection();
    $IdsArray = [];
    foreach ($db->SelectData($query, array($RecieverId)) as $r) {
        array_push($IdsArray, $r["userid"]);
    }
    return $IdsArray;
}

function InsertRecieverTeams($RecieverId, $UserId) {
    $query = "insert into recieverteam (userid,recieverid) values (?,?)";
    $db = new DbConnection();
    return $db->RunQuery($query, array(
                $UserId,
                $RecieverId
    ));
}

function DeleterecieverTeams($RecieverId) {
    $query = "delete FROM recieverteam where recieverid=?";
    $db = new DbConnection();
    return $db->RunQuery($query, array($RecieverId));
}

class IdNameModel {

    public $Id;
    public $Name;

}

?>