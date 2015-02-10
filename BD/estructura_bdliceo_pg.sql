-- Trigger for the auditories

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

-- End Trigger

-- Functions for Inventory

-- First / Last (aggregate)
-- This is a portable SQL-language implementation with no external dependencies.
-- Create a function that always returns the first non-NULL item
CREATE OR REPLACE FUNCTION public.first_agg ( anyelement, anyelement )
RETURNS anyelement LANGUAGE sql IMMUTABLE STRICT AS $$
        SELECT $1;
$$;
 
-- And then wrap an aggregate around it
CREATE AGGREGATE public.first (
        sfunc    = public.first_agg,
        basetype = anyelement,
        stype    = anyelement
);
 
-- Create a function that always returns the last non-NULL item
CREATE OR REPLACE FUNCTION public.last_agg ( anyelement, anyelement )
RETURNS anyelement LANGUAGE sql IMMUTABLE STRICT AS $$
        SELECT $2;
$$;
 
-- And then wrap an aggregate around it
CREATE AGGREGATE public.last (
        sfunc    = public.last_agg,
        basetype = anyelement,
        stype    = anyelement
);
-- Credit: http://archives.postgresql.org/pgsql-hackers/2006-03/msg01324.php with a couple of corrections.

-- End Functions

-- General

CREATE SCHEMA general;

CREATE SEQUENCE general.seq_pais;

