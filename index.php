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
    <!-- Sidenav -->
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
        <?php include('./components/headerBar.php'); ?>
        <!-- Header -->
        <!-- Header -->
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <!-- Card stats -->
                    <div class="row">
                        <div class="col-xl-6 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Initial Capital</h5>
                                            <span class="h2 font-weight-bold mb-0"><?php echo array_values(mysqli_fetch_array($conn->query("SELECT `initial_capital` FROM `initaila_capital` WHERE user_email='$email'")))[0]; ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                                <i class="ni ni-active-40"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Total Trades</h5>
                                            <span class="h2 font-weight-bold mb-0"><?php echo array_values(mysqli_fetch_array($conn->query("SELECT `number_of_trades` FROM `initaila_capital` WHERE user_email='$email'")))[0]; ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                                <i class="ni ni-chart-pie-35"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                    <h3 class="mb-0">Trading System</h3>
                                </div>
                                <div class="col text-right">
                                    <a href="./helpers/reset.php?email=<?= $email ?>" class="btn btn-sm btn-danger">Reset all</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Trade Result(W/L)</th>
                                        <th scope="col">Trade Amount</th>
                                        <th scope="col">Profit/Loss</th>
                                        <th scope="col">Current Capital</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (@$_POST['tade_test']) {
                                        $action = $_POST['action'];
                                        if ($action == 'W') {
                                            $proloss = @$_POST['pro_loss'];
                                            $initial_capital = @$_POST['initial_capital'];
                                            $trade_amount = @$_POST['trade_amount'];
                                            $profit = round(0.82 * $trade_amount, 2);
                                            $current_portfolio = $initial_capital + $profit;
                                            $date = date('Y-m-d H:i:s');
                                            $win_query = mysqli_query($conn, "INSERT INTO `trade`(`id`, `user_email`, `result`, `trade_amount`, `return_amount`, `current_portfolio`, `created_at`) VALUES (NULL,'$email','$action','$trade_amount','$profit','$current_portfolio','$date')");
                                            $update_query = mysqli_query($conn, "UPDATE `initaila_capital` SET `current_capital`='$current_portfolio' WHERE user_email = '$email'");
                                            if ($update_query) {
                                                echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\">";
                                            }
                                        } else if ($action == 'L') {
                                            $proloss = @$_POST['pro_loss'];
                                            $initial_capital = @$_POST['initial_capital'];
                                            $trade_amount = @$_POST['trade_amount'];
                                            $loss = round(1.00 * $trade_amount, 2);
                                            $current_portfolio = $initial_capital - $loss;
                                            $date = date('Y-m-d H:i:s');
                                            $loss_query = mysqli_query($conn, "INSERT INTO `trade`(`id`, `user_email`, `result`, `trade_amount`, `return_amount`, `current_portfolio`, `created_at`) VALUES (NULL,'$email','$action','$trade_amount','-$loss','$current_portfolio','$date')");
                                            $update_query = mysqli_query($conn, "UPDATE `initaila_capital` SET `current_capital`='$current_portfolio' WHERE user_email = '$email'");
                                            if ($update_query) {
                                                echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\">";
                                            }
                                        } else {
                                            echo '<div class="col-md-12 bg-danger text-white text-center p-2">Select At Least One Possibility!</div>';
                                        }
                                    }
                                    $check = mysqli_query($conn, "SELECT * FROM `trade` WHERE user_email = '$email'");
                                    $row_check = mysqli_num_rows($check);
                                    $sql = mysqli_query($conn, "SELECT * FROM `initaila_capital` WHERE user_email = '$email'");
                                    while ($row = mysqli_fetch_array($sql)) {
                                        $user_email = $row['user_email'];
                                        $initial_capital = $row['initial_capital'];
                                        $number_of_trades = $row['number_of_trades'] + 1;
                                        $formulae = $row['formulae'];
                                        $trade_amount = round($initial_capital / $formulae, 2);
                                        $final = round(0.82 * $trade_amount, 2);
                                        $current_capital = $row['current_capital'];
                                        if ($row_check > 0) {
                                            $fetch_trades = mysqli_query($conn, "SELECT * FROM `trade` WHERE user_email = '$email'");
                                            while ($row = mysqli_fetch_array($fetch_trades)) {
                                                $user_email = $row['user_email'];
                                                $result = $row['result'];
                                                $trade_amount = $row['trade_amount'];
                                                $return_amount = $row['return_amount'];
                                                $current_portfolio = $row['current_portfolio'];
                                                if ($result == "L") {
                                                    $current_portfolio = '<i class="fas fa-arrow-down text-danger mr-3"></i>' . $current_portfolio;
                                                } else {
                                                    $current_portfolio = '<i class="fas fa-arrow-up text-success mr-3"></i>' . $current_portfolio;
                                                }
                                                echo '<tr>
                                                    <td>
                                                    <select disabled class="form-control" id="action">
                                                    <option value="' . $result . '">' . $result . '</option>
                                                    </select>
                                                    </td>
                                                    <td>
                                                        ' . $trade_amount . '
                                                    </td>
                                                    <td>
                                                    ' . $return_amount . '
                                                    </td>
                                                    <td>
                                                    ' . $current_portfolio . '
                                                    </td>
                                                    <td>
                                                    </td>
                                                    </tr>';
                                                @++$i;
                                            }
                                        }
                                    }
                                    // Assuming you have a database connection established and a table named "mytable"
                                    // Query the database for the column data
                                    $query_checking_for_ending = mysqli_query($conn, "SELECT result FROM trade WHERE user_email = '$email'");
                                    // Initialize a counter
                                    $count = 0;
                                    // Loop through the rows
                                    while ($row = mysqli_fetch_assoc($query_checking_for_ending)) {
                                        // Check if the column value is the same as the previous row
                                        if ($row['result'] == @$prev_value) {
                                            $count++;
                                            // If the counter reaches 5, then 5 rows have the same value
                                        } else {
                                            // Reset the counter if the value is different
                                            $count = 0;
                                        }
                                        // Store the current value for the next iteration
                                        if ($row['result'] == 'L') {
                                            $prev_value = $row['result'];
                                        }
                                    }
                                    $current_capital;
                                    // print_r(array_values(mysqli_fetch_array($conn->query("SELECT current_capital FROM initaila_capital WHERE user_email = '$email'")))[0]);
                                    // echo $new_caps =  $current_capital - array_values(mysqli_fetch_array($conn->query("SELECT current_capital FROM initaila_capital WHERE user_email = '$email'")))[0];
                                    if ($current_capital <= 1) {
                                    } else {
                                        $count;
                                        $chec = array_values(mysqli_fetch_array($conn->query("SELECT number_of_trades FROM initaila_capital WHERE user_email = '$email'")))[0];
                                        if ($count == $chec) {
                                        } else {
                                            if ($result == 'W') {
                                                $trade_amount = round($current_capital / $formulae, 2);
                                            } else if ($result == 'L') {
                                                $result_checkcing = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM trade WHERE result = 'L' AND user_email = '$email'"));
                                                if ($result_checkcing == 2) {
                                                    $result_checkcing = $result_checkcing - 1;
                                                } else if ($result_checkcing == 3) {
                                                    $result_checkcing = $result_checkcing - 2;
                                                } else if ($result_checkcing == 4) {
                                                    $result_checkcing = $result_checkcing - 3;
                                                } else if ($result_checkcing == 5) {
                                                    $result_checkcing = $result_checkcing - 4;
                                                } else if ($result_checkcing == 6) {
                                                    $result_checkcing = $result_checkcing - 5;
                                                } else if ($result_checkcing == 7) {
                                                    $result_checkcing = $result_checkcing - 6;
                                                } else if ($result_checkcing == 8) {
                                                    $result_checkcing = $result_checkcing - 7;
                                                } else if ($result_checkcing == 9) {
                                                    $result_checkcing = $result_checkcing - 8;
                                                } else if ($result_checkcing == 10) {
                                                    $result_checkcing = $result_checkcing - 9;
                                                }
                                                switch ($result_checkcing) {
                                                    case "0":
                                                        $trade_amount = 1.00 * ($trade_amount);
                                                        break;
                                                    case "1":
                                                        $trade_amount = 2.22 * ($trade_amount);
                                                        break;
                                                    case "2":
                                                        $trade_amount = 4.93 * ($trade_amount);
                                                        break;
                                                    case "3":
                                                        $trade_amount = 10.93 * ($trade_amount);
                                                        break;
                                                    case "4":
                                                        $trade_amount = 24.27 * ($trade_amount);
                                                        break;
                                                    case "5":
                                                        $trade_amount = 53.8658 * ($trade_amount);
                                                        break;
                                                    case "6":
                                                        $trade_amount = 118.2158 * ($trade_amount);
                                                        break;
                                                    case "7":
                                                        $trade_amount = 263.1361 * ($trade_amount);
                                                        break;
                                                    case "8":
                                                        $trade_amount = 584.0338 * ($trade_amount);
                                                        break;
                                                    case "9":
                                                        $trade_amount = 1296.2701 * ($trade_amount);
                                                        break;
                                                    default:
                                                        $error;
                                                }
                                            }
                                            echo '<form action="./index.php" method="post">
                                        <tr>
                                            <td>
                                                <select name="action" class="form-control" id="action">
                                                <option value=""></option>
                                                    <option value="W">Win</option>
                                                    <option value="L">Loss</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input readonly type="text" value="' . $trade_amount . '" name="trade_amount" class="form-control border-0">
                                                </td>
                                            <td>
                                                NULL
                                                <input hidden type="text" value="' . $final . '" name="proloss" class="form-control border-0">
                                                </td>
                                            <td>
                                                NULL
                                                <input hidden type="text" value="' . $current_capital . '" name="initial_capital" class="form-control border-0">
                                            </td>
                                            <td>
                                            <input type="submit" name="tade_test" class="btn btn-primary">
                                            </td>
                                        </tr>
                                        </form>';
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <!-- Footer -->
            <?php include('./components/footer2.php'); ?>
            <?php include('./components/script.php'); ?>