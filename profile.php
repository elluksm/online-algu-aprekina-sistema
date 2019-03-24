<?php

// Include db_connect file
require "db_connect.php";

// Define variables and initialize with empty values
$name = $surname = $personal_code = $role = $password = $email = "";
$name_err = $surname_err = $personal_code_err = $role_err = $password_err = $email_err = $register_err = $success_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     //when user clicks SignUp button
        require "register.php";
}

require "header.php";
?>

<body>
<div class="background-image"></div>
<main class="main_container">
    <div class="row">
    <div class="register_form_container col-10 offset-1 col-lg-6 offset-lg-3">
        <div class="light_form">

                <section class="inner_form" id="register_form">
                    <h1>Lietotāja Reģistrācija</h1>
                    <br><hr><br>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                        <div <?php echo (!empty($name_err)) ? "has-error" : ""; ?>>
                            <label for="name">Vārds<span>*</span><span class="icon"><img
                                            src="images/icon3.png"></span></label>
                            <input type="text" name="name" id="name" value="<?= $name ?>">
                            <span class="help-block"><?= $name_err ?></span>
                        </div>

                        <div <?php echo (!empty($surname_err)) ? "has-error" : ""; ?>>
                            <label for="surname">Uzvārds<span>*</span></label>
                            <input type="text" name="surname" id="surname" value="<?= $surname ?>">
                            <span class="help-block"><?= $surname_err ?></span>
                        </div>

                        <div <?php echo (!empty($personal_code_err)) ? "has-error" : ""; ?>>
                            <label for="personal_code">Personas kods<span>*</span></label>
                            <input type="text" name="personal_code" id="personal_code" value="<?= $personal_code ?>">
                            <span class="help-block"><?= $personal_code_err ?></span>
                        </div>

                        <div <?php echo (!empty($email_err)) ? "has-error" : ""; ?>>
                            <label for="email">Epasts<span>*</span><span class="icon"><img src="images/icon1.png"></span></label>
                            <input type="email" name="email" id="email" value="<?= $email ?>">
                            <span class="help-block"><?= $email_err ?></span>
                        </div>

                        <div <?php echo (!empty($password_err)) ? "has-error" : ""; ?>>
                            <label for="password">Parole<span>*</span><span class="icon"><img src="images/icon2.png"></span></label>
                            <input type="password" name="password" id="password" value="<?= $password ?>">
                            <span class="help-block"><?= $password_err ?></span>
                        </div>

                        <div <?php echo (!empty($role_err)) ? "has-error" : ""; ?>>
                            <label for="role">Tiesības<span>*</span></label>
                            <select name="role" class="form-control">
                                <option value="view">Skatīties</option>
                                <option value="edit">Rediģēt</option>
                                <option value="admin">Admin</option>
                            </select>
                            <span class="help-block"><?= $role_err ?></span>
                            <span><?= $register_err ?></span>
                            <span id="success_msg"><?= $success_msg ?></span>
                        </div>

                        <br>
                        <button class="btn uppercase btn_blue" name="register">Pievienot</button>
                        <a href="welcome_admin.php" class="btn btn_red uppercase">Atgriezties</a>
                    </form>
                </section>
                </div>

        </div>
    </div>
</main>

<?php
require "footer.php";
?>

</body>
</html>
