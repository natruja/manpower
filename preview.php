<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ManPower RO10</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="bower_components/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet">
     <link href="bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
    <link href="font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="css/manpower.css" rel="stylesheet" >

    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="bower_components/datatables/media/js/jquery.dataTables.js"></script>
    <script src="bower_components/datatables/media/js/dataTables.bootstrap.js"></script>
    <script src="bower_components/datatables-responsive/js/dataTables.responsive.js"></script>
    <script src="js/manpower.js"></script>

</head>
<body>
<?php
    include_once('themes/left.php');
 ?>
 <div id="page-content-wrapper">
     <div class="container-fluid">
        <h2>พนักงานในหน่วยงาน
            <?php
              require_once('core/init.php');
              $db = new DB;
              $division =  htmlspecialchars($_GET["division"]);

                $id_division = $db->query('SELECT department_id,division FROM all_tttbb_division WHERE department_id = :id_division');
                $id_division = $db->bind(':id_division', $division, PDO::PARAM_STR);
                $id_division = $db->execute();
                $id_division = $db->single();
                foreach ($id_division as $key => $value) {
                   $division_name = $id_division["division"];
                 }
                 echo $division_name;

            ?>
          </h2>
        <hr>
        <div class="row">
            <div class="col-lg-12 col-md-6">
                <div class="panel panel-primary">
                      <div class="panel-heading">
                            <h3 class="panel-title">รายชื่อพนักงาน</h3>
                      </div>
                      <div class="panel-body">
                        <div class="col-lg-12 col-md-6">
                            <?php

                                  $today = date("Y-m-d");
                                  $month = date("m");
                                  $year = date("Y");
                                  $year_thai = "2558";


                                   $detail_division = $db->query('SELECT emp_id,t_firstname,t_lastname,job_title,section,division,date_start  FROM all_ro10_emp
                                                         WHERE division = :division
                                                         AND data_date = :today ');
                                   $detail_division = $db->bind(':today', $today, PDO::PARAM_STR);
                                   $detail_division = $db->bind(':division', $division_name, PDO::PARAM_STR);
                                   $detail_division = $db->execute();
                                   $detail_division = $db->rowCount();
                             ?>
                                 <table class="table table-striped table-bordered" id="deetail_emp" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>รหัสพนักงาน</th>
                                            <th>ชื่อพนักงาน</th>
                                            <th>นามสกุลพนักงาน</th>
                                            <th>Job Title</th>
                                            <th>Division</th>
                                            <th>Section</th>
                                            <th>Start Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $detail_division = $db->fetch();
                                        $i = 1;
                                        foreach ($detail_division as $key => $value) {
                                    ?>
                                        <tr>
                                            <td><?php echo  $i; ?></td>
                                            <td><?php echo $value["emp_id"]; ?></td>
                                            <td><?php echo $value["t_firstname"]; ?></td>
                                            <td><?php echo $value["t_lastname"]; ?></td>
                                            <td><?php echo $value["job_title"]; ?></td>
                                            <td><?php echo $value["section"]; ?></td>
                                            <td><?php echo $value["division"]; ?></td>
                                            <td><?php echo $value["date_start"]; ?></td>
                                        </tr>
                                        <?php
                                            $i++;
                                            }
                                         ?>
                                    </tbody>
                                </table>
                            </div>
                      </div>
                </div>
            </div>
        </div>
     </div>
 </div>
</body>
</html>