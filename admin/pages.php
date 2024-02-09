<?php

$href = (isset($_GET['href'])) ? $_GET['href'] : 'Manage';


if ($href == 'Manage') { ?>


    <div class=" d-flex justify-content-end">
        <a class="btn btn-primary text-center m-5" href="?href=add">Add Member</a>
    </div>



<?php



} elseif ($href == "add") {


?>



    <div class="add ">
        <h1 class="text-center text-dark">Add New Member</h1>
        <div class="container fw-bold  text-center  ">
            <form class="form-horizontal" action="?href=insert" method="POST">
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">User Name</label>
                    <input name="username" type="text" class=" col-sm-10 col-md-5" required="required" placeholder="User Name">
                </div>
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Email</label>
                    <input name="email" type="text" class="col-sm-10 col-md-5" required="required" placeholder="Email">
                </div>
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">password</label>
                    <input name="password" type="password" class="password col-sm-10 col-md-5" required="required" placeholder="Password">
                    <i class="show-pass fas fa-eye"></i>
                </div>
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Full Name</label>
                    <input name="full" type="text" class="col-sm-10 col-md-5" required="required" placeholder="Full Name">
                </div>
                <div class="form-group form-group-lg ">
                    <div class="offset-2 col-sm-10  ">
                        <input type="submit" value="Add" class="btn btn-primary ">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?PHP

} elseif ($href == "insert") {




    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        echo "<h1 class='text-center'> Add Member  </h1>";
        echo "<div class='container text-center'> ";

        $email = $_POST["email"];

        $fullName = $_POST["full"];

        $username = $_POST["username"];

        $password =  $_POST["password"];

        $hashPass = sha1($_POST["password"]);


        $HandleError = [];



        if (empty($username)) {
            $HandleError[] = ' username Cant Be <strong?> Empty </strong> ';
        }
        if (strlen($username) < 3) {
            $HandleError[] = ' username Cant Be Less Than <strong?> 3 </strong> Characters ';
        }
        if (strlen($fullName) < 3) {
            $HandleError[] = ' fullName Cant Be Less Than <strong?> 3 </strong> Characters ';
        }
        if (strlen($password) <div 6) {
            $HandleError[] = ' password Cant Be Less Than <strong?> 6 </strong> Characters ';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL, FILTER_FLAG_PATH_REQUIRED)) {

            $HandleError[] =  ' Enter Validate<strong?> Email </strong> ';
        }
        if (!filter_var($password, FILTER_VALIDATE_REGEXP, array('options' => array("regexp" =>"/^M(.*)/")))) {

            $HandleError[] =  ' Enter Validate<strong?> Password </strong> ';
        }
        if (empty($email)) {

            $HandleError[] =  ' Email Cant Be <strong?> Empty </strong> ';
        }
        if (empty($fullName)) {

            $HandleError[] = ' Full Name Cant Be <strong?> Empty </strong> ';
        }
        if (empty($password)) {

            $HandleError[] = ' password Cant Be <strong?> Empty </strong> ';
        }

        foreach ($HandleError as $error) {
            echo '<div class="alert alert-danger">' . $error . '</div>';
        }

        if (empty($HandleError)) {
            // Assuming $con is your database connection object
            $query = 'UPDATE users SET email = :email, username = :username, password = :password, fullName = :fullName WHERE user_id = :userID';
            $stmt = $con->prepare($query);
            //   Note: There was a typo in the parameter name here, it should be :fullName instead of :fullname
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':fullName', $fullName);
            $stmt->bindParam(':userID', $userid);
            $stmt->execute();


            echo  '
            <div class="alert alert-primary"> Updated </div>
            <a class="btn btn-primary text-center" href="member.php"> Update</a> 
         ';
        }



        echo "</div>";
    }
} elseif ($href == "Edite") {

    $user_id = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;

    $query = 'SELECT * FROM users WHERE user_id = :userid LIMIT 1';
    $stmt = $con->prepare($query);
    $stmt->bindParam(':userid', $user_id);
    $stmt->execute();
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    if ($count > 0) {
    ?>



        <div class="details ">
            <h1 class="text-center">Edite Member</h1>
            <div class="container fw-bold  text-center  ">
                <form class="form-horizontal" action="?href=Update" method="POST">
                    <input type="hidden" name="userid" value="<?php echo $row['user_id'] ?>">
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">User Name</label>
                        <input name="username" type="text" class=" col-sm-10 col-md-5" value="<?php echo $row["username"] ?>" required="required">
                    </div>
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Email</label>
                        <input name="email" type="text" class="col-sm-10 col-md-5" value="<?php echo $row["email"] ?>" required="required">
                    </div>
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">password</label>
                        <input name="password" type="text" class="col-sm-10 col-md-5" value="<?php echo $row['password'] ?>" required="required">
                        <input name="oldPassword" type="hidden" value="<?php echo $row['password'] ?>">
                    </div>
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Full Name</label>
                        <input name="full" type="text" class="col-sm-10 col-md-5" value="<?php echo $row["fullName"] ?>" required="required">
                    </div>
                    <div class="form-group form-group-lg ">
                        <div class="offset-2 col-sm-10  ">
                            <input type="submit" value="Save" class="btn btn-primary ">
                        </div>
                    </div>
                </form>
            </div>
        </div>

<?PHP

    } else {
        header('location:index.php');
    }
} elseif ($href == "Update") {


    echo "<h1 class='text-center'> Update Member  </h1>";
    echo "<div class='container text-center'> ";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userid = $_POST["userid"];
        $email = $_POST["email"];
        $fullName = $_POST["full"];
        $username = $_POST["username"];
        if (empty($_POST['password'])) {
            $password = $_POST['oldPassword'];
        } else {
            $password = sha1($_POST['password']);
        }


        $HandleError = [];



        if (empty($username)) {
            $HandleError[] = ' username Cant Be <strong?> Empty </strong> ';
        }
        if (strlen($username) < 3) {
            $HandleError[] = ' username Cant Be Less Than <strong?> 3 </strong> Characters ';
        }
        if (strlen($fullName) < 3) {
            $HandleError[] = ' fullName Cant Be Less Than <strong?> 3 </strong> Characters ';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL, FILTER_FLAG_PATH_REQUIRED)) {

            $HandleError[] =  ' Enter Validate<strong?> Email </strong> ';
        }
        if (empty($email)) {

            $HandleError[] =  ' Email Cant Be <strong?> Empty </strong> ';
        }
        if (empty($fullName)) {

            $HandleError[] = ' Full Name Cant Be <strong?> Empty </strong> ';
        }

        foreach ($HandleError as $error) {
            echo '<div class="alert alert-danger">' . $error . '</div>'; 
        }

        if (empty($HandleError)) {
            // Assuming $con is your database connection object
            $query = 'UPDATE users SET email = :email, username = :username, password = :password, fullName = :fullName WHERE user_id = :userID';
            $stmt = $con->prepare($query);
            //   Note: There was a typo in the parameter name here, it should be :fullName instead of :fullname
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':fullName', $fullName);
            $stmt->bindParam(':userID', $userid);
            $stmt->execute();


            echo  '
            <div class="alert alert-primary"> Updated </div>
            <a class="btn btn-primary text-center" href="member.php"> Update</a> 
         ';
        }



        echo "</>";
    }
}


?>