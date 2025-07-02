 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="#" class="brand-link">
         <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
         <span class="brand-text font-weight-light">Koperasi</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar user (optional) -->
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image">
                 <div class="rounded-circle overflow-hidden" style="width: 50px; height: 60px;">
                     <img src="dist/img/SAIMA.JPG" class="w-100 h-100 object-fit-cover" alt="User Image">
                 </div>
             </div>
             <div class="info">
                 <a href="#" class="d-block">Saima Fitri</a>
             </div>
         </div>

         <!-- SidebarSearch Form -->
         <div class="form-inline">
             <div class="input-group" data-widget="sidebar-search">
                 <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                 <div class="input-group-append">
                     <button class="btn btn-sidebar">
                         <i class="fas fa-search fa-fw"></i>
                     </button>
                 </div>
             </div>
         </div>

         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                 <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fas fa-tachometer-alt"></i>
                         <p>
                             Dashboard
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="data_pegawai.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Data pegawai</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="data_produk.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Data Produk</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="data_anggota.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Data anggota</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="data_kartu_diskon.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Data Kartu Diskon</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="data_jenis_produk.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Data jenis Produk</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="data_pesanan.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Data Pesanan</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-item">
                     <a href="login.php" class="nav-link">
                         <i class="fas fa-arrow-alt-circle-left nav-icon"></i>
                         <p>Logout</p>
                     </a>
                 </li>
             </ul>
             </li>


             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>