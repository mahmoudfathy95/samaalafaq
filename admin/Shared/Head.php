<?php
$SiteName = "Sama AL Afaq";
global $PageTitle;
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/Shared/Logic.php';
?>
<meta charset="utf-8">
<title><?php echo $SiteName . '-' . $PageTitle ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="" />
<meta name="author" content="" />
<!-- Custom fonts for this template-->
<link href="/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

<!-- Page level plugin CSS-->
<link href="/admin/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

<!-- Custom styles for this template-->
<link href="/admin/css/sb-admin.css" rel="stylesheet"> 
<link href="/admin/JsTree/themes/default/style.min.css?v=1" rel="stylesheet" type="text/css"/>
<style>
    .pull-right{
        float:right;
    }   
    .pull-left{
        float:left;
    }    
    .page-head{
        border-bottom:1px solid gray; 
    }
    .btn{
        cursor: pointer;
    }

    /*rtl*/
    body{
        direction: rtl;
        text-align: right;
    }footer.sticky-footer{
        right: initial;
        left:0;
    }.sidebar{
        padding-right: 0;
    }
    .sidebar .nav-item .nav-link{
        text-align: right; 
    }.dataTables_filter label{
        float: left;
    }.pagination{
        direction: ltr;
    }
    .pull-right{
        float: left;
    }
    .pull-left{
        float: right;
    }
    .dropdown-menu-right{
        right: auto;
        left: 0;
    }
    
</style>