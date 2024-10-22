<?php  

function insertClient($pdo, $first_name, $last_name, $contact_number) {

	$sql = "INSERT INTO clients (first_name, last_name, 
		contact_number) VALUES(?,?,?)";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$first_name, $last_name, 
		$contact_number]);

	if ($executeQuery) {
		return true;
	}
}

function getAllClients($pdo) {
	$sql = "SELECT * FROM clients";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getClientByID($pdo, $client_id) {
	$sql = "SELECT * FROM clients WHERE client_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$client_id]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}


function updateClient($pdo, $first_name, $last_name, 
	$contact_number, $client_id) {

	$sql = "UPDATE clients
			SET first_name = ?,
				last_name = ?,
				contact_number = ?
			WHERE client_id = ?";
	
	$stmt = $pdo->prepare($sql);

	$executeQuery = $stmt->execute([$first_name, $last_name, 
		$contact_number, $client_id]);
	
	if ($executeQuery) {
		return true;
	}

}

function deleteClient($pdo, $client_id) {
	$deleteClientLoan = "DELETE FROM loans WHERE client_id = ?";
	$deleteStmt = $pdo->prepare($deleteClientLoan);
	$executeDeleteQuery = $deleteStmt->execute([$client_id]);

	if ($executeDeleteQuery) {
		$sql = "DELETE FROM clients WHERE client_id = ?";
		$stmt = $pdo->prepare($sql);
		$executeQuery = $stmt->execute([$client_id]);

		if ($executeQuery) {
			return true;
		}

	}
	
}

function getAllInfoByClientID($pdo, $client_id) {
    $sql = "SELECT CONCAT(clients.first_name,' ',clients.last_name) AS loan_Client
            FROM clients
            WHERE client_id = ?";
    
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$client_id]);
    
    if ($executeQuery) {
        $result = $stmt->fetch();
        if ($result) {
            return $result;
        } else {
            return false; 
        }
    }

    return false; 
}
	

function getLoanByClient($pdo, $client_id) {
	
	$sql = "SELECT 
				loans.loan_id AS loan_id,
				loans.loan_amount AS loan_amount,
				loans.interest_rate AS interest_rate,
				CONCAT(clients.first_name,' ',clients.last_name) AS Client,
				loans.loan_date AS loan_date,
				loans.due_date AS due_date
			FROM loans
			JOIN clients ON loans.client_id = clients.client_id
			WHERE loans.client_id = ? 
			GROUP BY loans.loan_amount;
			";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$client_id]);
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}


function insertLoan($pdo, $loan_amount, $interest_rate, $loan_date, $client_id, $due_date) {
    $sql = "INSERT INTO loans (loan_amount, interest_rate, loan_date, client_id, due_date) 
            VALUES (?,?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$loan_amount, $interest_rate, $loan_date, $client_id, $due_date]);
    
    if ($executeQuery) {
        return true;
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "SQL error: " . $errorInfo[2];
        return false;
    }
}


function getLoanByID($pdo, $loan_id) {
    $sql = "SELECT 
                loans.loan_id AS loan_id,
                loans.loan_amount AS loan_amount,
                loans.interest_rate AS interest_rate,  /* Fix the typo here */
                loans.loan_date AS loan_date,
                loans.due_date AS due_date,
                CONCAT(clients.first_name, ' ', clients.last_name) AS loan_Client
            FROM loans
            JOIN clients ON loans.client_id = clients.client_id
            WHERE loans.loan_id = ?";
    
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$loan_id]);
    
    if ($executeQuery) {
        $result = $stmt->fetch();
        if ($result) {
            return $result; 
        } else {
            return false; 
        }
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "SQL error: " . $errorInfo[2];
        return false;
    }
}

function updateLoan($pdo, $loan_amount, $interest_rate, $loan_date, $client_id, $due_date, $loan_id) {
    $sql = "UPDATE loans
            SET loan_amount = ?,
                interest_rate = ?,
                loan_date = ?,
                client_id = ?,
                due_date = ?
            WHERE loan_id = ?;";
    
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$loan_amount, $interest_rate, $loan_date, $client_id, $due_date, $loan_id]);

    if ($executeQuery) {
        return true;
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "SQL error: " . $errorInfo[2];
        return false;
    }
}

function deleteLoan($pdo, $loan_id) {
    $sql = "DELETE FROM loans WHERE loan_id = ?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$loan_id])) {
        return true; // Return true on success
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "SQL error: " . $errorInfo[2];
        return false; // Return false on failure
    }
}

?> 