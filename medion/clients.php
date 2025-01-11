<?php

class Clients {

    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $telephone;
    public $ville;
    public $reg_date;
    public $idCity;

    public static $errorMsg = "";
    public static $successMsg = "";

    public function __construct($firstname, $lastname, $ville, $telephone, $email, $password) {
        // Initialize the attributes of the class with the parameters
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->telephone = $telephone;
        $this->ville = $ville;
        $this->email = $email;
        // Hash the password using password_hash for better security
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function insertClient($tableName, $conn) {
        // Insert a client into the database and return success or error message
        $sql = "INSERT INTO $tableName  (firstname, lastname, telephone, ville, email, password)
                VALUES ('$this->firstname', '$this->lastname', '$this->telephone', '$this->ville', '$this->email', '$this->password')";
        if (mysqli_query($conn, $sql)) {
            self::$successMsg =  "New record created successfully";
        } else {
            self::$errorMsg = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    public static function selectAllClients($tableName, $conn) {
        // Select all clients from the database and return the results as an array
        $sql = "SELECT id, firstname, lastname, telephone, ville, email FROM $tableName";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $table = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $table[] = $row;
            }
            return $table;
        }
    }

    static function selectClientById($tableName, $conn, $id) {
        // Select a client by ID and return the result
        $sql = "SELECT firstname, lastname, telephone, ville, email FROM $tableName WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
    }

    static function updateClient($client, $tableName, $conn, $id) {
        // Update a client with the given ID and return success or error message
        $sql = "UPDATE $tableName SET firstname = '$client->firstname', lastname ='$client->lastname', telephone = '$client->telephone', ville = '$client->ville', email = '$client->email' WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            self::$successMsg =  "Record updated successfully";
            header('Location: read.php');
        } else {
            self::$errorMsg = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    static function deleteClient($tableName, $conn, $id) {
        // Delete a client by ID and return success or error message
        $sql = "DELETE FROM $tableName WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            echo "Record deleted successfully";
            header('Location: read.php');
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    }

    public static function selectClientsByCity($tableName, $conn, $idCity) {
        // Select all clients by city ID and return the results as an array
        $sql = "SELECT id, firstname, lastname, email, idCity FROM $tableName WHERE idCity = '$idCity'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $table = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $table[] = $row;
            }
            return $table;
        }
    }

    // New login method to authenticate user based on email and password
    public static function login($email, $password, $conn) {
        // Sanitize input to prevent SQL injection
        $email = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $password);

        // Query to fetch the client by email
        $sql = "SELECT * FROM clients WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        // If email exists
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Verify the password using password_verify()
            if (password_verify($password, $row['password'])) {
                // Return the client details if login is successful
                return $row;
            } else {
                // Incorrect password
                self::$errorMsg = "Incorrect password";
                return false;
            }
        } else {
            // Email not found
            self::$errorMsg = "Email not found";
            return false;
        }
    }
}

?>
