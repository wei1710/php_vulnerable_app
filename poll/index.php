<?php
/**
 * Sloppy poll
 * 
 * @author  Arturo Mora-Rioja
 * @version 1.0.0 April 2020
 * @version 1.0.1 December 2024 Code convention updated
 */

session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['csrf_token'];

$conn = new mysqli('localhost', 'root', '', 'movies'); 
if ($conn->connect_errno) {
    die('Connection unsuccessful: ' . $conn->connect_errno);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vote'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed');
    }

    $sql = 'UPDATE votes SET nNumVotes = nNumVotes + 1 WHERE nVotesID = 1';
    if (!$conn->query($sql)) {
        die('Insert unsuccessful: ' . $conn->error . '; query: ' . $sql);
    }
}

$sql = 'SELECT nNumVotes FROM votes WHERE nVotesID = 1';
if (!$res = $conn->query($sql)) {
    die('Query unsuccessful: ' . $conn->error . '; query: ' . $sql); 
} else {
    $votes = $res->fetch_assoc()['nNumVotes'];
}