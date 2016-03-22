<?



/**
 * Este arquivo é parte do projeto PLANO D/C - Plano de contas . net
 *
 * Este arquivo é um software livre: você pode redistribuir e/ou modificá-lo
 * sob os termos da Licença Pública Geral GNU (GPL)como é publicada pela Fundação
 * para o Software Livre, na versão 3 da licença, ou qualquer versão posterior
 * e/ou 
 * sob os termos da Licença Pública Geral Menor GNU (LGPL) como é publicada pela Fundação
 * para o Software Livre, na versão 3 da licença, ou qualquer versão posterior.
 *
 *
 * Este programa é distribuído na esperança que será útil, mas SEM NENHUMA
 * GARANTIA; nem mesmo a garantia explícita definida por qualquer VALOR COMERCIAL
 * ou de ADEQUAÇÃO PARA UM PROPÓSITO EM PARTICULAR,
 * veja a Licença Pública Geral GNU para mais detalhes.
 *
 *  consulte <http://www.fsfla.org/svnwiki/trad/GPLv3> ou
 * <http://www.fsfla.org/svnwiki/trad/LGPLv3>. 
 *
 * Está atualizada para :
 *      PHP 5.3
 * @package   PLANO D/C
 * @name      sped_ecd.php
 * @version   2.0  20120829
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL v.3
 * @copyright 2012 &copy; PLANO D/C
 * @link      http:planodecontas.net
 * @author    Walber S Sales <eng.walber at gmail dot com>


 *        CONTRIBUIDORES (em ordem alfabetica):




*/

 
//ini_set('memory_limit','512M');
//ini_set("max_execution_time",0); 




   echo "<br><b> <FONT SIZE=4 color=blue>$menu_escolhido </FONT></b>";
  
$TBALANCO='balanco_'.$info_cnpj;
$TCONTBALANCO=$CONTPLANOCT;
include('periodo.php');

if (empty($lanperiodo1)) {
   $lanperiodo1=$dthoje;
}

if (empty($lanperiodo2)) {
   $lanperiodo2=$dthoje;
}
  
?>
<form action=logado.php?<?=$_SERVER["QUERY_STRING"];?> method=post name='flancamento' onSubmit='return validate(this);'>
<?
 $inputs_menu='periodo';

$filtro_opcoes_inputmenus_form_name='flancamento';
include('filtro_opcoes_inputmenus.php');
?>
</form>
<?

if (!($_POST)) {
exit;
}




$retorna_error=$retorna_error. _myfunc_valida_periodo_vaziok($lanperiodo1,$lanperiodo2);


	_myfunc_liga_id_processando("P R O C E S S A N D O : ");
	flush();

// tabela segmentos, dados da empresa
$sel_segmento = mysql_query("SELECT * FROM $TSEGMENTOS  WHERE cnpjcpf='$info_cnpj_segmento'",$CONTSEGMENTOS);
If (mysql_num_rows($sel_segmento)) {
    $info_segmento= mysql_fetch_assoc($sel_segmento);
}

// período

$per1=_myfunc_dtos($lanperiodo1)  ;
$per2=_myfunc_dtos($lanperiodo2) ;



include('balancete_n_periodos.php');







$perdtos1=_myfunc_dtos($lanperiodo1);
$perdtos2=_myfunc_dtos($lanperiodo2);


 

// gerar diario e balancete sped

include('bala_calc.php');



include('sped_matriz.php');

//$nome_do_arquivo='arquivo.txt';
require_once("$PASTA_INICIAL/nfefiles/nfe_nfefiles_pastas_nfe.php");
 
$nome_txt='ecd_'.$info_cnpj.'_'._myfunc_ddmmaaaa($lanperiodo1).'_'._myfunc_ddmmaaaa($lanperiodo2).'.txt';
$nome_do_arquivo_dir=$spedDir.'ecd_'.$info_cnpj.'_'._myfunc_ddmmaaaa($lanperiodo1).'_'._myfunc_ddmmaaaa($lanperiodo2).'.txt';
$nome_do_arquivo_down=$spedDir.'ecd_'.$info_cnpj.'_'._myfunc_ddmmaaaa($lanperiodo1).'_'._myfunc_ddmmaaaa($lanperiodo2).'.zip';

