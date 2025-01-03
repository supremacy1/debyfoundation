<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $otherName = $_POST['otherName'] ?? null;
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $placeOfBirth = $_POST['placeOfBirth'];
    $religion = $_POST['region'];
    $lga = $_POST['lga'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $referral = $_POST['referral'];

    // Check if email already exists
    $checkEmailSql = "SELECT id FROM users WHERE email = :email";
    $checkStmt = $pdo->prepare($checkEmailSql);
    $checkStmt->execute([':email' => $email]);

    if ($checkStmt->rowCount() > 0) {
        echo "<script>
                alert('Email already exists!');
                window.history.back();
              </script>";
    } else {
        // Insert the new user into the database
        $sql = "INSERT INTO users (first_name, last_name, other_name, dob, email, phone, address, place_of_birth, religion, lga, state_of_origin, country_of_origin, referral) 
                VALUES (:first_name, :last_name, :other_name, :dob, :email, :phone, :address, :place_of_birth, :religion, :lga, :state_of_origin, :country_of_origin, :referral)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':other_name' => $otherName,
            ':dob' => $dob,
            ':email' => $email,
            ':phone' => $phone,
            ':address' => $address,
            ':place_of_birth' => $placeOfBirth,
            ':religion' => $religion,
            ':lga' => $lga,
            ':state_of_origin' => $state,
            ':country_of_origin' => $country,
            ':referral' => $referral
        ]);

        echo "<script>
                alert('User registered successfully!');
                window.location.href = '../mainlandingpage.html';
              </script>";
    }
} else {
    echo "Invalid request method.";
}
?>
