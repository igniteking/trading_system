<?php include('./includes/connection.php'); ?>
<?php include('./components/header.php'); ?>
<?php include('./includes/functions.php'); ?>
<?php include('./includes/global.php'); ?>
<?php
if (isset($_SESSION['email'])) {
} else {
    echo "<meta http-equiv=\"refresh\" content=\"0; url=./helpers/logout.php\">";
    exit();
}
?>

<body>
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
        <?php include('./components/headerBar.php'); ?>
        <!-- Header -->
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <!-- Card stats -->
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--6">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">Trading Sheet</h3>
                                </div>
                                <!-- <div class="col text-right">
                                    <a href="#!" class="btn btn-sm btn-primary">See all</a>
                                </div> -->
                            </div>
                        </div>
                        <?php
                        if (isset($_POST['save'])) {
                            $created_at = date('Y-m-d H:i:s');
                            $sql_query = mysqli_query($conn, "INSERT INTO `trade`(`id`, `user_email`, `result`, `trade_amount`, `return_amount`, `current_portfolio`, `created_at`) VALUES
                                 (NULL,'$email','$result','$trade_amount','$return_amount','$current_portfolio','$created_at')");
                            echo "<div class='error-styler'>
                                <center>
                                    <p style='padding: 10px; margin: 10px; font-size: 14px; color: #fff; font-weight: 600; border-radius: 8px; text-align: center; background: #06d6a0;'>Saved!</p>
                                </center>
                            </div>";
                        }
                        ?>

                        <div class="table-responsive">
                            <!-- Projects table -->
                            <style>
                                .frame {
                                    transform: scale(1.04);
                                    transform-origin: 0 0;
                                }

                                .table-responsive::-webkit-scrollbar {
                                    display: none;
                                }
                            </style>
                            <iframe width="100%" class="frame" height="900" frameborder="0" scrolling="no" src="https://onedrive.live.com/embed?resid=68841761E73350F1%21402&authkey=%21AN2s_-gnXw9abNQ&em=2&wdAllowInteractivity=False&AllowTyping=True&Item='RRM2_DashBoard'!A1%3AO44&wdHideGridlines=True&wdInConfigurator=True&wdInConfigurator=True&edesNext=true&resen=false&ed1JS=false"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <?php include('./components/footer2.php'); ?>
            <?php include('./components/script.php'); ?>