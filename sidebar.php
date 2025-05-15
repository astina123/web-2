<?php
// Pastikan session sudah dimulai di file yang menginclude sidebar ini
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}
?>

<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
   <div class="sb-sidenav-menu">
      <div class="nav">
         <div class="sb-sidenav-menu-heading">Menu</div>
         <a class="nav-link" href="<?php echo getBasePath(); ?>dashboard.php">
            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
            Dashboard
         </a>

         <div class="sb-sidenav-menu-heading">Data</div>

         <a class="nav-link" href="<?php echo getBasePath(); ?>pegawai/index.php">
            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
            Data Pegawai
         </a>

         <a class="nav-link" href="<?php echo getBasePath(); ?>anggota/index.php">
            <div class="sb-nav-link-icon"><i class="fas fa-id-card"></i></div>
            Data Anggota
         </a>

         <a class="nav-link" href="<?php echo getBasePath(); ?>jenis-produk/index.php">
            <div class="sb-nav-link-icon"><i class="fas fa-tags"></i></div>
            Jenis Produk
         </a>

         <a class="nav-link" href="<?php echo getBasePath(); ?>produk/index.php">
            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
            Produk
         </a>

         <a class="nav-link" href="<?php echo getBasePath(); ?>pesanan/index.php">
            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
            Pesanan
         </a>

         <a class="nav-link" href="<?php echo getBasePath(); ?>detail-pesanan/index.php">
            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
            Detail Pesanan
         </a>

         <a class="nav-link" href="<?php echo getBasePath(); ?>pembayaran/index.php">
            <div class="sb-nav-link-icon"><i class="fas fa-money-bill-wave"></i></div>
            Pembayaran
         </a>
         <a class="nav-link" href="<?php echo getBasePath(); ?>kartu-diskon/index.php">
            <div class="sb-nav-link-icon"><i class="fas fa-money-bill-wave"></i></div>
            Kartu Diskon
         </a>
      </div>
   </div>
   <div class="sb-sidenav-footer">
      <div class="small">Logged in as:</div>
      <?= $_SESSION['user']['nama'] ?? 'Guest'; ?>
   </div>

</nav>

<?php
/**
 * Helper function to get the correct base path regardless of current directory depth
 * This ensures links work properly from any subdirectory
 */
function getBasePath()
{
   // Get the current script path relative to document root
   $current_path = $_SERVER['SCRIPT_NAME'];
   $path_parts = explode('/', $current_path);

   // Remove the file name and current directory from the path
   array_pop($path_parts); // Remove file name
   $current_dir = end($path_parts);

   // Calculate the path to get back to root
   $base_path = '';

   // If we're in a subdirectory like "jenis-produk", "pegawai", etc.
   if (in_array($current_dir, ['anggota', 'assets', 'jenis-produk', 'layout', 'pegawai', 'pembayaran', 'detail-pesanan', 'pesanan', 'produk', 'kartu-diskon'])) {
      $base_path = '../';
   }

   return $base_path;
}
?>