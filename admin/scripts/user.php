<?php
function createUser($fname, $username, $password, $email){
    $pdo = Database::getInstance()->getConnection();

    // TODO: build the proper SQL query with the infomation above
    // execute it to create a user in tbl_user;
    $create_user_query = 'INSERT INTO tbl_user(user_fname, user_name, user_pass, user_email)';
    $create_user_query .= ' VALUES(:fname, :username, :password, :email)';
    $create_user_set = $pdo->prepare($create_user_query);
    $create_user_result = $create_user_set -> execute(
        array(
            ':fname'=>$fname,
            ':username'=>$username,
            ':password'=>$password,
            ':email'=>$email
        )
    );
    //TODO: vased on the execution result, if everything goes through
    // redirect to the index.php
    // Otherwise, return a error message

    if($create_user_result){
        redirect_to('index.php');
    }else{
        return 'This individual sucks!';
    }
}

function getSingleUser($id){
    //TODO: set up database connection
    $pdo = Database::getInstance()->getConnection();

    //TODO: run the proper SQL query to fetch the user based on $id
    $get_user_query = 'SELECT * FROM tbl_user WHERE user_id = :id';
    $get_user_set = $pdo->prepare($get_user_query);
    $get_user_result = $get_user_set->execute(
        array(
            ':id'=>$id
        )
    );

    // echo $get_user_set->debugDumpParams();
    // exit;
    //TODO: return the user data if the above query went through
    // otherwise, return some error message.
    if($get_user_result && $get_user_set->rowCount()){
        return $get_user_set;
    }else{
        return false;
    }
}

function editUser($id, $fname, $username, $password, $email){
    //TODO: get the database connection
    $pdo = Database::getInstance()->getConnection();
    //TODO: Run the proper SQL query to update tbl_user
    $update_user_query = 'UPDATE tbl_user SET user_fname=:fname, user_name=:username';
    $update_user_query .= ', user_pass=:password, user_email=:email';
    $update_user_query .= ' WHERE user_id=:id';
    $update_user_set = $pdo->prepare($update_user_query);
    $update_user_result = $update_user_set->execute(
        array(
            ':fname'=>$fname,
            ':username'=>$username,
            ':password'=>$password,
            ':email'=>$email,
            ':id'=>$id
        )
    );

    //TODO: if the update SQL query went through redirect user to index.php
    //Otherwise return some error message
    if($update_user_result){
        redirect_to('index.php');
    }else{
        return 'Update failed...';
    }
}

function getAllUsers() {
    $pdo = Database::getInstance()->getConnection();

    $get_all_query = 'SELECT * FROM tbl_user';
    $set_users = $pdo->query($get_all_query);

    if($set_users) {
        return $set_users;
    } else {
        return false;
    }

}

function deleteUser($id) {

    $pdo = Database::getInstance()->getConnection();

    $delete_user_query = 'DELETE FROM tbl_user WHERE user_id = :id';
    $delete_user_set = $pdo->prepare($delete_user_query);
    $delete_result = $delete_user_set->execute(
        array(
            ':id'=>$id
        )
    );

    // echo $delete_user_set->debugDumpParams();


    if($delete_result && $delete_user_set->rowCount() > 0) {
        redirect_to('admin_delete_user.php');
    } else {
        return false;
    }
    
}