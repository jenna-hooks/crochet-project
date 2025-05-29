<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $password = $_POST["password"];
    $hash = password_hash($password, PASSWORD_BCRYPT);
    echo "<strong>Hashed Password:</strong><br><code>$hash</code>";
}
?>

<form method="post">
    <label>Enter password to hash:</label><br>
    <input type="text" name="password" required>
    <button type="submit">Generate Hash</button>
</form>
