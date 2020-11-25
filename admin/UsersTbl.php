<table class="userTbl table table-bordered" dir="rtl" style="width:100%">
    <thead>
        <tr>
            <th>الاسم</th>
            <th>اسم الدخول</th>
            <th>البريد الالكتروني</th>
            <th>الجوال</th> 
            <?php if ($UserType == 1) { ?>
                <th class="condView CondView1">عنوان المبنى</th>
                <th class="condView CondView1">الرقم الوزاري</th>
            <?php }if ($UserType == 2) { ?>
                <th class="condView CondView2">الرقم الوظيفي</th>
                <th class="condView CondView2">رقم الهوية</th>
            <?php }if ($UserType == 3) { ?>
                <th class="condView CondView3">الرقم الوظيفي للمشرف</th> 
   
                <th class="condView CondView3">اسم المشرف</th> 
            <?php }if ($UserType == 4) { ?> 
                <th class="condView CondView4">الوظيفة</th> 
            <?php }if (!$OnPrint) { ?>
                <th class="printDelete">تغيير كلمة المرور</th>
                <th class="printDelete">تعديل</th>
                <th class="printDelete">حذف</th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/Shared/Logic.php';
        $users = GetUsersFilterByType($UserType);
        foreach ($users as $user) {
            ?>
            <tr>
                <td><?php echo $user->Name; ?></td>
                <td><?php echo $user->UserName; ?></td>
                <td><?php echo $user->Email; ?></td>
                <td><?php echo $user->Mobile; ?></td>
                <?php if ($UserType == 1) { ?>
                    <td class="condView CondView1"><?php echo $user->BuildingAddress; ?></td>
                    <td class="condView CondView1"><?php echo $user->MinistryNumber; ?></td>
                <?php }if ($UserType == 2) { ?>
                    <td class="condView CondView2 "><?php echo $user->JobNumber; ?></td>
                    <td class="condView CondView2"><?php echo $user->IdentityNumber; ?></td>
                <?php }if ($UserType == 3) { ?>
                    <td class="condView CondView3 "><?php echo $user->JobNumber; ?></td> 
   
                    <td class="condView CondView3"><?php echo $user->SupervisorName; ?></td> 
                <?php }if ($UserType == 4) { ?>
                    <td class="condView CondView4"><?php echo $user->Job; ?></td> 
                <?php }if (!$OnPrint) { ?>
                    <td class="printDelete text-center"><a class="btn btn-success"  href="/admin/changepassword2.php?id=<?php echo $user->Id; ?>&type=<?php echo $user->UserType; ?>"><i class="fa fa-exchange-alt"></i></a></td>
                    <td class="printDelete text-center"><a class="btn btn-info"  href="/admin/useraddedit2.php?id=<?php echo $user->Id; ?>"><i class="fa fa-pencil-alt"></i></a></td>
                    <td class="printDelete text-center"><button class="btn btn-danger" onclick="DeleteUser(this,<?php echo $user->Id; ?>)"><i class="fa fa-times"></i></button></td>
                        <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>
