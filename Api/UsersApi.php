<?php

function Login($Params) {
    $email = $Params->email;
    $password = $Params->password;
    $result = UserLogin($email, $password, $Params->FireBaseToken);
    if ($result == null) {
        echo '{"result":"User Not Found"}';
    } else {
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}

function GetCurrentLoggedUser() {
    foreach (getallheaders() as $name => $value) {
        if (strtolower($name) == "usertoken") {
            $CurrentUser = GetUserByToken($value);
        }
    }
    if ($CurrentUser == null) {
        echo '{"result":"You are not Logged in","Code":"401"}';
    }
    return $CurrentUser;
}

function ChangePassword($Params) {
    $CurrentUser = GetCurrentLoggedUser();
    if ($CurrentUser != null) {
        if ($CurrentUser->Password == $Params->OldPassword) {
            ChangeUserPassword($CurrentUser->Id, $Params->NewPassword);
            echo '{"result":"DONE","Code":"200"}';
        } else {
            echo '{"result":"Old Password Is incorrect"}';
        }
    }
}

function Profile() {
    $user = GetCurrentLoggedUser();
    $user->Password = "";
    echo json_encode($user, JSON_UNESCAPED_UNICODE);
}

function GetTeams($urlParams) {
    $ReceiverTeams = GetRecieverTeams($urlParams->ReceiverId);
    $teams = GetUsersByIds($ReceiverTeams);
    echo json_encode($teams, JSON_UNESCAPED_UNICODE);
}

function ForgetPassword($urlParams) {
    $user = GetUserByMobile($urlParams->Mobile);
    if ($user != null) {
        $Code = GeneratePasswordRestCode();
        UpdateUserRestCode($urlParams->Mobile, $Code);
        $MSG = "Sama Al Afaq Password Reset Code : " . $Code;
        SendSMS($urlParams->Mobile, $MSG);
        echo '{"result":"DONE","Code":"200"}';
    } else {
        echo '{"result":"User Not Found","Code":"401"}';
    }
}

function ValidateRestCode($urlParams) {
    $user = GetUserByMobile($urlParams->Mobile);
    if ($user->RestCode == $urlParams->RestCode) {
        echo '{"result":"Valid","Code":"200"}';
    }
    echo '{"result":"Code Not Correct","Code":"400"}';
}

function ChangePasswordWithRestCode($urlParams) {
    $user = GetUserByMobile($urlParams->Mobile);
    if ($user != null) {
        if ($user->RestCode == $urlParams->RestCode) {
            ChangeUserPassword($user->Id, $urlParams->NewPassword);
            echo '{"result":"DONE","Code":"200"}';
        } else {
            echo '{"result":"Code Not Correct","Code":"400"}';
        }
    } else {
        echo '{"result":"User Not Found","Code":"401"}';
    }
}

function Logout() {
    $CurrentUser = GetCurrentLoggedUser();
    if ($CurrentUser) {
        DeleteUserToken($CurrentUser->Id);
        echo '{"result":"DONE"}';
    }
}

function Delete_User() {
    foreach (getallheaders() as $name => $value) {
        if (strtolower($name) == "id") {
            DeleteUser($value);
            echo '{"result":"DONE"}';
        }
    }
}

function Delete_TeamType() {
    foreach (getallheaders() as $name => $value) {
        if (strtolower($name) == "id") {
            DeleteTeamType($value);
            echo '{"result":"DONE"}';
        }
    }
}

function GetCurrentUserAllowedBuildings() {
    $CurrentUser = GetCurrentLoggedUser();
    if ($CurrentUser != null) {
        if ($CurrentUser->UserType == 2) {
            echo json_encode(GetReceiversOfBuildings($CurrentUser->Id), JSON_UNESCAPED_UNICODE);
        } else if ($CurrentUser->UserType == 3) {
            echo json_encode(GetAllBuildings(), JSON_UNESCAPED_UNICODE);
        } else if ($CurrentUser->UserType == 4) {
            echo json_encode(GetSupervisorsOfBuildings($CurrentUser->Id), JSON_UNESCAPED_UNICODE);
        }
    }
}

?>