/*procedimiento al que llamara el trigger*/
DELIMITER //
CREATE PROCEDURE generarCSV()
BEGIN
    SELECT *
    INTO OUTFILE '/ruta/del/archivo/resultados.csv'
    FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
    LINES TERMINATED BY '\n'
    FROM tu_tabla;
END //
DELIMITER ;

/*Trigger que llama al procedimiento*/
CREATE TRIGGER Trigger_correo
AFTER INSERT ON tu_tabla
FOR EACH ROW
BEGIN
    CALL generarCSV();
END;