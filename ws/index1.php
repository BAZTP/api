<?php
	include 'conexion1.php';
	$pdo =new Conexion();
	if($_SERVER['REQUEST_METHOD']=='GET'){
		if(isset($_GET['id'])){
			$sql=$pdo->prepare("Select * from contactos where id=:id");
			$sql->bindValue(':id',$_GET['id']);
			$sql->execute();
			$sql-> setFetchMode(PDO::FETCH_ASSOC);
			header ("HTTP/1.1 200 OK datos");
			echo json_encode($sql->fetchAll());
			exit;
		}else{
			$sql=$pdo->prepare("Select * from contactos");
			$sql->execute();
			$sql-> setFetchMode(PDO::FETCH_ASSOC);
			header ("HTTP/1.1 200 OK datos");
			echo json_encode($sql->fetchAll());
			exit;
		}
	}
	
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$sql="Insert into contactos(nombre, telefono, email) 
		values (:nombre, :telefono, :email)";
		$stmt=$pdo->prepare($sql);
		$stmt->bindValue(':nombre',$_POST['nombre']);
		$stmt->bindValue(':telefono',$_POST['telefono']);
		$stmt->bindValue(':email',$_POST['email']);
		$stmt->execute();
		$idPost=$pdo->lastInsertId();
		if($idPost){
			header ("HTTP/1.1 200 OK se insertaron los datos");
			echo json_encode($idPost);
			exit;
		}
	}
	
	if($_SERVER['REQUEST_METHOD']=='PUT'){
		$sql="update contactos set nombre=:nombre, telefono=:telefono, email=:email
		where id=:id";
		$stmt=$pdo->prepare($sql);
		$stmt->bindValue(':id',$_GET['id']);
		$stmt->bindValue(':nombre',$_GET['nombre']);
		$stmt->bindValue(':telefono',$_GET['telefono']);
		$stmt->bindValue(':email',$_GET['email']);
		$stmt->execute();
		header ("HTTP/1.1 200 OK se actualizaron los datos");
		exit;
	}
	
	if($_SERVER['REQUEST_METHOD']=='DELETE'){
		$sql="delete from contactos where id=:id";
		$stmt=$pdo->prepare($sql);
		$stmt->bindValue(':id',$_GET['id']);
		$stmt->execute();
		header ("HTTP/1.1 200 OK se elimino los datos");
		exit;
	}
?>