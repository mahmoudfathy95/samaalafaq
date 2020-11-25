<?php

function IsEmailUsed($email, $userid) {
    $query = "select id from users where email=? and id !=?";
    $db = new DbConnection();
    $result = $db->SelectData($query, array($email, $userid));
    if (count($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function IsMobileUsed($mobile, $userid) {
    $query = "select id from users where mobile=? and id !=?";
    $db = new DbConnection();
    $result = $db->SelectData($query, array($mobile, $userid));
    if (count($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function IsUserNameUsed($username, $userid) {
    $query = "select id from users where username=? and id !=?";
    $db = new DbConnection();
    $result = $db->SelectData($query, array($username, $userid));
    if (count($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function UpdateUser($User) {
    $query = "update users set Name = ? ,UserName = ? ,Email = ? ,Mobile = ? ,BuildingAddress = ? ,MinistryNumber = ? ,JobNumber = ? ,IdentityNumber = ? ,TeamType = ? ,SupervisorName = ? ,Job = ? ,lat=?,lang=? ,PdfPath=? where id=?";
    $db = new DbConnection();
    $result = $db->RunQuery($query, array(
        $User->Name
        , $User->UserName
        , $User->Email
        , $User->Mobile
        , $User->BuildingAddress
        , $User->MinistryNumber
        , $User->JobNumber
        , $User->IdentityNumber
        , $User->TeamType
        , $User->SupervisorName
        , $User->Job
        , $User->lat
        , $User->lang
            , $User->PdfPath
        , $User->Id
    ));
}

function InsertUser($User) {
    $query = "insert into users  (Name ,UserName ,Email ,Mobile ,BuildingAddress ,MinistryNumber ,JobNumber ,IdentityNumber ,TeamType ,SupervisorName ,Job,password,UserType,Token,CreatedDate,lat,lang,PdfPath) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $db = new DbConnection();
    $User->Token = GenerateUserToken();
    $result = $db->RunQuery($query, array(
        $User->Name
        , $User->UserName
        , $User->Email
        , $User->Mobile
        , $User->BuildingAddress
        , $User->MinistryNumber
        , $User->JobNumber
        , $User->IdentityNumber
        , $User->TeamType
        , $User->SupervisorName
        , $User->Job
        , $User->Password
        , $User->UserType
        , $User->Token
        , time()
        , $User->lat
        , $User->lang
        , $User->PdfPath
    ));
    return $result;
}

function DeleteUser($Id) {
    $query = "delete from users where id=?";
    $db = new DbConnection();
    $result = $db->RunQuery($query, array($Id));
}

function testconnection() {
    $query = "SELECT * from users";
    $db = new DbConnection();
    return $db->SelectData($query, array(), "User");
}

function GetUsersFilterByType($UserType) {
    $query = "SELECT users.*,teamtypes.Name as TeamTypeName from users left join  teamtypes on users.TeamType=teamtypes.Id where UserType=?";
    $db = new DbConnection();
    return $db->SelectData($query, array($UserType), "User");
}

function GetAllBuildings() {
    $query = "SELECT Id,Name from users where UserType=1";
    $db = new DbConnection();
    return $db->SelectData($query, array(), "IdNameModel");
}

function GetUsersByIds($ids) {
    $idsStr = implode(",", $ids);
    $query = "SELECT users.*,teamtypes.Name as TeamTypeName from users left join  teamtypes on users.TeamType=teamtypes.Id where users.Id in (" . $idsStr . ")";
    $db = new DbConnection();

    return $db->SelectData($query, array(), "User");
}

function UserLogin($email, $password, $FirebaseToken = null) {
    $query = "SELECT users.*,teamtypes.Name as TeamTypeName from users left join  teamtypes on users.TeamType=teamtypes.Id where (email=? or username=?) and binary trim(password)=trim(?)";
    $db = new DbConnection();
    $LoginState = $db->SelectData($query, array($email, $email, $password), "User");
    if (count($LoginState) > 0) {
        $LoginState[0]->Password = "";
        //Update User firebase token
        if ($FirebaseToken) {
            $query = "update users set firebaseToken=? where Id=?";
            $db->RunQuery($query, array($FirebaseToken, $LoginState[0]->Id));
        }
        return $LoginState[0];
    } else {
        return null;
    }
}

function AdminLogin($email, $password) {
    $query = "SELECT * from  users where (email=? or username=?) and binary trim(password)=trim(?)";
    $db = new DbConnection();
    $LoginState = $db->SelectData($query, array($email, $email, $password), "User");
    if (count($LoginState) > 0) {
        return $LoginState[0];
    } else {
        return null;
    }
}

function DeleteUserToken($Id) {
    $db = new DbConnection();
    $query = "update users set FireBaseToken=NULL where Id=?";
    $db->RunQuery($query, array($Id));
}

function ChangeUserPassword($UserId, $NewPassword) {
    $query = "update users set password=? where id=?";
    $db = new DbConnection();
    $result = $db->RunQuery($query, array($NewPassword, $UserId));
}

function GetUserByToken($token) {
    $query = "SELECT users.*,teamtypes.Name as TeamTypeName from users left join  teamtypes on users.TeamType=teamtypes.Id where token=?";

    $query = "SELECT * from users where token=?";
    $db = new DbConnection();
    $user = $db->SelectData($query, array($token), "User");
    if (count($user) == 0) {
        return null;
    } else {
        return $user[0];
    }
}

function GetUserById($id) {
    $query = "SELECT users.*,teamtypes.Name as TeamTypeName from users  left join  teamtypes on users.TeamType=teamtypes.Id  where  users.Id=?";
    $db = new DbConnection();
    $user = $db->SelectData($query, array($id), "User");
    if (count($user) == 0) {
        return null;
    } else {
        return $user[0];
    }
    return $user[0];
}

function GetUserByMobile($Mobile) {
    $query = "SELECT users.*,teamtypes.Name as TeamTypeName from users left join  teamtypes on users.TeamType=teamtypes.Id  where users.Mobile=?";
    $db = new DbConnection();
    $user = $db->SelectData($query, array($Mobile), "User");
    if (count($user) == 0) {
        return null;
    } else {
        return $user[0];
    }
}

function UpdateUserRestCode($Mobile, $ResetCode) {
    $query = "update users set RestCode=? where Mobile=?";
    $db = new DbConnection();
    $db->RunQuery($query, array($ResetCode, $Mobile));
}

function GeneratePasswordRestCode() {
    return sprintf('%X', mt_rand(0, 65535));
}

function GenerateUserToken() {
    return sprintf('%04X%04X%04X%04X%04X%04X%04X%04X%04X%04X%04X%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(32768, 49151), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(32768, 49151), mt_rand(32768, 49151), mt_rand(0, 65535));
}

function GetTeamTypes() {
    $query = "select * from teamtypes";
    $db = new DbConnection();
    $result = $db->SelectData($query, array());
    return $result;
}

function InsertTeamType($Name) {
    $query = "insert into teamtypes (Name) values(?)";
    $db = new DbConnection();
    $result = $db->RunQuery($query, array($Name));
    return $result;
}

function UpdateTeamType($Id, $Name) {
    $query = "update teamtypes set Name=? where id=?";
    $db = new DbConnection();
    $result = $db->RunQuery($query, array($Name, $Id));
    return $result;
}

function DeleteTeamType($Id) {
    $query = "delete from teamtypes where id=?";
    $db = new DbConnection();
    $result = $db->RunQuery($query, array($Id));
}

function GetTeamTypeById($Id) {
    $query = "select * from teamtypes where id=?";
    $db = new DbConnection();
    $user = $db->SelectData($query, array($Id), "User");
    return $user[0];
}

function redirect($url) {
    echo '<script type="text/javascript">location.href = "'.$url.'";</script>';
//    ob_start();
//    header('Location: ' . $url);
//    ob_end_flush();
//    die();
   // exit(header("Location: $url"));
}

class User {

    public $Id;
    public $Email;
    public $Password;
    public $Mobile;
    public $UserName;
    public $Name;
    public $Job;
    public $UserType;
    // public $BuildingName;
    public $BuildingAddress;
    public $MinistryNumber;
    public $JobNumber;
    public $IdentityNumber;
    public $TeamType;
    public $TeamTypeName;
    public $SupervisorName;
    public $CreatedDate;
    public $Token;
    public $FireBaseToken;
    public $lat;
    public $lang;
    public $PdfPath;

}

?>