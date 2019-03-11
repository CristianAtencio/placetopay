<?php 

Class Conectar {

	public static function conexion(){
		
		$servername = "localhost";
		$username = "root";
		$password = "";
 		$database = "placetopay";

		$connection= mysqli_connect($servername,$username,$password);

		if (!$connection) {
			die("Connection failed: ". mysqli_connect_error());
		}

		$sql = "create database if not exists ".$database;

		if ($createDb = mysqli_query($connection,$sql)) {
		
			mysqli_query($connection,"use ".$database);
	
			$sqluser="create table if not exists users(Id int(11) not null auto_increment, FirstName varchar(50) not null,LastName varchar(50) not null, Email varchar(100) not null, primary key (id))";
	
			$resulttableuser = mysqli_query($connection,$sqluser);

			$sqlpayment = "create table if not exists payment(Id int(11) not null auto_increment,Amount int(11) not null,Currency varchar(3) not null, State varchar(23) not null, IdPayment varchar(11), UserId int(11) not null, primary key (Id), FOREIGN key (UserId) REFERENCES users(Id))";
			
			$resulttablepayment = mysqli_query($connection,$sqlpayment);

			return $connection;

		}else{
			return "The create database failed: ".mysqli_error($connection); 
		}

	}

}

?>