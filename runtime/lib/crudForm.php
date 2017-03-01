<?php

/**
 * @author : Yuri Samuel
 * @since : 29/01/2017 01:54
 * @version: 1.0
 *
 */

class CrudForm
{
    protected $pdo = null;

    protected static $crudFormObj = null;

    private $line = false;

    private $qtdButton = 0;

    private $lineButton = false;

    private $htmlButtons = '';

    private $formEstaAberto = false;

    private  static $formObj = false;

    /*
     * Status de um requsito
     * */
    const StatusNaoIniciado = 1;

    const StatusFilaParaDesenvolvimento = 2;

    const StatusEmDesenvolvimento = 3;

    const StatusImplementado = 4;

    public static $statusRequsitos = array(
        self::StatusNaoIniciado => 'Não iniciado',
        self::StatusFilaParaDesenvolvimento => 'Fila p/ Desenvolvimento',
        self::StatusEmDesenvolvimento => 'Em Desenvolvimento',
        self::StatusImplementado => 'Implementado'
    );

     /*
     * Niveis de Prioridade
     * */
    const PrioridadeBaixa = 1;

    const PrioridadeMedia = 2;

    const PrioridadeAlta = 3;

    public static $prioridades = array(
        self::PrioridadeBaixa => 'Baixa',
        self::PrioridadeMedia => 'Media',
        self::PrioridadeAlta => 'Alta'
    );


    /**
     *Construtor da class
     * @param $conexao - conexão com o banco de dados
     *
     */
    public function __construct(){
        $this->pdo = Conexao::instaciar();
    }

    /**
     *
     * @param $conexao - conexão com o banco de dados
     * @return $crudFormObj - Instancia da class CrudForm
     *
     */
    public static function instanciar($conexao){
        if (!isset(self::$crudForm)){
            self::$crudFormObj = new CrudForm($conexao);
        }
        return self::$crudFormObj;
    }

    public function beginForm($tituloFormulario = ''){
        $name = get_class($this);
        $html = '';
        $html .= '<div class="panel panel-default" id="panelContent">';
        $html .= '    <div class="panel-heading">';
        $html .= '        <h3 class="panel-title">' . $tituloFormulario . '</h3>';
        $html .= '    </div>';
        $html .= '    <div class="panel-body">';
        $html .= '      <form id="' . ucwords(str_replace(' ', '', $tituloFormulario)) . '" name="' . $name . '" class="form">';
        $this->formEstaAberto = true;
        echo $html;
    }

    public function endForm(){
        if ($this->formEstaAberto){
            $html = '';
            $html .= '    </form>';
            $html .= '  </div>';
            $html .= '</div>';
            $this->formEstaAberto = false;
            echo $html;
        } else {
            throw new Exception('Nenhum formulario aberto');
        }
    }

    public function inputString($label = '', $placeholder = '', $size, $value = '', $name, $jsOnChange = '', $readOnly = false){
        $html = '';
        $divHorizontalAbre = '';
        $divHorizontalFecha  = '';
        if (!$size){
            throw new Exception('variavel size não pode ser nulo');
        }
        if ($label){
            $label = '<label for="'. $name .'">'. $label .'</label>';
            $divHorizontalAbre = '<div class="form-horizontal">';
            $divHorizontalFecha = '</div>';
        }
        $placeholder = ($placeholder) ? 'placeholder="' . $placeholder . '"' : '';
        $readOnly = ($readOnly) ? 'readonly' : '';
        if (!$this->line){
            $html .= '<div class="row linha-input">';
        }
        $html .= '  <div class="col-md-'. $this->getTamanhoInput($size) . '">';
        $html .= $divHorizontalAbre;
        $html .= $label;
        $html .= '      <input type="text" class="form-control" ' . $placeholder . ' maxlength="' . $size . '" name="' . $name . '" value="' . $value . '" id="' . get_class($this) . '_' .$name . '"' . $readOnly . '>';
        $html .= $divHorizontalFecha;
        $html .= '  </div>';
        if (!$this->line){
            $html .= '</div>';
        }

        echo $html;
    }

    public function comboBox($label = '', $name, $aLista, $jsOnChange = '', $col = 5){
        if ($name && $aLista){
            $html = '';
            if (!$this->line){
                $html .= '<div class="row linha-input">';
            }
            if ($label){
                $label = '<label for="'. $name .'">'. $label .'</label>';
            }
            $html .= '  <div class="col-md-'. $col . '">';
            $html .= $label;
            $html .= '      <select class="form-control" name="' . $name . '">';
            foreach ($aLista as $chave => $valor){
                $html .= '      <option value="' . $chave . '">' . $valor . '</option>';
            }
            $html .= '       </select>';
            $html .= '  </div>';
            if (!$this->line){
                $html .= '</div>';
            }
            echo $html;
        } else {
            throw new Exception('$ Nome  e $ a não podem ser nulos');
        }
    }

