<?php  
	include '../config/koneksi.php';
	include '../library/fungsi.php';
	date_default_timezone_set("Asia/Jakarta");
	session_start();

	$aksi= new oop();
	$table ="v_pembayaran";
	$bulanini = $_GET['bulan'];
	$tahunini = $_GET['tahun'];
 	$cari = "WHERE MONTH(tgl_pembayaran) = '$bulanini' AND YEAR(tgl_pembayaran) ='$tahunini' AND id_teller = '$_SESSION[id_teller]'";
 	$filename = "Laporan Riwayat Pemabayaran Bulan $bulanini TAHUN $tahunini";

 	$teller = $aksi->caridata("teller WHERE id_teller = '$_SESSION[id_teller]'");

	if(isset($_GET['excel'])){
    	header("Content-type:aplication/vnd-ms-excel");
		header("Content-type: application/image/png");
    	header("Content-disposition:attachment; filename=".$filename.".xls");
    }
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>CETAK LAPORAN</title>
	<style type="text/css">
		#footer{
			/*background-color: yellow;*/
			position:absolute;
			bottom:1px;
			padding-right: 100px;
			padding-left: 20px;
			width:100%;
			font-weight: bold;
		  	color:black;
		  	font:13px Arial;
		  }
	</style>
</head>
<body onload="window.print()"style="color: black;font-family: Myriad Pro Light;padding: 10px 10px;" >
<!-- INI BAGIAN HEADER LAPORAN -->
	<table width="100%" border="0" cellspacing="0">
		<tr>
			<?php if(isset($_GET['excel'])){ ?>
					<td>&nbsp;</td>
				<?php }else{ ?>
					<td style="margin-top: -20px;" width="15%" valign="top">
						<img src="../images/logo1.png" width="90px" height="90px">
					</td>
				<?php } ?>
			<td colspan="10" align="left">
			<h4 style="margin-top: 10px;margin-left: -10px;">PAYMENT POINT ONLINE BEST</h4>
				<h1 style="margin-top: -20px;margin-left: -10px;" >PT. ELECTRICITYPAY</h1>
				<h5 style="margin-top: -20px;margin-left: -10px;">Jl. Embong Trengguli No.19-21, Embong Kaliasin, Kec. Genteng, Kota SBY, Jawa Timur 60271</h5>
			</td>
		</tr>
		<tr><td colspan="10"><hr style="border: 2px solid black;"></td></tr>

		<tr><td colspan="10"><center><strong><h3><?php echo "LAPORAN RIWAYAT PEMBAYARAN BULAN ";$aksi->bulan($bulanini);echo " TAHUN $tahunini"; ?></h3></strong></center></td></tr>
	</table>
<!-- INI END BAGIAN HEADER LAPORAN -->

<!-- INI ISI LAPORAN -->
	<table width="100%" border="1" cellspacing="0" cellpadding="3">
		<thead>
			<th>No.</th>
			<th>ID Pelanggan</th>
			<th>Nama Pelanggan</th>
			<th>Waktu Pembayaran</th>
			<th>Bulan Pembayaran</th>
			<th><center>Jumlah Pembayaran</center></th>
			<th><center>Biaya Admin</center></th>
			<th><center>Total Akhir</center></th>
			<th><center>Bayar</center></th>
			<th><center>Kembali</center></th>
			<th><center>Manager</center></th>
		</thead>
		<tbody>
			<?php  
				$no=0;
				$data = $aksi->tampil($table,$cari," order by id_pembayaran desc");
				if ($data=="") {
					$aksi->no_record(13);
				}else{
					foreach ($data as $r) {
					$no++; ?>
						<tr>
							<td align="center"><?php echo $no; ?>.</td>
							<td><?php echo $r['id_pelanggan']; ?></td>
							<td><?php echo $r['nama_pelanggan']; ?></td>
							<td><?php echo $r['waktu_pembayaran']; ?></td>
							<td><?php $aksi->bulan($r['bulan_pembayaran']);echo " ".$r['tahun_pembayaran']; ?></td>
							<td><?php $aksi->rupiah($r['jumlah_pembayaran']); ?></td>
							<td><?php $aksi->rupiah($r['biaya_admin']); ?></td>
							<td><?php $aksi->rupiah($r['total']); ?></td>
							<td><?php $aksi->rupiah($r['bayar']); ?></td>
							<td><?php $aksi->rupiah($r['kembali']); ?></td>
							<td><?php echo $r['nama_teller']?></td>
						</tr>

				<?php }} ?>
	 	</tbody>
	</table>
<!-- INI END ISI LAPORAN -->

<!-- INI FOOTER LAPORAN -->
	<div id="footer">
		<table align="right" style="margin-right: 100px;">
			<tr><td rowspan="10" width="50px"></td><td>&nbsp;</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td align="center"><?php $aksi->hari(date("N"));echo ", ";$aksi->format_tanggal(date("Y-m-d")); ?></td>
			</tr>
			<tr>
				<td align="center">Hormat Saya,</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td align="center"><?php echo $_SESSION['nama_manager']; ?></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
		</table>
	</div>
<!-- INI END FOOTER LAPORAN -->
</body>
</html>