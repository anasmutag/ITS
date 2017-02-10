<?php

Load::models('Alumno', 'Docente', 'Encuestadocente');

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
            $docente = new Docente();
            
            $this->estado = 1;
            $this->alumno = $alumno->cargarDatosAlumno($codigo);
            /*$this->inactivos = $matricula->cargarSemestres($codigo, 2);
            $this->activo = $matricula->cargarSemestres($codigo, 1);*/
            
            $profesores = $docente->cargarDocentesEvaluacion($codigo);
            $this->docentes = $profesores;
            $encuestaprofesor = Array();
            
            foreach($profesores as $profesor){
                $encuestadocente = new Encuestadocente();
                
                $encuesta = $encuestadocente->cargarEncuestaDocente($profesor->id_docente);
                
                array_push($encuestaprofesor, $encuesta);
            }
            
            $this->encuestas = $encuestaprofesor;
        }else{
            $this->estado = 0;
        }
    }
    
    public function encuesta() {
        View::template(NULL);
        
        $encuesta = json_decode(stripslashes(Input::request('encuesta')));
        
        $this->encuesta = $encuesta;
    }
}
