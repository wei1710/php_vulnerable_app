<?php
/**
 * Main backend API
 * 
 * @author  Arturo Mora-Rioja
 * @version 1.0.0 April 2020
 * @version 1.0.1 December 2024 Code convention updated
 */

session_start();

$conn = new mysqli('localhost', 'root', '', 'movies'); 

if ($conn->connect_errno) {
    echo 'Connection unsuccessful';
    die('Connection unsuccessful: ' . $conn->connect_errno);
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if ($_GET['action'] === 'get_movie' ) {
            $stmt = $conn->prepare("SELECT cName FROM movies WHERE nMovieID = ?");
            $stmt->bind_param('i', $_GET['movie_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $movies = [];
            while ($movies = $result->fetch_assoc()) {
                $movies[] = $movie['cName'];
            }
            echo json_encode($movies);
        break;
    }
    case 'POST':
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('CSRF token validation failed');
        }

        if ($_POST['action'] === 'new_movie') {
            $stmt = $conn->prepare('INSERT INTO movies (cNames) VALUES (?)');
            $stmt->bind_param('s', $_POST['movie_name']);
            if ($stmt->execute()) {
                echo json_encode('Insert successful');
            } else {
                die('Insert unsuccessful: ' . $conn->error);
            }
        }
        break;
}

$conn = null;