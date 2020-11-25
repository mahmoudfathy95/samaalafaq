<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<footer class="sticky-footer">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
             
        </div>
    </div>
</footer>


<!-- Bootstrap core JavaScript-->
<script src="/admin/vendor/jquery/jquery.min.js"></script>
<script src="/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="/admin/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Page level plugin JavaScript-->
<script src="/admin/vendor/chart.js/Chart.min.js"></script>
<script src="/admin/vendor/datatables/jquery.dataTables.js"></script>
<script src="/admin/vendor/datatables/dataTables.bootstrap4.js"></script>

<!-- Custom scripts for all pages-->
<script src="/admin/js/sb-admin.min.js"></script>
<script src="/admin/sweetalert/sweetalert.min.js" type="text/javascript"></script>
<link href="/admin/sweetalert/sweetalert.css" rel="stylesheet" type="text/css"/>
<script src="/admin/JsTree/jstree.min.js" type="text/javascript"></script>

<script>
    function InitDataTable(selector) {
        $(selector).DataTable({
               "aaSorting": [],
        retrieve: true,
        "bFilter": true,
        "bLengthChange": true,
        "oLanguage": {
            "sEmptyTable": "لا يوجد بيانات",
            "sSearch": "بحث ",
            "oPaginate": { 
                "sNext": 'التالي',
                "sLast": 'الاخير',
                "sFirst": 'الاول',
                "sPrevious": 'السابق' 
            },
             "zeroRecords":   "لا يوجد بيانات",
              "lengthMenu":"عرض _MENU_ بالصفحة",
            "sInfoPostFix ": "Got a total of _TOTAL_ entries to show (_START_ to _END_)",
            "sInfo": "عرض _START_  الى _END_  من _TOTAL_ ",
            "sInfoEmpty": "عرض 0 to 0 of 0 "
        }});
    }
    function DestroyDataTable(selector) {
        $(selector).DataTable().destroy();
    }
</script>
