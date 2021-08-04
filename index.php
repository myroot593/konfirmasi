<?php

require_once('db.php');
require_once('function.php');

$obj = new crud;

$email_err = $username_err = $pass_err = "";

if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(empty($_POST['username']))
	{
		$username_err ="Username tidak boleh kosong";
	}
	else
	{
		$username=$_POST['username'];

	}

	if(empty($_POST['email']))
	{
		$email_err ="Email tidak boleh kosong";
	}
	else
	{
		$email=$_POST['email'];
		
	}

	if(empty($_POST['pass']))
	{
		$pass_err ="Password tidak boleh kosong";
	}
	else
	{
		$pass=$_POST['pass'];
		
	}
	if(empty($username_err) && empty($email_err) && empty($pass_err))
	{
		if($obj->insertUser($username, $email, $pass))
		{
			$last=$obj->insertlastid_to_pending_user();
				if($obj->insertPending_user($last, $email))
				{
					
					echo "<div class='alert alert-success'>Data berhasil disimpan</div>";
				}
				else
				{
					echo "<div class='alert alert-danger'>Terjadi kesalahan saat menyimpan ke pending user</div>";
				}
		}
		else
		{
			echo "<div class='alert alert-danger'>Gagal menyimpan user</div>";
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Pendaftaran Akun</title>

	<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
	<div class="row">
		
		
		<div class="col-md-4 mt-4">
			<h4>Pendaftaran</h4>
			<form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
				<div class="form-group">
					<label>Username</label>
					<input type="text" class="form-control" name="username" required="">
					<span class="text-danger"><?=$username_err;?></span>
				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="text" class="form-control" name="email" required="">
					<span class="text-danger"><?=$email_err;?></span>
				</div>
					<div class="form-group">
					<label>Password</label>
					<input type="text" class="form-control" name="pass" required="">
					<span class="text-danger"><?=$pass_err;?></span>
				</div>
				<button type="submit" class="btn btn-md btn-primary">Daftar</button>
			</form>
		</div>
		<div class="col-md-8 mt-4">
			<h5>Tabel Pending User</h5>
			<div class="table-responsive">
			<table class="table table-bordered">
				<tr>
					<th>UID</th>
					<th>EMAIL</th>
					<th>HASH</th>
					<th>STATUS</th>
					<th>AKSI</th>
				</tr>
			
					<?php
						$user = $obj->showPending_user('field_pending_user');
						if($user->num_rows>0)
						{
							while ($row=$user->fetch_array()) {
								echo'
								<tr>
								<td>'.$row['uid'].'</td>
								<td>'.$row['email'].'</td>
								<td>'.$row['hash'].'</td>
								<td>'.$row['pending_status'].'</td>
								<td>
									<a href="test_konfirmasi.php?email='.$row['email'].'&hash='.$row['hash'].'">Uji konfirmasi</a>


								</td>
								</tr>
								';
							}
						}
						else
						{
							echo '<tr><td colspan=4>Belum terdapat data</td></tr>';
						}
					?>
			</table>
			</div>
			<h5>Tabel User</h5>
			<div class="table-responsive">
			<table class="table table-bordered">
				<tr>
					<th>UID</th>
					<th>USERNAME</th>
					<th>EMAIL</th>					
					<th>STATUS</th>
				
				</tr>
			
					<?php
						$user = $obj->showPending_user('field_user');
						if($user->num_rows>0)
						{
							while ($row=$user->fetch_array()) {
								echo'
								<tr>
								<td>'.$row['uid'].'</td>
								<td>'.$row['username'].'</td>
								<td>'.$row['email'].'</td>								
								<td>'.$row['status'].'</td>

								</tr>
								';
							}
						}
						else
						{
							echo '<tr><td colspan=4>Belum terdapat data</td></tr>';
						}
					?>	
			</table>
			</div>	
			
		</div>
	</div>
</div>
</body>
</html>
