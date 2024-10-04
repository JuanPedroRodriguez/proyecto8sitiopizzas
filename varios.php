<form action="upload.php" method="POST" enctype="multipart/form-data">
    <label for="imagen">Selecciona una imagen:</label>
    <input type="file" name="imagen" id="imagen" required>
    <input type="submit" name="submit" value="Subir Imagen">
</form>

<?php
if (isset($_POST['submit'])) {
    // Directorio donde se guardarán las imágenes
    $target_dir = "uploads/";
    
    // Nombre del archivo (asegúrate de que sea único)
    $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
    
    // Obtener la extensión del archivo
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validar si es una imagen real o un archivo falso
    $check = getimagesize($_FILES["imagen"]["tmp_name"]);
    if ($check === false) {
        die("El archivo no es una imagen.");
    }

    // Verificar si el archivo ya existe
    if (file_exists($target_file)) {
        die("Lo siento, el archivo ya existe.");
    }

    // Limitar los formatos de archivo permitidos
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        die("Lo siento, solo se permiten archivos JPG, JPEG y PNG.");
    }

    // Intentar mover el archivo subido a la carpeta de destino
    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
        echo "El archivo ". htmlspecialchars(basename($_FILES["imagen"]["name"])) . " ha sido subido.";

        // Aquí guardamos la ruta de la imagen en la base de datos
        $conn = new mysqli('localhost', 'usuario', 'password', 'nombre_base_de_datos');

        // Chequear conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Preparar la consulta para insertar la ruta en la base de datos
        $sql = "INSERT INTO productos (nombre_producto, descripcion, precio, imagen_producto)
                VALUES ('Producto ejemplo', 'Descripción ejemplo', 100.00, '$target_file')";

        if ($conn->query($sql) === TRUE) {
            echo "La ruta de la imagen ha sido guardada en la base de datos.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Cerrar conexión
        $conn->close();
    } else {
        echo "Lo siento, hubo un error al subir tu archivo.";
    }
}
/*CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre_producto VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    imagen_producto VARCHAR(255) -- Aquí guardamos la ruta de la imagen
);*/
?>
<?php
// Consulta para obtener el producto
/*$sql = "SELECT nombre_producto, descripcion, precio, imagen_producto FROM productos WHERE id_producto = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<h2>" . $row['nombre_producto'] . "</h2>";
        echo "<p>" . $row['descripcion'] . "</p>";
        echo "<p>Precio: $" . $row['precio'] . "</p>";
        echo "<img src='" . $row['imagen_producto'] . "' alt='Imagen del producto'>";
    }
}*/
?>


