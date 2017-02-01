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
}
