<?php
session_start();
require_once 'config/koneksi.php';
require_once 'config/functions.php';

// jika pengguna belum login, tetapi ingin mengakses riwayat.php
if (!isset($_SESSION['username'])) {
  header("Location: paneladmin/index.php");
  exit;
}

$id_pembelian = $_GET['id'];

// menampilkan tb user dengan session
$queryAmbilUser = mysqli_query($conn, "SELECT * FROM tb_user") or die(mysqli_error($conn));
$rowUser = mysqli_fetch_assoc($queryAmbilUser);
$_SESSION['id_user'] = $rowUser['id_user'];

// tb pembayaran & tb_user
$ambil = mysqli_query($conn, "SELECT * FROM tb_pembayaran LEFT JOIN tb_pembelian ON tb_pembayaran.id_pembelian = tb_pembelian.id_pembelian WHERE tb_pembelian.id_pembelian = $id_pembelian") or die(mysqli_error($conn));

$pecah = mysqli_fetch_assoc($ambil);
// echo "<pre>";
// var_dump($pecah);
// var_dump($_SESSION);
// echo "</pre>";

// jika id kosong
if (empty($pecah)) {
  header("Location: riwayat.php");
  exit;
}

// jika user tidak sesuai dengan loginnya, akan di tendang
if ($rowUser['id_user'] != $pecah['id_user']) {
  header("Location: riwayat.php");
  exit;
}

?>
<!DOCTYPE html>
<html>

<head>
  <title>Riwayat Belanja | TokoLineDoo</title>
  <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
  <!--theme-style-->
  <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
  <link href="paneladmin/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <!--//theme-style-->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <script type="application/x-javascript">
    addEventListener("load", function() {
      setTimeout(hideURLbar, 0);
    }, false);

    function hideURLbar() {
      window.scrollTo(0, 1);
    }
  </script>
  <!--fonts-->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
  <!--//fonts-->
  <script src="js/jquery.min.js"></script>


</head>

