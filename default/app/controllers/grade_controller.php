<?php

Load::models('Docente', 'Programa', 'Materia', 'Materiaprograma', 'Matricula', 'Alumno', 'Nota', 'Validacion', 'Pagovalidacion');

class GradeController extends AppController {
    public function consultaNotas() {
        View::template('grade');
        
        $this->view = 1;
        $this->titulosc = "CONSULTA DE CALIFICACIONES";
    }
    
    public function consultarNotas() {
        View::template(NULL);
        
        $alumno = new Alumno();
        $matricula = new Matricula();
        
        $codigo = filter_var(Input::request('codigo'), FILTER_SANITIZE_STRING);
        
        if($alumno->validarCodigo($codigo)){
            $this->estado = 1;
            $datosAlumno = $alumno->cargarDatosAlumno($codigo);
            $this->datosAlumno = $datosAlumno;
            
            if($matricula->validarConvalidacion($datosAlumno[0]->id_alumno)){
                $this->semestrecv = $matricula->cargarSemestreConvalidacion($datosAlumno[0]->id_alumno)[0]->id_semestre;
            }else{
                $this->semestrecv = NULL;
                $this->inactivos = $matricula->cargarSemestres($codigo, 2);
            }
            
            $this->activo = $matricula->cargarSemestres($codigo, 1);
        }else{
            $this->estado = 0;
            $this->codigo = $codigo;
        }
    }
    
    public function mostrarNotas() {
        View::template(NULL);
        
        $nota = new Nota();
        $validacion = new Validacion();
        $alumno = new Alumno();
        
        $codigo = Input::request('codigo');
        $semestre = Input::request('semestre');
        
        $this->tipoperiodo = $semestre;
        $this->estado = Input::request('estado');
        $this->alumno = $alumno->cargarIdAlumno($codigo)[0]->id_alumno;
        
        if($semestre < 0){
            $this->semestres = $nota->cargarSemestresAlumno($codigo);
            $this->materias = $nota->cargarMateriasAlumno($codigo);
            $this->notas = $nota->cargarNotasAlumno($codigo);
            $this->validaciones = $validacion->cargarNotasValidcionesAlumno($codigo);
        }else{
            $this->semestres = $nota->cargarSemestreAlumno($codigo, $semestre);
            $this->materias = $nota->cargarMateriasSemestreAlumno($codigo, $semestre);
            $notas = $nota->cargarNotasSemestreAlumno($codigo, $semestre);
            
            $materia = $notas[0]->id_materia;
            $tiponota = $notas[0]->id_tiponota;
            $count = 0;
            
            foreach ($notas as $key => $n) {
                if($n->id_materia == $materia && $n->id_tiponota == $tiponota){
                    $count += 1;
                }else{
                    
                    if($count === 2){
                        unset($notas[$key - 2]);
                    }
                    
                    $materia = $notas[$key]->id_materia;
                    $tiponota = $notas[$key]->id_tiponota;
                    $count = 1;
                }
            }
            
            $this->notas = $notas;
            //$this->notas = $nota->cargarNotasSemestreAlumno($codigo, $semestre);
            $this->validaciones = $validacion->cargarNotasValidcionesSemestreAlumno($codigo, $semestre);
        }
    }
}
