<?php

/**
 * @author : Yuri Samuel
 * @since : 27/02/2017 18:24
 * @version: 1.0
 *
 */
class Rastreabilidade
{
    protected $pdo = null;

    /**
     *Construtor da class
     * @param $conexao - conexão com o banco de dados
     *
     */
    public function __construct(){
        $this->pdo = Conexao::instaciar();
    }
    public function codigoUnicoRequisito(){
        $nomeTabela = $_REQUEST['form'];
        $sql = 'select codigo from ' . $nomeTabela . ' where id_' . $nomeTabela . ' = (select max(id_' . $nomeTabela . ') from ' . $nomeTabela . ')';
        $stm = $this->pdo->prepare($sql);
        $stm->execute();
        $codigo = $stm->fetch(PDO::FETCH_ASSOC);
        if ($codigo){
            $codigo = substr($codigo['codigo'], (strlen($nomeTabela) > 2) ? 4 : 3);
            if ((int)$codigo < 10){
                $codigo = strtoupper($nomeTabela) . '-00' . strval((int)$codigo+1);
            } else if ((int)$codigo < 100){
                $codigo = strtoupper($nomeTabela) . '-0' . strval((int)$codigo+1);
            } else {
                $codigo = strtoupper($nomeTabela) . '-' . strval((int)$codigo+1);
            }
        }else {
            $codigo = strtoupper($nomeTabela) . '-000';
        }
        return $codigo;
    }

}