<body>
  <!--header-->
  <div class="header">
    <div class="top-header">
      <div class="container">
        <div class="top-header-left">
          <ul class="support">
            <li><a href="#"><label> </label></a></li>
            <li><a href="#">24x7 Chat<span class="live"> Bantuan</span></a></li>
          </ul>
          <ul class="support">
            <li class="van"><a href="#"><label> </label></a></li>
            <li><a href="#">Gratis Ongkir <span class="live">Pesanan diatas Rp.500.000 | Repost by <a href='https://stokcoding.com/' title='StokCoding.com' target='_blank'>StokCoding.com</a></span></a></li>
          </ul>
          <div class="clearfix"> </div>
        </div>
        <div class="top-header-right">
          <div class="down-top">
            <select class="in-drop">
              <option value="English" class="in-of">English</option>
              <option value="Japanese" class="in-of">Japanese</option>
              <option value="French" class="in-of">French</option>
              <option value="German" class="in-of">German</option>
            </select>
          </div>
          <div class="down-top top-down">
            <select class="in-drop">

              <option value="Dollar" class="in-of">Dollar</option>
              <option value="Yen" class="in-of">Yen</option>
              <option value="Euro" class="in-of">Euro</option>
            </select>
          </div>
          <!---->
          <div class="clearfix"> </div>
        </div>
        <div class="clearfix"> </div>
      </div>
    </div>
    <div class="bottom-header">
      <div class="container">
        <div class="header-bottom-left">
          <div class="logo">
            <a href="index.php"><img src="images/logo.png" alt=" " /></a>
          </div>
          <div class="search">
            <input type="text" value="" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '';}">
            <input type="submit" value="SEARCH">

          </div>
          <div class="clearfix"> </div>
        </div>
        <div class="header-bottom-right">
          <!-- <div class="account"><a href="login.html"><span> </span>YOUR ACCOUNT</a></div> -->
          <?php if (isset($_SESSION['username'])) : ?>
            <ul class="login">
              <li><a href="<?= base_url('paneladmin/index.php'); ?>"><span> </span>USER</a></li> |
              <li><a href="<?= base_url('paneladmin/logout.php'); ?>"><i class="fa fa-sign-out"></i> LOGUOT</a></li>
            </ul>
          <?php else : ?>
            <ul class="login">
              <li><a href="<?= base_url('paneladmin/index.php'); ?>"><span> </span>MASUK</a></li> |
              <li><a href="register.php">DAFTAR</a></li>
            </ul>
          <?php endif; ?>
          <!-- <div class="cart"><a href="#"><span> </span>KERANJANG</a></div> -->
          <div class="cart"><a href="<?= base_url('paneladmin/index.php'); ?>"><span> </span></a></div>
          <div class="clearfix"> </div>
        </div>
        <div class="clearfix"> </div>
      </div>
    </div>
  </div>
  <!---->
  <div class="container">

    <div class="register">
      <div class="products">
        <h5 class="latest-product"><i class="fa fa-shopping-cart"></i> LIHAT PEMBAYARAN <?= $_SESSION['nama_lengkap']; ?></h5>
        <!-- <a class="view-all" href="product.html">VIEW ALL<span> </span></a>           -->
      </div>
      <div class="row">
        <div class="col-md-6">
          <table class="table">
            <tr>
              <th>Nama</th>
              <td><?= $pecah['nama']; ?></td>
            </tr>
            <tr>
              <th>Bank</th>
              <td><?= $pecah['bank']; ?></td>
            </tr>
            <tr>
              <th>Tanggal</th>
              <td><?= $pecah['tanggal']; ?></td>
            </tr>
            <tr>
              <th>Jumlah</th>
              <td><?= number_format($pecah['jumlah']); ?></td>
            </tr>
          </table>
        </div>
        <div class="col-md-6">
          <img src="images/bukti/<?= $pecah['bukti']; ?>" width="400">
        </div>
      </div>
    </div>
    <div class="sub-cate">
      <?php include 'menu.php'; ?>
    </div>
    <!---->
    <div class="footer">
      <div class="footer-top">
        <div class="container">
          <div class="latter">
            <h6>NEWS-LETTER</h6>
            <div class="sub-left-right">
              <form>
                <input type="text" value="Enter email here" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Enter email here';}" />
                <input type="submit" value="SUBSCRIBE" />
              </form>
            </div>
            <div class="clearfix"> </div>
          </div>
          <div class="latter-right">
            <p>FOLLOW US</p>
            <ul class="face-in-to">
              <li><a href="#"><span> </span></a></li>
              <li><a href="#"><span class="facebook-in"> </span></a></li>
              <div class="clearfix"> </div>
            </ul>
            <div class="clearfix"> </div>
          </div>
          <div class="clearfix"> </div>
        </div>
      </div>
      <div class="footer-bottom">
        <div class="container">
          <div class="footer-bottom-cate">
            <h6>KATEGORI</h6>
            <ul>
              <?php
              $menu = mysqli_query($conn, "SELECT * FROM tb_kategori") or die(mysqli_error($conn));
              while ($row = mysqli_fetch_assoc($menu)) { ?>
                <li><a href="#"><?= $row['nama_kategori']; ?></a></li>
              <?php } ?>
            </ul>
          </div>
          <div class="footer-bottom-cate bottom-grid-cat">
            <h6>FEATURE PROJECTS</h6>
            <ul>
              <li><a href="#">Curabitur sapien</a></li>
              <li><a href="#">Dignissim purus</a></li>
              <li><a href="#">Tempus pretium</a></li>
              <li><a href="#">Dignissim neque</a></li>
              <li><a href="#">Ornared id aliquet</a></li>
              <li><a href="#">Ultrices id du</a></li>
              <li><a href="#">Commodo sit</a></li>
            </ul>
          </div>
          <div class="footer-bottom-cate">
            <h6>BRANDING TERBAIK</h6>
            <ul>
              <li><a href="#">Curabitur sapien</a></li>
              <li><a href="#">Dignissim purus</a></li>
              <li><a href="#">Tempus pretium</a></li>
              <li><a href="#">Dignissim neque</a></li>
              <li><a href="#">Ornared id aliquet</a></li>
              <li><a href="#">Ultrices id du</a></li>
              <li><a href="#">Commodo sit</a></li>
              <li><a href="#">Urna ac tortor sc</a></li>
              <li><a href="#">Ornared id aliquet</a></li>
              <li><a href="#">Urna ac tortor sc</a></li>
              <li><a href="#">Eget nisi laoreet</a></li>
              <li><a href="#">Faciisis ornare</a></li>
            </ul>
          </div>
          <div class="footer-bottom-cate cate-bottom">
            <h6>ALAMAT KAMI</h6>
            <ul>
              <li>Jl.Pepaya</li>
              <li>Pekanbaru, Riau</li>
              <li>No. 491.</li>
              <li class="phone">PH : 6985792466</li>
              <li class="temp">
                <p class="footer-class">Design by <a href="http://w3layouts.com/" target="_blank">W3layouts</a> </p>
              </li>
            </ul>
          </div>
          <div class="clearfix"> </div>
        </div>
      </div>
    </div>
</body>

</html>