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

         //hasheo la contraseña antes de insertarla en la BD
         $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

         if ($result->execute([
            'name' => $name,
            'lastName' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'password' => $hashedPassword,
        ])) {
            return true; // Se insertó correctamente
        } else {
            return false; // Hubo un error
        }
    }

    //método para iniciar sesión una vez validados los datos del usuario
    public function login($email){
        $query = "SELECT * FROM users WHERE email = :email";
        $result = $this->conexion->prepare($query);
        $result->execute(['email' => $email]);
    
       return $result->fetch(PDO::FETCH_ASSOC); // Obtener usuario de la base de datos, me devuelve array asoc  
    }
}
    

?>