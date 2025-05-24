<?php
//para probar el hash de la contraseña y podre crear un usuario administrador de primeras en la base de datos
echo password_hash("12345", PASSWORD_DEFAULT);
?>