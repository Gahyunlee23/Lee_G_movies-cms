<?php

include_once('../config/database.php');
include_once('../config/database_old.php');

$start = microtime(true);

# the new way
$i = 0;
while($i<100) {
    $database = Database::getInstance()->getConnection();
    $new_time = microtime(true) - $start;
    $i++;
}

// $new_time = microtime(true) - $start;

$start = microtime(true);
$i = 0;
# the old way with loop
while($i<100) {
    $database_old = new Database_old();
    $database_connection = $database_old->getConnection();
    $i++;
}
$old_time = microtime(true) - $start;


printf('New Connection takes ==> %s ms'.PHP_EOL, $new_time*1000); 
printf('Old Connection takes ==> %s ms'.PHP_EOL, $old_time*1000);
printf('You Saved %s ms'.PHP_EOL, ($old_time - $new_time)*1000);
printf('New Connection only takes %s%% of old connection'.PHP_EOL, ($new_time/$old_time)*100);

