<?php
session_start();

require_once 'config.php';
$exam_query = mysqli_query($link, "select * from tb_team");

if (isset($_SESSION['done'])) {
    header("location: ../login.php");
}

if (!isset($_SESSION['username'])) {
    header("location: login.php");
}

$query = mysqli_query($link, "select tb_user.nama, tb_user.username, tb_user.team, tb_result.answer_right, tb_result.answer_wrong, tb_result.answer_empty, tb_result.score from tb_user JOIN tb_result on tb_user.username = tb_result.username WHERE 0;");
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_id = trim($_POST["exam_id"]);

    $query = mysqli_query($link, "select tb_user.nama, tb_user.username, tb_user.team, tb_result.answer_right, tb_result.answer_wrong, tb_result.answer_empty, tb_result.score from tb_user JOIN tb_result on tb_user.username = tb_result.username WHERE tb_result.exam_id = $exam_id;");
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
    <link rel="stylesheet" href="../css/datatables.min.css" type="text/css">
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
    <script src="../js/datatables.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#viewResult').DataTable({
                language: {
                    processing: "Processing...",
                    search: "Search&nbsp;:",
                    lengthMenu: "Showing _MENU_ data",
                    info: "Showing data _START_ to _END_ of the total _TOTAL_ data",
                    infoEmpty: "Showing data 0 to 0 of a total of 0 data",
                    infoFiltered: "(Filter from total _MAX_ data)",
                    infoPostFix: "",
                    loadingRecords: "Load...",
                    zeroRecords: "There is no data to display",
                    emptyTable: "There is no data in the table",
                    paginate: {
                        first: "Beginning",
                        previous: "Previous",
                        next: "Next",
                        last: "End"
                    },
                    aria: {
                        sortAscending: ": enable to sort from smallest data",
                        sortDescending: ": Enable to sort by largest data"
                    },
                    language: {
                        decimal: ",",
                    }
                }
            });
        });
    </script>
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
                    <li>
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
                    <li class="active">
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
            <center>
                <h2>Quiz Results </h2>
                <form id="exam_select_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-list-alt"></i></span>
                            </div>
                            <select id="select_exam"
                                class="custom-select <?php echo (!empty($team_err)) ? 'is-invalid' : ''; ?>"
                                name="exam_id">
                                <option value="0" style="display:none">Select Examination</option>
                                <?php while ($result = mysqli_fetch_assoc($exam_query)) { ?>

                                    <option value="<?php echo $result['id_team']; ?>" <?php if (!empty($team) && $team == $result['id_team']) {
                                           echo "selected";
                                       } ?>>
                                        <?php echo $result['name_team']; ?>
                                    </option>

                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <input type="submit" class="btn btn-outline-primary" value="Fetch">
                    </div>
                </form>
            </center>
            <table id="viewResult" class="table display" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Correct</th>
                        <th>Wrong</th>
                        <th>Empty</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($view = mysqli_fetch_assoc($query)) {
                        echo "<tr>";
                        echo "<td>" . $view['nama'] . "</td>";
                        echo "<td>" . $view['answer_right'] . "</td>";
                        echo "<td>" . $view['answer_wrong'] . "</td>";
                        echo "<td>" . $view['answer_empty'] . "</td>";
                        echo "<td>" . $view['score'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>