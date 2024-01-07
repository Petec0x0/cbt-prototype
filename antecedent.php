<?php
require_once 'include/config.php';
$query = mysqli_query($link, "select * from tb_team");

// Define variables and initialize with empty values
$team_err = $error_msg = "";

session_start();

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['exam_id'] = trim($_POST["exam_id"]);
    $_SESSION['exam_name'] = trim($_POST["exam_name"]);
    header("location: index.php");
}
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Select Exam</title>
    <link rel="icon" href="" type="image/png" />

    <meta name="description" content="Quiz Application">
    <meta name="keywords" content="HTML,PHP,MySQL,JavaScript,Quiz,Web,Application">
    <meta name="author" content="Petec0x0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/bootstrap-reboot.min.css" type="text/css">
    <link rel="stylesheet" href="css/bootstrap-grid.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">


    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.min.js"></script>

    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->

    <style type="text/css">
        /*phone layout and less*/
        @media (max-width: 575.98px) {
            .container {
                width: 80%;
            }
        }

        /*tablet layout and up*/
        @media (min-width: 768px) {
            .container {
                width: 30%;
            }
        }
    </style>

</head>

<body style="font-family: 'Roboto', sans-serif;">
    <div class="container" style="padding: 10% 0%;min-width: 30%; max-width: 80%; margin: 0 auto; ">

        <div class="card">
            <div class="card-header bg-primary text-white" align="center"><strong>
                    <h4>Select Examination</h4>
                </strong></div>

            <div class="card-body">
                <form id="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <?php if (!empty($error_msg)) {
                        echo "<center><div class='alert alert-danger' role='alert'><STRONG>Warning! </STRONG>$error_msg</div></center>";
                        ;
                    } ?>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-list-alt"></i></span>
                            </div>
                            <select id="select_exam"
                                class="custom-select <?php echo (!empty($team_err)) ? 'is-invalid' : ''; ?>"
                                name="exam_id">
                                <option value="0" style="display:none">Select</option>
                                <?php while ($result = mysqli_fetch_assoc($query)) { ?>

                                    <option value="<?php echo $result['id_team']; ?>" <?php if (!empty($team) && $team == $result['id_team']) {
                                           echo "selected";
                                       } ?>>
                                        <?php echo $result['name_team']; ?>
                                    </option>

                                <?php } ?>
                            </select>
                            <input id="exam_name" type="hidden" name="exam_name" value="" />
                        </div>
                        <span class="help-block" style="color: red;">
                            <?php echo $team_err; ?>
                        </span>
                    </div>

                    <div class="form-group text-center">
                        <input type="submit" class="btn btn-outline-primary" value="Continue">
                    </div>
                </form>
            </div>

            <div class="card-footer bg-primary text-white" align="center">
                <!-- ©    Petec0x0  -->
            </div>
        </div>

    </div>


    <script>
        let examSelector = document.getElementById("select_exam");
        let exam_name = document.getElementById("exam_name");

        examSelector.addEventListener('change', (e) => {
            exam_name.value = examSelector.options[examSelector.selectedIndex].text;
        })
    </script>
</body>

</html>