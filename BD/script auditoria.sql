CREATE SCHEMA seguridad;

CREATE SEQUENCE seguridad.seq_auditoria;

CREATE TABLE seguridad.tauditoria
(
	codigo_auditoria numeric not null default nextval('seguridad.seq_auditoria'),
	usuario_aplicacion char(15),
	usuario_db char(20) not null,
	nombre_esquema varchar(60) not null,
	nombre_tabla varchar(60) not null,
	proceso varchar(60) not null,
	identificador_tabla varchar(30) not null,
	valor_anterior text,
	valor_nuevo text,
	fecha_operacion date not null,
	constraint pk_auditoria primary key(codigo_auditoria)
);

COMMENT ON TABLE seguridad.tauditoria IS 'Registrar todos los eventos relacionados a las modificaciones de registros.';
COMMENT ON COLUMN seguridad.tauditoria.usuario_aplicacion IS 'Identifica el usuario del sistema que efectuo el proceso.';
COMMENT ON COLUMN seguridad.tauditoria.usuario_db IS 'Nombre del usuario del base de datos el cual se conecto y efectuo la operacion.';
COMMENT ON COLUMN seguridad.tauditoria.nombre_esquema IS 'Esquema donde se efectuo la operacion.';
COMMENT ON COLUMN seguridad.tauditoria.nombre_tabla IS 'Identifica la entidad o tabla afectada.';
COMMENT ON COLUMN seguridad.tauditoria.proceso IS 'Identifica la acción [UPDATE, INSERT, DELETE] efectuada al registro de la tabla.';
COMMENT ON COLUMN seguridad.tauditoria.identificador_tabla IS 'Corresponde al identificador del registro que fue afectado.';
COMMENT ON COLUMN seguridad.tauditoria.valor_nuevo IS 'los datos relacionadas al nuevo registro.';
COMMENT ON COLUMN seguridad.tauditoria.valor_anterior IS 'Campos afectados en proceso de los registro anterior.';
COMMENT ON COLUMN seguridad.tauditoria.fecha_operacion IS 'Corresponde la fecha de acción del evento.';

CREATE OR REPLACE FUNCTION auditoria_general()
RETURNS trigger AS
$BODY$
DECLARE

-- @Autor: Gregorio Bolívar
-- @email: elalconxvii@gmail.com
-- @Fecha de Creacion: 11/07/2013
-- @Auditado por: Gregorio J Bolívar B
-- @Fecha de Modificacion: 11/07/2013
-- @Descripción: Funcion de auditoria para todos los sistemas que sean implementado con el sistema libertador(Autenticacion Unica), con el fin de contemplar todos los procesos efectuados por los usuarios dentro del sistema.
-- @version: 0.6
-- @Blog: http://gbbolivar.wordpress.com/

-- Edición y Adaptación de la versión original creada por Gregorio Bolívar --
-- @Editado por: Jorge Colmenarez
-- @email: jlct.master@gmail.com
-- @Fecha de Modificación: 20/09/2014
-- @Motivo Edición: Adaptación al Sistema del Complejo Habitacional Simón Bolívar
-- @versión: 1.0

-- Usuario de base de datos, es requerido que este usuario sea diferente a postgres con el fin de poder identificar si es por sistema o por otra medio
user_access VARCHAR := 'admin';

-- Definicion de los campos relacionados al identificador del usuario, es recomendable que toda tabla tiene que tener identificador del usuario, cuando sea insert o update
user_insert char(15);
user_change char(15);

-- Esta Variable es la que contendra el sql para la tabla tauditoria
sqla TEXT :='';
-- Esta variable contendra el nombre de la columna identificadora de la tabla
record_id RECORD;
-- Esta variable contendra el valor de la columna identificadora de la tabla
id TEXT :='';
BEGIN
	SELECT INTO record_id column_name FROM information_schema.key_column_usage WHERE TABLE_NAME=''||TG_TABLE_NAME||'' AND lower(constraint_name) LIKE '%pk%';
	IF(TG_OP = 'INSERT')THEN
		EXECUTE 'SELECT ($1).' || record_id.column_name || '::text' INTO id USING NEW;
		user_insert = NEW.creado_por;
		IF(CURRENT_USER=user_access)THEN
			sqla='INSERT INTO seguridad.tauditoria(usuario_aplicacion, usuario_db, nombre_esquema, nombre_tabla, proceso, valor_nuevo, identificador_tabla, fecha_operacion) values ('''||user_insert||''', '''|| USER ||''', '''||TG_TABLE_SCHEMA||''' , '''||TG_TABLE_NAME||''' , '''||TG_OP||''', '''||NEW||''' , '''||id||''' , '''|| now() ||''')';
		ELSE
			sqla='INSERT INTO seguridad.tauditoria(usuario_db, nombre_esquema, nombre_tabla, proceso, valor_nuevo, identificador_tabla, fecha_operacion) values ('''|| USER ||''', '''||TG_TABLE_SCHEMA||''' , '''||TG_TABLE_NAME||''' , '''||TG_OP||''', '''||NEW||''' , '''||id||''' , '''|| now() ||''')';
		END IF;
	ELSE
		IF(TG_OP = 'UPDATE')THEN
			EXECUTE 'SELECT ($1).' || record_id.column_name || '::text' INTO id USING NEW;
			user_change = NEW.modificado_por;
			IF(CURRENT_USER=user_access)THEN
				sqla='INSERT INTO seguridad.tauditoria(usuario_aplicacion, usuario_db, nombre_esquema, nombre_tabla, proceso, valor_nuevo, valor_anterior, identificador_tabla, fecha_operacion) values ('''||user_change||''', '''|| USER ||''', '''||TG_TABLE_SCHEMA||''' , '''||TG_TABLE_NAME||''' , '''||TG_OP||''', '''||NEW||''' , '''||OLD||''' , '''||id||''' , '''|| now() ||''')';
            ELSE
				sqla='INSERT INTO seguridad.tauditoria(usuario_db, nombre_esquema, nombre_tabla, proceso, valor_nuevo, valor_anterior, identificador_tabla, fecha_operacion) values ('''|| USER ||''', '''||TG_TABLE_SCHEMA||''' , '''||TG_TABLE_NAME||''' , '''||TG_OP||''', '''||NEW||''' , '''||OLD||''' , '''||id||''' , '''|| now() ||''')';
			END IF;
		END IF;
		IF(TG_OP = 'DELETE')THEN
			EXECUTE 'SELECT ($1).' || record_id.column_name || '::text' INTO id USING OLD;
			IF(CURRENT_USER=user_access)THEN
				sqla='INSERT INTO seguridad.tauditoria(usuario_db, nombre_esquema, nombre_tabla, proceso, valor_anterior, identificador_tabla, fecha_operacion) values ('''|| USER ||''', '''||TG_TABLE_SCHEMA||''' , '''||TG_TABLE_NAME||''' , '''||TG_OP||''', '''||OLD||''' , '''||id||''' , '''|| now() ||''')';
			ELSE
				sqla='INSERT INTO seguridad.tauditoria(usuario_db, nombre_esquema, nombre_tabla, proceso, valor_anterior, identificador_tabla, fecha_operacion) values ('''|| USER ||''', '''||TG_TABLE_SCHEMA||''' , '''||TG_TABLE_NAME||''' , '''||TG_OP||''', '''||OLD||''' , '''||id||''' , '''|| now() ||''')';
			END IF;
		END IF;
	END IF;
	EXECUTE sqla;
	RETURN new;
END;
$BODY$
LANGUAGE plpgsql VOLATILE
COST 100;

-- Modo de uso
CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON tabla_a_auditar
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();