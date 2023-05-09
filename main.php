<?php include('./includes/connection.php');
$check = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM initaila_capital WHERE user_email = '$email'"));
if ($check > 0) {
    echo "<meta http-equiv=\"refresh\" content=\"0; url=./index.php\">";
} ?>
<?php include('./includes/functions.php'); ?>
<?php include('./components/header.php'); ?>

<body class="bg-default">
    <!-- Navbar -->
    <!-- Main content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                            <h1 class="text-white">Trading Details</h1>
                            <p class="text-lead text-white">Provide the required information for your trading system.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        <!-- Page content -->
        <div class="container mt--9 pb-5">
            <!-- Table -->
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <?php
                    $submit = @$_POST['submit'];
                    if ($submit) {
                        $user_email = $email;
                        $initial_capital = @$_POST['initial_capital'];
                        $total_trades = @$_POST['total_trades'];
                        switch ($total_trades) {
                            case "1":
                                $formulae = 1;
                                break;
                            case "2":
                                $formulae = 3.22;
                                break;
                            case "3":
                                $formulae = 8.15;
                                break;
                            case "4":
                                $formulae = 19.08;
                                break;
                            case "5":
                                $formulae = 43.35;
                                break;
                            case "6":
                                $formulae = 97.2158;
                                break;
                            case "7":
                                $formulae = 215.7716;
                                break;
                            case "8":
                                $formulae = 478.9077;
                                break;
                            case "9":
                                $formulae = 1062.9415;
                                break;
                            case "10":
                                $formulae = 2359.2116;
                                break;
                            default:
                                $error;
                        }
                        $date = date("Y-m-d H:i:s");
                        $sql = mysqli_query($conn, "INSERT INTO `initaila_capital`(`id`, `user_email`, `initial_capital`, `current_capital`, `number_of_trades`, `formulae`, `created_at`) VALUES (NULL,'$user_email','$initial_capital', '$initial_capital','$total_trades', '$formulae','$date')");
                        if ($sql) {
                            echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\">";
                        } else {
                            echo "error";
                        }
                    }
                    ?>
                    <div class="card bg-secondary border-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <form method="post" action="./main.php">
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Initial Capital" name="initial_capital" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Total Trades" step="1" name="total_trades" max="10" type="number">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                        <input class="form-control" disabled value="Total Number of Wins = 1" type="text">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <input type="submit" name="submit" value="Move Ahead" class="btn btn-primary mt-4">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('./components/footer.php'); ?>
    <?php include('./components/script.php'); ?>