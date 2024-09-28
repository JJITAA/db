<?php
$servidor = "sql209.infinityfree.com";
$usuario = "if0_37402191";
$clave = "josuetecun";
$basededatos= "if0_37402191_proyecto";

$enlace = mysqli_connect($servidor, $usuario, $clave, $basededatos);

if(!$enlace){
    die("Error en la conexión: " . mysqli_connect_error());
}

if(isset($_POST['registro'])){
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    $insertardatos = "INSERT INTO conexion (nombre, apellido, correo, contraseña) VALUES ('$nombre', '$apellido', '$correo', '$contraseña')";

    $ejecutarinsert = mysqli_query($enlace, $insertardatos);

    if($ejecutarinsert){
        echo "Usuario agregado correctamente";
    }else{
        echo "Error al agregar usuario";
    }
}

// Función para eliminar un usuario
if(isset($_GET['eliminar'])){
    $id = $_GET['eliminar'];
    $eliminarUsuario = "DELETE FROM conexion WHERE id='$id'";
    $ejecutarEliminar = mysqli_query($enlace, $eliminarUsuario);

    if($ejecutarEliminar){
        echo "Usuario eliminado correctamente";
    }else{
        echo "Error al eliminar usuario";
    }
}

// Función para actualizar los datos de un usuario
if(isset($_POST['editar'])){
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    $actualizarDatos = "UPDATE conexion SET nombre='$nombre', apellido='$apellido', correo='$correo', contraseña='$contraseña' WHERE id='$id'";

    $ejecutarActualizar = mysqli_query($enlace, $actualizarDatos);

    if($ejecutarActualizar){
        echo "Usuario actualizado correctamente";
    }else{
        echo "Error al actualizar usuario";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD App</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <h1>Gestión de Usuarios</h1>
        <form action="#" name="crud1" method="post">
            <input type="hidden" name="id" value="<?php if(isset($_GET['editar'])) echo $_GET['editar']; ?>">
            <input type="text" name="nombre" placeholder="Nombre" value="<?php if(isset($nombre)) echo $nombre; ?>" required>
            <input type="text" name="apellido" placeholder="Apellido" value="<?php if(isset($apellido)) echo $apellido; ?>" required>
            <input type="email" name="email" placeholder="Correo Electrónico" value="<?php if(isset($correo)) echo $correo; ?>" required>
            <input type="password" name="contraseña" placeholder="Contraseña" value="<?php if(isset($contraseña)) echo $contraseña; ?>" required>
            <?php if(isset($_GET['editar'])): ?>
                <button type="submit" name="editar">Actualizar Usuario</button>
            <?php else: ?>
                <button type="submit" name="registro">Agregar Usuario</button>
            <?php endif; ?>
        </form>

        <h2>Lista de Usuarios</h2>
        <table border="1">
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
            <?php
            $mostrarDatos = "SELECT * FROM conexion";
            $resultado = mysqli_query($enlace, $mostrarDatos);

            while($fila = mysqli_fetch_array($resultado)){
                echo "<tr>";
                echo "<td>" . $fila['nombre'] . "</td>";
                echo "<td>" . $fila['apellido'] . "</td>";
                echo "<td>" . $fila['correo'] . "</td>";
                echo "<td>
                        <a href='?editar=" . $fila['id'] . "'>Editar</a> |
                        <a href='?eliminar=" . $fila['id'] . "'>Eliminar</a>
                     </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
