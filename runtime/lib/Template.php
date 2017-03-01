<?php


/**
 * @author : Yuri Samuel
 * @since : 29/01/2017 01:54
 * @version: 1.0
 *
 */

class Template extends CrudForm
{

    private $titlePage;

    private $nomeProjeto;

    private $dataInicio;

    private $dataPrevisaoFim;

//    NO CONSTRUTOR DA CLASS ABAIXO, NÃO USAR $nomeProjeto, $dataInicio, $dataPrevisaoFim, APENAS USAR ID DO PROJETO

    public function Template($titlePage, $nomeProjeto, $dataInicio, $dataPrevisaoFim){
        $this->titlePage = $titlePage;
        $this->nomeProjeto = $nomeProjeto;
        $this->dataInicio = $dataInicio;
        $this->dataPrevisaoFim = $dataPrevisaoFim;
    }

    public function header(){
        $html = '';
        $html .= '<!doctype html>';
        $html .= $this->getHeadHtml();

        /*Inicio do body*/
        $html .= '<body>';

        /*Inicio do header*/
        $html .= '  <header class="page-header">';
        $html .= '      <div class="container">';
        $html .=            $this->getHeader_topo();
        $html .=            $this->getHeader_menu_principal();
        $html .= '      </div>';
        $html .= '  </header>';
        $html .= '  <div class="container conteudo">';
        $html .= '      <div class="row" id="bodyContent">';
        echo $html;
    }

    public function footer(){
        $html = '';
        $html .= '        </div>';
        $html .= '    </div>';
//        ainda falta colocar informações aqui nesse footer, mas bora deixar mais pro finalzinho
        $html .= '    <footer class="container-fluid footer">';
        $html .= '    </footer>';
        $html .= '    <script type="text/javascript" src="public\js\jquery-3.1.1.min.js"></script>';
        $html .= '    <script type="text/javascript" src="public\js\bootstrap.min.js"></script>';
        $html .= '    <script type="text/javascript" src="public\js\ajax.js"></script>';
        $html .= '    <script type="text/javascript" src="public\js\jquery.fcbkcomplete_lookup.js?version=19" type="text/javascript" charset="utf-8"></script>';
        $html .= '    <script type="text/javascript" src="public\js\lookup.js?version=19"></script>';
        $html .= '</body>';
        $html .= '</html>';
        echo $html;
    }

    private function getHeadHtml(){
        $fileName = 'public\html\head.html';
        if (is_file($fileName)){
            $file = fopen($fileName, 'r');
            $html = fread($file, filesize($fileName));
            $html = str_replace('[TITLE-PAGE]', $this->titlePage, $html);
            return $html;
        } else {
            throw new Exception('O arquivo ' . $fileName . ' não esta definido');
        }
    }

    public function getHeader_topo(){
        $fileName = 'public\html\header_topo.html';
        if (is_file($fileName)){
            $file = fopen($fileName, 'r');
            $html = fread($file, filesize($fileName));
            $search = ['[PROJETO_NOME]', '[DATA_INICIO]', '[DATA_PREV_CONCLUSAO]'];
            $replace = [$this->nomeProjeto, $this->dataInicio, $this->dataPrevisaoFim];
            $html = str_replace($search, $replace, $html);
            return $html;
        } else {
            throw new Exception('O arquivo ' . $fileName . ' não esta definido');
        }
    }

    public function getHeader_menu_principal(){
        $fileName = 'public\html\header_menu_principal.html';
        if (is_file($fileName)){
            $file = fopen($fileName, 'r');
            $html = fread($file, filesize($fileName));

//            NO MENU PRINCIPAL AINDA NÃO HA NADA DINAMICO, QUANDO TIVER... TALVEZ O str_replace() SEJA UTIL
//            $search = ['[PROJETO_NOME]', '[DATA_INICIO]', '[DATA_PREV_CONCLUSAO]'];
//            $replace = [$this->nomeProjeto, $this->dataInicio, $this->dataPrevisaoFim];
//            $html = str_replace($search, $replace, $html);

            return $html;
        } else {
            throw new Exception('O arquivo ' . $fileName . ' não esta definido');
        }
    }
}
