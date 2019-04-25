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
	/*
	public $id_2;
	public $user_id;
    public $period_start;
    public $period_end;
    public $bruto;
    public $taxes_employee;
    public $taxes_employer;
    public $neto;
    public $created_at_2;*/
}

class Data
{
    //create Data object when reading data from database
    public $sum_user_id;
	public $sum_bruto;
    public $sum_taxes_employee;
    public $sum_taxes_employer;
    public $sum_neto;

}

class ReadData
{
    //function to read data from User table
    public static function readUserTable($pdo)
    {
        $statement = $pdo->prepare("select * from users left outer join data on users.id=data.user_id where users.role = 'view'");
        $statement->execute();

        $users = $statement->fetchAll(PDO::FETCH_CLASS, "User");
        return $users;
    }
}

class ReadSumData
{
    //function to read data from Data table
    public static function readDataTable($pdo)
    {
        $statement2 = $pdo->prepare("SELECT COUNT(user_id), SUM(bruto), SUM(taxes_employee), SUM(taxes_employer), SUM(neto) FROM data");
        $statement2->execute();

        $sumSalary = $statement2->fetchAll(PDO::FETCH_CLASS, "Data");
        return $sumSalary;
    }
}

class EditData
{
    public static function editSalary($pdo, $newSalary, $id)
    {
					/*
					$param_id = 3;
						$param_user_id = $id;
						$param_period_start = '2019-04-01 00:00:01';
						$param_period_end = '2019-04-30 00:00:00';
						$param_bruto = 784;
						$param_taxes_employee = 251;
						$param_taxes_employer = 155;
						$param_neto = 711;
						$param_created_at = '2019-04-24 22:25:08';

						$sql2 = "insert into `data` (`id`, `user_id`, `period_start`, `period_end`, `bruto`, `taxes_employee`, `taxes_employer`, `neto`, `created_at`) VALUES (:id, :user_id, :period_start, :period_end, :bruto, :taxes_employee, :taxes_employer, :neto, :created_at)";
					
						$statement1 = $pdo->prepare($sql2);
						$statement1->bindParam(":id", $param_id, PDO::PARAM_INT);
						$statement1->bindParam(":user_id", $id, PDO::PARAM_INT);
						$statement1->bindParam(":period_start", $param_period_start, PDO::PARAM_STR);
						$statement1->bindParam(":period_end", $param_period_end, PDO::PARAM_STR);
						$statement1->bindParam(":bruto", $param_bruto, PDO::PARAM_STR);
						$statement1->bindParam(":taxes_employee", $param_taxes_employee, PDO::PARAM_STR);
						$statement1->bindParam(":taxes_employer", $param_taxes_employer, PDO::PARAM_STR);
						$statement1->bindParam(":neto", $param_neto, PDO::PARAM_STR);
						$statement1->bindParam(":created_at", $param_created_at, PDO::PARAM_STR);

						$statement1->execute();	
			*/			

        $statement = $pdo->prepare("update data set bruto = '$newSalary', taxes_employee = round('$newSalary' * 0.11 + (('$newSalary' - ('$newSalary' * 0.11)) * 0.2),2) , taxes_employer = round('$newSalary' * 0.2409,2), neto = '$newSalary'- taxes_employee where id = '$id'");
        $statement->bindParam($id, $newSalary, PDO::PARAM_STR);
        $statement->execute();

	}
}

require "db_connect.php";

$users = ReadData::readUserTable($pdo);
$sumSalary = ReadSumData::readDataTable($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

if (isset ($_POST['newSalary']))
	$newSalary = $_POST['newSalary'];
	$id = $_POST['user_id'];

	EditData::editSalary($pdo, $newSalary, $id);

    header("location: welcome_editor.php");
}

require "header.php";
?>

<body>
<div class="background-image"></div>
<main class="container">
    <div class="row">
        <div class="dark_container col-12">

            <a href="logout.php" class="btn btn_logout uppercase" id="signout">Iziet</a>
            <h1>Darbinieki</h1><br>

            <table class="table table-hover user_table">
                <thead>
                    <tr>
                        <th scope="col">Vards</th>
                        <th scope="col">Uzvards</th>
                        <th scope="col">Alga bruto</th>
                        <th scope="col">Alga neto</th>
						<th scope="col">Izmaksas uznemumam</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <td><?= $user->name ?></td>
                                <td><?= $user->surname ?></td>
                                <td><input type="text" name="newSalary" value="<?= $user->bruto ?>"></td>
								<input hidden type="text" name="user_id" value=<?= $user->id ?>>
                                <td><?= $user->neto ?></td>
								<td><?= $user->bruto + $user->taxes_employer ?></td>
                                <td><button type="submit" class="btn btn-danger uppercase" value="calculate">Aprekinat</button></td>
                            </form>
                        </tr>
                    <?php }; ?>
                </tbody>
            </table>

			<br><h1>Kopsummas</h1><br>
			<table class="table table-hover user_table">
                <thead>
                    <tr>
                        <th scope="col">Darbinieki</th>
                        <th scope="col">Bruto algas</th>
                        <th scope="col">Darbinieka nodokli</th>
                        <th scope="col">Darba deveja nodokli</th>
						<th scope="col">Neto algas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sumSalary as $salary) { ?>
                        <tr>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <td><?= $salary->sum_bruto ?></td>
                                <td><?= $salary->sum_bruto ?></td>
                                <td><?= $salary->sum_taxes_employee ?></td>
								<td><?= $salary->sum_taxes_employer ?></td>
                                <td><?= $salary->sum_neto ?></td>
                            </form>
                        </tr>
                    <?php }; ?>
                </tbody>
            </table>

                   
        </div>
    </div>
</main>

<?php
require "footer.php";
?>

</body>
</html>


