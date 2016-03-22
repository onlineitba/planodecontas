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
 * @name      sped_ecd_funcoes.php
 * @version   2.0  20120804.1
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL v.3
 * @copyright 2012 &copy; PLANO D/C
 * @link      http:planodecontas.net
 * @author    Walber S Sales <eng.walber at gmail dot com>

 *        CONTRIBUIDORES (em ordem alfabetica):

 *        AUREO NEVES DE SOUZA JUNIOR <onlinesistema at hotmail.com.br>


*/

 



//REGISTRO 0000: ABERTURA DO ARQUIVO DIGITAL E IDENTIFICAÇÃO DA ENTIDADE

sped_ecd_registro_0000();

// REGISTRO 0001: ABERTURA DO BLOCO
sped_ecd_registro_0001();

// REGISTRO 0007: OUTRAS INSCRIÇÕES CADASTRAIS DO EMPRESÁRIO OU SOCIEDADE EMPRESÁRIA
sped_ecd_registro_0007();

//REGISTRO 0020: ESCRITURAÇÃO CONTÁBIL DESCENTRALIZADA
//sped_ecd_registro_0020();

//REGISTRO 0150: TABELA DE CADASTRO DO PARTICIPANTE
//sped_ecd_registro_0150();

//REGISTRO 0180: IDENTIFICAÇÃO DO RELACIONAMENTO COM O PARTICIPANTE
//sped_ecd_registro_0180();

//REGISTRO 0990: ENCERRAMENTO DO BLOCO 0
sped_ecd_registro_0990();

//REGISTRO I001: ABERTURA DO BLOCO I
sped_ecd_registro_I001();

//REGISTRO I010: IDENTIFICAÇÃO DA ESCRITURAÇÃO CONTÁBIL
sped_ecd_registro_I010();

//REGISTRO I012: LIVROS AUXILIARES AO DIÁRIO
//sped_ecd_registro_I012();

//REGISTRO I015: LIVROS AUXILIARES AO DIÁRIO
//sped_ecd_registro_I015();

//REGISTRO I020:  CAMPOS ADICIONAIS
//sped_ecd_registro_I020();

//REGISTRO I030: TERMO DE ABERTURA
sped_ecd_registro_I030();

//REGISTRO I050: PLANO DE CONTAS
sped_ecd_registro_I050();

//REGISTRO I051: PLANO DE CONTAS  REFERENCIAL
//sped_ecd_registro_I051();

//REGISTRO I052: INDICAÇÃO DOS CÓDIGOS DE AGLUTINAÇÃO
//sped_ecd_registro_I052();

//REGISTRO I075: TABELA DE HISTÓRICO PADRONIZADO
//sped_ecd_registro_I075();

//REGISTRO I100: CENTRO DE CUSTOS
//sped_ecd_registro_I100();

//REGISTRO I150: SALDOS PERIÓDICOS - IDENTIFICAÇÃO DO PERÍODO
sped_ecd_registro_I150();

//REGISTRO I155: DETALHE DOS SALDOS PERIÓDICOS

//sped_ecd_registro_I155();  // OK ,gerado dentro do I150

 


//REGISTRO I200: LANÇAMENTO CONTÁBIL
sped_ecd_registro_I200();

//REGISTRO I250: PARTIDAS DO LANÇAMENTO
//sped_ecd_registro_I250();   // OK, GERADO DENTRO DO I200

//REGISTRO I310: DETALHES DO BALANCETE DIÁRIO
//sped_ecd_registro_I310();

//REGISTRO I350: SALDOS DAS CONTAS DE RESULTADO ANTES DO ENCERRAMENTO - IDENTIFICAÇÃO DA DATA
//sped_ecd_registro_I350();

//REGISTRO I355: DETALHES DOS SALDOS DAS CONTAS DE RESULTADO ANTES DO ENCERRAMENTO
/*sped_ecd_registro_I355();   */

//REGISTRO I500: PARÂMETROS DE IMPRESSÃO E VISUALIZAÇÃO DO LIVRO RAZÃO AUXILIAR COM LEIAUTE PARAMETRIZÁVEL
//sped_ecd_registro_I500();

//REGISTRO I510: DEFINIÇÃO DE CAMPOS DO LIVRO RAZÃO AUXILIAR COM LEIAUTE PARAMETRIZAVEL
//sped_ecd_registro_I510();

//REGISTRO I550: DETALHES DO LIVRO AUXILIAR COM LEIAUTE PARAMETRIZÁVEL
// sped_ecd_registro_I550();

//REGISTRO I555: TOTAIS NO LIVRO AUXILIAR CO LEIAUTE PARAMETRIZÁVEL
// sped_ecd_registro_I555();

//REGISTRO I990: ENCERRAMENTO DO BLOCO I
sped_ecd_registro_I990();

//REGISTRO J001: ABERTURA DO BLOCO J
sped_ecd_registro_J001();

//REGISTRO J005: DEMONSTRAÇÕES CONTÁBEIS
sped_ecd_registro_J005();

//REGISTRO J100: BALANÇO PATRIMONIAL
sped_ecd_registro_J100();

//REGISTRO J150: DEMONSTRAÇÃO DO RESULTADO DO EXERCÍCIO
sped_ecd_registro_J150();

//REGISTRO J800: OUTRAS INFORMAÇÕES
sped_ecd_registro_J800();

//REGISTRO J900: TERMO DE ENCERRAMENTO
sped_ecd_registro_J900();

//REGISTRO J930: IDENTIFICAÇÃO DOS SIGNATÁRIOS DA ESCRITURAÇÃO
sped_ecd_registro_J930();

//REGISTRO J990: ENCERRAMENTO DO BLOCO J
sped_ecd_registro_J990();

//REGISTRO 9001: ABERTURA DO BLOCO 9
sped_ecd_registro_9001();

//REGISTRO 9900: REGISTROS DO ARQUIVO
sped_ecd_registro_9900();

//REGISTRO 9990: ENCERRAMENTO DO BLOCO 9
sped_ecd_registro_9990();

//REGISTRO 9999: ENCERRAMENTO DO ARQUIVO DIGITAL
sped_ecd_registro_9999();

 
escreve_matriz_linha();



return;


//REGISTRO 0000: ABERTURA DO ARQUIVO DIGITAL E IDENTIFICAÇÃO DA ENTIDADE
function sped_ecd_registro_0000() {
             global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$qtd_lin_0,$REG_BLC;//,$qtd_lin;
                      $reg='0000';
                      $lecd='LECD';
                      $dt_ini=_myfunc_ddmmaaaa($lanperiodo1);
                      $dt_fin=_myfunc_ddmmaaaa($lanperiodo2);
                      $nome=_myfunc_removeacentos($info_segmento[razaosocial]);
                      $cnpj=$info_segmento[cnpjcpf];
                      $uf=$info_segmento[uf];
                      $ie=$info_segmento[ie];
                      $cod_mun=_apenas_numeros($info_segmento[cod_mun]);
                      $im=$info_segmento[im];
                      $ind_sit_esp=$info_segmento[ind_sit_esp];
                      $linha='|'.$reg.'|'.$lecd.'|'.$dt_ini.'|'.$dt_fin.'|'.$nome.'|'.$cnpj.'|'.$uf.'|'.$ie.'|'.$cod_mun.'|'.$im.'|'.$ind_sit_esp.'|';
                      $qtd_lin_0 ++;
                      //$qtd_lin ++;
                      _matriz_linha($linha);
                      //$escreve = fwrite($fp, "$linha\r\n");
                      $tot_registro_bloco=1;
                      $REG_BLC[]='0000|'.$tot_registro_bloco;
                      return;
                      
}

