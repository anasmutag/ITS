<?php

class Encuesta extends ActiveRecord {
    public function cargarEncuestasRealizadas($codigoalumno) {
        /*return $this->find("columns: docente_encuesta",
                "conditions: id_alumno = (select id_alumno from alumno where identificacion_alumno = $codigoalumno)");*/
        
        return $this->find("columns: docente_encuesta,count(*) as cantidad",
                "join: join alumno on encuesta.id_alumno = alumno.id_alumno
                    join matricula on alumno.id_alumno = matricula.id_alumno",
                "conditions: identificacion_alumno = $codigoalumno
                    and id_estadomatricula = 1
                    and semestre_encuesta = id_semestre");
    }
}
