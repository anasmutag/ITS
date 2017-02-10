<?php

class Docente extends ActiveRecord {
    public function validarDocente($identificacion,$contrasena){
        $contrasena = addslashes($contrasena);
        $identificacion = addslashes($identificacion);
        
        return $this->find_by_sql('SELECT `validar_docente`("'.$identificacion.'","'.$contrasena.'") AS RESUL;');
    }
    
    public function cargarDocentesEvaluacion($codigoalumno) {
        return $this->find("columns: docente.id_docente,docente.nombre_docente,docente.apellido_docente",
                "join: join materia on docente.id_docente = materia.id_docente
                    join materiaprograma on materia.id_materia = materiaprograma.id_materia
                    join programa on materiaprograma.id_programa = programa.id_programa
                    join alumnoprograma on programa.id_programa = alumnoprograma.id_programa
                    join alumno on alumnoprograma.id_alumno = alumno.id_alumno",
                "conditions: identificacion_alumno = $codigoalumno
                    group by identificacion_docente",
                "order: docente.id_docente");
    }
}
