<?php 
global $wpdb; 
$kec = $wpdb->get_results("SELECT camat_teks, count(id) FROM data_desa_kelurahan WHERE tahun_anggaran=2022 GROUP BY camat_teks ORDER BY camat_teks", ARRAY_A);
$update_at = $wpdb->get_var("SELECT MAX(update_at) FROM `data_usulan` WHERE id_usulan IS NOT null AND tahun_anggaran = 2022 AND active = 1");
?>
<div class="no-print">
<form method="post" name="pilihan-kec" action="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
    <select name="kec">
	<?php 
		echo '<option value="">Pilih Kecamatan</option>';
		foreach ($kec as $bariskec => $baris_kec) {
			echo '<option>' . $baris_kec['camat_teks'] . '</option>';
		}
	?>
    </select>
	<select name="status">
		<option value=''>Pilih Status Usulan</option>
		<option value='1'>Semua Usulan</option>
		<option value='2'>Tidak/Belum Divalidasi Mitra Bappeda</option>
		<option value='3'>Ditolak Mitra Bappeda</option>
		<option value='4'>Diteruskan ke Musrenbang Kecamatan</option>
		<option value='5'>Tidak/Belum Diverifikasi Kecamatan</option>
		<option value='6'>Ditolak Kecamatan</option>
		<option value='7'>Diteruskan ke Forum SKPD</option>
		<option value='8'>Tidak/Belum Diverifikasi Forum SKPD</option>
		<option value='9'>Ditolak di Forum SKPD</option>
		<option value='10'>Diteruskan ke Musrenbang Provinsi/Kabupaten/Kota</option>
	</select>
    <input type="submit" value="GO"/>