CREATE TABLE general.tpais
(
	codigo_pais numeric not null default nextval('general.seq_pais'),
	descripcion varchar(60) not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_pais primary key(codigo_pais)
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON general.tpais
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE general.seq_estado;

CREATE TABLE general.testado
(
	codigo_estado numeric not null default nextval('general.seq_estado'),
	codigo_pais numeric not null,
	descripcion varchar(60) not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_estado primary key(codigo_estado),
	constraint fk_estado_pais foreign key(codigo_pais) references general.tpais(codigo_pais) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON general.testado
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE general.seq_municipio;

CREATE TABLE general.tmunicipio
(
	codigo_municipio numeric not null default nextval('general.seq_municipio'),
	codigo_estado numeric not null,
	descripcion varchar(60) not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_municipio primary key(codigo_municipio),
	constraint fk_municipio_estado foreign key(codigo_estado) references general.testado(codigo_estado) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON general.tmunicipio
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE general.seq_parroquia;

CREATE TABLE general.tparroquia
(
	codigo_parroquia numeric not null default nextval('general.seq_parroquia'),
	codigo_municipio numeric not null,
	descripcion varchar(60) not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_parroquia primary key(codigo_parroquia),
	constraint fk_parroquia_municipio foreign key(codigo_municipio) references general.tmunicipio(codigo_municipio) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON general.tparroquia
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE TABLE general.torganizacion
(
	rif_organizacion char(10) not null,
	nombre varchar(50) not null,
	direccion varchar(255) not null,
	telefono varchar(15) not null,
	tipo_organizacion char(1) not null default '0',
	codigo_parroquia numeric not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_organizacion primary key(rif_organizacion),
	constraint fk_organizacion_parroquia foreign key(codigo_parroquia) references general.tparroquia(codigo_parroquia) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON general.torganizacion
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE general.seq_tipo_persona;

CREATE TABLE general.ttipo_persona
(
	codigo_tipopersona numeric not null default nextval('general.seq_tipo_persona'),
	descripcion varchar(40) not null,
	es_usuariosistema char(1) not null default 'N',
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_tipo_persona primary key(codigo_tipopersona)
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON general.ttipo_persona
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();


CREATE TABLE general.tpersona
(
	cedula_persona char(10) not null,
	primer_nombre varchar(20) not null,
	segundo_nombre varchar(20),
	primer_apellido varchar(20) not null,
	segundo_apellido varchar(20),
	sexo char(1) not null default 'F',
	fecha_nacimiento date not null,
	lugar_nacimiento numeric not null,
	direccion varchar(255) not null,
	telefono_local varchar(15) not null,
	telefono_movil varchar(15),
  	profesion varchar(60),
  	grado_instruccion varchar(20),
	codigo_tipopersona numeric not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_persona primary key(cedula_persona),
	constraint fk_persona_parroquia foreign key(lugar_nacimiento) references general.tparroquia(codigo_parroquia) on delete restrict on update cascade,
	constraint fk_persona_codigo_tipopersona foreign key(codigo_tipopersona) references general.ttipo_persona(codigo_tipopersona) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON general.tpersona
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();


CREATE SEQUENCE general.seq_parentesco;

CREATE TABLE general.tparentesco
(
	codigo_parentesco numeric not null default nextval('general.seq_parentesco'),
	descripcion varchar(30) not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_parentesco primary key(codigo_parentesco)
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON general.tparentesco
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();


CREATE SEQUENCE general.seq_departamento;

CREATE TABLE general.tdepartamento
(
	codigo_departamento numeric not null default nextval('general.seq_departamento'),
	descripcion varchar(40) not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_departamento primary key(codigo_departamento)
);


CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON general.tdepartamento
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();


CREATE SEQUENCE general.seq_area;

CREATE TABLE general.tarea
(
	codigo_area numeric not null default nextval('general.seq_area'),
	descripcion varchar(40) not null,
	codigo_departamento numeric not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_area primary key(codigo_area),
	constraint fk_area_departamento foreign key(codigo_departamento) references general.tdepartamento(codigo_departamento) on delete restrict on update cascade
);


CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON general.tarea
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();


CREATE SEQUENCE general.seq_ambiente;

CREATE TABLE general.tambiente
(
	codigo_ambiente numeric not null default nextval('general.seq_ambiente'),
	descripcion varchar(60) not null,
	tipo_ambiente char(1) not null default '0',
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_ambiente primary key(codigo_ambiente)
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON general.tambiente
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE general.seq_det_familiar;

CREATE TABLE general.tdetalle_familiar
(
	codigo_detalle_familiar numeric NOT NULL DEFAULT nextval('general.seq_det_familiar'::regclass),
	cedula_persona char(10) NOT NULL,
	cedula_familiar char(10) NOT NULL,
	codigo_parentesco numeric NOT NULL,
	es_representantelegal char(1) NOT NULL DEFAULT 'N',
	estatus char(1) NOT NULL DEFAULT '1',
	creado_por char(15) NOT NULL,
	fecha_creacion timestamp without time zone,
	modificado_por char(15),
	fecha_modificacion timestamp without time zone DEFAULT NOW(),
	CONSTRAINT pk_detalle_familiar PRIMARY KEY (codigo_detalle_familiar),
	CONSTRAINT fk_detalle_familiar_estudiante FOREIGN KEY (cedula_persona) REFERENCES general.tpersona (cedula_persona) ON UPDATE CASCADE ON DELETE RESTRICT,
	CONSTRAINT fk_detalle_familiar_familiar FOREIGN KEY (cedula_familiar) REFERENCES general.tpersona (cedula_persona) ON UPDATE CASCADE ON DELETE RESTRICT,
	CONSTRAINT fk_detalle_familiar_parentesco FOREIGN KEY (codigo_parentesco) REFERENCES general.tparentesco (codigo_parentesco) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON general.tdetalle_familiar
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

-- Fin General

-- Inventario

CREATE SCHEMA inventario;

CREATE SEQUENCE inventario.seq_ubicacion;

CREATE TABLE inventario.tubicacion
(
	codigo_ubicacion numeric not null default nextval('inventario.seq_ubicacion'),
	descripcion varchar(40) not null,
	codigo_ambiente numeric not null,
	itemsdefectuoso char(1) not null default 'N',
	ubicacionprincipal char(1) not null default 'N',
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_ubicacion primary key(codigo_ubicacion),
	constraint fk_ubicacion_ambiente foreign key(codigo_ambiente) references general.tambiente(codigo_ambiente) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON inventario.tubicacion
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();


CREATE SEQUENCE inventario.seq_adquisicion;

CREATE TABLE inventario.tadquisicion
(
	codigo_adquisicion numeric not null default nextval('inventario.seq_adquisicion'),
	fecha_adquisicion date not null,
	tipo_adquisicion char(1) not null,
	rif_organizacion char(10) not null,
	cedula_persona char(10) not null,
	sonlibros char(1) not null default 'N',
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_adquisicion primary key(codigo_adquisicion),
	constraint fk_adquisicion_organizacion foreign key(rif_organizacion) references general.torganizacion(rif_organizacion) on delete restrict on update cascade,
	constraint fk_adquisicion_persona foreign key(cedula_persona) references general.tpersona(cedula_persona) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON inventario.tadquisicion
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE inventario.seq_det_adquisicion;

CREATE TABLE inventario.tdetalle_adquisicion
(
	codigo_detalle_adquisicion numeric not null default nextval('inventario.seq_det_adquisicion'),
	codigo_adquisicion numeric not null,
	codigo_item numeric not null,
	cantidad numeric not null,
	codigo_ubicacion numeric not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_det_adq primary key(codigo_detalle_adquisicion),
	constraint fk_det_adq_adquisicion foreign key(codigo_adquisicion) references inventario.tadquisicion(codigo_adquisicion) on delete restrict on update cascade,
	constraint fk_det_adq_ubicacion foreign key(codigo_ubicacion) references inventario.tubicacion(codigo_ubicacion) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON inventario.tdetalle_adquisicion
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE INDEX tdetalle_adquisicion_idx_1 ON inventario.tdetalle_adquisicion(codigo_item);

CREATE SEQUENCE inventario.seq_movimiento;

CREATE TABLE inventario.tmovimiento
(
	codigo_movimiento numeric not null default nextval('inventario.seq_movimiento'),
	fecha_movimiento timestamp NOT NULL default current_timestamp,
	tipo_movimiento char(1) not null default 'E',
	numero_documento numeric not null,
	tipo_transaccion char(2) not null default 'IA',
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_movimiento primary key(codigo_movimiento)
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON inventario.tmovimiento
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE INDEX tmovimiento_idx_1 ON inventario.tmovimiento(numero_documento);

CREATE SEQUENCE inventario.seq_det_movimiento;

CREATE TABLE inventario.tdetalle_movimiento
(
	codigo_detalle_movimiento numeric not null default nextval('inventario.seq_det_movimiento'),
	codigo_movimiento numeric not null,
	codigo_item numeric not null,
	codigo_ubicacion numeric not null,
	cantidad_movimiento numeric not null,
	valor_anterior numeric not null,
	valor_actual numeric not null,
	sonlibros char(1) not null default 'N',
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_det_mov primary key(codigo_detalle_movimiento),
	constraint fk_det_mov_movimiento foreign key(codigo_movimiento) references inventario.tmovimiento(codigo_movimiento) on delete restrict on update cascade,
	constraint fk_det_mov_ubicacion foreign key(codigo_ubicacion) references inventario.tubicacion(codigo_ubicacion) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON inventario.tdetalle_movimiento
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE INDEX tdetalle_movimiento_idx_1 ON inventario.tdetalle_movimiento(codigo_item);

-- Fin Inventario

-- Educacion

CREATE SCHEMA educacion;

CREATE SEQUENCE educacion.seq_bloque_hora;

CREATE TABLE educacion.tbloque_hora (
	codigo_bloque_hora numeric not null default nextval('educacion.seq_bloque_hora'),
	hora_inicio time not null,
	hora_fin time not null,
	turno char(1) not null default 'M',
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_bloque_hora primary key(codigo_bloque_hora)
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON educacion.tbloque_hora
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE educacion.seq_ano_academico;

CREATE TABLE educacion.tano_academico (
	codigo_ano_academico numeric not null default nextval('educacion.seq_ano_academico'),
	ano char(8) not null,
	estatus char(1) not null default '1',
	cerrado char(1) not null default 'Y',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_ano_academico primary key(codigo_ano_academico)
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON educacion.tano_academico
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE educacion.seq_lapso;

CREATE TABLE educacion.tlapso (
	codigo_lapso numeric not null default nextval('educacion.seq_lapso'),
	lapso char(3) not null,
	codigo_ano_academico numeric not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_lapso primary key(codigo_lapso),
	constraint fk_lapso_ano_academico foreign key(codigo_ano_academico) references educacion.tano_academico(codigo_ano_academico) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON educacion.tlapso
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE TABLE educacion.tmateria (
	codigo_materia char(7) not null,
	nombre_materia varchar(200) not null,
	unidad_credito numeric not null,
	tipo_materia char(1) not null default '0',
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_materia primary key(codigo_materia)
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON educacion.tmateria
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE educacion.seq_periodo;

CREATE TABLE educacion.tperiodo (
	codigo_periodo numeric not null default nextval('educacion.seq_periodo'),
	descripcion varchar(45) not null,
	fecha_inicio date not null,
	fecha_fin date not null,
	codigo_lapso numeric null,
	esinscripcion char(1) not null default '0',
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_periodo primary key(codigo_periodo),
	constraint fk_periodo_lapso foreign key(codigo_lapso) references educacion.tlapso(codigo_lapso) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON educacion.tperiodo
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE TABLE educacion.tseccion (
 	seccion char(5) not null,
 	nombre_seccion varchar(10) not null,
 	turno char(1) not null default 'M',
 	capacidad_min numeric not null,
 	capacidad_max numeric not null,
  	indice_min numeric NOT NULL Default 0,
	indice_max numeric NOT NULL Default 0,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
 	constraint pk_seccion primary key(seccion)
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON educacion.tseccion
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE educacion.seq_materia_seccion;

CREATE TABLE educacion.tmateria_seccion (
 	codigo_materia_seccion numeric not null default nextval('educacion.seq_materia_seccion'),
 	codigo_materia char(7) not null,
 	seccion char(5) not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
 	constraint pk_mat_sec primary key(codigo_materia_seccion),
 	constraint fk_mat_sec_materia foreign key(codigo_materia) references educacion.tmateria(codigo_materia) on delete restrict on update cascade,
 	constraint fk_mat_sec_seccion foreign key(seccion) references educacion.tseccion(seccion) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON educacion.tmateria_seccion
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE educacion.seq_inscrito_seccion;

CREATE TABLE educacion.tinscrito_seccion (
	codigo_inscrito_seccion numeric not null default nextval('educacion.seq_inscrito_seccion'),
 	cedula_persona char(10) not null,
 	seccion char(5) not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
 	constraint pk_ins_sec primary key(codigo_inscrito_seccion),
 	constraint fk_ins_sec_persona foreign key(cedula_persona) references general.tpersona(cedula_persona) on delete restrict on update cascade,
 	constraint fk_ins_sec_seccion foreign key(seccion) references educacion.tseccion(seccion) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON educacion.tinscrito_seccion
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE educacion.seq_inscripcion;

CREATE TABLE educacion.tinscripcion (
 	codigo_inscripcion numeric not null default nextval('educacion.seq_inscripcion'), 
 	codigo_periodo numeric not null,
 	fecha_cierre date not null,
	estatus char(1) not null default '1',
	cerrado char(1) not null default 'Y',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
 	constraint pk_inscripcion primary key(codigo_inscripcion),
 	constraint fk_inscripcion_periodo foreign key(codigo_periodo) references educacion.tperiodo(codigo_periodo) on delete restrict on update cascade
);
CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON educacion.tinscripcion
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE educacion.seq_horario_profesor;

CREATE TABLE educacion.thorario_profesor (
 	codigo_horario_profesor numeric not null default nextval('educacion.seq_horario_profesor'),
 	seccion char(5) not null,
 	cedula_persona char(10) not null,
 	codigo_materia char(7) not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
 	constraint pk_hora_prof primary key(codigo_horario_profesor),
 	constraint fk_hora_prof_seccion foreign key(seccion) references educacion.tseccion(seccion) on delete restrict on update cascade,
 	constraint fk_hora_prof_persona foreign key(cedula_persona) references general.tpersona(cedula_persona) on delete restrict on update cascade,
 	constraint fk_hora_prof_materia foreign key(codigo_materia) references educacion.tmateria(codigo_materia) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON educacion.thorario_profesor
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE educacion.seq_horario;

CREATE TABLE educacion.thorario (
	codigo_horario numeric not null default nextval('educacion.seq_horario'),
 	codigo_bloque_hora numeric not null,
 	codigo_ambiente numeric not null,
 	codigo_horario_profesor numeric not null,
 	dia numeric not null,
  	codigo_ano_academico numeric NOT NULL,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
 	constraint pk_horario primary key(codigo_horario),
 	constraint fk_horario_bloque_hora foreign key(codigo_bloque_hora) references educacion.tbloque_hora(codigo_bloque_hora) on delete restrict on update cascade,
 	constraint fk_horario_ambiente foreign key(codigo_ambiente) references general.tambiente(codigo_ambiente) on delete restrict on update cascade,
 	constraint fk_horario_hora_prof foreign key(codigo_horario_profesor) references educacion.thorario_profesor(codigo_horario_profesor) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON educacion.thorario
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE educacion.seq_proceso_inscripcion;

CREATE TABLE educacion.tproceso_inscripcion (
	codigo_proceso_inscripcion numeric not null default nextval('educacion.seq_proceso_inscripcion'),
 	codigo_inscripcion numeric not null,
 	fecha_inscripcion date not null,
 	codigo_ano_academico numeric not null,
 	cedula_responsable char(10) not null,
 	cedula_persona char(10) not null,
	anio_a_cursar char(1) NOT NULL default '1',
	coordinacion_pedagogica char(1) NOT NULL default '1',
 	estado_salud char(1) not null default '1',
 	alergico char(1) not null default 'N',
 	impedimento_deporte char(1) not null default 'N',
 	especifique_deporte varchar(40) default null,
 	practica_deporte char(1) not null default 'N',
 	cual_deporte varchar(40) default null,
 	tiene_beca char(1) not null default 'N',
 	organismo varchar(60) default null,
	tiene_hermanos char(1) NOT NULL default 'N',
 	numero_hermanos numeric not null default 0,
 	cuantos_varones numeric not null default 0,
 	cuantas_hembras numeric not null default 0,
 	estudian_aca char(1) not null default 'N',
 	que_anio char(1) default null,
 	peso numeric not null default 0,
 	talla numeric not null default 0,
 	indice numeric not null default 0,
 	tiene_talento char(1) not null default 'N',
 	cual_talento varchar(50) default null,
 	cedula_padre char(10) default null,
 	cedula_madre char(10) default null,
 	cedula_representante char(10) default null,
 	codigo_parentesco numeric null,
 	integracion_escuela_comunidad char(1) not null default '9',
 	especifique_integracion varchar(60) default null,
 	seccion char(5) null,
 	observacion varchar(255) default null,
 	estatus char(1) not null default '1',
	procesado char(1) NOT NULL default 'N',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
 	constraint pk_pro_ins primary key(codigo_proceso_inscripcion),
 	constraint fk_pro_ins_inscripcion foreign key(codigo_inscripcion) references educacion.tinscripcion(codigo_inscripcion) on delete restrict on update cascade,
 	constraint fk_pro_ins_ano_academico foreign key(codigo_ano_academico) references educacion.tano_academico(codigo_ano_academico) on delete restrict on update cascade,
 	constraint fk_pro_ins_responsable foreign key(cedula_responsable) references general.tpersona(cedula_persona) on delete restrict on update cascade,
 	constraint fk_pro_ins_persona foreign key(cedula_persona) references general.tpersona(cedula_persona) on delete restrict on update cascade,
 	constraint fk_pro_ins_padre foreign key(cedula_padre) references general.tpersona(cedula_persona) on delete restrict on update cascade,
 	constraint fk_pro_ins_madre foreign key(cedula_madre) references general.tpersona(cedula_persona) on delete restrict on update cascade,
 	constraint fk_pro_ins_representante foreign key(cedula_representante) references general.tpersona(cedula_persona) on delete restrict on update cascade,
 	constraint fk_pro_ins_parentesco foreign key(codigo_parentesco) references general.tparentesco(codigo_parentesco) on delete restrict on update cascade,
 	constraint fk_pro_ins_seccion foreign key(seccion) references educacion.tseccion(seccion) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON educacion.tproceso_inscripcion
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

-- Fin Educacion

-- Bienes Nacionales

CREATE SCHEMA bienes_nacionales;

CREATE SEQUENCE bienes_nacionales.seq_tipo_bien;

CREATE TABLE bienes_nacionales.ttipo_bien
(
	codigo_tipo_bien numeric not null default nextval('bienes_nacionales.seq_tipo_bien'),
	descripcion varchar(35) not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_tipo_bien primary key(codigo_tipo_bien)
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON bienes_nacionales.ttipo_bien
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE bienes_nacionales.seq_bien;

CREATE TABLE bienes_nacionales.tbien
(
	codigo_bien numeric not null default nextval('bienes_nacionales.seq_bien'),
	nombre varchar(40) not null,
	nro_serial varchar(45) not null,
	codigo_tipo_bien numeric not null,
	esconfigurable character(1) NOT NULL DEFAULT 'N',
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_bien primary key(codigo_bien),
	constraint fk_bien_tipo_bien foreign key(codigo_tipo_bien) references bienes_nacionales.ttipo_bien(codigo_tipo_bien) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON bienes_nacionales.tbien
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE bienes_nacionales.seq_configuracion_bien;

CREATE TABLE bienes_nacionales.tconfiguracion_bien
(
	codigo_configuracion_bien numeric not null default nextval('bienes_nacionales.seq_configuracion_bien'),
	codigo_bien numeric not null,
	codigo_item numeric not null,
	cantidad numeric not null,
	item_base char(1) not null default 'N',
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_conf_bien primary key(codigo_configuracion_bien),
	constraint fk_conf_bien_bien foreign key(codigo_bien) references bienes_nacionales.tbien(codigo_bien) on delete restrict on update cascade,
	constraint fk_conf_bien_item foreign key(codigo_item) references bienes_nacionales.tbien(codigo_bien) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON bienes_nacionales.tconfiguracion_bien
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE bienes_nacionales.seq_asignacion;

CREATE TABLE bienes_nacionales.tasignacion
(
	codigo_asignacion numeric not null default nextval('bienes_nacionales.seq_asignacion'),
	fecha_asignacion date not null,
	cedula_persona char(10) not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_asignacion primary key(codigo_asignacion),
	constraint fk_asignacion_persona foreign key(cedula_persona) references general.tpersona(cedula_persona) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON bienes_nacionales.tasignacion
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE bienes_nacionales.seq_det_asignacion;

CREATE TABLE bienes_nacionales.tdetalle_asignacion
(
	codigo_detalle_asignacion numeric not null default nextval('bienes_nacionales.seq_det_asignacion'),
	codigo_asignacion numeric not null,
	codigo_ubicacion numeric not null,
	codigo_ubicacion_hasta numeric not null,
	codigo_item numeric not null,
	cantidad numeric not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_det_asig primary key(codigo_detalle_asignacion),
	constraint fk_det_asig_asignacion foreign key(codigo_asignacion) references bienes_nacionales.tasignacion(codigo_asignacion) on delete restrict on update cascade,
	constraint fk_det_asig_ubicacion foreign key(codigo_ubicacion) references inventario.tubicacion(codigo_ubicacion) on delete restrict on update cascade,
	constraint fk_det_asig_ubicacion_hasta foreign key(codigo_ubicacion_hasta) references inventario.tubicacion(codigo_ubicacion) on delete restrict on update cascade,
	constraint fk_det_asig_item foreign key(codigo_item) references bienes_nacionales.tbien(codigo_bien) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON bienes_nacionales.tdetalle_asignacion
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE bienes_nacionales.seq_recuperacion;

CREATE TABLE bienes_nacionales.trecuperacion
(
	codigo_recuperacion numeric not null default nextval('bienes_nacionales.seq_recuperacion'),
	fecha date not null,
	cedula_persona char(10) not null,
	codigo_bien numeric not null,
	codigo_ubicacion numeric not null,
	cantidad numeric not null,
	esrecuperacion char(1) not null default 'Y',
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_recuperacion primary key(codigo_recuperacion),
	constraint fk_recuperacion_persona foreign key(cedula_persona) references general.tpersona(cedula_persona) on delete restrict on update cascade,
	constraint fk_recuperacion_bien foreign key(codigo_bien) references bienes_nacionales.tbien(codigo_bien) on delete restrict on update cascade,
	constraint fk_recuperacion_ubicacion foreign key(codigo_ubicacion) references inventario.tubicacion(codigo_ubicacion) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON bienes_nacionales.trecuperacion
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE bienes_nacionales.seq_det_recuperacion;

CREATE TABLE bienes_nacionales.tdetalle_recuperacion
(
	codigo_detalle_recuperacion numeric not null default nextval('bienes_nacionales.seq_det_recuperacion'),
	codigo_recuperacion numeric not null,
	codigo_ubicacion numeric not null,
	codigo_item numeric not null,
	cantidad numeric not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_det_recup primary key(codigo_detalle_recuperacion),
	constraint fk_det_recup_reasignacion foreign key(codigo_recuperacion) references bienes_nacionales.trecuperacion(codigo_recuperacion) on delete restrict on update cascade,
	constraint fk_det_recup_ubicacion foreign key(codigo_ubicacion) references inventario.tubicacion(codigo_ubicacion) on delete restrict on update cascade,
	constraint fk_det_recup_item foreign key(codigo_item) references bienes_nacionales.tbien(codigo_bien) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON bienes_nacionales.tdetalle_recuperacion
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

-- Fin Bienes Nacionales

-- Biblioteca

CREATE SCHEMA biblioteca;

CREATE SEQUENCE biblioteca.seq_clasificacion;

CREATE TABLE biblioteca.tclasificacion
(
	codigo_clasificacion numeric not null default nextval('biblioteca.seq_clasificacion'),
	descripcion varchar(80) not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_clasificacion primary key(codigo_clasificacion)
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON biblioteca.tclasificacion
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE biblioteca.seq_tema;

CREATE TABLE biblioteca.ttema
(
	codigo_tema numeric not null default nextval('biblioteca.seq_tema'),
	descripcion varchar(60) not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_tema primary key(codigo_tema)
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON biblioteca.ttema
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE biblioteca.seq_autor;

CREATE TABLE biblioteca.tautor
(
	codigo_autor numeric not null default nextval('biblioteca.seq_autor'),
	nombre varchar(80) not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_autor primary key(codigo_autor)
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON biblioteca.tautor
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE biblioteca.seq_editorial;

CREATE TABLE biblioteca.teditorial
(
	codigo_editorial numeric not null default nextval('biblioteca.seq_editorial'),
	nombre varchar(150) not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_editorial primary key(codigo_editorial),
	constraint fk_editorial_parroquia foreign key(codigo_parroquia) references general.tparroquia(codigo_parroquia) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON biblioteca.teditorial
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE TABLE biblioteca.tlibro 
(
	codigo_isbn_libro numeric not null,
	titulo varchar(150) not null,
	codigo_editorial numeric not null,
	codigo_autor numeric not null,
	codigo_tema numeric not null,
	numero_paginas numeric not null,
	fecha_edicion date not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_libro primary key(codigo_isbn_libro),
	constraint fk_libro_editorial foreign key(codigo_editorial) references biblioteca.teditorial(codigo_editorial) on delete restrict on update cascade,
	constraint fk_libro_autor foreign key(codigo_autor) references biblioteca.tautor(codigo_autor) on delete restrict on update cascade,
	constraint fk_libro_tema foreign key(codigo_tema) references biblioteca.ttema(codigo_tema) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON biblioteca.tlibro
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE biblioteca.seq_ejemplar;

CREATE TABLE biblioteca.tejemplar
(
	codigo_ejemplar numeric not null default nextval('biblioteca.seq_ejemplar'),
	codigo_clasificacion numeric not null,
	numero_edicion numeric not null,
	codigo_isbn_libro numeric not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_ejemplar primary key(codigo_ejemplar),
	constraint fk_ejemplar_clasificacion foreign key(codigo_clasificacion) references biblioteca.tclasificacion(codigo_clasificacion) on delete restrict on update cascade,
	constraint fk_ejemplar_libro foreign key(codigo_isbn_libro) references biblioteca.tlibro(codigo_isbn_libro) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON biblioteca.tejemplar
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE biblioteca.seq_prestamo;

CREATE TABLE biblioteca.tprestamo
(
	codigo_prestamo numeric not null default nextval('biblioteca.seq_prestamo'),
	cedula_responsable char(10) not null,
	cedula_persona char(10) not null,
	codigo_area numeric not null,
	fecha_salida date not null,
	fecha_entrada date not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_prestamo primary key(codigo_prestamo),
	constraint fk_prestamo_responsable foreign key(cedula_responsable) references general.tpersona(cedula_persona) on delete restrict on update cascade,
	constraint fk_prestamo_persona foreign key(cedula_persona) references general.tpersona(cedula_persona) on delete restrict on update cascade,
	constraint fk_prestamo_area foreign key(codigo_area) references general.tarea(codigo_area) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON biblioteca.tprestamo
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();
CREATE SEQUENCE biblioteca.seq_det_prestamo;

CREATE TABLE biblioteca.tdetalle_prestamo
(
	codigo_detalle_prestamo numeric not null default nextval('biblioteca.seq_det_prestamo'),
	codigo_prestamo numeric not null,
	codigo_ejemplar numeric not null,
	codigo_ubicacion numeric not null,
	cantidad numeric not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_det_prest primary key(codigo_detalle_prestamo),
	constraint fk_det_prest_prestamo foreign key(codigo_prestamo) references biblioteca.tprestamo(codigo_prestamo) on delete restrict on update cascade,
	constraint fk_det_prest_ejemplar foreign key(codigo_ejemplar) references biblioteca.tejemplar(codigo_ejemplar) on delete restrict on update cascade,
	constraint fk_det_prest_ubicacion foreign key(codigo_ubicacion) references inventario.tubicacion(codigo_ubicacion) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON biblioteca.tdetalle_prestamo
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE biblioteca.seq_entrega;

CREATE TABLE biblioteca.tentrega
(
	codigo_entrega numeric not null default nextval('biblioteca.seq_entrega'),
	codigo_prestamo numeric not null,
	cedula_responsable char(10) not null,
	cedula_persona char(10) not null,
	fecha_entrada date not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_entrega primary key(codigo_entrega),
	constraint fk_entrega_responsable foreign key(cedula_responsable) references general.tpersona(cedula_persona) on delete restrict on update cascade,
	constraint fk_entrega_persona foreign key(cedula_persona) references general.tpersona(cedula_persona) on delete restrict on update cascade,
	constraint fk_entrega_prestamo foreign key(codigo_prestamo) references biblioteca.tprestamo(codigo_prestamo) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON biblioteca.tentrega
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE biblioteca.seq_det_entrega;

CREATE TABLE biblioteca.tdetalle_entrega
(
	codigo_detalle_entrega numeric not null default nextval('biblioteca.seq_det_entrega'),
	codigo_entrega numeric not null,
	codigo_ubicacion numeric not null,
	codigo_ejemplar numeric not null,
	cantidad numeric not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_det_ent primary key(codigo_detalle_entrega),
	constraint fk_det_ent_entrega foreign key(codigo_entrega) references biblioteca.tentrega(codigo_entrega) on delete restrict on update cascade,
	constraint fk_det_ent_ejemplar foreign key(codigo_ejemplar) references biblioteca.tejemplar(codigo_ejemplar) on delete restrict on update cascade,
	constraint fk_det_ent_ubicacion foreign key(codigo_ubicacion) references inventario.tubicacion(codigo_ubicacion) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON biblioteca.tdetalle_entrega
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

-- Fin Biblioteca

-- Seguridad

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

CREATE TABLE seguridad.tsistema
(
	rif_negocio char(10) not null,
	nombre varchar(200) not null,
	telefono char(11),
	email varchar(60),
	clave_email varchar(60),
	direccion varchar(150),
	mision text,
	vision text,
	objetivo text,
	historia text,
	codigo_parroquia numeric,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_sistema primary key(rif_negocio)
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON seguridad.tsistema
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE seguridad.seq_configuracion;

CREATE TABLE seguridad.tconfiguracion
(
	codigo_configuracion numeric not null default nextval('seguridad.seq_configuracion'),
	descripcion character varying(30) not null,
	longitud_minclave numeric not null default 6,
	longitud_maxclave numeric not null default 10,
	cantidad_letrasmayusculas numeric not null default 1,
	cantidad_letrasminusculas numeric not null default 1,
	cantidad_caracteresespeciales numeric not null default 1,
	cantidad_numeros numeric not null default 1,
	dias_vigenciaclave numeric not null default 365,
	numero_ultimasclaves numeric not null default 1,
	dias_aviso numeric not null default 1,
	intentos_fallidos numeric not null default 1,
	numero_preguntas numeric not null default 1,
	numero_preguntasaresponder numeric not null default 1,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_configuracion primary key(codigo_configuracion)
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON seguridad.tconfiguracion
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE seguridad.seq_perfil;

CREATE TABLE seguridad.tperfil
(
	codigo_perfil numeric not null default nextval('seguridad.seq_perfil'),
	nombre_perfil varchar(45) not null,
	codigo_configuracion numeric not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_perfil primary key(codigo_perfil),
	constraint fk_perfil_configuracion foreign key(codigo_configuracion) references seguridad.tconfiguracion(codigo_configuracion) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON seguridad.tperfil
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE seguridad.seq_modulo;

CREATE TABLE seguridad.tmodulo
(
	codigo_modulo numeric not null default nextval('seguridad.seq_modulo'),
	nombre_modulo varchar(60) not null,
	icono varchar(255) default null,
	orden numeric not null default 0,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_modulo primary key(codigo_modulo)
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON seguridad.tmodulo
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE seguridad.seq_servicio;

CREATE TABLE seguridad.tservicio
(
	codigo_servicio numeric not null default nextval('seguridad.seq_servicio'),
	nombre_servicio varchar(45) not null,
	codigo_modulo numeric not null,
	url varchar(50) not null,
	orden numeric not null default 0,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_servicio primary key(codigo_servicio),
	constraint fk_servicio_modulo foreign key(codigo_modulo) references seguridad.tmodulo(codigo_modulo) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON seguridad.tservicio
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE seguridad.seq_opcion;

CREATE TABLE seguridad.topcion
(
	codigo_opcion numeric not null default nextval('seguridad.seq_opcion'),
	nombre_opcion varchar(45) not null,
	icono varchar(255) default null,
	orden numeric not null default 0,
	accion numeric not null default 0,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_opcion primary key(codigo_opcion)
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON seguridad.topcion
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE TABLE seguridad.tusuario
(
	nombre_usuario char(15) not null,
	cedula_persona char(10) not null,
	codigo_perfil numeric not null,
	intentos_fallidos numeric not null default 0,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp ,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_usuario primary key(nombre_usuario),
	constraint fk_usuario_persona foreign key(cedula_persona) references general.tpersona(cedula_persona) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON seguridad.tusuario
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE seguridad.seq_constrasena;

CREATE TABLE seguridad.tcontrasena
(
	codigo_constrasena numeric not null default nextval('seguridad.seq_constrasena'),
	nombre_usuario char(15) not null,
	contrasena varchar(60) not null,
	estado numeric not null default 0,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_contrasena primary key(codigo_constrasena),
	constraint fk_contrasena_usuario foreign key(nombre_usuario) references seguridad.tusuario(nombre_usuario) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON seguridad.tcontrasena
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE seguridad.seq_respuesta;

CREATE TABLE seguridad.trespuesta_secreta
(
	codigo_respuesta numeric not null default nextval('seguridad.seq_respuesta'),
	nombre_usuario char(15) not null,
	pregunta varchar(60) not null,
	respuesta varchar(60) not null,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_resp_secret primary key(codigo_respuesta),
	constraint fk_resp_secret_usuario foreign key(nombre_usuario) references seguridad.tusuario(nombre_usuario) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON seguridad.trespuesta_secreta
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

CREATE SEQUENCE seguridad.seq_det_serv_perfil_opc;

CREATE TABLE seguridad.tdetalle_servicio_perfil_opcion
(
	codigo_detalle_serv_perf_opc numeric not null default nextval('seguridad.seq_det_serv_perfil_opc'),
	codigo_servicio numeric not null,
	codigo_perfil numeric not null,
	codigo_opcion numeric,
	estatus char(1) not null default '1',
	creado_por char(15) not null,
	fecha_creacion timestamp,
	modificado_por char(15),
	fecha_modificacion timestamp default current_timestamp,
	constraint pk_det_serv_perf_opc primary key(codigo_detalle_serv_perf_opc),
	constraint fk_det_serv_perf_opc_opcion foreign key(codigo_opcion) references seguridad.topcion(codigo_opcion) on delete restrict on update cascade,
	constraint fk_det_serv_perf_opc_servicio foreign key(codigo_servicio) references seguridad.tservicio(codigo_servicio) on delete restrict on update cascade,
	constraint fk_det_serv_perf_opc_perfil foreign key(codigo_perfil) references seguridad.tperfil(codigo_perfil) on delete restrict on update cascade
);

CREATE TRIGGER auditoria_registros
AFTER INSERT OR UPDATE OR DELETE
ON seguridad.tdetalle_servicio_perfil_opcion
FOR EACH ROW
EXECUTE PROCEDURE auditoria_general();

-- Fin Seguridad

-- Create Views 

-- View Movimiento Inventario
CREATE OR REPLACE VIEW inventario.vw_movimiento_inventario AS 
-- Movimiento de Inventario por Adquisiciones de Materiales
SELECT DISTINCT m.codigo_movimiento, 'Adquisición No '||a.codigo_adquisicion AS nro_documento, m.fecha_movimiento, 
m.tipo_movimiento,CASE WHEN m.tipo_movimiento='E' THEN 'Entrada' ELSE 'Salida' END AS descrip_tipo_movimiento,
CASE a.sonlibros WHEN 'N' THEN b.nro_serial||' '||b.nombre WHEN 'Y' THEN e.codigo_isbn_libro||' - '||e.numero_edicion||' - '||l.titulo ELSE null END AS item,
dm.codigo_ubicacion,u.descripcion AS ubicacion, dm.cantidad_movimiento, dm.sonlibros  
FROM inventario.tmovimiento m 
INNER JOIN inventario.tadquisicion a ON m.numero_documento = a.codigo_adquisicion AND m.tipo_transaccion = 'IA' 
INNER JOIN inventario.tdetalle_adquisicion da ON a.codigo_adquisicion = da.codigo_adquisicion 
INNER JOIN inventario.tdetalle_movimiento dm ON m.codigo_movimiento = dm.codigo_movimiento AND da.codigo_item = dm.codigo_item 
INNER JOIN inventario.tubicacion u ON dm.codigo_ubicacion = u.codigo_ubicacion 
LEFT JOIN bienes_nacionales.tbien b ON da.codigo_item = b.codigo_bien AND a.sonlibros = 'N'
LEFT JOIN biblioteca.tejemplar e ON da.codigo_item = e.codigo_ejemplar AND a.sonlibros = 'Y' 
LEFT JOIN biblioteca.tlibro l ON e.codigo_isbn_libro = l.codigo_isbn_libro 
UNION ALL 
-- Movimiento de Inventario por Asignaciones de Materiales
SELECT DISTINCT m.codigo_movimiento, 'Asignación No '||a.codigo_asignacion AS nro_documento, m.fecha_movimiento, 
m.tipo_movimiento,CASE WHEN m.tipo_movimiento='E' THEN 'Entrada' ELSE 'Salida' END AS descrip_tipo_movimiento,
b.nro_serial||' '||b.nombre item,dm.codigo_ubicacion,u.descripcion AS ubicacion, dm.cantidad_movimiento, dm.sonlibros  
FROM inventario.tmovimiento m 
INNER JOIN bienes_nacionales.tasignacion a ON m.numero_documento = a.codigo_asignacion AND m.tipo_transaccion = 'BA' 
INNER JOIN bienes_nacionales.tdetalle_asignacion da ON a.codigo_asignacion = da.codigo_asignacion 
INNER JOIN inventario.tdetalle_movimiento dm ON m.codigo_movimiento = dm.codigo_movimiento AND da.codigo_item = dm.codigo_item AND (da.codigo_ubicacion = dm.codigo_ubicacion OR da.codigo_ubicacion_hasta = dm.codigo_ubicacion)
INNER JOIN inventario.tubicacion u ON dm.codigo_ubicacion = u.codigo_ubicacion 
LEFT JOIN bienes_nacionales.tbien b ON da.codigo_item = b.codigo_bien 
UNION ALL 
-- Movimiento de Inventario por Recuperación de Materiales
SELECT DISTINCT m.codigo_movimiento,
CASE r.esrecuperacion WHEN 'Y' THEN 'Recuperación No '::text || r.codigo_recuperacion ELSE 'Reconstrucción No '::text || r.codigo_recuperacion END AS nro_documento, 
m.fecha_movimiento,m.tipo_movimiento,CASE WHEN m.tipo_movimiento='E' THEN 'Entrada' ELSE 'Salida' END AS descrip_tipo_movimiento,
b.nro_serial||' '||b.nombre item,dm.codigo_ubicacion,u.descripcion AS ubicacion, dm.cantidad_movimiento, dm.sonlibros  
FROM inventario.tmovimiento m 
INNER JOIN bienes_nacionales.trecuperacion r ON m.numero_documento = r.codigo_recuperacion AND m.tipo_transaccion = 'BR' 
INNER JOIN bienes_nacionales.tdetalle_recuperacion dr ON r.codigo_recuperacion = dr.codigo_recuperacion 
INNER JOIN inventario.tdetalle_movimiento dm ON m.codigo_movimiento = dm.codigo_movimiento AND ((dr.codigo_item = dm.codigo_item AND dr.codigo_ubicacion = dm.codigo_ubicacion) OR (r.codigo_bien = dm.codigo_item AND r.codigo_ubicacion = dm.codigo_ubicacion))
INNER JOIN inventario.tubicacion u ON dm.codigo_ubicacion = u.codigo_ubicacion
INNER JOIN bienes_nacionales.tbien b ON dm.codigo_item = b.codigo_bien 
UNION ALL 
-- Movimiento de Inventario por Prestamos de Libros
SELECT DISTINCT m.codigo_movimiento, 'Prestamo No '||p.codigo_prestamo AS nro_documento, m.fecha_movimiento, 
m.tipo_movimiento,CASE WHEN m.tipo_movimiento='E' THEN 'Entrada' ELSE 'Salida' END AS descrip_tipo_movimiento,
e.codigo_isbn_libro||' - '||e.numero_edicion||' - '||l.titulo AS item, dm.codigo_ubicacion,u.descripcion AS ubicacion, 
dm.cantidad_movimiento, dm.sonlibros 
FROM inventario.tmovimiento m 
INNER JOIN biblioteca.tprestamo p ON m.numero_documento = p.codigo_prestamo AND m.tipo_transaccion = 'BP'
INNER JOIN biblioteca.tdetalle_prestamo dp ON p.codigo_prestamo = dp.codigo_prestamo 
INNER JOIN inventario.tdetalle_movimiento dm ON m.codigo_movimiento = dm.codigo_movimiento AND dp.codigo_ejemplar = dm.codigo_item AND dp.codigo_ubicacion = dm.codigo_ubicacion 
INNER JOIN inventario.tubicacion u ON dm.codigo_ubicacion = u.codigo_ubicacion 
LEFT JOIN biblioteca.tejemplar e ON dm.codigo_item = e.codigo_ejemplar 
LEFT JOIN biblioteca.tlibro l ON e.codigo_isbn_libro = l.codigo_isbn_libro 
UNION ALL 
-- Movimiento de Inventario por Entregas de Libros
SELECT DISTINCT m.codigo_movimiento, 'Entrega No '||ent.codigo_entrega AS nro_documento, m.fecha_movimiento, 
m.tipo_movimiento,CASE WHEN m.tipo_movimiento='E' THEN 'Entrada' ELSE 'Salida' END AS descrip_tipo_movimiento,
e.codigo_isbn_libro||' - '||e.numero_edicion||' - '||l.titulo AS item, dm.codigo_ubicacion,u.descripcion AS ubicacion, 
dm.cantidad_movimiento, dm.sonlibros 
FROM inventario.tmovimiento m 
INNER JOIN biblioteca.tentrega ent ON m.numero_documento = ent.codigo_entrega AND m.tipo_transaccion = 'BE'
INNER JOIN biblioteca.tdetalle_entrega de ON ent.codigo_entrega = de.codigo_entrega 
INNER JOIN inventario.tdetalle_movimiento dm ON m.codigo_movimiento = dm.codigo_movimiento AND de.codigo_ejemplar = dm.codigo_item AND de.codigo_ubicacion = dm.codigo_ubicacion 
INNER JOIN inventario.tubicacion u ON dm.codigo_ubicacion = u.codigo_ubicacion 
LEFT JOIN biblioteca.tejemplar e ON dm.codigo_item = e.codigo_ejemplar 
LEFT JOIN biblioteca.tlibro l ON e.codigo_isbn_libro = l.codigo_isbn_libro;

-- View Inventario
CREATE OR REPLACE VIEW inventario.vw_inventario AS 
SELECT dm.codigo_ubicacion,u.descripcion AS ubicacion,dm.codigo_item,
b.nro_serial||' '||b.nombre AS item,dm.sonlibros,
LAST(dm.valor_actual) AS existencia 
FROM inventario.tmovimiento m 
INNER JOIN inventario.tdetalle_movimiento dm ON m.codigo_movimiento = dm.codigo_movimiento 
INNER JOIN inventario.tubicacion u ON dm.codigo_ubicacion = u.codigo_ubicacion 
LEFT JOIN bienes_nacionales.tbien b ON dm.codigo_item = b.codigo_bien AND m.tipo_transaccion IN ('IA','BR','BA') 
WHERE dm.sonlibros='N'
GROUP BY dm.codigo_ubicacion,u.descripcion,dm.codigo_item,b.nro_serial,b.nombre,dm.sonlibros 
UNION ALL 
SELECT dm.codigo_ubicacion,u.descripcion AS ubicacion,dm.codigo_item,
e.codigo_isbn_libro||' '||e.numero_edicion||' '||l.titulo AS item,dm.sonlibros,
LAST(dm.valor_actual) AS existencia 
FROM inventario.tmovimiento m 
INNER JOIN inventario.tdetalle_movimiento dm ON m.codigo_movimiento = dm.codigo_movimiento 
INNER JOIN inventario.tubicacion u ON dm.codigo_ubicacion = u.codigo_ubicacion 
LEFT JOIN biblioteca.tejemplar e ON dm.codigo_item = e.codigo_ejemplar AND m.tipo_transaccion IN ('IA','BP','BE')
LEFT JOIN biblioteca.tlibro l ON e.codigo_isbn_libro = l.codigo_isbn_libro 
WHERE dm.sonlibros='Y'
GROUP BY dm.codigo_ubicacion,u.descripcion,dm.codigo_item,dm.sonlibros,e.codigo_isbn_libro,e.numero_edicion,l.titulo;

-- View Inventario Items Disponibles
CREATE OR REPLACE VIEW inventario.vw_inventario_de_items_disponibles AS 
SELECT cb.codigo_bien AS codigo_item_a_producir,
ins.codigo_item AS codigo_item_a_usar,
ins.codigo_ubicacion AS codigo_ubicacion_fuente,
cb.item_base,
sum(ins.existencia) AS cant_insumo_disponible,
max(cb.cantidad) AS cant_necesaria,
round(sum(ins.existencia) / max(cb.cantidad), 0) AS cant_a_usar,
round(sum(ins.existencia) / max(cb.cantidad), 0) AS cant_disponible,
round(sum(ins.existencia) / max(cb.cantidad), 0) AS cant_disponible_a_recuperar
FROM inventario.vw_inventario ins
JOIN bienes_nacionales.tconfiguracion_bien cb ON ins.codigo_item = cb.codigo_item
JOIN inventario.tubicacion u ON ins.codigo_ubicacion = u.codigo_ubicacion
WHERE ins.sonlibros = 'N'::bpchar AND u.itemsdefectuoso = 'N'::bpchar AND cb.item_base = 'Y'::bpchar
GROUP BY cb.codigo_bien, ins.codigo_item, ins.codigo_ubicacion, cb.item_base;

-- View Educacion Horario
CREATE OR REPLACE VIEW educacion.vhorario AS 
SELECT pr.primer_nombre AS nombre,
pr.primer_apellido AS apellido,
(h.codigo_bloque_hora || '-'::text) || h.dia AS celda,
pr.cedula_persona AS cedula,
h.dia,
h.codigo_bloque_hora,
hp.codigo_materia AS materia,
hp.cedula_persona AS profesor,
h.codigo_ambiente,
hp.seccion,
h.codigo_ano_academico,
tm.nombre_materia,
ta.descripcion AS nombre_ambiente,
(bh.hora_inicio || '-'::text) || bh.hora_fin AS hora,
s.nombre_seccion
FROM educacion.thorario h
LEFT JOIN educacion.thorario_profesor hp ON hp.codigo_horario_profesor = h.codigo_horario_profesor
LEFT JOIN educacion.tseccion s ON s.seccion = hp.seccion
LEFT JOIN general.tpersona pr ON pr.cedula_persona = hp.cedula_persona
LEFT JOIN educacion.tmateria tm ON tm.codigo_materia = hp.codigo_materia
LEFT JOIN general.tambiente ta ON ta.codigo_ambiente = h.codigo_ambiente
LEFT JOIN educacion.tbloque_hora bh ON bh.codigo_bloque_hora = h.codigo_bloque_hora;

-- View Educacion Horario por Sección
CREATE OR REPLACE VIEW educacion.vmateria_seccion_horario AS 
SELECT s.seccion,
count(h.codigo_materia) AS cantidad_materia_horario,
count(ms.codigo_materia) AS cantidad_materia_seccion
FROM educacion.tseccion s
LEFT JOIN educacion.tmateria_seccion ms ON s.seccion = ms.seccion
LEFT JOIN educacion.thorario_profesor h ON h.seccion = s.seccion
GROUP BY s.seccion, ms.codigo_materia;

-- End Views 