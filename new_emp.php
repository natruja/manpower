<?php 
date_default_timezone_set("Asia/Bangkok");
?>
<!DOCTYPE html>
<html lang="th">
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
      <?php 
        $monthNum  = date("m");
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March
      ?>
        <h1>พนักงานเข้าใหม่เดือน <?php echo  $monthName; ?></h1>
        <hr>
        <div class="row">
            <div class="col-lg-12 col-md-6">
                <div class="panel panel-primary">
                      <div class="panel-heading">
                            <h3 class="panel-title">รายชื่อพนักงานเข้าใหม่</h3>
                      </div>
                      <div class="panel-body">
                        <div class="col-lg-12 col-md-6">
                            <?php
                                require_once('core/init.php');

                                $db = new DB;

                                  $today = date("Y-m-d");
                                  $month = date("m");
                                  $year = date("Y");
                                  $year_thai = "2558";

                                 $start_emp = $db->query('SELECT date_start,emp_id,t_firstname,t_lastname,job_title,section,division,date_start  FROM all_ro10_emp
                                                         WHERE MONTH(date_start) = :month
                                                         AND (YEAR(date_start) = :thai_year OR  YEAR(date_start) = :year)
                                                         AND data_date = :today ');
                                   $start_emp = $db->bind(':year', $year, PDO::PARAM_STR);
                                   $start_emp = $db->bind(':month', $month, PDO::PARAM_STR);
                                   $start_emp = $db->bind(':thai_year', $year_thai, PDO::PARAM_STR);
                                   $start_emp = $db->bind(':today', $today, PDO::PARAM_STR);
                                   $start_emp = $db->execute();
                                   $start_emp = $db->rowCount();
                             ?>
                                 <table class="table table-striped table-bordered" id="new_emp" cellspacing="0" width="100%">
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
                                        $start_emp = $db->fetch();
                                        $i = 1;
                                        foreach ($start_emp as $key => $value) {
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