// REGISTRO 0001: ABERTURA DO BLOCO
function sped_ecd_registro_0001() {
         global $fp,$qtd_lin_0,$REG_BLC;//,$qtd_lin;
         $reg='0001';
         $ind_dad='0';
         $linha='|'.$reg.'|'.$ind_dad.'|';
         $qtd_lin_0 ++ ;
         //$qtd_lin ++;
         _matriz_linha($linha);
         //$escreve = fwrite($fp, "$linha\r\n");
         $tot_registro_bloco=1;
         $REG_BLC[]='0001|'.$tot_registro_bloco;
         RETURN;
}


// REGISTRO 0007: : OUTRAS INSCRIÇÕES CADASTRAIS DO EMPRESÁRIO OU SOCIEDADE EMPRESÁRIA
function sped_ecd_registro_0007()  {
         global $info_segmento,$fp,$qtd_lin_0,$REG_BLC;//,$qtd_lin;
         $reg='0007' ;
         $cod_ent_ref=$info_segmento[uf];
         $cod_inscr=$info_segmento[ie];;
         $linha='|'.$reg.'|'.$cod_ent_ref.'|'.$cod_inscr.'|';
         $qtd_lin_0 ++ ;
         //$qtd_lin ++;
         _matriz_linha($linha);
         //$escreve = fwrite($fp,"$linha\r\n") ;
         $tot_registro_bloco=1;
         $REG_BLC[]='0007|'.$tot_registro_bloco;
         return ;
}

//REGISTRO 0020: ESCRITURAÇÃO CONTÁBIL DESCENTRALIZADA
function sped_ecd_registro_0020(){
         global $info_segmento,$fp,$qtd_lin_0,$REG_BLC;//,$qtd_lin;
         $reg='0020';
         $ind_dec=$info_segmento[ind_dec];
         $cnpj=$info_segmento[cnpjcpf];
         $uf=$info_segmento[uf];
         $ie=$info_segmento[ie];
         $cod_mun=_apenas_numeros($info_segmento[cod_mun]);
         $im=$info_segmento[im];
         $nire=$info_segmento[nire];
         $linha='|'.$reg.'|'.$ind_dec.'|'.$cnpj.'|'.$uf.'|'.$ie.'|'.$cod_mun.'|'.$im.'|'.$nire.'|';
         $qtd_lin_0 ++ ;
         //$qtd_lin ++;
         _matriz_linha($linha);
         //$escreve = fwrite($fp,"$linha\r\n");
         $tot_registro_bloco=$tot_registro_bloco+1;
         $REG_BLC[]='0020|'.$tot_registro_bloco;
         return ;
}
//REGISTRO 0150: TABELA DE CADASTRO DO PARTICIPANTE
function sped_ecd_registro_0150(){
         global $fp,$lanperiodo1,$lanperiodo2,$CONTLANCAMENTOS,$TLANCAMENTOS,$TCNPJCPF,$CONTCNPJCPF,$per1,$per2,$qtd_lin_0,$REG_BLC;//,$qtd_lin;
         $sql="SELECT a.cnpjcpf,b.cnpj,b.razao,b.uf,.b.suframa,b.pais FROM $TLANCAMENTOS as a , $TCNPJCPF as b  WHERE a.data>='$per1' and a.data<='$per2' and a.cnpjcpf=b.cnpj group by a.cnpjcpf";
         $sel_lancamento = mysql_query($sql,$CONTLANCAMENTOS) ;
         while ($v=mysql_fetch_assoc($sel_lancamento) ) {
         $reg='0150';
         $cod_part=trim($v[cnpjcpf]);
         $nome=_myfunc_removeacentos($v[razao]);
         
         $cod_pais=TRIM($v[pais]);
         IF ($cod_pais==''){
            $cod_pais='01058';
         }
         $cnpjcpf=trim($v[cnpjcpf]);
         if (strlen($cnpjcpf)==14){
              $cnpjx=$cnpjcpf;
              $cpfx='';
         }
          else{
              $cnpjx='';
              $cpfx=$cnpjcpf;
         }
         $nit=$v[nit];
         $uf=$v[uf];
         $ie=$v[inscricao];
         $ie_st='';//não tem na tabela
         $cod_mun=_apenas_numeros($v[cod_mun]);
         $im=$v[im];
         $suframa=$v[suframa];
         $linha='|'.$reg.'|'.$cod_part.'|'.$nome.'|'.$cod_pais.'|'.$cnpjx.'|'.$cpfx.'|'.$nit.'|'.$uf.'|'.$ie.'|'.$ie_st.'|'.$cod_mun.'|'.$im.'|'.$suframa.'|';
         $qtd_lin_0 ++ ;
         //$qtd_lin ++;
         _matriz_linha($linha);
         //$escreve = fwrite($fp, "$linha\r\n");
         $tot_registro_bloco=$tot_registro_bloco+1;
         }
         $REG_BLC[]='0150|'.$tot_registro_bloco;
         return;
}

//REGISTRO 0180: IDENTIFICAÇÃO DO RELACIONAMENTO COM O PARTICIPANTE
function sped_ecd_registro_0180(){
         global $fp,$info_segmento,$qtd_lin_0,$REG_BLC;//,$qtd_lin;
         $reg='0180';
         $cod_rel=$info_segmento[cod_rel];
         $dt_ini=_myfunc_stod($info_segmento[dt_ini_rel]);
         $dt_ini_rel=str_replace('/','',$dt_ini);
         $dt_fin=_myfunc_stod($info_segmento[dt_fin_rel]);
         $dt_fin_rel=str_replace('/','',$dt_fin);
         $linha='|'.$reg.'|'.$cod_rel.'|'.$dt_ini_rel.'|'.$dt_fin_rel.'|';
         $qtd_lin_0 ++ ;
         //$qtd_lin ++;
         _matriz_linha($linha);
         //$escreve = fwrite($fp,"$linha\r\n");
         $tot_registro_bloco=$tot_registro_bloco+1;
         $REG_BLC[]='0180|'.$tot_registro_bloco;
         return ;
}

//REGISTRO 0990: ENCERRAMENTO DO BLOCO 0
function sped_ecd_registro_0990(){
         global $fp,$qtd_lin_0,$REG_BLC;//,$qtd_lin;
          $reg='0990';
          $qtd_lin_0 ++ ;
          $linha='|'.$reg.'|'. $qtd_lin_0.'|';
          //$qtd_lin ++;
          _matriz_linha($linha);
          //$escreve = fwrite($fp,"$linha\r\n");
          $tot_registro_bloco=$tot_registro_bloco+1;
          $REG_BLC[]='0990|'.$tot_registro_bloco;
          return ;
}

//REGISTRO I001: ABERTURA DO BLOCO I
function sped_ecd_registro_I001(){
          global $fp,$qtd_lin_i,$REG_BLC;//,$qtd_lin;
          $reg='I001';
          $ind_dad='0';
          $linha='|'.$reg.'|'. $ind_dad.'|';
          $qtd_lin_i ++ ;
          //$qtd_lin ++;
          _matriz_linha($linha);
          //$escreve = fwrite($fp,"$linha\r\n") ;
          $tot_registro_bloco=$tot_registro_bloco+1;
          $REG_BLC[]='I001|'.$tot_registro_bloco;

          return ;
}

