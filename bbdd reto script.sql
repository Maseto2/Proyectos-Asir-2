drop database if exists velodromo;
create database if not exists velodromo;
set foreign_key_checks = 0;
use velodromo;
create table if not exists vuelta (
id int primary key not null auto_increment,
id_usuario int,
fecha date,
tiempo time(3)
);
create table if not exists ciclista (
id int not null auto_increment,
id_equipo int,
id_usuario int,
primary key (id, id_usuario),
UNIQUE KEY unique_usuario (id_usuario)
);
create table if not exists equipo (
id int primary key not null auto_increment,
nombre varchar (255)
);
create table if not exists usuario (
id int primary key not null auto_increment,
nombre varchar(255),
apellido varchar(255),
nombre_usuario varchar(255),
contrasena varchar(255),
mail varchar(255),
id_rol int
);
create table if not exists rol (
id int not null primary key,
rol varchar(255),
pass int
);
create table if not exists fallidos (
nombre varchar(255),
contrasena varchar(255)
);
create table if not exists historicos(
nombre varchar(255),
contrasena varchar(255),
ultimaconexion datetime
);
ALTER TABLE vuelta ADD CONSTRAINT fk_usuario FOREIGN KEY (id_usuario) REFERENCES usuario (id) on delete cascade;
ALTER TABLE ciclista ADD CONSTRAINT fk_idequipo FOREIGN KEY (id_equipo) REFERENCES equipo (id);
ALTER TABLE ciclista ADD CONSTRAINT fk_idusuario FOREIGN KEY (id_usuario) REFERENCES usuario (id)  on delete cascade;
ALTER TABLE usuario ADD CONSTRAINT fk_idrol FOREIGN KEY (id_rol) REFERENCES rol (id);
insert into rol values (1, "Admin", "410113");
insert into rol (id, rol) values (2, "Usuario");
insert into equipo values (1, "Biciclistas");
insert into usuario values (1, "Administrador", "Administrador", "Administrador", "410113", "administrador@gmail.com","1")
/**Triggers y funciones**/
DELIMITER //

CREATE TRIGGER insertarfecha
before INSERT
ON vuelta FOR EACH ROW

BEGIN
    SET NEW.fecha = NOW();
END;

//


DELIMITER //

CREATE PROCEDURE ObtenerGanadorPorFecha(IN fecha_consulta DATE)
BEGIN
    SELECT
        usuario.nombre AS nombre_usuario,
        SUM(vuelta.tiempo) AS tiempo_total
    FROM
        usuario
    JOIN
        vuelta ON usuario.id = vuelta.id_usuario
    WHERE
        DATE(vuelta.fecha) = fecha_consulta
    GROUP BY
        usuario.id, usuario.nombre
    ORDER BY
        tiempo_total ASC
    LIMIT 1;
END //

DELIMITER ;
/* Este procedimiento revisa si el usuario ya esta registrado o no, en caso de no estar registrado en la bbdd guardará el usuario y  la contraseña 
en la tabla fallidos, en caso de estar registrado, actualizará la tabla historicos con la fecha de conexion*/
DELIMITER //

CREATE PROCEDURE proclogin(
    IN varnombre VARCHAR(255),
    IN varcontrasena VARCHAR(255)
)
BEGIN
    DECLARE usuarioalta INT;

    -- Verificar si el usuario ya está registrado
    SELECT COUNT(*) INTO usuarioalta FROM usuario WHERE nombre = varnombre;

    IF usuarioalta = 0 THEN
        -- Insertar el usuario fallido en la tabla fallidos
        INSERT INTO fallidos (nombre, contrasena) VALUES (varnormbre, varcontrasena);
    ELSE
        -- Actualizar la fecha de conexión del usuario existente en la tabla 'historicos'
        UPDATE historicos SET ultimaconexion = NOW() WHERE nombre = varnormbre;
    END IF;
END //

DELIMITER ;

/* creamos una vista desde la cual sacamos los valores de la taba usuario */
CREATE VIEW usadores AS (select nombre as nombre_usuario, contrasena as contrasena_usuario, mail as contacto from usuario where nombre like '%');

/* La funcion vera en cuanto tiempo se ha completado la vuelta hecha */
DELIMITER //

CREATE FUNCTION tiempovuelta(fechaVuelta DATETIME) RETURNS varchar(255)
BEGIN
    DECLARE resultado varchar(255);

    -- Verificar si una vuelta se ha realizado en menos de 1 minuto
    IF (select max(fecha) from vuleta) > NOW() - INTERVAL 3 MINUTE THEN
        SET resultado = 'Vuelta rápida';
    ELSE
        SET resultado = 'Puedes mejorar este tiempo, vulve a intetarlo';
    END IF;

    RETURN resultado;
END //

DELIMITER ;
