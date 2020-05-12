 <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div align="center">
      <a href="javascript:void(0)" class="brand-link">
        <img src="<?=$base_url?>/dist/img/favicon.png" height="70px" alt="AdminLTE Logo" style="background: #fff; padding: 5px; border-radius: 5px;">
      </a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?=$base_url?>/dist/img/avatar04.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?=@$_SESSION['pseudo']?></a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Tableau de bord
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Administration
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=$base_url?>/pages/utilisateurs" class="nav-link <?=$page_title=='Liste des utilisateurs'?'active':''?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Utilisateurs</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=$base_url?>/pages/groupes" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Groupes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Historiques</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="<?=$base_url?>/pages/parametrages" class="nav-link <?=$page_title=='Paramètrages'?'active':''?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Paramètrages
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=$base_url?>/pages/eleves" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Élèves
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=$base_url?>/pages/paiements" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Paiements
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=$base_url?>/pages/classes" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Classes
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
