<table class="ReportTbl table table-bordered" dir="rtl" style="width:100%">
    <thead>
        <tr>
            <th>رقم الطلب</th> 
            <th>الطلب</th>
            <th>صاحب الطلب</th>
            <th>فريق الصيانة</th>
            <th>الحالة</th> 
            <th>الاهمية</th> 
            <th>تاريخ الطلب</th> 

<!--            <th>رسالة اكتمال الطلب</th> -->
            <?php if (!$OnPrint) { ?> 
                <th class="printDelete">عرض</th>
                <th class="printDelete">حذف</th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/Shared/Logic.php';
        $reports = ListReports();
        foreach ($reports as $report) {
            ?>
            <tr>
                <td><?php echo $report->Id; ?></td>  
                <td><?php echo limit_text($report->ReportText, 40); ?></td> 
                <td><?php echo $report->CreatedBy_Name; ?></td> 
                <td><?php echo $report->MaintenanceTeam_Name; ?></td> 
                <td><?php echo $ReportStatus[$report->ReportStatus]; ?></td>  
                <td><?php echo $Importances[$report->Importance]; ?></td>  
                <td><?php echo ConvertFromUnixDate($report->CreatedAt); ?></td> 



                <?php if (!$OnPrint) { ?>
                    <td class="printDelete text-center"><a class="btn btn-info"  href="/admin/reportdetails2.php?id=<?php echo $report->Id; ?>"><i class="fa fa-eye"></i></a></td>
                    <td class="printDelete text-center"><button class="btn btn-danger" onclick="DeleteReport(this,<?php echo $report->Id; ?>)"><i class="fa fa-times"></i></button></td>
                        <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>
