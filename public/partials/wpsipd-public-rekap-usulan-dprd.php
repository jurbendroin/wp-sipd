<?php 
global $wpdb; 
$angg = $wpdb->get_results("SELECT iduser, namapengusul FROM data_dewan WHERE tahun_anggaran=2022 ORDER BY namapengusul", ARRAY_A);
$update_at = $wpdb->get_var("SELECT MAX(update_at) FROM `data_usulan` WHERE id_reses IS NOT null AND tahun_anggaran = 2022");
?>
<div class="no-print">
<form method="post" name="pilihan-anggota" action="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
    <select name="anggota">
	<?php 
		echo '<option value="">Pilih Anggota DPRD</option>';
		foreach ($angg as $barisdprd => $baris_angg) {
			echo '<option value="'. $baris_angg['iduser'] .'">' . $baris_angg['namapengusul'] . '</option>';
		}
	?>
    </select>
	<select name="status">
		<option value=''>Pilih Status Usulan</option>
		<option value='8'>Usulan Tidak Diajukan</option>
		<option value='1'>Semua Usulan Masuk</option>
		<option value='2'>Tidak/Belum Divalidasi Sekretariat DPRD</option>
		<option value='3'>Ditolak Sekretariat DPRD</option>
		<option value='4'>Diteruskan Ke Mitra Bappeda</option>
		<option value='5'>Tidak/Belum Diverifikasi Mitra Bappeda</option>
		<option value='6'>Ditolak Mitra Bappeda</option>
		<option value='7'>Diteruskan Ke SKPD</option>
		<option value='9'>Tidak/Belum Diverifikasi Forum SKPD</option>
		<option value='10'>Ditolak di Forum SKPD</option>
		<option value='11'>Diteruskan Ke Musrenbang Kabupaten</option>
	</select>
    <input type="submit" value="GO"/>