//REGISTRO I010: IDENTIFICAÇÃO DA ESCRITURAÇÃO CONTÁBIL
function sped_ecd_registro_I010(){
         global $fp,$qtd_lin_i,$REG_BLC;//,$qtd_lin;
         $reg='I010';
         $ind_esc='G';
         $cod_ver_lc='1.00';
         $linha='|'.$reg.'|'. $ind_esc.'|'.$cod_ver_lc.'|';
         $qtd_lin_i ++ ;
         //$qtd_lin ++;
         _matriz_linha($linha);
         //$escreve = fwrite($fp,"$linha\r\n") ;
         $tot_registro_bloco=$tot_registro_bloco+1;
         $REG_BLC[]='I010|'.$tot_registro_bloco;
         return ;
}

//REGISTRO I012: LIVROS AUXILIARES AO DIÁRIO
/*function sped_ecd_registro_I012(){
         global $fp,$qtd_lin_i_$qtd_lin;
         $reg='I012';
         $num_ord='w';
         $nat_livr='w';
         $tipo='w';
         $cod_hash_aux='w';
         $linha='|'.$reg.'|'.$num_ord.'|'.$nat_livr.'|'.$tipo'|';
          $qtd_lin_i ++ ;
         $qtd_lin ++;
         $escreve = fwrite($fp,"$linha\r\n") ;

         return ;
}*/

//REGISTRO I015: LIVROS AUXILIARES AO DIÁRIO
/*function sped_ecd_registro_I015(){
         global $fp,$qtd_lin_i_$qtd_lin;
         $reg='I015';
         $cod_cta_res='w';
         $linha='|'.$reg.'|'.$cod_cta_res.'|';
         $qtd_lin_i ++ ;
         $qtd_lin ++;
         $escreve = fwrite($fp,"$linha\r\n") ;

         return ;
}*/
//REGISTRO I020:  CAMPOS ADICIONAIS
function sped_ecd_registro_I020(){
        global $fp,$qtd_lin_i,$REG_BLC;//,$qtd_lin;
        $reg='I020';
        $reg_cod='I050';
        $num_ad='001';
        $campo='teste';
        $descricao='teste';
        $tipo='C';
        $linha='|'.$reg.'|'. $reg_cod.'|'.$num_ad.'|'.$campo.'|'.$descricao.'|'.$tipo.'|';
        $qtd_lin_i ++ ;
        //$qtd_lin ++;
        _matriz_linha($linha);
        //$escreve = fwrite($fp,"$linha\r\n");
        $tot_registro_bloco=$tot_registro_bloco+1;
        $REG_BLC[]='I020|'.$tot_registro_bloco;
        return ;
}

//REGISTRO I030: TERMO DE ABERTURA
function sped_ecd_registro_I030(){
         global $fp,$info_segmento,$qtd_lin_i,$REG_BLC,$lanperiodo2;//,$qtd_lin;
         $reg='I030';
         $dnrc_abert='TERMO DE ABERTURA';
         $num_ord=$info_segmento[ord_ecd];
         $nat_livr='DIARIO' ;
         $qtd_lin_t='xyzqw';
         $nome=_myfunc_removeacentos($info_segmento[razaosocial]);
         $nire=$info_segmento[nire] ;
         $cnpj=$info_segmento[cnpjcpf];
         $dt=_myfunc_stod($info_segmento[dt_ato_consti]);
         //$dt=_myfunc_ddmmaaaa($lanperiodo2);
         $dt_arq=str_replace('/','',$dt);
         $dt_arq_conv='' ;//não tem na tabela
         $desc_mun=$info_segmento[cidade];
         $linha='|'.$reg.'|'. $dnrc_abert.'|'.$num_ord.'|'.$nat_livr.'|'.$qtd_lin_t.'|'.$nome.'|'.$nire.'|'.$cnpj.'|'.$dt_arq.'|'.$dt_arq_conv.'|'.$desc_mun.'|';
         $qtd_lin_i ++ ;
         //$qtd_lin ++;
         _matriz_linha($linha);
         //$escreve = fwrite($fp,"$linha\r\n");
         $tot_registro_bloco=$tot_registro_bloco+1;
         $REG_BLC[]='I030|'.$tot_registro_bloco;
         return  ;
 }
 
//REGISTRO I050: PLANO DE CONTAS
function sped_ecd_registro_I050(){
         global $fp,$TPLANOCT,$CONTPLANOCT,$qtd_lin_i,$info_cnpj_segmento,$REG_BLC,$lanperiodo2,$tot_registro_51,$tot_registro_52;//,$qtd_lin;
         // provisorio
/*         01	Contas de ativo
02	Contas de passivo
03	Patrimônio líquido
04	Contas de resultado
05	Contas de compensação
09	Outras
  */
  
         $ativo="1";
         $passivo="2";
         $liquido="x";
         $resultado="3";
         $compensacao="x";
         
         
         $sql="SELECT * FROM $TPLANOCT";
         $sel_planoct = mysql_query($sql,$CONTPLANOCT) ;
       //  $xnivel=_myfun_len_grau_n($info_cnpj_segmento,1);
         while ($v=mysql_fetch_assoc($sel_planoct) ) {
         $reg='I050';
         $dt_fin=_myfunc_ddmmaaaa($lanperiodo2);
         $dt=_myfunc_stod($v[dataatu]);
         IF ($v[dataatu] > $dt_fin) {
         $dt=$dt_fin;
         }
         $dt_alt=str_replace('/','',$dt);
         $conta=$v[conta] ;
         if (strlen(_myfun_mascara_x($info_cnpj_segmento))==strlen($conta)) {
         $ind_cta='A';
         }
         else{
         $ind_cta='S';
         }
         

         if (strlen($conta)==_myfun_len_grau_n($info_cnpj_segmento,1)) {
         $nivel='1';
         $cod_cta=$conta;
         $cod_cta_sup='';
         $cod_nat='01';
         }
         if(strlen($conta)==_myfun_len_grau_n($info_cnpj_segmento,2)){
         $nivel='2';
         $cod_cta=$conta;
         $cod_cta_sup=substr($conta,0,_myfun_len_grau_n($info_cnpj_segmento,1));
         $cod_nat='02';
         }
         if(strlen($conta)==_myfun_len_grau_n($info_cnpj_segmento,3)) {
         $nivel='3';
         $cod_cta=$conta;
         $cod_cta_sup=substr($conta,0,_myfun_len_grau_n($info_cnpj_segmento,2));
         $cod_nat='04';
         }
         if(strlen($conta)==_myfun_len_grau_n($info_cnpj_segmento,4)){
         $nivel='4';
         $cod_cta=$conta;
         $cod_cta_sup=substr($conta,0,_myfun_len_grau_n($info_cnpj_segmento,3));
         $cod_nat='04';
         }
         if(strlen($conta)==_myfun_len_grau_n($info_cnpj_segmento,5)) {
         $nivel='5';
         $cod_cta=$conta;
         $cod_cta_sup=substr($conta,0,_myfun_len_grau_n($info_cnpj_segmento,4));
         $cod_nat='05';
         }
         if(strlen($conta)==_myfun_len_grau_n($info_cnpj_segmento,6)){
         $nivel='6';
         $cod_cta=$conta;
         $cod_cta_sup=substr($conta,0,_myfun_len_grau_n($info_cnpj_segmento,4));
         $cod_nat='09';
         }
         
         $cod_nat="09";

         $xnivel=substr($conta,0,_myfun_len_grau_n($info_cnpj_segmento,1));
         switch ($xnivel) {
                 case "$ativo" :
                       $cod_nat="01";
                       break;

                 case "$passivo" :
                       $cod_nat="02";
                       break;

                case "$liquido" :
                       $cod_nat="03";
                       break;

                case "$resultado" :
                       $cod_nat="04";
                       break;

               case "$compensacao" :
                       $cod_nat="05";
                       break;
        }
         
         
         $cta=$v[descricao];
         $linha='|'.$reg.'|'. $dt_alt.'|'.$cod_nat.'|'.$ind_cta.'|'.$nivel.'|'.$cod_cta.'|'.$cod_cta_sup.'|'.$cta.'|';
         $qtd_lin_i ++ ;
         //$qtd_lin ++;
         _matriz_linha($linha);
         //$escreve = fwrite($fp,"$linha\r\n") ;
         $tot_registro_bloco=$tot_registro_bloco+1;
         if ($ind_cta=='A') {
            //if(strlen($conta)==_myfun_len_grau_n($info_cnpj_segmento,6)){
            sped_ecd_registro_I051($conta);
            sped_ecd_registro_I052($conta);
         }
         }
         $REG_BLC[]='I050|'.$tot_registro_bloco;
         $REG_BLC[]='I051|'.$tot_registro_51;
         $REG_BLC[]='I052|'.$tot_registro_52;
         return ;

}
//REGISTRO I051: PLANO DE CONTAS REFERENCIAL
function sped_ecd_registro_I051($conta){
         global $fp,$TPLANOCT,$CONTPLANOCT,$qtd_lin_i,$REG_BLC,$tot_registro_51,$info_cnpj_segmento;//,$qtd_lin;
         $sql="SELECT * FROM $TPLANOCT where conta='$conta'";
         $sel_planoct = mysql_query($sql,$CONTPLANOCT) ;
         while ($v=mysql_fetch_assoc($sel_planoct) ) {
               $reg='I051';
               $cod_ent_ref='10'; //não tem na tabela
               $cod_ccus='';
               $cod_cta_ref=$v[conta_ecd];
               $linha='|'.$reg.'|'. $cod_ent_ref.'|'.$cod_ccus.'|'.$cod_cta_ref.'|';
               $qtd_lin_i ++ ;
               _matriz_linha($linha);
                //$escreve = fwrite($fp,"$linha\r\n");
               $tot_registro_51=$tot_registro_51+1;
         }

         return ;
}
         
