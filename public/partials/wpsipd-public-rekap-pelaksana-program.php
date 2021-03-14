<div class="no-print">
<form method="post" name="pilihan-ta" action="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
    <select name="ta">
	<?php 
		echo '<option value="">Pilih Tahun Anggaran</option>';
		echo '<option>2021</option>';
		echo '<option>2022</option>';
	?>
    </select>
    <input type="submit" value="GO"/>
</form>
</div>

<?php
global $wpdb;
$ta = carbon_get_theme_option('crb_tahun_anggaran_sipd');
if (isset($_POST['ta'])) if ($_POST['ta'] != '') $ta = $_POST['ta'];

$rekap = $wpdb->get_results("
    SELECT a.idinduk, b.kode_skpd, b.nama_skpd, c.nama_urusan, c.nama_bidang_urusan, c.kode_program, c.nama_program 
    FROM data_unit a
    JOIN data_unit b
    ON a.idinduk = b.id_skpd
    JOIN data_sub_keg_bl c
    ON a.id_skpd = c.id_sub_skpd
    WHERE a.tahun_anggaran = ".$ta." AND b.tahun_anggaran = ".$ta." AND c.tahun_anggaran = ".$ta."
    GROUP BY a.idinduk, b.nama_skpd, c.nama_urusan, c.nama_bidang_urusan, c.nama_program 
	ORDER BY c.kode_program, `b`.`kode_skpd` ASC"
, ARRAY_A);

$tbody = "
	<tr>
		<th class=\"atas kanan bawah kiri text_tengah\" colspan=\"5\">REKAPITULASI PROGRAM SKPD<br/>TAHUN ".$ta."</td>
	</tr>
	<tr>
		<td colspan=\"5\">
<table>        
<THEAD>
	<tr>
		<th width=\"180\" class=\"text_tengah kiri atas kanan bawah\">NOMOR</td>
		<th width=\"200\" class=\"text_tengah kiri atas kanan bawah\">URUSAN</td>
		<th width=\"200\" class=\"text_tengah kiri atas kanan bawah\">BIDANG</td>
		<th width=\"200\" class=\"text_tengah kiri atas kanan bawah\">PROGRAM</td>
		<th width=\"400\" class=\"text_tengah kiri atas kanan bawah\">NAMA SKPD</td>
	</tr>
</THEAD>";
$i = 0;
foreach ($rekap as $baris => $unit) {
    $i++;
	$tbody .= "
	<tr>
		<td width=\"180\" class=\"text_tengah kiri atas kanan bawah\">".$i."</td>
		<td width=\"400\" class=\"text_kiri kiri atas kanan bawah\">".$unit['nama_urusan']."</td>
		<td width=\"400\" class=\"text_kiri kiri atas kanan bawah\">".$unit['nama_bidang_urusan']."</td>
		<td width=\"400\" class=\"text_kiri kiri atas kanan bawah\">".$unit['nama_program']."</td>
		<td width=\"400\" class=\"text_kiri kiri atas kanan bawah\">".$unit['nama_skpd']."</td>
	</tr>";
}
	$tbody .= "
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