</form>
</div>
<?php
$tampilrekap=true;
if (isset($_POST['kec']) && isset($_POST['status'])){
	if (($_POST['kec'] !== '') && ($_POST['status']) !== ''){ 
		$tampilrekap=false;
		$kecamatan = $_POST['kec'];
		$status = $_POST['status'];
		switch ($status) {
			case '1':
				$title = "Rekapitulasi Seluruh Usulan Desa/Kelurahan di Kecamatan ".$kecamatan."<br/>Per ".$update_at;
				$qstatus = '';
				break;
			case '2':
				$title = "Rekapitulasi Usulan Desa/Kelurahan di Kecamatan ".$kecamatan." dengan Status Tidak/Belum Divalidasi Mitra Bappeda"."<br/>Per ".$update_at;
				$qstatus = " AND status_usul_teks = 'Validasi Mitra Bappeda'";
				break;
			case '3':
				$title = "Rekapitulasi Usulan Desa/Kelurahan di Kecamatan ".$kecamatan." dengan Status Ditolak Mitra Bappeda"."<br/>Per ".$update_at;
				$qstatus = " AND status_usul_teks = 'Validasi Mitra Bappeda||Ditolak'";
				$qket = ', tolak_teks AS ket';
				break;
			case '4':
				$title = "Rekapitulasi Usulan Desa/Kelurahan di Kecamatan ".$kecamatan." dengan Status Diteruskan ke Musrenbang Kecamatan"."<br/>Per ".$update_at;
				$qstatus = " AND status_usul_teks != '' AND status_usul_teks != 'Validasi Mitra Bappeda' AND status_usul_teks != 'Validasi Mitra Bappeda||Ditolak'";
				$qket = ', rekom_teks_mitra AS ket';
				$qvol = ', rekom_vol_mitra AS volume';
				$qsatuan = ', satuan';
				$qanggaran = ', rekom_pagu_mitra AS anggaran';
				break;
			case '5':
				$title = "Rekapitulasi Usulan Desa/Kelurahan di Kecamatan ".$kecamatan." dengan Status Tidak/Belum Diverifikasi Kecamatan"."<br/>Per ".$update_at;
				$qstatus = " AND status_usul_teks = 'Diteruskan ke Musrenbang Kecamatan'";
				break;
			case '6':
				$title = "Rekapitulasi Usulan Desa/Kelurahan di Kecamatan ".$kecamatan." dengan Status Ditolak oleh Kecamatan"."<br/>Per ".$update_at;
				$qstatus = " AND status_usul_teks = 'Diteruskan ke Musrenbang Kecamatan||Ditolak'";
				$qket = ', tolak_teks AS ket';
				break;
			case '7':
				$title = "Rekapitulasi Usulan Desa/Kelurahan di Kecamatan ".$kecamatan." dengan Status Diteruskan ke Forum SKPD"."<br/>Per ".$update_at;
				$qstatus = " AND status_usul_teks != '' AND status_usul_teks != 'Validasi Mitra Bappeda' AND status_usul_teks != 'Validasi Mitra Bappeda||Ditolak' AND status_usul_teks != 'Diteruskan ke Musrenbang Kecamatan' AND status_usul_teks != 'Diteruskan ke Musrenbang Kecamatan||Ditolak'";
				$qket = ', rekom_teks_camat AS ket';
				$qvol = ', rekom_vol_camat AS volume';
				$qsatuan = ', satuan';
				$qanggaran = ', rekom_pagu_camat AS anggaran';
				break;
			case '8':
				$title = "Rekapitulasi Usulan Desa/Kelurahan di Kecamatan ".$kecamatan." dengan Status Tidak/Belum Verifikasi Forum SKPD"."<br/>Per ".$update_at;
				$qstatus = " AND status_usul_teks = 'Diteruskan ke Forum SKPD'";
				break;
			case '9':
				$title = "Rekapitulasi Usulan Desa/Kelurahan di Kecamatan ".$kecamatan." dengan Status Ditolak di Forum SKPD"."<br/>Per ".$update_at;
				$qstatus = " AND status_usul_teks = 'Diteruskan ke Forum SKPD||Ditolak'";
				$qket = ', tolak_teks AS ket';
				break;
			case '10':
				$title = "Rekapitulasi Usulan Desa/Kelurahan di Kecamatan ".$kecamatan." dengan Status Diteruskan ke Musrenbang Provinsi/Kabupaten/Kota"."<br/>Per ".$update_at;
				$qket = ', rekom_teks_skpd AS ket';
				$qvol = ', rekom_vol_skpd AS volume';
				$qsatuan = ', satuan';
				$qanggaran = ', rekom_pagu_skpd AS anggaran';
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
							<th class=\"atas kanan bawah kiri text_tengah\" style=\"width: 15%;\">REKOMENDASI VOLUME</th>
							<th class=\"atas kanan bawah kiri text_tengah\" style=\"width: 15%;\">SATUAN</th>
							<th class=\"atas kanan bawah kiri text_tengah\" style=\"width: 15%;\">PAGU</th>
							<th class=\"atas kanan bawah kiri text_tengah\" style=\"width: 15%;\">KETERANGAN</th>
						</tr>
					</THEAD>";
			$deskel = $wpdb->get_results("
				select camat_teks, lurah_teks from data_desa_kelurahan where camat_teks = '".$kecamatan."' and tahun_anggaran = 2022
			"
			, ARRAY_A);
			$totalpagu = 0;
			foreach ($deskel as $bariskel => $baris_kel) {
				$tbody .= "
				<tr>
					<td class=\"atas kanan bawah kiri\"></td>
					<td class=\"atas kanan bawah kiri text_tengah\" colspan=\"8\"><b>".$baris_kel['lurah_teks']."</b></td>
				</tr>";
				$i=0;
				$list_usulan = $wpdb->get_results("SELECT gagasan, masalah, alamat_teks, createddate ".$qvol.$qsatuan.$qanggaran.$qket." FROM `data_usulan` WHERE camatteks = '".$kecamatan."' AND lurahteks = '".$baris_kel['lurah_teks']."' AND tahun_anggaran = 2022 AND active = 1 AND `id_usulan` IS NOT NULL ".$qstatus." ORDER BY `createddate` DESC", ARRAY_A);
				foreach ($list_usulan as $usulan => $detail_usulan) {
					$i++;
					$totalpagu += $detail_usulan['anggaran'];
					$tbody .= "
					<tr>
						<td class=\"atas kanan bawah kiri text_tengah text_atas\">".$i."</td>
						<td class=\"atas kanan bawah kiri text_kiri text_atas\">".$detail_usulan['gagasan']."</td>
						<td class=\"atas kanan bawah kiri text_kiri text_atas\">".$detail_usulan['masalah']."</td>
						<td class=\"atas kanan bawah kiri text_kiri text_atas\">".$detail_usulan['alamat_teks']."</td>
						<td class=\"atas kanan bawah kiri text_tengah text_atas\">".$detail_usulan['createddate']."</td>
						<td class=\"atas kanan bawah kiri text_tengah text_atas\">".$detail_usulan['volume']."</td>
						<td class=\"atas kanan bawah kiri text_tengah text_atas\">".$detail_usulan['satuan']."</td>
						<td class=\"atas kanan bawah kiri text_kanan text_atas\">".number_format($detail_usulan['anggaran'],2,",",".")."</td>
						<td class=\"atas kanan bawah kiri text_tengah text_atas\">".$detail_usulan['ket']."</td>
					</tr>";
				}
			}
			$tbody .= "
					<tr>
						<td class=\"atas bawah kiri text_tengah text_atas\"></td>
						<td class=\"atas bawah text_tengah text_atas\" colspan=\"6\"><b>JUMLAH</b></td>
						<td class=\"atas bawah text_kanan text_atas\"><b>".number_format($totalpagu,2,",",".")."</b></td>
						<td class=\"atas kanan bawah text_tengah text_atas\"></td>
					</tr>
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
		a.`camat_teks` AS `camatteks`,
		a.`lurah_teks` AS `lurahteks`,
		a.`nama` AS `namalurah`,
		b.`jml` AS `jml`, 
		c.`jml` AS `jmldimitra`, 
		d.`jml` AS `jmldikec`, 
		e.`jml` AS `jmlforum`, 
		f.`jml` AS `jmlditolakmitra`, 
		g.`jml` AS `jmlditolakkec`, 
		h.`jml` AS `jmltapd`, h.`totalpagu` AS `totalpagu`,
		i.`jml` AS `jmlditolakforum` 
	from `data_desa_kelurahan` a 
	LEFT JOIN
	(select `camatteks` AS `camatteks`,
		`lurahteks` AS `lurahteks`,
		count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_usulan` IS NOT NULL) and (status_usul_teks!='')) 
	group by `camatteks`,`lurahteks`) b 
	ON a.camat_teks = b.camatteks AND a.lurah_teks = b.lurahteks 
	LEFT JOIN
	(select `camatteks` AS `camatteks`,
		`lurahteks` AS `lurahteks`,
		count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_usulan` IS NOT NULL) and (status_usul_teks='Validasi Mitra Bappeda')) 
	group by `camatteks`,`lurahteks`) c 
	ON a.camat_teks = c.camatteks AND a.lurah_teks = c.lurahteks 
	LEFT JOIN
	(select `camatteks` AS `camatteks`,
		`lurahteks` AS `lurahteks`,
		count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_usulan` IS NOT NULL) and (status_usul_teks!='') and (status_usul_teks='Diteruskan ke Musrenbang Kecamatan')) 
	group by `camatteks`,`lurahteks`) d 
	ON a.camat_teks = d.camatteks AND a.lurah_teks = d.lurahteks 
	LEFT JOIN
	(select `camatteks` AS `camatteks`,
		`lurahteks` AS `lurahteks`,
		count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_usulan` IS NOT NULL) and (status_usul_teks!='') and (`status_usul_teks` = 'Diteruskan ke Forum SKPD')) 
	group by `camatteks`,`lurahteks`) e 
	ON a.camat_teks = e.camatteks AND a.lurah_teks = e.lurahteks 
	LEFT JOIN
	(select `camatteks` AS `camatteks`,
		`lurahteks` AS `lurahteks`,
		count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_usulan` IS NOT NULL) and (status_usul_teks='Validasi Mitra Bappeda||Ditolak')) 
	group by `camatteks`,`lurahteks`) f 
	ON a.camat_teks = f.camatteks AND a.lurah_teks = f.lurahteks 
	LEFT JOIN
	(select `camatteks` AS `camatteks`,
		`lurahteks` AS `lurahteks`,
		count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_usulan` IS NOT NULL) and (status_usul_teks='Diteruskan ke Musrenbang Kecamatan||Ditolak')) 
	group by `camatteks`,`lurahteks`) g 
	ON a.camat_teks = g.camatteks AND a.lurah_teks = g.lurahteks
	LEFT JOIN
	(select `camatteks` AS `camatteks`,
		`lurahteks` AS `lurahteks`, sum(`rekom_pagu_skpd`) AS `totalpagu`,
		count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_usulan` IS NOT NULL) and (status_usul_teks='Diteruskan ke Musrenbang Provinsi/Kabupaten/Kota')) 
	group by `camatteks`,`lurahteks`) h 
	ON a.camat_teks = h.camatteks AND a.lurah_teks = h.lurahteks
	LEFT JOIN
	(select `camatteks` AS `camatteks`,
		`lurahteks` AS `lurahteks`,
		count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_usulan` IS NOT NULL) and (status_usul_teks='Diteruskan ke Forum SKPD||Ditolak')) 
	group by `camatteks`,`lurahteks`) i 
	ON a.camat_teks = i.camatteks AND a.lurah_teks = i.lurahteks
	WHERE a.tahun_anggaran=2022 
	ORDER BY a.`camat_teks`, a.`lurah_teks`"
