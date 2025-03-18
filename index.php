<?php 
session_start();
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://code.jquery.com");

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['csrf_token'];

$userName = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['txtName'])) {
        $userName = $_POST['txtName'];
    }
}

?>

<!DOCTYPE html>
<!--
    Vulnerable Web Application Example

    Author: Arturo Mora-Rioja
    Date:   April 2020      Initial version
            September 2021  Bootstrap removed
-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vulnerable Web App Example</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script src="js/script.js" defer></script>
</head>
<body>
    <header>
        <h1>Vulnerable Web App Example</p>
    </header>
    <form id="frmName">
        <fieldset>
            <div>
                <label for="txtName">Please enter your name</label><br>
                <input type="text" id="txtName" maxlength="200">
            </div>               
            <div id="divName" class="outputDiv">
                <p><?php echo htmlspecialchars($userName, ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
            <div>
                <button type="submit">Show the text</button>
            </div>
        </fieldset>
    </form>            
    <form id="frmMovie" method="POST" action="src/api.php">
        <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
        <fieldset>
            <div>
                <input type="radio" id="optSearch" name="optMovie" value="search" checked>
                    <label for="optSearch" id="lblSearch" class="option">Search movie</label>
                <input type="radio" id="optNew" name="optMovie" value="new">
                    <label for="optNew" id="lblNew" class="option">New movie</label>
            </div>
            <div>
                <label for="txtName" id="lblMovie">Please enter a movie ID</label><br>
                <input type="text" id="txtMovie" maxlength="80">
            </div>               
            <div id="divMovie" class="outputDiv"></div>
            <div>
                <button type="submit" id="btnMovie"></button>
            </div>
        </fieldset>
    </form>            
    <footer>
        <p>&copy; 2021-2024 Arturo Mora-Rioja</p>
    </footer>
</body>
</html>