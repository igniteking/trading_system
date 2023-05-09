<?php
include('../includes/connection.php');
$action = $_GET['action'];
if ($action == 'W') {
    $initial_capital = $_GET['initial_capital'];
    $trade_amount = $_GET['trade_amount'];
    $profit = round(0.82 * $trade_amount, 2);
    $current_portfolio = $initial_capital + $profit;
    $date = date('Y-m-d H:i:s');
    $win_query = mysqli_query($conn, "INSERT INTO `trade`(`id`, `user_email`, `result`, `trade_amount`, `return_amount`, `current_portfolio`, `created_at`) VALUES (NULL,'$email','$action','$trade_amount','$profit','$current_portfolio','$date')");
    echo '<th scope="row">
    1
    </th>
    <td>
    <select name="action" onblur="action(this.value)" class="form-control" id="action">
        <option value="' . $action . '">' . $action . '</option>
        <option value="W">Win</option>
        <option value="L">Loss</option>
    </select>
    </td>
    <td>
    <?= $tade_amount ?>
    </td>
    <td>
    340
    </td>
    <td>
    <i class="fas fa-arrow-up text-success mr-3"></i> <?= $tade_amount ?>
    </td>';
} else {
    echo '<th scope="row">
    1
    </th>
    <td>
    <select name="action" onblur="action(this.value)" class="form-control" id="action">
        <option value="' . $action . '">' . $action . '</option>
        <option value="W">Win</option>
        <option value="L">Loss</option>
    </select>
    </td>
    <td>
    <?= $tade_amount ?>
    </td>
    <td>
    340
    </td>
    <td>
    <i class="fas fa-arrow-up text-success mr-3"></i> <?= $tade_amount ?>
    </td>';
}
