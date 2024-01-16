<!-- historyView.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Finance App</title>
</head>
<body>
    <div class="container mt-4 mb-5">
        <h1 class="mb-4">Transaction History</h1>

        <p class="mt-4">Balance: <?= Transaction::getBalance(); ?></p>

        <form method="post" action="">
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="text" class="form-control" name="amount" required>
            </div>

            <div class="form-group">
                <label for="type">Type:</label>
                <select class="form-control" name="type">
                    <option value="income">Income</option>
                    <option value="expense">Expense</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" name="add">Add Transaction</button>
        </form>

        <div class="table-responsive mt-4 max-height">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through transactions and display them -->
                    <?php foreach ($transactions as $index => $transaction): ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= $transaction['amount']; ?></td>
                            <td><?= $transaction['type']; ?></td>
                            <td><?= $transaction['created_at']; ?></td>
                            <td>
                                <form method="post" action="">
                                    <input type="hidden" name="index" value="<?= $index; ?>">
                                    <input type="hidden" name="amount" value="<?= $transaction['amount']; ?>">
                                    <input type="hidden" name="type" value="<?= strtolower($transaction['type']); ?>">
                                    <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-row-reverse bd-highlight mt-4">
            <button type="submit" class="btn btn-success" name="export">Export to CSV</button>
        </div>
    </div>
</body>

<style>
    /* Custom CSS for setting max-height */
    .max-height {
        max-height: 500px; /* Set your desired max height here */
        overflow-y: auto;  /* Add vertical scrollbar if content overflows */
    }
</style>