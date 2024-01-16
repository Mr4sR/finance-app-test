<?php
    class Transaction
    {
        private static $csvFilePath = 'transactions.csv';
        private static $balanceFilePath = 'balance.txt';    
    
        public static function exportToCSV($filename = 'exported_transactions.csv')
        {
            $transactions = self::getTransactions();
    
            if (!empty($transactions)) {
                $file = fopen($filename, 'w');
    
                // Write header
                fputcsv($file, array_keys($transactions[0]));
    
                // Write data
                foreach ($transactions as $transaction) {
                    fputcsv($file, $transaction);
                }
    
                fclose($file);
    
                return true;
            }
    
            return false;
        }
        public static function getTransactions()
        {
            $transactions = [];
    
            if (($file = fopen(self::$csvFilePath, 'r')) !== false) {
                while (($data = fgetcsv($file)) !== false) {
                    $transactions[] = [
                        'amount' => $data[0],
                        'type' => $data[1], // Make sure 'type' is the correct column index
                        'created_at' => $data[2],
                    ];
                }
                fclose($file);
            }
    
            return array_reverse($transactions); // Reverse array to show latest transactions first
        }
    
        public static function addTransaction($amount, $type)
        {
            $type = ($type === 'income') ? 'Income' : 'Expense';
            $data = [$amount, $type, date('Y-m-d H:i:s')];
    
            $file = fopen(self::$csvFilePath, 'a');
            fputcsv($file, $data);
            fclose($file);
    
            // Update balance
            $balance = self::getBalance();
            $balance += $amount;
            self::updateBalance($balance);
        }
    
        public static function deleteTransaction($index)
        {
            $transactions = self::getTransactions();
            if (isset($transactions[$index])) {
                $amount = $transactions[$index]['amount'];
    
                // Update balance
                $balance = self::getBalance();
                $balance -= $amount;
                self::updateBalance($balance);
    
                unset($transactions[$index]);
    
                $file = fopen(self::$csvFilePath, 'w');
                foreach ($transactions as $transaction) {
                    fputcsv($file, $transaction);
                }
                fclose($file);
            }
        }
    
        public static function getBalance()
        {
            if (file_exists(self::$balanceFilePath)) {
                return (float) file_get_contents(self::$balanceFilePath);
            }
    
            return 0;
        }
    
        private static function updateBalance($balance)
        {
            file_put_contents(self::$balanceFilePath, $balance);
        }
        public static function updateTransaction($index, $amount, $type)
        {
            $transactions = self::getTransactions();
            if (isset($transactions[$index])) {
                $transactions[$index]['amount'] = $amount;
                $transactions[$index]['type'] = $type;
    
                $file = fopen(self::$csvFilePath, 'w');
                foreach ($transactions as $transaction) {
                    fputcsv($file, $transaction);
                }
                fclose($file);
            }
        }
    }

?>
