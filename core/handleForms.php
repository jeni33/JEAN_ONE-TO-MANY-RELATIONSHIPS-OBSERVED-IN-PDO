<?php 

require_once 'dbConfig.php'; 
require_once 'models.php';

if (isset($_POST['insertClientBtn'])) {

	$query = insertClient($pdo, $_POST['first_name'], $_POST['last_name'], 
		$_POST['contact_number']);

	if ($query) {
		header("Location: ../index.php");
	}
	else {
		echo "Insertion failed";
	}

}

if (isset($_POST['editClientBtn'])) {
	$query = updateClient($pdo, $_POST['first_name'], $_POST['last_name'], 
		$_POST['contact_number'], $_GET['client_id']);

	if ($query) {
		header("Location: ../index.php");
	}

	else {
		echo "Edit failed";;
	}

}

ob_start();

if (isset($_POST['deleteClientBtn'])) {
    $query = deleteClient($pdo, $_GET['client_id']);

    if ($query) {
        header("Location: ../index.php");
        exit; 
    } else {
        echo "Deletion failed";
    }
}


ob_end_flush();

if (isset($_POST['insertNewLoanBtn'])) {

    if (isset($_GET['client_id'])) {
        $client_id = $_GET['client_id'];
    } else {
        echo "Error: Client ID not found!";
        exit;
    }

    // Validate that POST data exists
    $loan_amount = isset($_POST['loan_amount']) ? $_POST['loan_amount'] : null;
    $interest_rate = isset($_POST['interest_rate']) ? $_POST['interest_rate'] : null;
    $loan_date = isset($_POST['loan_date']) ? $_POST['loan_date'] : null;
    $due_date = isset($_POST['due_date']) ? $_POST['due_date'] : null;

    if ($loan_amount && $interest_rate && $loan_date && $due_date) {
        $query = insertLoan($pdo, $loan_amount, $interest_rate, $loan_date, $client_id, $due_date);
        
        if ($query) {
            header("Location: ../viewloans.php?client_id=" . $client_id);
        } else {
            echo "Insertion failed";
        }
    } else {
        echo "All loan fields are required!";
    }
}


if (isset($_POST['editLoanBtn'])) {
	$query = updateLoan($pdo, $_POST['loan_amount'], $_POST['interest_rate'], 
	         $_POST['loan_date'], $_GET['client_id'], $_POST['due_date'],
			 $_GET['loan_id']);

	if ($query) {
		header("Location: ../viewloans.php?client_id=" .$_GET['client_id']);
	}
	else {
		echo "Update failed";
	}

}


if (isset($_POST['deleteLoanBtn'])) {
    $loan_id = $_GET['loan_id'];
    $client_id = $_GET['client_id'];

    // Call the delete function
    if (deleteLoan($pdo, $loan_id)) {
        header("Location: ../viewloans.php?client_id=" .$_GET['client_id']);
        exit;
    } else {
        echo "Error deleting loan.";
    }
}

?>