</form>
</div>
<?php
$tampilrekap=true;
if (isset($_POST['anggota']) && isset($_POST['status'])){
	if (($_POST['anggota'] !== '') && ($_POST['status']) !== ''){ 
		$tampilrekap=false;
		$anggota = $_POST['anggota'];
		$status = $_POST['status'];
		$nama_anggota = $wpdb->get_var("SELECT namapengusul FROM data_dewan WHERE tahun_anggaran=2022 AND iduser=".$anggota);
		$update_at = $wpdb->get_var("SELECT MAX(update_at) FROM `data_usulan` WHERE id_reses IS NOT null AND tahun_anggaran = 2022 AND created_user=".$anggota);
		switch ($status) {
			case '1':
				$title = "Rekapitulasi Seluruh Usulan Anggora DPRD ".$nama_anggota."</br>PER ".$update_at ;
				$qstatus = '';
				break;
			case '2':
				$title = "Rekapitulasi Usulan Anggora DPRD ".$nama_anggota." dengan Status Tidak/Belum Divalidasi Sekretariat DPRD</br>PER ".$update_at;
				$qstatus = " AND status_usul_teks = 'Validasi Sekretariat Dewan'";
				break;
			case '3':
				$title = "Rekapitulasi Usulan Anggora DPRD ".$nama_anggota." dengan Status Ditolak Sekretariat DPRD</br>PER ".$update_at;
				$qstatus = " AND status_usul_teks = 'Validasi Sekretariat Dewan||Ditolak'";
				break;
			case '4':
				$title = "Rekapitulasi Usulan Anggora DPRD ".$nama_anggota." dengan Status Diteruskan ke Mitra Bappeda</br>PER ".$update_at;
				$qstatus = " AND status_usul_teks is not null AND status_usul_teks != 'Validasi Sekretariat Dewan' AND status_usul_teks != 'Validasi Sekretariat Dewan||Ditolak'";
				break;
			case '5':
				$title = "Rekapitulasi Usulan Anggora DPRD ".$nama_anggota." dengan Status Tidak/Belum Diverifikasi Mitra Bappeda</br>PER ".$update_at;
				$qstatus = " AND status_usul_teks = 'Validasi Mitra Bappeda'";
				break;
			case '6':
				$title = "Rekapitulasi Usulan Anggora DPRD ".$nama_anggota." dengan Status Ditolak oleh Mitra Bappeda</br>PER ".$update_at;
				$qstatus = " AND status_usul_teks = 'Validasi Mitra Bappeda||Ditolak'";
				break;
			case '7':
				$title = "Rekapitulasi Usulan Anggora DPRD ".$nama_anggota." dengan Status Diteruskan ke Forum SKPD</br>PER ".$update_at;
				$qstatus = " AND status_usul_teks is not null AND status_usul_teks != 'Validasi Sekretariat Dewan' AND status_usul_teks != 'Validasi Sekretariat Dewan||Ditolak' AND status_usul_teks != 'Validasi Mitra Bappeda' AND status_usul_teks != 'Validasi Mitra Bappeda||Ditolak'";
				break;
			case '8':
				$title = "Rekapitulasi Usulan Anggora DPRD ".$nama_anggota." dengan Status Tidak Diajukan</br>PER ".$update_at;
				$qstatus = " AND status_usul_teks is null";
				break;
			case '9':
				$title = "Rekapitulasi Usulan Anggora DPRD ".$nama_anggota." dengan Status Tidak/Belum Diverifikasi Forum SKPD</br>PER ".$update_at;
				$qstatus = " AND status_usul_teks = 'Diteruskan ke Forum SKPD'";
				break;
			case '10':
				$title = "Rekapitulasi Usulan Anggora DPRD ".$nama_anggota." dengan Status Ditolak Forum SKPD</br>PER ".$update_at;
				$qstatus = " AND status_usul_teks = 'Diteruskan ke Forum SKPD||Ditolak'";
				break;
			case '11':
				$title = "Rekapitulasi Usulan Anggora DPRD ".$nama_anggota." dengan Status Diteruskan ke Musrenbang Kabupaten</br>PER ".$update_at;
				$qstatus = " AND status_usul_teks = 'Diteruskan ke Musrenbang Provinsi/Kabupaten/Kota'";
				break;
			default: 
				$tampilrekap=true;
		}
		if (!$tampilrekap) {
			$tbody = "
			<tr>
				<table width=\"100%\" style=\"padding: 0px;\">
					<th class=\"atas kanan bawah kiri text_tengah\" colspan=\"5\">".$title."</th>
				</table>
			</tr>
			<tr>
				<td class=\"atas kanan bawah kiri\">
					<table width=\"100%\" style=\"padding: 0px;\">        
					<THEAD>
						<tr>
							<th class=\"atas kanan bawah kiri text_tengah\" style=\"width: 5%;\">NO</th>
							<th class=\"atas kanan bawah kiri text_tengah\" style=\"width: 20%;\">KAMUS USULAN</th>
							<th class=\"atas kanan bawah kiri text_tengah\" style=\"width: 30%;\">URAIAN PERMASALAHAN DAN USULAN</th>
							<th class=\"atas kanan bawah kiri text_tengah\" style=\"width: 30%;\">LOKASI / ALAMAT</th>
							<th class=\"atas kanan bawah kiri text_tengah\" style=\"width: 15%;\">TANGGAL USUL</th>
						</tr>
					</THEAD>";
				$i=0;
				$list_usulan = $wpdb->get_results("SELECT gagasan, masalah, alamat_teks, created_date FROM `data_usulan` WHERE created_user = '".$anggota."' AND tahun_anggaran = 2022 AND active = 1 AND `id_reses` IS NOT NULL ".$qstatus." ORDER BY `gagasan` ASC", ARRAY_A);
				foreach ($list_usulan as $usulan => $detail_usulan) {
					$i++;
					$tbody .= "
					<tr>
						<td class=\"atas kanan bawah kiri text_tengah text_atas\">".$i."</td>
						<td class=\"atas kanan bawah kiri text_kiri text_atas\">".$detail_usulan['gagasan']."</td>
						<td class=\"atas kanan bawah kiri text_kiri text_atas\">".$detail_usulan['masalah']."</td>
						<td class=\"atas kanan bawah kiri text_kiri text_atas\">".$detail_usulan['alamat_teks']."</td>
						<td class=\"atas kanan bawah kiri text_tengah text_atas\">".$detail_usulan['created_date']."</td>
					</tr>";
				}
			$tbody .= "
					</table>
				</td>
			</tr>
			";
		}
	}
}
if ($tampilrekap) {
	$rekap = $wpdb->get_results("
	select 
		a.iduser AS iduser,
		a.`namapengusul` AS `nama_user`,
		b.`jml` AS `jml`, 
		c.`jml` AS `jmldisetwan`, 
		d.`jml` AS `jmldimitra`, 
		e.`jml` AS `jmldiforum`, 
		f.`jml` AS `jmlditolaksetwan`, 
		g.`jml` AS `jmlditolakmitra`, 
		h.`jml` AS `jmlnostatus`, 
		i.`jml` AS `jmlditolakforum`
	from `data_dewan` a 
	LEFT JOIN
	(select `created_user` AS `created_user`,
		count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_reses` IS NOT NULL) and (status_usul_teks is not null)) 
	group by `created_user`) b 
	ON a.iduser = b.created_user 
	LEFT JOIN
	(select `created_user` AS `created_user`,
		count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_reses` IS NOT NULL) and (status_usul_teks='Validasi Sekretariat Dewan')) 
	group by `created_user`) c 
	ON a.iduser = c.created_user
	LEFT JOIN
	(select `created_user` AS `created_user`,
		count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_reses` IS NOT NULL) and (status_usul_teks is not null) and (status_usul_teks='Validasi Mitra Bappeda')) 
	group by `created_user`) d 
	ON a.iduser = d.created_user
	LEFT JOIN
	(select `created_user` AS `created_user`,
		count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_reses` IS NOT NULL) and (status_usul_teks is not null) and (`status_usul_teks` = 'Diteruskan ke Forum SKPD')) 
	group by `created_user`) e 
	ON a.iduser = e.created_user
	LEFT JOIN
	(select `created_user` AS `created_user`,
		count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_reses` IS NOT NULL) and (status_usul_teks='Validasi Sekretariat Dewan||Ditolak')) 
	group by `created_user`) f 
	ON a.iduser = f.created_user
	LEFT JOIN
	(select `created_user` AS `created_user`,
		count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_reses` IS NOT NULL) and (status_usul_teks='Validasi Mitra Bappeda||Ditolak')) 
	group by `created_user`) g 
	ON a.iduser = g.created_user
	LEFT JOIN
	(select `created_user` AS `created_user`,
		count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_reses` IS NOT NULL) and (status_usul_teks is null)) 
	group by `created_user`) h 
	ON a.iduser = h.created_user
	LEFT JOIN
	(select `created_user` AS `created_user`,
		count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_reses` IS NOT NULL) and (status_usul_teks='Diteruskan ke Forum SKPD||Ditolak')) 
	group by `created_user`) i 
	ON a.iduser = i.created_user

	WHERE a.tahun_anggaran=2022 
	ORDER BY a.`namapengusul`"
