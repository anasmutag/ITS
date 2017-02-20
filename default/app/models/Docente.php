<?php

class Docente extends ActiveRecord {
    public function validarDocente($identificacion,$contrasena){
        $contrasena = addslashes($contrasena);
        $identificacion = addslashes($identificacion);
        
        return $this->find_by_sql('SELECT `validar_docente`("'.$identificacion.'","'.$contrasena.'") AS RESUL;');
    }
    
    public function cargarDocentesEvaluacionParcial($codigoalumno) {
        return $this->find("columns: docente.id_docente,docente.nombre_docente,docente.apellido_docente",
                "join: join materiadocente on docente.id_docente = materiadocente.id_docente
                    join materia on materiadocente.id_materia = materia.id_materia
                    join materiaprograma on materia.id_materia = materiaprograma.id_materia
                    join programa on materiaprograma.id_programa = programa.id_programa
                    join alumnoprograma on programa.id_programa = alumnoprograma.id_programa
                    join alumno on alumnoprograma.id_alumno = alumno.id_alumno
                    join matricula on alumno.id_alumno = matricula.id_alumno",
                "conditions: identificacion_alumno = $codigoalumno
                    and id_estadomatricula = 1
                    and id_semestre = semestre
                    and id_sede = sede
                    and docente.id_docente <> (
                        select docente_encuesta
                        from encuesta
                        where id_alumno = (select id_alumno from alumno where identificacion_alumno = $codigoalumno)
                    )
                    group by identificacion_docente",
                "order: docente.id_docente");
    }
    
    public function cargarDocentesEvaluacionTotal($codigoalumno) {
        return $this->find("columns: docente.id_docente,docente.nombre_docente,docente.apellido_docente",
                "join: join materiadocente on docente.id_docente = materiadocente.id_docente
                    join materia on materiadocente.id_materia = materia.id_materia
                    join materiaprograma on materia.id_materia = materiaprograma.id_materia
                    join programa on materiaprograma.id_programa = programa.id_programa
                    join alumnoprograma on programa.id_programa = alumnoprograma.id_programa
                    join alumno on alumnoprograma.id_alumno = alumno.id_alumno
                    join matricula on alumno.id_alumno = matricula.id_alumno",
                "conditions: identificacion_alumno = $codigoalumno
                    and id_estadomatricula = 1
                    and id_semestre = semestre
                    and id_sede = sede
                    group by identificacion_docente",
                "order: docente.id_docente");
    }
}
