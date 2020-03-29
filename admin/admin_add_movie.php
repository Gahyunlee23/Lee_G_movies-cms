<?php
require_once '../load.php';
confirm_logged_in();

// $getGenre = getMovieGenre();

$genre_table = 'tbl_genre';
$genres = getAll($genre_table);

if(isset($_POST['submit'])) {
    // if php functions ever take too many parameters(like below), recommend to use array! 
    $movie = array(
        'cover' => trim($_FILES['cover']),
        'title' => trim($_POST['title']),
        'year' => trim($_POST['year']),
        'runtime' => trim($_POST['runtime']),
        'storyline' => trim($_POST['storyline']),
        'trailer' => trim($_POST['trailer']),
        'release' => trim($_POST['release']),
        'genre' => trim($_POST['genList']),
    );

    $result = addMovie($movie);
    $message = $result;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie</title>
</head>
<body>
    <h2>Add Movie!</h2>
    <?php echo !empty($message)? $message:''; ?>
        <form action="admin_add_movie.php" method="post" enctype="multipart/form-data">

            <label>Cover Image:</label><br>
            <input type="file" name="cover" value=""><br><br>

            <label>Movie Title:</label><br>
            <input type="text" name="title" value=""><br><br>

            <label>Movie Year:</label><br>
            <input type="text" name="year" value=""><br><br>

            <label>Movie Runtime:</label><br>
            <input type="text" name="runtime" value=""><br><br>

            <label>Movie release:</label><br>
            <input type="text" name="release" value=""><br><br>

            <label>Movie Storyline:</label><br>
            <textarea name="storyline"></textarea><br><br>

            <label>Movie trailer:</label><br>
            <input type="text" name="trailer" value=""><br><br>

            <label>Movie Genre: </label><br>
            <select name="genList">
                <option>Select a movie genre! (make me easy to fliter!)</option>

                <?php while ($mgenre = $genres->fetch(PDO::FETCH_ASSOC)): ?>
                    <option value="<?php echo $mgenre['genre_id']; ?>"><?php echo $mgenre['genre_name']; ?></option>
                <?php endwhile; ?>

            </select><br><br>

            <button type="submit" name="submit">Add Movie</button>
        </form>
</body>
</html>