, ARRAY_A);
// a: data desa 
// b: semua usulan 
// c: di mitra bappeda (blm/tidak validasi) 
// d: di kecamatan (tidak/blm verifikasi) 
// e: di forum skpd (tidak/blm verifikasi) 
// f: ditolak mitra bappeda 
// g: ditolak kecamatan 
// h: di tapd (tidak/blm verifikasi) 
// i: ditolak forum skpd 
$tbody = "
	<tr><td>
		<table width=\"100%\">
			<th class=\"atas kanan bawah kiri text_tengah\">REKAPITULASI USULAN<br/>PER ".$update_at."</th>
		</table>
	</td></tr>
	<tr>
		<td>
<table width=\"100%\">        
<THEAD>
	<tr>
		<th class=\"text_tengah kiri atas kanan bawah\" rowspan=\"3\">NO</th>
		<th class=\"text_tengah kiri atas kanan bawah\" rowspan=\"3\">KECAMATAN</th>
		<th class=\"text_tengah kiri atas kanan bawah\" rowspan=\"3\">DESA/KELURAHAN</th>
		<th class=\"text_tengah kiri atas kanan bawah\" rowspan=\"3\">NAMA KEPALA DESA/LURAH</th>
		<th class=\"text_tengah kiri atas kanan bawah\" colspan=\"10\">JUMLAH USULAN</th>
		<th class=\"text_tengah kiri atas kanan bawah\" rowspan=\"3\">TOTAL PAGU DITERUSKAN KE MUSRENBANG KABUPATEN</td>
		<tr>
							<th class=\"text_tengah kiri atas kanan bawah\" rowspan=\"2\">USULAN MASUK</th>
							<th class=\"text_tengah kiri atas kanan bawah\" colspan=\"3\">PROSES DI MITRA BAPPEDA</th>
							<th class=\"text_tengah kiri atas kanan bawah\" colspan=\"3\">PROSES DI KECAMATAN</th>
							<th class=\"text_tengah kiri atas kanan bawah\" colspan=\"3\">PROSES DI FORUM SKPD</th>
							<tr>
								<th class=\"text_tengah kiri atas kanan bawah\">TIDAK/BELUM DIVALIDASI</th>
			<th class=\"text_tengah kiri atas kanan bawah\">DITOLAK</th>
								<th class=\"text_tengah kiri atas kanan bawah\">DITERUSKAN KE MUSRENBANG KECAMATAN</th>
								<th class=\"text_tengah kiri atas kanan bawah\">TIDAK/BELUM DIVERIFIKASI</th>
								<th class=\"text_tengah kiri atas kanan bawah\">DITOLAK</th>
								<th class=\"text_tengah kiri atas kanan bawah\">DITERUSKAN KE FORUM SKPD</th>
								<th class=\"text_tengah kiri atas kanan bawah\">TIDAK/BELUM DIVERIFIKASI</th>
								<th class=\"text_tengah kiri atas kanan bawah\">DITOLAK</th>
								<th class=\"text_tengah kiri atas kanan bawah\">DITERUSKAN KE MUSRENBANG KABUPATEN</th>
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
	$total2 += $baris_rekap['jmldimitra'];
	$total3 += $baris_rekap['jmlditolakmitra'];
	$jmlvalid = $baris_rekap['jml']-$baris_rekap['jmldimitra']-$baris_rekap['jmlditolakmitra'];
	$total4 += $jmlvalid;
	$total5 += $baris_rekap['jmldikec'];
	$total6 += $baris_rekap['jmlditolakkec'];
	$jmlkeforum = $jmlvalid - $baris_rekap['jmldikec'] - $baris_rekap['jmlditolakkec'];
	$total7 += $jmlkeforum;
	$total8 += $baris_rekap['jmlforum'];
	$total9 += $baris_rekap['jmlditolakforum'];
	$total10 += $baris_rekap['jmltapd'];
	$total11 += $baris_rekap['totalpagu'];
	$tbody .= "
	<tr>
		<td class=\"text_tengah kiri atas kanan bawah\">".$i."</td>
		<td class=\"text_kiri kiri atas kanan bawah\">".$baris_rekap['camatteks']."</td>
		<td class=\"text_kiri kiri atas kanan bawah\">".$baris_rekap['lurahteks']."</td>
		<td class=\"text_kiri kiri atas kanan bawah\">".$baris_rekap['namalurah']."</td>
		<td class=\"text_tengah kiri atas kanan bawah\">".$baris_rekap['jml']."</td>
		<td class=\"text_tengah kiri atas kanan bawah\">".$baris_rekap['jmldimitra']."</td>
		<td class=\"text_tengah kiri atas kanan bawah\">".$baris_rekap['jmlditolakmitra']."</td>
		<td class=\"text_tengah kiri atas kanan bawah\">".$jmlvalid."</td>
		<td class=\"text_tengah kiri atas kanan bawah\">".$baris_rekap['jmldikec']."</td>
		<td class=\"text_tengah kiri atas kanan bawah\">".$baris_rekap['jmlditolakkec']."</td>
		<td class=\"text_tengah kiri atas kanan bawah\">".$jmlkeforum."</td>
		<td class=\"text_tengah kiri atas kanan bawah\">".$baris_rekap['jmlforum']."</td>
		<td class=\"text_tengah kiri atas kanan bawah\">".$baris_rekap['jmlditolakforum']."</td>
		<td class=\"text_tengah kiri atas kanan bawah\">".$baris_rekap['jmltapd']."</td>
		<td class=\"text_kanan kiri atas kanan bawah\">".number_format($baris_rekap['totalpagu'],2,",",".")."</td>
		</tr>";
}
$tbody .= "
	<tr>
		<td class=\"text_kiri kiri atas kanan bawah\"></td>
		<td class=\"text_kiri kiri atas kanan bawah\"><b>JUMLAH</b></td>
		<td class=\"text_kiri kiri atas kanan bawah\"></td>
		<td class=\"text_kiri kiri atas kanan bawah\"></td>
		<td class=\"text_tengah kiri atas kanan bawah\"><b>".$total1."</b></td>
		<td class=\"text_tengah kiri atas kanan bawah\"><b>".$total2."</b></td>
		<td class=\"text_tengah kiri atas kanan bawah\"><b>".$total3."</b></td>
		<td class=\"text_tengah kiri atas kanan bawah\"><b>".$total4."</b></td>
		<td class=\"text_tengah kiri atas kanan bawah\"><b>".$total5."</b></td>
		<td class=\"text_tengah kiri atas kanan bawah\"><b>".$total6."</b></td>
		<td class=\"text_tengah kiri atas kanan bawah\"><b>".$total7."</b></td>
		<td class=\"text_tengah kiri atas kanan bawah\"><b>".$total8."</b></td>
		<td class=\"text_tengah kiri atas kanan bawah\"><b>".$total9."</b></td>
		<td class=\"text_tengah kiri atas kanan bawah\"><b>".$total10."</b></td>
		<td class=\"text_kanan kiri atas kanan bawah\"><b>".number_format($total11,2,",",".")."</b></td>
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