, ARRAY_A);

$tbody = "
	<tr>
		<th class=\"atas kanan bawah kiri text_tengah\">REKAPITULASI USULAN DPRD</br>PER ".$update_at."</td>
	</tr>
	<tr>
		<td>
<table width=\"100%\">        
<THEAD>
	<tr>
		<th class=\"text_tengah kiri atas kanan bawah\" rowspan=\"3\">NO</td>
		<th class=\"text_tengah kiri atas kanan bawah\" rowspan=\"3\">NAMA ANGGOTA DPRD</td>
		<th class=\"text_tengah kiri atas kanan bawah\" colspan=\"11\">JUMLAH USULAN</td>
		<tr>
							<th class=\"text_tengah kiri atas kanan bawah\" rowspan=\"2\">USULAN TIDAK DIAJUKAN</td>
							<th class=\"text_tengah kiri atas kanan bawah\" rowspan=\"2\">USULAN MASUK / DIAJUKAN</td>
							<th class=\"text_tengah kiri atas kanan bawah\" colspan=\"3\">PROSES DI SEKRETARIAT DPRD</td>
							<th class=\"text_tengah kiri atas kanan bawah\" colspan=\"3\">PROSES DI MITRA BAPPEDA</td>
							<th class=\"text_tengah kiri atas kanan bawah\" colspan=\"3\">PROSES DI FORUM SKPD</td>
							<tr>
								<th class=\"text_tengah kiri atas kanan bawah\">TIDAK/BELUM DIVALIDASI</td>
								<th class=\"text_tengah kiri atas kanan bawah\">DITOLAK</td>
								<th class=\"text_tengah kiri atas kanan bawah\">DITERUSKAN KE MITRA BAPPEDA</td>
								<th class=\"text_tengah kiri atas kanan bawah\">TIDAK/BELUM DIVERIFIKASI</td>
								<th class=\"text_tengah kiri atas kanan bawah\">DITOLAK</td>
								<th class=\"text_tengah kiri atas kanan bawah\">DITERUSKAN KE SKPD</td>
								<th class=\"text_tengah kiri atas kanan bawah\">TIDAK/BELUM DIVERIFIKASI</td>
								<th class=\"text_tengah kiri atas kanan bawah\">DITOLAK</td>
								<th class=\"text_tengah kiri atas kanan bawah\">DITERUSKAN KE MUSRENBANG KABUPATEN</td>
							</tr>
		</tr>
	</tr>
