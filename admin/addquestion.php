<?php
session_start();

require_once 'config.php';

if(isset($_SESSION['done'])){
  header("location: ../login.php");
}

if(!isset($_SESSION['username'])){
  header("location: login.php");
}

$query = mysqli_query($link, "select * from tb_team");

// Define variables and initialize with empty values
$question_name = $option1 = $option2 = $option3 = $option4 = $answer = $question_image = $team = "";
$question_err = $option1_err = $option2_err = $option3_err = $option4_err = $answer_err = $image_err = $team_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validasi foto
    if(!empty($_FILES['question_image']['name'])){
        $uploadDirectory = "../img/";
        $sourceDirectory ="img/";

        // Jika direktori tidak ada, buat baru
        if (!file_exists($uploadDirectory)) {
          mkdir($uploadDirectory, 0777, true); 
      }

        $file_name = $_FILES['question_image']['name'];
        $file_size = $_FILES['question_image']['size'];
        $file_tmp = $_FILES['question_image']['tmp_name'];
        $file_type = $_FILES['question_image']['type'];

        $file_ext=explode('.',$_FILES['question_image']['name']);
        $file_ext=strtolower(end($file_ext));

        $targetUpload = $uploadDirectory.$file_name;
        $targetSource = $sourceDirectory.$file_name;
        
        $expensions= array("jpeg","jpg","png");
        
        if(in_array($file_ext,$expensions) === false){
            $image_err = "Please select a photo in JPG or PNG type."; 
        } else{
          $question_image = $targetSource;
        }     
     }

    // Validate team
    if($_POST['team'] == 0){
        $team_err = "Please select a team.";     
    } else{
        $team = trim($_POST['team']);
    }

    // Validate soal
    if(empty(trim($_POST['question_name']))){
        $question_err = "Please complete the questions.";     
    } else{
        $question_name = trim($_POST['question_name']);
    }

    // Validate opsi
    if(empty(trim($_POST['option1']))){
        $option1_err = "Please fill in the answer choices.";     
    } else{
        $option1 = trim($_POST['option1']);
    }

    if(empty(trim($_POST['option2']))){
        $option2_err = "Please fill in the answer choices.";     
    } else{
        $option2 = trim($_POST['option2']);
    }

    if(empty(trim($_POST['option3']))){
        $option3_err = "Please fill in the answer choices.";     
    } else{
        $option3 = trim($_POST['option3']);
    }

    if(empty(trim($_POST['option4']))){
        $option4_err = "Please fill in the answer choices.";     
    } else{
        $option4 = trim($_POST['option4']);
    }


    if($_POST['answer'] == 0){
        $answer_err = "Please fill in the answers to the questions.";     
    } else{
        $answer = $_POST['answer'];
    }
    
    
    // Check input errors before inserting in database
    if(empty($question_err) && empty($option1_err) && empty($option2_err) && empty($option3_err) && empty($option4_err) && empty($answer_err) && empty($image_err) && empty($team_err) ){
        
        // Prepare an insert statement
        $sql = "INSERT INTO tb_question (question_name, question_image, option1, option2, option3, option4, answer, group_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssi", $param_question, $param_image, $param_option1, $param_option2, $param_option3, $param_option4, $param_answer, $param_team);
            
            // Set parameters
            $param_question = $question_name;
            $param_image = $question_image;
            $param_option1 = $option1;
            $param_option2 = $option2;
            $param_option3 = $option3;
            $param_option4 = $option4;
            $param_answer = $answer;
            $param_team = $team;
            
            // Attempt to execute the prepared statement
            if(!empty($_FILES['question_image']['name'])){
              if(move_uploaded_file($file_tmp, $targetUpload)){
                if(mysqli_stmt_execute($stmt)){
                    // Redirect
                    header("location: addquestion.php?msg=success");
                } else{
                    header("location: addquestion.php?msg=failed");
                }
            }
          } elseif(mysqli_stmt_execute($stmt)){
                // Redirect
                header("location: addquestion.php?msg=success");
            } else{
                header("location: addquestion.php?msg=failed");
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <title>Quiz Dashboard</title>
    <link rel="icon" href="" type="image/png" />

    <meta name="description" content="Quiz Application">
    <meta name="keywords" content="HTML,PHP,MySQL,JavaScript,Quiz,Web,Application">
    <meta name="author" content="Petec0x0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../css/bootstrap-reboot.min.css" type="text/css">
    <link rel="stylesheet" href="../css/bootstrap-grid.min.css" type="text/css">
    <link rel="stylesheet" href="../css/style.css" type="text/css">
    <link rel="stylesheet" href="../css/font-awesome.min.css" type="text/css">
    <style type="text/css">
        /*phone layout and less*/
        @media (max-width: 575.98px) {
            .container {
                width: 100%;
            }
        }

        /*tablet layout and less*/
        @media (max-width: 768px) {
            .navbarlist {
                display: none;
            }
        }

        /*tablet layout and up*/
        @media (min-width: 768px) {
            .container {
                width: 50%;
            }
        }

        .navbar-fixed-top {
            border-width: 0 0 1px;
            top: 0;
        }

        .wrapping {
            padding-top: 56px;
            padding-left: 0px;
            /*-webkit-transition: all .5s ease;
    -moz-transition: all .5s ease;
    -o-transition: all .5s ease;
    transition: all .5s ease;*/
        }

        @media (min-width: 992px) {
            .content-wrapping {
                padding-left: 15px;
                padding-right: 25px;
                padding-top: 5px;
                min-width: 762px;
            }

            .wrapping {
                padding-left: 225px;
            }
        }

        @media (min-width: 992px) {
            .wrapping .sidebar-wrapping {
                width: 225px;
            }
        }

        .sidebar-wrapping {
            border-right: 1px solid #e7e7e7;
        }

        .sidebar-wrapping {
            z-index: 1000;
            position: fixed;
            left: 225px;
            width: 0;
            height: 100%;
            margin-left: -225px;
            overflow-y: auto;
            background: #f8f8f8;
            /*-webkit-transition: all .5s ease;
    -moz-transition: all .5s ease;
    -o-transition: all .5s ease;
    transition: all .5s ease;*/
        }

        .sidebar-wrapping .sidebar-nav {
            position: absolute;
            top: 0;
            width: 225px;
            font-size: 14px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .sidebar-wrapping .sidebar-nav li {
            text-indent: 0;
            line-height: 45px;
        }

        .sidebar-wrapping .sidebar-nav li a {
            display: block;
            text-decoration: none;
            color: #428bca;
        }

        .sidebar-nav .active a {
            background: #92bce0;
            color: #fff !important;
        }

        .sidebar-wrapping .sidebar-nav li a .sidebar-icon {
            width: 45px;
            height: 45px;
            font-size: 14px;
            padding: 0 2px;
            display: inline-block;
            text-indent: 7px;
            margin-right: 10px;
            float: left;
        }

        .sidebar-wrapping .sidebar-nav li a .caret {
            position: absolute;
            right: 23px;
            top: auto;
            margin-top: 20px;
        }


        @media (max-width: 992px) {
            .content-wrapping {
                padding-left: 50px;
                padding-right: 10px;
                padding-top: 2px;
            }

            .wrapping .sidebar-wrapping {
                width: 45px;
            }

            .wrapping .sidebar-wrapping .sidebar .sidemenu li ul {
                position: fixed;
                left: 45px;
                margin-top: -45px;
                z-index: 1000;
                width: 200px;
                height: 0;
            }
        }
    </style>
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->

</head>

<body style="font-family: 'Roboto', sans-serif">
    <script src="../js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../js/jquery.min.js" type="text/javascript"></script>

    <div class="navbar-wrapping">
        <nav class="navbar fixed-top bg-light" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Quiz Dashboard</a>
                </div>
                <ul class="nav navbar-nav navbar-right navbarlist">
                    <li><a href="#"><span class="fa fa-user"></span>
                            <?php echo $_SESSION['nama']; ?>
                        </a></li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="wrapping">
        <div class="sidebar-wrapping">
            <aside class="sidebar">
                <ul class="sidemenu sidebar-nav">
                    <li>
                        <a href="index.php">
                            <span class="sidebar-icon"><i class="fa fa-question-circle"></i></span>
                            <span class="sidebar-title">Guide</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="addquestion.php">
                            <span class="sidebar-icon"><i class="fa fa-pencil"></i></span>
                            <span class="sidebar-title">Add Question</span>
                        </a>
                    </li>
                    <li>
                        <a href="questions.php">
                            <span class="sidebar-icon"><i class="fa fa-book"></i></span>
                            <span class="sidebar-title">Manage Questions</span>
                        </a>
                    </li>
                    <li>
                        <a href="adduser.php">
                            <span class="sidebar-icon"><i class="fa fa-user-plus"></i></span>
                            <span class="sidebar-title">Add User</span>
                        </a>
                    </li>
                    <li>
                        <a href="userlist.php">
                            <span class="sidebar-icon"><i class="fa fa-users"></i></span>
                            <span class="sidebar-title">Manage Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="addteam.php">
                            <span class="sidebar-icon"><i class="fa fa-handshake-o"></i></span>
                            <span class="sidebar-title">User Exam Group</span>
                        </a>
                    </li>
                    <li>
                        <a href="view.php">
                            <span class="sidebar-icon"><i class="fa fa-bell"></i></span>
                            <span class="sidebar-title">View Results</span>
                        </a>
                    </li>
                    <hr>
                    <li>
                        <a href="setting.php">
                            <span class="sidebar-icon"><i class="fa fa-cogs"></i></span>
                            <span class="sidebar-title">Arrangement</span>
                        </a>
                    </li>
                    <li>
                        <a href="logout.php">
                            <span class="sidebar-icon"><i class="fa fa-sign-out"></i></span>
                            <span class="sidebar-title">Log Out</span>
                        </a>
                    </li>
                </ul>
            </aside>
        </div>

        <div class="content-wrapping" style="text-align: justify;">

            <div class="container">
                <center>
                    <h2>Add Question</h2>
                </center>
                <br>
                <?php if(isset($_GET['msg'])){
            if ($_GET['msg'] === "success"){
              echo "<div class='alert alert-success' role='alert'>Successfully added question!</div>";
            }
            else{
              echo "<div class='alert alert-danger' role='alert'>Gagal menambahkan soal!</div>";
            }
          } ?>
                <form id="question" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-list-alt"></i></span>
                            </div>
                            <select class="custom-select <?php echo (!empty($team_err)) ? 'is-invalid' : ''; ?>"
                                name="team">
                                <option value="0" style="display:none">Exam Group</option>
                                <?php while ( $result = mysqli_fetch_assoc($query) ) {?>

                                <option value="<?php echo $result['id_team']; ?>" <?php if(!empty($team) &&
                                    $team==$result['id_team']){ echo "selected" ;} ?>>
                                    <?php echo $result['name_team']; ?>
                                </option>

                                <?php } ?>
                            </select>
                        </div>
                        <span class="help-block" style="color: red;">
                            <?php echo $team_err; ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="question_name">Question</label>
                        <textarea class="form-control <?php echo (!empty($question_err)) ? 'is-invalid' : ''; ?>"
                            name="question_name" rows="5"><?php echo $question_name; ?></textarea>
                        <span class="help-block" style="color: red;">
                            <?php echo $question_err; ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="question_image">Image (optional)</label>
                        <input type="file" class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>"
                            name="question_image" />
                        <span class="help-block" style="color: red;">
                            <?php echo $image_err; ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="option1">Option 1</label>
                        <input type="text"
                            class="form-control <?php echo (!empty($option1_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $option1; ?>" name="option1" />
                        <span class="help-block" style="color: red;">
                            <?php echo $option1_err; ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="option2">Option 2</label>
                        <input type="text"
                            class="form-control <?php echo (!empty($option2_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $option2; ?>" name="option2" />
                        <span class="help-block" style="color: red;">
                            <?php echo $option2_err; ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="option3">Option 3</label>
                        <input type="text"
                            class="form-control <?php echo (!empty($option3_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $option3; ?>" name="option3" />
                        <span class="help-block" style="color: red;">
                            <?php echo $option3_err; ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="option4">Option 4</label>
                        <input type="text"
                            class="form-control <?php echo (!empty($option4_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $option4; ?>" name="option4" />
                        <span class="help-block" style="color: red;">
                            <?php echo $option4_err; ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="answer">Answer</label>
                        <select class="custom-select <?php echo (!empty($answer_err)) ? 'is-invalid' : ''; ?>"
                            name="answer">
                            <option value="0" style="display:none"></option>
                            <option value="1" <?php if(!empty($answer) && $answer==1){ echo "selected" ;} ?>>Option 1
                            </option>
                            <option value="2" <?php if(!empty($answer) && $answer==2){ echo "selected" ;} ?>>Option 2
                            </option>
                            <option value="3" <?php if(!empty($answer) && $answer==3){ echo "selected" ;} ?>>Option 3
                            </option>
                            <option value="4" <?php if(!empty($answer) && $answer==4){ echo "selected" ;} ?>>Option 4
                            </option>
                        </select>
                        <span class="help-block" style="color: red;">
                            <?php echo $answer_err; ?>
                        </span>
                    </div>

                    <div class="form-group text-center">
                        <input type="submit" class="btn btn-outline-primary" value="Add">
                    </div>
                </form>
            </div>

        </div>

    </div>
</body>

</html>