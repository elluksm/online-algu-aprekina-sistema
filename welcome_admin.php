<?php

session_start();

// If session variable is not set it will redirect to login page
if (!isset($_SESSION["email"]) || empty($_SESSION["email"])) {
    header("location: index.php");
    exit;
}

$user_email = $_SESSION["email"];
$user_id = $_SESSION["id"];

class User
{
    //create User object when reading data from database
    public $id;
    public $name;
    public $surname;
    public $personal_code;
    public $role;
    public $email;
    public $password;
    public $created_at;
}

class ReadData
{
    //function to read data from User table
    public static function readUserTable($pdo)
    {
        $statement = $pdo->prepare("select * from users");
        $statement->execute();

        $users = $statement->fetchAll(PDO::FETCH_CLASS, "User");
        return $users;
    }
}

class DeleteData
{
    public static function deleteUser($pdo, $user_id)
    {
        $statement = $pdo->prepare("delete from users where id =:user_id");
        $statement->bindParam(":user_id", $user_id, PDO::PARAM_STR);
        $statement->execute();

		$statement = $pdo->prepare("DELETE FROM data where user_id =:user_id");
        $statement->bindParam(":user_id", $user_id, PDO::PARAM_STR);
        $statement->execute();
    }
}

require "db_connect.php";

$users = ReadData::readUserTable($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    DeleteData::deleteUser($pdo, $_POST["user_id"]);
    header("location: welcome_admin.php");
}
require "header.php";
?>

<body>
<div class="background-image"></div>
<main class="container">
    <div class="row">
        <div class="dark_container col-12">

            <a href="logout.php" class="btn btn_logout uppercase" id="signout">Iziet</a>
            <h1>Visi lietotāji</h1><br>

            <table class="table table-hover user_table">
                <thead>
                    <tr>
                        <th scope="col">Vārds</th>
                        <th scope="col">Uzvārds</th>
                        <th scope="col">Epasts</th>
                        <th scope="col">Tiesības</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <td><?= $user->name ?></td>
                                <td><?= $user->surname ?></td>
                                <td><?= $user->email ?></td>
                                <td><?= $user->role ?></td>
                                <td><input hidden type="text" name="user_id" value=<?= $user->id ?>>
                                <button type="submit" class="btn btn-danger uppercase" name="delete" id="delete">Dzēst</button></td>
                            </form>
                        </tr>
                    <?php }; ?>
                </tbody>
            </table>

            <a href="profile.php" class="btn btn-success uppercase">Pievienot</a>
                   
        </div>
    </div>
</main>

<?php
require "footer.php";
?>

</body>
</html>


