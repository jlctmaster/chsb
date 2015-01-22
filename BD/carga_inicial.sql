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

-- Created Modules 
 
INSERT INTO seguridad.tmodulo (nombre_modulo,icono,orden,creado_por,fecha_creacion) VALUES ('LOCALIDADES','icon-list',1,'postgres',NOW());
INSERT INTO seguridad.tmodulo (nombre_modulo,icono,orden,creado_por,fecha_creacion) VALUES ('GENERAL','icon-list-alt',2,'postgres',NOW());
INSERT INTO seguridad.tmodulo (nombre_modulo,icono,orden,creado_por,fecha_creacion) VALUES ('INVENTARIO','icon-list-alt',3,'postgres',NOW());
INSERT INTO seguridad.tmodulo (nombre_modulo,icono,orden,creado_por,fecha_creacion) VALUES ('EDUCACIÓN','icon-list-alt',4,'postgres',NOW());
INSERT INTO seguridad.tmodulo (nombre_modulo,icono,orden,creado_por,fecha_creacion) VALUES ('BIENES NACIONALES','icon-list-alt',5,'postgres',NOW());
INSERT INTO seguridad.tmodulo (nombre_modulo,icono,orden,creado_por,fecha_creacion) VALUES ('BIBLIOTECA','icon-list',6,'postgres',NOW());
INSERT INTO seguridad.tmodulo (nombre_modulo,icono,orden,creado_por,fecha_creacion) VALUES ('REPORTES','icon-cog',7,'postgres',NOW());
INSERT INTO seguridad.tmodulo (nombre_modulo,icono,orden,creado_por,fecha_creacion) VALUES ('SEGURIDAD','icon-lock',8,'postgres',NOW());


-- Created Services of Security Modules

INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('PAÍS','PAIS',1,1,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('ESTADO','ESTADO',1,2,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('MUNICIPIO','MUNICIPIO',1,3,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('PARROQUIA','PARROQUIA',1,4,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('ORGANIZACIÓN','ORGANIZACION',2,1,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('TIPO DE PERSONA','TIPO_PERSONA',2,2,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('PERSONA','PERSONA',2,3,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('PARENTESCO','PARENTESCO',2,4,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('DEPARTAMENTO','DEPARTAMENTO',2,5,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('ÁREA','AREA',2,6,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('AMBIENTE','AMBIENTE',2,7,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('UBICACIÓN','UBICACION',3,1,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('ADQUISICIÓN','ADQUISICION',3,2,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('MOVIMIENTO','MOVIMIENTO',3,4,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('INVENTARIO','INVENTARIO',3,4,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('BLOQUE DE HORA','BLOQUE_HORA',4,1,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('AÑO ACADÉMICO','ANO_ACADEMICO',4,2,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('LAPSO','LAPSO',4,3,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('MATERIA','MATERIA',4,4,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('PERÍODO','PERIODO',4,5,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('SECCIÓN','SECCION',4,6,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('ESTUDIANTES','ESTUDIANTE',4,7,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('INSCRIPCIÓN','inscripcion',4,9,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('HORARIO','HORARIO',4,11,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('PROCESO DE  INSCRIPCIÓN','PROCESO_INSCRIPCION',4,12,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('TIPO DE BIEN','tipo_bien',5,1,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('BIEN','BIEN',5,2,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('ASIGNACIÓN','ASIGNACION',5,3,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('RECUPERACIÓN','RECUPERACION',5,4,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('RECONSTRUCCIÓN','RECONSTRUCCION',5,5,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('CLASIFICACIÓN','CLASIFICACION',6,1,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('TEMA','TEMA',6,2,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('AUTOR','AUTOR',6,3,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('EDITORIAL','EDITORIAL',6,4,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('LIBRO','LIBRO',6,5,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('EJEMPLAR','EJEMPLAR',6,6,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('PRÉSTAMO','prestamo',6,7,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('ENTREGA','ENTREGA',6,10,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('HORARIO DE CLASES','HORARIO_CLASES',7,1,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('HORARIO PROFESOR','HORARIO_PROFESOR',7,2,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('HISTÓRICO DE INSCRIPCIÓN','HISTORICO_INSCRIPCION',7,3,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('INVENTARIO ANALÍTICO','INVENTARIO_ANALITICO',7,4,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('MOVIMIENTO DE INVENTARIOS','MOVIMIENTO_INVENTARIO',7,5,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('ASISTENCIA A  LA BIBLIOTECA','ASISTENCIA_BIBLIOTECA',7,6,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('PRESTAMO DE LIBROS','PRESTAMO_LIBROS',7,7,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('CARTA DE MOROSIDAD','CARTA_MOROSIDAD',7,8,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('ENTREGA DE LIBROS','ENTREGA_LIBROS',7,9,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('ASIGNACIÓN DE BIENES','ASIGNACION_BIENES',7,10,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('RECUPERACION DE BIENES','RECUPERACION_BIENES',7,11,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('RECONSTRUCCIÓN DE BIENES','RECONSTRUCCION_BIENES',7,12,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('INFO. NEGOCIO','SISTEMA',8,1,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('CONFIG. SISTEMA','CONFIGURACION',8,2,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('MÓDULO','MODULO',8,3,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('SERVICIOS','SERVICIO',8,4,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('BOTONERA','BOTONES',8,5,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('PERFIL','PERFILES',8,6,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('NUEVO USUARIO','NUEVOUSUARIO',8,7,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('MÍ PERFIL','PERFIL',8,8,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('CAMBIAR CONTRASEÑA','CAMBIARCONTRASENA',8,9,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('DESBLOQUEAR USUARIO','DESBLOQUEARUSUARIO',8,10,'postgres',NOW());
INSERT INTO seguridad.tservicio (nombre_servicio,url,codigo_modulo,orden,creado_por,fecha_creacion) VALUES ('HISTÓRICO DE CAMBIOS','BITACORA',8,11,'postgres',NOW());


-- Created Options 

INSERT INTO seguridad.topcion (nombre_opcion,icono,orden,accion,creado_por,fecha_creacion) VALUES ('INSERTAR','icon-pencil',1,1,'postgres',NOW());
INSERT INTO seguridad.topcion (nombre_opcion,icono,orden,accion,creado_por,fecha_creacion) VALUES ('ACTUALIZAR','icon-edit',2,2,'postgres',NOW());
INSERT INTO seguridad.topcion (nombre_opcion,icono,orden,accion,creado_por,fecha_creacion) VALUES ('DESACTIVAR','icon-eye-close',3,3,'postgres',NOW());
INSERT INTO seguridad.topcion (nombre_opcion,icono,orden,accion,creado_por,fecha_creacion) VALUES ('ACTIVAR','icon-eye-open',4,4,'postgres',NOW());
INSERT INTO seguridad.topcion (nombre_opcion,icono,orden,accion,creado_por,fecha_creacion) VALUES ('CONSULTAR','icon-search',5,5,'postgres',NOW());

-- Created Access Windows for Security Modules

INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,1,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,1,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,1,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,1,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,1,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,2,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,2,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,2,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,2,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,2,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,3,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,3,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,3,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,3,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,3,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,4,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,4,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,4,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,4,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,4,'postgres',NOW());
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
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,8,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,8,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,8,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,8,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,9,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,9,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,9,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,9,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,9,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,10,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,10,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,10,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,10,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,10,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,11,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,11,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,11,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,11,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,11,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,12,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,12,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,12,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,12,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,12,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,13,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,13,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,13,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,13,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,13,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,14,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,14,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,14,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,14,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,14,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,15,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,15,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,15,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,15,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,15,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,16,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,16,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,16,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,16,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,16,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,17,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,17,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,17,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,17,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,17,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,18,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,18,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,18,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,18,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,18,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,19,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,19,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,19,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,19,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,19,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,20,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,20,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,20,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,20,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,20,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,21,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,21,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,21,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,21,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,21,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,22,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,22,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,22,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,22,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,22,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,23,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,23,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,23,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,23,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,23,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,24,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,24,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,24,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,24,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,24,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,25,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,25,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,25,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,25,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,25,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,26,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,26,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,26,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,26,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,26,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,27,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,27,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,27,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,27,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,27,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,28,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,28,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,28,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,28,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,28,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,29,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,29,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,29,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,29,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,29,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,30,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,30,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,30,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,30,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,30,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,31,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,31,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,31,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,31,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,31,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,32,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,32,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,32,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,32,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,32,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,33,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,33,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,33,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,33,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,33,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,34,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,34,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,34,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,34,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,34,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,35,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,35,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,35,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,35,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,35,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,36,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,36,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,36,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,36,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,36,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,37,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,37,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,37,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,37,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,37,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,38,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,38,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,38,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,38,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,38,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,39,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,39,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,39,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,39,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,39,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,40,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,40,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,40,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,40,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,40,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,41,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,41,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,41,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,41,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,41,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,42,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,42,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,42,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,42,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,42,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,43,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,43,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,43,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,43,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,43,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,44,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,44,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,44,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,44,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,44,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,45,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,45,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,45,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,45,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,45,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,46,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,46,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,46,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,46,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,46,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,47,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,47,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,47,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,47,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,47,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,48,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,48,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,48,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,48,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,48,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,49,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,49,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,49,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,49,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,49,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,50,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,50,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,50,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,50,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,50,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,51,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,51,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,51,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,51,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,51,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,52,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,52,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,52,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,52,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,52,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,53,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,53,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,53,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,53,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,53,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,54,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,54,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,54,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,54,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,54,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,55,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,55,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,55,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,55,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,55,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,56,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,56,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,56,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,56,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,56,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,57,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,57,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,57,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,57,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,57,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,58,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,58,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,58,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,58,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,58,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,59,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,59,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,59,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,59,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,59,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,60,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,60,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,60,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,60,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,60,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,1,61,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,2,61,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,3,61,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,4,61,'postgres',NOW());
INSERT INTO seguridad.tdetalle_servicio_perfil_opcion (codigo_perfil,codigo_opcion,codigo_servicio,creado_por,fecha_creacion) VALUES (1,5,61,'postgres',NOW());


-- Created First User Admin

INSERT INTO seguridad.tusuario (nombre_usuario,cedula_persona,codigo_perfil,intentos_fallidos,creado_por,fecha_creacion) VALUES ('ADMINV123456789','V123456789',1,0,'postgres',NOW());

-- Created First Password 12345678

INSERT INTO seguridad.tcontrasena (nombre_usuario,contrasena,estado,creado_por,fecha_creacion) VALUES ('ADMINV123456789','1f82ea75c5cc526729e2d581aeb3aeccfef4407e',3,'postgres',NOW());