<?php
global $wpdb;

$rekap = $wpdb->get_results("
	SELECT c.kodeunit, c.namaunit, SUM(a.rincian) AS total FROM data_rka a 
	LEFT JOIN data_sub_keg_bl b ON a.kode_sbl = b.kode_sbl 
	LEFT JOIN data_unit c ON b.id_sub_skpd = c.id_skpd 
	WHERE a.active = 1 GROUP BY c.id_unit
	ORDER BY `c`.`kodeunit` ASC"
, ARRAY_A);

$tbody = "
	<tr>
		<th class=\"atas kanan bawah kiri text_tengah\" colspan=\"3\">REKAPITULASI RINCIAN PER UNIT</td>
	</tr>        
	<tr>
		<th width=\"180\" class=\"text_tengah kiri atas kanan bawah\">KODE UNIT</td>
		<th class=\"text_tengah kiri atas kanan bawah\">NAMA UNIT</td>
		<th width=\"200\" class=\"text_tengah kiri atas kanan bawah\">RINCIAN</td>
	</tr>";
foreach ($rekap as $baris => $unit) {
	$tbody .= "
	<tr>
		<td width=\"180\" class=\"text_tengah kiri atas kanan bawah\">".$unit['kodeunit']."</td>
		<td class=\"text_kiri kiri atas kanan bawah\">".$unit['namaunit']."</td>
		<td width=\"200\" class=\"text_kanan kiri atas kanan bawah\">".number_format($unit['total'],2,',','.')."</td>
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