//REGISTRO I052: INDICAÇÃO DOS CÓDIGOS DE AGLUTINAÇÃO
function sped_ecd_registro_I052($conta){
        global $fp,$TPLANOCT,$CONTPLANOCT,$qtd_lin_i,$REG_BLC,$tot_registro_52,$info_cnpj_segmento;//,$qtd_lin;
        $sql="SELECT * FROM $TPLANOCT where conta='$conta'";
        $sel_planoct = mysql_query($sql,$CONTPLANOCT) ;
        If (mysql_num_rows($sel_planoct)) {
        while ($v=mysql_fetch_assoc($sel_planoct) ) {
        $reg='I052';
        $conta=$v[conta] ;
        $cod_ccus=$v[cod_cc];
        $cod_ccus='';
        $cod_agl=substr($conta,0,_myfun_len_grau_n($info_cnpj_segmento,5));     //PROVISORIO
        $linha='|'.$reg.'|'.$cod_ccus.'|'.$cod_agl.'|';
        $qtd_lin_i ++ ;
        //$qtd_lin ++;
        _matriz_linha($linha);
        //$escreve = fwrite($fp,"$linha\r\n") ;
        $tot_registro_52=$tot_registro_52+1;
        }
        }
        return ;
}

//REGISTRO I075: TABELA DE HISTÓRICO PADRONIZADO
function sped_ecd_registro_I075(){
        global $fp,$THISTORICOS,$CONTHISTORICOS,$qtd_lin_i,$REG_BLC;//,$qtd_lin;
        $sql="SELECT * FROM $THISTORICOS";
        $sel_historico = mysql_query($sql,$CONTHISTORICOS) ;
        while ($v=mysql_fetch_assoc($sel_historico) ) {
        $reg='I075';
        $cod_hist= $v[id];
        $descr_hist= $v[historico];
        $linha='|'.$reg.'|'.$cod_hist.'|'.$descr_hist.'|';
        $qtd_lin_i ++ ;
        //$qtd_lin ++;
        _matriz_linha($linha);
        //$escreve = fwrite($fp,"$linha\r\n");
        $tot_registro_bloco=$tot_registro_bloco+1;
        }
        $REG_BLC[]='I075|'.$tot_registro_bloco;
        return    ;
}

//REGISTRO I100: CENTRO DE CUSTOS
function sped_ecd_registro_I100(){
        global $fp,$qtd_lin_i,$TCENTROCUSTO,$CONTCENTROCUSTO,$REG_BLC;//,$qtd_lin;
        $sql="SELECT * FROM $TCENTROCUSTO";
        $sel_centrocusto = mysql_query($sql,$CONTCENTROCUSTO) ;
        while ($v=mysql_fetch_assoc($sel_centrocusto) ) {
        $reg='I100';
        $dt_alt=$v[dataatu];
        $cod_ccus=$v[conta];
        $ccus=$v[descricao];
        $linha='|'.$reg.'|'.$dt_alt.'|'.$cod_ccus.'|'.$ccus.'|';
        $qtd_lin_i ++ ;
        //$qtd_lin ++;
        _matriz_linha($linha);
        //$escreve = fwrite($fp,"$linha\r\n") ;
        }
        $tot_registro_bloco=$tot_registro_bloco+1;
        $REG_BLC[]='I100|'.$tot_registro_bloco;
        return;
}
//REGISTRO I150: SALDOS PERIÓDICOS - IDENTIFICAÇÃO DO PERÍODO
function sped_ecd_registro_I150(){
        global $fp,$qtd_lin_i,$REG_BLC,$lanperiodo1,$lanperiodo2,$tot_registro_I155;
       // FROM_UNIXTIME(pagamento, '%m/%Y')
        $reg='I150';
        //$dt_ini=_myfunc_ddmmaaaa($lanperiodo1);
        //$dt_fin=_myfunc_ddmmaaaa($lanperiodo2);
        
        $dt_inix=$lanperiodo1;
        $dt_finx=$lanperiodo2;
        
        $dt_ini_flag=$dt_inix;
        $data_mostrar_inicio=$dt_inix;
        

        $datatrans = explode("-",convdata($lanperiodo1,0));
        $data_mostrar_final=_myfunc_ultimodia_mes($datatrans[1],$datatrans[0]).'/'.$datatrans[1].'/'.$datatrans[0];


        
        $xdt_flag=substr($dt_inix,3,7) ;
        $xdt_fin=substr($dt_finx,3,7) ;
        $finished = false;
            $dt_ini_flag= _myfunc_aaaa_mm_dd($dt_ini_flag);
        $a=0;
        while ( ! $finished ):
        
               $xdt_flag=substr($data_mostrar_inicio,3,7) ;
               
               $data_mostrar_iniciox=_myfunc_ddmmaaaa($data_mostrar_inicio);
               $data_mostrar_finalx=_myfunc_ddmmaaaa($data_mostrar_final);
               
               $linha='|'.$reg.'|'.$data_mostrar_iniciox.'|'. $data_mostrar_finalx.'|';
               $qtd_lin_i ++ ;
               _matriz_linha($linha);
               $tot_registro_bloco=$tot_registro_bloco+1;
               sped_ecd_registro_I155($xdt_flag);

        
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
       
       
       $REG_BLC[]='I150|'.$tot_registro_bloco;
       $REG_BLC[]='I155|'.$tot_registro_I155;

return;
}

