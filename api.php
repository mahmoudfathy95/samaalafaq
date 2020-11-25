<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/DbConnection.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/UserLogic.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/ReportLogic.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/FilesUploading.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/FireBase.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/SMSSend.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/BuildingLogic.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/PeriodicReportLogic.php';

//Functions Of Api
include_once $_SERVER['DOCUMENT_ROOT'] . '/Api/ReportsApi.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Api/UsersApi.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Api/PriodicReportApi.php';
//Rout Api Requests To Functions

$urlParams = explode('/', $_SERVER['REQUEST_URI']);
$functionName = $urlParams[2];
$entityBody = json_decode(file_get_contents('php://input'));
$functionName($entityBody);

//header('Content-Type: application/json');

//Generic Api Functions
function PageArray($array, $page, $limit) {

    $page = $page != 0 ? (int) $page : 1;
    $total = count($array); //total items in array

    $totalPages = ceil($total / $limit); //calculate total pages
    $page = max($page, 1); //get 1 page when $_GET['page'] <= 0
    $page = min($page, $totalPages); //get last page when $_GET['page'] > $totalPages
    $offset = ($page - 1) * $limit;
    if ($offset < 0)
        $offset = 0;

    $array2 = array_slice($array, $offset, $limit);
    $result = array(
        'data' => $array2,
        'TotalCount' => $total,
        'TotalPages' => $totalPages,
        'CurrentPage' => $page,
        'ItemPerPage' => $limit
    );
    return $result;
}
function GetHeaderValue($HeaderName) {
    foreach (getallheaders() as $name => $value) {
        if (strtolower($name) == strtolower($HeaderName)) {
            return $value;
        }
    }
}



//----------------------------------- البلاغات الدورية----------------------------------------------------------------------


// ------ new api ------------- 
function GetContactInfo() {
    $query = "SELECT * from settings where id=?";
    $db = new DbConnection();
    $contact = $db->SelectData($query, array(1));
    echo json_encode($contact);
}

?>
