<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li  <?php if($_GET["m"]==""){ echo 'class="active"';}?>>
          <a href="index.php">
            <i class="fa fa-dashboard"></i> <span>DASHBOARD</span>
          </a>
        </li>

        <?php 
          $sql_nav1 = "SELECT DISTINCT(a.Nav1) AS Nav1, a.Icon
                      FROM ms_nav a WHERE a.Nav1 != '' 
                          AND (SELECT COUNT(b.NavID) FROM ms_privilege b 
                                WHERE b.NavID = a.NavID AND b.UserID = '".$_SESSION["userid"]."') > 0
                      ORDER BY a.Urut ASC"; 
          $data_nav1 =$sqlLib->select($sql_nav1);  
          foreach ($data_nav1 as $row_nav1) 
            {?>

              <li class="treeview">
                <a href="#">
                  <i class="<?php echo $row_nav1['Icon']?>"></i>
                  <span><?php echo strtoupper($row_nav1['Nav1'])?></span>
                  <span class="pull-right-container">              
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <?php 
                    $sql_nav2 = "SELECT a.Nav2, a.Path
                                FROM ms_nav a WHERE a.Nav1 = '".$row_nav1["Nav1"]."' AND 
                                    (SELECT COUNT(b.NavID) FROM ms_privilege b 
                                        WHERE b.NavID = a.NavID AND b.UserID = '".$_SESSION["userid"]."') > 0
                                ORDER BY a.NavID ASC"; 
                    $data_nav2 =$sqlLib->select($sql_nav2); 
                    foreach ($data_nav2 as $row_nav2) 
                      { ?>
                        <li>
                          <a href="index.php?m=<?php echo acakacak("encode",$row_nav2['Path'])?>&p=<?php echo acakacak("encode",$row_nav2['Nav2'])?>">
                            <i class="fa fa-circle-o"></i><?php echo $row_nav2['Nav2']?>
                          </a>
                        </li>
                      <?php } ?>

                </ul>
              </li>
            <?php
            }          
          ?>   
      </ul>

    </section>
    <!-- /.sidebar -->
  </aside>