//REGISTRO I155: DETALHE DOS SALDOS PERIÓDICOS
function sped_ecd_registro_I155($mmaaaa){
 
       global $fp,$CONTPLANOCT,$qtd_lin_i,$info_cnpj_segmento,$REG_BLC,$tot_registro_I155;
       $graumaximo=strlen(_myfun_mascara_x($info_cnpj_segmento));
       //$sql="SELECT *,FROM_UNIXTIME(data, '%m/%Y') as mmaaaa FROM $TBALANCO where  mmaaaa='$mmaaaa'  and length(conta)='$graumaximo' AND (abs(saldo_ante)+debito+credito>0)";
       $TBALANCO_SPED='balanco_sped_'.substr($mmaaaa,0,2).substr($mmaaaa,3,4);
       $sql="SELECT * FROM $TBALANCO_SPED where length(conta)='$graumaximo' AND (abs(saldo_ante)+debito+credito>0)";
 
       $sel_balanco = mysql_query($sql,$CONTPLANOCT) ;
       
 
       
       
       while ($v=mysql_fetch_assoc($sel_balanco) ) {
       $reg='I155';
       $cod_cta=$v[conta];
       $cod_ccus='';
       $saldo_ante=$v[saldo_ante];
       if (strlen($saldo_ante<0)){
              $ind_dc_ini='C';

             }
             else
             {
             $ind_dc_ini='D';
             }
       $debito=$v[debito];
       $credito=$v[credito];
       $vl_sldo=($saldo_ante+$debito-$credito);
       if (strlen($vl_sldo<0)){
             $ind_dc_fin='C';

             }
             else
             {
             $ind_dc_fin='D';
             }

       $saldo_ini=abs($saldo_ante);
       $vl_sld=abs($vl_sldo);
       $vl_deb=number_format($debito, 2, ',', '');
       $vl_cred=number_format($credito, 2, ',', '');
       $vl_sld_ini=number_format($saldo_ini, 2, ',', '');
       $vl_sld_fin=number_format($vl_sld, 2, ',', '');
       $linha='|'.$reg.'|'.$cod_cta.'|'.$cod_ccus.'|'.$vl_sld_ini.'|'.$ind_dc_ini.'|'.$vl_deb.'|'.$vl_cred.'|'.$vl_sld_fin.'|'.$ind_dc_fin.'|';
       $qtd_lin_i ++ ;
       _matriz_linha($linha);
       $tot_registro_I155=$tot_registro_I155+1;
       }
       //$REG_BLC[]='I155|'.$tot_registro_I155;
       return ;
}
 //REGISTRO I200: LANÇAMENTO CONTÁBIL
function sped_ecd_registro_I200(){
        global $fp,$CONTPLANOCT,$qtd_lin_i,$REG_BLC,$tot_registro_250,$info_cnpj;//,$qtd_lin;
        $TLANDIARIO='landiario_'.$info_cnpj;
        $sql="SELECT sum(valorc) as xvalorc, sum(valord) as xvalord ,id,data FROM $TLANDIARIO group by data ";
        $sel_landiario = mysql_query($sql,$CONTPLANOCT) ;
        while ($v=mysql_fetch_assoc($sel_landiario) ) {
        $reg='I200';
        $num_lcto=$v[id];
        $dt_a=_myfunc_stod($v[data]);
        $dt_lcto=str_replace('/','',$dt_a);
        $valorc=$v[xvalorc];
        $valord=$v[xvalord];
        $vl=$valord;
        $vl_0=abs($vl);
        $vl_lcto=number_format($vl_0, 2, ',', '');
        $ind_lcto='N';
        $linha='|'.$reg.'|'.$num_lcto.'|'.$dt_lcto.'|'.$vl_lcto.'|'.$ind_lcto.'|';
        $qtd_lin_i ++ ;
        //$qtd_lin ++;
        _matriz_linha($linha);
        //$escreve = fwrite($fp,"$linha\r\n") ;
        $tot_registro_bloco=$tot_registro_bloco+1;
        sped_ecd_registro_I250($v[data]);
        }
        $REG_BLC[]='I200|'.$tot_registro_bloco;
        $REG_BLC[]='I250|'.$tot_registro_250;
        return ;
}



//REGISTRO I250: PARTIDAS DO LANÇAMENTO
function sped_ecd_registro_I250($datadia){
        global $fp,$CONTPLANOCT,$qtd_lin_i,$REG_BLC,$tot_registro_250,$info_cnpj;//,$qtd_lin;
                $TLANDIARIO='landiario_'.$info_cnpj;

 
       // $sql="SELECT * FROM $TLANDIARIO where data='$datadia' order by conta" ;

$datadiax=_myfunc_stod($datadia);
 
$sql="SELECT * FROM $TLANDIARIO where FROM_UNIXTIME(data,'%d/%m/%Y')='$datadiax' order by conta" ;

 
        $sel_landiario = mysql_query($sql,$CONTPLANOCT) ;
        while ($v=mysql_fetch_assoc($sel_landiario) ) {
        $reg='I250';
        $cod_cta=$v[conta];
        $cod_ccus='';
        $valorc=$v[valorc];
        $valord=$v[valord];

          $hist=_myfunc_removeacentos(trim($v[historico]).trim($v[obs]).'.');
            $hist=_myfunc_removeacentos_extras($hist);
        
        if ($valorc>0) {
            $ind_dc='C';
            $valor=$valorc;
            $vl_dc=number_format($valor, 2, ',', '');
            $num_arq=$v[id];
            $cod_hist_pad='';
           
            $cod_part='';
            $linha='|'.$reg.'|'.$cod_cta.'|'.$cod_ccus.'|'.$vl_dc.'|'.$ind_dc.'|'.$num_arq.'|'.$cod_hist_pad.'|'.$hist.'|'.$cod_part.'|';
            $qtd_lin_i ++ ;
            //$qtd_lin ++;
            _matriz_linha($linha);
            //$escreve = fwrite($fp,"$linha\r\n");
            $tot_registro_250=$tot_registro_250+1;
        }

        if ($valord>0) {
            $ind_dc='D';
            $valor=$valord;
            $vl_dc=number_format($valor, 2, ',', '');
            $num_arq=$v[id];
            $cod_hist_pad='';
          
            //$cod_part=$v[cnpjcpf];
            $cod_part='';
            $linha='|'.$reg.'|'.$cod_cta.'|'.$cod_ccus.'|'.$vl_dc.'|'.$ind_dc.'|'.$num_arq.'|'.$cod_hist_pad.'|'.$hist.'|'.$cod_part.'|';
            $qtd_lin_i ++ ;
            //$qtd_lin ++;
            _matriz_linha($linha);
            //$escreve = fwrite($fp,"$linha\r\n");
            $tot_registro_250=$tot_registro_250+1;
        }
        }
        return ;
}



//REGISTRO I310: DETALHES DO BALANCETE DIÁRIO
/*function sped_ecd_registro_I310(){
         global $fp,$TCONTLANDIARIO,$TLANDIARIO,$qtd_lin_i,$qtd_lin;
         $sql="SELECT * FROM $TLANDIARIO";
         $sel_landiario = mysql_query($sql,$TCONTLANDIARIO) ;
         while ($v=mysql_fetch_assoc($sel_landiario) ) {
         $reg='I310';
         $cod_cta=$v[conta];
         $cod_ccus='';
         $val_debd=$v[valord];
         $val_credd=$v[valord];
         $linha='|'.$reg.'|'.$cod_cta.'|'.$cod_ccus.'|'.$val_debd.'|'.$val_credd.'|';
         $qtd_lin_i ++ ;
         $qtd_lin ++;
         $escreve = fwrite($fp,"$linha\r\n");

         }
         return ;
} */

