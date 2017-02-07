<?php

class Validacion extends ActiveRecord {
    public function cargarDatosValidacion($id) {
        return $this->find_first("conditions: id_validacion = $id");
    }
    
    public function cargarNotasValidcionesAlumno($id) {
        return $this->find("columns: validacion.*,semestre.id_semestre",
                "join: join materia on validacion.id_materia = materia.id_materia
                    join alumno on validacion.id_alumno = alumno.id_alumno
                    join matricula on alumno.id_alumno = matricula.id_alumno
                    join semestre on matricula.id_semestre = semestre.id_semestre",
                "conditions: identificacion_alumno = $id",
                "order: semestre.id_semestre");
    }
    
    public function cargarNotasValidcionesSemestreAlumno($id, $semestre) {
        return $this->find("columns: validacion.*,semestre.id_semestre",
                "join: join materia on validacion.id_materia = materia.id_materia
                    join alumno on validacion.id_alumno = alumno.id_alumno
                    join matricula on alumno.id_alumno = matricula.id_alumno
                    join semestre on matricula.id_semestre = semestre.id_semestre",
                "conditions: identificacion_alumno = $id and semestre.id_semestre = $semestre",
                "order: semestre.id_semestre");
    }
    
    public function cargarAlumnosMateriaValidaciones($sede, $programa, $materia) {
        return $this->find("columns: validacion.id_validacion,alumno.id_alumno,alumno.identificacion_alumno,alumno.nombre_alumno,alumno.apellido_alumno,materia.id_materia",
                "join: join pagovalidacion on validacion.id_validacion = pagovalidacion.id_validacion
                    join alumno on validacion.id_alumno = alumno.id_alumno
                    join matricula on matricula.id_alumno = alumno.id_alumno
                    join alumnoprograma on alumno.id_alumno = alumnoprograma.id_alumno
                    join programa on alumnoprograma.id_programa = programa.id_programa
                    join materiaprograma on programa.id_programa = materiaprograma.id_programa
                    join materia on materiaprograma.id_materia = materia.id_materia",
                "conditions: matricula.id_sede = $sede
                    and programa.id_programa = $programa
                    and materia.id_materia = $materia
                    and matricula.id_semestre = materiaprograma.semestre
                    and estado_pagovalidacion = 2",
                "order: apellido_alumno");
    }
    
    public function cargarNumeroAlumnosValidaciones($sede, $programa, $materia) {
        return $this->find("columns: count(*) as resultado",
                "join: join pagovalidacion on validacion.id_validacion = pagovalidacion.id_validacion
                    join alumno on validacion.id_alumno = alumno.id_alumno
                    join matricula on matricula.id_alumno = alumno.id_alumno
                    join alumnoprograma on alumno.id_alumno = alumnoprograma.id_alumno
                    join programa on alumnoprograma.id_programa = programa.id_programa
                    join materiaprograma on programa.id_programa = materiaprograma.id_programa
                    join materia on materiaprograma.id_materia = materia.id_materia",
                "conditions: matricula.id_sede = $sede
                    and programa.id_programa = $programa
                    and materia.id_materia = $materia
                    and matricula.id_semestre = materiaprograma.semestre
                    and estado_pagovalidacion = 2",
                "order: apellido_alumno");
    }
}
