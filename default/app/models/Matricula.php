<?php

class Matricula extends ActiveRecord {
    /*public function cargarDatosMatriculaActualizarValidaciones($alumno) {
        return $this->find("coditions: id_alumno = $alumno and id_estadomatricula = 1");
    }*/
    
    public function cargarAlumnosMateria($sede, $programa, $materia) {
        return $this->find("columns: alumno.id_alumno,alumno.identificacion_alumno,alumno.nombre_alumno,alumno.apellido_alumno,materia.id_materia",
                "join: join alumno on matricula.id_alumno = alumno.id_alumno
                    join alumnoprograma on alumno.id_alumno = alumnoprograma.id_alumno
                    join programa on alumnoprograma.id_programa = programa.id_programa
                    join materiaprograma on programa.id_programa = materiaprograma.id_programa
                    join materia on materiaprograma.id_materia = materia.id_materia",
                "conditions: matricula.id_sede = $sede
                    and programa.id_programa = $programa
                    and materia.id_materia = $materia
                    and matricula.id_estadomatricula = 1
                    and matricula.id_semestre = materiaprograma.semestre",
                "order: apellido_alumno");
    }
    
    public function cargarAlumnosMateriaPerdida($sede, $programa, $materia) {
        return $this->find("columns: alumno.id_alumno,alumno.identificacion_alumno,alumno.nombre_alumno,alumno.apellido_alumno,materia.id_materia",
                "join: join alumno on matricula.id_alumno = alumno.id_alumno
                    join alumnoprograma on alumno.id_alumno = alumnoprograma.id_alumno
                    join programa on alumnoprograma.id_programa = programa.id_programa
                    join materiaprograma on programa.id_programa = materiaprograma.id_programa
                    join materia on materiaprograma.id_materia = materia.id_materia",
                "conditions: matricula.id_sede = $sede
                    and programa.id_programa = $programa
                    and materia.id_materia = $materia
                    and matricula.id_estadomatricula = 2
                    and matricula.id_semestre = materiaprograma.semestre",
                "order: apellido_alumno");
    }
    
    /*public function cargarAlumnosMateriaValidaciones($sede, $programa, $materia) {
        return $this->find("columns: validacion.id_validacion,alumno.id_alumno,alumno.identificacion_alumno,alumno.nombre_alumno,alumno.apellido_alumno,materia.id_materia",
                "join: join alumno on matricula.id_alumno = alumno.id_alumno
                    join alumnoprograma on alumno.id_alumno = alumnoprograma.id_alumno
                    join programa on alumnoprograma.id_programa = programa.id_programa
                    join materiaprograma on programa.id_programa = materiaprograma.id_programa
                    join materia on materiaprograma.id_materia = materia.id_materia
                    join validacion on materia.id_materia = validacion.id_materia
                    join pagovalidacion on validacion.id_validacion = pagovalidacion.id_validacion",
                "conditions: matricula.id_sede = $sede
                    and programa.id_programa = $programa
                    and materia.id_materia = $materia
                    and matricula.id_semestre = materiaprograma.semestre
                    and estado_pagovalidacion = 2",
                "order: apellido_alumno");
    }*/
    
    public function cargarNumeroAlumnosSemestre($sede, $materia) {
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
                    and id_sede = $sede
                    and materiaprograma.id_materia = $materia");
    }
    
    /*public function cargarNumeroAlumnosValidaciones($materia) {
        return $this->find("columns: count(*) as resultado",
                "join: join alumno on matricula.id_alumno = alumno.id_alumno
                    join alumnoprograma on alumno.id_alumno = alumnoprograma.id_alumno
                    join programa on alumnoprograma.id_programa = programa.id_programa
                    join materiaprograma on programa.id_programa = materiaprograma.id_programa
                    join materia on materiaprograma.id_materia = materia.id_materia
                    join validacion on materia.id_materia = validacion.id_materia
                    join pagovalidacion on validacion.id_validacion = pagovalidacion.id_validacion",
                "conditions: materiaprograma.id_materia = $materia
                    and estado_pagovalidacion = 2");
    }*/
    
    public function cargarSemestres($codigo, $estado) {
        return $this->find("columns: matricula.id_semestre,nombre_semestre",
                "join: join alumno on matricula.id_alumno = alumno.id_alumno
                    join semestre on matricula.id_semestre = semestre.id_semestre",
                "conditions: alumno.identificacion_alumno = $codigo and id_estadomatricula = $estado");
    }
    
    public function validarConvalidacion($alumno) {
        if($this->find("columns: convalidacion_matricula as resultado",
                "conditions: id_alumno = $alumno")[0]->resultado != 0){
            return true;
        }else{
            return false;
        }
    }
    
    public function cargarSemestreConvalidacion($alumno) {
        return $this->find("columns: id_semestre",
                "conditions: id_alumno = $alumno");
    }
    
    public function cargarSemestreActivoAlumno($alumno) {
        return $this->find("columns: id_semestre",
                "conditions: id_estadomatricula = 1
                    and id_alumno = (
                        select id_alumno
                        from alumno
                        where identificacion_alumno = $alumno
                    )");
    }
}
