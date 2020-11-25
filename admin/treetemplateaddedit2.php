<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/Shared/Logic.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        $PageTitle = "إضافة قالب صيانة";
        if (isset($_GET["id"])) {
            $PageTitle = "تعديل قالب صيانة";
        }
        include 'Shared/Head.php';
        ?>
    </head>
    <body  id="page-top">
        <form>
            <?php include 'Shared/Nav.php'; ?>
            <div id="wrapper">
                <!-- Menu Here -->
                <?php
                include 'Shared/Menu.php';
                //echo count($test[0]);
                ?>
                <div id="content-wrapper"> 
                    <div class="container-fluid ">

                        <?php
//                    $template = GetMaintenanceTemplateDetails(1);
//                     
//
//                    function GetTreeHtml($TreeNode) {
//                        $treehtml = "";
//                        if (count($TreeNode->SubNodes) > 0) {
//                            //Parent Node
//                            $treehtml = $treehtml . "<li>" . $TreeNode->Title . "<ul>";
//                            foreach ($TreeNode->SubNodes as $subnode) {
//                                $treehtml = $treehtml . GetTreeHtml($subnode);
//                            }
//                            $treehtml = $treehtml . "</ul></li>";
//                        } else {
//                            //Leaf Node
//                            $treehtml = $treehtml . "<li>" . $TreeNode->Title . "</li>";
//                        }
//                        return $treehtml;
//                    }
//
//                    foreach ($template->TreeNodes as $TreeNode) {
//                        echo '<ul>' . GetTreeHtml($TreeNode) . "</ul>";
//                    }
                        ?>


                        <!--content here-->
                        <div class="page-head">
                            <div class="pull-right">     
                                <button class="btn btn-info" type="button" onclick="SaveTreeTemplate();"><i class="fa fa-save"></i>  حفظ</button>
                                <a class="btn btn-warning" href="/admin/treetemplateaddedit2.php"><i class="fa fa-plus-circle"></i> جديد  </a>
                                <a class="btn btn-success" href="/admin/TreeTemplates2.php"><i class="fa fa-reply"></i></a>
                            </div>
                            <div class="pull-left">
                                <h2><i class="fa fa-wrench"></i>
                                    <?php echo $PageTitle; ?></h2>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <div class="form-row">
                                    <?php if (isset($result)) { ?>
                                        <div class="col-lg-12">
                                            <div class="alert alert-info"><?php echo $result; ?></div>
                                        </div>
                                    <?php } ?>
                                    <input type="hidden" value="<?php echo $TeamType->Id ?>" name="Id"/>
                                    <div class="col-md-3">
                                        <div class="form-label-group">
                                            <input type="text" id="TemplateName" oninput="ChangeTreeName();" name="Name" class="form-control" placeholder="الاسم" required="required" value="">
                                            <label for="TemplateName">اسم قالب الصيانة</label>
                                        </div>
                                    </div>
                                    <div class="col-md-9 ">
                                        <div class="pull-right">
                                            <p>الصيانة المطلوبة</p>
                                            <input type="Text" id="NodeEditor"/>
                                            <button class="btn btn-info" onclick="SaveNodeItem();" type="button"><i id="btnicon" class="fa fa-plus-circle"></i></button>

                                            <h1 onclick="DeselectNodes();"  id="TreeHeader">  
                                            </h1>
                                            <div class="tree">
                                                <ul id="TreeRoot"></ul> 
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div> 
                        </div>   

                    </div>
                </div>
            </div>
        </form>

        <!-- Footer Here -->
        <?php
        include 'Shared/Footer.php';
        ?>
        <script>
            var TreeId = 0, OnEditNode = 0, SelectedNodeText = "", SelectedNode = null, nodes = [], treeview;
