<?php
include('../includes/connection.php');
$user_email = $_GET['email'];
$query_initil_capital = mysqli_query($conn, "DELETE FROM `initaila_capital` WHERE user_email = '$user_email'");
$query_trades = mysqli_query($conn, "DELETE FROM `trade` WHERE user_email = '$user_email'");
if ($query_initil_capital and $query_trades) {
    echo "<meta http-equiv=\"refresh\" content=\"0; url=../main.php\">";
}
