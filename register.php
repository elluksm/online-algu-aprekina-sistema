<?php

//Registration process, inserts user info into the database

// Validate username
if (empty(trim($_POST["name"]))) {
    $name_err = "Lūdzu ievadiet vārdu!";
} else {
    $name = trim($_POST["name"]);
}

// Validate surname
if (empty(trim($_POST["surname"]))) {
    $surname_err = "Lūdzu ievadiet uzvārdu!";
} else {
    $surname = trim($_POST["surname"]);
}

// Validate personal code
if (empty(trim($_POST["personal_code"]))) {
    $personal_code_err = "Lūdzu ievadiet personas kodu!";
} else {
    $personal_code = trim($_POST["personal_code"]);
}

// Validate role
if (empty(trim($_POST["role"]))) {
    $role_err = "Lūdzu ievadiet lietotāja tiesības!";
} else {
    $role = trim($_POST["role"]);
}

// Validate email
if (empty(trim($_POST["email"]))) {
    $email_err = "Lūdzu ievadiet epastu!";
} else {
    $sql = "SELECT id FROM users WHERE email = :email";

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
        $param_email = trim($_POST["email"]);
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                $email_err = "Konts ar šādu epastu jau eksistē!";
            } else {
                $email = trim($_POST["email"]);
            }
        } else {
            $register_err =  "Oops! Kaut kas nogāja greizi. Lūdzu mēģiniet atkal nedaudz vēlāk!";
        }
    }
    unset($stmt);
}

// Validate password
if (empty(trim($_POST["password"]))) {
    $password_err = "Lūdzu ievadiet paroli!";
} elseif (strlen(trim($_POST["password"])) < 6) {
    $password_err = "Parolei jābūt vismaz 6 simbolus garai!";
} else {
    $password = trim($_POST["password"]);
}



if (!empty($name_err) || !empty($password_err) || !empty($email_err) || !empty($surname_err) || !empty($personal_code_err) || !empty($role_err)) {
    $register_err = "Reģistrācija nebija veiksmīga. Lūdzu mēģiniet atkal!";
}

// Check input errors before inserting in database
if (empty($name_err) && empty($password_err) && empty($email_err) && empty($surname_err) && empty($personal_code_err) && empty($role_err) ) {

    // Prepare an insert statement
    $sql = "INSERT INTO users (name, surname, personal_code, role, email, password) VALUES (:name, :surname, :personal_code, :role, :email, :password)";

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
        $stmt->bindParam(":surname", $param_surname, PDO::PARAM_STR);
        $stmt->bindParam(":personal_code", $param_personal_code, PDO::PARAM_STR);
        $stmt->bindParam(":role", $param_role, PDO::PARAM_STR);
        $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
        $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

        $param_name = $name;
        $param_surname = $surname;
        $param_personal_code = $personal_code;
        $param_role = $role;
        $param_email = $email;
        $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash


        if ($stmt->execute()) {
            $success_msg = "Lietotāja reģistrācija veiksmīga!";	
			$last_id = $pdo->lastInsertId();
        } else {
            $register_err = "Oops! Kaut kas nogāja greizi. Lūdzu mēģiniet atkal nedaudz vēlāk!";
        }
    }

    // Close statement
    unset($stmt);

	//Inserting default data for minimum wage
	$statement = $pdo->prepare("INSERT INTO data (id, user_id, bruto, taxes_employee, taxes_employer, neto, dependents, created_at) VALUES
(DEFAULT, $last_id, 430, 123.84, 103.59, 306.16, 0, DEFAULT);");
    $statement->execute();

}

// Close connection
unset($pdo);
