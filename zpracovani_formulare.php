<?php
// Připojení k databázi
$servername = "localhost";
$username = "root";
$password = "@Tat/n3k007*";
$dbname = "lesnictvii"; // Název vaší databáze

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kontrola, zda formulář byl odeslán
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jmeno = $_POST['name'];
    $email = $_POST['email'];
    $telefon = $_POST['phone'];
    $typ_prace = $_POST['work-type'];

    // Vložení zákazníka do tabulky zakaznici
    $stmt = $conn->prepare("INSERT INTO zakaznici (jmeno, email, telefon) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $jmeno, $email, $telefon);
    $stmt->execute();
    $zakaznik_id = $stmt->insert_id; // ID nového zákazníka

    // Vložení požadované práce do tabulky prace s cizím klíčem na zakaznika
    $stmt = $conn->prepare("INSERT INTO prace (typ_prace, zakaznik_id) VALUES (?, ?)");
    $stmt->bind_param("si", $typ_prace, $zakaznik_id);
    $stmt->execute();

    // Zavření statementu
    $stmt->close();
    
    // Přesměrování po úspěšném odeslání formuláře
    header("Location: dekuji.html"); // Přesměrování na stránku s poděkováním
    exit(); // Ukončení skriptu
}

$conn->close();
?>
