<?php
function img_resize_upload($new_name, $dir, $file, $width, $ext) {
	//direktori upload
	$dir_upload = $dir . $_FILES[''.$file.'']['name'];

	//simpan gambar dalam ukuran sebenarnya
	move_uploaded_file($_FILES[''.$file.'']['tmp_name'], $dir.$_FILES[''.$file.'']['name']);

	//identitas file asli
	if ($ext == "jpeg" || $ext == "jpg") {
		$img_src = imagecreatefromjpeg($dir_upload);
	}else if ($ext == "png"){
		$img_src = imagecreatefrompng($dir_upload);
	}
	$src_width = imagesx($img_src);
	$src_height = imagesy($img_src);

	//set ukuran gambar hasil perubahan
	$dst_width = $width;
	$dst_height = ($dst_width/$src_width)*$src_height;

	//proses perubahan ukuran gambar
	$img = imagecreatetruecolor($dst_width, $dst_height);
	imagecopyresampled($img, $img_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

	//simpan gambar
	imagejpeg($img, $dir.$new_name, 100);

	//hapus gambar di memory komputer
	imagedestroy($img);
	imagedestroy($img_src);
	unlink($dir_upload);
}
?>