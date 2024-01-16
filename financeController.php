<?php

    include 'finance.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['add'])) {
            $amount = $_POST['amount'];
            $type = $_POST['type'];
            $type = $_POST['type'];

            if ($type === 'expense') {
                $amount = -$amount;
            }

            Transaction::addTransaction($amount, $type);
        } elseif (isset($_POST['update'])) {
            $index = $_POST['index'];
            $amount = $_POST['amount'];
            $type = $_POST['type'];

            Transaction::updateTransaction($index, $amount, $type);
        } elseif (isset($_POST['delete'])) {
            $index = $_POST['index'];

            Transaction::deleteTransaction($index);
        } elseif (isset($_POST['export'])) {
            // Ekspor data ke CSV
            Transaction::exportToCSV();
            header('Location: index.php'); // Redirect back to the main page
            exit;
        }
    }

    $transactions = Transaction::getTransactions();
    include 'mainView.php';


?>
