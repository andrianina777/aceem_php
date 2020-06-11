 <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div align="center">
      <a href="javascript:void(0)" class="brand-link">
        <img src="../../dist/img/favicon.png" height="70px" alt="AdminLTE Logo" style="background: #fff; padding: 5px; border-radius: 5px;">
      </a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../../dist/img/avatar04.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?=@$_SESSION['pseudo']?></a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="../../pages/dashboard" class="nav-link <?=$page_title=='Tableau de bord'?'active':''?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Tableau de bord
              </p>
            </a>
          </li>
          <?php if ( is_privileged('historiques') || is_privileged('utilisateurs') || is_privileged('groupes')):
            $open = $page_title=='Utilisateurs' || $page_title=='Groupes' || $page_title=='Historiques' ?'menu-open':'';
          ?>
          <li class="nav-item has-treeview <?=$open?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Administration
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php if (is_privileged('utilisateurs')): ?>
              <li class="nav-item">
                <a href="../../pages/utilisateurs" class="nav-link <?=$page_title=='Utilisateurs'?'active':''?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Utilisateurs</p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (is_privileged('groupes')): ?>
              <li class="nav-item">
                <a href="../../pages/groupes" class="nav-link <?=$page_title=='Groupes'?'active':''?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Groupes</p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (is_privileged('historiques')): ?>
              <li class="nav-item">
                <a href="../../pages/historiques" class="nav-link <?=$page_title=='Historiques'?'active':''?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Historiques</p>
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>
          <?php if (is_privileged('parametrages')): ?>
          <li class="nav-item">
            <a href="../../pages/parametrages" class="nav-link <?=$page_title=='Paramètrages'?'active':''?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Paramètrages
              </p>
            </a>
          </li>
          <?php endif; ?>
          <?php if (is_privileged('eleves')): ?>
          <li class="nav-item">
            <a href="../../pages/eleves" class="nav-link <?=$page_title=='Élèves'?'active':''?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Élèves
              </p>
            </a>
          </li>
          <?php endif; ?>
          <?php if (is_privileged('paiements')): ?>
          <li class="nav-item">
            <a href="../../pages/paiements" class="nav-link <?=$page_title=='Paiements'?'active':''?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Paiements
              </p>
            </a>
          </li>
          <?php endif; ?>
          
        <!--Menu Etat général-->
          <li class="nav-item">
            <a href="../../pages/etatGenerals" class="nav-link <?=$page_title=='Etat Général'?'active':''?> ">
            <i class="nav-icon fas fa-table"></i>
              <p>
                Etat Général
              </p>
            </a>
          </li>
                  <!--Numéro reçu manquant-->
          <li class="nav-item">
            <a href="#" class="nav-link ">
            <i class="nav-icon fas fa-table"></i>
              <p>
                Numéro Réçu manquant
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