<?php
if (isset($_GET["id"])) {
    echo "TreeId=" . $_GET["id"] . ";LoadTreeTemplate();";
}
?>

            function ChangeTreeName() {
                $("#TreeHeader").text($("#TemplateName").val());
            }
            function DeselectNodes() {
                $('.tree').jstree().deselect_node(SelectedNode);
                SelectedNode = null;
            }

            //Save Node From Input To Tree
            function SaveNodeItem() {
                title = $("#NodeEditor").val();
                if (title != "")
                {
                    var id = Math.random().toString(36).substring(3);

                    debugger;
                    if (OnEditNode != 0) {
                        //Update Node 
                        $('.tree').jstree('rename_node', OnEditNode, title);
                        GetNodeById(OnEditNode).Title = title;
                    }
                    else {
                        //Insert Node 
                        nodes.push({Id: id, ParentId: SelectedNode, Title: title});
                        $('.tree').jstree().create_node(SelectedNode, {"id": id, "text": title}, "last");
                        $('.tree').jstree("open_node", SelectedNode);
                    }

                    $("#NodeEditor").val("");
                    OnEditNode = 0;
                    $("#btnicon").attr("class", "fa fa-plus-circle");
                }
            }
            BuildTree();
            function BuildTree() {

                treeview = $('.tree').jstree({
                    "core": {
                        "multiple": false,
                        "check_callback": true,
                    },
                    "plugins": [
                        "contextmenu",
                        "search", "crrm"
                    ], "search": {
                        'case_insensitive': false,
                        'show_only_matches': true
                    }, "contextmenu": {
                        "items": function ($node) {
                            return {
                                "Edit": {
                                    "separator_before": false,
                                    "separator_after": false,
                                    "label": "تعديل",
                                    "icon": "JsTree/themes/default/edit.png",
                                    "action": function (obj) {
                                        $("#NodeEditor").val(SelectedNodeText);
                                        $("#NodeEditor").focus();
                                        OnEditNode = SelectedNode;
                                        $("#btnicon").attr("class", "fa fa-save");
                                    }
                                },
                                "Delete": {
                                    "separator_before": false,
                                    "separator_after": false,
                                    "label": "حذف",
                                    "icon": "JsTree/themes/default/remove.png",
                                    "action": function (obj) {
                                        swal({
                                            title: 'تأكيد الحذف',
                                            text: 'هل انت متاكد انك تريد حذف هذا العنصر و كل العناصر التابعه له؟',
                                            type: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: "#DD6B55",
                                            confirmButtonText: "نعم",
                                            cancelButtonText: "لا",
                                            closeOnConfirm: true,
                                            closeOnCancel: true
                                        }, (function () {
                                            GetNodeById(SelectedNode).Deleted = true;

                                            var selectedNodes = $(".tree").jstree(true).get_json(SelectedNode, {flat: true}); 
                                            for (var i = 0; i < selectedNodes.length; i++)
                                            {
                                                GetNodeById(selectedNodes[i].id).Deleted = true;
                                            }
                                            $('.tree').jstree(true).delete_node(SelectedNode);
                                        }));


                                    }
                                }
                            };
                        }
                    }
                });
                $('.tree').on(
                        "select_node.jstree", function (evt, data) {

                            //selected node object: data.node;
                            SelectedNode = data.node.id;
                            SelectedNodeText = data.node.text;
                        }
                );
            }

            function SaveTreeTemplate() {

                var TemplateName = $("#TemplateName").val();
                if (TemplateName == "")
                {
                    swal("", "من فضلك ادخل اسم قالب الصيانة");
                    return;
                }
                $.ajax({
                    url: "/api.php/SaveTreeTemplate",
                    type: "post",
                    datatype: "json",
                    data: {TreeId: TreeId, Nodes: nodes, TemplateName: TemplateName},
                    success: function (data) {
                        console.log(data);
                        data = JSON.parse(data);
                        if (data.result == "Done") {
                            swal(
                                    {
                                        title: " ",
                                        text: "تم حفظ قالب الصيانة",
                                        type: "success",
                                        confirmButtonText: "موافق"
                                    }, function () {
                                window.location.reload();
                            });
                        }
                        else
                        {
                            swal("", "فشل اثناء الحفظ من فضلك حاول مره اخرى");
                        }

                    }
                });
            }

            function LoadTreeTemplate() {
                $.ajax({
                    url: "/api.php/GetTreeTemplate",
                    type: "post",
                    datatype: "json",
                    data: {Id: TreeId},
                    success: function (data) {
                        data = JSON.parse(data);
                        $("#TemplateName").val(data.TemplateName).trigger("input");
                        nodes = data.TreeNodes;
                        for (var i = 0; i < data.TreeNodes.length; i++) {
                            var node = data.TreeNodes[i];
                            if (node.ParentId == "")
                                node.ParentId = "#";
                            $('.tree').jstree().create_node(node.ParentId, {"id": node.Id, "text": node.Title}, "last");
                            $('.tree').jstree("open_node", node.ParentId);
                        }
                    }
                });
            }

            function GetNodeById(id) {

                for (var i = 0; i < nodes.length; i++) {
                    if (nodes[i].Id == id)
                        return nodes[i];
                }
            }
        </script>
    </body>
</html>
