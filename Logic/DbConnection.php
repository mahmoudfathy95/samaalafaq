<?php
session_start();
class DbConnection {

//Server Conncetio
   static $servername = "localhost"; 
    static $username = "samaalaf_admin";
    static $password = "Sama$1456879";
    static $dbname = "samaalaf_db";


    function SelectData($sqlQuery, $Params, $className = null) {

        $db = new PDO('mysql:host=' . self::$servername . ';dbname=' . self::$dbname . ';charset=utf8mb4', self::$username, self::$password);
        // $db = new PDO(self::$dbname, self::$username, self::$password);

        $stmt = $db->prepare($sqlQuery);
        $stmt->execute($Params);
        if ($className != null) {
            $result = $stmt->fetchAll(PDO::FETCH_CLASS, $className);
        } else {
            $result = $stmt->fetchAll();
        }
        return $result;
    }

    function SelectGroupedData($sqlQuery, $Params, $className = null) {

        $db = new PDO('mysql:host=' . self::$servername . ';dbname=' . self::$dbname . ';charset=utf8mb4', self::$username, self::$password);
        // $db = new PDO(self::$dbname, self::$username, self::$password);

        $stmt = $db->prepare($sqlQuery);
        $stmt->execute($Params);
        $result = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);
        return $result;
    }

    function RunQuery($sqlQuery, $Params) {

        $db = new PDO('mysql:host=' . self::$servername . ';dbname=' . self::$dbname . ';charset=utf8mb4', self::$username, self::$password);
        // $db = new PDO(self::$dbname, self::$username, self::$password);
        $stmt = $db->prepare($sqlQuery);

        $stmt->execute($Params);
        return $db->lastInsertId();
//        $affected_rows = $stmt->rowCount();
//        $affected_rows;
    }

}
 

function CheckLogin() {
    if (IsLoggedIn() == false) {
        redirect("/admin/Login.php");
        return;
    }
}

function IsLoggedIn() { 
    return isset($_SESSION["UserId"]);
}

?>