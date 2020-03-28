<?php 

function redirect_to($location) {
    if($location != null) {
        header('Location: ' .$location);
        exit;
    } 
}

// function getMovieGenre() {
//     $pdo = Database::getInstance()->getConnection();

//     $getGenre = 'SELECT * FROM tbl_genre';
//     $gresult = $pdo->query($getGenre);

//     if($gresult) {
//         return($gresult);
//     } else {
//         return "Wrong here!";
//     }

// }