<?php

Load::models('Alumno');

class EvaluationController extends AppController {
    public function evaluacionDocente() {
        View::template('grade');
        
        $this->view = 3;
        $this->titulosc = "EVALUACIÓN DOCENTE";
    }
    
    public function encuestaDocente() {
        View::template(NULL);
        
        $alumno = new Alumno();
        
        $codigo = filter_var(Input::request('codigo'), FILTER_SANITIZE_STRING);
        
        if($alumno->validarCodigo($codigo)){
            $this->estado = 1;
            /*$this->datosAlumno = $alumno->cargarDatosAlumno($codigo);
            $this->inactivos = $matricula->cargarSemestres($codigo, 2);
            $this->activo = $matricula->cargarSemestres($codigo, 1);*/
        }else{
            $this->estado = 0;
        }
    }
}