</THEAD>";
$i=0;
$total1=0;
$total2=0;
$total3=0;
$total4=0;
$total5=0;
$total6=0;
$total7=0;
$total8=0;
$total9=0;
$total10=0;
$total11=0;
foreach ($rekap as $baris => $baris_rekap) {
	$i++;
	$total1 += $baris_rekap['jml'];
	$total2 += $baris_rekap['jmldisetwan'];
	$total3 += $baris_rekap['jmlditolaksetwan'];
	$jmlvalid = $baris_rekap['jml']-$baris_rekap['jmldisetwan']-$baris_rekap['jmlditolaksetwan'];
	$total4 += $jmlvalid;
	$total5 += $baris_rekap['jmldimitra'];
	$total6 += $baris_rekap['jmlditolakmitra'];
	$jmlkeforum = $jmlvalid - $baris_rekap['jmldimitra'] - $baris_rekap['jmlditolakmitra'];
	$total7 += $jmlkeforum;
	$total8 += $baris_rekap['jmlnostatus'];
	$total9 += $baris_rekap['jmldiforum'];
	$total10 += $baris_rekap['jmlditolakforum'];
	$jmlkemusren = $jmlkeforum - $baris_rekap['jmldiforum'] - $baris_rekap['jmlditolakforum'];
	$total11 += $jmlkemusren;
	$tbody .= "
	<tr>
		<td class=\"text_tengah kiri atas kanan bawah\">".$i."</td>
		<td class=\"text_kiri kiri atas kanan bawah\">".$baris_rekap['nama_user']."</td>
		<td class=\"text_tengah kiri atas kanan bawah\">".$baris_rekap['jmlnostatus']."</td>
		<td class=\"text_tengah kiri atas kanan bawah\">".$baris_rekap['jml']."</td>
		<td class=\"text_tengah kiri atas kanan bawah\">".$baris_rekap['jmldisetwan']."</td>
		<td class=\"text_tengah kiri atas kanan bawah\">".$baris_rekap['jmlditolaksetwan']."</td>
		<td class=\"text_tengah kiri atas kanan bawah\">".$jmlvalid."</td>
		<td class=\"text_tengah kiri atas kanan bawah\">".$baris_rekap['jmldimitra']."</td>
		<td class=\"text_tengah kiri atas kanan bawah\">".$baris_rekap['jmlditolakmitra']."</td>
		<td class=\"text_tengah kiri atas kanan bawah\">".$jmlkeforum."</td>
		<td class=\"text_tengah kiri atas kanan bawah\">".$baris_rekap['jmldiforum']."</td>
		<td class=\"text_tengah kiri atas kanan bawah\">".$baris_rekap['jmlditolakforum']."</td>
		<td class=\"text_tengah kiri atas kanan bawah\">".$jmlkemusren."</td>
		</tr>";
}
$tbody .= "
	<tr>
		<td class=\"text_kiri kiri atas kanan bawah\"></td>
		<td class=\"text_kiri kiri atas kanan bawah\"><b>JUMLAH</b></td>
		<td class=\"text_tengah kiri atas kanan bawah\"><b>".$total8."</b></td>
		<td class=\"text_tengah kiri atas kanan bawah\"><b>".$total1."</b></td>
		<td class=\"text_tengah kiri atas kanan bawah\"><b>".$total2."</b></td>
		<td class=\"text_tengah kiri atas kanan bawah\"><b>".$total3."</b></td>
		<td class=\"text_tengah kiri atas kanan bawah\"><b>".$total4."</b></td>
		<td class=\"text_tengah kiri atas kanan bawah\"><b>".$total5."</b></td>
		<td class=\"text_tengah kiri atas kanan bawah\"><b>".$total6."</b></td>
		<td class=\"text_tengah kiri atas kanan bawah\"><b>".$total7."</b></td>
		<td class=\"text_tengah kiri atas kanan bawah\"><b>".$total9."</b></td>
		<td class=\"text_tengah kiri atas kanan bawah\"><b>".$total10."</b></td>
		<td class=\"text_tengah kiri atas kanan bawah\"><b>".$total11."</b></td>
		</tr>
