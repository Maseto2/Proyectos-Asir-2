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
