<?php

function SendFireBaseNotification($UserId, $title, $message, $reportId, $status) {
    $user = GetUserById($UserId);
    if ($user) {
        if ($user->FireBaseToken != null && $user->FireBaseToken != "") {
            $url = 'https://fcm.googleApis.com/fcm/send';
            $fields = array(
                'to' => $user->FireBaseToken,
                "priority" => "HIGH",
                'data' => array(
                    "title" => $title,
                    "body" => $message,
                    "orderId" => $reportId,
                    "orderStatus" => $status,
					"sound"=> "default"
                ),
                "notification" => array(
                    "body" => $message,
                    "title" => $title,
					"sound"=> "default"
                ),
            );
            $fieldsJson = json_encode($fields);
            $headers = array('Authorization: key=AAAAFSEbJ88:APA91bHsFT7u2VhAiq0pkHomtJ-k0KAnNlL9Q1cale7iaFVrwXVSjmHzlx3Se5kbQrc6Idvj4F9g_vswFfP_Kbn3nU1ngL4RbzUaUKqRzqbGyK0t-PBaRI_Inl2YH-np-9xulOsCLA3q', 'Content-Type: application/json');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsJson);
            $result = curl_exec($ch);

            //echo "TOKEN : " . $user->FireBaseToken . " result: " . $result;
            curl_close($ch);
        }
    }
    return $UserId.'--'.$result;
}

function SendFireBaseNotification2($token, $title, $message, $reportId, $status, $r) {

    $url = 'https://fcm.googleApis.com/fcm/send';
    $fields = array(
        'to' => $token,
        "priority" => "HIGH",
        'data' => array(
            "title" => $title,
            "body" => $message,
            "orderId" => $reportId,
            "orderStatus" => $status
        ),
        "notification" => array(
            "body" => $message,
            "title" => $title
        ),
    );
    $fieldsJson = json_encode($fields);
    $headers = array('Authorization: key=AAAAFSEbJ88:APA91bHsFT7u2VhAiq0pkHomtJ-k0KAnNlL9Q1cale7iaFVrwXVSjmHzlx3Se5kbQrc6Idvj4F9g_vswFfP_Kbn3nU1ngL4RbzUaUKqRzqbGyK0t-PBaRI_Inl2YH-np-9xulOsCLA3q', 'Content-Type: application/json');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsJson);
    $result = curl_exec($ch);
    echo $result;
    curl_close($ch);

    return $result;
}

function SendToReportReceivers($title, $message, $reportId, $userType, $status) {
    if ($userType == 2) {
        $report = GetReportById($reportId);
        $users = GetBuildingReceivers($report->CreatedBy);
        foreach ($users as $user) {
            SendFireBaseNotification($user, $title, $message, $reportId, $status);
        }
    }
    if ($userType == 4) {
        $report = GetReportById($reportId);
        $users = GetBuildingSupervisors($report->CreatedBy);
        foreach ($users as $user) {
            SendFireBaseNotification($user, $title, $message, $reportId, $status);
        }
    }
    if ($userType == 0) {
        $users = GetUsersFilterByType(0);
        foreach ($users as $user) {
            SendFireBaseNotification($user->Id, $title, $message, $reportId, $status);
        }
    }
}

function SendToPeriodicReportReceivers($title, $message, $reportId, $userType, $status) {
      $report = GetPeriodicReportById($reportId);
    if ($userType == 2) {
     
        $users = GetBuildingReceivers($report->BuildingId);
        foreach ($users as $user) {
            SendFireBaseNotification($user, $title, $message, $reportId, $status);
        }
    }
    if ($userType == 4) {
        $users = GetBuildingSupervisors($report->BuildingId);
        foreach ($users as $user) {
            SendFireBaseNotification($user, $title, $message, $reportId, $status);
        }
    }
    if ($userType == 0) {
        $users = GetUsersFilterByType(0);
        foreach ($users as $user) {
            SendFireBaseNotification($user->Id, $title, $message, $reportId, $status);
        }
    }
}


?>