</table>
</td>
</tr>";
}
?>

<style type="text/css">
	.cellpadding_1 td, .cellpadding_1 th {
		padding: 1px;
	}
	.cellpadding_2 td, .cellpadding_2 th {
		padding: 2px;
	}
	.cellpadding_3 td, .cellpadding_3 th {
		padding: 3px;
	}
	.cellpadding_4 td, .cellpadding_4 th {
		padding: 4px;
	}
	.cellpadding_5 td, .cellpadding_5 th {
		padding: 5px;
	}
	.no_padding>td {
		padding: 0;
	}
	td, th {
		text-align: inherit;
		padding: inherit;
		display: table-cell;
    	vertical-align: inherit;
	}
	table, td, th {
		border: 0; 
	}
	body {
		display: block;
		margin: 8px;
	    font-family: 'Open Sans',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
	    padding: 0;
	    font-size: 13px;
	}
	table {
	    display: table;
	    border-collapse: separate;
	    margin: 0;
	}
    .cetak{
        font-family:'Open Sans',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
        padding:0;
        margin:0;
        font-size:13px;
    }
    .bawah{
        border-bottom:1px solid #000;        
    }
    .kiri{
        border-left:1px solid #000;        
    }
    .kanan{        
        border-right:1px solid #000;
    }
    .atas{        
        border-top:1px solid #000;
    }
    .text_tengah{
        text-align: center;
    }
    .text_kiri{
        text-align: left;
    }
    .text_kanan{
        text-align: right;
    }
	.text_atas{
		vertical-align: top;
	}
    .text_blok{
        font-weight: bold;
    }        
    .text_15{
        font-size: 15px;
    }
    .text_20{
        font-size: 20px;
    }
    .footer{
        display:none;
    }
	@media print{
		.no-print, .no-print * {
			display: none !important;
		}
	}
</style>
<div class="cetak">
	<table width="100%" class="cellpadding_1" style="border-spacing: 0px;">
<?php echo $tbody; ?>
	</table>
</div>    

