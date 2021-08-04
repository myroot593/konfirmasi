<?php

class Database
{
	private $host="localhost";
	private $user="root";
	private $pass="";
	private $db="konfirmasi";
	protected $koneksi;
	public function __construct()
	{
		$this->koneksi = new mysqli($this->host, $this->user, $this->pass, $this->db);
		if($this->koneksi==false)die("Gagal melakukan koneksi".$this->koneksi->connect_error());
		return $this->koneksi;
	}
}
