# 🧘‍♀️ MindStone Pilates Center Web App

Aplicación web desarrollada para la gestión integral de un centro de Pilates. Permite a los usuarios registrarse, comprar bonos, reservar clases semanales o mensuales y gestionar su perfil, mientras que el administrador puede gestionar coaches, clases, usuarios y reservas desde un panel de control centralizado.

---

## 🧩 Arquitectura de la Aplicación

### Diagrama Visual
![Diagrama](/public/img/diagrama_arquitectura_mindSone.png)

### Modelo de Capas Utilizado

La arquitectura sigue un modelo MVC por capas funcionales, adaptado a una web tradicional con componentes dinámicos. Se ha buscado mantener una separación clara de responsabilidades para mejorar la escalabilidad y el mantenimiento del sistema.

- **Capa de Presentación (Frontend/Vista):**
  - Basada en archivos .php renderizados desde el servidor.
  - Estilizado moderno con TailwindCSS.
  - Lógica de interacción manejada mediante JavaScript modular, con uso de fetch para comunicación asincrónica.
  - En la parte administrativa se utiliza un comportamiento SPA, donde se actualiza contenido de forma dinámica con JavaScript, sin recargar toda la página.
  
- **Capa de Lógica de Negocio (Controladores PHP):**
  - Los controladores reciben y procesan peticiones desde el frontend.
  - Cada controlador está vinculado al flujo de una vista concreta.
  - Validaciones server-side, control de errores estructurado y respuestas en JSON estandarizadas.
  - Seguimiento de buenas prácticas de seguridad, manejo de errores y separación de responsabilidades.

- **Capa de Datos (Modelos PHP + MySQL):**
  - Uso de modelos PHP reutilizables con conexión segura mediante una función central `getPDO()`.
  - Los modelos encapsulan la lógica de acceso a datos (SELECT, INSERT, UPDATE, DELETE), evitando SQL en controladores.
  - Estructura clara con entidades como `users`, `coaches`, `credits`, `class_instances`, etc.
  - Integridad referencial y relaciones bien definidas mediante claves foráneas.

### 📁 Estructura del Proyecto

```
/mindStone
├── 📂app/
│   ├── controllers/
│   ├── models/
│   └── views/
│       └── layout/
│       └── admin/
│       └── user/
│         └── pages/
├── 📂public/
│   ├── img/
│   └── inicio.php
├── 📂config/
│   └── database.php
└── README.md
```

---

## 🔧 Configuración de Apache (VirtualHost) en AWS EC2

A continuación se describen los pasos realizados para instalar Apache, configurar el VirtualHost y desplegar el proyecto en la nube.  
**Nota:** Para todo esto, primero se debe conectar por SSH a la instancia.

### 1. Actualizar los paquetes del sistema
```bash
sudo apt update
sudo apt upgrade -y
```

### 2. Instalar Apache
```bash
sudo apt install apache2 -y
```

### 3. Verificar que Apache está funcionando
Abrir un navegador y acceder a la IP pública de la instancia:
```
http://<IP_PUBLICA>
```
Debería aparecer la página de bienvenida de Apache.

### 4. Subir los archivos del proyecto a la carpeta del sitio web
Copiar los archivos a la ruta:
```
/var/www/html/
```
Se puede utilizar `scp`, `sftp` o copiar manualmente los archivos a esa carpeta.

### 5. Configurar el VirtualHost de Apache
Crear o editar el archivo de configuración. En este caso se edita el archivo por defecto:
```bash
sudo nano /etc/apache2/sites-available/000-default.conf
```
Insertar la siguiente configuración:

![Captura de la instancia EC2 en la consola de AWS](/public/img/config_apache.png)

**Nota:** Actualmente se accede mediante la IP elástica, pero en el futuro se puede añadir un dominio fácilmente.
Guardar y cerrar el archivo.

### 6. Activar el sitio por defecto
```bash
sudo a2ensite 000-default.conf
```

### 7. Recargar Apache para aplicar los cambios
```bash
sudo systemctl reload apache2
```

### 8. (Opcional) Abrir el puerto 80 en el firewall de la instancia AWS EC2
En la consola de AWS, agregar una regla de entrada al grupo de seguridad de la instancia para permitir el tráfico HTTP (puerto 80).

Con estos pasos, Apache quedará funcionando y el sitio será accesible desde Internet usando la IP pública o elástica de la instancia.

---

## 🖥️ Instancia EC2 utilizada

### Tipo de instancia y características

- **Tipo de instancia:** t2.micro  
- **vCPU:** 1  
- **RAM:** 1 GB  
- **Almacenamiento:** 8 GB (EBS, SSD)  
- **Sistema operativo:** Ubuntu Server 22.04 LTS  
- **Zona de disponibilidad:** eu-west-1a  
- **Software instalado:** Apache2, PHP, MySQL Server  
- **Dirección IP pública/Elastic IP:**  
![Captura de la instancia EC2 en la consola de AWS](/public/img/instancia_EC2.png)

### Herramientas y protocolos utilizados

#### 🔑 SSH
Desde la terminal, se debe ejecutar el siguiente comando, reemplazando `llave.pem` y la `IP pública` que te da AWS por los valores correspondientes de la instancia:
```bash
ssh -i "llave.pem" ubuntu@[DIRECCION_IP]
```

#### 📦 SCP
Para subir el código fuente desde la máquina local:
```bash
scp -i /ruta/a/la/llave.pem -r /ruta/al/proyecto ubuntu@[DIRECCION_IP]:/var/www/html/
```
Una vez dentro de la instancia, ejecutar los siguientes comandos:
```bash
sudo apt update
sudo apt install unzip
unzip mindStone.zip -d mindStone
sudo mv mindStone /var/www/html
```

---
