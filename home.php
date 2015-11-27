<?php
date_default_timezone_set("Asia/Bangkok");
?>
<!DOCTYPE html>
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
    <script src="bower_components/table/tableExport.min.js" type="text/javascript"></script>
    <script src="js/manpower.js"></script>

</head>
<body>
        <?php
           //require_once('themes/left.php');
           require_once('core/init.php');
           require 'bower_components/Carbon/Carbon.php';

            $today = date("Y-m-d");
            $month = date("m");
            $year = date("Y");
            $year_thai = "2558";
            $number = "1";

            use Carbon\Carbon;

            $yesterday = Carbon::yesterday();
            $yesterday->toDateString();

         //$last_month = date("Y-n-j", strtotime("last day of previous month"));
        $db = new DB;


        $new = $db->query("SELECT date_finish
                            FROM all_ro10_emp_trans
                            WHERE MONTH(all_ro10_emp_trans.date_finish) = :month
                            AND all_ro10_emp_trans.data_date = :today
                            AND (YEAR(all_ro10_emp_trans.date_finish) = :year OR YEAR(all_ro10_emp_trans.date_finish) = :thai_year)
                            AND ExpiredCaseID != '0' ");
        $new = $db->bind(':month', $month);
        $new = $db->bind(':year', $year);
        $new = $db->bind(':today', $today);
        $new = $db->bind(':thai_year', $year_thai);
        $new = $db->execute();
        $emp_out = $db->rowCount();


            $start_emp = $db->query('SELECT date_start  FROM all_ro10_emp
                                 WHERE MONTH(date_start) = :month
                                 AND (YEAR(date_start) = :thai_year OR  YEAR(date_start) = :year)
                                 AND data_date = :today ');
           $start_emp = $db->bind(':year', $year, PDO::PARAM_STR);
           $start_emp = $db->bind(':month', $month, PDO::PARAM_STR);
           $start_emp = $db->bind(':thai_year', $year_thai, PDO::PARAM_STR);
           $start_emp = $db->bind(':today', $today, PDO::PARAM_STR);
           $start_emp = $db->execute();
           $start_emp = $db->rowCount();

           //add new line

           $type_emp = $db->query('SELECT
                                    COUNT(CASE WHEN emp_type_id = 1 then 1 ELSE NULL END) as "emp",
                                    COUNT(CASE WHEN emp_type_id = 2 then 1 ELSE NULL END) as "contract",
                                    COUNT(CASE WHEN emp_type_id = 3 then 1 ELSE NULL END) as "part_time",
                                    COUNT(emp_id) as all_emp
                                  FROM all_ro10_emp WHERE data_date = :today ');
           $type_emp = $db->bind(':today', $today);
           $type_emp = $db->execute();
           $result =  $db->single();
           $emp        =  $result["emp"];
           $contract   =  $result["contract"];
           $part_time  =  $result["part_time"];
            $all_emp  =  $result["all_emp"];


        ?>
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                <div class="col-lg-12">
                        <h1>RO10 Manpower</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div><!-- row -->
                <hr>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-male fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php echo $all_emp; ?></div>
                                            <div>รวมพนักงานทั้งหมด</div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- panel panel-primary -->
                        </div><!-- col-lg-3 col-md-6 -->
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-pink">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-male fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php echo $emp; ?></div>
                                            <div>พนักงานประจำ</div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- panel panel-primary -->
                        </div><!-- col-lg-3 col-md-6 -->
                        <div class="col-lg-3 col-md-6">
                             <div class="panel panel-sky">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-male fa-5x "></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php echo $contract; ?></div>
                                            <div>สัญญาจ้าง</div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- panel panel-primary -->
                        </div>
                         <div class="col-lg-3 col-md-6">
                             <div class="panel panel-yellow">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-male fa-5x "></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php echo $part_time; ?></div>
                                            <div>Part Time</div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- panel panel-primary -->
                        </div>
                        <div class="col-lg-3 col-md-6">
                             <div class="panel panel-green">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-male fa-5x "></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php  echo $start_emp; ?></div>
                                            <div><a href="new_emp.php"><font color="white">เข้าใหม่</font></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- panel panel-primary -->
                        </div>
                        <div class="col-lg-3 col-md-6">
                             <div class="panel panel-red">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-male fa-5x "></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php  echo $emp_out;  ?></div>
                                            <div><a href="resign.php"><font color="white">ลาออก</font></a></div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- panel panel-primary -->
                        </div>
                         <div class="col-lg-3 col-md-6">
                             <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-male fa-5x "></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php  //echo $finish_emp;  ?></div>
                                            <div>ปรับตำแหน่ง</div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- panel panel-primary -->
                        </div>
                         <div class="col-lg-3 col-md-6">
                             <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-male fa-5x "></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php  //echo $finish_emp;  ?></div>
                                            <div>โอนย้าย</div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- panel panel-primary -->
                        </div>
                    </div><!-- col-lg-12 -->
               </div><!-- row -->

       <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    <div class="row">
                       <div class="col-xs-3">
                            <i class="fa fa-male"></i>
                               &nbsp;&nbsp; อัตราความต้องการของแต่ละหน่วยงาน
                        </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <table class="table table-striped table-bordered" id="current" cellspacing="0" width="100%">
                            <div class="pull-left">
                                 อัตรากำลังประจำหน่วยงานเดือน <?php echo date('F'); ?>
                            </div>
                            <div class="pull-right">
                                <a href="#" onClick="doExport('#current', {type: 'excel',fileName: 'อัตราความต้องการของแต่ละหน่วยงาน <?php echo date('M'),"-",$year; ?>' ,worksheetName: 'อัตราความต้องการของแต่ละหน่วยงาน'});">
                                    <img src='icons/xls.png' alt="CSV" style="width:24px">
                                </a>
                            </div>
                                <thead>
                                    <tr>
                                        <th rowspan="2">NO.</th>
                                        <th rowspan="2"><div align="center">หน่วยงานใน RO10</div></th>
                                        <th colspan="3"><div align="center">อัตรากำลังประจำหน่วยงาน</div></th>
                                        <th rowspan="2"><div align="center">รวม</div></th>
                                        <th colspan="3"><div align="center">จำนวนพนักงานปัจจุจัน</div></th>
                                        <th rowspan="2"><div align="center">รวม</div></th>
                                        <th colspan="3"><div align="center">อัตราความต้องการแต่ละหน่วยงาน</div></th>
                                        <th rowspan="2"><div align="center">รวม</div></th>
                                    </tr>
                                    <tr>
                                        <th><div align="center">Permanent</div></th>
                                        <th><div align="center">Contract</div></th>
                                        <th><div align="center">Part Time</div></th>
                                        <th><div align="center">Permanent</div></th>
                                        <th><div align="center">Contract</div></th>
                                        <th><div align="center">Part Time</div></th>
                                        <th><div align="center">Permanent</div></th>
                                        <th><div align="center">Contract</div></th>
                                        <th><div align="center">Part Time</div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                       $current = $db->query('SELECT
                                                                SUM(all_ro10_emp_master.staff) as staff,
                                                                SUM(all_ro10_emp_master.contract) as contract,
                                                                SUM(all_ro10_emp_master.train) as train,
                                                                 all_ro10_emp_master.division,
                                                                 all_ro10_emp_master.department_id
                                                            FROM
                                                                all_ro10_emp_master
                                                            GROUP BY division
                                                            ORDER BY division DESC');
                                      $current = $db->fetch();
                                      $i = 1;


                                        foreach ($current as $key => $v) {

                                              $total_diff = $v["staff"] + $v["contract"] + $v["train"];
                                              $division_v = $v["division"];
                                              $department_id = $v["department_id"];

                                              $curent_now = $db->query('SELECT all_ro10_emp.division,
                                                                            COUNT(CASE WHEN all_ro10_emp.emp_type_id = 1 then 1 ELSE NULL END) as "emp",
                                                                            COUNT(CASE WHEN all_ro10_emp.emp_type_id = 2 then 1 ELSE NULL END) as "contract",
                                                                            COUNT(CASE WHEN all_ro10_emp.emp_type_id = 3 then 1 ELSE NULL END) as "part_time",
                                                                            COUNT(all_ro10_emp.emp_type_id) as "total"
                                                                        FROM all_ro10_emp

                                                                        WHERE all_ro10_emp.data_date = :today
                                                                        AND all_ro10_emp.division = :division');
                                               $curent_now = $db->bind(':today', $today);
                                               $curent_now = $db->bind(':division', $division_v);
                                               $curent_now = $db->execute();
                                               $curent_now = $db->single();


                                               $emp = $curent_now["emp"];
                                               $contract = $curent_now["contract"];
                                               $part_time = $curent_now["part_time"];
                                               $total_all = $curent_now["total"];

                                               $all_emp = $v["staff"] - $emp;
                                               $all_contract = $v["contract"] - $contract;
                                               $all_part = $v["train"] - $part_time;
                                               $all_total = $total_diff - $total_all;

                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td> <a href="preview.php?division=<?php echo $department_id; ?>" ><?php echo $division_v; ?></a></td>
                                        <td><?php echo $v["staff"]; ?></td>
                                        <td><?php echo $v["contract"]; ?></td>
                                        <td><?php echo $v["train"]; ?></td>
                                        <td><?php echo $total_diff; ?></td>
                                        <td><?php echo ($curent_now["emp"]== "0"  ?  '-' : $curent_now["emp"]); ?></a></td>
                                        <td><?php echo ($curent_now["contract"]== "0"  ?  '-' : $curent_now["contract"]); ?></td>
                                        <td><?php echo ($curent_now["part_time"]== "0"  ?  '-' : $curent_now["part_time"]); ?></td>
                                        <td><?php echo ($curent_now["total"]== "0"  ?  '-' : $curent_now["total"]); ?></td>
                                        <td><?php echo ($all_emp == "0"  ?  '-' : $all_emp); ?></td>
                                        <td><?php echo ($all_contract == "0"  ?  '-' : $all_contract); ?></td>
                                        <td><?php echo ($all_part == "0"  ?  '-' : $all_part); ?></td>
                                        <td><?php echo ($all_total == "0"  ?  '-' : $all_total); ?></td>
                                    </tr>
                                    <?php
                                            $i++;
                                        }
                                    ?>
                                <?php
                                    $current = $db->query('SELECT
                                                                SUM(all_ro10_emp_master.staff) as staff,
                                                                SUM(all_ro10_emp_master.contract) as contract_all,
                                                                SUM(all_ro10_emp_master.train) as part_time,
                                                                all_ro10_emp_master.division
                                                            FROM
                                                                all_ro10_emp_master');
                                     $current = $db->single();
                                     $contract_all = $current["contract_all"];
                                     $part_time = $current["part_time"];
                                     $staff= $current["staff"];
                                     $total = $staff + $contract_all + $part_time;

                                      $curent_now = $db->query('SELECT all_ro10_emp.division,all_ro10_emp.data_date,
                                                                            COUNT(CASE WHEN all_ro10_emp.emp_type_id = 1 then 1 ELSE NULL END) as "emp",
                                                                            COUNT(CASE WHEN all_ro10_emp.emp_type_id = 2 then 1 ELSE NULL END) as "contract_all",
                                                                            COUNT(CASE WHEN all_ro10_emp.emp_type_id = 3 then 1 ELSE NULL END) as "part_time",
                                                                            COUNT(all_ro10_emp.emp_type_id) as "total"
                                                                        FROM all_ro10_emp
                                                                        WHERE all_ro10_emp.data_date = :today  ');
                                       $curent_now = $db->bind(':today', $today);
                                       $curent_now = $db->single();
                                       $cur_emp = $curent_now["emp"];
                                       $cur_contract = $curent_now["contract_all"];
                                       $cur_part_time = $curent_now["part_time"];
                                       $cur_total = $curent_now["total"];

                                       $all_emp = abs($cur_emp) - abs($current["staff"]);
                                       $all_contract =  $cur_contract - $current["contract_all"];
                                       $all_train_ =  $current["part_time"] - $cur_part_time;
                                       $all_total =$total - $cur_total ;
                                ?>
                                    <tr>
                                        <td colspan="2"><div align="right"><b>รวม</b></div></td>
                                        <td><?php echo ($current["staff"]); ?></td>
                                        <td><?php echo ($current["contract_all"]); ?></td>
                                        <td><?php echo ($current["part_time"]); ?></td>
                                        <td><?php echo ($total); ?></td>
                                        <td><?php echo ($curent_now["emp"]); ?></td>
                                        <td><?php echo ($curent_now["contract_all"]); ?></td>
                                        <td><?php echo ($curent_now["part_time"]); ?></td>
                                        <td><?php echo ($curent_now["total"]); ?></td>
                                        <td><?php echo ($all_emp) ?></td>
                                        <td><?php echo ($all_contract) ?></td>
                                        <td><?php echo ($all_train_) ?></td>
                                        <td><?php echo ($all_total) ?></td>
                                    </tr>
                                 </tbody>
                            </table>
                        </div>
                    </div>
                </div>
         </div><!-- col-lg-12 -->
        </div><!-- row -->

                   <div class="row">
                       <div class="col-lg-12">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-male"></i>
                                               &nbsp;&nbsp; ความเคลื่อนไหนภายในเดือนนี้
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-lg-12">
                                        <table class="table table-striped table-bordered numformat" id="total" width="100%">
                                            <div class="pull-left">
                                                  ตารางสรุปความเคลื่อนไหวภายในเดือน <?php echo date('F'); ?>
                                            </div>
                                            <div class="pull-right">

                                                <a href="#" onClick="doExport('#total', {type: 'excel',fileName: 'ตารางสรุปความเคลื่อนไหวภายในเดือน <?php echo date('M'),"-",$year; ?>' ,worksheetName: 'ความเคลื่อนไหนภายในเดือนนี้'});">
                                                    <img src='icons/xls.png' alt="Xls" style="width:24px">
                                                </a>
                                            </div>
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">NO.</th>
                                                    <th rowspan="2"><div align="center">หน่วยงานใน RO10</div></th>
                                                    <th colspan="3"><div align="center">จำนวนพนักงานปัจจุจัน</div></th>
                                                    <th rowspan="2"><div align="center">รวม</div></th>
                                                    <th colspan="3"><div align="center">พนักงานลาออกในเดือน</div></th>
                                                    <th rowspan="2"><div align="center">รวม</div></th>
                                                    <th colspan="3"><div align="center">พนักงานเข้าใหม่ในเดือน</div></th>
                                                    <th rowspan="2"><div align="center">รวม</div></th>
                                                </tr>
                                                <tr>
                                                    <th><div align="center">Permanent</div></th>
                                                    <th><div align="center">Contract</div></th>
                                                    <th><div align="center">Part Time</div></th>
                                                    <th><div align="center">Permanent</div></th>
                                                    <th><div align="center">Contract</div></th>
                                                    <th><div align="center">Part Time</div></th>
                                                    <th><div align="center">Permanent</div></th>
                                                    <th><div align="center">Contract</div></th>
                                                    <th><div align="center">Part Time</div></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                              $division = $db->query('SELECT all_ro10_emp.division,all_ro10_emp.emp_type_id,
                                                                            COUNT(CASE WHEN all_ro10_emp.emp_type_id = 1 then 1 ELSE NULL END) as "emp",
                                                                            COUNT(CASE WHEN all_ro10_emp.emp_type_id = 2 then 1 ELSE NULL END) as "contract",
                                                                            COUNT(CASE WHEN all_ro10_emp.emp_type_id = 3 then 1 ELSE NULL END) as "part_time",
                                                                            COUNT(all_ro10_emp.division) as "total",
                                                                            all_tttbb_division2.department_id,
                                                                            all_tttbb_division2.division
                                                                        FROM all_ro10_emp
                                                                        INNER JOIN all_tttbb_division2 ON all_ro10_emp.division = all_tttbb_division2.division
                                                                        WHERE all_ro10_emp.data_date = :today
                                                                        GROUP BY all_ro10_emp.division,all_tttbb_division2.department_id
                                                                        ORDER BY all_tttbb_division2.division DESC');
                                               $division = $db->bind(':today', $today);
                                               $division = $db->execute();
                                               $count = 1;
                                               $division = $db->fetch();

                                                  foreach ($division as $key => $value) {

                                                       $name = $value["division"];
                                                       $department_id = $value["department_id"];
                                                       $emp_type = $value["emp_type_id"];

                                                        // ลาออก
                                                        $sql = $db->query('SELECT
                                                                    all_ro10_emp_trans.date_finish,
                                                                    all_ro10_emp_trans.division,
                                                                    all_ro10_emp_trans.section,
                                                                    all_ro10_emp_trans.emp_id,
                                                                    all_ro10_emp_trans.data_date,
                                                                    COUNT(CASE WHEN all_ro10_emp_trans.emp_type_id = 1 then 1 ELSE NULL END) as "emp",
                                                                    COUNT(CASE WHEN all_ro10_emp_trans.emp_type_id = 2 then 1 ELSE NULL END) as "contract",
                                                                    COUNT(CASE WHEN all_ro10_emp_trans.emp_type_id = 3 then 1 ELSE NULL END) as "part_time",
                                                                    COUNT(all_ro10_emp_trans.division) as "total"
                                                                FROM
                                                                    all_ro10_emp_trans
                                                                WHERE MONTH(all_ro10_emp_trans.date_finish) = :month
                                                                AND date(all_ro10_emp_trans.data_date) = :today
                                                                AND (YEAR(all_ro10_emp_trans.date_finish) = :year OR YEAR(all_ro10_emp_trans.date_finish) = :thai_year)
                                                                AND all_ro10_emp_trans.division = :name');
                                                         $sql = $db->bind(':today', $today);
                                                         $sql = $db->bind(':month', $month);
                                                         $sql = $db->bind(':name', $name);
                                                         $sql = $db->bind(':year', $year);
                                                         $sql = $db->bind(':thai_year', $year_thai);
                                                         $sql = $db->single();

                                                         //เข้าใหม่

                                                          $start_emp = $db->query('SELECT  COUNT(CASE WHEN all_ro10_emp.emp_type_id = 1 then 1 ELSE NULL END) as "emp",
                                                                             COUNT(CASE WHEN all_ro10_emp.emp_type_id = 2 then 1 ELSE NULL END) as "contract",
                                                                             COUNT(CASE WHEN all_ro10_emp.emp_type_id = 3 then 1 ELSE NULL END) as "part_time",
                                                                             COUNT(all_ro10_emp.division) as "total"
                                                                  FROM all_ro10_emp
                                                                 WHERE MONTH(date_start) = :month
                                                                 AND (YEAR(date_start) = :thai_year OR  YEAR(date_start) = :year)
                                                                 AND data_date = :today
                                                                 AND division = :name');
                                                           $start_emp = $db->bind(':year', $year, PDO::PARAM_STR);
                                                           $start_emp = $db->bind(':month', $month, PDO::PARAM_STR);
                                                           $start_emp = $db->bind(':thai_year', $year_thai, PDO::PARAM_STR);
                                                           $start_emp = $db->bind(':today', $today, PDO::PARAM_STR);
                                                           $start_emp = $db->bind(':name', $name);
                                                           $start_emp = $db->single();
                                            ?>

                                                <tr>
                                                    <td><?php echo $count; ?></td>
                                                    <td><?php echo $name; ?></a></td>
                                                    <td><?php echo ($value["emp"]== "0"  ?  '-' : $value["emp"]); ?></a></td>
                                                    <td><?php echo ($value["contract"]== "0"  ?  '-' : $value["contract"]); ?></td>
                                                    <td><?php echo ($value["part_time"]== "0"  ?  '-' : $value["part_time"]); ?></td>
                                                    <td><?php echo ($value["total"]== "0"  ?  '-' : $value["total"]); ?></td>
                                                    <td><?php echo ($sql["emp"] == "0"  ?  '-' : $sql["emp"]); ?></td>
                                                    <td><?php echo ($sql["contract"] == "0"  ?  '-' : $sql["contract"]); ?></td>
                                                    <td><?php echo ($sql["part_time"]== "0"  ?  '-' : $sql["part_time"]); ?></td>
                                                    <td><?php echo ($sql["total"]== "0"  ?  '-' : $sql["total"]); ?></td>
                                                    <td><?php echo ($start_emp["emp"] == "0" ?  '-' : $start_emp["emp"]); ?></td>
                                                    <td><?php echo ($start_emp["contract"] == "0" ? '-' : $start_emp["contract"]); ?></td>
                                                    <td><?php echo ($start_emp["part_time"] == "0" ? '-': $start_emp["part_time"]); ?></td>
                                                    <td><?php echo ($start_emp["total"] == "0" ? '-' : $start_emp["total"]); ?></td>
                                                </tr>
                                            <?php
                                                  $count++;

                                                }

                                            ?>
                                                <tr>
                                                  <td colspan="2"><div align="right"><b>รวม</b></div></td>
                                                    <?php
                                                        $all = $db->query("SELECT COUNT(CASE WHEN all_ro10_emp.emp_type_id = 1 then 1 ELSE NULL END) as 'emp',
                                                                            COUNT(CASE WHEN all_ro10_emp.emp_type_id = 2 then 1 ELSE NULL END) as 'contract',
                                                                            COUNT(CASE WHEN all_ro10_emp.emp_type_id = 3 then 1 ELSE NULL END) as 'part_time',
                                                                            COUNT(all_ro10_emp.division) as 'total'
                                                                      FROM all_ro10_emp
                                                                      WHERE all_ro10_emp.data_date = :today ");
                                                        $all = $db->bind(':today', $today);
                                                        $all = $db->execute();
                                                        $all = $db->fetchNum();

                                            //ลาออก
                                                        $toal = $db->query('SELECT
                                                                    all_ro10_emp_trans.date_finish,
                                                                    all_ro10_emp_trans.division,
                                                                    all_ro10_emp_trans.emp_id,
                                                                    all_ro10_emp_trans.data_date,
                                                                    COUNT(CASE WHEN all_ro10_emp_trans.emp_type_id = 1 then 1 ELSE NULL END) as "emp",
                                                                    COUNT(CASE WHEN all_ro10_emp_trans.emp_type_id = 2 then 1 ELSE NULL END) as "contract",
                                                                    COUNT(CASE WHEN all_ro10_emp_trans.emp_type_id = 3 then 1 ELSE NULL END) as "part_time",
                                                                    COUNT(all_ro10_emp_trans.emp_id) as "all"
                                                                FROM
                                                                    all_ro10_emp_trans
                                                                WHERE MONTH(all_ro10_emp_trans.date_finish) = :month
                                                                AND date(all_ro10_emp_trans.data_date) = :today
                                                                AND (YEAR(all_ro10_emp_trans.date_finish) = :year OR YEAR(all_ro10_emp_trans.date_finish) = :thai_year) ');
                                                       $toal = $db->bind(':today', $today);
                                                       $toal = $db->bind(':month', $month);
                                                       $toal = $db->bind(':year', $year);
                                                       $toal = $db->bind(':thai_year', $year_thai);
                                                       $toal = $db->single();

                                             //เข้าใหม่
                                                        $toal_new = $db->query('SELECT
                                                                    all_ro10_emp.date_start,
                                                                    all_ro10_emp.division,
                                                                    all_ro10_emp.emp_id,
                                                                    all_ro10_emp.data_date,
                                                                    COUNT(CASE WHEN all_ro10_emp.emp_type_id = 1 then 1 ELSE NULL END) as "emp",
                                                                    COUNT(CASE WHEN all_ro10_emp.emp_type_id = 2 then 1 ELSE NULL END) as "contract",
                                                                    COUNT(CASE WHEN all_ro10_emp.emp_type_id = 3 then 1 ELSE NULL END) as "part_time",
                                                                    COUNT(all_ro10_emp.emp_id) as "all_emp"
                                                                FROM
                                                                    all_ro10_emp
                                                                WHERE MONTH(all_ro10_emp.date_start) = :month
                                                                AND date(all_ro10_emp.data_date) = :today
                                                                AND (YEAR(all_ro10_emp.date_start) = :year OR YEAR(all_ro10_emp.date_start) = :thai_year)');
                                                         $toal_new = $db->bind(':today', $today);
                                                         $toal_new = $db->bind(':month', $month);
                                                         $toal_new = $db->bind(':year', $year);
                                                         $toal_new = $db->bind(':thai_year', $year_thai);
                                                         $toal_new = $db->single();
                                            ?>
                                                    <td><?php echo ($all[0]== "0"  ?  '-' : $all[0]); ?></td>
                                                    <td><?php echo ($all[1]== "0"  ?  '-' : $all[1]); ?></td>
                                                    <td><?php echo ($all[2]== "0"  ?  '-' : $all[2]); ?></td>
                                                    <td><?php echo ($all[3]== "0"  ?  '-' : $all[3]); ?></td>
                                                    <td><?php echo ($toal["emp"] == "0"  ?  '-' : $toal["emp"]);   ?></td>
                                                    <td><?php echo ($toal["contract"]== "0"  ?  '-' : $toal["contract"]);  ?></td>
                                                    <td><?php echo ($toal["part_time"]== "0"  ?  '-' : $toal["part_time"]);  ?></td>
                                                    <td><?php echo ($toal["all"]== "0"  ?  '-' : $toal["all"]);  ?></td>
                                                    <td><?php echo ($toal_new["emp"] == "0"  ?  '-' : $toal_new["emp"]); ?></td>
                                                    <td><?php echo ($toal_new["contract"] == "0"  ? '-' : $toal_new["contract"]); ?></td>
                                                    <td><?php echo ($toal_new["part_time"] == "0"  ?  '-' : $toal_new["part_time"]); ?></td>
                                                    <td><?php echo ($toal_new["all_emp"] == "0"  ?  '-' : $toal_new["all_emp"]); ?></td>
                                                </tr>
                                             </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div><!-- container-fluid -->
        </div><!-- page-content-wrapper -->



</body>
</html>
