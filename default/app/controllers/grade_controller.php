<?php

Load::models('Docente', 'Programa', 'Materia', 'Materiaprograma', 'Matricula', 'Alumno', 'Nota', 'Validacion');

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
            $this->datosAlumno = $alumno->cargarDatosAlumno($codigo);
            $this->inactivos = $matricula->cargarSemestres($codigo, 2);
            $this->activo = $matricula->cargarSemestres($codigo, 1);
        }else{
            $this->estado = 0;
        }
    }
    
    public function mostrarNotas() {
        View::template(NULL);
        
        $nota = new Nota();
        
        $codigo = Input::request('codigo');
        $semestre = Input::request('semestre');
        
        $this->tipoperiodo = $semestre;
        $this->estado = Input::request('estado');
        
        if($semestre < 0){
            $this->semestres = $nota->cargarSemestresAlumno($codigo);
            $this->materias = $nota->cargarMateriasAlumno($codigo);
            $this->notas = $nota->cargarNotasAlumno($codigo);
        }else{
            $this->semestres = $nota->cargarSemestreAlumno($codigo, $semestre);
            $this->materias = $nota->cargarMateriasSemestreAlumno($codigo, $semestre);
            $this->notas = $nota->cargarNotasSemestreAlumno($codigo, $semestre);
        }
    }
    
    public function registroNotas($tipo = 1) {
        View::template('grade');
        
        if($tipo === 1){
            $this->view = 2;
        }else{
            $this->view = 3;
        }
        
        $this->titulosc = "REGISTRO DE CALIFICACIONES";
        $this->tipo = $tipo;
    }
    
    public function logearDocente() {
        View::select(NULL, NULL);
        
        $arr['res'] = 'fail';
        $arr['msg'] = '';
        
        $identificacion = Input::request('identificacion');
        $contrasena = Input::request('contrasena');
        
        $docente = new Docente();
        
        if($docente->validarDocente($identificacion, $contrasena)->RESUL == true){
            $auth = new Auth("model", "class: docente", "identificacion_docente: $identificacion");

            if($auth->authenticate()){
                $arr['res'] = 'ok';
            }else{
                $arr['msg'] = 'Ocurrio un error inesperado. Intenta nuevamente';
            }
        }else{
            $arr['msg'] = 'Identificacion o contraseña invalida';
        }

        exit(json_encode($arr));
    }
    
    public function salirDocente($tipo = 1) {
        Auth::destroy_identity();
        
        if($tipo === 1){
            Router::redirect("docentes/inicio/");
        }else{
            Router::redirect("docentes/inicio/validaciones/");
        }
    }
    
    public function registrarNotas($tipo = 1) {
        if(Auth::is_valid()){
            View::template('grade');
            
            $programa = new Programa();
            
            if($tipo === 1){
                $this->view = 2;
            }else{
                $this->view = 3;
            }
            
            $this->titulosc = "REGISTRO DE CALIFICACIONES";
            $this->programas = $programa->programas();
            $this->tipo = $tipo;
        }else{
            Router::redirect("docentes/inicio/");
        }
    }
    
    public function obtenerMaterias($idprograma = '0') {
        View::select(NULL, NULL);
        
        $materiaprograma = new Materiaprograma();
        
        echo json_encode($materiaprograma->materiasprograma($idprograma));
    }
    
    public function notas() {
        View::template(NULL);
        
        $matricula = new Matricula();
        $nota = new Nota();
        
        $sede = Input::request('sede');
        $programa = Input::request('programa');
        $materia = Input::request('materia');
        
        $this->tiponota = $nota->cargarTiposNotas($materia);
        $this->numeroalumnos = $matricula->cargarNumeroAlumnosSemestre($materia);
        $this->alumnos = $matricula->cargarAlumnosMateria($sede, $programa, $materia);
        $this->idmateria = $materia;
    }
    
    public function validaciones() {
        View::template(NULL);
        
        $matricula = new Matricula();
        
        $sede = Input::request('sede');
        $programa = Input::request('programa');
        $materia = Input::request('materia');
        
        $this->numeroalumnos = $matricula->cargarNumeroAlumnosValidaciones($materia);
        $this->alumnos = $matricula->cargarAlumnosMateriaValidaciones($sede, $programa, $materia);
        $this->idmateria = $materia;
    }
    
    public function registrarNotasAlumnos() {
        View::select(NULL, NULL);
        
        $grade = new Nota();
        
        $tiponota = Input::request('tiponota');
        $materia = Input::request('idmateria');
        $notas = json_decode(stripslashes(Input::request('notas')));
        $bannotas = 1;
        
        $arr['res'] = 'fail';
        $arr['msg'] = '';
        
        $grade->begin();
        
        foreach ($notas as $n) {
            $nota = new Nota();
            
            if($n->valor == 0){
                $g = '0';
                $nota->valor_nota = $g;
            }else{
                $nota->valor_nota = $n->valor;
            }
            
            $nota->id_tiponota = $tiponota;
            $nota->id_alumno = $n->idalumno;
            $nota->id_materia = $materia;

            if($nota->save()){
                if($tiponota == 3){
                    $notamateria = new Nota();
                    
                    $notasmateria = $notamateria->cargarNotasMateria($n->idalumno, $materia);
                    $definitiva = 0;
                    
                    foreach($notasmateria as $nm):
                        switch($nm->id_tiponota):
                            case 1:
                                $definitiva += ($nm->valor_nota*0.3);
                                break;
                            case 2:
                                $definitiva += ($nm->valor_nota*0.3);
                                break;
                            case 3:
                                $definitiva += ($nm->valor_nota*0.4);
                                break;
                        endswitch;
                    endforeach;
                    
                    if($definitiva < 3.5){
                        $validacion = new Validacion();
                        
                        $validacion->valor_validacion = '0';
                        $validacion->id_alumno = $n->idalumno;
                        $validacion->id_materia = $materia;
                        
                        if(!$validacion->save()){
                            $bannotas = 0;
                        }
                    }
                }
            }else{
                $bannotas = 0;
            }
        }
        
        if($bannotas === 1){
            $arr['res'] = 'ok';
            
            $grade->commit();
        }else{
            $arr['msg'] = 'El registro de notas no fue exitoso. Intentar nuevamente';
            
            $grade->rollback();
        }
        
        exit(json_encode($arr));
    }
    
    public function registrarNotasValidacionesAlumnos() {
        View::select(NULL, NULL);
        
        $grade = new Validacion();
        
        $notas = json_decode(stripslashes(Input::request('notas')));
        $bannotas = 1;
        
        $arr['res'] = 'fail';
        $arr['msg'] = '';
        
        $grade->begin();
        
        foreach ($notas as $n) {
            if($n->valor !== '0'){
                $validacion = new Validacion();
                
                $validacion->cargarDatosValidacion($n->idvalidacion);
                $validacion->valor_validacion = $n->valor;
                
                if(!$validacion->update()){
                    $bannotas = 0;
                }
            }
        }
        
        if($bannotas === 1){
            $arr['res'] = 'ok';
            
            $grade->commit();
        }else{
            $arr['msg'] = 'El registro de calificaciones de validacion no fue exitoso. Intentar nuevamente';
            
            $grade->rollback();
        }
        
        exit(json_encode($arr));
    }
}
