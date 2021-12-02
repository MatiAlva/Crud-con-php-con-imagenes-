<?php
$conexion = mysqli_connect("localhost", "root", "", "crud") or die("ror de conexion
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title> PAGINA Vehiculo </title>
        <link rel="stylesheet" type="text/css" href="Estilos/styles.css">
    </head>
<body>
 <header>
    <h1>Grupo 1</h1>
    <a href="info.html" class="info">+info</a>
</header>

<form action="#" method="POST" enctype= "multipart/form-data">
                    <h1> Datos del vehiculo </h1>
                    <input type="text" name="marca" placeholder="Marca" required/>
                    <input type="text" name="modelo" placeholder="Modelo" required/>
                    <h3> Ingrese el color: </h3>
                    <input type="color" name="color" placeholder="Color" class="color" />
                    <input type="text" name="patente" placeholder="Patente" required/>
                    <h3> Mes y Año de su compra: </h3>
                    <input type="month" name="año" placeholder="Año" required/>
                    <input type="int" name="km" placeholder="Kilometros recorridos" required/>
                    <input type="file" name="foto" acept="imagen/" required/>
                    <input type="submit" name="insertar" value="Enviar Datos" class="enviar"/>
</form>
</body>
</html>
<?php

      

if(isset($_POST['insertar'])){
    $marca_vehiculo = $_POST['marca'];
    $modelo_vehiculo = $_POST['modelo'];
    $color_vehiculo = $_POST['color'];
    $patente_vehiculo = $_POST['patente'];
    $año_vehiculo = $_POST['año'];
    $km_vehiculo = $_POST['km'];


    if(is_uploaded_file($_FILES['foto']['tmp_name'])){
        $archivo = $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], 'imagenesbdd/'.$archivo);
    }
    
    


    
    $sql = "INSERT INTO vehiculo (marca, modelo, color, patente, anio, km, imagen) VALUES( '$marca_vehiculo',
        '$modelo_vehiculo', '$color_vehiculo', '$patente_vehiculo', '$año_vehiculo', '$km_vehiculo', '$archivo')";
        $insertar = mysqli_query($conexion, $sql)? print("<script> alert('Registro insertado');window.location='index.php'</script>") : print("<script> alert('Error');window.location='index.php'</script>");
        
        
        $verficar_patente=mysqli_query($conexion, "SELECT * FROM vehiculo WHERE patente='$patente_vehiculo'");

}


?>
       

        <?php
if(isset($_GET['id_borrar'])){
    $id_borrar = $_GET['id_borrar'];
    $sql = "DELETE FROM vehiculo WHERE cod_vehiculo='$id_borrar'";
    $borrar = mysqli_query($conexion, $sql)? print ("<script> alert('Registro eliminado');window.location='index.php'</script>") : print ("<script> alert('Error a la hora de eliminar el regsitro');window.location='index.php'</script>");
}

?>

  <?php
if(isset($_GET['id_editar'])){
    $id_editar = $_GET['id_editar'];
    $sql= "SELECT * FROM vehiculo WHERE cod_vehiculo='$id_editar'";
    $consulta = mysqli_query($conexion, $sql);
    $reg_editar = mysqli_fetch_assoc($consulta);
    echo '
    
    <form action="" method="post" enctype= "multipart/form-data" class="modificar">
    <h1 style="font-family: Verdana, Geneva, Tahoma, sans-serif; color: rgb(255, 255, 255); text-align: center;
    padding: 10px; "> Actualizar datos </h1>
        <input type="text" name="Marca"  placeholder="Ingrese la marca" value ="'.$reg_editar['marca'].'" />
        <input type="hidden" name="fotoPrevia"  acept="imagen/" value ="'.$reg_editar['imagen'].'" />
        <input type="text" name="Modelo"  placeholder="Ingrese el modelo" value ="'.$reg_editar['modelo'].'"/>
        <h3> Ingrese el color: </h3>
        <input type="color" name="Color" placeholder="Ingrese el color" value ="'.$reg_editar['color'].'" />
        <input type="int" name="Patente" placeholder="Ingrese la patente" value ="'.$reg_editar['patente'].'" />
        <input type="month" name="Año" placeholder="Ingrese el año de la compra" value ="'.$reg_editar['anio'].'" />
        <input type="int" name="KM" placeholder="Ingrese los Kilometros" value ="'.$reg_editar['km'].'" />
        <input type="file" name="foto" acept="imagen/" />       
        <input type="submit" name="modificar" value="Modificar Datos" class="enviar"/>
    </form>
    ';
}


if(isset($_POST['modificar'])){
    $foto_previa = $_POST['fotoPrevia'];
    $marca_mod = $_POST['Marca'];
    $modelo_mod = $_POST['Modelo'];
    $color_mod = $_POST['Color'];
    $patente_mod = $_POST['Patente'];
    $año_mod = $_POST['Año'];
    $km_mod = $_POST['KM'];

    if(is_uploaded_file($_FILES['foto']['tmp_name'])){
        $archivo = $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], 'imagenesbdd/'.$archivo);
        unlink("imagenesbdd/" .$foto_previa);
    }else{
        $archivo = $foto_previa;
    }
        $sql = "UPDATE vehiculo SET marca='$marca_mod', modelo='$modelo_mod', color='$color_mod', patente='$patente_mod', anio='$año_mod', km='$km_mod', imagen='$archivo' WHERE cod_vehiculo='$id_editar'";
        $insertar = mysqli_query($conexion, $sql)? print("<script> alert('Registro modificado');window.location='index.php'</script>") : print("<script> alert('Error al modificar');window.location='index.php'</script>");
}




?>

<?php

$sql = "SELECT * FROM vehiculo";
$consulta = mysqli_query($conexion, $sql);
    if(mysqli_num_rows($consulta)>0){
        while($registro = mysqli_fetch_assoc($consulta)){
            echo '
            <table class="table">
                    <tr>
                      
                        <th> Marca_vehiculo </th>
                        <th> Modelo_vehiculo </th>
                        <th> Color_vehiculo </th>
                        <th> Patente_vehiculo </th>
                        <th> Año y Mes_vehiculo </th>
                        <th> Km_vehiculo </th>
                        <th> Imgagen_vehiculo </th>
                    </tr>

                    <tr> 
                        <th> '.$registro['marca'].'</th>
                        <th> '.$registro['modelo'].'</th>
                        <th><div style="width: 40px; height: 30px; background:' .$registro['color'].'"</div></th>
                        <th> '.$registro['patente'].'</th>
                        <th> '.$registro['anio'].'</th>
                        <th> '.$registro['km'].'</th>
                        <th> <img src ="imagenesbdd/'.$registro['imagen'].'" style="width:40px"> </th>
                        <th> <a class="eliminar" href ="index.php?id_borrar='.$registro['cod_vehiculo'].'" onclick="return confirm 
                        (\'¿Seguro desea eliminar?\')" >Eliminar </a> </th>
                        <th> <a class="editar" href ="index.php?id_editar='.$registro['cod_vehiculo'].'"> Editar </a> </th>
                    </tr>
            ';
        }
    }else{
        echo "<script>alert('No hay nada que mostrar') </script>";
    }


?>

<?php

mysqli_close($conexion);
?>
