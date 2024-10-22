<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <a href="index.php">Return to home</a>

    <?php
    if (isset($_GET['client_id'])) {
        $client_id = $_GET['client_id'];
        $getAllInfoByClientID = getAllInfoByClientID($pdo, $client_id);

        if ($getAllInfoByClientID) {
            echo "<h1>Client: " . htmlspecialchars($getAllInfoByClientID['loan_Client']) . "</h1>";
        } else {
            echo "<h1>No client found or query failed.</h1>";
            exit; // Stop further processing if no client is found
        }
    } else {
        echo "<h1>Client ID is missing.</h1>";
        exit; // Exit if client_id is not set in URL
    }
    ?>

    <h1>Add New Loan</h1>
    <form action="core/handleForms.php?client_id=<?php echo htmlspecialchars($client_id); ?>" method="POST">
        <p>
            <label for="loan_amount">Loan Amount: </label> 
            <input type="number" name="loan_amount">
        </p>
        <p>
            <label for="interest_rate">Interest Rate: </label> 
            <input type="number" name="interest_rate">
        </p>
        <p>
            <label for="loan_date">Loan Date: </label> 
            <input type="date" name="loan_date">
        </p>
        <p>
            <label for="due_date">Due Date: </label> 
            <input type="date" name="due_date">
        </p>
        <p>
            <input type="submit" name="insertNewLoanBtn">
        </p>
    </form>

    <table style="width:100%; margin-top: 50px;">
        <tr>
            <th>Loan ID</th>
            <th>Loan Amount</th>
            <th>Interest Rate</th>
            <th>Loan Date</th>
            <th>Due Date</th>
            <th>Action</th>
        </tr>
        <?php
        $getLoanByClient = getLoanByClient($pdo, $client_id);
        
        if (empty($getLoanByClient)) {
            echo "<tr><td colspan='8'>No Loan found for this Client.</td></tr>";
        } else {
            foreach ($getLoanByClient as $row) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['loan_id']); ?></td>      
                    <td><?php echo htmlspecialchars($row['loan_amount']); ?></td>    
                    <td><?php echo htmlspecialchars($row['interest_rate']); ?></td>
                    <td><?php echo htmlspecialchars($row['loan_date']); ?></td>    
                    <td><?php echo htmlspecialchars($row['due_date']); ?></td>
                    <td>
                        <a href="editloan.php?loan_id=<?php echo htmlspecialchars($row['loan_id']); ?>&client_id=<?php echo htmlspecialchars($client_id); ?>">Edit</a>
                        <a href="deleteloan.php?loan_id=<?php echo htmlspecialchars($row['loan_id']); ?>&client_id=<?php echo htmlspecialchars($client_id); ?>">Delete</a>
                    </td>    
                </tr>
            <?php }
        }
        ?>
    </table>
</body>
</html>
