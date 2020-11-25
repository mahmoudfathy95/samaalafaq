<!DOCTYPE html>
<html>
    <head>
        <?php
        $PageTitle = "Home";
        include 'Shared/Head.php';
        ?>
    </head>
    <body  id="page-top">
        <?php include 'Shared/Nav.php'; ?>
        <div id="wrapper">
            <!-- Menu Here -->
            <?php
            include 'Shared/Menu.php';
            include_once $_SERVER['DOCUMENT_ROOT'] . '/Logic/PeriodicReportLogic.php';
            //echo count($test[0]);
            ?>
            <div class="container">
                <div class="card card-login mx-auto mt-5">
                    <div class="card-header">معلومات الاتصال</div>
                    <div class="card-body">
                        <form  method="Post" action="<?php $_PHP_SELF ?>" role="form" novalidate="novalidate">
                            <?php
                            $template = GetMaintenanceTemplateDetails(1);
                            echo '<h1>' . $template->TemplateName . '</h1>';

                            function GetTreeHtml($TreeNode) {
                                $treehtml = "";
                                if (count($TreeNode->SubNodes) > 0) {
                                    //Parent Node
                                    $treehtml = $treehtml . "<li>" . $TreeNode->Title . "<ul>";
                                    foreach ($TreeNode->SubNodes as $subnode) {
                                        $treehtml = $treehtml . GetTreeHtml($subnode);
                                    }
                                    $treehtml = $treehtml . "</ul></li>";
                                } else {
                                    //Leaf Node
                                    $treehtml = $treehtml . "<li>" . $TreeNode->Title . "</li>";
                                }
                                return $treehtml;
                            }

                            foreach ($template->TreeNodes as $TreeNode) {
                                echo '<ul>' . GetTreeHtml($TreeNode) . "</ul>";
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>

        </div>


        <!-- Footer Here -->
        <?php
        include 'Shared/Footer.php';
        ?>

    </body>
</html>
