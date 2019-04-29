<?php

session_start();

// If session variable is not set it will redirect to login page
if (!isset($_SESSION["email"]) || empty($_SESSION["email"])) {
    header("location: index.php");
    exit;
}

$user_email = $_SESSION["email"];
$user_id = $_SESSION["id"];

class Salary
{
    //create User object when reading data from database
	public $id;
	public $user_id;
    public $period_start;
    public $period_end;
    public $bruto;
    public $taxes_employee;
    public $taxes_employer;
    public $neto;
	public $dependents;
    public $date;
}

class Name
{
	public $id;
    public $name;
    public $surname;
    public $personal_code;
    public $email;

}

class ReadOwnData
{
    //function to read data from User table
    public static function readDataTable($pdo, $user_id)
    {
        $statement = $pdo->prepare("SELECT id, user_id, period_start, period_end, bruto, taxes_employee, taxes_employer, neto, dependents, date(created_at) as date FROM data WHERE data.user_id = '$user_id'");
        $statement->execute();

        $salaryData = $statement->fetchAll(PDO::FETCH_CLASS, "Salary");
        return $salaryData;
    }
}

class ReadPersonalData
{
	public static function readUserData($pdo, $user_id)
    {
        $statement = $pdo->prepare("SELECT id, name, surname, personal_code, email FROM users WHERE id = '$user_id'");
        $statement->execute();

        $personalData = $statement->fetchAll(PDO::FETCH_CLASS, "Name");
        return $personalData;
    }
}

require "db_connect.php";

$salaryData = ReadOwnData::readDataTable($pdo, $user_id);
$personalData = ReadPersonalData::readUserData($pdo, $user_id);

require "header.php";
?>

<body>
<div class="background-image"></div>
<main class="container">
    <div class="row">
        <div class="dark_container col-12">

		<span><h4><?php foreach ($personalData as $person) {echo "Sveiki, " . $person->name . " ". $person->surname . "!";} ?></h4>
		</span>

            <a href="logout.php" class="btn btn_logout uppercase" id="signout">Iziet</a>
            <h1>Mana alga</h1>
            
			<table class="table table-hover user_table">
                <thead>
                    <tr>
						<th scope="col">Apgadajamie</th>
                        <th scope="col">Aprekinats</th>
                        <th scope="col">Ieturets</th>
                        <th scope="col">Izmaksats</th>
						<th scope="col">Parrekina datums</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($salaryData as $salary) { ?>
                        <tr>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
								<td><?= $salary->dependents ?></td>
                                <td><?= $salary->bruto ?></td>
                                <td><?= $salary->taxes_employee ?></td>
								<td><?= $salary->neto ?></td>
								<td><?= $salary->date ?></td>
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