//REGISTRO I350: SALDOS DAS CONTAS DE RESULTADO ANTES DO ENCERRAMENTO - IDENTIFICAÇÃO DA DATA
function sped_ecd_registro_I350(){
        global $fp,$qtd_lin_i,$REG_BLC,$lanperiodo2;//,$qtd_lin;
        $reg='I350';
        $dt_res=_myfunc_ddmmaaaa($lanperiodo2);;
        $linha='|'.$reg.'|'.$dt_res.'|';
        $qtd_lin_i ++ ;
        //$qtd_lin ++;
        _matriz_linha($linha);
        //$escreve = fwrite($fp,"$linha\r\n");
        $tot_registro_bloco=$tot_registro_bloco+1;
        $REG_BLC[]='I350|'.$tot_registro_bloco;
        return ;
}

//REGISTRO I355: DETALHES DOS SALDOS DAS CONTAS DE RESULTADO ANTES DO ENCERRAMENTO
function sped_ecd_registro_I355(){
        global $fp,$TCONTLANDIARIO,$TLANDIARIO,$qtd_lin_i,$REG_BLC;//,$qtd_lin;
        $sql="SELECT * FROM $TLANDIARIO";
        $sel_landiario = mysql_query($sql,$TCONTLANDIARIO) ;
        while ($v=mysql_fetch_assoc($sel_landiario) ) {
        $reg='I355';
        $cod_cta=$v[conta];
        $cod_ccus='';
        $valorc=abs($v[valorc]);
        $valord=abs($v[valord]);
        $vl2=abs($valorc-$valord);
        $vl_cta=number_format($vl2, 2, ',', '');
        if (strlen($vl_cta<0)){
             $ind_dc='C';
             }
             else
             {
             $ind_dc='D';
             }
        $linha='|'.$reg.'|'.$cod_cta.'|'.$cod_ccus.'|'.$vl_cta.'|'.$ind_dc.'|';
        $qtd_lin_i ++;
        //$qtd_lin ++;
        _matriz_linha($linha);
        //$escreve = fwrite($fp,"$linha\r\n");
        $tot_registro_bloco=$tot_registro_bloco+1;
        }
        $REG_BLC[]='I355|'.$tot_registro_bloco;
        return ;
}

//REGISTRO I500: PARÂMETROS DE IMPRESSÃO E VISUALIZAÇÃO DO LIVRO RAZÃO AUXILIAR COM LEIAUTE PARAMETRIZÁVEL
/*function sped_ecd_registro_I500(){
         global $fp,$qtd_lin_i,$qtd_lin;
         $reg='I500';
         $tam_fonte='w';
         $linha='|'.$reg.'|'.$tam_fonte.'|';
         $qtd_lin_i ++ ;
         $qtd_lin ++;
         $escreve = fwrite($fp,"$linha\r\n");
         return;
}*/

//REGISTRO I510: DEFINIÇÃO DE CAMPOS DO LIVRO RAZÃO AUXILIAR COM LEIAUTE PARAMETRIZAVEL
/*function sped_ecd_registro_I510(){
         global $fp,$qtd_lin_i,$qtd_lin;
         $reg='I510';
         $nm_campo='w';
         $desc_campo='w';
         $tipo_campo='w';
         $tam_campo='w';
         $dec_campo='w';
         $col_campo='w';
         $linha='|'.$reg.'|'.$desc_campo.'|'.$tipo_campo.'|'.$tam_campo.'|'.$dec_campo.'|'.$col_campo.'|';
         $qtd_lin_i ++ ;
         $qtd_lin ++;
         $escreve = fwrite($fp,"$linha\r\n");
         return ;
}*/

//REGISTRO I550: DETALHES DO LIVRO AUXILIAR COM LEIAUTE PARAMETRIZÁVEL
function sped_ecd_registro_I550(){
         global $fp,$qtd_lin_i,$REG_BLC;//,$qtd_lin;
         $reg='I550';
         $rz_cont='';
         $linha='|'.$reg.'|'.$rz_cont.'|';
         $qtd_lin_i ++ ;
         //$qtd_lin ++;
         _matriz_linha($linha);
         //$escreve = fwrite($fp,"$linha\r\n");
         $tot_registro_bloco=$tot_registro_bloco+1;
         $REG_BLC[]='I550|'.$tot_registro_bloco;
         return;
}

//REGISTRO I555: TOTAIS NO LIVRO AUXILIAR CO LEIAUTE PARAMETRIZÁVEL
/*function sped_ecd_registro_I555(){
global $fp,$qtd_lin_i,$qtd_lin;
         $reg='I555';
         $rz_con_total='w';
         $linha='|'.$reg.'|'.$rz_cont_total.'|';
         $qtd_lin_i ++ ;
         $qtd_lin ++;
         $escreve = fwrite($fp,"$linha\r\n");
         return;
} */

