-- Created First Country

INSERT INTO general.tpais (descripcion,creado_por,fecha_creacion) VALUES ('VENEZUELA','postgres',NOW());

-- Created First State

INSERT INTO general.testado (descripcion,codigo_pais,creado_por,fecha_creacion) VALUES ('PORTUGUESA',1,'postgres',NOW());

-- Created First Municipality

INSERT INTO general.tmunicipio (descripcion,codigo_estado,creado_por,fecha_creacion) VALUES ('PÁEZ',1,'postgres',NOW());

-- Created First Parish

INSERT INTO general.tparroquia (descripcion,codigo_municipio,creado_por,fecha_creacion) VALUES ('ACARIGUA',1,'postgres',NOW());

-- Created First Person Type

INSERT INTO general.ttipo_persona (descripcion,es_usuariosistema,creado_por,fecha_creacion) VALUES ('OPERADOR DE SISTEMA','Y','postgres',NOW());

-- Created First Person 

INSERT INTO general.tpersona (cedula_persona,primer_nombre,primer_apellido,sexo,fecha_nacimiento,lugar_nacimiento,direccion,telefono_local,codigo_tipopersona,creado_por,fecha_creacion) VALUES ('V123456789','GREGORIO','MARTINEZ','M','01/01/1985',1,'BARRIO SAN VICENTE SECTOR 3 CASA 12-45','02556230054',1,'postgres',NOW());

-- Created First Dates Company

INSERT INTO seguridad.tsistema (rif_negocio,nombre,telefono,email,direccion,mision,vision,objetivo,historia,codigo_parroquia,creado_por,fecha_creacion) VALUES ('J000000000','COMPLEJO HABITACIONAL SIMÓN BOLÍVAR','02550000000','CHSB@GMAIL.COM','AQUÍ VA LA DIRECCIÓN','AQUÍ VA LA MISIÓN','AQUÍ VA LA VISIÓN','AQUÍ VAN LOS OBJETIVOS','AQUÍ VA LA RESEÑA HISTORICA',1,'postgres',NOW());

-- Created First Configurations

INSERT INTO seguridad.tconfiguracion (descripcion,creado_por,fecha_creacion) VALUES ('POR DEFECTO','postgres',NOW());

-- Created First Perfil

INSERT INTO seguridad.tperfil (nombre_perfil,codigo_configuracion,creado_por,fecha_creacion) VALUES ('ADMINISTRADOR',1,'postgres',NOW());

-- Created First Modules 

INSERT INTO seguridad.tmodulo (nombre_modulo,icono,orden,creado_por,fecha_creacion) VALUES ('SEGURIDAD','icon-lock',0,'postgres',NOW()); 

-- Created Services of Security Modules

INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('INFO. NEGOCIO','SISTEMA',1,0,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('CONFIG. SISTEMA','CONFIGURACION',1,0,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('MÓDULO','MODULO',1,0,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('SERVICIOS','SERVICIO',1,0,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('BOTONERA','BOTONES',1,0,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('PERFIL','PERFILES',1,0,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('NUEVO USUARIO','NUEVOUSUARIO',1,0,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('MÍ PERFIL','PERFIL',1,0,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('CAMBIAR CONTRASEÑA','CAMBIARCONTRASENA',1,0,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('DESBLOQUEAR USUARIO','DESBLOQUEARUSUARIO',1,0,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('BÍTACORA','BITACORA',1,0,'postgres',NOW());

-- Created Options 

INSERT INTO seguridad.topcion (nombre_opcion,icono,orden,accion,creado_por,fecha_creacion) VALUES ('INSERTAR','icon-pencil',1,1,'postgres',NOW());
INSERT INTO seguridad.topcion (nombre_opcion,icono,orden,accion,creado_por,fecha_creacion) VALUES ('ACTUALIZAR','icon-edit',2,2,'postgres',NOW());
INSERT INTO seguridad.topcion (nombre_opcion,icono,orden,accion,creado_por,fecha_creacion) VALUES ('DESACTIVAR','icon-eye-close',3,3,'postgres',NOW());
INSERT INTO seguridad.topcion (nombre_opcion,icono,orden,accion,creado_por,fecha_creacion) VALUES ('ACTIVAR','icon-eye-open',4,4,'postgres',NOW());
INSERT INTO seguridad.topcion (nombre_opcion,icono,orden,accion,creado_por,fecha_creacion) VALUES ('CONSULTAR','icon-search',5,5,'postgres',NOW());

-- Created Access Windows for Security Modules

INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,1,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,2,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,2,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,2,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,2,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,2,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,4,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,3,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,3,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,4,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,4,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,3,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,4,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,3,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,4,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,3,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,5,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,5,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,5,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,5,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,5,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,6,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,6,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,6,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,6,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,6,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,7,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,7,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,7,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,7,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,7,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,8,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,9,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,10,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,11,'postgres',NOW());

-- Created First User Admin

INSERT INTO seguridad.tusuario (nombre_usuario,cedula_persona,codigo_perfil,intentos_fallidos,creado_por,fecha_creacion) VALUES ('ADMINV123456789','V123456789',1,0,'postgres',NOW());

-- Created First Password 12345678

INSERT INTO seguridad.tcontrasena (nombre_usuario,contrasena,estado,creado_por,fecha_creacion) VALUES ('ADMINV123456789','1f82ea75c5cc526729e2d581aeb3aeccfef4407e',3,'postgres',NOW());