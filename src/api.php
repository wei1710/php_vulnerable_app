<?php
/**
 * Main backend API
 * 
 * @author  Arturo Mora-Rioja
 * @version 1.0.0 April 2020
 * @version 1.0.1 December 2024 Code convention updated
 */

$conn = new mysqli('localhost', 'root', '', 'movies'); 

if ($conn->connect_errno) {
    echo 'Connection unsuccessful';
    die('Connection unsuccessful: ' . $conn->connect_errno);
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if ($_GET['action'] === 'get_movie' ) {
            $sql = 'SELECT cName FROM movies WHERE nMovieID = ' . $_GET['movie_id'];
            if (!$res = $conn->query($sql)) {
                echo 'Query unsuccessful: ' . $sql;
                die('Query unsuccessful: ' . $conn->error);
            } else {
                $movies = [];
                while ($movie = $res->fetch_assoc())
                    array_push($movies, $movie['cName']);
            echo json_encode($movies);
        }
        break;
    }
    case 'POST':
        if ($_POST['action'] === 'new_movie') {
            $sql = 'INSERT INTO movies (cName) VALUES ("' . $_POST['movie_name'] . '")';
            if (!$conn->query($sql)) {
                echo 'Insert unsuccessful: ' . $sql;
                die('Insert unsuccessful: ' . $conn->error);
            } else 
            echo json_encode('Insert successful');
        }
        break;
}

$conn = null;