    public function button($conteudo = '', $acao = 'inicializar', $single = false, $irParaForm = ''){
        if (!$this->lineButton){
            $this->htmlButtons .= '<div class="row linha-input">';
        }
        $this->htmlButtons .= '  <div class="col-md-[TAMANHO_COLUNA]">';
        $this->htmlButtons .= '      <button type="button" name="' . $acao . '" id="button_' .  $acao . '" class="btn btn-default btn-inline" value="valor qualquer">' . $conteudo . '</button>';
        if ($irParaForm){
            $this->htmlButtons .= '<input type="hidden" id="irPara" value="' . $irParaForm . '">';
        }
        $this->htmlButtons .= '  </div>';
        if (!$this->lineButton){
            $this->htmlButtons .= '</div>';
        }
        if ($single){
            echo $this->htmlButtons;
        }
        $this->qtdButton++;
    }

    public function beginLineButton(){
        if ($this->lineButton){
            throw new Exception('Uma linha para botoes ja foi aberta, use endLineButton para fechar a linha.');
        } else {
            $this->lineButton = true;
        }
    }
    public function endLineButton(){
        if (!$this->lineButton){
            throw new Exception('A linha para botões ja foi fechada, use beginlineButton para abrir um nova linha.');
        } else if ($this->qtdButton<=12) {
            $this->htmlButtons = str_replace('[TAMANHO_COLUNA]', (int)number_format(12/$this->qtdButton, 1, ".", ""), $this->htmlButtons);
            echo $this->htmlButtons;
            $this->htmlButtons = '';
            $this->qtdButton = 0;
            $this->lineButton = false;
        } else {
            throw new Exception('Botões não podem ser exibidos pois quantidade máxima de botões em uma linha é 12');
        }
    }

    public function inputStringTextarea($label = '', $placeholder = '', $rows, $columns = 12,$size, $value = '', $name, $jsOnChange = '', $readOnly = false){
        $html = '';
        $divHorizontalAbre = '';
        $divHorizontalFecha  = '';
        if (!$rows){
            throw new Exception('variavel rows não pode ser nulo');
        }
        if ($label){
            $label = '<label for="'. $name .'">'. $label .'</label>';
            $divHorizontalAbre = '<div class="form-horizontal">';
            $divHorizontalFecha = '</div>';
        }
        $placeholder = ($placeholder) ? 'placeholder="' . $placeholder . '"' : '';
        $readOnly = ($readOnly) ? 'readonly' : '';
        if (!$this->line){
            $html .= '<div class="row linha-input">';
        }
        $html .= '  <div class="col-md-'. (int)$columns . '">';
        $html .= $divHorizontalAbre;
        $html .= $label;
        $html .= '      <textarea class="form-control" rows="' . $rows . '"' . $placeholder . ' maxlength="' . $size . '" name="' . $name . '" ' . $readOnly . '>' . $value . '</textarea>';
        $html .= $divHorizontalFecha;
        $html .= '  </div>';
        if (!$this->line){
            $html .= '</div>';
        }

        echo $html;
    }

    public function lookup($label, $name, $lookupTabela, $lookupCampo, $aValues = null, $size = 120, $jsOnChange = '', $readOnly = false){
        $html = '';
        $divHorizontalAbre = '';
        $divHorizontalFecha  = '';
        if (!$size){
            throw new Exception('variavel size não pode ser nulo');
        }
        if ($label){
            $label = '<label for="'. $name .'">'. $label .'</label>';
            $divHorizontalAbre = '<div class="form-horizontal">';
            $divHorizontalFecha = '</div>';
        }
        $readOnly = ($readOnly) ? 'readonly' : '';
        if (!$this->line){
            $html .= '<div class="row linha-input">';
        }
        $html .= '  <div class="col-md-'. $this->getTamanhoInput($size) . '">';
        $html .= $divHorizontalAbre;
        $html .= $label;
        /*Componente fcbkcomplete (lookup)*/
        $html .= '<select id="' . get_class($this) . '_' . $name . '" name="' . $name . '" class="lookup">';
        if ($aValues){
            foreach ($aValues as $chave => $valor){
                $html .= '    <option value="' . $chave . '" class="selected">' . $valor . '</option>';
            }
        }
        $html .= '</select>';
        $html .= '<span class="glyphicon glyphicon-search" aria-hidden="true"></span>';
        $html .= $divHorizontalFecha;
        $html .= '  </div>';
        $html .= '<input type="hidden" id="lookupTabela" name="lookupTabela" value="' . $lookupTabela . '">';
        $html .= '<input type="hidden" id="lookupCampo"name="lookupCampo" value="' . $lookupCampo . '">';
        if (!$this->line){
            $html .= '</div>';
        }

        echo $html;
    }

