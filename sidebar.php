  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="dropdown">
    <a href="./" class="brand-link">
    <?php if($_SESSION['login_user_type_id'] == 1): ?>
        <h3 class="text-center p-0 m-0"><b>ADMIN</b></h3>
    <?php elseif($_SESSION['login_user_type_id'] == 2): ?>
        <h3 class="text-center p-0 m-0"><b>STUDENT</b></h3>
    <?php elseif($_SESSION['login_user_type_id'] == 3): ?>
        <h3 class="text-center p-0 m-0"><b>ROOM OWNER</b></h3>
    <?php elseif($_SESSION['login_user_type_id'] == 4): ?>
        <h3 class="text-center p-0 m-0"><b>MESS OWNER</b></h3>
    <?php endif; ?>
</a>

    </div>
    <div class="sidebar pb-4 mb-4">
      <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item dropdown">
            <a href="./" class="nav-link nav-home">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <?php if($_SESSION['login_user_type_id'] == 2 ): ?>
            <li class="nav-item">
                <a href="./index.php?page=curriculum" class="nav-link nav-   tree-item">
                  <i class="nav-icon fas fa-print"></i>
                  <p>Curriculum Activities</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="./index.php?page=scholarship" class="nav-link nav-   tree-item">
                  <i class="nav-icon fas fa-print"></i>
                  <p>Scholarship</p>
                </a>
            </li>

          <li class="nav-item">
            <a href="#" class="nav-link nav-Letters nav-Letters ">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>
                Study Material
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
            <?php if($_SESSION['login_user_type_id'] == 3 | $_SESSION['login_user_type_id'] == 2 ): ?>
              <li class="nav-item">
                <a href="./index.php?page=new_material" class="nav-link nav-new_letter tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Add New</p>
                </a>
              </li>
            <?php endif; ?>
              <li class="nav-item">
                <a href="./index.php?page=list_material" class="nav-link nav-letter_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
            </ul>
          </li>          
          <?php endif;?>




          <?php if($_SESSION['login_user_type_id'] == 3  || $_SESSION['login_user_type_id'] == 2 ): ?>

          <li class="nav-item">
            <a href="#" class="nav-link nav-Letters nav-Letters nav-link nav-reports ">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>
                Rooms 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
            <?php if($_SESSION['login_user_type_id'] == 3): ?>
              <li class="nav-item">
                <a href="./index.php?page=new_room" class="nav-link nav-new_letter tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Add Room</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=list_room" class="nav-link nav-letter_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List Room</p>
                </a>
              </li>
            <?php endif; ?>
            <?php if($_SESSION['login_user_type_id'] == 2 ): ?>
              <li class="nav-item">
                <a href="./index.php?page=apply_room" class="nav-link nav-new_letter tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Apply Room</p>
                </a>
              </li>
            <?php endif; ?>
              
            </ul>
          </li>  
        <?php endif;?>

          <?php if($_SESSION['login_user_type_id'] == 4  || $_SESSION['login_user_type_id'] == 2 ): ?>

          <li class="nav-item">
            <a href="#" class="nav-link nav-Letters nav-Letters nav-link nav-reports ">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>
                Mess 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
            <?php if($_SESSION['login_user_type_id'] == 4): ?>
              <li class="nav-item">
                <a href="./index.php?page=update_mess" class="nav-link nav-new_letter tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Update Mess</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=list_customers" class="nav-link nav-letter_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List Customers</p>
                </a>
              </li>
            <?php endif; ?>
            <?php if($_SESSION['login_user_type_id'] == 2 ): ?>
              <li class="nav-item">
                <a href="./index.php?page=apply_mess" class="nav-link nav-new_letter tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Apply Mess</p>
                </a>
              </li>
            <?php endif; ?>
              
            </ul>
          </li>  
        <?php endif;?>

          
          
          <?php if($_SESSION['login_user_type_id'] == 1): ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_user">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=new_user" class="nav-link nav-new_user tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Add New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=user_list" class="nav-link nav-user_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
            </ul>
          </li>
        <?php endif; ?>
        </ul>
      </nav>
    </div>
  </aside>
  <script>
  	$(document).ready(function(){
      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
  		var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
      if(s!='')
        page = page+'_'+s;
  		if($('.nav-link.nav-'+page).length > 0){
             $('.nav-link.nav-'+page).addClass('active')
  			if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
            $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
  				$('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
  			}
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

  		}

  	})
  </script>