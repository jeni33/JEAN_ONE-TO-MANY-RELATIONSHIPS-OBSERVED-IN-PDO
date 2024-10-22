CREATE TABLE clients (
    client_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    contact_number VARCHAR(20),
);

CREATE TABLE loans (
    loan_id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT,
    loan_amount DECIMAL(10, 2),
    interest_rate DECIMAL(5, 2),
    loan_date TIMESTAMP DEFAULT CURRENT_TIME_STAMP,
    due_date TIMESTAMP DEFAULT CURRENT_TIME_STAMP,
    CONSTRAINT fk_client FOREIGN KEY (client_id) REFERENCES clients(client_id)
);
