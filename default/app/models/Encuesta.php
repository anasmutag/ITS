<?php

class Encuesta extends ActiveRecord {
    public function cargarEncuestasRealizadas($codigoalumno) {
        return $this->find("columns: docente_encuesta",
                "conditions: id_alumno = (select id_alumno from alumno where identificacion_alumno = $codigoalumno)");
    }
}
