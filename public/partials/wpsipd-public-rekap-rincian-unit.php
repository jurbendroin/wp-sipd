<?php
global $wpdb;

$rekap = $wpdb->get_results("
	SELECT d.kode_skpd, d.nama_skpd, e.batasanpagu, e.nilaipagu, e.nilairincian, SUM(a.rincian) AS total FROM (SELECT * FROM data_rka WHERE tahun_anggaran = 2021) a 
	LEFT JOIN (SELECT * FROM data_sub_keg_bl WHERE tahun_anggaran = 2021) b ON a.kode_sbl = b.kode_sbl 
	LEFT JOIN (SELECT * FROM data_unit WHERE tahun_anggaran = 2021) c ON b.id_sub_skpd = c.id_skpd 
	LEFT JOIN (SELECT * FROM data_unit WHERE tahun_anggaran = 2021) d ON c.id_unit = d.id_skpd
	LEFT JOIN (SELECT * FROM data_unit_pagu WHERE tahun_anggaran = 2021) e ON e.id_skpd = d.id_skpd
	WHERE a.active = 1 GROUP BY d.id_skpd
	ORDER BY `d`.`kode_skpd` ASC"
, ARRAY_A);

$tbody = "
	<tr>
		<th class=\"atas kanan bawah kiri text_tengah\" colspan=\"9\">REKAPITULASI RINCIAN PER UNIT</td>
	</tr>
	<tr>
		<td colspan=\"9\">
<table>        
<THEAD>
	<tr>
		<th width=\"180\" class=\"text_tengah kiri atas kanan bawah\">KODE UNIT</td>
		<th width=\"400\" class=\"text_tengah kiri atas kanan bawah\">NAMA UNIT</td>
		<th width=\"200\" class=\"text_tengah kiri atas kanan bawah\">BATASAN PAGU</td>
		<th width=\"200\" class=\"text_tengah kiri atas kanan bawah\">PAGU VALIDASI</td>
		<th width=\"200\" class=\"text_tengah kiri atas kanan bawah\">NILAI RINCIAN</td>
		<th width=\"200\" class=\"text_tengah kiri atas kanan bawah\">IMPOR RINCIAN</td>
		<th width=\"200\" class=\"text_tengah kiri atas kanan bawah\">KURANG RINCIAN</td>
		<th width=\"200\" class=\"text_tengah kiri atas kanan bawah\">KURANG IMPOR</td>
		<th width=\"200\" class=\"text_tengah kiri atas kanan bawah\">SUDAH VALIDASI</td>
	</tr>
</THEAD>";
$batasanpagu = 0;
$nilaipagu = 0;
$nilairincian = 0;
$total = 0;
foreach ($rekap as $baris => $unit) {
	$batasanpagu += $unit['batasanpagu'];
	$nilaipagu += $unit['nilaipagu'];
	$nilairincian += $unit['nilairincian'];
	$total += $unit['total'];
	$tbody .= "
	<tr>
		<td width=\"180\" class=\"text_tengah kiri atas kanan bawah\">".$unit['kode_skpd']."</td>
		<td width=\"400\" class=\"text_kiri kiri atas kanan bawah\">".$unit['nama_skpd']."</td>
		<td width=\"200\" class=\"text_kanan kiri atas kanan bawah\">".number_format($unit['batasanpagu'],2,',','.')."</td>
		<td width=\"200\" class=\"text_kanan kiri atas kanan bawah\">".number_format($unit['nilaipagu'],2,',','.')."</td>
		<td width=\"200\" class=\"text_kanan kiri atas kanan bawah\">".number_format($unit['nilairincian'],2,',','.')."</td>
		<td width=\"200\" class=\"text_kanan kiri atas kanan bawah\">".number_format($unit['total'],2,',','.')."</td>
		<td width=\"200\" class=\"text_kanan kiri atas kanan bawah\">".number_format($unit['nilairincian']-$unit['batasanpagu'],2,',','.')."</td>
		<td width=\"200\" class=\"text_kanan kiri atas kanan bawah\">".number_format($unit['total']-$unit['nilairincian'],2,',','.')."</td>
		<td width=\"180\" class=\"text_tengah kiri atas kanan bawah\">".(boolval($unit['nilaipagu']==$unit['nilairincian']) ? 'Sudah' : '')."</td>
	</tr>";
}
	$tbody .= "
	<tr>
		<td width=\"180\" class=\"text_tengah kiri atas kanan bawah\"></td>
		<td width=\"400\" class=\"text_kiri kiri atas kanan bawah\">JUMLAH</td>
		<td width=\"200\" class=\"text_kanan kiri atas kanan bawah\">".number_format($batasanpagu,2,',','.')."</td>
		<td width=\"200\" class=\"text_kanan kiri atas kanan bawah\">".number_format($nilaipagu,2,',','.')."</td>
		<td width=\"200\" class=\"text_kanan kiri atas kanan bawah\">".number_format($nilairincian,2,',','.')."</td>
		<td width=\"200\" class=\"text_kanan kiri atas kanan bawah\">".number_format($total,2,',','.')."</td>
		<td width=\"200\" class=\"text_kanan kiri atas kanan bawah\">".number_format($nilairincian-$batasanpagu,2,',','.')."</td>
		<td width=\"200\" class=\"text_kanan kiri atas kanan bawah\">".number_format($total-$nilairincian,2,',','.')."</td>
		<td width=\"180\" class=\"text_tengah kiri atas kanan bawah\"> </td>
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
