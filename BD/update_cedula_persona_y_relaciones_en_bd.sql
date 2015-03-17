DROP VIEW educacion.vhorario;
ALTER TABLE general.tdetalle_familiar DROP CONSTRAINT fk_detalle_familiar_estudiante;
ALTER TABLE general.tdetalle_familiar DROP CONSTRAINT fk_detalle_familiar_familiar;
ALTER TABLE inventario.tadquisicion DROP constraint fk_adquisicion_persona;
ALTER TABLE educacion.tinscrito_seccion DROP constraint fk_ins_sec_persona;
ALTER TABLE educacion.thorario_profesor DROP constraint fk_hora_prof_persona;
ALTER TABLE educacion.tproceso_inscripcion DROP constraint fk_pro_ins_responsable;
ALTER TABLE educacion.tproceso_inscripcion DROP constraint fk_pro_ins_persona;
ALTER TABLE educacion.tproceso_inscripcion DROP constraint fk_pro_ins_padre;
ALTER TABLE educacion.tproceso_inscripcion DROP constraint fk_pro_ins_madre;
ALTER TABLE educacion.tproceso_inscripcion DROP constraint fk_pro_ins_representante;
ALTER TABLE bienes_nacionales.tasignacion DROP constraint fk_asignacion_persona;
ALTER TABLE bienes_nacionales.trecuperacion DROP constraint fk_recuperacion_persona;
ALTER TABLE biblioteca.tprestamo DROP constraint fk_prestamo_responsable;
ALTER TABLE biblioteca.tprestamo DROP constraint fk_prestamo_persona;
ALTER TABLE biblioteca.tentrega DROP constraint fk_entrega_responsable;
ALTER TABLE biblioteca.tentrega DROP constraint fk_entrega_persona;
ALTER TABLE biblioteca.tasignacion_libro DROP constraint fk_asignacion_libro_persona;
ALTER TABLE seguridad.tusuario DROP constraint fk_usuario_persona;
ALTER TABLE general.tpersona ALTER COLUMN cedula_persona TYPE char(15);
ALTER TABLE general.tdetalle_familiar ALTER COLUMN cedula_persona TYPE char(15);
ALTER TABLE general.tdetalle_familiar ALTER COLUMN cedula_familiar TYPE char(15);
ALTER TABLE inventario.tadquisicion ALTER COLUMN cedula_persona TYPE char(15);
ALTER TABLE educacion.tinscrito_seccion ALTER COLUMN cedula_persona TYPE char(15);
ALTER TABLE educacion.thorario_profesor ALTER COLUMN cedula_persona TYPE char(15);
ALTER TABLE educacion.tproceso_inscripcion ALTER COLUMN cedula_persona TYPE char(15);
ALTER TABLE educacion.tproceso_inscripcion ALTER COLUMN cedula_responsable TYPE char(15);
ALTER TABLE educacion.tproceso_inscripcion ALTER COLUMN cedula_padre TYPE char(15);
ALTER TABLE educacion.tproceso_inscripcion ALTER COLUMN cedula_madre TYPE char(15);
ALTER TABLE educacion.tproceso_inscripcion ALTER COLUMN cedula_representante TYPE char(15);
ALTER TABLE bienes_nacionales.tasignacion ALTER COLUMN cedula_persona TYPE char(15);
ALTER TABLE bienes_nacionales.trecuperacion ALTER COLUMN cedula_persona TYPE char(15);
ALTER TABLE biblioteca.tprestamo ALTER COLUMN cedula_persona TYPE char(15);
ALTER TABLE biblioteca.tprestamo ALTER COLUMN cedula_responsable TYPE char(15);
ALTER TABLE biblioteca.tentrega ALTER COLUMN cedula_persona TYPE char(15);
ALTER TABLE biblioteca.tentrega ALTER COLUMN cedula_responsable TYPE char(15);
ALTER TABLE biblioteca.tasignacion_libro ALTER COLUMN cedula_persona TYPE char(15);
ALTER TABLE seguridad.tusuario ALTER COLUMN cedula_persona TYPE char(15);
ALTER TABLE general.tdetalle_familiar ADD CONSTRAINT fk_detalle_familiar_estudiante FOREIGN KEY (cedula_persona) REFERENCES general.tpersona (cedula_persona) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE general.tdetalle_familiar ADD CONSTRAINT fk_detalle_familiar_familiar FOREIGN KEY (cedula_familiar) REFERENCES general.tpersona (cedula_persona) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE inventario.tadquisicion ADD constraint fk_adquisicion_persona foreign key(cedula_persona) references general.tpersona(cedula_persona) on delete restrict on update cascade;
ALTER TABLE educacion.tinscrito_seccion ADD constraint fk_ins_sec_persona foreign key(cedula_persona) references general.tpersona(cedula_persona) on delete restrict on update cascade;
ALTER TABLE educacion.thorario_profesor ADD constraint fk_hora_prof_persona foreign key(cedula_persona) references general.tpersona(cedula_persona) on delete restrict on update cascade;
ALTER TABLE educacion.tproceso_inscripcion ADD constraint fk_pro_ins_responsable foreign key(cedula_responsable) references general.tpersona(cedula_persona) on delete restrict on update cascade;
ALTER TABLE educacion.tproceso_inscripcion ADD constraint fk_pro_ins_persona foreign key(cedula_persona) references general.tpersona(cedula_persona) on delete restrict on update cascade;
ALTER TABLE educacion.tproceso_inscripcion ADD constraint fk_pro_ins_padre foreign key(cedula_padre) references general.tpersona(cedula_persona) on delete restrict on update cascade;
ALTER TABLE educacion.tproceso_inscripcion ADD constraint fk_pro_ins_madre foreign key(cedula_madre) references general.tpersona(cedula_persona) on delete restrict on update cascade;
ALTER TABLE educacion.tproceso_inscripcion ADD constraint fk_pro_ins_representante foreign key(cedula_representante) references general.tpersona(cedula_persona) on delete restrict on update cascade;
ALTER TABLE bienes_nacionales.tasignacion ADD constraint fk_asignacion_persona foreign key(cedula_persona) references general.tpersona(cedula_persona) on delete restrict on update cascade;
ALTER TABLE bienes_nacionales.trecuperacion ADD constraint fk_recuperacion_persona foreign key(cedula_persona) references general.tpersona(cedula_persona) on delete restrict on update cascade;
ALTER TABLE biblioteca.tprestamo ADD constraint fk_prestamo_responsable foreign key(cedula_responsable) references general.tpersona(cedula_persona) on delete restrict on update cascade;
ALTER TABLE biblioteca.tprestamo ADD constraint fk_prestamo_persona foreign key(cedula_persona) references general.tpersona(cedula_persona) on delete restrict on update cascade;
ALTER TABLE biblioteca.tentrega ADD constraint fk_entrega_responsable foreign key(cedula_responsable) references general.tpersona(cedula_persona) on delete restrict on update cascade;
ALTER TABLE biblioteca.tentrega ADD constraint fk_entrega_persona foreign key(cedula_persona) references general.tpersona(cedula_persona) on delete restrict on update cascade;
ALTER TABLE biblioteca.tasignacion_libro ADD constraint fk_asignacion_libro_persona foreign key(cedula_persona) references general.tpersona(cedula_persona) on delete restrict on update cascade;
ALTER TABLE seguridad.tusuario ADD constraint fk_usuario_persona foreign key(cedula_persona) references general.tpersona(cedula_persona) on delete restrict on update cascade;
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
s.nombre_seccion, 
pr.maxhoras 
FROM educacion.thorario h
LEFT JOIN educacion.thorario_profesor hp ON hp.codigo_horario_profesor = h.codigo_horario_profesor
LEFT JOIN educacion.tseccion s ON s.seccion = hp.seccion
LEFT JOIN general.tpersona pr ON pr.cedula_persona = hp.cedula_persona
LEFT JOIN educacion.tmateria tm ON tm.codigo_materia = hp.codigo_materia
LEFT JOIN general.tambiente ta ON ta.codigo_ambiente = h.codigo_ambiente
LEFT JOIN educacion.tbloque_hora bh ON bh.codigo_bloque_hora = h.codigo_bloque_hora;