    public function beginLine(){
        echo '<div class="row linha-input">';
        $this->line = true;
    }
    public function endLine(){
        echo '</div>';
        $this->line = false;
    }
    private function getTamanhoInput($num){
        if ($num && $num>0){
            if ($num>=20 && $num<110){
                $num = (int)($num-20)/10;
                return (int)$num+1;
            } else if ($num>=0 && $num<20) {
                return 1;
            } else {
                return 12;
            }
        } else {
            throw new Exception('Metodo getTamanhoInput() requer um numero inteiro > 0');
        }
    }

    /**
     * @param $aCamposValores[] - array com os valores para inserção e os nomes de seus respectivos campos no Banco de dados
     * @param $nomeTabela - string com nome da tabela
     */
    public function insert($aCamposValores, $nomeTabela){
        $aNomeCampos = array_keys($aCamposValores);
        try{
            $sql = 'INSERT INTO '. $nomeTabela . ' (' . implode(', ' , $aNomeCampos). ')';
            $sql .= ' VALUES ( :'. implode(', :' , $aNomeCampos) . ')';
            $stm = $this->pdo->prepare($sql);
            foreach ($aCamposValores as $campo => $valor){
                $stm->bindValue(':'.$campo, $valor);
            }
            $stm->execute();
        }catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    /**
     * @param $aNomeCampos
     * @param $aValores
     * @param $nomeTabela
     * @param $aIds - array de ids
     */
//    ************************************************************************************************
//    ******************CORRIGIR***********************************
//    SUBSTITUIR METODO getPlaceholders() POR FUNÇÃO array_fill()  do php

    public function update($aNomeCampos, $aValores, $nomeTabela, $aIds){
        if ($aNomeCampos && $aValores && $nomeTabela && $aIds){
            try{
                $placeholders = $this->getPlaceholders(count($aIds));
                $stm = $this->pdo->prepare('SELECT * FROM ' . $nomeTabela . ' WHERE ' . $this->getNomeId($nomeTabela) . ' in(' . implode(', ', $placeholders) . ') ');
                $i = 1;
                foreach ($aIds as $id){
                    $stm->bindValue($i, $id, PDO::PARAM_INT);
                    $i++;
                }
                $stm->execute();
                if ($stm->rowCount() > 0){
                    $campos = implode('=?, ', $aNomeCampos) . '=?';
                    $stm = $this->pdo->prepare('UPDATE ' . $nomeTabela . ' SET ' . $campos . ' WHERE ' . $this->getNomeId($nomeTabela) . ' in(' . implode(', ', $placeholders) . ') ');
                    $i = 1;
                    foreach ($aValores as $valor){
                        $stm->bindValue($i, $valor);
                        $i++;
                    }
                    foreach ($aIds as $id){
                        $stm->bindValue($i, $id, PDO::PARAM_INT);
                        $i++;
                    }
                    $stm->execute();
                }
            }catch (PDOException $e){
                echo $e->getMessage();
            }
        }
    }

    /**
     * @param $aIds - array de ids
     * @param $nomeTabela
     */
    public function delete($aIds, $nomeTabela){
        if ($aIds){
            $placeholders = $this->getPlaceholders(count($aIds));
            try{
                $stm = $this->pdo->prepare('DELETE FROM ' . $nomeTabela . ' WHERE ' . $this->getNomeId($nomeTabela) . ' in (' . implode(', ', $placeholders) . ') ');
                $i = 1;
                foreach ($aIds as $id){
                    $stm->bindValue($i, $id, PDO::PARAM_INT);
                    $i++;
                }
                $stm->execute();
            }catch (PDOException $e){
                echo $e->getMessage();
            }
        }
    }

    /**
     * Função de busca por id. Quando passado um array com os ids que deseja buscar
     * e o nome da tabela, a função retorna um array com os registro encontrados
     *
     * @param $aIds
     * @param $nomeTabela
     * @param string $aRetornoCampos
     * @return mixed
     */
    public function findById($aIds, $nomeTabela, $aRetornoCampos = '*'){
        if (is_array($aRetornoCampos)){
            $aRetornoCampos = implode(', ', $aRetornoCampos);
        }
        if ($aIds && $nomeTabela){
            try{
                $sql =  'SELECT ';
                $sql .=     $aRetornoCampos;
                $sql .= ' FROM ';
                $sql .=     $nomeTabela;
                $sql .= ' WHERE ';
                $sql .=     $this->getNomeId($nomeTabela) . ' in(' . implode(', ', $aIds) . ') ';
                $stm = $this->pdo->prepare($sql);
                $stm->execute();
                return $stm->fetchAll();
            }catch (PDOException $e){
                echo $e->getMessage();
            }
        }
    }

    /**
     * Função busca por nome de campo. Quando passado um array com os dados de busca e outro
     * com os nomes dos campos respectivamente, a função retorna um array com os registros
     * encontrados. $aBusca e $aNomeCampos quando diferentes de vazio devem conter a mesma
     * quantidade de indeces
     *
     * @param null $aBusca
     * @param null $aNomeCampos
     * @param $nomeTabela
     * @param string $aRetornoCampos
     * @return bool | array mixed
     */
    public function find($aBusca = null, $aNomeCampos = null, $nomeTabela, $aRetornoCampos = '*'){
        if (is_array($aRetornoCampos)){
            $aRetornoCampos = implode(', ', $aRetornoCampos);
        }
        if ($nomeTabela){
            try{
                $sql =  ' SELECT ';
                $sql .=     $aRetornoCampos;
                $sql .= ' FROM ';
                $sql .=     $nomeTabela . ' ';
                $where = '';

                if ($aNomeCampos && $aBusca){
                    $aCamposBusca =array_combine($aNomeCampos, $aBusca);
                    $infoTabela = $this->getInfoTabela($nomeTabela);
                    $tipoCampos = array();
                    foreach ($aNomeCampos as $campo){
                        foreach ($infoTabela as $infoCampo){
                            if ($campo == $infoCampo['Field']){
                                $tipoCampos[] = $infoCampo['Type'];
                            }
                        }
                    }
                    $i = 0;
                    foreach ($aNomeCampos as $campo){
                        if ((strpos($tipoCampos[$i], 'int') !== false)){
                            $where .= ($where) ? ' AND ' : '';
                            $where .= $campo . ' = :' . $campo;
                        }
                        $where .= ($where) ? ' AND ' : '';
                        $where .= $campo . ' LIKE :' . $campo . ' ';
                        $i++;
                    }
                }
                $sql .= ($where) ? ' WHERE ' . $where: '';
                $stm = $this->pdo->prepare($sql);

                if ($aNomeCampos && $aBusca){
                    $i = 0;
                    foreach ($aCamposBusca as $campo => $busca){
                        if ((strpos($tipoCampos[$i], 'int') !== false)){
                            $stm->bindValue(':' . $campo, $busca, PDO::PARAM_INT);
                        }
                        $stm->bindValue(':' . $campo,'%' . $busca .'%', PDO::PARAM_STR);
                        $i++;
                    }

                }
                $stm->execute();
                return $stm->fetchAll();
            }catch (PDOException $e){
                echo  $e->getMessage();
            }
        } else{
            return false;
        }
    }

    /**
     * Função obtem informações da tabela indicada em $nomeTabela
     *
     * @param null $nomeTabela
     * @return mixed
     */
    public function getInfoTabela($nomeTabela = null){
        if ($nomeTabela){
            try{
                $stm = $this->pdo->prepare('SHOW COLUMNS FROM ' . $nomeTabela);
                $stm->execute();
                return $stm->fetchAll();
            }catch (PDOException $e){
                echo $e->getMessage();
            }
        }
    }

    /**
     * Função obtem o nome da PRIMARY KEY da tabela indicada em $nomeTabela
     *
     * @param null $nomeTabela
     * @return mixed
     */
    public function getNomeId($nomeTabela = null){
        if ($nomeTabela){
            try{
                $stm = $this->pdo->prepare('SHOW COLUMNS FROM ' . $nomeTabela);
                $stm->execute();
                $nomeId = $stm->fetch(PDO::FETCH_ASSOC);
                return $nomeId['Field'];
            }catch (PDOException $e){
                echo $e->getMessage();
            }
        }
    }

    /**
     * Função retorna um array de placeholders do tipo interrogação (caracter "?")
     * com a quantidade indicada em $num
     *
     * @param $num
     * @return array
     */
    private function getPlaceholders($num){
        $placeholders = array();
        for ($i = 0; $i < $num; $i++){
            $placeholders[] = '?';
        }
        return $placeholders;
    }
}