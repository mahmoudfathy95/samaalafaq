<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/DbConnection.php';
CheckLogin();
?>
<ul class="sidebar navbar-nav">
    <li class="nav-item active">
        <a class="nav-link" href="/admin/index4.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item">

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <i class="fa fa-users"></i>
            <span>المستخدمين</span>
        </a> 
        <div class="dropdown-menu " aria-labelledby="pagesDropdown" x-placement="top-start" >

            <a class="dropdown-item" href="/admin/users2.php?type=0">

                <span>المديرين</span>
            </a>
            <a class="dropdown-item" href="/admin/users2.php?type=1">

                <span>المبنى التعليمي</span></a>
            <a class="dropdown-item" href="/admin/users2.php?type=2">

                <span>مستقبلين البلاغات</span></a>
            <a class="dropdown-item" href="/admin/users2.php?type=3">

                <span>فرق الصيانة</span></a>
            <a class="dropdown-item" href="/admin/users2.php?type=4"> 
                <span>مطلعين الجودة والإدارة</span></a>
        </div>
    </li>

</li>

<li class="nav-item">
    <a class="nav-link" href="/admin/reports2.php">
        <i class="fas fa-fw fa-copy"></i>
        <span>الطلبات</span></a>
</li> 
<li class="nav-item">
    <a class="nav-link" href="/admin/TeamTypes2.php">
        <i class="fas fa-fw fa-users-cog"></i>
        <span>انواع الفرق</span></a>
</li> 
<li class="nav-item">
    <a class="nav-link" href="/admin/TreeTemplates2.php">
        <i class="fas fa-fw fa-wrench"></i>
        <span>قوالب الصيانة </span></a>
</li> 
<li class="nav-item">
    <a class="nav-link" href="/admin/PeriodicReports2.php">
        <i class="fas fa-fw fa-file-signature"></i>
        <span>البلاغات الدورية</span></a>
</li> 
</ul>
