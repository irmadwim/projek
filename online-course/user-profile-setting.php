<?php include 'process/session.php'; ?>
<?php $id = $_SESSION['uid'];?>
<?php $pecah = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM table_user WHERE id_user='$id'" )); ?>

<!-- profile setting -->
<div class="container" style="margin-top: 80px;">
	<div class="row justify-content-center">
		<div class="col-md-4">
			<div class="card ">
				<img src="./image/<?= $pecah['foto_user'];
				?>" class="rounded-circle ml-auto mr-auto mt-3 mb-3"  alt="no image" width='190px' >
				<h5 class="card-title text-center ml-3 mr-3"> 
					<?= $pecah['nama_depan'];  ?> <?= $pecah['nama_belakang'];  ?>
				</h5>
				<p class="card-text text-center mb-3"> 
					<?= $pecah['email_user'];  ?></p>
				</div>
			</div> 
			<!-- form profile -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-body">
						<form method="post" enctype="multipart/form-data">
							<ul class="list-group list-group-flush">
								<li class="list-group-item text-center">
									<h4 class="card-title">Profile</h4>
									<p class="card-text">Add information about yourself.</p>
								</li>
								<li class="list-group-item">
									<div class="row">
										<div class="col-md">
											<div class="form-group">
												<label for="exampleFormControlTextarea1">First name</label>
												<input type="text" name="Nama" class="form-control"  placeholder="First name" value="<?= $pecah['nama_depan'];?>">
											</div>
										</div>
										<div class="col-md">
											<div class="form-group">
												<label for="exampleFormControlTextarea1">First name</label>
												<input type="text" name="nama" class="form-control"  placeholder="Last name" value="<?= $pecah['nama_belakang'];?>">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="exampleFormControlTextarea1">Photo</label>
										<small style="font-size: 12px;" class="text-muted">*upload foto profil dengan ukuran (500Kb) dan dimensi (640x640)</small>

										<input type="file" class="form-control" name="image">
									</div>
									<div class="form-group">
										<label for="exampleFormControlTextarea1">Bio</label>
										<textarea class="form-control" name="bio" rows="3"><?= $pecah['bio_user'];?></textarea>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleFormControlTextarea1">TTL</label>
												<input type="date" class="form-control" name="tl" value="<?= $pecah['tl_user'];?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleFormControlTextarea1">Contact</label>
												<input type="number" class="form-control" name="kontak" placeholder="Contact" value="<?= $pecah['telepon_user'];?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="exampleFormControlTextarea1">Address</label>
												<input class="form-control" name="alamat"  value="<?= $pecah['alamat_user'];?>">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="exampleFormControlTextarea1">City</label>
												<input type="text"  name="kota" class="form-control" placeholder="City" value="<?= $pecah['kota_user'];?>">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="exampleFormControlTextarea1">Country</label>
												<input type="text"  name="negara" class="form-control" placeholder="City" value="<?= $pecah['negara_user'];?>">
											</div>
										</div>
									</div>
								</li>
								<li class="list-group-item">
									<label for="basic-url">Links</label>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text">Website http://</span>
										</div>
										<input type="text" class="form-control" name="link_web" aria-describedby="basic-addon3" value="<?= $pecah['link_web'];?>">
									</div>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon3" >http://twitter.com/</span>
										</div>
										<input type="text" class="form-control"  name="link_twitter"  aria-describedby="basic-addon3"  value="<?= $pecah['link_twitter'];?>">
									</div>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon3">http://www.facebook.com/</span>
										</div>
										<input type="text" class="form-control"   name="link_facebook" aria-describedby="basic-addon3" value="<?= $pecah['link_facebook'];?>">
									</div>
								</li>
							</ul>
							<div class="card-group-item text-center mt-3">
								<button class="btn btn-warning btn-block" name="save">Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- end form profile -->
		</div>
	</div>
</div>

<!-- update profile user -->
<!-- end update profile user -->
<?php 
if (isset($_POST['save'])) {
	$errors = $_FILES['image']['error'];
	$file_name = $_FILES['image']['name'];
	$file_size = $_FILES['image']['size'];
	$file_tmp = $_FILES['image']['tmp_name'];
	$file_type = $_FILES['image']['type'];
	$file_ext = strtolower(end(explode('.',$_FILES['image']['name'])));
	$expensions= array("jpeg","jpg","png");
	$lebar_max       = 640;
	$tinggi_max      = 640;
	$lokasi_gambar   = $file_tmp;
	$ukuran_asli = GetImageSize($file_tmp);

	if (!empty($file_tmp)) {
		if ($errors === 0) {
			if (in_array($file_ext,$expensions)== true) {
				if ($file_size < 500000) {
					if ( $ukuran_asli[0] != $lebar_max and $ukuran_asli[1] != $tinggi_max ) {
						echo "<script>alert('your profile photo size should be 640x640 ');</script>";
					}else{
						move_uploaded_file($file_tmp, "./image/$file_name");
						$result = mysqli_query($conn, "UPDATE table_user SET nama_depan='$_POST[Nama]', nama_belakang='$_POST[nama]', bio_user='$_POST[bio]', telepon_user='$_POST[kontak]', tl_user='$_POST[tl]', alamat_user='$_POST[alamat]', kota_user='$_POST[kota]', negara_user='$_POST[negara]', link_web='$_POST[link_web]', link_twitter='$_POST[link_twitter]', link_facebook='$_POST[link_facebook]', foto_user='$file_name' WHERE id_user='$id'");
						echo "<script>alert('( Update Image ) Successfull Update Your Profile');</script>";
						echo "<meta http-equiv='refresh' content='0'>";
					}
					
				}else{
					echo "<script>alert('( Upload Image ) File size must be excately 500 KB');</script>";
				}
			}else{
				echo "<script>alert('( Upload Image ) Extension not allowed, please choose a JPEG or PNG file.');</script>";
			}
		}else{
			echo "<script>alert('( Upload Image ) Image not empty);</script>";
		}
	}else{
		$result = mysqli_query($conn, "UPDATE table_user SET nama_depan='$_POST[Nama]', nama_belakang='$_POST[nama]', bio_user='$_POST[bio]', telepon_user='$_POST[kontak]', tl_user='$_POST[tl]', alamat_user='$_POST[alamat]', kota_user='$_POST[kota]', negara_user='$_POST[negara]', link_web='$_POST[link_web]', link_twitter='$_POST[link_twitter]', link_facebook='$_POST[link_facebook]' WHERE id_user='$id'");
		echo "<script>alert('( No Update Image ) Successfull Update Your Profile');</script>";
		echo "<meta http-equiv='refresh' content='0'>";
	}
}
?>