$nome_do_arquivo_dir='../nfefiles/'.$cnpjcpf_segmento.'/spedtxt/ecd_'.$info_cnpj.'_'._myfunc_ddmmaaaa($lanperiodo1).'_'._myfunc_ddmmaaaa($lanperiodo2).'.txt'; 
$nome_do_arquivo_down='../nfefiles/'.$cnpjcpf_segmento.'/spedtxt/ecd_'.$info_cnpj.'_'._myfunc_ddmmaaaa($lanperiodo1).'_'._myfunc_ddmmaaaa($lanperiodo2).'.txt';


// abe arquivo para w-gravaçao
$fp = fopen("$nome_do_arquivo_dir", "w");

 

// script / rotina que gera as linhas txt

     include('sped_ecd_funcoes.php');

fclose($fp);  // fecha arquivo

 

// apagar arquivos dos periodos


// gerar balancetes mensais por periodo do sped ecd
        $dt_inix=$lanperiodo1;
        $dt_finx=$lanperiodo2;

        $dt_ini_flag=$dt_inix;
        $data_mostrar_inicio=$dt_inix;


        $datatrans = explode("-",convdata($lanperiodo1,0));
        $data_mostrar_final=_myfunc_ultimodia_mes($datatrans[1],$datatrans[0]).'/'.$datatrans[1].'/'.$datatrans[0];



        $xdt_flag=substr($dt_inix,3,7) ;
        $xdt_fin=substr($dt_finx,3,7) ;
        $finished = false;

        $a=0;
        while ( ! $finished ):

               $xdt_flag=substr($data_mostrar_inicio,3,7) ;

               $data_mostrar_iniciox=_myfunc_ddmmaaaa($data_mostrar_inicio);
               $data_mostrar_finalx=_myfunc_ddmmaaaa($data_mostrar_final);



               
               $lanper1=substr( $data_mostrar_iniciox,0,2).'/'.substr( $data_mostrar_iniciox,2,2).'/'.substr( $data_mostrar_iniciox,4,4);
               $lanper2=substr( $data_mostrar_finalx,0,2).'/'.substr( $data_mostrar_finalx,2,2).'/'.substr( $data_mostrar_finalx,4,4);

               $perdtos1=_myfunc_dtos($lanper1);
$perdtos1=_myfunc_dtos_0hs($lanper1);
               $perdtos2=_myfunc_dtos($lanper2);
 
           
              $arquivo_sped_ecd='balanco_sped_'.substr($lanper1,3,2).substr($lanper2,6,4);
              $sql="drop table $arquivo_sped_ecd";
              if ( @mysql_query($sql)) {
              }
              

               $xdt_flag=substr($data_mostrar_inicio,3,7) ;

               if ($xdt_fin==$xdt_flag) {
                   $finished = true;
               }
               $dt_ini_proximo= date("d/m/Y", strtotime($dt_ini_flag . " + 01 month"));
               $dt_ini_flag=convdata($dt_ini_proximo,0);
               $datatrans = explode ("-",$dt_ini_flag);
               $data_mostrar_inicio = "$datatrans[2]/$datatrans[1]/$datatrans[0]";
              //$data_inicio=_myfunc_ddmmaaaa($data_mostrar_inicio);
               $data_mostrar_final=_myfunc_ultimodia_mes($datatrans[1],$datatrans[0]).'/'.$datatrans[1].'/'.$datatrans[0];
               
               

       endwhile;
 




















if (file_exists("$nome_do_arquivo_dir")) {
echo "Arquivo $nome_txt gerado com sucesso!";

echo "<a href=$nome_do_arquivo_down target=_blank> Download </a>";

}else{

echo "Arquivo   não gerado!";

}

 _myfunc_desliga_id_processando(''); 
		_myfunc_desliga_id_processando('Final de processamento!');
		flush();
?>
