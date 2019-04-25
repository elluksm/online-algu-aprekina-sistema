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
    public $created_at;
}

class ReadOwnData
{
    //function to read data from User table
    public static function readDataTable($pdo, $user_id)
    {
        $statement = $pdo->prepare("select * from data where data.user_id = '$user_id'");
        $statement->execute();

        $salaryData = $statement->fetchAll(PDO::FETCH_CLASS, "Salary");
        return $salaryData;
    }
}

require "db_connect.php";

$salaryData = ReadOwnData::readDataTable($pdo, $user_id);

require "header.php";
?>

<body>
<div class="background-image"></div>
<main class="container">
    <div class="row">
        <div class="dark_container col-12">

            <a href="logout.php" class="btn btn_logout uppercase" id="signout">Iziet</a>
            <h1>Mana alga</h1>
            
			<table class="table table-hover user_table">
                <thead>
                    <tr>
                        <th scope="col">Aprekinats</th>
                        <th scope="col">Ieturets</th>
                        <th scope="col">Izmaksats</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($salaryData as $salary) { ?>
                        <tr>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <td><?= $salary->bruto ?></td>
                                <td><?= $salary->taxes_employee ?></td>
								<td><?= $salary->neto ?></td>
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


