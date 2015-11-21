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
    <link href="bower_components/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="css/manpower.css" rel="stylesheet" >
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="bower_components/datatables/media/js/jquery.dataTables.js"></script>
    <script src="bower_components/datatables/media/js/dataTables.bootstrap.js"></script>
    <script src="bower_components/datatables-responsive/js/dataTables.responsive.js"></script>
    <script src="js/manpower.js"></script>
    <script type="text/javascript">
      function list()
      {
         document.form_name.submit();
      }
</script>
  </head>
  <body>
    <?php
    //include_once('themes/left.php');
    ?>
    <div id="page-content-wrapper">
      <div class="container-fluid">
        <h2>พนักงานในหน่วยงาน
        <?php
            $today = date("Y-m-d");
            $month = date("m");
            $year = date("Y");
            $year_thai = "2558";

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
        <br>
          <div class="row">
            <div class="col-lg-12">
              <div class="col-lg-2">
                 <div align="right"><h4>เลือกหน่วยงาน</h4></div>
              </div>
              <div class="col-lg-4">
                  <div class="dropdown">
                      <?php
                             $section = $db->query('SELECT section
                                              FROM all_ro10_emp
                                              WHERE division = :division
                                              AND data_date = :today
                                              GROUP BY section
                                              ORDER BY date_start ASC');
                            $section = $db->bind(':today', $today, PDO::PARAM_STR);
                            $section = $db->bind(':division', $division_name, PDO::PARAM_STR);
                            $section = $db->execute();
                      ?>
                      <form name='form_name' action='' method='GET'>
                      <select class="form-control" id="section" name="section" onchange="list()">
                          <option value="0"> - - เลือกทั้งหมด - - </option>
                          <?php
                             $section = $db->fetch();
                             foreach ($section as $key => $v) {
                                  $section_name = $v['section'];
                                  echo "<option value='".$section_name."'>",$section_name,"</option>";
                              }
                           ?>
                           <input type="hidden" value="<?php echo $division ?>" name="division">
                      </select>
                  </form>
                  </div>
              </div>
            </div>
          </div>
        <hr>

      <?php
        if(isset($_GET["section"])){
           $section = $_GET["section"];
           $detail_division = $db->query('SELECT emp_id,t_firstname,t_lastname,job_title,section,division,date_start,
                                         COUNT(CASE WHEN emp_type_id = 1 then 1 ELSE NULL END) as "emp",
                                         COUNT(CASE WHEN emp_type_id = 2 then 1 ELSE NULL END) as "contract",
                                         COUNT(CASE WHEN emp_type_id = 3 then 1 ELSE NULL END) as "part_time",
                                         COUNT(emp_id) as "all"
                                          FROM all_ro10_emp
                                          WHERE data_date = :today
                                          AND  division = :division
                                          AND section = :section
                                          ORDER BY date_start ASC ');
          $detail_division = $db->bind(':today', $today, PDO::PARAM_STR);
          $detail_division = $db->bind(':division', $division_name, PDO::PARAM_STR);
          $detail_division = $db->bind(':section', $section, PDO::PARAM_STR);
         }else{
           $detail_division = $db->query('SELECT emp_id,t_firstname,t_lastname,job_title,section,division,date_start,
                                         COUNT(CASE WHEN emp_type_id = 1 then 1 ELSE NULL END) as "emp",
                                         COUNT(CASE WHEN emp_type_id = 2 then 1 ELSE NULL END) as "contract",
                                         COUNT(CASE WHEN emp_type_id = 3 then 1 ELSE NULL END) as "part_time",
                                         COUNT(emp_id) as "all"
                                          FROM all_ro10_emp
                                          WHERE data_date = :today
                                          AND  division = :division
                                          ORDER BY date_start ASC ');
          $detail_division = $db->bind(':today', $today, PDO::PARAM_STR);
          $detail_division = $db->bind(':division', $division_name, PDO::PARAM_STR);
        }
         $detail_division = $db->execute();
         $detail_division = $db->single();
          $all =  $detail_division["all"];
          $emp =  $detail_division["emp"];
          $contract = $detail_division["contract"];
          $part_time = $detail_division["part_time"];
     ?>
        <div class="row">
          <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-male fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <div class="huge"><?php echo $all; ?></div>
                    <div>พนักงานทั้งหมด</div>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer">
                  <span class="pull-left">พนักงานทั้งหมด</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
                </div>
              </a>
              </div><!-- panel panel-primary -->
            </div>
            <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-male fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <div class="huge"><?php echo $emp ?></div>
                    <div>Permanent</div>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer">
                  <span class="pull-left">View Details</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
                </div>
              </a>
              </div><!-- panel panel-primary -->
            </div><!-- col-lg-3 col-md-6 -->
            <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-male fa-5x "></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <div class="huge"><?php echo $contract; ?></div>
                    <div>Contract</div>
                  </div>
                </div>
              </div>
              <a href="resign.php">
                <div class="panel-footer">
                  <span class="pull-left">View Details</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
                </div>
              </a>
              </div><!-- panel panel-primary -->
            </div><!-- col-lg-3 col-md-6 -->
            <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-male fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <div class="huge"><?php echo $part_time; ?></div>
                    <div>Part time</div>
                  </div>
                </div>
              </div>
              <a href="resign.php">
                <div class="panel-footer">
                  <span class="pull-left">View Details</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
                </div>
              </a>
              </div><!-- panel panel-primary -->
            </div><!-- col-lg-3 col-md-6 -->


          </div><!-- row -->



          <div class="row">
            <div class="col-lg-12 col-md-6">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  <h3 class="panel-title">รายชื่อพนักงาน
                      <?php
                        if(isset($_GET["section"]) ){
                            echo $_GET["section"];
                         }else{
                            echo "ทั้งหมด";
                         }
                       ?>
                    </h3>
                </div>
                <div class="panel-body">
                  <div class="col-lg-12 col-md-6">
                    <?php
                    if(isset($_GET["section"])){
                        $section = $_GET["section"];
                        $detail_division = $db->query('SELECT emp_id,t_firstname,t_lastname,job_title,section,division,date_start  FROM all_ro10_emp
                                                      WHERE division = :division
                                                      AND section = :section
                                                      AND data_date = :today
                                                      ORDER BY date_start ASC ');
                        $detail_division = $db->bind(':today', $today, PDO::PARAM_STR);
                        $detail_division = $db->bind(':division', $division_name, PDO::PARAM_STR);
                        $detail_division = $db->bind(':section', $section, PDO::PARAM_STR);
                    }else{
                      $detail_division = $db->query('SELECT emp_id,t_firstname,t_lastname,job_title,section,division,date_start  FROM all_ro10_emp
                                                      WHERE division = :division
                                                      AND data_date = :today
                                                      ORDER BY date_start ASC ');
                        $detail_division = $db->bind(':today', $today, PDO::PARAM_STR);
                        $detail_division = $db->bind(':division', $division_name, PDO::PARAM_STR);
                    }
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
                         $detail_division = $db->execute();
                        $detail_division = $db->rowCount();
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