<?php

# function.php
class crud extends Database
{

	public function insertUser($username, $email, $pass)
	{
		$sql = "INSERT INTO field_user (username, email, pass) VALUES (?,?,?)";
		if($stmt=$this->koneksi->prepare($sql))
		{
			$stmt->bind_param("sss",$param_user,$param_email, $param_pass);
			$param_user = $username;
			$param_email=$email;
			$param_pass = password_hash($pass, PASSWORD_DEFAULT);
			
			if($stmt->execute())
			{
				return true;

			}
			else
			{
				return false;
			}
		}

	}
	//memasukan id terakhir yang ditambahkan oleh fungsi insertUser
	//karena tabel insertPending_user tidak menggunakan auto increment pada tblnya
	//maka kita tambahkan id insert pending user berdasarkan id sebelumnya
	//pada uid tabel user
	public function insertlastid_to_pending_user()
	{
		$this->last = $this->koneksi->insert_id;
		return $this->last;

		# procedural mysqli_insert_id($var)
		# pdo $koneksi->lastInsertId();
		# oop $koneksi->insert_id;
	}
	public function insertPending_user($data=null, $email, $hash=null)
	{
		$sql = "INSERT INTO field_pending_user (uid, email, hash) VALUES (?,?,?)";
		if($stmt=$this->koneksi->prepare($sql))
		{
			$stmt->bind_param("iss",$data,$param_email,$param_hash);
			
			$param_email=$email;
			$param_hash=md5(rand(0,1000));//menghasilkan hash untuk konfirmasi akun
			$param_data=$data;
			if($stmt->execute())
			{
				return true;

			}
			else
			{
				return false;
			}
		}

	}
	//mengubah status user menjadi aktif (1)
	public function updateUser($email)
	{
		$sql = "UPDATE field_user SET status=1 WHERE email=?";
		if($stmt=$this->koneksi->prepare($sql))
		{
			$stmt->bind_param("s",$param_email);
			$param_email=$email;
			if($stmt->execute())
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	//jika usernya sudah melakukan mengkonfirmasi, maka rubah statusnya menjadi 1
	public function updatePending_user($email)
	{
		$sql = "UPDATE field_pending_user SET pending_status=1 WHERE email=?";
		if($stmt=$this->koneksi->prepare($sql))
		{
			$stmt->bind_param("s",$param_email);
			$param_email=$email;
			if($stmt->execute())
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	//menampilkan data pending user di index
	public function showPending_user($table)
	{
		$sql="SELECT * FROM $table ORDER by uid desc";
		$stmt=$this->koneksi->query($sql);
		if(!$stmt) die("Error statement :".$this->koneksi->error);
		return $stmt;
	}


	//mencocokan url email dan hash yang diakses oleh user
	public function emailverification($email, $hash)
	{
		$sql = "SELECT email, hash FROM field_pending_user WHERE email=? AND hash=? AND pending_status=0";
		if($stmt=$this->koneksi->prepare($sql))
		{
			$stmt->bind_param("ss",$param_email, $param_hash);
			$param_email=$email;
			$param_hash=$hash;
			if($stmt->execute())
			{
				$stmt->store_result();
				$stmt->bind_result($this->email, $this->hash);
				$stmt->fetch();
			
				if($stmt->num_rows==1)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}

	}

	//proses pencocokan data
	public function getHash($email, $hash)
	{
		if(isset($email) && !empty($email) AND isset($hash) && !empty($hash))
		{
			//jika ada request berhasil maka cocokan data email dan hashnya
			if($this->emailverification($email,$hash))
			{
				//jika cocok maka update tabel pending user
				if($this->updatePending_user($email))
				{
					//selanjutnya update status pda tabel user
					if($this->updateUser($email))
					{
						
						echo "<div class='alert alert-success'>Data berhasil diaktifkan</div>";
					}
					else
					{
						echo "<div class='alert alert-danger'>Data user gagal diaktifkan</div>";
					}
				}
				else
				{
					echo "<div class='alert alert-danger'>Data email gagal dikonfirmasi</div>";
				}
			}
			else
			{
				echo "<div class='alert alert-danger'>Data email atau hash salah</div>";
			}
		}
		else
		{
			echo "<div class='alert alert-danger'>Request data tidak ditemukan</div>";
		}
	}
	public function __destruct()
	{

	}

}
