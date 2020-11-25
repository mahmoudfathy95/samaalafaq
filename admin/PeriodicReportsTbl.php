<table class="PeriodicReportTbl table table-bordered" dir="rtl" style="width:100%">
    <thead>
        <tr>
            <th>المبنى</th> 
            <th>الفريق</th> 
            <th>حالة الطلب</th> 
            <th>تاريخ الارسال</th> 
            <th>تم الارسال</th> 
           <?php if (!$OnPrint) { ?> 
                <th class="printDelete">عرض</th>
                <th class="printDelete">حذف</th>
            <?php } ?> 
        </tr>
    </thead>
    <tbody>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/Shared/Logic.php';
        $PeriodicReports = ListAllPeriodicReports();
        foreach ($PeriodicReports as $PeriodicReport) {
            ?>
            <tr>
                <td><?php echo $PeriodicReport->BuildingId; ?></td>   
                <td><?php echo $PeriodicReport->TeamId; ?></td>  
                <td><?php echo $PeriodicReportsStatus[$PeriodicReport->ReportStatus]; ?></td>    
                <td><?php echo date("m/d/Y", $PeriodicReport->SendDate); ?></td>    
                <td><?php echo $PeriodicReport->IsSent ? "<i class='fa fa-check success'></i> نعم" : "<i class='fa fa-times danger'></i> لا"; ?></td>    
                <td class="printDelete text-center"><a class="btn btn-info"  href="/admin/PeriodicReportAddEdit2.php?id=<?php echo $PeriodicReport->Id; ?>"><i class="fa fa-pencil-alt"></i></a></td>
                <td class="printDelete text-center"><button class="btn btn-danger" onclick="DeletePeriodicReport(this,<?php echo $PeriodicReport->Id; ?>)"><i class="fa fa-times"></i></button></td>

            </tr>
        <?php } ?>
    </tbody>
</table>