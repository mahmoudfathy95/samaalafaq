<?php

ob_start();
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/UserLogic.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/ReportLogic.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/FireBase.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/BuildingLogic.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/PeriodicReportLogic.php';

function LogOut() {
    $_SESSION["UserId"] = null;
    redirect("/admin/Login.php");
} 
?>