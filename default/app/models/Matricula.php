<?php

class Matricula extends ActiveRecord {
    public function cargarAlumnosMateria($sede, $programa, $materia) {
        return $this->find("columns: alumno.id_alumno,alumno.identificacion_alumno,alumno.nombre_alumno,alumno.apellido_alumno,materia.id_materia",
                "join: join alumno on matricula.id_alumno = alumno.id_alumno
                    join alumnoprograma on alumno.id_alumno = alumnoprograma.id_alumno
                    join programa on alumnoprograma.id_programa = programa.id_programa
                    join materiaprograma on programa.id_programa = materiaprograma.id_programa
                    join materia on materiaprograma.id_materia = materia.id_materia",
                "conditions: matricula.id_sede = $sede and programa.id_programa = $programa and materia.id_materia = $materia and matricula.id_estadomatricula = 1 and matricula.id_semestre = materiaprograma.semestre",
                "order: apellido_alumno");
    }
    
    public function cargarAlumnosMateriaValidaciones($sede, $programa, $materia) {
        return $this->find("columns: id_validacion,alumno.id_alumno,alumno.identificacion_alumno,alumno.nombre_alumno,alumno.apellido_alumno,materia.id_materia",
                "join: join alumno on matricula.id_alumno = alumno.id_alumno
                    join alumnoprograma on alumno.id_alumno = alumnoprograma.id_alumno
                    join programa on alumnoprograma.id_programa = programa.id_programa
                    join materiaprograma on programa.id_programa = materiaprograma.id_programa
                    join materia on materiaprograma.id_materia = materia.id_materia
                    join validacion on materia.id_materia = validacion.id_materia",
                "conditions: matricula.id_sede = $sede
                    and programa.id_programa = $programa
                    and materia.id_materia = $materia
                    and matricula.id_estadomatricula = 1
                    and matricula.id_semestre = materiaprograma.semestre",
                "order: apellido_alumno");
    }
    
    public function cargarNumeroAlumnosSemestre($materia) {
        return $this->find("columns: count(*) as resultado",
                "join: join alumno on matricula.id_alumno = alumno.id_alumno
                    join alumnoprograma on alumno.id_alumno = alumnoprograma.id_alumno
                    join programa on alumnoprograma.id_programa = programa.id_programa
                    join materiaprograma on programa.id_programa = materiaprograma.id_programa",
                "conditions: id_estadomatricula = 1
                    and id_semestre = (
                        select semestre
                        from materiaprograma
                        where id_materia = $materia
                    )
                    and materiaprograma.id_materia = $materia");
    }
    
    public function cargarNumeroAlumnosValidaciones($materia) {
        return $this->find("columns: count(*) as resultado",
                "join: join alumno on matricula.id_alumno = alumno.id_alumno
                    join alumnoprograma on alumno.id_alumno = alumnoprograma.id_alumno
                    join programa on alumnoprograma.id_programa = programa.id_programa
                    join materiaprograma on programa.id_programa = materiaprograma.id_programa
                    join materia on materiaprograma.id_materia = materia.id_materia
                    join validacion on materia.id_materia = validacion.id_materia",
                "conditions: id_estadomatricula = 1 and materiaprograma.id_materia = $materia");
    }
    
    public function cargarSemestres($codigo, $estado) {
        return $this->find("columns: matricula.id_semestre,nombre_semestre",
                "join: join alumno on matricula.id_alumno = alumno.id_alumno
                    join semestre on matricula.id_semestre = semestre.id_semestre",
                "conditions: alumno.identificacion_alumno = $codigo and id_estadomatricula = $estado");
    }
}
