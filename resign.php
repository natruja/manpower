<?php 
date_default_timezone_set("Asia/Bangkok");
?>
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
    //include_once('themes/left.php');
 ?>
 <div id="page-content-wrapper">
     <div class="container-fluid">
      <?php 
        $monthNum  = date("m");
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); 
        
      ?>
        <h1>พนักงานเข้าใหม่ <?php echo $monthName; ?></h1>
        <hr>
        <div class="row">
            <div class="col-lg-12 col-md-6">
                <div class="panel panel-primary">
                      <div class="panel-heading">
                            <h3 class="panel-title">รายชื่อพนักงานเข้าใหม่ <?php echo $monthName; ?></h3>
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

                                  $finish = $db->query("SELECT    all_ro10_emp.data_date,
                                                                  all_ro10_emp.emp_id,
                                                                  all_ro10_emp.e_firstname,
                                                                  all_ro10_emp.e_lastname,
                                                                  all_ro10_emp.job_title,
                                                                  all_ro10_emp_trans.e_firstname,
                                                                  all_ro10_emp_trans.e_lastname,
                                                                  all_ro10_emp_trans.date_finish
                                                      FROM
                                                              all_ro10_emp_trans
                                                      INNER JOIN all_ro10_emp ON all_ro10_emp_trans.e_firstname = all_ro10_emp.e_firstname AND all_ro10_emp_trans.e_lastname = all_ro10_emp.e_lastname
                                                      WHERE MONTH(all_ro10_emp_trans.date_finish) = :month
                                                      AND all_ro10_emp.data_date = :today
                                                      AND (YEAR(all_ro10_emp_trans.date_finish) = :year OR YEAR(all_ro10_emp_trans.date_finish) = :thai_year)");
                           $finish = $db->bind(':month', $month);
                           $finish = $db->bind(':year', $year);
                           $finish = $db->bind(':today', $today);
                           $finish = $db->bind(':thai_year', $year_thai);
                           $finish = $db->execute();
                           $count = $db->rowCount();
                          

                            $new = $db->query("SELECT date_finish,emp_id,t_firstname,t_lastname,section,division,date_finish FROM all_ro10_emp_trans
                                                WHERE MONTH(all_ro10_emp_trans.date_finish) = :month
                                                AND all_ro10_emp_trans.data_date = :today
                                                AND (YEAR(all_ro10_emp_trans.date_finish) = :year OR YEAR(all_ro10_emp_trans.date_finish) = :thai_year)");
                            $new = $db->bind(':month', $month);
                            $new = $db->bind(':year', $year);
                            $new = $db->bind(':today', $today);
                            $new = $db->bind(':thai_year', $year_thai);
                            $new = $db->execute();
                            $count_new = $db->rowCount();
                        

                               
                             ?>
                                 <table class="table table-striped table-bordered" id="new_emp" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>รหัสพนักงาน</th>
                                            <th>ชื่อพนักงาน</th>
                                            <th>นามสกุลพนักงาน</th>
                                            <th>Division</th>
                                            <th>Section</th>
                                            <th>Date Finish</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $new = $db->fetch();
                                        $i = 1;
                                        foreach ($new as $key => $value) {
                                    ?>
                                        <tr>
                                            <td><?php echo  $i; ?></td>
                                            <td><?php echo $value["emp_id"]; ?></td>
                                            <td><?php echo $value["t_firstname"]; ?></td>
                                            <td><?php echo $value["t_lastname"]; ?></td>               
                                            <td><?php echo $value["section"]; ?></td>
                                            <td><?php echo $value["division"]; ?></td>
                                            <td><?php echo $value["date_finish"]; ?></td>
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