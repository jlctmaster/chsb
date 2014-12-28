CREATE TABLE auditoria.seg_eventos
(
id bigserial NOT NULL,
usuario_id integer, -- Identifica el usuario del sistema que efectuo el proceso.
host character varying(60) NOT NULL,
usuario_db character varying(60) NOT NULL, -- Nombre del usuario del base de datos el cual se conecto y efectuo la operacion.
name_db character varying(60) NOT NULL, -- Corresponde la base de datos al cual fue afectada.
esquema character varying(60) NOT NULL, -- Esquema donde se efectuo la operacion.
entidad character varying(60) NOT NULL, -- Identifica la entidad afectada.
proceso character varying(20) NOT NULL, -- Identifica la accin [UPDATE, INSERT, DELETE] efectuada al registro de la tabla actividades_especiales.
new_values text, -- los datos relacionadas al nuevo registro.
old_values text, -- Campos afectados en proceso de los registro anterior.
entidad_id integer NOT NULL, -- Corresponde al identificador del registro que fue afectado.
fecha timestamp without time zone NOT NULL, -- Corresponde la fecha de accion del evento.
CONSTRAINT seg_evento_id_pk PRIMARY KEY (id )
)
WITH (
OIDS=FALSE
);
ALTER TABLE auditoria.seg_eventos
OWNER TO postgres;
COMMENT ON TABLE auditoria.seg_eventos
IS 'Registrar todos los eventos relacionados a las modificaciones de registros de esta base de datos.';
COMMENT ON COLUMN auditoria.seg_eventos.usuario_id IS 'Identifica el usuario del sistema que efectuo el proceso.';
COMMENT ON COLUMN auditoria.seg_eventos.usuario_db IS 'Nombre del usuario del base de datos el cual se conecto y efectuo la operacion.';
COMMENT ON COLUMN auditoria.seg_eventos.name_db IS 'Corresponde la base de datos al cual fue afectada.';
COMMENT ON COLUMN auditoria.seg_eventos.esquema IS 'Esquema donde se efectuo la operacion.';
COMMENT ON COLUMN auditoria.seg_eventos.entidad IS 'Identifica la entidad afectada.';
COMMENT ON COLUMN auditoria.seg_eventos.proceso IS 'Identifica la accin [UPDATE, INSERT, DELETE] efectuada al registro de la tabla actividades_especiales.';
COMMENT ON COLUMN auditoria.seg_eventos.new_values IS 'los datos relacionadas al nuevo registro.';
COMMENT ON COLUMN auditoria.seg_eventos.old_values IS 'Campos afectados en proceso de los registro anterior.';
COMMENT ON COLUMN auditoria.seg_eventos.entidad_id IS 'Corresponde al identificador del registro que fue afectado.';
COMMENT ON COLUMN auditoria.seg_eventos.fecha IS 'Corresponde la fecha de accion del evento.';


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

-- Variables de configuracion para la conexion con el dblink
db_audi VARCHAR :='auditoria_db';
ip_audi VARCHAR :='ip_base_dato_auditoria';
es_audi VARCHAR :='usuario_remoto_auditoria';
ps_audi VARCHAR :='clave_remota_aiditoria';

-- Usuario de base de datos, es requerido que este usuario sea diferente a postgres con el fin de poder identificar si es por sistema o por otra medio
user_access VARCHAR := 'usuario_local';

-- Definicion de los campos relacionados al identificador del usuario, es recomendable que toda tabla tiene que tener identificador del usuario, cuando sea insert o update
user_id_insert INTEGER ;
user_id_otros INTEGER ;

-- Esta variable es para concatenar la conexion de los valores
conf TEXT :='';
sqla TEXT :='';
BEGIN
conf='hostaddr='''||ip_audi||''' dbname='''||db_audi||''' user='''||es_audi||''' password='''||ps_audi ||'''';
IF(TG_OP = 'INSERT')THEN
user_id_insert = NEW.usuario_created_id;
IF(CURRENT_USER=user_access)THEN
sqla='INSERT INTO auditoria.seg_eventos(usuario_id, host, usuario_db, name_db, esquema, entidad, proceso, new_values, entidad_id, fecha) values ('''||user_id_insert||''', '''|| inet_client_addr() ||''', '''|| USER ||''', '''|| current_database() ||''' , '''|| current_schema() ||''' , '''||TG_TABLE_NAME||''' , '''||TG_OP||''', '''||NEW||''' , '''||NEW.id||''' , '''|| now() ||''')';

ELSE
sqla='INSERT INTO auditoria.seg_eventos(host, usuario_db, name_db, esquema, entidad, proceso, new_values, entidad_id, fecha) values ('''|| inet_client_addr() ||''', '''|| USER ||''', '''|| current_database() ||''' , '''|| current_schema() ||''' , '''||TG_TABLE_NAME||''' , '''||TG_OP||''', '''||NEW||''' , '''||NEW.id||''' , '''|| now() ||''')';

END IF;
ELSE
user_id_otros = OLD.usuario_updated_id;
IF(TG_OP = 'UPDATE')THEN
IF(CURRENT_USER=user_access)THEN
sqla='INSERT INTO auditoria.seg_eventos(usuario_id, host, usuario_db, name_db, esquema, entidad, proceso, new_values, old_values, entidad_id, fecha) values ('''||user_id_otros||''', '''|| inet_client_addr() ||''', '''|| USER ||''', '''|| current_database() ||''' , '''|| current_schema() ||''' , '''||TG_TABLE_NAME||''' , '''||TG_OP||''', '''||NEW||''' , '''||OLD||''' , '''||OLD.id||''' , '''|| now() ||''')';
ELSE
sqla='INSERT INTO auditoria.seg_eventos(host, usuario_db, name_db, esquema, entidad, proceso, new_values, old_values, entidad_id, fecha) values ('''|| inet_client_addr() ||''', '''|| USER ||''', '''|| current_database() ||''' , '''|| current_schema() ||''' , '''||TG_TABLE_NAME||''' , '''||TG_OP||''', '''||NEW||''' , '''||OLD||''' , '''||OLD.id||''' , '''|| now() ||''')';

END IF;
END IF;

IF(TG_OP = 'DELETE')THEN
IF(CURRENT_USER=user_access)THEN
sqla='INSERT INTO auditoria.seg_eventos(usuario_id, host, usuario_db, name_db, esquema, entidad, proceso, old_values, entidad_id, fecha) values ('''||user_id_otros||''', '''|| inet_client_addr() ||''', '''|| USER ||''', '''|| current_database() ||''' , '''|| current_schema() ||''' , '''||TG_TABLE_NAME||''' , '''||TG_OP||''', '''||OLD||''' , '''||OLD.id||''' , '||' now() '||')';
ELSE
sqla='INSERT INTO auditoria.seg_eventos(host, usuario_db, name_db, esquema, entidad, proceso, old_values, entidad_id, fecha) values ('''||inet_client_addr() ||''', '''|| USER ||''', '''|| current_database() ||''' , '''|| current_schema() ||''' , '''||TG_TABLE_NAME||''' , '''||TG_OP||''', '''||OLD||''' , '''||OLD.id||''' , '||' now() '||')';

END IF;
END IF;
END IF;
PERFORM dblink_exec(''||conf||'',''||sqla||'');
return new;
END;
$BODY$
LANGUAGE plpgsql VOLATILE
COST 100;


CREATE TRIGGER auditoria_origen
AFTER INSERT OR UPDATE OR DELETE
ON tabla_a_auditar
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();