//REGISTRO I990: ENCERRAMENTO DO BLOCO I
function sped_ecd_registro_I990(){
        global $fp,$qtd_lin_i,$REG_BLC;//,$qtd_lin;
        $reg='I990';
        $qtd_lin_i ++ ;
        $linha='|'.$reg.'|'.$qtd_lin_i.'|';
        //$qtd_lin ++;
        _matriz_linha($linha);
        //$escreve = fwrite($fp,"$linha\r\n");
        $tot_registro_bloco=$tot_registro_bloco+1;
        $REG_BLC[]='I990|'.$tot_registro_bloco;
        return;
}
//REGISTRO J001: ABERTURA DO BLOCO J
function sped_ecd_registro_J001(){
        global $fp,$qtd_lin_j,$REG_BLC;//,$qtd_lin;
        $reg='J001';
        $ind_dad='0';
        $linha='|'.$reg.'|'.$ind_dad.'|';
        $qtd_lin_j ++;
        //$qtd_lin ++;
        _matriz_linha($linha);
        //$escreve = fwrite($fp,"$linha\r\n")  ;
        $tot_registro_bloco=$tot_registro_bloco+1;
        $REG_BLC[]='J001|'.$tot_registro_bloco;
        return  ;
}
//REGISTRO J005: DEMONSTRAÇÕES CONTÁBEIS
function sped_ecd_registro_J005(){
        global $fp,$lanperiodo1,$lanperiodo2,$qtd_lin_j,$REG_BLC;//,$qtd_lin;
        $reg='J005';
        $dt_ini=_myfunc_ddmmaaaa($lanperiodo1);
        $dt_fin=_myfunc_ddmmaaaa($lanperiodo2);
        $id_dem='1';
        $cab_dem='';
        $linha='|'.$reg.'|'.$dt_ini.'|'.$dt_fin.'|'.$id_dem.'|'.$cab_dem.'|';
        $qtd_lin_j ++;
        //$qtd_lin ++;
        _matriz_linha($linha);
        //$escreve = fwrite($fp,"$linha\r\n") ;
        $tot_registro_bloco=$tot_registro_bloco+1;
        $REG_BLC[]='J005|'.$tot_registro_bloco;
        return;
}
//REGISTRO J100: BALANÇO PATRIMONIAL
function sped_ecd_registro_J100(){
        global $fp,$TBALANCO,$TCONTBALANCO,$qtd_lin_j,$REG_BLC,$info_cnpj_segmento;//,$qtd_lin;
        // provisorio
         $ativo="1";
         $passivo="2";
         
         
        $graumaximo=strlen(_myfun_mascara_x($info_cnpj_segmento));
        $sql="SELECT * FROM $TBALANCO where (substring(conta,1,1)='$ativo' or substring(conta,1,1)='$passivo') and length(conta)<>'$graumaximo' and  (abs(saldo_ante)+debito+credito>0)";
        $sel_balanco = mysql_query($sql,$TCONTBALANCO) ;
        while ($v=mysql_fetch_assoc($sel_balanco) ) {
        $reg='J100';
        $conta=$v[conta];
        $cod_agl=$conta;
        
         if (strlen($conta)==_myfun_len_grau_n($info_cnpj_segmento,1)) {
         $nivel_agl='1';

         }
         if(strlen($conta)==_myfun_len_grau_n($info_cnpj_segmento,2)){
         $nivel_agl='2';

         }
         if(strlen($conta)==_myfun_len_grau_n($info_cnpj_segmento,3)) {
         $nivel_agl='3';

         }
         if(strlen($conta)==_myfun_len_grau_n($info_cnpj_segmento,4)){
         $nivel_agl='4';

         }
         if(strlen($conta)==_myfun_len_grau_n($info_cnpj_segmento,5)) {
         $nivel_agl='5';

         }
         if(strlen($conta)==_myfun_len_grau_n($info_cnpj_segmento,6)){
         $nivel_agl='6';
         }
         // provisorio
         $ativo="1";
         $passivo="2";
         
         $xnivel=substr($conta,0,_myfun_len_grau_n($info_cnpj_segmento,1));

         switch ($xnivel) {
                 case "$ativo" :
                       $ind_grp_bal="1";
                       break;

                 case "$passivo" :
                       $ind_grp_bal="2";
                       break;

        }
         
         
        $descr_cod_agl=$v[descricao];
        $vl_sld_ini=$v[saldo_ante];
        $vl_deb=$v[debito];
        $vl_cred=$v[credito];
        $vl=$vl_sld_ini+($vl_deb-$vl_cred);
        if (strlen($vl<0)){
             $ind_dc_bal='C';

             }
            else
             {
             $ind_dc_bal='D';
             }
        $vl_cta=abs($vl);
        $vl_cta=number_format($vl_cta, 2, ',', '');
        $linha='|'.$reg.'|'.$cod_agl.'|'.$nivel_agl.'|'.$ind_grp_bal.'|'.$descr_cod_agl.'|'.$vl_cta.'|'.$ind_dc_bal.'|';
        $qtd_lin_j ++;
        //$qtd_lin ++;
        _matriz_linha($linha);
        //$escreve = fwrite($fp,"$linha\r\n") ;
        $tot_registro_bloco=$tot_registro_bloco+1;
        }
        $REG_BLC[]='J100|'.$tot_registro_bloco;
        return   ;
}

//REGISTRO J150: DEMONSTRAÇÃO DO RESULTADO DO EXERCÍCIO
function sped_ecd_registro_J150(){
        global $fp,$TBALANCO,$TCONTBALANCO,$TDRE,$CONTDRE,$qtd_lin_j,$REG_BLC;//,$qtd_lin;
        //$sql="SELECT * FROM $TDRE$TBALANCO";
        $sql="SELECT * FROM $TDRE order by linhadre";

        $sel_dre = mysql_query($sql,$CONTDRE) ;
        while ($v=mysql_fetch_assoc($sel_dre) ) {
        $reg='J150';
        $cod_agl=$v[contas];
        
         if (strlen($conta_agl)==_myfun_len_grau_n($info_cnpj_segmento,1)) {
         $nivel_agl='1';
         }
         if(strlen($conta_agl)==_myfun_len_grau_n($info_cnpj_segmento,2)){
         $nivel_agl='2';
         }
         if(strlen($conta_agl)==_myfun_len_grau_n($info_cnpj_segmento,3)) {
         $nivel_agl='3';
         }
         if(strlen($conta_agl)==_myfun_len_grau_n($info_cnpj_segmento,4)){
         $nivel_agl='4';
         }
         if(strlen($conta_agl)==_myfun_len_grau_n($info_cnpj_segmento,5)) {
         $nivel_agl='5';
         }
         if(strlen($conta_agl)==_myfun_len_grau_n($info_cnpj_segmento,6)){
         $nivel_agl='6';
         }
        
        $descr_cod_agl=$v[descricao];
        //$vl_sld_ini=$v[saldo_ante];
        //$vl_deb=$v[debito];
        //$vl_cred=$v[credito];
        $vl3=$v[saldo]; //$vl_sld_ini+($vl_deb-$vl_cred);
        $v=substr($vl3,0,1);
        if ($v == '-'){
           $ind_vl='N';
        }
        if ($v <> '-'){
           $ind_vl='P';
        }

        //$vl4=abs($vl_sld_ini+($vl_deb-$vl_cred));
        $vl4=abs($vl3);
        $vl_cta=number_format($vl4, 2, ',', '');
         if($vl3<>0){
                $linha='|'.$reg.'|'.$cod_agl.'|'.$nivel_agl.'|'.$descr_cod_agl.'|'.$vl_cta.'|'.$ind_vl.'|';
                $qtd_lin_j ++;
                //$qtd_lin ++;
                _matriz_linha($linha);
                //$escreve = fwrite($fp,"$linha\r\n");
                $tot_registro_bloco=$tot_registro_bloco+1;
        }
     }
     $REG_BLC[]='J150|'.$tot_registro_bloco;
     return  ;
}
//REGISTRO J800: OUTRAS INFORMAÇÕES
function sped_ecd_registro_J800(){
        global $fp,$qtd_lin_j,$REG_BLC;//,$qtd_lin;
        $reg='J800';
        $arq_rtf='Obs';
        $ind_fin_rtf='J800FIM';
        $linha='|'.$reg.'|'.$arq_rtf.'|'.$ind_fin_rtf.'|';
        $qtd_lin_j ++;
        //$qtd_lin ++;
        _matriz_linha($linha);
        //$escreve = fwrite($fp,"$linha\r\n") ;
        $tot_registro_bloco=$tot_registro_bloco+1;
        $REG_BLC[]='J800|'.$tot_registro_bloco;
        return  ;
}

//REGISTRO J900: TERMO DE ENCERRAMENTO
function sped_ecd_registro_J900(){
        global $fp,$info_segmento,$qtd_lin_j,$lanperiodo1,$lanperiodo2,$REG_BLC;//,$qtd_lin;
        $reg='J900';
        $dnrc_encer='TERMO DE ENCERRAMENTO';
        $num_ord=$info_segmento[ord_ecd];
        $nat_livro='DIARIO';
        $nome=_myfunc_removeacentos($info_segmento[razaosocial]);
        $qtd_lin='www';
        $dt_ini_escr=_myfunc_ddmmaaaa($lanperiodo1);
        $dt_fin_escr=_myfunc_ddmmaaaa($lanperiodo2);
        $linha='|'.$reg.'|'.$dnrc_encer.'|'.$num_ord.'|'.$nat_livro.'|'.$nome.'|'.$qtd_lin.'|'.$dt_ini_escr.'|'.$dt_fin_escr.'|';
        $qtd_lin_j ++;
        //$qtd_lin ++;
        _matriz_linha($linha);
        //$escreve = fwrite($fp,"$linha\r\n")  ;
        $tot_registro_bloco=$tot_registro_bloco+1;
        $REG_BLC[]='J900|'.$tot_registro_bloco;
        return  ;
}


