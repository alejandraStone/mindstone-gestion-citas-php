<?php 
/*El Modelo es el encargado de interactuar con la base de datos. 
En este caso, se encargará de registrar al usuario en la DDBB
*/
require_once dirname(__DIR__) . '/config/database.php';//llamo al archivo donde realizo la conexión a la DDBB con PDO


class User{
    private $conexion;

    public function __construct($conexion){
        $this->conexion = $conexion;
    }

    //Método para verificar si el email existe
    public function emailExist($email){
        //Consulta para verificar si el email existe
        $query = "SELECT * FROM users WHERE email = :email";
        //llamo a la conexión
        $result = $this->conexion->prepare($query);
        $result->execute(['email' => $email]);

        return $result->fetchColumn() > 0;//devuelve si encuentra filas
    }
    
    public function createUser($name, $lastName, $email, $phone, $password ){
        $query = "INSERT INTO users (name, lastName, email, phone, password) VALUES (:name, :lastName, :email, :phone, :password) ";
        $result = $this->conexion->prepare($query);

         //hasheo la contraseña
         $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

         $result->execute([
            'name' => $name,
            'lastName' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'password' => $hashedPassword,
         ]);
           // Retorna el resultado de la ejecución
            return $result;
    }
}

?>