
<?php 

function menu_list($divisi, $divisiName){ 
if( $divisi == 2 || $divisi == 1){
?>
    <li class="sidebar-item">
        <a data-target="#sb1" data-toggle="collapse" class="sidebar-link collapsed bg-light">
            <i class="align-middle" data-feather="trending-up"></i> <span class="align-middle"> Data Penjualan</span>
        </a>

        <ul id="sb1" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">

            <?php if(Yii::$app->user->identity->id == 1 || Yii::$app->user->identity->id == 4){ ?>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=board"> Dashboard</a></li>

            <?php } ?>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=penjualan"> Penjualan</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=wo"> Work Order</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=pengiriman"> Antar / Ambil Barang</a></li>

        </ul>
    </li>
    <li class="sidebar-item">
        <a data-target="#sb2" data-toggle="collapse" class="sidebar-link collapsed bg-light">
            <i class="align-middle" data-feather="shopping-cart"></i> <span class="align-middle"> Data Stok</span>
        </a>

        <ul id="sb2" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=dopembelian"> DO Pembelian</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=retur"> Retur</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=rma"> RMA</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=do-produk/global"> Global Stok</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=do-produk/stokterjual"> Stok Terjual</a></li>
        </ul>
    </li>
    <li class="sidebar-item">

        <a data-target="#sb3" data-toggle="collapse" class="sidebar-link collapsed bg-light">
            <i class="align-middle" data-feather="book-open"></i> <span class="align-middle"> Kas</span>
        </a>

        <ul id="sb3" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=akun-saldo/transaksi"> Transaksi</a></li>
            
            <?php if( $divisi == 1){ ?>
            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=margin"> Report Margin</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=neraca"> Neraca</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=salary"> Salary</a></li>
            <?php } ?>
        </ul>
    </li>
    <li class="sidebar-item">

        <a data-target="#sb4" data-toggle="collapse" class="sidebar-link collapsed bg-light">
            <i class="align-middle" data-feather="briefcase"></i> <span class="align-middle"> Kelola Aset</span>
        </a>

        <ul id="sb4" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link bg-light" href="#"> Aset</a></li>
        </ul>
    </li>
    <li class="sidebar-item">

        <a data-target="#sb5" data-toggle="collapse" class="sidebar-link collapsed bg-light">
            <i class="align-middle" data-feather="git-branch"></i> <span class="align-middle"> Linked Data</span>
        </a>

        <ul id="sb5" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=konsumen"> Konsumen</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=supplier"> Supplier</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=produk"> Produk</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=kategori"> Produk Kategori</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=merek"> Merek</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=stok-jenis"> Jenis Stok</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=inventori"> Inventori</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=rakitan"> Rakitan Ready</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=rakitan/rakitansold"> Rakitan Terjual</a></li>

            <!-- <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=lokasi"> Lokasi</a></li> -->

        </ul>
    </li>
    <li class="sidebar-item">

        <a data-target="#sb6" data-toggle="collapse" class="sidebar-link collapsed bg-light">
            <i class="align-middle" data-feather="database"></i> <span class="align-middle"> Base Data  <?php echo ucfirst($divisiName); ?></span>
        </a>

        <ul id="sb6" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=report"> Report Dev</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=absen"> Absensi</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=aktiva"> Akun Aktif</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=beban"> Beban</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=beban-jenis"> Jenis Beban</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=divisi"> Divisi</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=backend-user"> Karyawan & User</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=akun"> Rekening Bank</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=variable"> MJT Setting</a></li>

        </ul>

        <!-- <a data-target="#sb3" data-toggle="collapse" class="sidebar-link collapsed bg-light">
            <i class="align-middle" data-feather="trending-up"></i> <span class="align-middle"> Report</span>
        </a>

        <ul id="sb3" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="#"> Rugi / Laba</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="#"> Global Report</a></li>

        </ul> -->
    </li>
 <?php }elseif( $divisi == 3){ ?>
     <li class="sidebar-item">
         <a data-target="#sb1" data-toggle="collapse" class="sidebar-link collapsed bg-light" aria-expanded="false">
             <i class="align-middle" data-feather="tag"></i> <span class="align-middle"> <?php echo ucfirst($divisiName); ?></span>
         </a>
 
         <ul id="sb1" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=penjualan" style="border-top: #eaeaea;"> Penjualan</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=rakitan" style="border-top: #eaeaea;"> Rakitan Ready</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=rakitan/rakitansold" style="border-top: #eaeaea;"> Rakitan Terjual</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=do-produk/global" style="border-top: #eaeaea;"> Global Stok</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=wo" style="border-top: #eaeaea;"> Work Order</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=pengiriman" style="border-top: #eaeaea;"> Antar / Ambil Barang</a></li>


            <!-- <li class="sidebar-item"><a class="sidebar-link bg-light" href="#" style="border-top: #eaeaea;"> Transport Fee</a></li> -->
         </ul>
 
         <a data-target="#sb2" data-toggle="collapse" class="sidebar-link collapsed bg-light" aria-expanded="false">
             <i class="align-middle" data-feather="database"></i> <span class="align-middle"> Base Data  <?php echo ucfirst($divisiName); ?></span>
         </a>
 
         <ul id="sb2" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=report"> Report Dev</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=konsumen" style="border-top: #eaeaea;"> Konsumen</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=supplier" style="border-top: #eaeaea;"> Supplier</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=akun" style="border-top: #eaeaea;"> Rekening Bank</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=produk" style="border-top: #eaeaea;"> Produk</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=kategori" style="border-top: #eaeaea;"> Produk Kategori</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=merek" style="border-top: #eaeaea;"> Merek</a></li>

            <!-- <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=stok-jenis" style="border-top: #eaeaea;"> Jenis Stok</a></li> -->

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=inventori" style="border-top: #eaeaea;"> Inventori</a></li>


         </ul>
 
     </li>
 
<?php }elseif( $divisi == 5){ ?>
    <li class="sidebar-item">
        <a data-target="#sb1" data-toggle="collapse" class="sidebar-link collapsed bg-light" aria-expanded="false">
            <i class="align-middle" data-feather="tag"></i> <span class="align-middle"> <?php echo ucfirst($divisiName); ?></span>
        </a>

        <ul id="sb1" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=order" style="border-top: #eaeaea;"> Order</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=tracking-order" style="border-top: #eaeaea;"> Tracking Order</a></li>
        </ul>

        <a data-target="#sb2" data-toggle="collapse" class="sidebar-link collapsed bg-light" aria-expanded="false">
            <i class="align-middle" data-feather="database"></i> <span class="align-middle"> Base Data  <?php echo ucfirst($divisiName); ?></span>
        </a>

        <ul id="sb2" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=konsumen" style="border-top: #eaeaea;"> Konsumen</a></li>

        </ul>

    </li>

<?php } else { ?> 
    <li class="sidebar-item">
        <a data-target="#sb1" data-toggle="collapse" class="sidebar-link collapsed bg-light" aria-expanded="false">
            <i class="align-middle" data-feather="tag"></i> <span class="align-middle"> <?php echo ucfirst($divisiName); ?></span>
        </a>

        <ul id="sb1" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=tracking-order" style="border-top: #eaeaea;"> Tracking Order</a></li>
            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=order" style="border-top: #eaeaea;"> Order</a></li>
        </ul>

        <a data-target="#sb2" data-toggle="collapse" class="sidebar-link collapsed bg-light" aria-expanded="false">
            <i class="align-middle" data-feather="database"></i> <span class="align-middle"> Base Data  <?php echo ucfirst($divisiName); ?></span>
        </a>

        <ul id="sb2" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=report"> Report Dev</a></li>

            <li class="sidebar-item"><a class="sidebar-link bg-light" href="../web/index.php?r=konsumen" style="border-top: #eaeaea;"> Konsumen</a></li>

        </ul>
    </li>
<?php } ?> 

<?php } ?>