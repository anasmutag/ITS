<?php

Load::models('Alumno', 'Docente', 'Encuestadocente', 'Encuesta', 'Matricula');

class EvaluationController extends AppController {
    public function evaluacionDocente() {
        View::template('grade');
        
        $this->view = 3;
        $this->titulosc = "EVALUACIÓN DOCENTE";
    }
    
    public function encuestaDocente($codigo) {
        View::template('grade');
        
        $this->view = 3;
        $this->titulosc = "EVALUACIÓN DOCENTE";
        
        $alumno = new Alumno();
        
        $identificacion = filter_var($codigo, FILTER_SANITIZE_STRING);
        
        if($alumno->validarCodigo($identificacion)){
            $docente = new Docente();
            $encuesta = new Encuesta();
            
            $this->estado = 1;
            $this->codigo = $codigo;
            $this->alumno = $alumno->cargarDatosAlumno($identificacion);
            
            $encuestasrealizadas = $encuesta->cargarEncuestasRealizadas($identificacion);
            
            if(empty($encuestasrealizadas)){
                $profesores = $docente->cargarDocentesEvaluacionTotal($identificacion);
            }else{
                $profesores = $docente->cargarDocentesEvaluacionTotal($identificacion);
                
                foreach ($profesores as $key => $profesor) {
                    foreach ($encuestasrealizadas as $er) {
                        if ($profesor->id_docente == $er->docente_encuesta && $er->cantidad > 1) {
                            unset($profesores[$key]);
                        }
                    }
                }
            }
            
            $encuestasprofesores = Array();
            
            foreach($profesores as $profesor){
                $encuestadocente = new Encuestadocente();
                
                $encuesta = $encuestadocente->cargarEncuestaDocente($profesor->id_docente);
                
                array_push($encuestasprofesores, $encuesta);
            }
            
            $this->encuestas = $encuestasprofesores;
        }else{
            $this->estado = 0;
            $this->codigo = 0;
        }
    }
    
    public function encuesta() {
        View::template(NULL);
        
        $matricula = new Matricula();
        
        $encuesta = json_decode(stripslashes(Input::request('encuesta')));
        $codigo = Input::request('codigo');
        
        $this->encuesta = $encuesta;
        $this->codigo = $codigo;
        
        $this->semestre = $matricula->cargarSemestreActivoAlumno($codigo)[0]->id_semestre;
    }
    
    public function registroencuestaalumno() {
        View::select(NULL, NULL);
        
        $encuesta = new Encuesta();
        $alumno = new Alumno();
        
        $codigo = Input::request('alumno');
        $docente = Input::request('docente');
        $semestre = Input::request('semestre');
        
        $arr['res'] = 'fail';
        $arr['msg'] = '';
        
        $encuesta->begin();
        
        $encuesta->docente_encuesta = $docente;
        $encuesta->semestre_encuesta = $semestre;
        $encuesta->id_alumno = $alumno->cargarIdAlumno($codigo)[0]->id_alumno;
        
        if($encuesta->save()){
            $arr['res'] = 'ok';
            
            $encuesta->commit();
        }else{
            $arr['msg'] = 'Ocurrio un error en el registro de la evaluación docente';
            
            $encuesta->rollback();
        }

        exit(json_encode($arr));
    }
}
