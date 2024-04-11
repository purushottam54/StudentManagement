<?php include('db_connect.php') ?>
 <div class="col-12">
          <div class="card">
            <div class="card-body">
              Welcome <?php echo $_SESSION['login_user_name']." ".$_SESSION['login_user_surname'] ?>!
            </div>
          </div>
  </div>
  <hr>



  <?php if($_SESSION['login_user_type_id'] == 2): ?>
      <div class="row">
        <div class="col-8">
        <div class="card card-outline card-success">
          <div class="card-header">
            <b>Self Study Material</b>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0 table-hover">
                <colgroup>
                  <col width="5%">
                  <col width="30%">
                  <col width="35%">
                  <col width="15%">
                  <col width="15%">
                </colgroup>
                <thead>
                  <th>#</th>
                  <th>Category</th>
                  <th>Type</th>
                  <th>Action</th>
                  <th></th>
                </thead>
                <tbody>
                <?php
                $i = 1;
                $material_type = ["PDF","PPT","Docs","Handwritten Notes","Image"];
                $where = "";
                if($_SESSION['login_user_type_id'] == 2){
                  $where = " WHERE material_user_id = ( SELECT student_id FROM students WHERE stud_user_id =  '{$_SESSION['login_user_id']}')";
                }
                $qry = $conn->query("SELECT * FROM material $where order by material_id asc");
                while($row = $qry->fetch_assoc()):?>
                  <tr>
                      <td>
                         <?php echo $i++ ?>
                      </td>
                      <td>
                          <a>
                              <?php echo ucwords($row['material_category']) ?>
                          </a>
                          <br>
                          <small>
                              Date: <?php echo date("Y-m-d",strtotime($row['material_date'])) ?>
                          </small>
                      </td>
                      <td class="project_progress">
                          <a>
                              <?php echo $material_type[$row['material_type']] ?>
                          </a>
                      </td>
                      <td>
                        <a class="btn btn-primary btn-sm " href="./index.php?page=view_material&id=<?php echo $row['material_id'] ?>">
                              <i class="fas fa-folder">
                              </i>
                              View
                        </a>
                      </td>
                  </tr>
                <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        </div>
        <div class="col-md-4">
          <div class="row">
          <div class="col-12 col-sm-6 col-md-12">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM material $where")->num_rows; ?></h3>
                <p>Total Material</p>
              </div>
              <div class="icon">
                <i class="fa fa-layer-group"></i>
              </div>
            </div>
          </div>
          </div>
      </div>
        </div>
      </div>

  <?php endif;?>


<?php if($_SESSION['login_user_type_id'] == 3): ?>
<div class="row">
    <div class="col-8">
        <div class="card card-outline card-success">
            <div class="card-header">
                <b>Students In Room</b>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0 table-hover">
                        <colgroup>
                            <col width="10%">
                            <col width="30%">
                            <col width="30%">
                            <col width="30%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Room ID</th>
                                <th>Student Name</th>
                                <th>Student Surname</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;

                            $where = "WHERE stud_room_id IN ( SELECT room_id  FROM room WHERE room_user_id =  ".$_SESSION['login_user_id'].")";
                            $qry = $conn->query("SELECT * FROM students $where order by stud_room_id asc");
                            while($row = $qry->fetch_assoc()):?>
                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td><a><?php echo ucwords($row['stud_room_id']) ?></a></td>
                                <td class="project_progress">
                                    <a>
                                        <?php
                                            $qry2 = $conn->query("SELECT user_name, user_surname FROM users WHERE user_id = ".$row['stud_user_id']);
                                            $row2 = $qry2->fetch_assoc();
                                            echo $row2['user_name'];
                                        ?>
                                    </a>
                                </td>
                                <td class="project_progress">
                                    <a><?php echo $row2['user_surname'] ?></a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-12">
                <div class="small-box bg-light shadow-sm border">
                    <div class="inner">
                        <h3><?php echo $conn->query("SELECT * FROM students $where")->num_rows; ?></h3>
                        <p>Total Students</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-layer-group"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif;?>


<?php if($_SESSION['login_user_type_id'] == 4): ?>
<div class="row">
    <div class="col-8">
        <div class="card card-outline card-success">
            <div class="card-header">
                <b>Students In Room</b>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0 table-hover">
                        <colgroup>
                            <col width="10%">
                            <col width="30%">
                            <col width="30%">
                            <col width="30%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Mess ID</th>
                                <th>Student Name</th>
                                <th>Student Surname</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;

                            $where = "WHERE stud_mess_id IN ( SELECT mess_id  FROM mess WHERE mess_user_id =  ".$_SESSION['login_user_id'].")";
                            $qry = $conn->query("SELECT * FROM students $where order by stud_mess_id asc");
                            while($row = $qry->fetch_assoc()):?>
                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td><a><?php echo ucwords($row['stud_mess_id']) ?></a></td>
                                <td class="project_progress">
                                    <a>
                                        <?php
                                            $qry2 = $conn->query("SELECT user_name, user_surname FROM users WHERE user_id = ".$row['stud_user_id']);
                                            $row2 = $qry2->fetch_assoc();
                                            echo $row2['user_name'];
                                        ?>
                                    </a>
                                </td>
                                <td class="project_progress">
                                    <a><?php echo $row2['user_surname'] ?></a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-12">
                <div class="small-box bg-light shadow-sm border">
                    <div class="inner">
                        <h3><?php echo $conn->query("SELECT * FROM students $where")->num_rows; ?></h3>
                        <p>Total Students</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-layer-group"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif;?>
