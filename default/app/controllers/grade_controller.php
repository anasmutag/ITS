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
            $this->notas = $nota->cargarNotasSemestreAlumno($codigo, $semestre);
            $this->validaciones = $validacion->cargarNotasValidcionesSemestreAlumno($codigo, $semestre);
        }
    }
    
    public function registroNotas($tipo = 1) {
        if(Auth::is_valid()){
            if($tipo === 1){
                Router::redirect("docentes/registro_notas/");
            }else{
                Router::redirect("docentes/registro_notas/validaciones/");
            }
        }else{
            View::template('grade');
            
            if($tipo === 1){
                $this->view = 2;
            }else{
                $this->view = 3;
            }
            
            $this->titulosc = "REGISTRO DE CALIFICACIONES";
            $this->tipo = $tipo;
        }
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
                $this->programas = $programa->programasDocente(Auth::get('id_docente'));
            }else{
                $this->view = 3;
                $this->programas = $programa->programas();
            }
            
            $this->titulosc = "REGISTRO DE CALIFICACIONES";
            $this->tipo = $tipo;
        }else{
            Router::redirect("docentes/inicio/");
        }
    }
    
    public function obtenerMaterias($idprograma = '0', $tipo) {
        View::select(NULL, NULL);
        
        $materiaprograma = new Materiaprograma();
        
        if($tipo == 1){
            echo json_encode($materiaprograma->materiasProgramaDocente($idprograma, Auth::get('id_docente')));
        }else{
            echo json_encode($materiaprograma->materiasprograma($idprograma));
        }
    }
    
    public function notas() {
        View::template(NULL);
        
        $matricula = new Matricula();
        $nota = new Nota();
        
        $sede = Input::request('sede');
        $programa = Input::request('programa');
        $materia = Input::request('materia');
        
        $this->tiponota = $nota->cargarTiposNotas($sede, $materia);
        $this->numeroalumnos = $matricula->cargarNumeroAlumnosSemestre($sede, $materia);
        $this->alumnos = $matricula->cargarAlumnosMateria($sede, $programa, $materia);
        $this->idmateria = $materia;
    }
    
    public function validaciones() {
        View::template(NULL);
        
        //$matricula = new Matricula();
        $validacion = new Validacion();
        
        $sede = Input::request('sede');
        $programa = Input::request('programa');
        $materia = Input::request('materia');
        
        //$this->numeroalumnos = $matricula->cargarNumeroAlumnosValidaciones($materia);
        $this->numeroalumnos = $validacion->cargarNumeroAlumnosValidaciones($sede, $programa, $materia);
        //$this->alumnos = $matricula->cargarAlumnosMateriaValidaciones($sede, $programa, $materia);
        $this->alumnos = $validacion->cargarAlumnosMateriaValidaciones($sede, $programa, $materia);
        $this->idmateria = $materia;
    }
    
    public function registrarNotasAlumnos() {
        View::select(NULL, NULL);
        
        $grade = new Nota();
        
        $tiponota = Input::request('tiponota');
        $materia = Input::request('idmateria');
        $notas = json_decode(stripslashes(Input::request('notas')));
        $docente = Input::request('docente');
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
            $nota->docente_nota = $docente;
            $nota->faltas_nota = $n->faltas;

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
                        $pagovalidacion = new Pagovalidacion();
                        
                        $validacion->valor_validacion = '0';
                        $validacion->id_alumno = $n->idalumno;
                        $validacion->id_materia = $materia;
                        
                        if($validacion->save()){
                            $pagovalidacion->valor_pagovalidacion = '0';
                            $pagovalidacion->id_validacion = $validacion->id_validacion;
                            
                            if(!$pagovalidacion->save()){
                                $bannotas = 0;
                            }
                        }else{
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
                $pagovalidacion = new Pagovalidacion();
                
                $validacion->cargarDatosValidacion($n->idvalidacion);
                $validacion->valor_validacion = $n->valor;
                $validacion->docente_validacion = Auth::get('id_docente');
                
                if($validacion->update()){
                    $pagovalidacion->cargarDatosPagoValidacion($n->idvalidacion);
                    
                    if($validacion->valor_validacion >= 3.5){
                        $pagovalidacion->estado_pagovalidacion = 3;
                    }else{
                        $pagovalidacion->estado_pagovalidacion = 1;
                    }
                    
                    if(!$pagovalidacion->update()){
                        $bannotas = 0;
                    }
                }else{
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
