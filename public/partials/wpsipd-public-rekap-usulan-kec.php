<?php
global $wpdb;

$rekap = $wpdb->get_results("
	select 
		a.`camat_teks` AS `camatteks`,
		b.`jml` AS `jml`, 
		c.`jml` AS `jmldimitra`, 
		d.`jml` AS `jmldikec`, 
		e.`jml` AS `jmlforum`, 
		f.`jml` AS `jmlditolakmitra`, 
		g.`jml` AS `jmlditolakkec`, 
		h.`jml` AS `jmltapd`, 
		i.`jml` AS `jmlditolakforum`  
	from `data_desa_kelurahan` a 
	LEFT JOIN
	(select `camatteks` AS `camatteks`,
	count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_usulan` IS NOT NULL) and (status_usul_teks!='')) 
	group by `camatteks`) b 
	ON a.camat_teks = b.camatteks
	LEFT JOIN
	(select `camatteks` AS `camatteks`,
	count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_usulan` IS NOT NULL) and (status_usul_teks='Validasi Mitra Bappeda')) 
	group by `camatteks`) c 
	ON a.camat_teks = c.camatteks
	LEFT JOIN
	(select `camatteks` AS `camatteks`,
	count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_usulan` IS NOT NULL) and (status_usul_teks!='') and (status_usul_teks='Diteruskan ke Musrenbang Kecamatan')) 
	group by `camatteks`) d 
	ON a.camat_teks = d.camatteks 
	LEFT JOIN
	(select `camatteks` AS `camatteks`,
	count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_usulan` IS NOT NULL) and (status_usul_teks!='') and (`status_usul_teks` = 'Diteruskan ke Forum SKPD')) 
	group by `camatteks`) e 
	ON a.camat_teks = e.camatteks 
	LEFT JOIN
	(select `camatteks` AS `camatteks`,
	count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_usulan` IS NOT NULL) and (status_usul_teks='Validasi Mitra Bappeda||Ditolak')) 
	group by `camatteks`) f 
	ON a.camat_teks = f.camatteks 
	LEFT JOIN
	(select `camatteks` AS `camatteks`,
	count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_usulan` IS NOT NULL) and (status_usul_teks='Diteruskan ke Musrenbang Kecamatan||Ditolak')) 
	group by `camatteks`) g 
	ON a.camat_teks = g.camatteks
	LEFT JOIN
	(select `camatteks` AS `camatteks`,
	count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_usulan` IS NOT NULL) and (status_usul_teks='Diteruskan ke Musrenbang Provinsi/Kabupaten/Kota')) 
	group by `camatteks`) h 
	ON a.camat_teks = h.camatteks
	LEFT JOIN
	(select `camatteks` AS `camatteks`,
	count(`id`) AS `jml` 
	from `data_usulan` 
	where ((`tahun_anggaran` = 2022) and (`active` = 1) and (`id_usulan` IS NOT NULL) and (status_usul_teks='Diteruskan ke Forum SKPD||Ditolak')) 
	group by `camatteks`) i 
	ON a.camat_teks = i.camatteks
	WHERE a.tahun_anggaran=2022 group BY a.`camat_teks` 
	ORDER BY a.`camat_teks`"
, ARRAY_A);

$tbody = "
	<tr>
		<th class=\"atas kanan bawah kiri text_tengah\">REKAPITULASI USULAN</td>
	</tr>
	<tr>
		<td>
			<table width=\"100%\">        
				<THEAD>
					<tr>
						<th class=\"text_tengah kiri atas kanan bawah\" rowspan=\"3\">NO</td>
						<th class=\"text_tengah kiri atas kanan bawah\" rowspan=\"3\">KECAMATAN</td>
						<th class=\"text_tengah kiri atas kanan bawah\" colspan=\"10\">JUMLAH USULAN</td>
						<tr>
							<th class=\"text_tengah kiri atas kanan bawah\" rowspan=\"2\">USULAN MASUK</td>
							<th class=\"text_tengah kiri atas kanan bawah\" colspan=\"3\">PROSES DI MITRA BAPPEDA</td>
							<th class=\"text_tengah kiri atas kanan bawah\" colspan=\"3\">PROSES DI KECAMATAN</td>
							<th class=\"text_tengah kiri atas kanan bawah\" colspan=\"3\">PROSES DI FORUM SKPD</td>
							<tr>
								<th class=\"text_tengah kiri atas kanan bawah\">TIDAK/BELUM DIVALIDASI</td>
								<th class=\"text_tengah kiri atas kanan bawah\">DITOLAK</td>
								<th class=\"text_tengah kiri atas kanan bawah\">DITERUSKAN KE MUSRENBANG KECAMATAN</td>
								<th class=\"text_tengah kiri atas kanan bawah\">TIDAK/BELUM DIVERIFIKASI</td>
								<th class=\"text_tengah kiri atas kanan bawah\">DITOLAK</td>
								<th class=\"text_tengah kiri atas kanan bawah\">DITERUSKAN KE FORUM SKPD</td>
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
	$tbody .= "
				<tr>
					<td class=\"text_tengah kiri atas kanan bawah\">".$i."</td>
					<td class=\"text_kiri kiri atas kanan bawah\">".$baris_rekap['camatteks']."</td>
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
				</tr>";
}
	$tbody .= "
				<tr>
					<td class=\"text_kiri kiri atas kanan bawah\"></td>
					<td class=\"text_kiri kiri atas kanan bawah\"><b>JUMLAH</b></td>
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
				</tr>
			</table>
		</td>
	</tr>";
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

</style>
<div class="cetak">
	<table width="100%" class="cellpadding_1" style="border-spacing: 2px;">
<?php echo $tbody; ?>
	</table>
</div>    
