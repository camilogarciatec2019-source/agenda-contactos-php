# agenda-contactos-php

# Agenda Personal de Contactos con Autenticación en PHP

## 📄 Descripción del Proyecto
Este proyecto es una aplicación web dinámica desarrollada en **PHP y MySQL** como parte del componente de **Aprendizaje en Contacto con el Docente (ACD)** para la asignatura de Desarrollo Web en la UTPL.

La aplicación permite a los usuarios registrarse, iniciar sesión de forma segura y gestionar una **agenda de contactos personal (CRUD)**. El sistema garantiza el aislamiento estricto de los datos: cada usuario autenticado solo puede visualizar, crear, editar y eliminar sus propios contactos sin posibilidad de acceder a la información de otros usuarios.

---

## 🛠️ Tecnologías Utilizadas
* **Lenguaje Backend:** PHP (versión 7.4 / 8.x)
* **Base de Datos:** MySQL / MariaDB (gestión con phpMyAdmin)
* **Servidor Web:** Apache (entorno local con XAMPP)
* **Frontend:** HTML5, CSS3, JavaScript (alertas de confirmación)
* **Control de Versiones:** Git & GitHub

---

## 📂 Estructura del Proyecto
```text
agenda-contactos-php/
│
├── conexion.php           # Configuración de conexión MySQLi / PDO
├── schema.sql             # Script SQL de creación de la BD y tablas
├── registro.php           # Formulario y procesamiento de registro de usuarios
├── login.php              # Autenticación y creación de sesión
├── dashboard.php          # Panel principal con el listado de contactos del usuario
├── guardar_contacto.php   # Formulario y procesamiento para crear contactos
├── editar_contacto.php    # Modificación de contactos (valida propiedad)
├── eliminar_contacto.php  # Eliminación segura de contactos
├── logout.php            # Destrucción de sesión y redirección
└── README.md              # Documentación del proyecto
