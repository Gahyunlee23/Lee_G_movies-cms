<?php

function addMovie($movie) {
    // var_dump($movie);
    try {
         // 1. connect to the DB
        $pdo = Database::getInstance()->getConnection();

        // 2. validate the upload file
        $cover = $movie['cover'];
        $upload_file = pathinfo($cover['name']);
        $accepted_types = array('gif', 'jpg', 'jpeg', 'jpe', 'png', 'webp', 'JPG');
        if(!in_array($upload_file['extension'], $accepted_types)) {
            throw new Exception('wrong file extension!');
        } 

        // 3. move the uploaded file around (move the file from top path to the /image)

        // *optional* 
        // randomlize the file name before move it over!
        $image_path = '../images/';

        $generated_name = md5($upload_file['filename'].time());
        $generated_filename = $generated_name.'.'.$upload_file['extension'];
        $targetpath = $image_path.$generated_filename;
        
        
        if(!move_uploaded_file($cover['tmp_name'], $targetpath)) {
            throw new Exception('Failed to load file, check permission');
        }

        // *** optional *** 
        //  convert it to webp
    
        // 4. insert into the db(tbl_movies as tbl_mov_genre)
        $add_movie_query = 'INSERT INTO tbl_movies(movies_cover, movies_title, movies_year, movies_runtime, movies_storyline, movies_trailer, movies_release)';
        $add_movie_query .= ' VALUE(:movies_cover, :movies_title, :movies_year, :movies_runtime, :movies_storyline, :movies_trailer, :movies_release)';
        
        $set_movie = $pdo->prepare($add_movie_query);
        $add_movie_result = $set_movie->execute(
            array(
                ':movies_cover' => $generated_filename,
                ':movies_title' => $movie['title'],
                ':movies_year' => $movie['year'],
                ':movies_runtime' => $movie['runtime'],
                ':movies_storyline' => $movie['storyline'],
                ':movies_trailer' => $movie['trailer'],
                ':movies_release' => $movie['release']
            )
        );

        $last_uploaded_id = $pdo->lastInsertId();
        
        if($add_movie_result && !empty($last_uploaded_id)) {
            $update_genre_query = 'INSERT INTO tbl_mov_genre(movies_id, genre_id) VALUE (:movies_id, :genre_id)';
            $update_genre = $pdo->prepare($update_genre_query);
            $update_genre->execute(
                array(
                    ':movies_id' => $last_uploaded_id,
                    'genre_id' => $movie['genre']
                )
            );
           
        }

        // 5. if all if above works, redirect to index.php
        redirect_to('index.php');
        // otherwise, return some error message
    } catch (Exception $e) {
        $error = $e->getMessage();
        return $error;

    }
}
   