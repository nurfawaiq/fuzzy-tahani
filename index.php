<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Fuzzy PHP">
	<meta name="keywords" content="fuzzy, tahani">
	<meta name="author" content="M. Nur Fawaiq">
    <title>Fuzzy Tahani PHP</title>
	<style>
		body { font-family:Verdana, Arial; font-size:12px; }
		.text-justify { text-align:center; }	
		.text-right { text-align:right; }	
		.bg1, .bg2, .bg3 { background-color:#CCFFCC; }
		.bg6, .bg7, .bg8 { background-color:#FFFFCC; }
		th, td { padding:.3em .5em; }
		th { background-color:#EEEEEE; }
	</style>
</head>
<body>
	<?php
	$con = mysqli_connect("localhost", "root", "", "tahani");

	function cek_selected($cek, $value)	{
		if($cek == $value) {
			echo "selected=\"selected\"";
		}		
	}	
		
	function format_desimal($nn, $des) {
		return number_format($nn, $des, ",", ".");
	}

	function get_namakelompok($id_kelompok, $con)	{
		$hasil = mysqli_query($con, "SELECT * FROM kelompok WHERE id = '$id_kelompok'");
		$row = mysqli_fetch_array($hasil);
		return $row['nama_kelompok'];
	}	
		
	function derajat_keanggotaan($nilai, $bawah, $tengah, $atas) {
		$selisih = $atas - $bawah;	
		
		if($nilai < $bawah) {
			$DA = 0;	
		} elseif (($nilai >= $bawah) && ($nilai <= $tengah)) {
			if($bawah <= 0) {
				$DA = 1;
			} else {
				$DA = ((float)$nilai - (float)$bawah) / ((float)$tengah - (float)$bawah);	
			}
		} elseif (($nilai > $tengah) && ($nilai <= $atas)) {
			$DA = ((float)$atas - (float)$nilai) / ((float)$atas - (float)$tengah);
		} elseif($nilai > $atas) {
			$DA = 0;
		}

		return $DA;	
	}
		
	$ux[][] = NULL;  // variabel utk data derajat keanggotaaan
	 	
	$kelompok = isset($_GET['kelompok']) ? $_GET['kelompok'] : 1;
	$hasil_kelompok	= mysqli_query($con, "SELECT * FROM kelompok WHERE id = '$kelompok'");
	$row_kelompok = mysqli_fetch_array($hasil_kelompok);
	
	$hasil = mysqli_query($con, "SELECT * FROM kriteria");
	$jumkol = mysqli_num_rows($hasil);
	?>

	<h2>Data Buah & Derajat Keanggotaan</h2> 
	<table border="1" cellpadding="3" style="border-collapse:collapse;">
		<thead>
			<tr>
				<th width="17" rowspan="2">ID</th>
				<th width="100" rowspan="2">Nama Buah</th>
				<th width="28" rowspan="2">Kandungan Vitamin C</th>
				<th width="37" rowspan="2">Masa Tanam</th>
				<th width="78" rowspan="2">Harga</th>
				
				<th colspan="3">(&#956;[x]) <?= get_namakelompok(1, $con);?></th>
				<th colspan="2">(&#956;[x]) <?= get_namakelompok(2, $con);?></th>
				<th colspan="3">(&#956;[x]) <?= get_namakelompok(3, $con);?></th>
			</tr>
			<tr>
				<?php
				$hasil = mysqli_query($con, "SELECT * FROM kriteria WHERE kelompok = '1'");
				while($row = mysqli_fetch_array($hasil)) {
					echo "<th>" . $row['nama_kriteria'] . "</th>";
				}

				$hasil = mysqli_query($con, "SELECT * FROM kriteria WHERE kelompok = '2'");
				while($row = mysqli_fetch_array($hasil)) {
					echo "<th>" . $row['nama_kriteria'] ."</th>";
				}

				$hasil = mysqli_query($con, "SELECT * FROM kriteria WHERE kelompok = '3'");
				while($row = mysqli_fetch_array($hasil)) {
					echo "<th>" . $row['nama_kriteria'] . "</th>";
				}
				?>
			</tr>
		</thead>
		<tbody>
			<?php
			$hasil = mysqli_query($con, "SELECT * FROM buah");
			while($row=mysqli_fetch_array($hasil)) {
			?>
			<tr>
				<td><?= $row['id']; ?></td>
				<td><?= $row['nama']; ?></td>
				<td class="text-right"><?= $row['vitamin']; ?></td>
				<td class="text-right"><?= $row['masatanam']; ?></td>
				<td class="text-right"><?= format_desimal($row['harga'], 2); ?></td>
				<?php
				$hasil2	=mysqli_query($con, "SELECT * FROM kriteria WHERE kelompok = '1'");
				while($row2 = mysqli_fetch_array($hasil2)) {
					$u = derajat_keanggotaan($row['vitamin'], $row2['bawah'], $row2['tengah'], $row2['atas']);
					$ux[$row['id']][$row2['id']] = $u;
					$bg = "text-right";
					if(isset($_GET['vitamin']) && ($row2['id'] == $_GET['vitamin'])) {
						$bg .= " bg" . $row2['id'];
					}
					?>	
					<td class="<?= $bg; ?>"><?= format_desimal($u, 2); ?></td>
					<?php
				}
				?>
				<?php
				$hasil2	= mysqli_query($con, "SELECT * FROM kriteria WHERE kelompok='2'");
				while($row2 = mysqli_fetch_array($hasil2)) {
					$u = derajat_keanggotaan($row['masatanam'], $row2['bawah'], $row2['tengah'], $row2['atas']);
					$ux[$row['id']][$row2['id']] = $u;
					?>
					<td class="text-right"><?= format_desimal($u, 2, ",", "."); ?></td>
					<?php
				}

				$hasil2	= mysqli_query($con, "SELECT * FROM kriteria WHERE kelompok='3'");
				while($row2 = mysqli_fetch_array($hasil2)) {
					$u = derajat_keanggotaan($row['harga'], $row2['bawah'], $row2['tengah'], $row2['atas']);
					$ux[$row['id']][$row2['id']] = $u;
					$bg = "text-right";
					if(isset($_GET['harga']) && ($row2['id'] == $_GET['harga'])) {
						$bg .= " bg" . $row2['id'];
					}
					?>
					<td class="<?= $bg; ?>"><?= format_desimal($u,2); ?></td>
					<?php
				}
				?>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
	
	<br>

	<h2><strong>Query</strong></h2>
	<form action="" method="GET">
		<select name="vitamin" required>
			<option value=""></option>
			<option value="1" <?php if(isset($_GET['vitamin'])) cek_selected($_GET['vitamin'],1); ?>>Vitamin rendah</option>
			<option value="2" <?php if(isset($_GET['vitamin'])) cek_selected($_GET['vitamin'],2); ?>>Vitamin sedang</option>
			<option value="3" <?php if(isset($_GET['vitamin'])) cek_selected($_GET['vitamin'],3); ?>>Vitamin tinggi</option>
		</select>
		<select name="opr">
			<option value="OR" <?php if(isset($_GET['opr'])) cek_selected($_GET['opr'],"OR"); ?>>OR</option>
			<option value="AND" <?php if(isset($_GET['opr'])) cek_selected($_GET['opr'],"AND"); ?>>AND</option>
		</select>
		<select name="harga" required>
			<option value=""></option>
			<option value="6" <?php if(isset($_GET['harga'])) cek_selected($_GET['harga'],6); ?>>Harga murah</option>
			<option value="7" <?php if(isset($_GET['harga'])) cek_selected($_GET['harga'],7); ?>>Harga sedang</option>
			<option value="8" <?php if(isset($_GET['harga'])) cek_selected($_GET['harga'],8); ?>>Harga mahal</option>
		</select>
		<button type="submit">Submit</button>
	<form>
	<a href="./"><button type="button">Reset</button></a>

	<br><br>

	<h2><strong>Hasil</strong></h2>
	<?php
	if (isset($_GET['opr'])) {
		$opr = $_GET['opr'];
		$vitamin = $_GET['vitamin'];
		$harga = $_GET['harga'];	
		
		$hasil = mysqli_query($con, "SELECT id,nama FROM buah");
		
		while($row = mysqli_fetch_array($hasil)) {
			// ambil data derajat keanggotaan	
			$c1 = $ux[$row['id']][$vitamin];
			$c2 = $ux[$row['id']][$harga];
			
			// tentukan operasi
			if ($opr == "OR") {
				$cc = max($c1, $c2);
			} else {
				$cc = min($c1, $c2);
			}

			if ($cc > 0) {
				echo $row['nama']." : [".format_desimal($cc,2)."]<br>";
			}
		}
	}
	?>
    
</body>
</html>