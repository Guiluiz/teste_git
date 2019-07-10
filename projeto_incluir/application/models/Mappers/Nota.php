<?php

class Application_Model_Mappers_Nota {

    private $db_nota;

    public function lancamentoNotaAlunos($atividade, $notas, $id_turma_atividades, $id_turma_alunos) {
        try {
            if (!empty($id_turma_alunos) && !empty($id_turma_atividades) && isset($id_turma_atividades[$atividade])) {
                $this->db_nota = new Application_Model_DbTable_NotasAlunos();
                // Como as atividades são exclusivas para uma única turma, é possível excluir o lançamento atual apenas pelo id da atividade

                $this->db_nota->delete($this->db_nota->getAdapter()->quoteInto('nota_aluno.id_atividades_turma = ?', $id_turma_atividades[$atividade]));

                if (!empty($notas)) {
                    foreach ($notas as $id_aluno => $nota) {
                        if ($nota instanceof Application_Model_Nota && isset($id_turma_alunos[$id_aluno])) {
                            $aux = $nota->parseArray();
                            $aux['id_turma_aluno'] = $id_turma_alunos[$id_aluno];
                            $aux['id_atividades_turma'] = $id_turma_atividades[$atividade];

                            $this->db_nota->insert($aux);
                        }
                    }
                }
                return true;
            }
            return false;
        } catch (Zend_Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
    
    
    /**
     * Retorna as notas dos alunos organizados por turma. Utilizado para efetuar a finalização do semestre
     * @return null
     * @throws Exception
     */
    public function getNotasAlunos() {
        try {
            $this->db_nota = new Application_Model_DbTable_NotasAlunos();
            $select = $this->db_nota->select()
                    ->setIntegrityCheck(false)
                    ->from('nota_aluno', array('id_nota', 'id_turma_aluno', 'id_atividades_turma', 'valor_nota'))
                    ->joinleft('turma_alunos', 'nota_aluno.id_turma_aluno = turma_alunos.id_turma_aluno',array())
                    ->joinleft('turma', 'turma_alunos.id_turma = turma.id_turma',array())                
                    ->joinInner('periodo', 'turma.id_periodo = periodo.id_periodo', array())
                    ->where('periodo.is_atual = ?', true);
                   
            $notas = $this->db_nota->fetchAll($select);
            echo $select;
            if (!empty($notas)) {
                $array_notas = array();

                foreach ($notas as $nota)
                    $array_notas[$nota->id_atividades_turma][$nota->id_nota] = $nota->valor_nota;

                return $array_notas;
            }
            return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

}
