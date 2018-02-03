<div class="panel panel-default">
	<div class="panel-heading">Tambah Produk Baru</div>
	<div class="panel-body">
		<?php
		if (isset($_GET['edit'])) {
			$edit = $db->query("SELECT * FROM produk WHERE id_produk = '$_GET[edit]'");
			$data = $edit->fetch(PDO::FETCH_OBJ);
			$nama = $data->nama;
			$image = $data->gambar;
			$desk = $data->keterangan;
			$stok = $data->stok;
			$harga = $data->harga;
			$berat = $data->berat;
			$id = $_GET['edit'];
			$req = "";
			$btn_nm = "Edit";
			$btn_val = "edit";
			$btn_icon = '<i class="glyphicon glyphicon-edit"></i>';
		}else{
			$nama = null; $image = null; $desk = null; $stok = null; $harga = null; $berat = null; $id = null; $req = "required"; $btn_nm = "Tambah"; $btn_val = "add";
			$btn_icon = '<i class="glyphicon glyphicon-plus"></i>';
		}
		?>
		<form action="<?php echo "$host/admin-cni/proses-produk.php"; ?>" method="post" class="form-horizontal" enctype="multipart/form-data">
			<div class="form-group">
				<label class="col-md-3">Nama Produk :</label>
				<div class="col-md-5">
					<input type="text" name="nm_produk" class="form-control" value="<?php echo $nama; ?>" autofocus required>
					<input type="hidden" value="<?php echo $id; ?>" name="id_product">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3">Gambar Produk :</label>
				<div class="col-md-5">
					<input type="file" name="gb_produk" class="form-control" <?php echo $req; ?>>
					<input type="hidden" value="<?php echo $image; ?>" name="gb_produk2">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3">Deskripsi Produk :</label>
				<div class="col-md-5">
					<textarea name="ket_produk" class="form-control" rows="5" required><?php echo $desk; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3">Stok Produk :</label>
				<div class="col-md-5">
					<input type="number" name="stok_produk" class="form-control" value="<?php echo $stok; ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3">Harga Produk :</label>
				<div class="col-md-5">
					<input type="number" name="harga_produk" class="form-control" value="<?php echo $harga; ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3">Berat Produk :</label>
				<div class="col-md-5">
					<input type="number" name="berat_produk" class="form-control" value="<?php echo $berat; ?>" required><br>
					<button class="btn btn-default" name="<?php echo $btn_val; ?>" value="<?php echo $btn_val; ?>"><?php echo $btn_icon." ".$btn_nm; ?></button>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">Daftar Produk</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-hover table-condensed">
				<thead>
					<tr>
						<th colspan="2">Produk</th>
						<th>Deskripsi</th>
						<th>Stok</th>
						<th>Harga</th>
						<th>Berat</th>
						<th>Date</th>
						<th>Terjual</th>
					</tr>
				</thead>
				<tbody>
					<?php
					date_default_timezone_set('Asia/Singapore');
					$sql = $db->query("SELECT * FROM produk ORDER BY id_produk DESC");
					while ($data = $sql->fetch(PDO::FETCH_OBJ)) {
						echo "
						<tr>
							<td width='20%'>
							$data->nama<br><br>
							<a href='".$host."/admin-cni/?adm=set-produk&edit=".$data->id_produk."' data-toggle='tooltip' data-placement='bottom' title='Edit'><i class='glyphicon glyphicon-edit' style='font-size:17px;'></i></a>&nbsp;&nbsp&nbsp;&nbsp;
							<a href='javascript:void(0)' data-toggle='tooltip' data-placement='bottom' title='Hapus' onclick='hapus_produk(".$data->id_produk.")'><i class='glyphicon glyphicon-remove-sign' style='color:red;font-size:17px;'></i></a>
							</td>
							<td><img src='".$host."/images/produk/".$data->gambar."' class='img-responsive'></td>
							<td>".substr($data->keterangan,0,50)."...</td>
							<td>$data->stok</td>
							<td>Rp ".number_format($data->harga,0,",",".")."</td>
							<td>$data->berat gram</td>
							<td>".date("d-m-Y H:i:s",$data->tanggal)."</td>
							<td align='center'>$data->terjual</td>
						</tr>
						";
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>