//REGISTRO J930: IDENTIFICAÇÃO DOS SIGNATÁRIOS DA ESCRITURAÇÃO
function sped_ecd_registro_J930(){
        global $info_segmento,$info_cnpj_segmento,$TCONTABILISTA,$TCNPJCPF,$fp,$CONTCONTABILISTA,$qtd_lin_j,$REG_BLC;
        //tabela contabilista
        $sel_contabilista = mysql_query("SELECT * FROM $TCONTABILISTA WHERE cnpjcpfseg='$info_cnpj_segmento'",$CONTCONTABILISTA);

        If (mysql_num_rows($sel_contabilista)) {
              $info_contabilista = mysql_fetch_assoc($sel_contabilista);
        }
        $reg='J930';
        $ident_cpf=$info_contabilista[cpf];
	    $cnpj_bres=_myfun_dados_cnpjcpf($ident_cpf) ;
        $ident_nom=$cnpj_bres[razao];
                
        $ident_qualif='Contabilista';//não tem na tabela
        $cod_assin='900';//não tem na tabela
        $ind_crc=$info_contabilista[crc];
        $linha='|'.$reg.'|'.$ident_nom.'|'.$ident_cpf.'|'.$ident_qualif.'|'.$cod_assin.'|'.$ind_crc.'|';
        $qtd_lin_j ++;
        //$qtd_lin ++;
        _matriz_linha($linha);
        //$escreve = fwrite($fp,"$linha\r\n")  ;
        $tot_registro_bloco=$tot_registro_bloco+1;

        // Dados Signatario,cnpjcpfsignat1,codsignatar1
        $ident_cpf=$info_segmento[cnpjcpfsignat1];
	    $cnpj_bres=_myfun_dados_cnpjcpf($ident_cpf) ;
        $ident_nom=$cnpj_bres[razao];

        $ident_qualif='Diretor';//não tem na tabela
 $cod_assin=$info_segmento[codsignatar1];
$m_matriz_signatarios = MATRIZ::m_matriz_signatarios();
$ident_qualif=$m_matriz_signatarios[$cod_assin];

        $ind_crc='';
        $linha='|'.$reg.'|'.$ident_nom.'|'.$ident_cpf.'|'.$ident_qualif.'|'.$cod_assin.'|'.$ind_crc.'|';
        $qtd_lin_j ++;

        if($ident_cpf<>''){
           _matriz_linha($linha);
          //$escreve = fwrite($fp,"$linha\r\n")  ;
          $tot_registro_bloco=$tot_registro_bloco+1;
        }

        $REG_BLC[]='J930|'.$tot_registro_bloco;

        return ;

}



//REGISTRO J990: ENCERRAMENTO DO BLOCO J
function sped_ecd_registro_J990(){
        global $fp,$qtd_lin_j,$REG_BLC;//,$qtd_lin;
        $reg='J990';
        $qtd_lin_j ++;
        $linha='|'.$reg.'|'.$qtd_lin_j.'|';
        //$qtd_lin ++;
        _matriz_linha($linha);
        //$escreve = fwrite($fp,"$linha\r\n") ;
        $tot_registro_bloco=$tot_registro_bloco+1;
        $REG_BLC[]='J990|'.$tot_registro_bloco;
        return  ;
}
//REGISTRO 9001: ABERTURA DO BLOCO 9
function sped_ecd_registro_9001(){
        global $fp,$REG_BLC,$cont;//,$qtd_lin;
        $reg='9001';
        $ind_dad='0';
        $linha='|'.$reg.'|'.$ind_dad.'|';
        $cont ++;
        //$qtd_lin ++;
        _matriz_linha($linha);
        //$escreve = fwrite($fp,"$linha\r\n") ;
        $tot_registro_bloco=$tot_registro_bloco+1;
        $REG_BLC[]='9001|'.$tot_registro_bloco;
        return  ;
}
//REGISTRO 9900: REGISTROS DO ARQUIVO

function sped_ecd_registro_9900(){
        global $fp,$REG_BLC,$cont,$qtd_lin_9990;
        
        

        // INCREMENTAR +3  REF. 9900, 9990  E 9999
        $tot_registro_bloco_9900=count($REG_BLC)+3;

        $REG_BLC[]='9900|'.$tot_registro_bloco_9900;
        $REG_BLC[]='9990|1';
        $REG_BLC[]='9999|1';
        
        $qtd_lin_9990= $tot_registro_bloco_9900;

        // INSERIR O 9990 E 9999 MO BLOCO 9

   //     $linha='|9900|9990|1|';
   //     _matriz_linha($linha);

     //   sped_ecd_registro_9990() ;
     //   sped_ecd_registro_9999();
        
   //     $linha='|9900|9999|1|';
   //     _matriz_linha($linha);
        

        $reg='9900';
        $cont=0;
        $i=count($REG_BLC);
        while($cont<$i){
                        $linha='|'.$reg.'|'.$REG_BLC[$cont].'|';
                        _matriz_linha($linha);
                        

                        $cont++;
                        }


        return ;
}

//REGISTRO 9990: ENCERRAMENTO DO BLOCO 9
function sped_ecd_registro_9990(){
       global $fp,$cont,$REG_BLC;
       $reg='9990';
       $cont ++;
       $cont=$cont+2;
       $linha='|'.$reg.'|'.$cont.'|';

       _matriz_linha($linha);

       return;
}

//REGISTRO 9999: ENCERRAMENTO DO ARQUIVO DIGITAL
function sped_ecd_registro_9999(){
       global $fp,$qtd_lin_0,$qtd_lin_i,$qtd_lin_j,$cont,$qtd_lin,$qtd_lin_9990,$REG_BLC,$cont;
       $reg='9999';
     //  $cont ++;
       $qtd_lin=$cont+$qtd_lin_i+$qtd_lin_j+$qtd_lin_0;

       //+$qtd_lin_9990;
       


       $linha='|'.$reg.'|'.$qtd_lin.'|';
       

       
       _matriz_linha($linha);

       return  ;
}

function  _matriz_linha($conteudo) {
         global $matriz_linha_ecd,$l030,$J900;
         if (trim($conteudo)<> '') {
         $matriz_linha_ecd[]=$conteudo;
         if (substr($conteudo,1,4)=='I030') {
            $l030 = count($matriz_linha_ecd);
         }
         if (substr($conteudo,1,4)=='J900') {
            $J900 = count($matriz_linha_ecd);
         }
         }
         return;
}
function escreve_matriz_linha(){
        global $matriz_linha_ecd,$fp,$qtd_lin,$l030,$J900;
 
        $l030=$l030-1;
        $J900=$J900-1;
        $string = $matriz_linha_ecd[$l030];
        $string1 = $matriz_linha_ecd[$J900];
        $matriz_linha_ecd[$l030] = ereg_replace('xyzqw',"$qtd_lin" , $string);
        $matriz_linha_ecd[$J900] = ereg_replace('www',"$qtd_lin" , $string1);
        $cont=0;
        $i = count($matriz_linha_ecd);
        


 
      
        
        while($cont < $i) {
                $linha = trim($matriz_linha_ecd[$cont]);
                $escreve = fwrite($fp,"$linha\r\n");

 // $sql="insert into  spedecd (linha) values ('$linha')";
 // if ( mysql_query($sql) or die (mysql_error()) ) {
// } 

                $cont++;
        }

        return ;
}


?>

