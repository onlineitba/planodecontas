<?
 // 08/12/2015
/*
  
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
 * @name      sped_efd_piscofins_funcoes.php
 * @version   2.0  20130310
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL v.3
 * @copyright 2012 &copy; PLANO D/C
 * @link      http:planodecontas.net
 * @author    Walber S Sales <eng.walber at gmail dot com>

 *        CONTRIBUIDORES (em ordem alfabetica):

 * AUREO NEVES DE SOUZA JUNIOR <onlinesistema at hotmail.com.br>
 * PATRICIA BERNARDES BARCELOS <tyssa_bernardes at hotmail.com>




*/
 

global $REG_BLC;


include('mysql_performace.php');

sped_efd_pis_registro_0000(); //ABERTURA, IDENTIFICAÇÃO E REFERÊNCIAS
sped_efd_pis_registro_0001(); //ABERTURA DO BLOCO 0
sped_efd_pis_registro_0100(); //DADOS DO CONTABILISTA 
sped_efd_pis_registro_0110(); //REGIMES DE APURAÇÃO DA CONTRIBUIÇÃO  SOCIAL E DE APROPRIAÇÃO DE CRÉDITO
 
$cod_inc_trib=$_POST[cod_inc_trib];
$ind_apro_cred=$_POST[ind_apro_cred];
 
if (($cod_inc_trib=='1' or $cod_inc_trib=='3') and $ind_apro_cred=='2') {
	sped_efd_pis_registro_0111(); //TABELA DE RECEITA BRUTA MENSAL PARA FINS DE RATEIO DE CRÉDITOS COMUNS

}


sped_efd_pis_registro_0140(); //TABELA DE CADASTRO DE ESTABLECIMENTO

sped_efd_pis_registro_0145(); //REGIME DA APURAÇÃO DA CONTRIBUIÇÃO PREVIDENCIAR SOBRE A RECEITA BRUTA

sped_efd_pis_registro_0150(); //TABELA DO CADASTRO DO PARTICIPANTE

// sped_efd_pis_registro_0190(); //IDENTIFICAÇÃO DAS UNIDADES DE MEDIDA

sped_efd_pis_registro_0200(); //TABELA DE IDENTIFICAÇÃO DO ITEM (PRODUTOS E SERVIÇOS)

//sped_efd_pis_registro_0205(); //ALTERAÇÃO DO ITEM
//sped_efd_pis_registro_0206(); //CÓDIGO DE PRODUTO CONFORME TABELA ANP (COMBUSTÍVEIS)
//sped_efd_pis_registro_0208(); //CÓDIGO DE GRUPOS POR MARCA COMERCIAL REFRI (BEBIDAS FRIAS).

sped_efd_pis_registro_0400(); //TABELA DE NATUREZA DA OPERAÇÃO/PRESTAÇÃO
sped_efd_pis_registro_0450(); //TABELA DE INFORMAÇÃO COMPLEMENTAR DO DOCUMENTO FISCAL
sped_efd_pis_registro_0500(); //PLANO DE CONTAS CONTÁBEIS
sped_efd_pis_registro_0600(); //CENTRO DE CUSTOS
sped_efd_pis_registro_0990(); //ENCERAMENTO DO BLOCO 0

ECHO "BLOCO 0 - OK <BR>";
flush();
// inicio funcoes

	function sped_efd_pis_registro_0000() { //ABERTURA, IDENTIFICAÇÃO E REFERÊNCIAS
		global $qtd_lin_0,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$info_cnpj_segmento,$TSEGMENTOS,$cod_ver;

		$sel_segmento = mysql_query("SELECT * FROM $TSEGMENTOS  WHERE cnpjcpf='$info_cnpj_segmento'");

		if (mysql_num_rows($sel_segmento)) {
		$info_segmento= mysql_fetch_assoc($sel_segmento);
		}

		   $reg='0000';
		  // $cod_ver=$_POST[cod_ver]; //Referente versão do leiaute 1.01 ADE Cofis nº 34/2010, atualizado pelo ADE Cofis nº 37/2010
 			$tamanho3=3;
                      $cod_ver=_myfunc_zero_a_esquerda($cod_ver,$tamanho3) ;

		   $tipo_escrit=$_POST[tipo_escrit]; //tipo de escrituração 0-Original ou 1-Retificadora

		   $num_rec_anterior='';
                   IF ($tipo_escrit=='1') {
			$num_rec_anterior=$_POST[num_rec_anterior];
                   }
 		   $ind_sit_esp=$_POST[ind_sit_esp];//indicador de situação especial 0-Abertura,1-Cisão,2-Fusão,3-Incorporação,4-Encerramento.
                   if ($ind_sit_esp=='selected') {
			$ind_sit_esp='';
		   }
		  
 		   $dt_ini=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo1));
        	   $dt_fin=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo2));
		 
		  

		   $nome=_myfunc_removeacentos($info_segmento['razaosocial']);
		   $cnpj=$info_segmento['cnpjcpf'];
		   $uf=$info_segmento['uf'];
		   $cod_mun=_apenas_numeros($info_segmento['cod_mun']);
		   $suframa=$info_segmento['suframa'];
		  
		   $ind_nat_pj=$_POST[ind_nat_pj] ;//00 - Sociedade empresária em geral, 01 - Sociedade Cooperativa e 02 - Entidade Sujeita ao PIS/Pasep exclusivamente com base na Folha de salário

		   $ind_ativ=$info_segmento['ind_ativ'];

		  

		   $linha='|'.$reg.'|'.$cod_ver.'|'.$tipo_escrit.'|'.$ind_sit_esp.'|'.$num_rec_anterior.'|'.$dt_ini.'|'.$dt_fin.'|'.$nome.'|'.$cnpj.'|'.$uf.'|'.$cod_mun.'|'.$suframa.'|'.$ind_nat_pj.'|'.$ind_ativ.'|';
	           _matriz_linha($linha);
		   $tot_registro_bloco=1;
                   $REG_BLC[]='|0000|'.$tot_registro_bloco.'|';
 		   $qtd_lin_0 ++;
                     


		   return;
	}




 


	function sped_efd_pis_registro_0001() { // //ABERTURA DO BLOCO 0
	global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$qtd_lin_0;

	   $reg='0001';

	   $ind_mov='0'; //0 - com dados e 1 - sem dados.

	   $linha='|'.$reg.'|'.$ind_mov.'|';

   		_matriz_linha($linha);
		   $tot_registro_bloco=1;
                   $REG_BLC[]='|0001|'.$tot_registro_bloco.'|';
 		   $qtd_lin_0 ++;
 

	  
	   return;
	}


		function sped_efd_pis_registro_0100() { //DADOS DO CONTABILISTA 
		global $info_cnpj_segmento,$qtd_lin_0,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$TCONTABILISTA,$CONTCONTABILISTA,$TCNPJCPF;

		   $sel_contabilista = mysql_query("SELECT a.cpf,a.crc,a.cnpj AS cnpjescritorio,b.* FROM $TCONTABILISTA as a, $TCNPJCPF as b WHERE a.cpf=b.cnpj and a.cnpjcpfseg='$info_cnpj_segmento'");

		   while ($v=mysql_fetch_assoc($sel_contabilista)) {

		   $reg='0100';
		   $nome=_myfunc_removeacentos($v['razao']);
		   $cpf=$v['cpf'];
		   $crc=$v['crc'];
		   $cnpjescritorio=trim($v['cnpjescritorio']);
		   $cep=$v['cep'];
		   $end=_myfunc_removeacentos($v['endereco']);
		   $num=$v['num'];
		   $compl=_myfunc_removeacentos($v['compl']);
		   $bairro=_myfunc_removeacentos($v['bairro']);
		 
		   $fone=_myfunc_zero_a_esquerda($v['tel'],10) ;
                   $fone=substr($fone,0,10);

  		   $fax=_myfunc_zero_a_esquerda($v['fax'],10) ;
                   $fax=substr($fax,0,10);
		  
		 
		   $email=$v['email'];

		   $cod_mun=$v['cod_mun'];
		 
		   $linha='|'.$reg.'|'.$nome.'|'.$cpf.'|'.$crc.'|'.$cnpj.'|'.$cep.'|'.$end.'|'.$num.'|'.$compl.'|'.$bairro.'|'.$fone.'|'.$fax.'|'.$email.'|'.$cod_mun.'|';

		   _matriz_linha($linha);
		   $tot_registro_bloco=$tot_registro_bloco+1;
             

		   }
   		   $REG_BLC[]='|0100|'.$tot_registro_bloco.'|';
 		   $qtd_lin_0=$qtd_lin_0+  $tot_registro_bloco;

		   return;

		}




 

 

 

	function sped_efd_pis_registro_0110(){ //REGIMES DE APURAÇÃO DA CONTRIBUIÇÃO  SOCIAL E DE APROPRIAÇÃO DE CRÉDITO
		global $qtd_lin_0,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$cod_ver;

		   $reg='0110';
		   $cod_inc_trib=$_POST[cod_inc_trib];
		   $ind_apro_cred=$_POST[ind_apro_cred];
		   $cod_tipo_cont=$_POST[cod_tipo_cont];
		    $ind_reg_cum=$_POST[ind_reg_cum];
			 if($cod_inc_trib<>'2'){
             			 $ind_reg_cum=''; // Lista apenas se incidencia exclusivamente no regime cumulativo, ou seja, $ind_reg_cum=2
           		}

		   $linha='|'.$reg.'|'.$cod_inc_trib.'|'.$ind_apro_cred.'|'.$cod_tipo_cont.'|';
			if ($cod_ver>='003')  {
			   $linha='|'.$reg.'|'.$cod_inc_trib.'|'.$ind_apro_cred.'|'.$cod_tipo_cont.'|'.$ind_reg_cum.'|';   // OBS , no layout manual ver tem 5 parametros e validaro aceita 4
			}
		  _matriz_linha($linha);
			   $tot_registro_bloco=1;
		           $REG_BLC[]='|0110|'.$tot_registro_bloco.'|';
	 		   $qtd_lin_0 ++;
	 
	   	return;

	}

//TABELA DE RECEITA BRUTA MENSAL PARA FINS DE RATEIO DE CRÉDITOS COMUNS
function sped_efd_pis_registro_0111(){
global $qtd_lin_0,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC;

   $reg='0111';

   $rec_bru_ncum_trib_mi=''; // calcular via select
   $rec_bru_ncum_trib_mi=_myfunc_sql_receitas_piscofins('rec_bru_ncum_trib_mi');
 $rec_bru_ncum_nt_mi=_myfunc_sql_receitas_piscofins('rec_bru_ncum_nt_mi');
 
   $rec_bru_ncum_exp='0.00'; // calcular via select
   $rec_bru_ncum_exp= number_format($rec_bru_ncum_exp, 2, ',', '');

   $rec_bru_cum=_myfunc_sql_receitas_piscofins('rec_bru_cum');

 
   $rec_bru_cum= number_format($rec_bru_cum, 2, ',', '');

   $rec_bru_total= $rec_bru_ncum_trib_mi+$rec_bru_ncum_nt_mi; // calcular via select
   $rec_bru_total= number_format($rec_bru_total, 2, ',', '');


   $rec_bru_ncum_trib_mi= number_format($rec_bru_ncum_trib_mi, 2, ',', '');

   
   $rec_bru_ncum_nt_mi= number_format($rec_bru_ncum_nt_mi, 2, ',', '');


   $linha='|'.$reg.'|'.$rec_bru_ncum_trib_mi.'|'.$rec_bru_ncum_nt_mi.'|'.$rec_bru_ncum_exp.'|'.$rec_bru_cum.'|'.$rec_bru_total.'|';
   _matriz_linha($linha);
			   $tot_registro_bloco=1;
		           $REG_BLC[]='|0111|'.$tot_registro_bloco.'|';
	 		   $qtd_lin_0++;
   return;

}


//TABELA DE CADASTRO DE ESTABLECIMENTO
function sped_efd_pis_registro_0140(){
global $qtd_lin_0,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_0140;

   $reg='0140';

   $cod_est=$info_segmento['cnpjcpf'];
   $nome=_myfunc_removeacentos($info_segmento['razaosocial']);
 

   $cnpj=$info_segmento['cnpjcpf'];
 
   $uf=$info_segmento['uf'];
  
   $ie=$info_segmento['ie'];
   
   $cod_mun=$info_segmento['cod_mun'];
  
   $im=$info_segmento['im'];

   $suframa=$info_segmento['suframa'];
  
   $linha='|'.$reg.'|'.$cod_est.'|'.$nome.'|'.$cnpj.'|'.$uf.'|'.$ie.'|'.$cod_mun.'|'.$im.'|'.$suframa.'|';
   _matriz_linha($linha);
			   $tot_registro_bloco=1;
		           $REG_BLC[]='|0140|'.$tot_registro_bloco.'|';
	 		   $qtd_lin_0++;
   
   return;
}


//  REGSITRO 0145 - REGIME DA APURAÇÃO DA CONTRIBUIÇÃO PREVIDENCIAR SOBRE A RECEITA BRUTA
// NIVEL -3
function sped_efd_pis_registro_0145(){
   global $qtd_lin_0,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_0145;
   global $TLANCAMENTOS,$TNFDOCUMENTOS,$TITEM_FLUXO,$TNFDOCUMENTOS_TMP,$TNFDOCUMENTOS,$CONTNFDOCUMENTOS,$info_cnpj_segmento;
   global $vl_rec_tot; // Para totalização do registro P001

    $reg='0145';
    $vl_rec_tot=0.00;

    $filtro_lancamentos=" and POSITION(modelo IN ':01:1B:2D:04:55:') > 0 and movimento='RECEITAS'";
    $sql_lancamentos= _myfunc_sql_receitas_despesas_documentos('',"$filtro_lancamentos",'','','');

    while ($v=mysql_fetch_assoc($sql_lancamentos)) {

	    $dono=$v[dono];
	    $cst_pis=$v[cst_pis];
        if($cst_pis=='01'){
           $vl_doc=($v[svprod]+$v[svfrete]+$v[svseg]+$v[svicmsst]+$v[svipi]+$v[svoutro])-$v[svdesc];
           $vl_rec_tot=$vl_rec_tot+$vl_doc;
        }
        
    }

    // Código indicador da incidência da tributaria no período
    $cod_inc_trib='1';
                   /*
                   1 - Contr. previdenciária apurada no período, exclusivamente com base na receita bruta
                   2 - Contr. previdenciária apurada no período, com base na receita bruta e com base nas
                       remunerações pagas, na forma dos incisos I e III do art. 22 da lei 8212, de 1991.
                   */

    // 13/07/2013
	if ($vl_rec_tot<=0) { //  No caso de não auferir quaisquer das receitas, nas hipóteses previstas em lei, não precisa ser informado o registro 0145, muito menos ser escriturado o Bloco P.

            return;

	}
                   

    $vl_rec_tot=number_format(abs($vl_rec_tot), 2, ",", "") ;
    $vl_rec_ativ=number_format(abs($vl_rec_tot), 2, ",", "") ;
    $vl_rec_demais_ativ=''; //number_format(abs($vl_rec_tot_est), 2, ",", "") ;
    $info_compl='';

    $linha='|'.$reg.'|'.$cod_inc_trib.'|'.$vl_rec_tot.'|'.$vl_rec_ativ.'|'.$vl_rec_demais_ativ.'|'.$info_compl.'|';
    $qtde_linha_bloco_0145++ ;

   _matriz_linha($linha);
   $tot_registro_bloco=1;
   $REG_BLC[]='|0145|'.$tot_registro_bloco.'|';
   $qtd_lin_0++;
   $tot_0145=$total_registro_bloco;

   return;

}

//TABELA DO CADASTRO DO PARTICIPANTE
function sped_efd_pis_registro_0150() {

	global $qtd_lin_0,$info_segmento,$fp,$REG_BLC,$TLANCAMENTOS,$TCNPJCPF,$lanperiodo1,$lanperiodo2;

        $sql_partipantes=_myfunc_sql_cnpjcpf_participantes_periodo();  // movimento = receitas e despesas, todos cnpjcpf do periodo

     	while ( $partipantes = mysql_fetch_assoc($sql_partipantes)) {

     
             $reg='0150';

             $cod_part=$partipantes['cnpj'];
             $nome=$partipantes['razao'];
             $cod_pais=$partipantes['pais'];

             $cnpj='';
             $cpf='';

             if ((strlen($partipantes['cnpj']))==14) {
                  $cnpj=$partipantes['cnpj'];
                  $ie=_apenas_numeros($partipantes['inscricao']);
             }else{
                  $ie='';
                  $cpf=$partipantes['cnpj'];
             }

            
            
             $cod_mun=$partipantes['cod_mun'];
            
             $suframa=$partipantes['suframa'];
            
             $end=$partipantes['endereco'];
            
             $num=$partipantes['num'];

             $compl=$partipantes['compl'];
           
             $bairro=$partipantes['bairro'];
           
             $linha='|'.$reg.'|'.$cod_part.'|'.$nome.'|'.$cod_pais.'|'.$cnpj.'|'.$cpf.'|'.$ie.'|'.$cod_mun.'|'.$suframa.'|'.$end.'|'.$num.'|'.$compl.'|'.$bairro.'|';
            
       
		   _matriz_linha($linha);
		   $tot_registro_bloco=$tot_registro_bloco+1;
             

	   }
   		   $REG_BLC[]='|0150|'.$tot_registro_bloco.'|';
 		   $qtd_lin_0=$qtd_lin_0+  $tot_registro_bloco;

       return;


}

//REGISTRO 0190: IDENTIFICAÇÃO DAS UNIDADES DE MEDIDA

function sped_efd_pis_registro_0190() {
                 return ;  // esta em g
                global $info_segmento,$fp,$livro_reg;
                global $TUNIDADE_FATOR_CONVERSAO,$TITEM_FLUXO,$CONTITEM_FLUXO,$TLANCAMENTOS,$perdtos1,$perdtos2,$info_cnpj_segmento;
           
 		$sel_itens=_myfunc_sql_receitas_despesas_itens('','') ;
                $selunidade = mysql_query("SELECT a.*,b.ucom FROM $TUNIDADE_FATOR_CONVERSAO as a,$livro_reg as b where a.unidad_conv=b.ucom group by b.ucom order by b.ucom ASC",$CONTITEM_FLUXO);


                $tot_registro_bloco=0;
                while ( $punidade = mysql_fetch_assoc($selunidade) ) {
                         $linha='|0190|'.$punidade[ucom].'|'.$punidade[descricao].'|';
                       _matriz_linha($linha);
                }

                 
                return;
}

//TABELA DE IDENTIFICAÇÃO DO ITEM (PRODUTOS E SERVIÇOS)
function sped_efd_pis_registro_0200() {
global $CONTITEM_FLUXO,$TUNIDADE_FATOR_CONVERSAO,$livro_reg,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$TITEM_FLUXO,$TPRODUTOS,$CONTITEM_FLUXO,$TSERVICOS,$info_cnpj_segmento,$TVEICULOS,$CONTVEICULOS;
 
//Este registro tem por objetivo informar as mercadorias, serviços, produtos ou quaisquer outros itens concernentes às transações representativas de receitas e/ou geradoras de créditos
// O Código do Item deverá ser preenchido com as informações utilizadas na última ocorrência do período.
          
	 
 $sel_itens=_myfunc_sql_receitas_despesas_itens('','') ;

  

      $modelos_inclusos="|2D|3A|03|01|1B|04|06|07|08|8B|09|10|11|21|22|26|27|28|29|55|57|"; 
 	 $filtro_modelos="   POSITION(a.modelo IN '$modelos_inclusos')>0 ";    
 

        // 0190 em 0200        


$sql_190="SELECT b.*,a.ucom FROM $livro_reg as a,$TUNIDADE_FATOR_CONVERSAO as b where b.unidad_conv=a.ucom and $filtro_modelos group by a.ucom order by a.ucom ASC";
     	$selunidade = mysql_query("$sql_190",$CONTITEM_FLUXO);
 

                $tot_registro_bloco=0;
                while ( $punidade = mysql_fetch_assoc($selunidade) ) {
                         $linha='|0190|'.$punidade[ucom].'|'.$punidade[descricao].'|';
                       _matriz_linha($linha);
                }



     
                                                                                                                      
 
                

			$sql_0200="select ucom,cprod,modelo,tipo_lancamento from $livro_reg as a where $filtro_modelos group by cprod";
		 
			$sel_itens=mysql_query("$sql_0200");

		

 
 
		       while ( $itens = mysql_fetch_assoc($sel_itens) ) {
 
			     $cod_barra='';
				$tipi='';
			 			$cod_lst='';
						$cod_barra='';
						$cod_ncm='';
					        $tipo_item='00';
						$descr_item='';


			     $cod_item=$itens['cprod'];
			     $ok='N';
				$tipo_tabela='tipo_tabela';

				// produtos
				$dados_item=_myfun_dados_produto($cod_item);
			        $descr_item=$dados_item['descricao'];
		  		$cod_barra=$dados_item['cean'];
				$cod_ncm=$dados_item['ncm'];
				$tipi=$dados_item['cenqipi'];
				$xunidade=$dados_item['unidade'];
				$tipo_item=$dados_item['tipoitem'];
				if ($descr_item<>'') {
  					$ok='';
					$tipo_tabela='PRODUTOS';
				}
 
			    if ($ok=='N') {  // servicos
				$dados_item=_myfun_dados_servicos($cod_item);
				$xunidade=$dados_item['unidade'];
				$tipo_item='09';

				$cod_lst=$dados_item[cod_lst];
				   $descr_item=$dados_item['descricao'];
				if ($descr_item<>'') {
  					$ok='';
					$tipo_tabela='SERVICOS';
				}

			     }
			  
			  
				if ($ok=='N') {  // despesas

						 
 						$dados_item=_myfun_dados_itens_despesas($cod_item);
				 		$descr_item=$dados_item['descricao'];
						$xunidade=$dados_item['unidade'];
						$tipo_item='09';
						 
							  
						if ($descr_item<>'') {
		  					$ok='';
							$tipo_tabela='DESPESAS';
						}
					
				}

				 

			  

			     IF ($ok=='N') {  // buscar veiculos
				 $dados_item=_myfunc_dados_motors_via_chassi($cod_item);
				 $descr_item = $dados_item['descricao'];
 
				 $xunidade='UN';
				 $tipo_item='00';
					 if ($descr_item<>'') {
		                            $ok='';
					    $tipo_tabela='VEICULOS';
					 	}
				 
			         }
 
				 IF (ok=='N') {  // buscar itens NF_COMPLEMENTAR
						 $dados_item=_myfun_dados_itens_nfcomplementar($cod_item);
						 $descr_item=$dados_item['descricao'];
						$xunidade=$dados_item['unidade'];
						$cod_ncm=$dados_item['ncm'];
						$tipo_item='99';

						if ($descr_item<>'') {
		  					$ok='';
							$tipo_tabela='NFCOMPLEMENTAR';
						}
				}

				if ( $tipo_item=='') {
					 $tipo_item='00';
				}

 
 

			     $cod_ant_item='';
			   

			     $tipi=_myfunc_espaco_a_direita($tipi,$tamanho3);
			     $cod_gen=$dados_item['cod_gen'];
			     $alqicms='0';  

			    $cod_lst=_apenas_numeros($cod_lst);
			  
			     //$alqicms= number_format($alqicms, 2, ',', '.');

			     $linha='|0200|'.$cod_item.'|'.$descr_item.'|'.$cod_barra.'|'.$cod_ant.'|'.$xunidade.'|'.$tipo_item.'|'.$cod_ncm.'|'.$tipi.'|'.$cod_gen.'|'.$cod_lst.'|'.$alqicms.'|';
			     
				   _matriz_linha($linha);

//				sped_efd_registro_0220($xunidade);
				   
			     

			  }

		   		  
        
}




//IDENTIFICAÇÃO DAS UNIDADES DE MEDIDA
function xsped_efd_pis_registro_0190(){
global $qtd_lin_0,$info_segmento,$fp,$REG_BLC,$TUNIDADE_FATOR_CONVERSAO,$TITEM_FLUXO,$CONTITEM_FLUXO,$info_cnpj_segmento,$lanperiodo1,$lanperiodo2;
 global  $fp,$livro_reg;
                global $TUNIDADE_FATOR_CONVERSAO,$TITEM_FLUXO,$CONTITEM_FLUXO,$TLANCAMENTOS,$perdtos1,$perdtos2,$info_cnpj_segmento;
           
 		$sel_itens=_myfunc_sql_receitas_despesas_itens('','') ;
                $selunidade = mysql_query("SELECT a.*,b.ucom FROM $TUNIDADE_FATOR_CONVERSAO as a,$livro_reg as b where a.unidad_conv=b.ucom group by b.ucom order by b.ucom ASC",$CONTITEM_FLUXO);


         while ( $punidade = mysql_fetch_assoc($selunidade) ) {
                         $linha='|0190|'.$punidade[ucom].'|'.$punidade[descricao].'|';
                       _matriz_linha($linha);
                 
		   $tot_registro_bloco=$tot_registro_bloco+1;
             

	  }
   		   $REG_BLC[]='|0190|'.$tot_registro_bloco.'|';
 		   $qtd_lin_0=$qtd_lin_0+  $tot_registro_bloco;

       return;
}


//TABELA DE IDENTIFICAÇÃO DO ITEM (PRODUTOS E SERVIÇOS)
function xsped_efd_pis_registro_0200() {
global $qtd_lin_0,$info_segmento,$fp,$REG_BLC,$lanperiodo1,$lanperiodo2,$TITEM_FLUXO,$TPRODUTOS,$CONTITEM_FLUXO,$TSERVICOS,$info_cnpj_segmento;
 
//Este registro tem por objetivo informar as mercadorias, serviços, produtos ou quaisquer outros itens concernentes às transações representativas de receitas e/ou geradoras de créditos
// O Código do Item deverá ser preenchido com as informações utilizadas na última ocorrência do período.
          
	  $filtro_periodo=" and (data >= $lanperiodo1 and data <= $lanperiodo2)";



         $xsql_itens="SELECT cprod,tipo_lancamento FROM $TITEM_FLUXO WHERE cnpjcpfseg='$info_cnpj_segmento'  $filtro_periodo group by cprod order by data desc";
 
	 
         $sel_itens=mysql_query("$xsql_itens",$CONTITEM_FLUXO) or die (mysql_error());
 


       while ( $itens = mysql_fetch_assoc($sel_itens) ) {

             $reg='0200';

             $cod_item=$itens['cprod'];
	     $ok='N';
             if ($itens[tipo_lancamento]=='SERVICOS') {
		$dados_item=_myfun_dados_servicos($cod_item);
		$cod_barra='';
	        $cod_ncm='';
                $tipi='';
		$cod_lst=$dados_item[cod_lst];
                $ok='';

             }
          
             if ($itens[tipo_lancamento]=='PRODUTOS') {
		$dados_item=_myfun_dados_produto($cod_item);
  		$cod_barra=$dados_item['cean'];
                $cod_ncm=$dados_item['ncm'];
                $tipi=$dados_item['cenqipi'];
	 	$cod_lst='';
                $ok='';


             }

if ($ok=='N') {  // nao achou em produto e servicos, busca em produtos despesas

		$dados_item=_myfun_dados_itens_despesas($cod_item);
		$cod_barra='';
	        $cod_ncm='';
                $tipi='';
		$cod_lst=$dados_item[cod_lst];
                $ok='';
}

$cod_lst=_apenas_numeros($cod_lst);

             $descr_item=$dados_item['descricao'];
             $unid_inv=$dados_item['unidade'];
             $tipo_item=$dados_item['tipoitem'];

             IF ($dados_item[conta]=='') {  // buscar veiculos
		 $dados_item=_myfunc_dados_motors_via_chassi($cod_item);
                 $descr_item=$dados_item['modelo'];
		 $tipi='';
		  $unid_inv='UN';
		 $tipo_item='00';
             }

	    IF ($dados_item[conta]=='') {  // buscar itens despesas
		 $dados_item=_myfun_dados_itens_despesas($cod_item);
                 $descr_item=$dados_item['descricao'];
                $cod_ncm=$dados_item['ncm'];
                $tipi='';
	 	$cod_lst='';
             }

IF ($dados_item[conta]=='') {  // buscar itens NF_COMPLEMENTAR
		 $dados_item=_myfun_dados_itens_nfcomplementar($cod_item);
                 $descr_item=$dados_item['descricao'];
                $cod_ncm=$dados_item['ncm'];
                $tipi='';
	 	$cod_lst='';
             }

if ( $tipo_item=='') {
	 $tipo_item='00';
}




             $cod_ant_item='';
           

             $tipi=_myfunc_espaco_a_direita($tipi,$tamanho3);
             $cod_gen=$dados_item['cod_gen'];
             $alqicms='';  

	    
          
             //$alqicms= number_format($alqicms, 2, ',', '.');

             $linha='|'.$reg.'|'.$cod_item.'|'.$descr_item.'|'.$cod_barra.'|'.$cod_ant.'|'.$unid_inv.'|'.$tipo_item.'|'.$cod_ncm.'|'.$tipi.'|'.$cod_gen.'|'.$cod_lst.'|'.$alqicms.'|';
             
		   _matriz_linha($linha);
		   $tot_registro_bloco=$tot_registro_bloco+1;
             

	  }
   		   $REG_BLC[]='|0200|'.$tot_registro_bloco.'|';
 		   $qtd_lin_0=$qtd_lin_0+  $tot_registro_bloco;
        
}



//ALTERAÇÃO DO ITEM
function sped_efd_pis_registro_0205(){
	global $qtd_lin_0,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC;

       $reg='0205';

       $descr_ant_item='';

       $dt_ini='';
       $dt_ini=_myfunc_stod($dt_ini);
       $dt_ini=_myfunc_ddmmaaaa($dt_ini);
       $tamanho8=8;
       $dt_ini=_myfunc_zero_a_esquerda($dt_ini,$tamanho8) ;

       $dt_fin='';
       $dt_fin=_myfunc_stod($dt_fin);
       $dt_fin=_myfunc_ddmmaaaa($dt_fin);
       $tamanho8=8;
       $dt_fin=_myfunc_zero_a_esquerda($dt_fin,$tamanho8) ;

       $cod_ant_item='';
       $tamanho60=60;
       $cod_ant_item=_myfunc_espaco_a_direita($cod_ant_item,$tamanho60);


	$linha='|'.$reg.'|'.$descr_ant_item.'|'.$dt_ini.'|'.$dt_fin.'|'.$cod_ant_item.'|';
         _matriz_linha($linha);
			   $tot_registro_bloco=1;
		           $REG_BLC[]='|0205|'.$tot_registro_bloco.'|';
	 		   $qtd_lin_0++;
      return;

}

//CÓDIGO DE PRODUTO CONFORME TABELA ANP (COMBUSTÍVEIS)
function sped_efd_pis_registro_0206(){
	global $qtd_lin_0,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC;

       $reg='0206';

       $cod_comb='';

       $linha='|'.$reg.'|'.$cod_comb.'|';
        _matriz_linha($linha);
			   $tot_registro_bloco=1;
		           $REG_BLC[]='|0206|'.$tot_registro_bloco.'|';
	 		   $qtd_lin_0++;
      return;

}




//CÓDIGO DE GRUPOS POR MARCA COMERCIAL  REFRI (BEBIDAS FRIAS).
function sped_efd_pis_registro_0208(){
	global  $qtd_lin_0,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC;

       $reg='0208';

       $cod_tab='';
       $tamanho2=2;
       $cod_tab=_myfunc_espaco_a_direita($cod_tab,$tamanho2);

       $cod_gru='';
       $tamanho2=2;
       $cod_gru=_myfunc_espaco_a_direita($cod_gru,$tamanho2);

       $marca_com='';
       $tamanho60=60;
       $marca_com=_myfunc_espaco_a_direita($marca_com,$tamanho60);


       $linha='|'.$reg.'|'.$cod_tab.'|'.$cod_gru.'|'.$marca_com.'|';
        _matriz_linha($linha);
			   $tot_registro_bloco=1;
		           $REG_BLC[]='|0208|'.$tot_registro_bloco.'|';
	 		   $qtd_lin_0++;
      return;
}

//TABELA DE NATUREZA DA OPERAÇÃO/PRESTAÇÃO
function sped_efd_pis_registro_0400() {
	global  $qtd_lin_0,$info_segmento,$fp,$REG_BLC,$TLANCAMENTOS,$TNATUREZAOPERACAO,$lanperiodo1,$lanperiodo2;

        $selunidade = mysql_query("select a.codnat,a.descricaonatureza,b.data,b.codnat from $TNATUREZAOPERACAO as a, $TLANCAMENTOS as b where a.codnat=b.codnat and b.data >= $lanperiodo1 and b.data <= $lanperiodo2  and b.lan_impostos<>'S' group by a.codnat");

       while ( $punidade = mysql_fetch_assoc($selunidade)) {

             $reg='0400';

             $cod_nat=$punidade['codnat'];
          

             $descr_nat=$punidade['descricaonatureza'];

             $linha='|'.$reg.'|'.$cod_nat.'|'.$descr_nat.'|';
              _matriz_linha($linha);
		   $tot_registro_bloco=$tot_registro_bloco+1;
             

	  }
   		   $REG_BLC[]='|0400|'.$tot_registro_bloco.'|';
 		   $qtd_lin_0=$qtd_lin_0+  $tot_registro_bloco;
       return;

       }

//TABELA DE INFORMAÇÃO COMPLEMENTAR DO DOCUMENTO FISCAL
function sped_efd_pis_registro_0450(){
        global $qtd_lin_0,$info_segmento,$fp,$REG_BLC,$TINFOCPL,$info_cnpj_segmento,$lanperiodo1,$lanperiodo2;

         $sql=mysql_query("SELECT * from $TINFOCPL");

          while ($v=mysql_fetch_assoc($sql)) {

                 $cod_inf=$v['id'];
            

                 $txt=$v['historico'];

                 $linha='|0450|'.$cod_inf.'|'.$txt.'|';
                
       		 _matriz_linha($linha);
		   $tot_registro_bloco=$tot_registro_bloco+1;
             

	  }
   		   $REG_BLC[]='|0450|'.$tot_registro_bloco.'|';
 		   $qtd_lin_0=$qtd_lin_0+  $tot_registro_bloco;
        return;
}



 //PLANO DE CONTAS CONTÁBEIS
function sped_efd_pis_registro_0500(){
global $qtd_lin_0,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$info_cnpj_segmento,$TPLANOCT,$TLANCAMENTOS,$REG_BLC,$conta;

       $sql_lancamentos= mysql_query("select DISTINCT a.*,b.contad,b.contac,b.data from $TPLANOCT as a, $TLANCAMENTOS as b where (a.conta=b.contad or a.conta=b.contac) and b.data >= $lanperiodo1  and b.data <= $lanperiodo2 group by a.conta order by a.conta ");


    while ($v=mysql_fetch_assoc($sql_lancamentos)) {

        $dt_alt=$v['dataatu'];
        $dt_alt=_myfunc_stod($dt_alt);
        $dt_alt=_myfunc_ddmmaaaa($dt_alt);
$dt_alt='31122011';
        $tamanho8=8;
        $dt_alt=_myfunc_zero_a_esquerda($dt_alt,$tamanho8) ;

         $conta=$v['conta'] ;
         if (strlen(_myfun_mascara_x($info_cnpj_segmento))==strlen($conta)) {
         $ind_cta='A';
         }
         else{
         $ind_cta='S';
         }

         if(strlen($conta)==_myfun_len_grau_n($info_cnpj_segmento,1)) {
         $nivel='1';
         $cod_cta=$conta;
         $cod_cta_sup='';
         $cod_nat_cc='01';
         }
         if(strlen($conta)==_myfun_len_grau_n($info_cnpj_segmento,2)){
         $nivel='2';
         $cod_cta=$conta;
         $cod_cta_sup=substr($conta,0,_myfun_len_grau_n($info_cnpj_segmento,1));
         $cod_nat_cc='02';
         }
         if(strlen($conta)==_myfun_len_grau_n($info_cnpj_segmento,3)) {
         $nivel='3';
         $cod_cta=$conta;
         $cod_cta_sup=substr($conta,0,_myfun_len_grau_n($info_cnpj_segmento,2));
         $cod_nat_cc='04';
         }
         if(strlen($conta)==_myfun_len_grau_n($info_cnpj_segmento,4)){
         $nivel='4';
         $cod_cta=$conta;
         $cod_cta_sup=substr($conta,0,_myfun_len_grau_n($info_cnpj_segmento,3));
         $cod_nat_cc='04';
         }
         if(strlen($conta)==_myfun_len_grau_n($info_cnpj_segmento,5)) {
         $nivel='5';
         $cod_cta=$conta;
         $cod_cta_sup=substr($conta,0,_myfun_len_grau_n($info_cnpj_segmento,4));
         $cod_nat_cc='05';
         }
         if(strlen($conta)==_myfun_len_grau_n($info_cnpj_segmento,6)){
         $nivel='6';
         $cod_cta=$conta;
         $cod_cta_sup=substr($conta,0,_myfun_len_grau_n($info_cnpj_segmento,4));
         $cod_nat_cc='09';
         }

         $tamanho5=5;
         $nivel=_myfunc_zero_a_esquerda($nivel,$tamanho5) ;

         $tamanho60=60;
         $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);

         $nome_cta=$v['descricao'];
         $tamanho60=60;
         $nome_cta=_myfunc_espaco_a_direita($nome_cta,$tamanho60);

         $cnpj_est=$info_cnpj_segmento;
         $tamanho14=14;
         $cnpj_est=_myfunc_zero_a_esquerda($cnpj_est,$tamanho14) ;

        $linha='|'.'0500'.'|'.$dt_alt.'|'.$cod_nat_cc.'|'.$ind_cta.'|'.$nivel.'|'.$cod_cta.'|'.$nome_cta.'|'.$cod_cta_sup.'|'.$cnpj_est.'|';
         _matriz_linha($linha);
		   $tot_registro_bloco=$tot_registro_bloco+1;
             

	  }
   		   $REG_BLC[]='|0500|'.$tot_registro_bloco.'|';
 		   $qtd_lin_0=$qtd_lin_0+  $tot_registro_bloco;
        return;
}

//CENTRO DE CUSTOS
function sped_efd_pis_registro_0600(){
global $qtd_lin_0,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$info_cnpj_segmento,$TCENTROCUSTO,$TLANCAMENTOS,$REG_BLC;

       $sql_lancamentos= mysql_query("SELECT *,b.centrocusto,b.data FROM $TCENTROCUSTO as a,$TLANCAMENTOS as b where a.descricao=b.centrocusto and b.data >= $lanperiodo1  and b.data <= $lanperiodo2 ");

    while ($v=mysql_fetch_assoc($sql_lancamentos)) {

        $dt_alt=$v['dataatu'];
        $dt_alt=_myfunc_stod($dt_alt);
        $dt_alt=_myfunc_ddmmaaaa($dt_alt);
        $tamanho8=8;
        $dt_alt=_myfunc_zero_a_esquerda($dt_alt,$tamanho8) ;


        $cod_ccus=$v['conta'];
        $tamanho60=60;
        $cod_ccus=_myfunc_zero_a_esquerda($cod_ccus,$tamanho60) ;

        $ccus=$v['descricao'];
        $tamanho60=60;
        $ccus=_myfunc_zero_a_esquerda($ccus,$tamanho60) ;

        $linha='|'.'0600'.'|'.$dt_alt.'|'.$cod_ccus.'|'.$ccus.'|';
     
         _matriz_linha($linha);
		   $tot_registro_bloco=$tot_registro_bloco+1;
             

	  }
   		   $REG_BLC[]='|0600|'.$tot_registro_bloco.'|';
 		   $qtd_lin_0=$qtd_lin_0+  $tot_registro_bloco;
          return;


}
//ENCERAMENTO DO BLOCO 0
 
 

function sped_efd_pis_registro_0990() {
                     global $info_segmento,$fp,$qtde_linha_bloco_0,$qtde_linha_bloco_c,$REG_BLC;
                     $qtde_linha_bloco=_myfunc_qtde_registro_matriz_linha_sped('0') + 1;
                     $linha='|0990|'.$qtde_linha_bloco.'|';
		     _matriz_linha($linha);


			flush();

 
                     return;
}

 





//**** INICIO BLOCO A  *****************

 

sped_efd_pis_registro_A001(); //ABERTURA DO BLOCO A
sped_efd_pis_registro_A010(); //IDENTIFICAÇÃO DO ESTABELECIMENTO
sped_efd_pis_registro_A100(); //DOCUMENTO - NOTA FISCAL DE SERVIÇO
//sped_efd_pis_registro_A110(); //COMPLEMENTO DO DOCUMENTO - INFORMAÇÃO COMPLEMENTAR DA NF
//sped_efd_pis_registro_A111(); //PROCESSO REFERENCIADO
//sped_efd_pis_registro_A120(); //INFORMAÇÃO COMPLEMENTAR - OPERAÇÃODE IMPORTAÇÃO
//sped_efd_pis_registro_A170(); //COMPLEMENTO DO DOCUMENTO - ITENS DO DOCUMENTO
sped_efd_pis_registro_A990(); //ENCERRAMENTO DO BLOCO A

ECHO "BLOCO A - OK <BR>";
flush();

//ABERTURA DO BLOCO A
function sped_efd_pis_registro_A001(){
global $qtd_lin_A,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC ;

   $reg='A001';
   
   $ind_mov='0'; //0 - com dados e 1 - sem dados.

   $linha='|'.$reg.'|'.$ind_mov.'|';
    _matriz_linha($linha);
        
          $tot_registro_bloco++;
          $REG_BLC[]='|A001|'.$tot_registro_bloco.'|';
	   $qtd_lin_A=$tot_registro_bloco;;
          return ;
   return;
}
//IDENTIFICAÇÃO DO ESTABELECIMENTO
function sped_efd_pis_registro_A010(){
global $qtd_lin_A,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC ;

   $reg='A010';

   $cnpj=$info_segmento['cnpjcpf'];
   $tamanho14=14;
   $cnpj=_myfunc_zero_a_esquerda($cnpj,$tamanho14) ;

   $linha='|'.$reg.'|'.$cnpj.'|';
     _matriz_linha($linha);
        
          $tot_registro_bloco++;
          $REG_BLC[]='|A010|'.$tot_registro_bloco.'|';
	   $qtd_lin_A=$qtd_lin_A+$tot_registro_bloco;
          return ;
   
}

//DOCUMENTO - NOTA FISCAL DE SERVIÇO
function sped_efd_pis_registro_A100(){
global $info_cnpj_segmento,$qtd_lin_A,$tot_registro_bloco_A110,$tot_registro_bloco_A170,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$TLANCAMENTOS,$TNFDOCUMENTOS,$TITEM_FLUXO;
global $TNFDOCUMENTOS_TMP,$TNFDOCUMENTOS,$CONTNFDOCUMENTOS;

$filtro_item_fluxo=" and vissqn>0 ";

    $sql_lancamentos= _myfunc_sql_receitas_despesas_documentos('','',"$filtro_item_fluxo".''.'');
//mysql_query("SELECT a.*,b.dono,b.gerar_id,c.dono,sum(c.vdesc) as vdesc,sum(c.vbc_pis) as vbc_pis,sum(c.vpis) as vpis,sum(c.vbc_cofins) as vbc_cofins,sum(c.vcofins) as vcofins,sum(c.vissqn) as vissqn FROM $TLANCAMENTOS as a,$TNFDOCUMENTOS as b,$TITEM_FLUXO as c where (a.modelo='03' or a.modelo='3A' or a.modelo='3B') and a.data BETWEEN $lanperiodo1 AND $lanperiodo2 and a.dono=b.dono and a.dono=c.dono group by c.dono");

    while ($v=mysql_fetch_assoc($sql_lancamentos)) {

 
	    $dono=$v[dono];
	    include('documentos_situacao_erp.php');
	    $reg='A100';
	    if ($v[movimento]=='RECEITAS') { //0 - Serviços Contratados pelo Estabelecimento, 1 - Serviços Prestação pelo Estabelecimento
		$ind_oper='1';
		 $ind_emit='0'; //0 - Emissão Própria, 1 - Emissão de Terceiros
            }ELSE{
		$ind_oper='0';
		 $ind_emit='1';
	    }

	 
	    $cod_part=$v[cnpjcpf];
//   BASICO::AVISO($info_nfdocumentos[tipodocumento].' '.$info_nfdocumentos[numero].' '.$info_nfdocumentos[serie].' NF-e já esta cancelada na base de dados da SEFAZ!');
           
				 //  00 Documento regular  01 Documento regular extemporâneo  02 Documento cancelado 03 Documento cancelado extemporâneo  04 NF-e ou CT-e denegado  05 NF-e ou CT-e  Numeração inutilizada   06 Documento Fiscal Complementar  07 Documento Fiscal Complementar extemporâneo.    08 Documento Fiscal emitido com base em Regime Especial ou Norma Específica
                                                
            $cod_sit=(empty($v[cod_sit]))  ? '00' : $v[cod_sit];  // se for receitas ,emissão propria
         
	    $ser=$info_nfdocumentos[serie];
	   
	    $sub='';
	 
	    $num_doc=$info_nfdocumentos[numero];
	 
	    $chv_nfse=$info_nfdocumentos['gerar_id'];
  	    $dt_doc=$info_nfdocumentos[data];
	    $dt_doc=_myfunc_stod($dt_doc);
	    $dt_doc=_myfunc_ddmmaaaa($dt_doc);

	    $dt_exe_serv= $dt_doc;
	   
 	    $vl_doc=($v[svprod]+$v[svfrete]+$v[svseg]+$v[svicmsst]+$v[svipi]+$v[svoutro])-$v[svdesc];
	  
	    $vl_doc=number_format($vl_doc, 2, ',', '');



	   
   
		$ind_pgto='1'; // A prazo, 9 é igual a outros
		if($v[data]==$v[pagamento]){
			$ind_pgto='0'; // A vista
		}

	    $vl_desc=$v['svdesc'];
	    $vl_desc=number_format($vl_desc, 2, ',', '');

	    $vl_bc_pis=$v['svbc_pis'];
	    $vl_bc_pis=number_format($vl_bc_pis, 2, ',', '');

	    $vl_pis=$v['svpis'];
	    $vl_pis=number_format($vl_pis, 2, ',', '');

	    $vl_bc_cofins=$v['svbc_cofins'];
	    $vl_bc_cofins=number_format($vl_bc_cofins, 2, ',', '');

	    $vl_cofins=$v['svcofins'];
	    $vl_cofins=number_format($vl_cofins, 2, ',', '');

	    $vl_pis_ret='';
	    //$vl_pis_ret=number_format($vl_pis_ret, 2, ',', '');

	    $vl_cofins_ret='';
	    //$vl_cofins_ret=number_format($vl_cofins_ret, 2, ',', '');

	    $vl_iss=$v['svissqn'];
	    $vl_iss=number_format($vl_iss, 2, ',', '');

	   $linha='|'.$reg.'|'.$ind_oper.'|'.$ind_emit.'|'.$cod_part.'|'.$cod_sit.'|'.$ser.'|'.$sub.'|'
	   .$num_doc.'|'.$chv_nfse.'|'.$dt_doc.'|'.$dt_exe_serv.'|'.$vl_doc.'|'.$ind_pgto.'|'.$vl_desc.
	   '|'.$vl_bc_pis.'|'.$vl_pis.'|'.$vl_bc_cofins.'|'.$vl_cofins.'|'.$vl_pis_ret.'|'.$vl_cofins_ret.
	   '|'.$vl_iss.'|';

	$qtd_lin_A++;
	  _matriz_linha($linha);
	   $tot_registro_bloco++;


                                    //c110  filho
                                    //REGISTRO C110: INFORMAÇÃO COMPLEMENTAR DA NOTA FISCAL (CÓDIGO 01, 1B, 04 e 55).
                                    // Para código 55 (NFe) Informar apenas de emissão de terceiros
                                    if ($info_nfdocumentos[modelo]=='55' and $ind_emit=='0'){
					//sped_efd_pis_registro_A110(); //COMPLEMENTO DO DOCUMENTO - INFORMAÇÃO COMPLEMENTAR DA NF
                                    }
		 
		// sped_efd_pis_registro_A111(); //PROCESSO REFERENCIADO
	//	sped_efd_pis_registro_A120(); //INFORMAÇÃO COMPLEMENTAR - OPERAÇÃODE IMPORTAÇÃO
		sped_efd_pis_registro_A170("$dono"); //COMPLEMENTO DO DOCUMENTO - ITENS DO DOCUMENTO


}
     $REG_BLC[]='|A100|'.$tot_registro_bloco.'|';

 
          $REG_BLC[]='|A170|'.$tot_registro_bloco_A170.'|';

 		 
    
}
//COMPLEMENTO DO DOCUMENTO - INFORMAÇÃO COMPLEMENTAR DA NF
function sped_efd_pis_registro_A110(){
global $qtd_lin_A,$tot_registro_bloco_A110,$info_segmento,$fp,$TINFOCPL,$TITEM_FLUXO,$info_cnpj_segmento,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS,$REG_BLC;

       $sql=mysql_query("SELECT a.codigo_infcpl,a.data,a.dono,b.id,b.historico,c.dono,c.modelo FROM $TITEM_FLUXO as a, $TINFOCPL as b,$TLANCAMENTOS as c where ((a.data >= $lanperiodo1) and (a.data <= $lanperiodo2)) and a.codigo_infcpl=b.id and a.dono=c.dono and (c.modelo='03' or c.modelo='3A' or c.modelo='3B') group by b.id");

          while ($v=mysql_fetch_assoc($sql)) {

                 $cod_inf=$v['id'];

                 $txt_compl=$v['historico'];
                 $tamanho6=6;
                 $txt_compl=_myfunc_espaco_a_direita($txt_compl,$tamanho6);

                 $linha='|A110|'.$cod_inf.'|'.$txt.'|';
                 _matriz_linha($linha);
        
                 $tot_registro_bloco++;
		$tot_registro_bloco_A110++;
 
}
 $qtd_lin_A=$qtd_lin_A+$tot_registro_bloco;

          
          return ;
    
 
}

//PROCESSO REFERENCIADO
function sped_efd_pis_registro_A111(){
global $qtd_lin_A,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC;

   $reg='A111';

   $num_proc='';
   $tamanho15=15;
   $num_proc=_myfunc_espaco_a_direita($num_proc,$tamanho15);

   $ind_proc='';

   $linha='|'.$reg.'|'.$num_proc.'|'.$ind_proc.'|';
   
   $linha='|'.$reg.'|'.$cnpj.'|';
     _matriz_linha($linha);
        
          $tot_registro_bloco++;
          $REG_BLC[]='|A111|'.$tot_registro_bloco.'|';
	 //  $qtd_lin_A=$qtd_lin_A+$tot_registro_bloco;
          return ;
}
//INFORMAÇÃO COMPLEMENTAR - OPERAÇÃODE IMPORTAÇÃO
function sped_efd_pis_registro_A120(){
global $qtd_lin_A,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC;

   $reg='A120';

   $vl_tot_serv='';
   //$vl_tot_serv=number_format($vl_tot_serv, 2, ',', '');

   $vl_bc_pis='';
   //$vl_bc_pis=number_format($vl_bc_pis, 2, ',', '');

   $vl_pis_imp='';
   //$vl_pis_imp=number_format($vl_pis_imp, 2, ',', '');

   $dt_pag_pis='';
   //$dt_pag_pis=_myfunc_stod($dt_pag_pis);
   //$dt_pag_pis=_myfunc_ddmmaaaa($dt_pag_pis);

   $vl_bc_cofins='';
   //$vl_bc_cofins=number_format($vl_bc_cofins, 2, ',', '');

   $vl_cofins_imp='';
   //$vl_cofins_imp=number_format($vl_cofins_imp, 2, ',', '');

   $dt_pag_cofins='';
   //$dt_pag_cofins=_myfunc_stod($dt_pag_cofins);
   //$dt_pag_cofins=_myfunc_ddmmaaaa($dt_pag_cofins);

   $loc_exe_serv='';

   $linha='|'.$reg.'|'.$vl_tot_serv.'|'.$vl_bc_pis.'|'.$vl_pis_imp.'|'.$dt_pag_pis.'|'. $vl_bc_cofins.'|'.$vl_cofins_imp.'|'.$dt_pag_cofins.'|'.$loc_exe_serv.'|';

   $linha='|'.$reg.'|'.$cnpj.'|';
     _matriz_linha($linha);
        
          $tot_registro_bloco++;
          $REG_BLC[]='|A120|'.$tot_registro_bloco.'|';
	//   $qtd_lin_A=$qtd_lin_A+$tot_registro_bloco;
          return ;

}

//COMPLEMENTO DO DOCUMENTO - ITENS DO DOCUMENTO
function sped_efd_pis_registro_A170($xdono){
global $qtd_lin_A,$tot_registro_bloco_A170,$info_segmento,$fp,$REG_BLC,$TITEM_FLUXO,$CONTITEM_FLUXO,$TPRODUTOS,$TSERVICOS,$info_cnpj_segmento,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS;

//       $xsql_d="SELECT a.*,b.codnat,b.data,b.modelo FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b where a.dono=b.dono and b.contad<>'' and a.cnpjcpfseg='$info_cnpj_segmento' and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and (b.modelo='03' or b.modelo='3A' or b.modelo='3B') order by a.dono,a.id";
 $xsql_d=_myfunc_sql_receitas_despesas_itens('',$xdono);

      // $selunidade_d = mysql_query("$xsql_d",$CONTITEM_FLUXO);
       $ordem_documento_emitido=0;
       $xdono='######';
 
           while ( $punidade_d = mysql_fetch_assoc($xsql_d)) {
                 if ($xdono<>$punidade_d['dono']) {
                     $ordem_documento_emitido=0;
                     $xdono=$punidade_d['dono'];
		     $num_item=0;
                 }
                 $num_item=$num_item+1;

 
                      $cod_item=$punidade_d['cprod'];
                  
                 $descr_compl=$punidade_d['xprod'];
 
                 $vl_item=_myfunc_valor_base_pis_cofins($punidade_d);
//$punidade_d['vprod'];
                 $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

                 $vl_desc=$punidade_d['vdesc'];
                 $vl_desc=number_format(abs($vl_desc), 2, ",", "")  ;

                 $nat_bc_cred='13'; //  ??????

/*
01 Aquisição de bens para revenda
02 Aquisição de bens utilizados como insumo
04 Energia elétrica utilizada nos estabelecimentos da pessoa jurídica
13 Outras operações com direito a crédito
*/
 
$ind_orig_cred='0';

                 $cst_pis=$punidade_d['cst_pis'];
             
                  $vl_bc_pis=$punidade_d['vbc_pis'];
                  $vl_bc_pis=number_format(abs($vl_bc_pis), 2, ",", "")  ;

                  $aliq_pis=$punidade_d['ppis'];
                  $aliq_pis=number_format(abs($aliq_pis), 2, ",", "")  ;

                  $vl_pis=$punidade_d['vpis'];
                  $vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;

                  $cst_cofins=$punidade_d['cst_cofins'];
                

                  $vl_bc_cofins=$punidade_d['vbc_cofins'];
                  $vl_bc_cofins=number_format(abs($vl_bc_cofins), 2, ",", "")  ;

                  $aliq_cofins=$punidade_d['pcofins'];
                      $aliq_cofins=number_format(abs($aliq_cofins), 2, ",", "")  ;

                  $vl_cofins=$punidade_d['vcofins'];
                  $vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;

                  $cod_cta='';
                  
                  $cod_ccus='';
              

   $linha='|A170|'.$num_item.'|'.$cod_item.'|'.$descr_compl.'|'.$vl_item.'|'.$vl_desc.'|'.$nat_bc_cred.'|'.$ind_orig_cred.'|'.$cst_pis.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$vl_pis.'|'.$cst_cofins.'|'.$vl_bc_cofins.'|'.$aliq_cofins.'|'.$vl_cofins.'|'.$cod_cta.'|'.$cod_ccus.'|';

                 _matriz_linha($linha);
        
                 $tot_registro_bloco++;
}
          
	   $qtd_lin_A=$qtd_lin_A+$tot_registro_bloco;
$tot_registro_bloco_A170++;
          return ;
    
 
}
 

//ENCERRAMENTO DO BLOCO A
function sped_efd_pis_registro_A990(){
global $qtd_lin_A,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC;
     
   
 

  $reg='A990';
          $qtd_lin_A ++ ;
          $linha='|'.$reg.'|'. $qtd_lin_A.'|';
         
          _matriz_linha($linha);
        
          $tot_registro_bloco=$tot_registro_bloco+1;
          $REG_BLC[]='|A990|'.$tot_registro_bloco .'|';
          return ;
 
 

 

}






//**** INICIO BLOCO C  *****************

 
 

sped_efd_pis_registro_C001(); //ABERTURA DO BLOCO C
sped_efd_pis_registro_C010(); //IDENTIFICAÇÃO DO ESTABELECIMENTO
sped_efd_pis_registro_C100(); //DOCUMENTO - NOTA FISCAL(CÓDIGO 01),NOTA FISCAL AVULSA(CÓDIGO 1B), NOTA FISCAL DE PRODUTOR(CÓDIGO 04) E NFE(CÓDIGO 55)
/*
sped_efd_pis_registro_C110(); //COMPLEMENTO DO DOCUMENTO - INFORMAÇÃO COMPLEMENTAR DA NOTA FISCAL (CÓDIGO 01,1B,04 E 55)
sped_efd_pis_registro_C111(); //PROCESSO REFERENCIADO
sped_efd_pis_registro_C120(); //COMPLEMENTO DO DOCUMENTO - OPERAÇÕES DE IMPORTAÇÃO(CÓDIGO 01)
sped_efd_pis_registro_C170(); //COMPLEMENTO DO DOCUMENTO - ITENS DO DOCUMENTO (CÓDIGO 01,1B,04 E 55)
sped_efd_pis_registro_C180(); //CONSOLIDAÇÃO DE NOTAS FISCAIS ELETRÔNICAS EMITIDAS PELA PESSOA JURÍDICA(CODIGO 55) - OPERAÇÃO DE VENDAS
sped_efd_pis_registro_C181(); //DETALHAMENTO DA CONSOLIDAÇÃO - OPERAÇÃO DE VENDAS - PIS/PASEP
sped_efd_pis_registro_C185(); //DETALHAMENTO DA CONSOLIDAÇÃO - OPERAÇÃO DE VENDAS - COFINS
sped_efd_pis_registro_C188(); //PROCESSO REFERENCIADO
sped_efd_pis_registro_C190(); //CONSOLIDAÇÃO DE NOTAS FISCAIS ELETRÔNICAS (CÓDIGO 55) - OPERAÇÃO DE AQUISIÇÃO COM DIREITO A CRÉDITO, E OPERAÇÃO DE DEVOLUÇÃO DE COMPRAS E VENDAS.
//sped_efd_pis_registro_C191(); //DETALHAMENTO DA CONSOLIDAÇÃO - OPERAÇÃO DE AQUISIÇÃO COM DIREITO A CRÉDITO, E OPERAÇÃO DE DEVOLUÇÃO DE COMPRAS E VENDAS - PIS/PASEP
//sped_efd_pis_registro_C195(); //DETALHAMENTO DA CONSOLIDAÇÃO - OPERAÇÃO DE AQUISIÇÃO COM DIREITO A CRÉDITO, E OPERAÇÃO DE DEVOLUÇÃO DE COMPRAS E VENDAS - COFINS
//sped_efd_pis_registro_C198(); //PROCESSO REFERENCIADO
//sped_efd_pis_registro_C199(); //COMPLEMENTO DO DOCUMENTO - OPERAÇÃO DE IMPORTAÇÃO (CODIGO 55)
sped_efd_pis_registro_C380(); //NOTA FISCAL DE VENDA A CONSUMIDOR (CODIGO 02) - CONCOLIDAÇÃO DE DOCUMENTOS EMITIDOS
sped_efd_pis_registro_C381(); //DETALHAMENTO DA CONSOLIDAÇÃO - PIS/PASEP
sped_efd_pis_registro_C385(); //DETALHAMENTO DA CONSOLIDAÇÃO - COFINS
sped_efd_pis_registro_C395(); //NOTAS FISCAIS DE VENDA A CONSUMIDOR (CÓDIGO 02,2D,2E E 59) - AQUISIÇÃO/ENTRADA COM CRÉDITO
sped_efd_pis_registro_C396(); //ITENS DO DOCUMENTO (CÓDIGO 02,2D,2E e 59) - AQUISIÇÃO/ENTRADAS COM CRÉDITO
*/
sped_efd_pis_registro_C400(); //EQUIPAMENTO ECF (CÓDIGOS 02 E 2D)
/*
sped_efd_pis_registro_C405(); //REDUÇÃO Z (CÓDIGOS 02 E 2D)
sped_efd_pis_registro_C481(); //RESUMO DIÁRIO DE DOCUMENTOS EMITIDOS POR ECF - PIS/PASEP (CÓDIGO 02 E 2D)
sped_efd_pis_registro_C485(); //RESUMO DIÁRIO DE DOCUMENTOS EMITIDOS POR ECF - COFINS (CÓDIGO 02 E 2D)
sped_efd_pis_registro_C489(); //PROCESSO REFERENCIADO
sped_efd_pis_registro_C490(); //CONSOLIDAÇÃO DE DOCUMENTOS EMITIDOS POR ECF - (CÓDIGO 02,2D E 59)
sped_efd_pis_registro_C491(); //DETALHAMENTO DA CONSOLIDAÇÃO DE DOCUMENTOS EMITIDOS POR ECF (CÓDIGO 02,2D E 59) - PIS/PASEP
sped_efd_pis_registro_C495(); //DETALHAMENTO DA CONSOLIDAÇÃO DE DOCUMENTOS EMITIDOS POR ECF (CÓDIGO 02,2D E 59)
sped_efd_pis_registro_C499(); //PROCESSO REFERENCIADO
*/
sped_efd_pis_registro_C500(); //NOTA FISCAL/CONTA DE ENERGIA ELÉTRICA (CÓDIGO 06),NOTA FISCAL/CONTA DE FORNECIMENTO D'ÁGUA CANALIZADA (CÓSIGO 29) E NOTA FISCAL CONSUMO FORNECIMENTO DE GÁS (CÓDIGO 28) - DOCUMENTOS DE ENTRADA/AQUISIÇÃO COM CRÉDITO
/*
//sped_efd_pis_registro_C501(); //COMPLEMENTO DA OPERAÇÃO (CÓDIGO 06,28 E 29) - PIS/PASEP
//sped_efd_pis_registro_C505(); //COMPLEMENTO DA OPERAÇÃO (CÓDIGO 06,28 E 29) - COFINS
//sped_efd_pis_registro_C509(); //PROCESSO REFERENCIADO

sped_efd_pis_registro_C600(); //CONSOLIDAÇÃO DIÁRIA DE NOTAS FISCAIS/CONTAS EMITIDAS DE ENERGIA ELÉTRICA (CÓDIGO 06), NOTA FISCAL/CONTA DE FORNECIMENTO D'ÁGUA CANALIZADA (CÓDIGO 29) E NOTA FISCAL/CONTA DE FORNECIMENTO DE GÁS (CÓDIGO 28)(EMPRESAS OBRIGADAS OU NÃO OBRIGADAS AO CONVENIO ICMS 155/03) - DOCUMENTO DE SAÍDA      APENAS PARA EMPRESAS QUE VENDEM ENERGIA , AGUA E GÁS

//sped_efd_pis_registro_C601(); //COMPLEMENTO DA CONSOLIDAÇÃO DIÁRIA (CÓDIGOS 06,28 E 29) - DOCUMENTOS DE SAÍDAS - PIS/PASEP
//sped_efd_pis_registro_C605(); //COMPLEMENTO DA CONSOLIDAÇÃO DIÁRIA (CÓDIGOS 06,28 E 29) - DOCUMENTOS DE SAÍDAS - COFINS
//sped_efd_pis_registro_C609(); //PROCESSO REFERENCIADO

*/
sped_efd_pis_registro_C990(); //ENCERRAMENTO DO BLOCO C


ECHO "BLOCO C - OK <BR>";
flush();

 
   
  
 
//ABERTURA DO BLOCO C
function sped_efd_pis_registro_C001(){
global $qtd_lin_C,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC;

   $reg='C001';
   
   $ind_mov='0'; //0 - com dados e 1 - sem dados.

   $linha='|'.$reg.'|'.$ind_mov.'|';

$qtd_lin_C++; 
                 _matriz_linha($linha);
        
                 $tot_registro_bloco++;

          $REG_BLC[]='|C001|'.$tot_registro_bloco.'|';
	   $qtd_lin_C=$qtd_lin_C+$tot_registro_bloco;
          return ;

 
}

//IDENTIFICAÇÃO DO ESTABELECIMENTO
function sped_efd_pis_registro_C010(){
global $qtd_lin_C,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C010;

   $reg='C010';

   $cnpj=$info_segmento['cnpjcpf'];
   $tamanho14=14;
   $cnpj=_myfunc_zero_a_esquerda($cnpj,$tamanho14) ;

   $ind_escri='2'; //1 - Relação NF-e(C180 e C190) e ECF(C490) 2 - Relação NF-e(	 e C170) e ECF(C400)

   $linha='|'.$reg.'|'.$cnpj.'|'.$ind_escri.'|';

                 _matriz_linha($linha);
        
                 $tot_registro_bloco++;
 
          $REG_BLC[]='|C010|'.$tot_registro_bloco.'|';
	   $qtd_lin_C=$qtd_lin_C+$tot_registro_bloco;
   return;
}

//DOCUMENTO - NOTA FISCAL(CÓDIGO 01),NOTA FISCAL AVULSA(CÓDIGO 1B), NOTA FISCAL DE PRODUTOR(CÓDIGO 04) E NFE(CÓDIGO 55)
function sped_efd_pis_registro_C100(){
	global $qtd_lin_C,$tot_registro_bloco_C170,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$TLANCAMENTOS,$TNFDOCUMENTOS,$TITEM_FLUXO;
	global $TNFDOCUMENTOS_TMP,$TNFDOCUMENTOS,$CONTNFDOCUMENTOS,$info_cnpj_segmento;
;
	$filtro_lancamentos=" and POSITION(modelo IN ':01:1B:04:55:') > 0";
	$filtro_item_fluxo=" and vpis>0 ";
        $sql_lancamentos= _myfunc_sql_receitas_despesas_documentos('',"$filtro_lancamentos",'','','');
 
    while ($v=mysql_fetch_assoc($sql_lancamentos)) {

 
	    $dono=$v[dono];
	    include('documentos_situacao_erp.php');
 
  

    $reg='C100';

    $movimento=$v['movimento'];

    if($movimento=='DESPESAS'){
       $ind_oper='0'; //ENTRADA
	 $ind_emit='1'; //0 - Emissão terceiros
    }else{
       $ind_oper='1'; //SAÍDA
       $ind_emit='0'; //0 - Emissão própria e 1 - Terceiros
    }

    IF (($info_cnpj_segmento==$v[cnpjcpf]) and $movimento=='DESPESAS') {
        $ind_emit='0'; //0 - Emissão própria   devolucao
    }

  $cod_part=$v[cnpjcpf];

    $cod_mod=$v['modelo'];
  
          $cod_sit=(empty($v[cod_sit]))  ? '00' : $v[cod_sit];  // se for receitas ,emissão propria
         
	    $ser=$info_nfdocumentos[serie];
	   
	    $sub='';
	 
	    $num_doc=$info_nfdocumentos[numero];

	  
	 
	    $chv_nfe=$info_nfdocumentos['gerar_id'];
  	    $dt_doc=$info_nfdocumentos[data];
	    $dt_doc=_myfunc_stod($dt_doc);
	    $dt_doc=_myfunc_ddmmaaaa($dt_doc);

	    $dt_e_s= $dt_doc;
	   
 	    $vl_doc=($v[svprod]+$v[svfrete]+$v[svseg]+$v[svicmsst]+$v[svipi]+$v[svoutro])-$v[svdesc];
	  
	 

	   
	       $ind_pgto='1';

 $vl_desc=$v['svdesc'];
	    $vl_desc=number_format($vl_desc, 2, ',', '');

	    $vl_bc_pis=$v['svbc_pis'];
	    $vl_bc_pis=number_format($vl_bc_pis, 2, ',', '');

	    $vl_pis=$v['svpis'];
	    $vl_pis=number_format($vl_pis, 2, ',', '');

	    $vl_bc_cofins=$v['svbc_cofins'];
	    $vl_bc_cofins=number_format($vl_bc_cofins, 2, ',', '');

	    $vl_cofins=$v['svcofins'];
	    $vl_cofins=number_format($vl_cofins, 2, ',', '');

	    $vl_pis_ret='';
	    //$vl_pis_ret=number_format($vl_pis_ret, 2, ',', '');

	    $vl_cofins_ret='';
	    //$vl_cofins_ret=number_format($vl_cofins_ret, 2, ',', '');

	    $vl_iss=$v['svissqn'];
	    $vl_iss=number_format($vl_iss, 2, ',', '');
 
 
    $vl_abat_nt='0.00';
    $vl_abat_nt=number_format($vl_abat_nt, 2, ',', '');

    $vl_merc=$v['svprod'];

   $vl_merc=$vl_doc;
    $vl_merc=number_format($vl_merc, 2, ',', '');

    $vl_frt=$v['svfrete'];
 
       $ind_frt=$info_nfdocumentos[modfrete];
if ($ind_frt=='') {
$ind_frt='9';
}

    $vl_frt=number_format($vl_frt, 2, ',', '');

    $vl_seg=$v['svseg'];
    $vl_seg=number_format($vl_seg, 2, ',', '');

    $vl_out_da=$v['svoutro'];
    $vl_out_da=number_format($vl_out_da, 2, ',', '');

    $vl_bc_icms=$v['svbc'];
    $vl_bc_icms=number_format($vl_bc_icms, 2, ',', '');

    $vl_icms=$v['svicms'];
    $vl_icms=number_format($vl_icms, 2, ',', '');

    $vl_bc_icms_st='';
    //$vl_bc_icms_st=number_format($vl_bc_icms_st, 2, ',', '');

    $vl_icms_st=$v['svicmsst'];
    $vl_icms_st=number_format($vl_icms_st, 2, ',', '');

    $vl_ipi=$v['vipi'];
    $vl_ipi=number_format($vl_ipi, 2, ',', '');

    $vl_pis=$v['svpis'];
    $vl_pis=number_format($vl_pis, 2, ',', '');

    $vl_cofins=$v['svcofins'];
    $vl_cofins=number_format($vl_cofins, 2, ',', '');

    $vl_pis_st=$v['svpisst'];
    $vl_pis_st=number_format($vl_pis_st, 2, ',', '');

    $vl_cofins_st='';
    //$vl_cofins_st=number_format($vl_cofins_st, 2, ',', '');
   $vl_doc=number_format($vl_doc, 2, ',', '');

    $linha='|'.$reg.'|'.$ind_oper.'|'.$ind_emit.'|'.$cod_part.'|'.$cod_mod.'|'.$cod_sit.'|'.$ser.'|'
   .$num_doc.'|'.$chv_nfe.'|'.$dt_doc.'|'.$dt_e_s.'|'.$vl_doc.'|'.$ind_pgto.'|'.$vl_desc.
   '|'.$vl_abat_nt.'|'.$vl_merc.'|'.$ind_frt.'|'.$vl_frt.'|'.$vl_seg.'|'.$vl_out_da.
   '|'.$vl_bc_icms.'|'.$vl_icms.'|'.$vl_bc_icms_st.'|'.$vl_icms_st.'|'.$vl_ipi.'|'
   .$vl_pis.'|'.$vl_cofins.'|'.$vl_pis_st.'|'.$vl_cofins_st.'|';

$qtd_lin_C++;
	  _matriz_linha($linha);
	   $tot_registro_bloco++;


                                    //c110  filho
                                    //REGISTRO C110: INFORMAÇÃO COMPLEMENTAR DA NOTA FISCAL (CÓDIGO 01, 1B, 04 e 55).
                                    // Para código 55 (NFe) Informar apenas de emissão de terceiros
                                    if ($info_nfdocumentos[modelo]=='55' and $ind_emit=='0'){
					//sped_efd_pis_registro_C110(); //COMPLEMENTO DO DOCUMENTO - INFORMAÇÃO COMPLEMENTAR DA NF
                                    }
		 
		// sped_efd_pis_registro_A111(); //PROCESSO REFERENCIADO
	//	sped_efd_pis_registro_A120(); //INFORMAÇÃO COMPLEMENTAR - OPERAÇÃODE IMPORTAÇÃO
		sped_efd_pis_registro_C170("$dono"); //COMPLEMENTO DO DOCUMENTO - ITENS DO DOCUMENTO


}
          $REG_BLC[]='|C100|'.$tot_registro_bloco.'|';
	//   $qtd_lin_C=$qtd_lin_C+$tot_registro_bloco;

 
          $REG_BLC[]='|C170|'.$tot_registro_bloco_C170.'|';
	//   $qtd_lin_C=$qtd_lin_C+$tot_registro_bloco_C170;
          return ;

}

//COMPLEMENTO DO DOCUMENTO - INFORMAÇÃO COMPLEMENTAR DA NOTA FISCAL (CÓDIGO 01,1B,04 E 55)
function sped_efd_pis_registro_C110(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C110,$TITEM_FLUXO,$TINFOCPL,$TLANCAMENTOS;

   $sql=mysql_query("SELECT a.codigo_infcpl,a.data,a.dono,b.id,b.historico,c.dono,c.modelo FROM $TITEM_FLUXO as a, $TINFOCPL as b,$TLANCAMENTOS as c where ((a.data >= $lanperiodo1) and (a.data <= $lanperiodo2)) and a.codigo_infcpl=b.id and a.dono=c.dono and (c.modelo='01' or c.modelo='1B' or c.modelo='04' or c.modelo='55') group by b.id");

          while ($v=mysql_fetch_assoc($sql)) {

                 $cod_inf=$v['id'];
                 $tamanho6=6;
                 $cod_inf=_myfunc_espaco_a_direita($cod_inf,$tamanho6);

                 $txt=$v['historico'];

                 $linha='|C110|'.$cod_inf.'|'.$txt.'|';
                 $qtde_linha_bloco_C110++ ;
                 $escreve = fwrite($fp, "$linha\r\n");
                 $total_registro_bloco=$total_registro_bloco+1;
                 $tot_C110=$total_registro_bloco;
         }

        $REG_BLC[]='|C110|'.$tot_C110.'|';
        return;
}

//PROCESSO REFERENCIADO
function sped_efd_pis_registro_C111(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C111;

   $reg='C111';

   $num_proc='';
   $tamanho20=20;
   $num_proc=_myfunc_espaco_a_direita($num_proc,$tamanho20);

   $ind_proc='';


   $linha='|'.$reg.'|'.$num_proc.'|'.$ind_proc.'|';
   $qtde_linha_bloco_C111++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_C111=$total_registro_bloco;

   $REG_BLC[]='|C111|'.$total_registro_bloco.'|';
   return;
}


////COMPLEMENTO DO DOCUMENTO - OPERAÇÕES DE IMPORTAÇÃO(CÓDIGO 01)
function sped_efd_pis_registro_C120(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C120;

   $reg='C120';

   $cod_doc_imp='0'; // 0 - Declaração de Importação , 1 - Declaração Simplificada de Importação

   $num_doc_imp='';
   $tamanho10=10;
   $num_doc_imp=_myfunc_espaco_a_direita($num_doc_imp,$tamanho10);

   $vl_pis_imp='';
   //$vl_pis_imp=number_format($vl_pis_imp, 2, ',', '');


   $vl_cofins_imp='';
   //$vl_cofins_imp=number_format($vl_cofins_imp, 2, ',', '');

   $num_acdr_aw='';
   $tamanho20=20;
   $num_acdr_aw=_myfunc_espaco_a_direita($num_acdr_aw,$tamanho20);


   $linha='|'.$reg.'|'.$cod_doc_imp.'|'.$num_doc_imp.'|'.$vl_pis_imp.'|'.$vl_cofins_imp.'|'. $num_acdr_aw.'|';
   $qtde_linha_bloco_C120++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_C120=$total_registro_bloco;

   $REG_BLC[]='|C120|'.$total_registro_bloco.'|';
   return;

}

//COMPLEMENTO DO DOCUMENTO - ITENS DO DOCUMENTO (CÓDIGOS 01,1B,04 E 55)
function sped_efd_pis_registro_C170($xdono){
	global $qtd_lin_C,$tot_registro_bloco_C170,$info_segmento,$fp,$REG_BLC,$TITEM_FLUXO,$CONTITEM_FLUXO,$TPRODUTOS,$TSERVICOS,$info_cnpj_segmento,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS;


 	$xsql_d=_myfunc_sql_receitas_despesas_itens('',$xdono);

      // $selunidade_d = mysql_query("$xsql_d",$CONTITEM_FLUXO);
       $ordem_documento_emitido=0;
       $xdono='######';
 
           while ( $punidade_d = mysql_fetch_assoc($xsql_d)) {
                 
		 if ($xdono<>$punidade_d['dono']) {
                     $ordem_documento_emitido=0;
                     $xdono=$punidade_d['dono'];
		     $num_item=0;
                 }

		$num_item=$num_item+1;
                $cod_item=$punidade_d['cprod'];
                $descr_compl=$punidade_d['xprod'];
 		$qtd=number_format(abs($punidade_d['qcom']), 5, ",", "");

                 $unid=$punidade_d['ucom'];
 
                 $vl_item=_myfunc_valor_base_pis_cofins($punidade_d);

 $vl_item=($punidade_d[vprod]+$punidade_d[vfrete]+$punidade_d[vseg]+$punidade_d[vicmsst]+$punidade_d[vipi]+$punidade_d[voutro])-$punidade_d[vdesc];
//$punidade_d['vprod'];
                 $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

                 $vl_desc=$punidade_d['vdesc'];
                 $vl_desc=number_format(abs($vl_desc), 2, ",", "")  ;

                 

                 $ind_mov='0' ; //sim  TEVE FLUXO?  POR NATUREZA / CFOP  COMPLETAR  0 SIM  1 NAO
 
                
 
                 $cst_icms=$punidade_d['cst'];
                
                 $cfop=$punidade_d['cfop'];
                  
                 $cod_nat=$punidade_d['codnat'] ;
               
                 $vl_bc_icms=$punidade_d['vbc'];
                 $vl_bc_icms=number_format(abs($vl_bc_icms), 2, ",", "")  ;

                 $aliq_icms=$punidade_d['picms'];
                 $tamanho6=6;
                 $aliq_icms=_myfunc_zero_a_esquerda($aliq_icms,$tamanho6) ;
                 $aliq_icms=number_format(abs($aliq_icms), 2, ",", "")  ;

                 $vl_icms=$punidade_d['vicms'];
                 $vl_icms=number_format(abs($vl_icms), 2, ",", "")  ;

                 $vl_bc_icms_st=$punidade_d['vbcst'];
                 $vl_bc_icms_st=number_format(abs($vl_bc_icms_st), 2, ",", "")  ;

                 $aliq_st='';
             
                 $vl_icms_st=$punidade_d['vicmsst'];
                 $vl_icms_st=number_format(abs($vl_icms_st), 2, ",", "")  ;

                 $ind_apur='0'; // 0 - Mensal, 1 - Decendial

                 $cst_ipi=$punidade_d['cstipi'];
               
                 $cod_enq='';   // ??????
                
                 $vl_bc_ipi=$punidade_d['vbc_ipi'];
                 $vl_bc_ipi=number_format(abs($vl_bc_ipi), 2, ",", "")  ;

                 $aliq_ipi=$punidade_d['pipi'];
            
                 $aliq_ipi=number_format(abs($aliq_ipi), 2, ",", "")  ;


                 $vl_ipi=$punidade_d['vipi'];
                 $vl_ipi=number_format(abs($vl_ipi), 2, ",", "")  ;

                  $cst_pis=$punidade_d['cst_pis'];
               
                  $vl_bc_pis=$punidade_d['vbc_pis'];
                  $vl_bc_pis=number_format(abs($vl_bc_pis), 2, ",", "")  ;

                  $aliq_pis=$punidade_d['ppis'];
                 $aliq_pis=number_format(abs($aliq_pis), 4, ",", "")  ;

                  $quant_bc_pis='';
                  //$quant_bc_pis=number_format(abs($quant_bc_pis), 3, ",", "")  ;

                  $aliq_pis_quant='';
                  //$aliq_pis_quant=number_format(abs($aliq_pis_quant), 4, ",", "")  ;

                  $vl_pis=$punidade_d['vpis'];
                  $vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;

                  $cst_cofins=$punidade_d['cst_cofins'];


                  $vl_bc_cofins=$punidade_d['vbc_cofins'];
                  $vl_bc_cofins=number_format(abs($vl_bc_cofins), 2, ",", "")  ;

                  $aliq_cofins=$punidade_d['pcofins'];
                  $tamanho8=8;
                  $aliq_cofins=_myfunc_zero_a_esquerda($aliq_cofins,$tamanho8) ;
                  $aliq_cofins=number_format(abs($aliq_cofins), 4, ",", "")  ;

                  $quant_bc_cofins='';
                  //$quant_bc_cofins=number_format(abs($quant_bc_cofins), 3, ",", "")  ;

                  $aliq_cofins_quant='';
                  //$aliq_cofins_quant=number_format(abs($aliq_cofins_quant), 4, ",", "")  ;


                  $vl_cofins=$punidade_d['vcofins'];
                  $vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;

                  $cod_cta='';
		    $reg='C170'; // adic. para padronização
		    $linha='|'.$reg.'|'.$num_item.'|'.$cod_item.'|'.$descr_compl.'|'.$qtd.'|'.$unid.'|'.$vl_item.'|'.$vl_desc.'|'.$ind_mov.'|'.$cst_icms.'|'.$cfop.'|'.$cod_nat.'|'.$vl_bc_icms.'|'.$aliq_icms.'|'.$vl_icms.'|'.$vl_bc_icms_st.'|'.$aliq_st.'|'.$vl_icms_st.'|'.$ind_apur.'|'.$cst_ipi.'|'.$cod_enq.'|'.$vl_bc_ipi.'|'.$aliq_ipi.'|'.$vl_ipi.'|'.$cst_pis.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$quant_bc_pis.'|'.$aliq_pis_quant.'|'.$vl_pis.'|'.$cst_cofins.'|'.$vl_bc_cofins.'|'.$aliq_cofins.'|'.$quant_bc_cofins.'|'.$aliq_cofins_quant.'|'.$vl_cofins.'|'.$cod_cta.'|';


   
                 _matriz_linha($linha);
        
                 $tot_registro_bloco++;
$tot_registro_bloco_C170++;
}

	   $qtd_lin_C=$qtd_lin_C+$tot_registro_bloco;

 
          return ;
    
 
}


//CONSOLIDAÇÃO DE NOTAS FISCAIS ELETRÔNICAS EMITIDAS PELA PESSOA JURÍDICA(CODIGO 55) - OPERAÇÃO DE VENDAS
function sped_efd_pis_registro_C180(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C180,$TITEM_FLUXO,$TITEM_FLUXO,$info_cnpj_segmento,$TLANCAMENTOS;

   $sql=mysql_query("SELECT a.*,b.codnat,b.data,b.modelo FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b where a.dono=b.dono and a.cnpjcpfseg='$info_cnpj_segmento' and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and b.modelo='55'  and a.movimento='RECEITAS' group by a.cprod  order by a.dono,a.id");

          while ($v=mysql_fetch_assoc($sql)) {

                 $cod_mod=$v['modelo'];

                 $dt_doc_ini=$v['dataatu'];
                 $dt_doc_ini=_myfunc_stod($dt_doc_ini);
                 $dt_doc_ini=_myfunc_ddmmaaaa($dt_doc_ini);

                 $dt_doc_fin=$v['data'];
                 $dt_doc_fin=_myfunc_stod($dt_doc_fin);
                 $dt_doc_fin=_myfunc_ddmmaaaa($dt_doc_fin);

                 if ($v['cean']<>''){
                      $cod_item=$v['cean'];
                  }else{
                      $cod_item=$v['cprod'];
                  }

                  $tamanho60=60;
                  $cod_item=_myfunc_espaco_a_direita($cod_item,$tamanho60);

                  $cod_ncm=$v['ncm'];
                  $tamanho8=8;
                  $cod_ncm=_myfunc_espaco_a_direita($cod_ncm,$tamanho8);

                  $ex_ipi='';
                  $tamanho3=3;
                  $ex_ipi=_myfunc_espaco_a_direita($ex_ipi,$tamanho3);

                  $vl_tot_item=$v['vprod'];
                  $vl_tot_item=number_format(abs($vl_tot_item), 2, ",", "")  ;

                 $linha='|C180|'.$cod_mod.'|'.$dt_doc_ini.'|'.$dt_doc_fin.'|'.$cod_item.'|'.$cod_ncm.'|'.$ex_ipi.'|'.$vl_tot_item.'|';
                 $qtde_linha_bloco_C180++ ;
                 $escreve = fwrite($fp, "$linha\r\n");
                 $total_registro_bloco=$total_registro_bloco+1;
                 $tot_C180=$total_registro_bloco;
         }

        $REG_BLC[]='|C180|'.$total_registro_bloco.'|';
        return;
}

//DETALHAMENTO DA CONSOLIDAÇÃO - OPERAÇÃO DE VENDAS - PIS/PASEP
function sped_efd_pis_registro_C181(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C181,$TITEM_FLUXO,$TITEM_FLUXO,$info_cnpj_segmento,$TLANCAMENTOS;

   $sql=mysql_query("SELECT a.*,b.codnat,b.data,b.modelo FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b where a.dono=b.dono and a.cnpjcpfseg='$info_cnpj_segmento' and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and b.modelo='55'  and a.movimento='RECEITAS' and a.vpis<>'0.00' group by a.cprod  order by a.dono,a.id");

          while ($v=mysql_fetch_assoc($sql)) {

                 $cst_pis=$v['cst_pis'];
                 $tamanho2=2;
                 $cst_pis=_myfunc_zero_a_esquerda($cst_pis,$tamanho2) ;

                 $cfop=$v['cfop'];
                 $tamanho4=4;
                 $cfop=_myfunc_zero_a_esquerda($cfop,$tamanho4) ;


                 $vl_item=$v['vprod'];
                 $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

                 $vl_desc=$v['vdesc'];
                 $vl_desc=number_format(abs($vl_desc), 2, ",", "")  ;

                 $vl_bc_pis=$v['vbc_pis'];
                 $vl_bc_pis=number_format(abs($vl_bc_pis), 2, ",", "")  ;

                 $aliq_pis=$v['ppis'];
                 $tamanho8=8;
                 $aliq_pis=_myfunc_zero_a_esquerda($aliq_pis,$tamanho8) ;
                 $aliq_pis=number_format(abs($aliq_pis), 4, ",", "")  ;

                 $quant_bc_pis='';
                 //$quant_bc_pis=number_format(abs($quant_bc_pis), 3, ",", "")  ;

                 $aliq_pis_quant='';
                 //$aliq_pis_quant=number_format(abs($aliq_pis_quant), 4, ",", "")  ;

                 $vl_pis=$v['vpis'];
                 $vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;

                 $cod_cta='';
                 $tamanho60=60;
                 $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);

                 $linha='|C181|'.$cst_pis.'|'.$cfop.'|'.$vl_item.'|'.$vl_desc.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$quant_bc_pis.'|'.$aliq_pis_quant.'|'.$vl_pis.'|'.$cod_cta.'|';
                 $qtde_linha_bloco_C181++ ;
                 $escreve = fwrite($fp, "$linha\r\n");
                 $total_registro_bloco=$total_registro_bloco+1;
                 $tot_C181=$total_registro_bloco;
         }

        $REG_BLC[]='|C181|'.$tot_C181.'|';
        return;
}


//DETALHAMENTO DA CONSOLIDAÇÃO - OPERAÇÃO DE VENDAS - COFINS
function sped_efd_pis_registro_C185(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C185,$TITEM_FLUXO,$TITEM_FLUXO,$info_cnpj_segmento,$TLANCAMENTOS;

   $sql=mysql_query("SELECT a.*,b.codnat,b.data,b.modelo FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b where a.dono=b.dono and a.cnpjcpfseg='$info_cnpj_segmento' and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and b.modelo='55'  and a.movimento='RECEITAS' and a.vcofins<>'0.00' group by a.cprod  order by a.dono,a.id");
   //echo "SELECT a.*,b.codnat,b.data,b.modelo FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b where a.dono=b.dono and a.cnpjcpfseg='$info_cnpj_segmento' and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and b.modelo='55'  and a.movimento='RECEITAS' group by a.cprod  order by a.dono,a.id";
   //exit;

          while ($v=mysql_fetch_assoc($sql)) {

                 $cst_cofins=$v['cst_cofins'];
                 $tamanho2=2;
                 $cst_cofins=_myfunc_zero_a_esquerda($cst_cofins,$tamanho2) ;

                 $cfop=$v['cfop'];
                 $tamanho4=4;
                 $cfop=_myfunc_zero_a_esquerda($cfop,$tamanho4) ;

                 $vl_item=$v['vprod'];
                 $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

                 $vl_desc=$v['vdesc'];
                 $vl_desc=number_format(abs($vl_desc), 2, ",", "")  ;

                 $vl_bc_cofins=$v['vbc_cofins'];
                 $vl_bc_cofins=number_format(abs($vl_bc_cofins), 2, ",", "")  ;

                 $aliq_cofins=$v['pcofins'];
                 $tamanho8=8;
                 $aliq_cofins=_myfunc_zero_a_esquerda($aliq_cofins,$tamanho8) ;
                 $aliq_cofins=number_format(abs($aliq_cofins), 4, ",", "")  ;

                 $quant_bc_cofins='';
                 //$quant_bc_cofins=number_format(abs($quant_bc_cofins), 3, ",", "")  ;

                 $aliq_cofins_quant='';
                 //$aliq_cofins_quant=number_format(abs($aliq_cofins_quant), 4, ",", "")  ;

escreve_matriz_linha();
return;
                 $vl_cofins=$v['vcofins'];
                 //$vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;

                 $cod_cta='';
                 $tamanho60=60;
                 $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);

                 $linha='|C185|'.$cst_cofins.'|'.$cfop.'|'.$vl_item.'|'.$vl_desc.'|'.$vl_bc_cofins.'|'.$aliq_cofins.'|'.$quant_bc_cofins.'|'.$aliq_cofins_quant.'|'.$vl_cofins.'|'.$cod_cta.'|';
                 $qtde_linha_bloco_C185++ ;
                 $escreve = fwrite($fp, "$linha\r\n");
                 $total_registro_bloco=$total_registro_bloco+1;
                 $tot_C185=$total_registro_bloco;
         }

        $REG_BLC[]='|C185|'.$tot_C185.'|';
        return;
}

//PROCESSO REFERENCIADO
function sped_efd_pis_registro_C188(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C188;

   $reg='C188';

   $num_proc='';
   $tamanho20=20;
   $num_doc_imp=_myfunc_espaco_a_direita($num_doc_imp,$tamanho20);

   $ind_proc='';


   $linha='|'.$reg.'|'.$num_proc.'|'.$ind_proc.'|';
   $qtde_linha_bloco_C188++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_C188=$total_registro_bloco;

   $REG_BLC[]='|C188|'.$total_registro_bloco.'|';
   return;
}


//CONSOLIDAÇÃO DE NOTAS FISCAIS ELETRÔNICAS (CÓDIGO 55) - OPERAÇÃO DE AQUISIÇÃO COM DIREITO A CRÉDITO, E OPERAÇÃO DE DEVOLUÇÃO DE COMPRAS E VENDAS.
function sped_efd_pis_registro_C190(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C190,$TITEM_FLUXO,$TLANCAMENTOS,$TNATUREZAOPERACAO,$info_cnpj_segmento;

   $sql=mysql_query("SELECT a.*,b.codnat,b.data,b.modelo,c.codnat,c.descricaonatureza FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b,$TNATUREZAOPERACAO as c where a.dono=b.dono and a.cnpjcpfseg='$info_cnpj_segmento' and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and b.modelo='55' and b.codnat=c.codnat and c.descricaonatureza LIKE 'Devol%' group by a.cprod order by a.dono,a.id");


   while ($v=mysql_fetch_assoc($sql)) {

         $reg='C190';

         $cod_mod=$v['modelo'];
         $tamanho2=2;
         $cod_mod=_myfunc_espaco_a_direita($cod_mod,$tamanho2);

         $dt_ref_ini=$v['dataatu'];
         $dt_ref_ini=_myfunc_stod($dt_ref_ini);
         $dt_ref_ini=_myfunc_ddmmaaaa($dt_ref_ini);

         $dt_ref_fin=$v['data'];
         $dt_ref_fin=_myfunc_stod($dt_ref_fin);
         $dt_ref_fin=_myfunc_ddmmaaaa($dt_ref_fin);

         $cod_item=$v['cprod'];
         $tamanho60=60;
         $cod_item=_myfunc_espaco_a_direita($cod_item,$tamanho60);

         $cod_ncm=$v['ncm'];
         $tamanho8=8;
         $cod_ncm=_myfunc_espaco_a_direita($cod_ncm,$tamanho8);

         $ex_ipi='';
         $tamanho3=3;
         $cod_ncm=_myfunc_espaco_a_direita($cod_ncm,$tamanho3);

         $vl_tot_item=$v['vprod'];
         $vl_tot_item=number_format(abs($vl_tot_item), 2, ",", "")  ;

   $linha='|'.$reg.'|'.$cod_mod.'|'.$dt_ref_ini.'|'.$dt_ref_fin.'|'.$cod_item.'|'.$cod_ncm.'|'.$ex_ipi.'|'.$vl_tot_item.'|';
   $qtde_linha_bloco_C190++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_C190=$total_registro_bloco;

   }
   $REG_BLC[]='|C190|'.$tot_C190.'|';
   return;
}

//DETALHAMENTO DA CONSOLIDAÇÃO - OPERAÇÃO DE AQUISIÇÃO COM DIREITO A CRÉDITO, E OPERAÇÃO DE DEVOLUÇÃO DE COMPRAS E VENDAS - PIS/PASEP
function sped_efd_pis_registro_C191(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C191,$TITEM_FLUXO,$TITEM_FLUXO,$info_cnpj_segmento,$TLANCAMENTOS,$TNATUREZAOPERACAO;

         $sql=mysql_query("SELECT a.*,b.codnat,b.data,b.modelo,c.codnat,c.descricaonatureza FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b,$TNATUREZAOPERACAO as c where a.dono=b.dono and a.cnpjcpfseg='$info_cnpj_segmento' and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and b.modelo='55' and b.codnat=c.codnat and c.descricaonatureza LIKE 'Devol%' and a.vpis<>'0.00' group by a.cprod order by a.dono,a.id");

          while ($v=mysql_fetch_assoc($sql)) {

                 $cnpj_cpf_part=$v['cnpjcpf'];
                 $tamanho14=14;
                 $cnpj_cpf_part=_myfunc_espaco_a_direita($cnpj_cpf_part,$tamanho14);

                 $cst_pis=$v['cst_pis'];
                 $tamanho2=2;
                 $cst_pis=_myfunc_zero_a_esquerda($cst_pis,$tamanho2) ;

                 $cfop=$v['cfop'];
                 $tamanho4=4;
                 $cfop=_myfunc_zero_a_esquerda($cfop,$tamanho4) ;

                 $vl_item=$v['vprod'];
                 $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

                 $vl_desc=$v['vdesc'];
                 $vl_desc=number_format(abs($vl_desc), 2, ",", "")  ;

                 $vl_bc_pis=$v['vbc_pis'];
                 $vl_bc_pis=number_format(abs($vl_bc_pis), 2, ",", "")  ;

                 $aliq_pis=$v['ppis'];
                 $tamanho8=8;
                 $aliq_pis=_myfunc_zero_a_esquerda($aliq_pis,$tamanho8) ;
                 $aliq_pis=number_format(abs($aliq_pis), 4, ",", "")  ;

                 $quant_bc_pis='';
                 //$quant_bc_pis=number_format(abs($quant_bc_pis), 3, ",", "")  ;

                 $aliq_pis_quant='';
                 //$aliq_pis_quant=number_format(abs($aliq_pis_quant), 4, ",", "")  ;

                 $vl_pis=$v['vpis'];
                 $vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;

                 $cod_cta='';
                 $tamanho60=60;
                 $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);

                 $linha='|C191|'.$cnpj_cpf_part.'|'.$cst_pis.'|'.$cfop.'|'.$vl_item.'|'.$vl_desc.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$quant_bc_pis.'|'.$aliq_pis_quant.'|'.$vl_pis.'|'.$cod_cta.'|';
                 $qtde_linha_bloco_C191++ ;
                 $escreve = fwrite($fp, "$linha\r\n");
                 $total_registro_bloco=$total_registro_bloco+1;
                 $tot_C191=$total_registro_bloco;
         }

        $REG_BLC[]='|C191|'.$tot_C191.'|';
        return;
}

//DETALHAMENTO DA CONSOLIDAÇÃO - OPERAÇÃO DE AQUISIÇÃO COM DIREITO A CRÉDITO, E OPERAÇÃO DE DEVOLUÇÃO DE COMPRAS E VENDAS - COFINS
function sped_efd_pis_registro_C195(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C195,$TITEM_FLUXO,$TITEM_FLUXO,$info_cnpj_segmento,$TLANCAMENTOS,$TNATUREZAOPERACAO;

         $sql=mysql_query("SELECT a.*,b.codnat,b.data,b.modelo,c.codnat,c.descricaonatureza FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b,$TNATUREZAOPERACAO as c where a.dono=b.dono and a.cnpjcpfseg='$info_cnpj_segmento' and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and b.modelo='55' and b.codnat=c.codnat and c.descricaonatureza LIKE 'Devol%' and a.vcofins<>'0.00' group by a.cprod order by a.dono,a.id");


          while ($v=mysql_fetch_assoc($sql)) {

                 $cnpj_cpf_part=$v['cnpjcpf'];
                 $tamanho14=14;
                 $cnpj_cpf_part=_myfunc_espaco_a_direita($cnpj_cpf_part,$tamanho14);

                 $cst_cofins=$v['cst_cofins'];
                 $tamanho2=2;
                 $cst_cofins=_myfunc_zero_a_esquerda($cst_cofins,$tamanho2) ;


                 $cfop=$v['cfop'];
                 $tamanho4=4;
                 $cfop=_myfunc_zero_a_esquerda($cfop,$tamanho4) ;


                 $vl_item=$v['vprod'];
                 $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

                 $vl_desc=$v['vdesc'];
                 $vl_desc=number_format(abs($vl_desc), 2, ",", "")  ;

                 $vl_bc_pis=$v['vbc_cofins'];
                 $vl_bc_pis=number_format(abs($vl_bc_pis), 2, ",", "")  ;

                 $aliq_cofins=$v['pcofins'];
                 $tamanho8=8;
                 $aliq_cofins=_myfunc_zero_a_esquerda($aliq_cofins,$tamanho8) ;
                 $aliq_cofins=number_format(abs($aliq_cofins), 4, ",", "")  ;

                 $quant_bc_cofins='';
                 //$quant_bc_cofins=number_format(abs($quant_bc_cofins), 3, ",", "")  ;

                 $aliq_cofins_quant='';
                 //$aliq_cofins_quant=number_format(abs($aliq_cofins_quant), 4, ",", "")  ;

                 $vl_cofins=$v['vcofins'];
                 $vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;

                 $cod_cta='';
                 $tamanho60=60;
                 $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);

                 $linha='|C195|'.$cnpj_cpf_part.'|'.$cst_cofins.'|'.$cfop.'|'.$vl_item.'|'.$vl_desc.'|'.$vl_bc_cofins.'|'.$aliq_cofins.'|'.$quant_bc_cofins.'|'.$aliq_cofins_quant.'|'.$vl_cofins.'|'.$cod_cta.'|';
                 $qtde_linha_bloco_C195++ ;
                 $escreve = fwrite($fp, "$linha\r\n");
                 $total_registro_bloco=$total_registro_bloco+1;
                 $tot_C195=$total_registro_bloco;
         }

        $REG_BLC[]='|C195|'.$tot_C195.'|';
        return;
}

//PROCESSO REFERENCIADO
function sped_efd_pis_registro_C198(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C198;

   $reg='C198';

   $num_proc='';
   $tamanho20=20;
   $num_proc=_myfunc_espaco_a_direita($num_proc,$tamanho20);

   $ind_proc='';

   $linha='|'.$reg.'|'.$num_proc.'|'.$ind_proc.'|';
   $qtde_linha_bloco_C198++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_C198=$total_registro_bloco;

   $REG_BLC[]='|C198|'.$total_registro_bloco.'|';
   return;
}

//COMPLEMENTO DO DOCUMENTO - OPERAÇÃO DE IMPORTAÇÃO (CODIGO 55)
function sped_efd_pis_registro_C199(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C199;

   $reg='C199';

   $cod_doc_imp='';

   $num_doc_imp='';
   $tamanho10=10;
   $num_doc_imp=_myfunc_espaco_a_direita($num_doc_imp,$tamanho10);

   $vl_pis_imp='';
   //$vl_pis_imp=number_format(abs($vl_pis_imp), 2, ",", "")  ;

   $vl_cofins_imp='';
   //$vl_cofins_imp=number_format(abs($vl_cofins_imp), 2, ",", "")  ;

   $num_acdraw='';
   $tamanho20=20;
   $num_acdraw=_myfunc_espaco_a_direita($num_acdraw,$tamanho20);


   $linha='|'.$reg.'|'.$cod_doc_imp.'|'.$num_doc_imp.'|'.$vl_pis_imp.'|'.$vl_cofins_imp.'|'.$num_acdraw.'|';
   $qtde_linha_bloco_C199++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_C199=$total_registro_bloco;

   $REG_BLC[]='|C199|'.$total_registro_bloco.'|';
   return;
}

//NOTA FISCAL DE VENDA A CONSUMIDOR (CODIGO 02) - CONCOLIDAÇÃO DE DOCUMENTOS EMITIDOS
function sped_efd_pis_registro_C380(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C380,$TITEM_FLUXO,$info_cnpj_segmento,$TLANCAMENTOS;

         $sql=mysql_query("SELECT a.*,b.codnat,b.data,b.modelo,b.documento FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b where a.dono=b.dono and a.cnpjcpfseg='$info_cnpj_segmento' and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and b.modelo='02' and a.movimento='RECEITAS' group by a.cprod order by b.documento,a.id");

          while ($v=mysql_fetch_assoc($sql)) {

                 $cod_mod=$v['modelo'];
                 $tamanho2=2;
                 $cod_mod=_myfunc_espaco_a_direita($cod_mod,$tamanho2);

                 $dt_doc_ini=$v['dataatu'];
                 $dt_doc_ini=_myfunc_stod($dt_doc_ini);
                 $dt_doc_ini=_myfunc_ddmmaaaa($dt_doc_ini);

                 $dt_doc_fin=$v['data'];
                 $dt_doc_fin=_myfunc_stod($dt_doc_fin);
                 $dt_doc_fin=_myfunc_ddmmaaaa($dt_doc_fin);

                 $num_doc_ini=$v['documento'];
                 $tamanho6=6;
                 $num_doc_ini=_myfunc_zero_a_esquerda($num_doc_ini,$tamanho6) ;

                 $num_doc_fin=$v['documento'];
                 $tamanho6=6;
                 $num_doc_fin=_myfunc_zero_a_esquerda($num_doc_fin,$tamanho6) ;

                 $vl_doc=$v['valor'];
                 $vl_doc=number_format(abs($vl_doc), 2, ",", "")  ;

                 $vl_doc_canc=$v['valor'];
                 $vl_doc_canc=number_format(abs($vl_doc_canc), 2, ",", "")  ;



$linha='|C380|'.$cod_mod.'|'.$dt_doc_ini.'|'.$dt_doc_fin.'|'.$num_doc_ini.'|'.$num_doc_fin.'|'.$vl_doc.'|'.$vl_doc_canc.'|';
                 $qtde_linha_bloco_C380++ ;
                 $escreve = fwrite($fp, "$linha\r\n");
                 $total_registro_bloco=$total_registro_bloco+1;
                 $tot_C380=$total_registro_bloco;
}

        $REG_BLC[]='|C380|'.$total_registro_bloco.'|';
        return;
}

//DETALHAMENTO DA CONSOLIDAÇÃO - PIS/PASEP
function sped_efd_pis_registro_C381(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C381,$TITEM_FLUXO,$TITEM_FLUXO,$info_cnpj_segmento,$TLANCAMENTOS;

   $sql=mysql_query("SELECT a.*,b.codnat,b.data,b.modelo FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b where a.dono=b.dono and a.cnpjcpfseg='$info_cnpj_segmento' and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and b.modelo='02'  and a.movimento='RECEITAS' and a.vpis<>'0.00' group by a.cprod  order by a.dono,a.id");

          while ($v=mysql_fetch_assoc($sql)) {

                 $cst_pis=$v['cst_pis'];
                 $tamanho2=2;
                 $cst_pis=_myfunc_zero_a_esquerda($cst_pis,$tamanho2) ;

                 $cod_item=$v['cprod'];
                 $tamanho60=60;
                 $cod_item=_myfunc_espaco_a_direita($cod_item,$tamanho60);

                 $vl_item=$v['vprod'];
                 $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

                 $vl_bc_pis=$v['vbc_pis'];
                 $vl_bc_pis=number_format(abs($vl_bc_pis), 2, ",", "")  ;

                 $aliq_pis=$v['ppis'];
                 $tamanho8=8;
                 $aliq_pis=_myfunc_zero_a_esquerda($aliq_pis,$tamanho8) ;
                 $aliq_pis=number_format(abs($aliq_pis), 4, ",", "")  ;

                 $quant_bc_pis='';
                 //$quant_bc_pis=number_format(abs($quant_bc_pis), 3, ",", "")  ;

                 $aliq_pis_quant='';
                 //$aliq_pis_quant=number_format(abs($aliq_pis_quant), 4, ",", "")  ;

                 $vl_pis=$v['vpis'];
                 $vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;

                 $cod_cta='';
                 $tamanho60=60;
                 $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);

                 $linha='|C381|'.$cst_pis.'|'.$cod_item.'|'.$vl_item.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$quant_bc_pis.'|'.$aliq_pis_quant.'|'.$vl_pis.'|'.$cod_cta.'|';
                 $qtde_linha_bloco_C381++ ;
                 $escreve = fwrite($fp, "$linha\r\n");
                 $total_registro_bloco=$total_registro_bloco+1;
                 $tot_C381=$total_registro_bloco;
         }

        $REG_BLC[]='|C381|'.$tot_C381.'|';
        return;
}

//DETALHAMENTO DA CONSOLIDAÇÃO - COFINS
function sped_efd_pis_registro_C385(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C385,$TITEM_FLUXO,$TITEM_FLUXO,$info_cnpj_segmento,$TLANCAMENTOS;

   $sql=mysql_query("SELECT a.*,b.codnat,b.data,b.modelo FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b where a.dono=b.dono and a.cnpjcpfseg='$info_cnpj_segmento' and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and b.modelo='02'  and a.movimento='RECEITAS' and a.vcofins<>'0.00' group by a.cprod  order by a.dono,a.id");
   //echo "SELECT a.*,b.codnat,b.data,b.modelo FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b where a.dono=b.dono and a.cnpjcpfseg='$info_cnpj_segmento' and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and b.modelo='55'  and a.movimento='RECEITAS' group by a.cprod  order by a.dono,a.id";
   //exit;

          while ($v=mysql_fetch_assoc($sql)) {

                 $cst_cofins=$v['cst_cofins'];
                 $tamanho2=2;
                 $cst_cofins=_myfunc_zero_a_esquerda($cst_cofins,$tamanho2) ;

                 $cod_item=$v['cprod'];
                 $tamanho60=60;
                 $cod_item=_myfunc_espaco_a_direita($cod_item,$tamanho60);

                 $vl_item=$v['vprod'];
                 $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

                 $vl_bc_cofins=$v['vbc_cofins'];
                 $vl_bc_cofins=number_format(abs($vl_bc_cofins), 2, ",", "")  ;

                 $aliq_cofins=$v['pcofins'];
                 $tamanho8=8;
                 $aliq_cofins=_myfunc_zero_a_esquerda($aliq_cofins,$tamanho8) ;
                 $aliq_cofins=number_format(abs($aliq_cofins), 4, ",", "")  ;

                 $quant_bc_cofins='';
                 //$quant_bc_cofins=number_format(abs($quant_bc_cofins), 3, ",", "")  ;

                 $aliq_cofins_quant='';
                 //$aliq_cofins_quant=number_format(abs($aliq_cofins_quant), 4, ",", "")  ;

                 $vl_cofins=$v['vcofins'];
                 $vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;

                 $cod_cta='';
                 $tamanho60=60;
                 $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);
                 $linha='|C385|'.$cst_cofins.'|'.$cod_item.'|'.$vl_item.'|'.$vl_bc_cofins.'|'.$aliq_cofins.'|'.$quant_bc_cofins.'|'.$aliq_cofins_quant.'|'.$vl_cofins.'|'.$cod_cta.'|';
                 $qtde_linha_bloco_C385++ ;
                 $escreve = fwrite($fp, "$linha\r\n");
                 $total_registro_bloco=$total_registro_bloco+1;
                 $tot_C385=$total_registro_bloco;
         }

        $REG_BLC[]='|C385|'.$tot_C385.'|';
        return;
}


//NOTAS FISCAIS DE VENDA A CONSUMIDOR (CÓDIGO 02,2D,2E E 59) - AQUISIÇÃO/ENTRADA COM CRÉDITO
function sped_efd_pis_registro_C395(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C395,$TITEM_FLUXO,$TITEM_FLUXO,$info_cnpj_segmento,$TLANCAMENTOS,$TNATUREZAOPERACAO;

         $sql=mysql_query("SELECT a.*,b.codnat,b.data,b.modelo FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b where a.dono=b.dono and a.cnpjcpfseg='$info_cnpj_segmento' and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and (b.modelo='02' or b.modelo='2D' or b.modelo='2E' or b.modelo='59') and a.movimento='RECEITAS' group by a.cprod order by a.dono,a.id");


         while ($v=mysql_fetch_assoc($sql)) {

                 $cod_mod=$v['modelo'];
                 $tamanho2=2;
                 $cod_mod=_myfunc_espaco_a_direita($cod_mod,$tamanho2);

                 $cod_part=$v['cnpjcpf'];
                 $tamanho60=60;
                 $cod_part=_myfunc_espaco_a_direita($cod_part,$tamanho60);

                 $ser=$v['serie'];
                 $tamanho3=3;
                 $ser=_myfunc_espaco_a_direita($ser,$tamanho3);

                 $sub_ser='';
                 $tamanho3=3;
                 $sub_ser=_myfunc_espaco_a_direita($sub_ser,$tamanho3);

                 $num_doc=$v['documento'];
                 $tamanho6=6;
                 $num_doc=_myfunc_espaco_a_direita($num_doc,$tamanho6);

                 $dt_doc=$v['data'];
                 $dt_doc=_myfunc_stod($dt_doc);
                 $dt_doc=_myfunc_ddmmaaaa($dt_doc);

                 $vl_doc=$v['valor'];
                 $vl_doc=number_format(abs($vl_doc), 2, ",", "")  ;

                 $linha='|C395|'.$cod_mod.'|'.$cod_part.'|'.$ser.'|'.$sub_ser.'|'.$num_doc.'|'.$dt_doc.'|'.$vl_doc.'|';
                 $qtde_linha_bloco_C395++ ;
                 $escreve = fwrite($fp, "$linha\r\n");
                 $total_registro_bloco=$total_registro_bloco+1;
                 $tot_C395=$total_registro_bloco;
         }

        $REG_BLC[]='|C395|'.$total_registro_bloco.'|';
        return;
}

//ITENS DO DOCUMENTO (CÓDIGO 02,2D,2E e 59) - AQUISIÇÃO/ENTRADAS COM CRÉDITO
function sped_efd_pis_registro_C396(){
global $info_segmento,$fp,$REG_BLC,$TITEM_FLUXO,$CONTITEM_FLUXO,$TPRODUTOS,$TSERVICOS,$info_cnpj_segmento,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS,$tot_C396;

       $xsql="SELECT a.*,b.codnat,b.data,b.modelo FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b where a.dono=b.dono and a.cnpjcpfseg='$info_cnpj_segmento' and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and (b.modelo='02' or b.modelo='2D' or b.modelo='2E' or b.modelo='59') order by a.dono,a.id";

       $selunidade = mysql_query("$xsql",$CONTITEM_FLUXO);
       $ordem_documento_emitido=0;
       $xdono='######';
           while ( $punidade = mysql_fetch_assoc($selunidade) ) {
                 if ($xdono<>$punidade['dono']) {
                     $ordem_documento_emitido=0;
                     $xdono=$punidade['dono'];
                 }

                 $vl_item=$punidade['vprod'];
                 $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

                 $vl_desc=$punidade['vdesc'];
                 $vl_desc=number_format(abs($vl_desc), 2, ",", "");

                               $nat_bc_cred='13'; //  ??????

/*
01 Aquisição de bens para revenda
02 Aquisição de bens utilizados como insumo
04 Energia elétrica utilizada nos estabelecimentos da pessoa jurídica
13 Outras operações com direito a crédito
*/
                 $tamanho2=2;
                 $nat_bc_cred=_myfunc_espaco_a_direita($nat_bc_cred,$tamanho2);

                 $cst_pis=$punidade['cst_pis'];
                 $tamanho2=2;
                 $cst_pis=_myfunc_zero_a_esquerda($cst_pis,$tamanho2) ;

                 $vl_bc_pis=$punidade['vbc_pis'];
                 $vl_bc_pis=number_format(abs($vl_bc_pis), 2, ",", "")  ;

                 $aliq_pis=$punidade['ppis'];
                 $tamanho8=8;
                 $aliq_pis=_myfunc_zero_a_esquerda($aliq_pis,$tamanho8) ;
                 $aliq_pis=number_format(abs($aliq_pis), 4, ",", "")  ;


                 $vl_pis=$punidade['vpis'];
                 $vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;

                 $cst_cofins=$punidade['cst_cofins'];
                 $tamanho2=2;
                 $cst_cofins=_myfunc_zero_a_esquerda($cst_cofins,$tamanho2) ;

                 $vl_bc_cofins=$punidade['vbc_cofins'];
                 $vl_bc_cofins=number_format(abs($vl_bc_cofins), 2, ",", "")  ;

                 $aliq_cofins=$punidade['pcofins'];
                 $tamanho8=8;
                 $aliq_cofins=_myfunc_zero_a_esquerda($aliq_cofins,$tamanho8) ;
                 $aliq_cofins=number_format(abs($aliq_cofins), 4, ",", "")  ;


                 $vl_cofins=$punidade['vcofins'];
                 $vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;

                 $cod_cta=$punidade['conta_plano'];
                 $tamanho60=60;
                 $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);


                  if ($punidade['cean']<>''){
                      $cod_item=$punidade['cean'];
                  }else{
                      $cod_item=$punidade['cprod'];
                  }

                  $tamanho60=60;
                  $cod_item=_myfunc_espaco_a_direita($cod_item,$tamanho60);

   $linha='|C396|'.$cod_item.'|'.$vl_item.'|'.$vl_desc.'|'.$nat_bc_cred.'|'.$cst_pis.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$vl_pis.'|'.$cst_cofins.'|'.$vl_bc_cofins.'|'.$aliq_cofins.'|'.$vl_cofins.'|'.$cod_cta.'|';
   $qtde_linha_bloco_C396++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_C396=$total_registro_bloco;
   }
   $REG_BLC[]='|C396|'.$total_registro_bloco.'|';
   return;

}





// REGISTRO C400 - EQUIPAMENTO ECF (CÓDIGO 02 e 2D)
// Nivel - 3
function sped_efd_pis_registro_c400(){
         global $info_segmento,$info_cnpj_segmento,$fp,$qtde_linha_bloco_c,$qtd_lin_C,$pcind_perfil,$REG_BLC;
         global $tot_registro_bloco_C400,$TITEM_FLUXO,$CONTITEM_FLUXO,$TMAPA_RESUMO,$CONTMAPA_RESUMO,$TLANCAMENTOS,$TNFDOCUMENTOS,$perdtos1,$perdtos2,$lanperiodo1,$lanperiodo2,$dtreducaoz;

         $xsql="SELECT * FROM $TMAPA_RESUMO where cnpjcpfseg='$info_cnpj_segmento' and ((dt_mapa >= $perdtos1) and (dt_mapa <= $perdtos2)) group by serial_imp";

         $seleC400 = mysql_query("$xsql",$CONTMAPA_RESUMO);
         //$tot_registro_bloco_C400=0;

         while ( $info_C400 = mysql_fetch_assoc($seleC400) ) {
              //$info_C400 = mysql_fetch_assoc($seleC400);

              $cod_mod='2D';
              $ecf_mod='MP 2100 TH FI';
              $ecf_fab=$info_C400[serial_imp];
              $ecf_cx=$info_C400[numif];

              $reg='C400';
              $linha='|'.$reg.'|'.$cod_mod.'|'.$ecf_mod.'|'.$ecf_fab.'|'.$ecf_cx.'|';
              $qtde_linha_bloco_c++;
              $qtd_lin_C++;
              _matriz_linha($linha);
              $tot_registro_bloco++;

              //$escreve = fwrite($fp, "$linha1"."\r\n");
              //$tot_registro_bloco_C400=$tot_registro_bloco_C400+1;

              $filtro_valor_pis_cofins="and (vpis>0 and vcofins>0) ";
              // Para ser usado no c425 , estava demorando demais o processamento
              $xsql_ifc425="SELECT a.*,b.modelo,b.data as data_e_s,b.cod_sit,b.documento,c.ecf_numimp as serial_imp,FROM_UNIXTIME(a.data,'%d/%m/%Y')  FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b,$TNFDOCUMENTOS as c where a.cnpjcpfseg='$info_cnpj_segmento' and b.modelo='2D' and (a.dono=b.dono and a.dono=c.dono) and b.contac<>'' and (a.data >= '$perdtos1' and a.data<='$perdtos2') order by a.id";
              $sql_error='';

              $sql="drop table IF EXISTS tabela_c425_provisorio";  // apaga anterior
		      	if ( mysql_query($sql) or die (mysql_error()) ) {
       		  	}

              $sql_c425_provisorio="create table tabela_c425_provisorio($xsql_ifc425)";
              if ( mysql_query($sql_c425_provisorio) or die (mysql_error()) ) {
                  // devido a rural pec com aliquota reduzia
                  //$xsql_upifc425="update tabela_c425_provisorio set picms='7.20' where cst='020'";
                  //if ( mysql_query($xsql_upifc425) or die (mysql_error()) ) {
                  //}

                  // devido a cfop de fora do estado para modelo 2D - cupom fiscal
                  $xsql_cfopout="update tabela_c425_provisorio set cfop='5405' where cfop='6404'";
                  if ( mysql_query($xsql_cfopout) or die (mysql_error()) ) {
                  }
                  // devido a cfop de fora do estado para modelo 2D - cupom fiscal
                  $xsql_cfopoutx="update tabela_c425_provisorio set cfop='5102' where cfop='6102'";
                  if ( mysql_query($xsql_cfopoutx) or die (mysql_error()) ) {
                  }


              }

              // REGISTRO C405 - REDUÇÃO Z CÓDIGO 02 e 2D)
              // Nivel - 3
               sped_efd_pis_registro_c405($ecf_fab);
              // até c495


         }
         /*else
         {
              echo '<br>.* Não encontrado MAPA RESUMO para o período';
         }*/

        return;

}

// REGISTRO C405 - REDUÇÃO Z CÓDIGO 02 e 2D)
// Nivel - 3
function sped_efd_pis_registro_c405($ecf_fab){
         global $info_segmento,$fp,$qtde_linha_bloco_c,$REG_BLC;
         global $TITEM_FLUXO,$CONTITEM_FLUXO,$info_cnpj_segmento,$perdtos1,$perdtos2,$dtreducaoz,$serialimpressora,$TMAPA_RESUMO,$CONTMAPA_RESUMO;
         global $tot_registro_bloco_C405,$qtd_lin_C;

         $xsql="SELECT * FROM $TMAPA_RESUMO where cnpjcpfseg='$info_cnpj_segmento' and ((dt_mapa >= $perdtos1) and (dt_mapa <= $perdtos2)) and serial_imp='$ecf_fab' order by dt_mapa,serial_imp";

         $sele405 = mysql_query("$xsql",$CONTMAPA_RESUMO);
         while ( $pmapa = mysql_fetch_assoc($sele405) ) {
            if ($pmapa[vdia]>0) {
                $dtreducaoz=$pmapa[dt_mapa];
                $serialimpressora=$pmapa[serial_imp];
                $dt_doc=_myfunc_stod($dtreducaoz);
                $dt_doc=_myfunc_ddmmaaaa($dt_doc);

                $cro='001';  // Contador de reinicios
                $crz=$pmapa[reducao];
                $num_coo_fin=$pmapa[mapa];

                $gt_fin=$pmapa[gtf];
                $gt_fin=number_format(abs($gt_fin), 2, ",", "")  ;
                if ($gt_fin==0) {
                     $gt_fin='0';
                }

                $vl_brt=$pmapa[vdia];
                $vl_brt=number_format(abs($vl_brt), 2, ",", "")  ;
                if ($vl_brt==0) {
                     $vl_brt='0';
                }

                $reg='C405';
                $linha='|'.$reg.'|'.$dt_doc.'|'.$cro.'|'.$crz.'|'.$num_coo_fin.'|'.$gt_fin.'|'.$vl_brt.'|';
                $qtd_lin_C++;
                _matriz_linha($linha);
	            $tot_registro_bloco++;

                //$qtde_linha_bloco_c++;
                //$escreve = fwrite($fp, "$linha1\r\n");
                //$tot_registro_bloco_C405=$tot_registro_bloco_C405+1;

                // REGISTRO C481 - RESUMO DIÁRIO DE DOC. EMITIDOS ECF (CÓDIGO 02 e 2D)
                // PIS/PASEP
                // Nivel - 5
                $filtroaliq="and ecf_numimp='$serialimpressora'"; // para filhos
                sped_efd_pis_registro_c481($dtreducaoz,$serialimpressora);

                // REGISTRO C485 - RESUMO DIÁRIO DE DOC. EMITIDOS ECF (CÓDIGO 02 e 2D)
                // COFINS
                // Nivel - 5
                sped_efd_pis_registro_c485($dtreducaoz,$serialimpressora);


             }
        }

        return;

}

// REGISTRO C481 - RESUMO DIÁRIO DE DOC. EMITIDOS (CÓDIGO 02 e 2D)
// PIS/PASEP
// Nivel - 5
function sped_efd_pis_registro_c481($dtreducaoz,$serialimpressora){
         global $info_segmento,$fp,$qtde_linha_bloco_c,$qtd_lin_C,$tot_registro_bloco_C481,$REG_BLC;
         global $TITEM_FLUXO,$CONTITEM_FLUXO,$info_cnpj_segmento,$perdtos1,$perdtos2;
         global $vl_bc_cont_m210,$quant_bc_pis_tot_m210;

         $xsql="SELECT cprod,cst_pis,sum(vprod) as vvprod,sum(vfrete) as vvfrete,sum(vseg) as vvseg,sum(vipi) as vvipi,sum(voutro) as vvoutro,sum(vicmsst) as vvicmsst,sum(vdesc) as vvdesc,sum(vbc_pis) as vvbc_pis,ppis,sum(vpis) as vvpis,sum(qbcprod_pis) as vqbcprod_pis,sum(valiqprod_pis) as vvaliqprod_pis FROM tabela_c425_provisorio where data = '$dtreducaoz' and serial_imp='$serialimpressora' group by cprod,cst_pis order by cprod,cst_pis";

         $sele481 = mysql_query("$xsql",$CONTITEM_FLUXO);
         while ($ppis = mysql_fetch_assoc($sele481)){
            //if ($ppis[vvpis]>0) {

                $cod_item=$ppis[cprod];
                $cst_pis=$ppis[cst_pis];

                $vl_item=($ppis[vvprod]-$ppis[vvdesc]);
                //$vl_item=_myfunc_valor_base_pis_cofins($ppis);
                if ($vl_item==0) {
                    $vl_item='0';
                }else{
                    $vl_item=number_format(abs($vl_item), 2, ",", "")  ;
                }


                $vl_bc_pis=$ppis[vvbc_pis];
                $vl_bc_cont_m210=$vl_bc_cont_m210+$vl_bc_pis;
                if ($vl_bc_pis==0) {
                     $vl_bc_pis='0';
                }else{
                     $vl_bc_pis=number_format(abs($vl_bc_pis), 2, ",", "")  ;
                }

                $aliq_pis=$ppis[ppis];
                if ($aliq_pis==0) {
                     $aliq_pis='0';
                }else{
                     $aliq_pis=number_format(abs($aliq_pis), 2, ",", "")  ;
                }

                $quant_bc_pis='';//$ppis[vqbcprod_pis];
                /*$quant_bc_pis_tot_m210=$quant_bc_pis_tot_m210+$quant_bc_pis;
                if ($quant_bc_pis==0) {
                     $quant_bc_pis='0';
                }else{
                     $quant_bc_pis=number_format(abs($quant_bc_pis), 2, ",", "")  ;
                }*/

                $aliq_pis_quant='';//$ppis[vvaliqprod_pis];
                /*if ($aliq_pis_quant==0) {
                     $aliq_pis_quant='0';
                }else{
                     $aliq_pis_quant=number_format(abs($aliq_pis_quant), 2, ",", "")  ;
                }*/

                $vl_pis=$ppis[vvpis];
                if ($vl_pis==0) {
                     $vl_pis='0';
                }else{
                     $vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;
                }

                $cod_cta='';

                $reg='C481';
                $linha='|'.$reg.'|'.$cst_pis.'|'.$vl_item.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$quant_bc_pis.'|'.$aliq_pis_quant.'|'.$vl_pis.'|'.$cod_item.'|'.$cod_cta.'|';
                $qtd_lin_C++;
	            _matriz_linha($linha);
	            $tot_registro_bloco++;

                //$qtde_linha_bloco_c++;
                //$escreve = fwrite($fp, "$linha1"."\r\n");
                //$tot_registro_bloco_C481=$tot_registro_bloco_C481+1;
             //}
        }

        return;
}

// REGISTRO C485 - RESUMO DIÁRIO DE DOC. EMITIDOS (CÓDIGO 02 e 2D)
// COFINS
// Nivel - 5
function sped_efd_pis_registro_c485($dtreducaoz,$serialimpressora){
         global $info_segmento,$fp,$qtde_linha_bloco_c,$qtd_lin_C,$tot_registro_bloco_C485,$REG_BLC;
         global $TITEM_FLUXO,$CONTITEM_FLUXO,$info_cnpj_segmento,$perdtos1,$perdtos2;
         global $vl_bc_cont_m610,$quant_bc_pis_tot_m610;
         $xsql="SELECT cprod,cst_cofins,sum(vprod) as vvprod,sum(vfrete) as vvfrete,sum(vseg) as vvseg,sum(vipi) as vvipi,sum(voutro) as vvoutro,sum(vicmsst) as vvicmsst,sum(vdesc) as vvdesc,sum(vbc_cofins) as vvbc_cofins,pcofins,sum(vcofins) as vvcofins,sum(qbcprod_cofins) as vqbcprod_cofins,sum(valiqprod_cofins) as vvaliqprod_cofins FROM tabela_c425_provisorio where data = '$dtreducaoz' and serial_imp='$serialimpressora' group by cprod,cst_cofins order by cprod,cst_cofins";

         $sele481 = mysql_query("$xsql",$CONTITEM_FLUXO);
         while ($pcofins = mysql_fetch_assoc($sele481)) {
            //if ($pcofins[vvcofins]>0) {

                $cod_item=$pcofins[cprod];
                $cst_cofins=$pcofins[cst_cofins];

                $vl_item=($pcofins[vvprod]-$pcofins[vvdesc]);
                //$vl_item=_myfunc_valor_base_pis_cofins($pcofins);
                if ($vl_item==0) {
                    $vl_item='0';
                }else{
                    $vl_item=number_format(abs($vl_item), 2, ",", "")  ;
                }


                $vl_bc_cofins=$pcofins[vvbc_cofins];
                $vl_bc_cont_m610=$vl_bc_cont_m610+$vl_bc_cofins;
                if ($vl_bc_cofins==0) {
                     $vl_bc_cofins='0';
                }else{
                     $vl_bc_cofins=number_format(abs($vl_bc_cofins), 2, ",", "")  ;
                }

                $aliq_cofins=$pcofins[pcofins];
                if ($aliq_cofins==0) {
                     $aliq_cofins='0';
                }else{
                     $aliq_cofins=number_format(abs($aliq_cofins), 2, ",", "")  ;
                }

                $quant_bc_cofins='';//$pcofins[vqbcprod_cofins];
                /*$quant_bc_pis_tot_m610=$quant_bc_pis_tot_m610+$quant_bc_cofins;
                if ($quant_bc_cofins==0) {
                     $quant_bc_cofins='0';
                }else{
                     $quant_bc_cofins=number_format(abs($quant_bc_cofins), 2, ",", "")  ;
                }*/

                $aliq_cofins_quant='';//$pcofins[vvaliqprod_cofins];
                /*if ($aliq_cofins_quant==0) {
                     $aliq_cofins_quant='0';
                }else{
                     $aliq_cofins_quant=number_format(abs($aliq_cofins_quant), 2, ",", "")  ;
                }*/

                $vl_cofins=$pcofins[vvcofins];
                if ($vl_cofins==0) {
                     $vl_cofins='0';
                }else{
                     $vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;
                }

                $cod_cta='';

                $reg='C485';
                $linha='|'.$reg.'|'.$cst_cofins.'|'.$vl_item.'|'.$vl_bc_cofins.'|'.$aliq_cofins.'|'.$quant_bc_cofins.'|'.$aliq_cofins_quant.'|'.$vl_cofins.'|'.$cod_item.'|'.$cod_cta.'|';
                $qtd_lin_C++;
	            _matriz_linha($linha);
	            $tot_registro_bloco++;

                //$qtde_linha_bloco_c++;
                //$escreve = fwrite($fp, "$linha1"."\r\n");
                //$tot_registro_bloco_C485=$tot_registro_bloco_C485+1;
             //}
        }
        return;
}

//PROCESSO REFERENCIADO
function sped_efd_pis_registro_C489(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C489,$qtd_lin_C;

   $reg='C489';
   $num_proc='';
   $tamanho20=20;
   $num_proc=_myfunc_espaco_a_direita($num_proc,$tamanho20);

   $ind_proc='';

   $linha='|'.$reg.'|'.$num_proc.'|'.$ind_proc.'|';
   $qtd_lin_C++;
   _matriz_linha($linha);
   $tot_registro_bloco++;

   //$qtde_linha_bloco_C489++ ;

   //$escreve = fwrite($fp, "$linha\r\n");
   //$total_registro_bloco=$total_registro_bloco+1;
   //$tot_C489=$total_registro_bloco;

   //$REG_BLC[]='|C489|'.$total_registro_bloco.'|';
   return;
}

//CONSOLIDAÇÃO DE DOCUMENTOS EMITIDOS POR ECF - (CÓDIGO 02,2D E 59)
function sped_efd_pis_registro_C490(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C490,$TITEM_FLUXO,$TLANCAMENTOS,$TNATUREZAOPERACAO,$info_cnpj_segmento;

   $sql=mysql_query("SELECT a.*,b.codnat,b.data,b.modelo,c.codnat,c.descricaonatureza FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b,$TNATUREZAOPERACAO as c where a.dono=b.dono and a.cnpjcpfseg='$info_cnpj_segmento' and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and (b.modelo='02' or b.modelo='2D' or b.modelo='59') and b.codnat=c.codnat group by a.cprod order by a.dono,a.id");

   while ($v=mysql_fetch_assoc($sql)) {

         $reg='C490';

         $cod_mod=$v['modelo'];
         $tamanho2=2;
         $cod_mod=_myfunc_zero_a_esquerda($cod_mod,$tamanho2) ;

         $dt_ref_ini=$v['dataatu'];
         $dt_ref_ini=_myfunc_stod($dt_ref_ini);
         $dt_ref_ini=_myfunc_ddmmaaaa($dt_ref_ini);

         $dt_ref_fin=$v['data'];
         $dt_ref_fin=_myfunc_stod($dt_ref_fin);
         $dt_ref_fin=_myfunc_ddmmaaaa($dt_ref_fin);

   $linha='|'.$reg.'|'.$dt_ref_ini.'|'.$dt_ref_fin.'|'.$cod_mod.'|';
   $qtde_linha_bloco_C490++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_C490=$total_registro_bloco;

   }
   $REG_BLC[]='|C490|'.$total_registro_bloco.'|';
   return;

}

//DETALHAMENTO DA CONSOLIDAÇÃO DE DOCUMENTOS EMITIDOS POR ECF (CÓDIGO 02,2D E 59) - PIS/PASEP
function sped_efd_pis_registro_C491(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C491,$TITEM_FLUXO,$TITEM_FLUXO,$info_cnpj_segmento,$TLANCAMENTOS;

   $sql=mysql_query("SELECT a.*,b.codnat,b.data,b.modelo FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b where a.dono=b.dono and a.cnpjcpfseg='$info_cnpj_segmento' and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and (b.modelo='02' or b.modelo='2D' or b.modelo='59') and a.vpis<>'0.00' group by a.cprod  order by a.dono,a.id");

          while ($v=mysql_fetch_assoc($sql)) {

                 $cst_pis=$v['cst_pis'];
                 $tamanho2=2;
                 $cst_pis=_myfunc_zero_a_esquerda($cst_pis,$tamanho2) ;

                 $cod_item=$v['cprod'];
                 $tamanho60=60;
                 $cod_item=_myfunc_espaco_a_direita($cod_item,$tamanho60);

                 $cfop=$v['cfop'];
                 $tamanho4=4;
                 $cfop=_myfunc_zero_a_esquerda($cfop,$tamanho4) ;

                 $vl_item=$v['vprod'];
                 $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

                 $vl_bc_pis=$v['vbc_pis'];
                 $vl_bc_pis=number_format(abs($vl_bc_pis), 2, ",", "")  ;

                 $aliq_pis=$v['ppis'];
                 $tamanho8=8;
                 $aliq_pis=_myfunc_zero_a_esquerda($aliq_pis,$tamanho8) ;
                 $aliq_pis=number_format(abs($aliq_pis), 4, ",", "")  ;

                 $quant_bc_pis='';
                 //$quant_bc_pis=number_format(abs($quant_bc_pis), 3, ",", "")  ;

                 $aliq_pis_quant='';
                 //$aliq_pis_quant=number_format(abs($aliq_pis_quant), 4, ",", "")  ;

                 $vl_pis=$v['vpis'];
                 $vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;

                 $cod_cta='';
                 $tamanho60=60;
                 $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);

                 $linha='|C491|'.$cod_item.'|'.$cst_pis.'|'.$cfop.'|'.$vl_item.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$quant_bc_pis.'|'.$aliq_pis_quant.'|'.$vl_pis.'|'.$cod_cta.'|';
                 $qtde_linha_bloco_C491++ ;
                 $escreve = fwrite($fp, "$linha\r\n");
                 $total_registro_bloco=$total_registro_bloco+1;
                 $tot_C491=$total_registro_bloco;
         }

        $REG_BLC[]='|C491|'.$tot_C491.'|';
        return;

}

//DETALHAMENTO DA CONSOLIDAÇÃO DE DOCUMENTOS EMITIDOS POR ECF (CÓDIGO 02,2D E 59)
function sped_efd_pis_registro_C495(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C495,$TITEM_FLUXO,$info_cnpj_segmento,$TLANCAMENTOS;

   $sql=mysql_query("SELECT a.*,b.codnat,b.data,b.modelo FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b where a.dono=b.dono and a.cnpjcpfseg='$info_cnpj_segmento' and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and b.modelo='02'  and a.movimento='RECEITAS' and a.vcofins<>'0.00' group by a.cprod  order by a.dono,a.id");

          while ($v=mysql_fetch_assoc($sql)) {

                 $cst_cofins=$v['cst_cofins'];
                 $tamanho4=4;
                 $cst_cofins=_myfunc_zero_a_esquerda($cst_cofins,$tamanho4) ;

                 $cod_item=$v['cprod'];
                 $tamanho60=60;
                 $cod_item=_myfunc_espaco_a_direita($cod_item,$tamanho60);

                 $cfop=$v['cfop'];
                 $tamanho4=4;
                 $cfop=_myfunc_zero_a_esquerda($cfop,$tamanho4) ;

                 $vl_item=$v['vprod'];
                 $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

                 $vl_bc_cofins=$v['vbc_cofins'];
                 $vl_bc_cofins=number_format(abs($vl_bc_cofins), 2, ",", "")  ;

                 $aliq_cofins=$v['pcofins'];
                 $tamanho8=8;
                 $aliq_cofins=_myfunc_zero_a_esquerda($aliq_cofins,$tamanho8) ;
                 $aliq_cofins=number_format(abs($aliq_cofins), 4, ",", "")  ;

                 $quant_bc_cofins='';
                 //$quant_bc_cofins=number_format(abs($quant_bc_cofins), 2, ",", "")  ;

                 $aliq_cofins_quant='';
                 //$aliq_cofins_quant=number_format(abs($aliq_cofins_quant), 2, ",", "")  ;

                 $vl_cofins=$v['vcofins'];
                 $vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;

                 $cod_cta='';
                 $tamanho60=60;
                 $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);

                 $linha='|C495|'.$cod_item.'|'.$cst_cofins.'|'.$cfop.'|'.$vl_item.'|'.$vl_bc_cofins.'|'.$aliq_cofins.'|'.$quant_bc_cofins.'|'.$aliq_cofins_quant.'|'.$vl_cofins.'|'.$cod_cta.'|';
                 $qtde_linha_bloco_C495++ ;
                 $escreve = fwrite($fp, "$linha\r\n");
                 $total_registro_bloco=$total_registro_bloco+1;
                 $tot_C495=$total_registro_bloco;
         }

        $REG_BLC[]='|C495|'.$tot_C495.'|';
        return;

}


//PROCESSO REFERENCIADO
function sped_efd_pis_registro_C499(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C499;

   $reg='C499';

   $num_proc='';
   $tamanho20=20;
   $num_proc=_myfunc_espaco_a_direita($num_proc,$tamanho20);

   $ind_proc='';


   $linha='|'.$reg.'|'.$num_proc.'|'.$ind_proc.'|';
   $qtde_linha_bloco_C499++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_C499=$total_registro_bloco;

   $REG_BLC[]='|C499|'.$total_registro_bloco.'|';
   return;

}

//NOTA FISCAL/CONTA DE ENERGIA ELÉTRICA (CÓDIGO 06),NOTA FISCAL/CONTA DE FORNECIMENTO D'ÁGUA CANALIZADA (CÓSIGO 29) E NOTA FISCAL CONSUMO FORNECIMENTO DE GÁS (CÓDIGO 28) - DOCUMENTOS DE ENTRADA/AQUISIÇÃO COM CRÉDITO
//A AGUA E O GÁS UTILIZADOS COMO INSUMO.
function sped_efd_pis_registro_C500(){

	global $qtd_lin_C,$tot_registro_bloco_C501,$tot_registro_bloco_C505,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$TLANCAMENTOS,$TNFDOCUMENTOS,$TITEM_FLUXO;
	global $TNFDOCUMENTOS_TMP,$TNFDOCUMENTOS,$CONTNFDOCUMENTOS;
	$filtro_lancamentos=" and POSITION(modelo IN ':06:29:28:') > 0";
        $sql_lancamentos= _myfunc_sql_receitas_despesas_documentos('',"$filtro_lancamentos",'','','');
 
    while ($v=mysql_fetch_assoc($sql_lancamentos)) {
		$dono=$v[dono];
          $cod_part=$v['cnpjcpf'];
       
          $cod_mod=$v['modelo'];
      
          	 //  00 Documento regular  01 Documento regular extemporâneo  02 Documento cancelado 03 Documento cancelado extemporâneo  04 NF-e ou CT-e denegado  05 NF-e ou CT-e  Numeração inutilizada   06 Documento Fiscal Complementar  07 Documento Fiscal Complementar extemporâneo.    08 Documento Fiscal emitido com base em Regime Especial ou Norma Específica
                                                
            $cod_sit=(empty($v[cod_sit]))  ? '00' : $v[cod_sit];  // se for receitas ,emissão propria
 
          $ser=$v['serie'];
         
          $sub=_myfunc_zero_a_esquerda($sub,$tamanho3) ;

          $num_doc=$v['documento'];
        
          $dt_doc=$v['data'];
          $dt_doc=_myfunc_stod($dt_doc);
          $dt_doc=_myfunc_ddmmaaaa($dt_doc);

          $dt_ent=$dt_doc;
		$vl_doc=($v[svprod]+$v[svfrete]+$v[svseg]+$v[svicmsst]+$v[svipi]+$v[svoutro])-$v[svdesc];
	  
	    $vl_doc=number_format($vl_doc, 2, ',', '');


          $vl_ivmcs=$v['svicms'];
          $vl_ivmcs=number_format(abs($vl_ivmcs), 2, ",", "")  ;

          $cod_inf='';  // ???????
  


          $vl_pis=$v['vpis'];
          $vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;

          $vl_cofins=$v['vcofins'];
          $vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;


	$linha='|C500|'.$cod_part.'|'.$cod_mod.'|'.$cod_sit.'|'.$ser.'|'.$sub.'|'.$num_doc.'|'.$dt_doc.'|'.$dt_ent.'|'.$vl_doc.'|'.$vl_icms.'|'.$cod_inf.'|'.$vl_pis.'|'.$vl_cofins.'|';


	  _matriz_linha($linha);
	   $tot_registro_bloco++;

	   // c501 filho
		sped_efd_pis_registro_C501($dono); 

   // c505 filho
		sped_efd_pis_registro_C505($dono);
		 
	 
}



          $REG_BLC[]='|C500|'.$tot_registro_bloco.'|';
	   $qtd_lin_C=$qtd_lin_C+$tot_registro_bloco;


  $REG_BLC[]='|C501|'.$tot_registro_bloco_C501.'|';
	   $qtd_lin_C=$qtd_lin_C+$tot_registro_bloco_C501;
 		

          $REG_BLC[]='|C505|'.$tot_registro_bloco_C505.'|';
	   $qtd_lin_C=$qtd_lin_C+$tot_registro_bloco_C505;

 	 
          return ;

}
 
 

//COMPLEMENTO DA OPERAÇÃO (CÓDIGO 06,28 E 29) - PIS/PASEP
function sped_efd_pis_registro_C501($xdono){
 global $qtd_lin_C,$tot_registro_bloco_C501,$info_segmento,$fp,$REG_BLC,$TITEM_FLUXO,$CONTITEM_FLUXO,$TPRODUTOS,$TSERVICOS,$info_cnpj_segmento,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS;

 $xsql_d=_myfunc_sql_receitas_despesas_itens('',$xdono);

      // $selunidade_d = mysql_query("$xsql_d",$CONTITEM_FLUXO);
       $ordem_documento_emitido=0;
       $xdono='######';
 
           while ( $punidade_d = mysql_fetch_assoc($xsql_d)) {

                 $cst_pis=$punidade_d['cst_pis'];
               
                 $vl_item=_myfunc_valor_base_pis_cofins($punidade_d);
                 $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

                 $nat_bc_cred='13'; //  ??????

/*
01 Aquisição de bens para revenda
02 Aquisição de bens utilizados como insumo
04 Energia elétrica utilizada nos estabelecimentos da pessoa jurídica
13 Outras operações com direito a crédito
*/
                   $vl_bc_pis=$punidade_d['vbc_pis'];
                  $vl_bc_pis=number_format(abs($vl_bc_pis), 2, ",", "")  ;

                  $aliq_pis=$punidade_d['ppis'];
                  $aliq_pis=number_format(abs($aliq_pis), 2, ",", "")  ;

                  $vl_pis=$punidade_d['vpis'];
                  $vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;


                 $cod_cta='';
              
                 $linha='|C501|'.$cst_pis.'|'.$vl_item.'|'.$nat_bc_cred.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$vl_pis.'|'.$cod_cta.'|';
                
			 
	  		_matriz_linha($linha);

	   		$tot_registro_bloco_C501++;

 } 
        return;

}

//COMPLEMENTO DA OPERAÇÃO (CÓDIGO 06,28 E 29) - COFINS

function sped_efd_pis_registro_C505($xdono){
 global $qtd_lin_C,$tot_registro_bloco_C505,$info_segmento,$fp,$REG_BLC,$TITEM_FLUXO,$CONTITEM_FLUXO,$TPRODUTOS,$TSERVICOS,$info_cnpj_segmento,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS;

 $xsql_d=_myfunc_sql_receitas_despesas_itens('',$xdono);

      // $selunidade_d = mysql_query("$xsql_d",$CONTITEM_FLUXO);
       $ordem_documento_emitido=0;
       $xdono='######';
 
           while ( $punidade_d = mysql_fetch_assoc($xsql_d)) {

                 $cst_cofins=$punidade_d['cst_cofins'];
               
                 $vl_item=_myfunc_valor_base_pis_cofins($punidade_d);
                 $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

                           $nat_bc_cred='13'; //  ??????

/*
01 Aquisição de bens para revenda
02 Aquisição de bens utilizados como insumo
04 Energia elétrica utilizada nos estabelecimentos da pessoa jurídica
13 Outras operações com direito a crédito
*/
     
              
                   $vl_bc_cofins=$punidade_d['vbc_cofins'];
                  $vl_bc_cofins=number_format(abs($vl_bc_cofins), 2, ",", "")  ;

                  $aliq_cofins=$punidade_d['pcofins'];
                  $aliq_cofins=number_format(abs($aliq_cofins), 2, ",", "")  ;

                  $vl_cofins=$punidade_d['vcofins'];
                  $vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;


                 $cod_cta='';
              
                 $linha='|C505|'.$cst_cofins.'|'.$vl_item.'|'.$nat_bc_cred.'|'.$vl_bc_cofins.'|'.$aliq_cofins.'|'.$vl_cofins.'|'.$cod_cta.'|';
                
			 
	  		_matriz_linha($linha);
	   		$tot_registro_bloco_C505++;

 }
          		 
        return;

}




//PROCESSO REFERENCIADO
function sped_efd_pis_registro_C509(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C509;

   $reg='C509';

   $num_proc='';
   $tamanho60=60;
   $num_proc=_myfunc_espaco_a_direita($num_proc,$tamanho60);

   $ind_proc='';


   $linha='|'.$reg.'|'.$num_proc.'|'.$ind_proc.'|';
   $qtde_linha_bloco_C509++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_C509=$total_registro_bloco;

   $REG_BLC[]='|C509|'.$total_registro_bloco.'|';
   return;

}

//CONSOLIDAÇÃO DIÁRIA DE NOTAS FISCAIS/CONTAS EMITIDAS DE ENERGIA ELÉTRICA (CÓDIGO 06), NOTA FISCAL/CONTA DE FORNECIMENTO D'ÁGUA CANALIZADA (CÓDIGO 29) E NOTA FISCAL/CONTA DE FORNECIMENTO DE GÁS (CÓDIGO 28)(EMPRESAS OBRIGADAS OU NÃO OBRIGADAS AO CONVENIO ICMS 155/03) - DOCUMENTO DE SAÍDA
function sped_efd_pis_registro_C600(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C600,$TITEM_FLUXO,$TLANCAMENTOS,$THISTORICOS,$TCNPJCPF;


$sql=mysql_query("SELECT sum(a.vicms) as vicms,a.vpis,a.vcofins,a.dono,sum(a.vdesc) as vdesc,b.codnat,b.modelo,b.cod_sit,b.serie,b.documento,b.data,b.dataatu,b.valor,b.historico,b.dono,b.cnpjcpf,c.id,c.historico,d.cnpj,d.cod_mun FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b,$THISTORICOS as c,$TCNPJCPF as d where a.dono=b.dono and (b.modelo='06' or b.modelo='29' or b.modelo='28') and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and a.movimento='RECEITAS' and b.cnpjcpf=d.cnpj group by b.dono order by b.dono");


   while ($v=mysql_fetch_assoc($sql)) {


          $cod_mod=$v['modelo'];
          $tamanho60=60;
          $cod_mod=_myfunc_espaco_a_direita($cod_mod,$tamanho60);

          $cod_mun=$v['cod_mun'];
          $tamanho7=7;
          $cod_mun=_myfunc_zero_a_esquerda($cod_mun,$tamanho7);

          $ser=$v['serie'];
          $tamanho4=4;
          $ser=_myfunc_espaco_a_direita($ser,$tamanho4);

          $sub='';
          $tamanho3=3;
          $sub=_myfunc_zero_a_esquerda($sub,$tamanho3);

          $cod_cons='';
          $tamanho2=2;
          $cod_cons=_myfunc_zero_a_esquerda($cod_cons,$tamanho2);

          $qtd_cons='';

          $qtd_canc='';

          $dt_doc=$v['dataatu'];
          $dt_doc=_myfunc_stod($dt_doc);
          $dt_doc=_myfunc_ddmmaaaa($dt_doc);

          $vl_doc=$v['valor'] ;
          $vl_doc=number_format(abs($vl_doc), 2, ",", "")  ;

          $vl_desc=$v['vdesc'] ;
          $vl_desc=number_format(abs($vl_desc), 2, ",", "")  ;

          $cons='';

          $vl_forn='';
          //$vl_forn=number_format(abs($vl_forn), 2, ",", "")  ;

          $vl_serv_nt='';
          //$vl_serv_nt=number_format(abs($vl_serv_nt), 2, ",", "")  ;

          $vl_terc='';
          //$vl_terc=number_format(abs($vl_terc), 2, ",", "")  ;

          $vl_da='';
          //$vl_da=number_format(abs($vl_da), 2, ",", "")  ;

          $vl_bc_icms='';
          //$vl_bc_icms=number_format(abs($vl_bc_icms), 2, ",", "")  ;

          $vl_icms='';
          //$vl_icms=number_format(abs($vl_icms), 2, ",", "")  ;

          $vl_bc_icms_st='';
          //$vl_bc_icms_st=number_format(abs($vl_bc_icms_st), 2, ",", "")  ;

          $vl_icms_st='';
          //$vl_icms_st=number_format(abs($vl_icms_st), 2, ",", "")  ;

          $vl_pis='';
          //$vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;

          $vl_cofins='';
          //$vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;

$linha='|C600|'.$cod_mod.'|'.$cod_mun.'|'.$ser.'|'.$sub.'|'.$cod_cons.'|'.$qtd_cons.'|'.$qtd_canc.'|'.$dt_doc.'|'.$vl_doc.'|'.$vl_desc.'|'.$cons.'|'.$vl_forn.'|'.$vl_serv_nt.'|'.$vl_terc.'|'.vl_da.'|'.$vl_bc_icms.'|'.$vl_bc_icms.'|'.$vl_icms.'|'.$vl_bc_icms_st.'|'.vl_icms_st.'|'.$vl_pis.'|'.$vl_cofins.'|';
                 $qtde_linha_bloco_C600++ ;
                 $escreve = fwrite($fp, "$linha\r\n");
                 $total_registro_bloco=$total_registro_bloco+1;
                 $tot_C600=$total_registro_bloco;
         }

        $REG_BLC[]='|C600|'.$tot_C600.'|';
        return;
}


//COMPLEMENTO DA CONSOLIDAÇÃO DIÁRIA (CÓDIGO 06,28 E 29) - DOCUMENTOS DE SAÍDAS - PIS/PASEP
function sped_efd_pis_registro_C601(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C601,$TITEM_FLUXO,$TITEM_FLUXO,$info_cnpj_segmento,$TLANCAMENTOS;

   $sql=mysql_query("SELECT a.*,b.codnat,b.data,b.modelo FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b where a.dono=b.dono and a.cnpjcpfseg='$info_cnpj_segmento' and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and (b.modelo='06' or b.modelo='28' or b.modelo='29') and a.vpis<>'0.00' and a.movimento='RECEITAS' group by a.cprod  order by a.dono,a.id");

          while ($v=mysql_fetch_assoc($sql)) {

                 $cst_pis=$v['cst_pis'];
                 $tamanho2=2;
                 $cst_pis=_myfunc_zero_a_esquerda($cst_pis,$tamanho2) ;

                 $vl_item=$v['vprod'];
                 $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

                 $vl_bc_pis=$v['vbc_pis'];
                 $vl_bc_pis=number_format(abs($vl_bc_pis), 2, ",", "")  ;

                 $aliq_pis=$v['ppis'];
                 $tamanho8=8;
                 $aliq_pis=_myfunc_zero_a_esquerda($aliq_pis,$tamanho8) ;
                 $aliq_pis=number_format(abs($aliq_pis), 4, ",", "")  ;

                 $vl_pis=$v['vpis'];
                 $vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;

                 $cod_cta='';
                 $tamanho10=10;
                 $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho10);

                 $linha='|C601|'.$cst_pis.'|'.$vl_item.'|'.$nat_bc_cred.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$vl_pis.'|'.$cod_cta.'|';
                 $qtde_linha_bloco_C601++ ;
                 $escreve = fwrite($fp, "$linha\r\n");
                 $total_registro_bloco=$total_registro_bloco+1;
                 $tot_C601=$total_registro_bloco;
         }

        $REG_BLC[]='|C601|'.$tot_C601.'|';
        return;

}


//COMPLEMENTO DE CONSOLIDAÇÃO DIÁRIA (CÓDIGO 06,28 E 29) - DOCUMENTOS DE SAÍDA - COFINS
function sped_efd_pis_registro_C605(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C605,$TITEM_FLUXO,$info_cnpj_segmento,$TLANCAMENTOS;

   $sql=mysql_query("SELECT a.*,b.codnat,b.data,b.modelo FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b where a.dono=b.dono and a.cnpjcpfseg='$info_cnpj_segmento' and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and (b.modelo='06' or b.modelo='28' or b.modelo='29') and a.vcofins<>'0.00' and a.movimento='RECEITAS' group by a.cprod  order by a.dono,a.id");

          while ($v=mysql_fetch_assoc($sql)) {

                 $cst_cofins=$v['cst_cofins'];
                 $tamanho2=2;
                 $cst_cofins=_myfunc_zero_a_esquerda($cst_cofins,$tamanho2) ;

                 $vl_item=$v['vprod'];
                 $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

                 $vl_bc_cofins=$v['vbc_cofins'];
                 $vl_bc_cofins=number_format(abs($vl_bc_cofins), 2, ",", "")  ;

                 $aliq_cofins=$v['pcofins'];
                 $tamanho8=8;
                 $aliq_cofins=_myfunc_zero_a_esquerda($aliq_cofins,$tamanho8) ;
                 $aliq_cofins=number_format(abs($aliq_cofins), 4, ",", "")  ;


                 $vl_cofins=$v['vcofins'];
                 $vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;

                 $cod_cta='';
                 $tamanho10=10;
                 $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho10);


                 $linha='|C605|'.$cst_pis.'|'.$vl_item.'|'.$nat_bc_cred.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$vl_pis.'|'.$cod_cta.'|';
                 $qtde_linha_bloco_C605++ ;
                 $escreve = fwrite($fp, "$linha\r\n");
                 $total_registro_bloco=$total_registro_bloco+1;
                 $tot_C605=$total_registro_bloco;
         }

        $REG_BLC[]='|C605|'.$tot_C605.'|';
        return;

}

//PROCESSO REFERENCIADO
function sped_efd_pis_registro_C609(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_C609;

   $reg='C609';

   $num_proc='';
   $tamanho10=10;
   $num_proc=_myfunc_espaco_a_direita($num_proc,$tamanho10);


   $ind_proc='';


   $linha='|'.$reg.'|'.$num_proc.'|'.$ind_proc.'|';
   $qtde_linha_bloco_C609++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_C609=$total_registro_bloco;

   $REG_BLC[]='|C609|'.$total_registro_bloco.'|';
   return;

}


//ENCERRAMENTO DO BLOCO C
function sped_efd_pis_registro_C990(){
global $qtd_lin_C,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC;
     
   
 

  $reg='C990';
          
          $linha='|'.$reg.'|'. $qtd_lin_C.'|';
         
          _matriz_linha($linha);
        
          $tot_registro_bloco=$tot_registro_bloco+1;
          $REG_BLC[]='|C990|'.$tot_registro_bloco.'|';
          return ;
 

}



// inicio bloco D


// inicio bloco D
// BLOCO D: DOCUMENTOS FISCAIS II - SERVIÇOS (ICMS)
//REGISTRO D001: ABERTURA DO BLOCO D
sped_efd_pis_registro_D001(); //ABERTURA DO BLOCO D

//sped_efd_pis_registro_D010(); //IDENTIFICAÇÃO DO ESTABELECIMENTO
// Alt. habilitada a gerar
//sped_efd_pis_registro_D100(); //AQUISIÇÃO DE SERVIÇOS DE TRANSPORTE - NOTA FISCAL DE SERVIÇO DE TRANSPORTE (CÓDIGO 07) E CONHECIMENTO DE TRANSPORTE RODOVIÁRIO DE CARGAS (CÓDIGO 08), CONHECIMENTO DE TRANSPORTE DE CARGAS AVULSO (CÓDIGO 8B), AQUAVIÁRIO DE CARGAS (CÓDIGO 09), AÉREO (CÓDIGO 10),FERROVIÁRIO DE CARGAS (CÓDIGO 11),MULTIMODAL DE CARGAS (CÓDIGO 26), NOTA FISCAL DE TRASNPORTE FERROVIÁRIO DE CARGA (CÓDIGO 27) E CONHECIMENTO DE TRANSPORTE ELETRÔNICO - CT-e (CÓDIGO 57)
//sped_efd_pis_registro_D101(); //COMPLEMENTO DO DOCUMENTO DE TRANSPORTE (CÓDIGO 07,08,8B,09,10,11,26,27 E 57) - PIS/PASEP
//sped_efd_pis_registro_D111(); //PROCESSO REFERENCIADO
//sped_efd_pis_registro_D200(); //RESUMO DA ESCRITURAÇÃO DIÁRIA -  PRESTAÇÃO DE SERVIÇO DE TRANSPORTE  - NOTA FISCAL DE SERVIÇO DE TRANSPORTE (CÓDIGO 07) E CONHECIMENTO DE TRANSPORTE RODOVIÁRIO DE CARGAS (CÓDIGO 08), CONHECIMENTO DE TRANSPORTE DE CARGAS AVULSO(CÓDIGO 8B),AQUAVIÁRIA DE CARGAS (CÓDIGO 09), AÉREA (CÓDIGO 10),FERROVIÁRIA DE CARGAS (CÓDIGO 11), MULTIMODAL DE CARGA(CÓDIGO 26), NOTA FISCAL DE TRANSPORTE FERROVIÁRIO DE CARGA (CÓDIGO 27) E CONHECIMENTO DE TRANSPORTE ELETRÔNICO - CT-e (CÓDIGO 57)
//sped_efd_pis_registro_D201(); //TOTALIZADOR DO RESUMO DIÁRIO - PIS/PASEP
//sped_efd_pis_registro_D205(); //TOTALIZADOR DO RESUMO DIÁRIO - COFINS
//sped_efd_pis_registro_D209(); //PROCESSO REFERENCIADO
//sped_efd_pis_registro_D300(); //RESUMO DA ESCRITURAÇÃO DIÁRIA - BILHETES CONSOLIDADOS DE PASSAGEM RODOVIÁRIO (CÓDIGO 13), DE PASSAGEM AQUAVIÁRIO (CÓDIGO 14), DE PASSAGEM E NOTA DE BAGAGEM (CÓDIGO 15), DE PASSAGEM FERROVIÁRIO (CÓDIGO 16) E RESUMO DE MOVIMENTO DIÁRIO (CÓDIGO 18)
//sped_efd_pis_registro_D309(); //PROCESSO REFERENCIADO
//sped_efd_pis_registro_D350(); //RESUMO DIÁRIO DE CUPOM FISCAL EMITIDO POR ECF - (CÓDIGOS 2E,13,14,15 E 16)
//sped_efd_pis_registro_D359(); //PROCESSO REFERENCIADO
//sped_efd_pis_registro_D500(); //NOTA FISCAL DE SERVIÇO DE COMUNICAÇÃO (CÓDIGO 21) E NOTA FISCAL DE SERVIÇO DE TELECOMUNICAÇÃO (CÓDIGO 22) - DOCUMENTOS DE AQUISIÇÃO COM DIREITO A CRÉDITO
//sped_efd_pis_registro_D501(); //COMPLEMENTO DA OPERAÇÃO (CÓDIGO 21 E 22) - PIS/PASEP
//sped_efd_pis_registro_D505(); //COMPLEMENTO DA OPERAÇÃO (CÓDIGO 21 E 22) - COFINS
//sped_efd_pis_registro_D509(); //PROCESSO REFERENCIADO
sped_efd_pis_registro_D600(); //CONSOLIDAÇÃO DA PRESTAÇÃO DE SERVIÇOS - NOTAS DE SERVIÇO DE COMUNICAÇÃO (CÓDIGO 21) E DE SERVIÇO DE TELECOMUNICAÇÃO (CÓDIGO 22)
//sped_efd_pis_registro_D601(); //COMPLEMENTO DA CONSOLIDAÇÃO DA PRESTAÇÃO DE SERVIÇOS (CÓDIGOS 21 E 22) - PIS/PASEP
//sped_efd_pis_registro_D605(); //COMPLEMENTO DA CONSOLIDAÇÃO DA PRESTAÇÃO DE SERVIÇOS (CÓDIGOS 21 E 22) - COFINS
//sped_efd_pis_registro_D609(); //PROCESSO REFERENCIADO
sped_efd_pis_registro_D990(); //ENCERRAMENTO DO BLOCO D

 ECHO "BLOCO D - OK <BR>";
flush();

//ABERTURA DO BLOCO D
//REGISTRO D001: ABERTURA DO BLOCO D
function sped_efd_pis_registro_D001(){
         global $qtd_lin_D,$info_segmento,$info_cnpj_segmento,$fp,$qtde_linha_bloco_d,$REG_BLC,$tot_D001;
         global $TLANCAMENTOS,$CONTLANCAMENTOS,$perdtos1,$perdtos2,$lanperiodo1,$lanperiodo2,$filtromodeloD;

         $reg='D001';
         $ind_mov='1';
         $filtromodeloD="and (modelo='07' or modelo='08' or modelo='8B' or modelo='09' or modelo='21' or modelo='22' or modelo='27' or modelo='57')";
         $xsqlx="SELECT cnpjcpfseg from $TLANCAMENTOS WHERE ((data >= $perdtos1) and (data <= $perdtos2)) and lan_impostos<>'S' and contac<>'' $filtromodeloD group by cnpjcpfseg order by cnpjcpfseg";

         $seleD001 = mysql_query("$xsqlx",$CONTLANCAMENTOS);
         if (mysql_num_rows($seleD001)>0) {
              $ind_mov='0';
         }
	$qtd_lin_D++;

         $linha='|'.$reg.'|'.$ind_mov.'|';

         _matriz_linha($linha);

         $tot_registro_bloco++;
         $REG_BLC[]='|D001|'. $tot_registro_bloco.'|';


         // Caso haja matriz e filial
         while ( $pseleD001 = mysql_fetch_assoc($seleD001) ) {
                $info_cnpj_segmento=$pseleD001[cnpjcpfseg];

              // D010: IDENTIFICAÇÃO DO ESTABELECIMENTO
              sped_efd_pis_registro_D010($info_cnpj_segmento);

         }
         return;

}



//REGISTRO D010: IDENTIFICAÇÃO DO ESTABELECIMENTO
function sped_efd_pis_registro_D010(){
         global $qtd_lin_D,$info_segmento,$info_cnpj_segmento,$fp,$REG_BLC,$tot_D010;

         $reg='D010';
	$qtd_lin_D++;
         $linha='|'.$reg.'|'.$info_cnpj_segmento.'|';
         _matriz_linha($linha);

         $tot_registro_bloco++;
         $REG_BLC[]='|D010|'.$tot_registro_bloco.'|';
	      

         sped_efd_pis_registro_D100($info_cnpj_segmento);

         sped_efd_pis_registro_D500();

         return;

}

// MODELOS 07 - NF DE SERVIÇO DE TRANSPORTE
// MODELO 08 - CONHEC. DE TRANSPORTE RODOVIARIO DE CARGAS
// MODELO 8B - CONHEC. DE TRANSPORTE DE CARGA AVULSO
// MODELO 09 - AQUAVIARIO DE CARGAS
// MODELO 10 - AÉREO
// MODELO 11 - FERROVIÁRIO DE CARGAS
// MODELO 26 - MULTIMODAL DE CARGAS
// MODELO 27 - NF DE TRANSP. FERROVIÁRIO DE CARGA
// MODELO 57 - CONHEC. DE TRANSPORTE ELETRÔNICO CT-e
function sped_efd_pis_registro_D100() {
                global $qtd_lin_D,$info_segmento,$fp,$qtde_linha_bloco_d,$REG_BLC,$tot_D100;
                global $TLANCAMENTOS,$CONTLANCAMENTOS_TMP,$filtromovimento,$filtroconsulta,$TCNPJCPF,$CONTCNPJCPF,$ordem ,$tordem,$TNFDOCUMENTOS,$CONTNFDOCUMENTOS,$info_cnpj_segmento,$TITEM_FLUXO,$CONTITEM_FLUXO,$perdtos1,$perdtos2;
                global $tot_registro_bloco_D100;

                $tordem          = 'ASC';
                $ordem          = 'documento';
                $filtromodeloD100="and (modelo='07' or modelo='08' or modelo='8B' or modelo='09' or modelo='10' or modelo='11' or modelo='26' or modelo='27' or modelo='57')";
                $xsqlx="SELECT * from $TLANCAMENTOS where cnpjcpfseg='$info_cnpj_segmento'  and ((data >= $perdtos1) and (data <= $perdtos2)) and lan_impostos<>'S' $filtromodeloD100 group by dono order by id";

                $seldiferedono=mysql_query($xsqlx,$CONTLANCAMENTOS_TMP) or die (mysql_error());

                while ( $pdono = mysql_fetch_assoc($seldiferedono) ) {
                       if (substr($pdono[dono],0,3)=='LAN' and $pdono[valor]<>0) {
                          $n++;
                          $dono=$pdono[dono];

                          // Chave da nfe para nota de emissão propria
                          $gerar_id='';
                          $sel_chvnfe_nfdocumentos = mysql_query("SELECT dono,gerar_id FROM $TNFDOCUMENTOS WHERE (dono='$dono') group by dono",$CONTNFDOCUMENTOS);
                          while ( $chvdono = mysql_fetch_assoc($sel_chvnfe_nfdocumentos) ) {
                                  $gerar_id=$chvdono['gerar_id'];
                          }
                          //Fim chave da nfe

                          $sel_existe_nfdocumentos=mysql_query("SELECT cfop,sum(vbc_iss) as svbc_iss,valiq_iss,sum(vissqn) as svissqn,sum(voutro) as svoutro,sum(vseg) as svseg,sum(vbc) as svbc,sum(vicms) as svicms,sum(vbcst) as svbcst,sum(vicmsst) as svicmsst,sum(vipi) as svipi,sum(vpis) as svpis,sum(vcofins) as svcofins,sum(vfrete) as svfrete,sum(vdesc) as svdesc,sum(vprod) as svprod,sum(vpisst) as svpisst,sum(vcofinsst) as svcofinsst FROM $TITEM_FLUXO WHERE dono='$dono' group by dono order by data",$CONTITEM_FLUXO);

                          If (@mysql_num_rows($sel_existe_nfdocumentos)) {
                              $info_nfdocumentos= mysql_fetch_assoc($sel_existe_nfdocumentos);
                          }ELSE{
                              //echo "Não encontrado registro C100 para $dono - $TNFDOCUMENTOS em (sped_funcoes)!".'<br>';
                          }

                          $modelo=$pdono[modelo];
                          $filtromodelo="($modelo=='07' or $modelo=='08' or $modelo=='8B' or $modelo=='09' or $modelo=='10' or $modelo=='11' or $modelo=='26' or $modelo=='27' or $modelo=='57')";
                          IF ($filtromodelo) {

                                    $ind_oper=( $pdono[movimento]=='RECEITAS')  ? '1' : '0';
                                    $ind_emit=( $pdono[movimento]=='RECEITAS')  ? '0' : '1';  // se for receitas ,emissão propria

                                	/*
									$cod_sit
									00 Documento regular
									01 Documento regular extemporâneo
									02 Documento cancelado
									03 Documento cancelado extemporâneo
									04 NF-e ou CT-e denegado
									05 NF-e ou CT-e  Numeração inutilizada
									06 Documento Fiscal Complementar
									07 Documento Fiscal Complementar extemporâneo.
									08 Documento Fiscal emitido com base em Regime Especial ou Norma Específica

									*/

								    $cod_sit=(empty($pdono[cod_sit]))  ? '00' : $pdono[cod_sit];  // se for receitas ,emissão propria
								    $dt_doc=_myfunc_ddmmaaaa(_myfunc_stod($pdono[data]));
								    $dt_e_s=_myfunc_ddmmaaaa(_myfunc_stod($pdono[data]));
								    $ind_pgto='1';
									/*
									Indicador do tipo de pagamento:
									0- À vista;
									1- A prazo;
									9- Sem pagamento.
								    */
                                    $vl_doc=$info_nfdocumentos[svprod]+$info_nfdocumentos[svfrete]+$info_nfdocumentos[svseg]+$info_nfdocumentos[svicmsst]+$info_nfdocumentos[svipi]+$info_nfdocumentos[svoutro];
                                    $vl_doc=number_format(abs($vl_doc), 2, ",", "");
                                    if ($vl_doc==0) {
                                       $vl_doc='0';
                                       $ind_pgto='9';
                                    }
                                    $vl_desc=$info_nfdocumentos[svdesc];
                                    $vl_desc=number_format(abs($vl_desc), 2, ",", "");
                                    if ($vl_desc==0) {
                                       $vl_desc='0';
                                    }
                                    $vl_serv=$info_nfdocumentos[svprod];
                                    $vl_serv=number_format(abs($vl_serv), 2, ",", "");
                                    if ($vl_serv==0) {
                                       $vl_serv='0';
                                    }

                                    $vl_frt=$info_nfdocumentos[svfrete];
                                    $vl_frt=number_format(abs($vl_frt), 2, ",", "")  ;
                                    if ($vl_frt==0) {
                                       $vl_frt='0';
                                       $ind_frt='9';
                                    }

                                    $vl_seg=$info_nfdocumentos[svseg];
                                    $vl_seg=number_format(abs($vl_seg), 2, ",", "");
                                    if ($vl_seg==0) {
                                       $vl_seg='0';
                                    }


                                    $vl_out_da=$info_nfdocumentos[svoutro];
                                    $vl_out_da=number_format(abs($vl_out_da), 2, ",", "");
                                    if ($vl_out_da==0) {
                                       $vl_out_da='0';
                                    }

                                    $vl_icms=$info_nfdocumentos[svicms];
                                    if ($vl_icms==0) {
                                       $vl_icms='0';
                                    }else{
                                       $vl_icms=number_format(abs($vl_icms), 2, ",", "");
                                    }

                                    $vl_nt='0';
                                    $vl_terc='0';
                                    $vl_da='0';

                                    $vl_bc_icms=$info_nfdocumentos[svbc];
                                    $vl_bc_icms_nfdocumentos=$vl_bc_icms; // para verificar bc_icms em outros registros
                                    if ($vl_bc_icms==0 or $vl_icms=='0') {
                                        $vl_bc_icms='0';
                                        $vl_serv_nt=$vl_doc;
                                    }else{
                                        $vl_bc_icms=number_format(abs($vl_bc_icms), 2, ",", "");
                                    }


                                    $vl_bc_icms_st=$info_nfdocumentos[svbcst];
                                    if ($vl_bc_icms_st==0) {
                                       $vl_bc_icms_st='0';
                                    }else{
                                       $vl_bc_icms_st=number_format(abs($vl_bc_icms_st), 2, ",", "");
                                    }

                                    $vl_icms_st=$info_nfdocumentos[svicmsst];
                                    if ($vl_icms_st==0) {
                                       $vl_icms_st='0';
                                    }else{
                                       $vl_icms_st=number_format(abs($vl_icms_st), 2, ",", "");
                                    }

                                    $vl_ipi=$info_nfdocumentos[svipi];
                                    if ($vl_ipi==0) {
                                       $vl_ipi='0';
                                    }else{
                                       $vl_ipi=number_format(abs($vl_ipi), 2, ",", "");
                                    }

                                    $xxcnpjcpf=$pdono[cnpjcpf];
                                    $documento=_apenas_numeros($pdono[documento]);
                                    if ($xxcnpjcpf==''){
                                       echo '<br> * Documento '.$documento.' sem cnpjcpf ,dono '.$dono;
                                    }

                                   // REG, IND_OPER, IND_EMIT, COD_MOD, COD_SIT, SER e NUM_DOC
                                   // REG, IND_OPER, IND_EMIT, COD_MOD, COD_SIT, SER , NUM_DOC,COD_INF,COD_CTA
                                    if (preg_match("/$cod_sit/", "02030405")) {
                                        $xxcnpjcpf='';
                                        $dt_doc='';
                                        $dt_e_s='';
                                        $vl_doc='';
                                        $ind_pgto='';
                                        $vl_desc='';
                                        $vl_serv='';
                                        $ind_frt='';
                                        $vl_bc_icms='';
                                        $vl_icms='';
                                        $vl_nt='';
                                        $cod_inf='';
                                        $cod_cta='';
                                    }
                                    $sub='';
                                    $tp_ct_e=''; //Tipo do conh. transporte eletronico
                                    if($modelo=='57'){
                                       $tp_ct_e='0'; //Tipo do conh. transporte eletronico
                                    }
                                    $chv_cte_ref=''; //Chave do ct-e cujos valores foram complementados

                                    $reg='D100';
	$qtd_lin_D++;
                                    $linha1='|'.$reg.'|'.$ind_oper.'|'.$ind_emit.'|'.$xxcnpjcpf.'|'.$modelo.'|'.$cod_sit.'|'.$pdono[serie].'|'.$sub.'|'.$documento.'|'.$gerar_id.'|'.$dt_doc.'|'.$dt_e_s.'|';
                                    $linha2=$tp_ct_e.'|'.$chv_cte_ref.'|'.$vl_doc.'|'.$vl_desc.'|'.$ind_frt.'|'.$vl_serv.'|'.$vl_bc_icms.'|'.$vl_icms.'|'.$vl_nt.'|'.$cod_inf.'|'.$cod_cta.'|';
                                    $linha="$linha1"."$linha2";

                                    _matriz_linha($linha);
                                    $tot_registro_bloco++;

                                   // D101  filho -3 (D101)
                                   //REGISTRO D101: COMPLTO DO DOC. DE TRANSPORTE(CÓDIGO 07,08,8B,09,10,11,26,27 E 57).
                                   // PIS/PASEP
                                   sped_efd_pis_registro_d101($dono);

                                   // D105  filho -3 (D101)
                                   //REGISTRO D105: COMPLTO DO DOC. DE TRANSPORTE(ÓDIGO 07,08,8B,09,10,11,26,27 E 57).
                                   // COFINS
                                   sped_efd_pis_registro_d105($dono);

							}

                   }

                   $REG_BLC[]='|D100|'.$tot_registro_bloco.'|';


                }


                return;
}

// REGISTRO D101:  COMPLEMENTO DA OPERAÇÃO DE TRANSPORTE(CÓDIGO 07,08,8B,09,10,11,26,27 E 57).
// PIS/PASEP
// n:4
function sped_efd_pis_registro_d101($xdono) {
                         global $qtd_lin_D,$vl_bc_pis_tot_m105,$vl_bc_cofins_tot_m105,$info_segmento,$fp,$qtde_linha_bloco_d,$REG_BLC,$tot_D101;
                         global $TITEM_FLUXO,$CONTITEM_FLUXO,$info_cnpj_segmento,$perdtos1,$perdtos2,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS;

                         $xsql_d="select dono,cprod,sum(vprod) as vvprod,sum(vfrete) as vvfrete,sum(vseg) as vvseg,sum(voutro) as vvoutro,sum(vicmsst) as vvicmsst,sum(vipi) as vvipi,sum(vdesc) as vvdesc,cst_pis,sum(vbc_pis) as vvbc_pis,ppis,sum(vpis) as vvpis FROM $TITEM_FLUXO where dono='$xdono' group by cprod,cst_pis order by cprod,cst_pis";

                         $selunidade_d = mysql_query("$xsql_d",$CONTITEM_FLUXO);
                         while ( $punidade_d = mysql_fetch_assoc($selunidade_d) ) {

                              $cod_item=$punidade_d[cprod];

                              $vl_item=($punidade_d[vvprod]+$punidade_d[vvfrete]+$punidade_d[vvseg]+$punidade_d[vvipi]+$punidade_d[vvicmsst]+$punidade_d[vvoutro])-$punidade_d[vvdesc];
                              //$vl_item=_myfunc_valor_base_pis_cofins($punidade_d);
                               if ($vl_item==0) {
                                   $vl_item='0';
                               }else{
                                   $vl_item=number_format(abs($vl_item), 2, ",", "")  ;
                               }

                               $ind_nat_frt='2'; //Indicador da Natureza do frete contratado

                               $nat_bc_cred='03'; //Código da base de cálculo do crédito,conforme tabela 4.3.7
                               //01	Aquisição de bens para revenda
                               //02	Aquisição de bens utilizados como insumo
                               //03	Aquisição de serviços utilizados como insumo
                               //04	Energia eletrica utilizada nos estabelecimento da pessoa jurídica

                               $cst_pis=$punidade_d[cst_pis];
                               $vl_bc_pis=$punidade_d[vvbc_pis];
                               $vl_bc_pis_tot_m105=$vl_bc_pis_tot_m105+$vl_bc_pis; // para registros M505
                               if ($vl_bc_pis==0) {
                                   $vl_bc_pis='0';
                               }else{
                                   $vl_bc_pis=number_format(abs($vl_bc_pis), 2, ",", "")  ;
                               }

                               $aliq_pis=$punidade_d[ppis];
                               if ($aliq_pis==0) {
                                   $aliq_pis='0';
                               }else{
                                   $aliq_pis=number_format(abs($aliq_pis), 2, ",", "")  ;
                               }

                               $vl_pis=$punidade_d[vvpis];
                               if ($vl_pis==0) {
                                   $vl_pis='0';
                               }else{
                                   $vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;
                               }

                               $cod_cta='';
                               $reg='D101';
                               	$qtd_lin_D++;
                               $linha='|'.$reg.'|'.$ind_nat_frt.'|'.$vl_item.'|'.$cst_pis.'|'.$nat_bc_cred.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$vl_pis.'|'.$cod_cta.'|';
                                _matriz_linha($linha);

                               $tot_registro_bloco++;
                               $REG_BLC[]='|D101|'.$tot_registro_bloco.'|';
                              

                         }

                         return;
}


//COMPLEMENTO DO DOCUMENTO DE TRANSPORTE (CÓDIGO 07,08,8B,09,10,11,26,27 E 57) - COFINS
// REGISTRO D105:  COMPLEMENTO DA OPERAÇÃO DE TRANSPORTE(CÓDIGO 07,08,8B,09,10,11,26,27 E 57).
// COFINS
// n:4
function sped_efd_pis_registro_d105($xdono) {
                         global $qtd_lin_D,$vl_bc_pis_tot_m505,$vl_bc_cofins_tot_m505,$info_segmento,$fp,$qtde_linha_bloco_d,$REG_BLC,$tot_D105;
                         global $TITEM_FLUXO,$CONTITEM_FLUXO,$info_cnpj_segmento,$perdtos1,$perdtos2,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS;

                         $xsql_d="select dono,cprod,sum(vprod) as vvprod,sum(vfrete) as vvfrete,sum(vseg) as vvseg,sum(voutro) as vvoutro,sum(vicmsst) as vvicmsst,sum(vipi) as vvipi,sum(vdesc) as vvdesc,cst_cofins,sum(vbc_cofins) as vvbc_cofins,pcofins,sum(vcofins) as vvcofins FROM $TITEM_FLUXO where dono='$xdono' group by cprod,cst_cofins order by cprod,cst_cofins";

                         $selunidade_d = mysql_query("$xsql_d",$CONTITEM_FLUXO);
                         while ( $punidade_d = mysql_fetch_assoc($selunidade_d) ) {

                              $cod_item=$punidade_d[cprod];

                              $vl_item=($punidade_d[vvprod]+$punidade_d[vvfrete]+$punidade_d[vvseg]+$punidade_d[vvipi]+$punidade_d[vvicmsst]+$punidade_d[vvoutro])-$punidade_d[vvdesc];
                               if ($vl_item==0) {
                                   $vl_item='0';
                               }else{
                                   $vl_item=number_format(abs($vl_item), 2, ",", "")  ;
                               }

                               $ind_nat_frt='2'; //Indicador da Natureza do Frete Contratado

                               $nat_bc_cred='03'; //Código da base de cálculo do crédito,conforme tabela 4.3.7
                               //01	Aquisição de bens para revenda
                               //02	Aquisição de bens utilizados como insumo
                               //03	Aquisição de serviços utilizados como insumo
                               //04	Energia eletrica utilizada nos estabelecimento da pessoa jurídica

                               $cst_cofins=$punidade_d[cst_cofins];
                               $vl_bc_cofins=$punidade_d[vvbc_cofins];
                               $vl_bc_pis_tot_m505=$vl_bc_pis_tot_m505+$vl_bc_cofins; // para registros M505
                               if ($vl_bc_cofins==0) {
                                   $vl_bc_cofins='0';
                               }else{
                                   $vl_bc_cofins=number_format(abs($vl_bc_cofins), 2, ",", "")  ;
                               }

                               $aliq_cofins=$punidade_d[pcofins];
                               if ($aliq_cofins==0) {
                                   $aliq_cofins='0';
                               }else{
                                   $aliq_cofins=number_format(abs($aliq_cofins), 2, ",", "")  ;
                               }

                               $vl_cofins=$punidade_d[vvcofins];
                               if ($vl_cofins==0) {
                                   $vl_cofins='0';
                               }else{
                                   $vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;
                               }

                               $cod_cta='';
                               $reg='D105';
                               $linha='|'.$reg.'|'.$ind_nat_frt.'|'.$vl_item.'|'.$cst_cofins.'|'.$nat_bc_cred.'|'.$vl_bc_cofins.'|'.$aliq_cofins.'|'.$vl_cofins.'|'.$cod_cta.'|';
                               _matriz_linha($linha);
	$qtd_lin_D++;
                               $tot_registro_bloco++;
                               $REG_BLC[]='|D105|'.$tot_registro_bloco.'|';
                               

                         }

                         return;
}

//PROCESSO REFERENCIADO
function sped_efd_pis_registro_D111(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_D111;

   $reg='D111';

   $num_proc='';
   $tamanho60=60;
   $num_proc=_myfunc_espaco_a_direita($num_proc,$tamanho60);

   $ind_proc='';

   $linha='|'.$reg.'|'.$num_proc.'|'.$ind_proc.'|';
   $qtde_linha_bloco_D111++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_D111=$total_registro_bloco;

   $REG_BLC[]='|D111|'.$total_registro_bloco.'|';
   return;

}

//RESUMO DA ESCRITURAÇÃO -  PRESTAÇÃO DE SERVIÇO DE TRANSPORTE  - NOTA FISCAL DE SERVIÇO DE TRANSPORTE (CÓDIGO 07) E CONHECIMENTO DE TRANSPORTE RODOVIÁRIO DE CARGAS (CÓDIGO 08), CONHECIMENTO DE TRANSPORTE DE CARGAS AVULSO(CÓDIGO 8B),AQUAVIÁRIA DE CARGAS (CÓDIGO 09), AÉREA (CÓDIGO 10),FERROVIÁRIA DE CARGAS (CÓDIGO 11), MULTIMODAL DE CARGA(CÓDIGO 26), NOTA FISCAL DE TRANSPORTE FERROVIÁRIO DE CARGA (CÓDIGO 27) E CONHECIMENTO DE TRANSPORTE ELETRÔNICO - CT-e (CÓDIGO 57)
function sped_efd_pis_registro_D200(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_D200,$TITEM_FLUXO,$TLANCAMENTOS;

    $sql=mysql_query("SELECT a.dono,a.cfop,
b.modelo,b.cod_sit,b.serie,b.documento,b.datacad,b.valor,b.dono,b.cnpjcpf,b.movimento FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b where a.dono=b.dono and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and (b.modelo='07' or b.modelo='08' or b.modelo='8B' or b.modelo='09' or b.modelo='10' or b.modelo='11' or b.modelo='26' or b.modelo='27' or b.modelo='57') and a.movimento='RECEITAS' group by b.dono order by b.data");

    while ($v=mysql_fetch_assoc($sql)) {

           $cod_mod=$v['modelo'];
           $tamanho2=2;
           $cod_mod=_myfunc_espaco_a_direita($cod_mod,$tamanho2);

           $cod_sit=$v['cod_sit'];
           $tamanho4=4;
           $cod_sit=_myfunc_zero_a_esquerda($cod_sit,$tamanho4) ;

           $ser=$v['serie'];
           $tamanho4=4;
           $ser=_myfunc_espaco_a_direita($ser,$tamanho4);

           $sub='';
           $tamanho3=3;
           $sub=_myfunc_espaco_a_direita($sub,$tamanho3);

           $num_doc_ini=$v['documento'];
           $tamanho9=9;
           $num_doc_ini=_myfunc_zero_a_esquerda($num_doc_ini,$tamanho9) ;

           $num_doc_fin=$v['documento'];
           $tamanho9=9;
           $num_doc_fin=_myfunc_zero_a_esquerda($num_doc_fin,$tamanho9) ;

           $cfop=$v['cfop'];
           $tamanho4=4;
           $cfop=_myfunc_zero_a_esquerda($cfop,$tamanho4) ;

           $dt_ref=$v['datacad'];
           $dt_ref=_myfunc_stod($dt_ref);
           $dt_ref=_myfunc_ddmmaaaa($dt_ref);

           $vl_doc=$v['valor'];
           $vl_doc=number_format(abs($vl_doc), 2, ",", "")  ;

           $vl_desc=$v['vdesc'];
           $vl_desc=number_format(abs($vl_desc), 2, ",", "")  ;


$linha='|D200|'.$cod_mod.'|'.$cod_sit.'|'.$ser.'|'.$sub.'|'.$num_doc_ini.'|'.$num_doc_fin.'|'.$cfop.'|'.$dt_ref.'|'.$vl_doc.'|'.$vl_desc.'|';
                 $qtde_linha_bloco_D200++ ;
                 $escreve = fwrite($fp, "$linha\r\n");
                 $total_registro_bloco=$total_registro_bloco+1;
                 $tot_D200=$total_registro_bloco;
    }

        $REG_BLC[]='|D200|'.$tot_D200.'|';
        return;
}

//TOTALIZADOR DO RESUMO DIÁRIO - PIS/PASEP
function sped_efd_pis_registro_D201(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_D201,$TITEM_FLUXO,$TLANCAMENTOS;

        $sql=mysql_query("SELECT sum(a.vprod) as vprod,sum(a.vpis) as vpis,a.cst_pis,sum(a.vbc_pis) as vbc_pis,sum(a.ppis) as ppis,b.codnat,b.data,b.modelo FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b where a.dono=b.dono and a.cnpjcpfseg='$info_cnpj_segmento' and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and (b.modelo='07' or b.modelo='08' or b.modelo='8B' or b.modelo='09' or b.modelo='10' or b.modelo='11' or b.modelo='26' or b.modelo='27' or b.modelo='57') and vpis<>'0.00' and a.movimento='RECEITAS' order by a.dono,a.id");

       while ($v=mysql_fetch_assoc($sql)) {

              $cst_pis=$v['cst_pis'];
              $tamanho2=2;
              $cst_pis=_myfunc_zero_a_esquerda($cst_pis,$tamanho2) ;

              $vl_item=$v['vprod'];
              $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

              $vl_bc_pis=$v['vbc_pis'];
              $vl_bc_pis=number_format(abs($vl_bc_pis), 2, ",", "")  ;

              $aliq_pis=$v['ppis'];
              $tamanho8=8;
              $aliq_pis=_myfunc_zero_a_esquerda($aliq_pis,$tamanho8) ;
              $aliq_pis=number_format(abs($aliq_pis), 4, ",", "")  ;

              $vl_pis=$v['vpis'];
              $vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;

              $cod_cta='';
              $tamanho60=60;
              $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);


       $linha='|D201|'.$cst_pis.'|'.$vl_item.'|'.$nat_bc_cred.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$vl_pis.'|'.$cod_cta.'|';
                 $qtde_linha_bloco_D201++ ;
                 $escreve = fwrite($fp, "$linha\r\n");
                 $total_registro_bloco=$total_registro_bloco+1;
                 $tot_D201=$total_registro_bloco;
    }

        $REG_BLC[]='|D201|'.$total_registro_bloco.'|';
        return;
}

//TOTALIZADOR DO RESUMO DIÁRIO - COFINS
function sped_efd_pis_registro_D205(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_D205,$TITEM_FLUXO,$TLANCAMENTOS;

        $sql=mysql_query("SELECT sum(a.vprod) as vprod,sum(a.vcofins) as vcofins,a.cst_cofins,sum(a.vbc) as vbc,sum(a.pcofins) as pcofins,b.codnat,b.data,b.modelo FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b where a.dono=b.dono and a.cnpjcpfseg='$info_cnpj_segmento' and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and (b.modelo='07' or b.modelo='08' or b.modelo='8B' or b.modelo='09' or b.modelo='10' or b.modelo='11' or b.modelo='26' or b.modelo='27' or b.modelo='57') and a.vcofins<>'0.00' and a.movimento='RECEITAS' order by a.dono,a.id");

       while ($v=mysql_fetch_assoc($sql)) {

              $cst_cofins=$v['cst_cofins'];
              $tamanho2=2;
              $cst_cofins=_myfunc_zero_a_esquerda($cst_cofins,$tamanho2) ;


              $vl_item=$v['vprod'];
              $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

              $vl_bc_cofins=$v['vbc_cofins'];
              $vl_bc_cofins=number_format(abs($vl_bc_cofins), 2, ",", "")  ;

              $aliq_cofins=$v['pcofins'];
              $tamanho8=8;
              $aliq_cofins=_myfunc_zero_a_esquerda($aliq_cofins,$tamanho8) ;
              $aliq_cofins=number_format(abs($aliq_cofins), 4, ",", "")  ;

              $vl_cofins=$v['vcofins'];
              $vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;

              $cod_cta='';
              $tamanho60=60;
              $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);

       $linha='|D205|'.$cst_cofins.'|'.$vl_item.'|'.$vl_bc_cofins.'|'.$aliq_cofins.'|'.$vl_cofins.'|'.$cod_cta.'|';
                 $qtde_linha_bloco_D205++ ;
                 $escreve = fwrite($fp, "$linha\r\n");
                 $total_registro_bloco=$total_registro_bloco+1;
                 $tot_D205=$total_registro_bloco;
    }

        $REG_BLC[]='|D205|'.$total_registro_bloco.'|';
        return;
}

//PROCESSO REFERENCIADO
function sped_efd_pis_registro_D209(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_D209;

   $reg='D209';

   $num_proc='';
   $tamanho20=20;
   $num_proc=_myfunc_espaco_a_direita($num_proc,$tamanho20);

   $ind_proc='';

   $linha='|'.$reg.'|'.$num_proc.'|'.$ind_proc.'|';
   $qtde_linha_bloco_D209++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_D209=$total_registro_bloco;

   $REG_BLC[]='|D209|'.$total_registro_bloco.'|';
   return;

}

//RESUMO DA ESCRITURAÇÃO DIÁRIA - BILHETES CONSOLIDADOS DE PASSAGEM RODOVIÁRIO (CÓDIGO 13), DE PASSAGEM AQUAVIÁRIO (CÓDIGO 14), DE PASSAGEM E NOTA DE BAGAGEM (CÓDIGO 15), DE PASSAGEM FERROVIÁRIO (CÓDIGO 16) E RESUMO DE MOVIMENTO DIÁRIO (CÓDIGO 18)
function sped_efd_pis_registro_D300(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_D300,$TITEM_FLUXO,$TLANCAMENTOS;

$sql=mysql_query("SELECT a.dono,a.cfop,a.cst_pis,a.cst_cofins,a.vbc_pis,a.vbc_cofins,a.ppis,a.pcofins,a.vpis,a.vcofins,sum(a.vdesc) as vdesc,b.modelo,b.cod_sit,b.serie,b.documento,b.datacad,b.data,b.valor,b.dono,b.cnpjcpf,b.movimento FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b where a.dono=b.dono and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 and a.movimento='RECEITAS' and (b.modelo='13' or b.modelo='14' or b.modelo='15' or b.modelo='16' or b.modelo='18') group by b.dono order by b.data");

   while ($v=mysql_fetch_assoc($sql)) {

          $cod_mod=$v['modelo'];
          $tamanho2=2;
          $cod_mod=_myfunc_espaco_a_direita($cod_mod,$tamanho2);

          $ser=$v['serie'];
          $tamanho4=4;
          $ser=_myfunc_espaco_a_direita($ser,$tamanho4);

          $sub='';
          $tamanho3=3;
          $sub=_myfunc_zero_a_esquerda($sub,$tamanho3) ;

          $num_doc_ini=$v['documento'];
          $tamanho6=6;
          $num_doc_ini=_myfunc_zero_a_esquerda($num_doc_ini,$tamanho6) ;

          $num_doc_fin=$v['documento'];
          $tamanho6=6;
          $num_doc_fin=_myfunc_zero_a_esquerda($num_doc_fin,$tamanho6) ;

          $cfop=$v['cfop'];
          $tamanho4=4;
          $cfop=_myfunc_zero_a_esquerda($cfop,$tamanho4) ;

          $dt_ref=$v['data'];
          $dt_ref=_myfunc_stod($dt_ref);
          $dt_ref=_myfunc_ddmmaaaa($dt_ref);

          $vl_doc=$v['valor'];
          $vl_doc=number_format(abs($vl_doc), 2, ",", "")  ;

          $vl_desc=$v['vdesc'];
          $vl_desc=number_format(abs($vl_desc), 2, ",", "")  ;

          $cst_pis=$v['cst_pis'];
          $tamanho2=2;
          $cst_pis=_myfunc_zero_a_esquerda($cst_pis,$tamanho2) ;

          $vl_bc_pis=$v['vbc_pis'];
          $vl_bc_pis=number_format(abs($vl_bc_pis), 2, ",", "")  ;

          $aliq_pis=$v['ppis'];
          $tamanho8=8;
          $aliq_pis=_myfunc_zero_a_esquerda($aliq_pis,$tamanho8) ;
          $aliq_pis=number_format(abs($aliq_pis), 4, ",", "")  ;

          $vl_pis=$v['vpis'];
          $vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;

          $cst_cofins=$v['cst_cofins'];

          $vl_bc_cofins=$v['vbc_cofins'];
          $vl_bc_cofins=number_format(abs($vl_bc_cofins), 2, ",", "")  ;

          $aliq_cofins=$v['pcofins'];
          $tamanho8=8;
          $aliq_cofins=_myfunc_zero_a_esquerda($aliq_cofins,$tamanho8) ;
          $aliq_cofins=number_format(abs($aliq_cofins), 4, ",", "")  ;

          $vl_cofins=$v['vcofins'];
          $vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;

          $cod_cta='';
          $tamanho60=60;
          $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);

$linha='|D300|'.$cod_mod.'|'.$ser.'|'.$sub.'|'.$num_doc_ini.'|'.$num_doc_fin.'|'.$cfop.'|'.$dt_ref.'|'.$vl_doc.'|'.$vl_des.'|'.$cst_pis.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$vl_pis.'|'.$cst_cofins.'|'.$vl_bc_cofins.'|'.$aliq_cofins.'|'.$vl_cofins.'|'.$cod_cta.'|';
                 $qtde_linha_bloco_D300++ ;
                 $escreve = fwrite($fp, "$linha\r\n");
                 $total_registro_bloco=$total_registro_bloco+1;
                 $tot_D300=$total_registro_bloco;
    }

        $REG_BLC[]='|D300|'.$tot_D300.'|';
        return;
}


//PROCESSO REFERENCIADO
function sped_efd_pis_registro_D309(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_D309;

   $reg='D309';

   $num_proc='';
   $tamanho20=20;
   $num_proc=_myfunc_espaco_a_direita($num_proc,$tamanho20);

   $ind_proc='';

   $linha='|'.$reg.'|'.$num_proc.'|'.$ind_proc.'|';
   $qtde_linha_bloco_D309++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_D309=$total_registro_bloco;

   $REG_BLC[]='|D309|'.$total_registro_bloco.'|';
   return;
}

//RESUMO DIÁRIO DE CUPOM FISCAL EMITIDO POR ECF - (CÓDIGOS 2E,13,14,15 E 16)
function sped_efd_pis_registro_D350(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_D350;

   $reg='D350';

   $cod_mod='';
   $tamanho2=2;
   $cod_mod=_myfunc_espaco_a_direita($cod_mod,$tamanho2);

   $ecf_mod='';
   $tamanho20=20;
   $ecf_mod=_myfunc_espaco_a_direita($ecf_mod,$tamanho20);

   $ecf_fab='';
   $tamanho20=20;
   $ecf_fab=_myfunc_espaco_a_direita($ecf_fab,$tamanho20);


   $dt_doc='';
   $dt_doc=_myfunc_stod($dt_doc);
   $dt_doc=_myfunc_ddmmaaaa($dt_doc);

   $cro='';
   $tamanho3=3;
   $cro=_myfunc_zero_a_esquerda($cro,$tamanho3) ;

   $crz='';
   $tamanho6=6;
   $crz=_myfunc_zero_a_esquerda($crz,$tamanho6) ;

   $num_coo_fin='';
   $tamanho6=6;
   $num_coo_fin=_myfunc_zero_a_esquerda($num_coo_fin,$tamanho6) ;

   $gt_fin='';
   //$gt_fin=number_format(abs($gt_fin), 2, ",", "")  ;

   $vl_brt='';
   //$vl_brt=number_format(abs($vl_brt), 2, ",", "")  ;

   $cst_pis='';
   $tamanho2=2;
   $cst_pis=_myfunc_zero_a_esquerda($cst_pis,$tamanho2) ;

   $vl_bc_pis='';
   //$vl_bc_pis=number_format(abs($vl_bc_pis), 2, ",", "")  ;

   $aliq_pis='';
   $tamanho8=8;
   $aliq_pis=_myfunc_zero_a_esquerda($aliq_pis,$tamanho8) ;
   //$aliq_pis=number_format(abs($aliq_pis), 4, ",", "")  ;

   $quant_bc_pis='';
   //$quant_bc_pis=number_format(abs($quant_bc_pis), 3, ",", "")  ;

   $aliq_pis_quant='';
   //$aliq_pis_quant=number_format(abs($aliq_pis_quant), 4, ",", "")  ;

   $vl_pis='';
   //$vl_pis=number_format(abs( $vl_pis), 2, ",", "")  ;

   $cst_cofins='';
   $tamanho2=2;
   $cst_cofins=_myfunc_zero_a_esquerda($cst_cofins,$tamanho2) ;

   $vl_bc_cofins='';
   //$vl_bc_cofins=number_format(abs($vl_bc_cofins), 2, ",", "")  ;

   $aliq_cofins='';
   $tamanho8=8;
   $aliq_cofins=_myfunc_zero_a_esquerda($aliq_cofins,$tamanho8) ;
   //$aliq_cofins=number_format(abs($aliq_cofins), 4, ",", "")  ;

   $quant_bc_cofins='';
   //$quant_bc_cofins=number_format(abs($quant_bc_cofins), 3, ",", "")  ;

   $aliq_cofins_quant='';
   //$aliq_cofins_quant=number_format(abs($aliq_cofins_quant), 4, ",", "")  ;


   $vl_cofins='';
   //$vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;

   $cod_cta='';
   $tamanho60=60;
   $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);



   $linha='|'.$reg.'|'.$cod_mod.'|'.$ecf_mod.'|'.$ecf_fab.'|'.$dt_doc.'|'.$cro.'|'.$crz.'|'.$num_coo_fin.'|'.$gt_fin.'|'.$vl_brt.'|'.$cst_pis.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$quant_bc_pis.'|'.$aliq_pis_quant.'|'.$vl_pis.'|'.$cst_cofins.'|'.$vl_bc_cofins.'|'.$aliq_cofins.'|'.$quant_bc_cofins.'|'.$aliq_cofins_quant.'|'.$vl_cofins.'|'.$cod_cta.'|';
   $qtde_linha_bloco_D350++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_D350=$total_registro_bloco;

   $REG_BLC[]='|D350|'.$total_registro_bloco.'|';
   return;

}

//PROCESSO REFERENCIADO
function sped_efd_pis_registro_D359(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_D359;

   $reg='D359';

   $num_proc='';
   $tamanho20=20;
   $num_proc=_myfunc_espaco_a_direita($num_proc,$tamanho20);

   $ind_proc='';

   $linha='|'.$reg.'|'.$num_proc.'|'.$ind_proc.'|';
   $qtde_linha_bloco_D359++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_D359=$total_registro_bloco;

   $REG_BLC[]='|D359|'.$total_registro_bloco.'|';
   return;

}

//	global $qtd_lin_D,$tot_registro_bloco_D501,$tot_registro_bloco_D505,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$TLANCAMENTOS,$TNFDOCUMENTOS,$TITEM_FLUXO;

//NOTA FISCAL DE SERVIÇO DE COMUNICAÇÃO (CÓDIGO 21) E NOTA FISCAL DE SERVIÇO DE TELECOMUNICAÇÃO (CÓDIGO 22) - DOCUMENTOS DE AQUISIÇÃO COM DIREITO A CRÉDITO
function sped_efd_pis_registro_D500() {
                global $qtd_lin_D,$info_segmento,$fp,$qtde_linha_bloco_0,$qtde_linha_bloco_d,$REG_BLC,$tot_D500;
                global $TLANCAMENTOS,$CONTLANCAMENTOS_TMP,$filtromovimento,$filtroconsulta,$TCNPJCPF,$CONTCNPJCPF,$ordem ,$tordem,$TNFDOCUMENTOS,$CONTNFDOCUMENTOS,$info_cnpj_segmento,$TITEM_FLUXO,$CONTITEM_FLUXO,$perdtos1,$perdtos2;

                $tordem          = 'ASC';
                $ordem          = 'documento';
                $filtromodeloD500="and (modelo='21' or modelo='22')";
                $xsqlx="SELECT * from $TLANCAMENTOS where movimento='DESPESAS' and cnpjcpfseg='$info_cnpj_segmento'  and ((data >= $perdtos1) and (data <= $perdtos2)) and lan_impostos<>'S' $filtromodeloD500 group by dono order by id";

                $seldiferedono=mysql_query($xsqlx,$CONTLANCAMENTOS_TMP) or die (mysql_error());

                while ( $pdono = mysql_fetch_assoc($seldiferedono) ) {
                       if (substr($pdono[dono],0,3)=='LAN' and $pdono[valor]<>0) {
                                    $n++;
                                    $dono=$pdono[dono];

                                    // Chave da nfe para nota de emissão propria
                                    $gerar_id='';
                                    $sel_chvnfe_nfdocumentos = mysql_query("SELECT dono,gerar_id FROM $TNFDOCUMENTOS WHERE (dono='$dono') group by dono",$CONTNFDOCUMENTOS);
                                    while ( $chvdono = mysql_fetch_assoc($sel_chvnfe_nfdocumentos) ) {
                                          $gerar_id='';
                                    }
                                    // Fim chave da nfe

                                    $sel_existe_nfdocumentos=mysql_query("SELECT cst_pis,cst_cofins,cfop,sum(vbc_iss) as svbc_iss,valiq_iss,sum(vissqn) as svissqn,sum(voutro) as svoutro,sum(vseg) as svseg,sum(vbc) as svbc,sum(vicms) as svicms,sum(vbcst) as svbcst,sum(vicmsst) as svicmsst,sum(vipi) as svipi,sum(vpis) as svpis,sum(vcofins) as svcofins,sum(vfrete) as svfrete,sum(vdesc) as svdesc,sum(vprod) as svprod,sum(vpisst) as svpisst,sum(vcofinsst) as svcofinsst FROM $TITEM_FLUXO WHERE dono='$dono' group by dono order by data",$CONTITEM_FLUXO);

                                    If (@mysql_num_rows($sel_existe_nfdocumentos)) {
                                        $info_nfdocumentos= mysql_fetch_assoc($sel_existe_nfdocumentos);
                                    }ELSE{
                                        //echo "Não encontrado registro C100 para $dono - $TNFDOCUMENTOS em (sped_funcoes)!".'<br>';
                                    }

                          $modelo=$pdono[modelo];
                          $cst_pis=$info_nfdocumentos[cst_pis];
                          $cst_cofins=$info_nfdocumentos[cst_cofins];
                          $filtromodelo="(($cst_pis=='50' or $cst_pis=='56' or $cst_cofins=='50' or $cst_cofins=='56') and ($modelo=='21' or $modelo=='22'))";
//                          IF ($filtromodelo) {
                                    $ind_oper=($pdono[movimento]=='RECEITAS')  ? '1' : '0';
                                    $ind_emit=($pdono[movimento]=='RECEITAS')  ? '0' : '1';  // se for receitas ,emissão propria

                                	/*
									$cod_sit
									00 Documento regular
									01 Documento regular extemporâneo
									02 Documento cancelado
									03 Documento cancelado extemporâneo
									04 NF-e ou CT-e denegado
									05 NF-e ou CT-e  Numeração inutilizada
									06 Documento Fiscal Complementar
									07 Documento Fiscal Complementar extemporâneo.
									08 Documento Fiscal emitido com base em Regime Especial ou Norma Específica

									*/

								    $cod_sit=(empty($pdono[cod_sit]))  ? '00' : $pdono[cod_sit];  // se for receitas ,emissão propria
								    $dt_doc=_myfunc_ddmmaaaa(_myfunc_stod($pdono[data]));
								    $dt_e_s=_myfunc_ddmmaaaa(_myfunc_stod($pdono[data]));

                                    $vl_doc=$info_nfdocumentos[svprod]+$info_nfdocumentos[svfrete]+$info_nfdocumentos[svseg]+$info_nfdocumentos[svicmsst]+$info_nfdocumentos[svipi]+$info_nfdocumentos[svoutro];
                                    $vl_doc=number_format(abs($vl_doc), 2, ",", "");
                                    if ($vl_doc==0) {
                                       $vl_doc='0';
                                    }
                                    $vl_desc=$info_nfdocumentos[svdesc];
                                    $vl_desc=number_format(abs($vl_desc), 2, ",", "");
                                    if ($vl_desc==0) {
                                       $vl_desc='0';
                                    }
                                    $vl_serv=$info_nfdocumentos[svprod];
                                    $vl_serv=number_format(abs($vl_serv), 2, ",", "");
                                    if ($vl_serv==0) {
                                       $vl_serv='0';
                                    }

                                    $vl_icms=$info_nfdocumentos[svicms];
                                    if ($vl_icms==0) {
                                       $vl_icms='0';
                                    }else{
                                       $vl_icms=number_format(abs($vl_icms), 2, ",", "");
                                    }

                                    $vl_serv_nt='0';
                                    $vl_terc='0';
                                    $vl_da='0';

                                    $vl_bc_icms=$info_nfdocumentos[svbc];
                                    $vl_bc_icms_nfdocumentos=$vl_bc_icms; // para verificar bc_icms em outros registros
                                    if ($vl_bc_icms==0 or $vl_icms=='0') {
                                        $vl_bc_icms='0';
                                        $vl_serv_nt=$vl_doc;
                                    }else{
                                        $vl_bc_icms=number_format(abs($vl_bc_icms), 2, ",", "");
                                    }


                                    $vl_bc_icms_st=$info_nfdocumentos[svbcst];
                                    if ($vl_bc_icms_st==0) {
                                       $vl_bc_icms_st='0';
                                    }else{
                                       $vl_bc_icms_st=number_format(abs($vl_bc_icms_st), 2, ",", "");
                                    }

                                    $vl_pis=$info_nfdocumentos[svpis];
                                    $vl_pis=number_format(abs($vl_pis), 2, ",", "");
                                    if ($vl_pis==0) {
                                       $vl_pis='0';
                                    }

                                    $vl_cofins=$info_nfdocumentos[svcofins];
                                    $vl_cofins=number_format(abs($vl_cofins), 2, ",", "");
                                    if ($vl_cofins==0) {
                                       $vl_cofins='0';
                                    }

                                    $xxcnpjcpf=$pdono[cnpjcpf];
                                    $documento=_apenas_numeros($pdono[documento]);
                                    if ($xxcnpjcpf==''){
                                       echo '<br> * Documento '.$documento.' sem cnpjcpf ,dono '.$dono;
                                    }

                                   // REG, IND_OPER, IND_EMIT, COD_MOD, COD_SIT, SER e NUM_DOC
                                    if (preg_match("/$cod_sit/", "02030405")) {
                                        $xxcnpjcpf='';
                                        $dt_doc='';
                                        $dt_e_s='';
                                        $vl_doc='';
                                        $vl_desc='';
                                        $vl_forn='';
                                        $vl_bc_icms='';
                                        $vl_icms='';
                                        $vl_pis='';
                                        $vl_cofins='';
                                    }
                                    $sub='';
                                    $cod_inf='';

                                    $reg='D500';
                                    $linha1='|'.$reg.'|'.$ind_oper.'|'.$ind_emit.'|'.$xxcnpjcpf.'|'.$modelo.'|'.$cod_sit.'|'.$pdono[serie].'|'.$sub.'|'.$documento.'|'.$dt_doc.'|'.$dt_e_s.'|'.$vl_doc.'|';
                                    $linha2=$vl_desc.'|'.$vl_serv.'|'.$vl_serv_nt.'|'.$vl_terc.'|'.$vl_da.'|';
                                    $linha3=$vl_bc_icms.'|'.$vl_icms.'|'.$cod_inf.'|'.$vl_pis.'|'.$vl_cofins.'|';
                                    $linha="$linha1"."$linha2"."$linha3";
				    $qtd_lin_D++;
                                    _matriz_linha($linha);
                                    $tot_registro_bloco++;

                                   // D501   filho -4 (D501)
                                   //REGISTRO D501: complemento da operação (CÓDIGO 21 E 22).
                                   // PIS/PASEP
                                   sped_efd_pis_registro_d501($dono);

                                   // D505   filho -4 (D505)
                                   //REGISTRO D505: complemento da operação (CÓDIGO 21 E 22).
                                   // COFINS
                                   sped_efd_pis_registro_d505($dono);


							}

                            $REG_BLC[]='|D500|'.$tot_registro_bloco.'|';
//                            $qtd_lin_D=$qtd_lin_D+$tot_registro_bloco;

           //        }

                }


                return;
}


//COMPLEMENTO DA OPERAÇÃO (CÓDIGO 21 E 22) - PIS/PASEP
function sped_efd_pis_registro_d501($xdono) {
                         global $qtd_lin_D,$vl_bc_pis_tot_m105,$vl_bc_cofins_tot_m105,$info_segmento,$fp,$qtde_linha_bloco_d,$REG_BLC,$tot_D501;
                         global $TITEM_FLUXO,$CONTITEM_FLUXO,$info_cnpj_segmento,$perdtos1,$perdtos2,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS;

                         $filtromodelo="((cst_pis='50' or cst_pis='56' or cst_cofins='50' or cst_cofins='56') and dono='$xdono')";
                         $xsql_d="select dono,cprod,sum(vprod) as vvprod,sum(vfrete) as vvfrete,sum(vseg) as vvseg,sum(voutro) as vvoutro,sum(vicmsst) as vvicmsst,sum(vipi) as vvipi,sum(vdesc) as vvdesc,cst_pis,sum(vbc_pis) as vvbc_pis,ppis,sum(vpis) as vvpis FROM $TITEM_FLUXO where $filtromodelo group by cprod,cst_pis order by cprod,cst_pis";
                         
                         //echo "select dono,cprod,sum(vprod) as vvprod,sum(vfrete) as vvfrete,sum(vseg) as vvseg,sum(voutro) as vvoutro,sum(vicmsst) as vvicmsst,sum(vipi) as vvipi,sum(vdesc) as vvdesc,cst_pis,sum(vbc_pis) as vvbc_pis,ppis,sum(vpis) as vvpis FROM $TITEM_FLUXO where $filtromodelo group by cprod,cst_pis order by cprod,cst_pis";

                         $selunidade_d = mysql_query("$xsql_d",$CONTITEM_FLUXO);
                         while ( $punidade_d = mysql_fetch_assoc($selunidade_d) ) {

                              $cod_item=$punidade_d[cprod];


				$vl_item=($punidade_d[vvprod]+$punidade_d[vvfrete]+$punidade_d[vvseg]+$punidade_d[vvicmsst]+$punidade_d[vvipi]+$punidade_d[vvoutro])-$punidade_d[vvdesc];
                          //    $vl_item=_myfunc_valor_base_pis_cofins($punidade_d);  // 13/07/2013
                               if ($vl_item==0) {
                                   $vl_item='0';
                               }else{
                                   $vl_item=number_format(abs($vl_item), 2, ",", "")  ;
                               }

                               $nat_bc_cred='13'; //Código da base de cálculo do crédito,conforme tabela 4.3.7
                               //03	Aquisição de serviços utilizados como insumo
                               //13	Outras operações com direito a crédito

                               $cst_pis=$punidade_d[cst_pis];
                               $vl_bc_pis=$vl_item; //$punidade_d[vvbc_pis];
                               $vl_bc_pis_tot_m105=$vl_bc_pis_tot_m105+$vl_bc_pis; // para registros M505
                               if ($vl_bc_pis==0) {
                                   $vl_bc_pis='0';
                               }else{
                                   $vl_bc_pis=number_format(abs($vl_bc_pis), 2, ",", "")  ;
                               }

                               $aliq_pis=$punidade_d[ppis];
                               if ($aliq_pis==0) {
                                   $aliq_pis='0';
                               }else{
                                   $aliq_pis=number_format(abs($aliq_pis), 2, ",", "")  ;
                               }

                               $vl_pis=$punidade_d[vvpis];
                               if ($vl_pis==0) {
                                   $vl_pis='0';
                               }else{
                                   $vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;
                               }

                               $cod_cta='';
                               
                               $reg='D501';

                               $linha='|'.$reg.'|'.$cst_pis.'|'.$vl_item.'|'.$nat_bc_cred.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$vl_pis.'|'.$cod_cta.'|';
                               _matriz_linha($linha);
                               $tot_registro_bloco++;
                               $REG_BLC[]='|D501|'.$tot_registro_bloco.'|';
                               $qtd_lin_D=$qtd_lin_D+$tot_registro_bloco;

                         }


}

// REGISTRO D505:  COMPLEMENTO DA OPERAÇÃO DE COMUNICAÇÃO(CÓDIGO 21 E 22).
// COFINS
// n:4
function sped_efd_pis_registro_d505($xdono) {
                         global $qtd_lin_D,$vl_bc_pis_tot_m505,$vl_bc_cofins_tot_m505,$info_segmento,$fp,$qtde_linha_bloco_d,$REG_BLC,$tot_D505;
                         global $TITEM_FLUXO,$CONTITEM_FLUXO,$info_cnpj_segmento,$perdtos1,$perdtos2,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS;

                         $filtromodelo="((cst_pis='50' or cst_pis='56' or cst_cofins='50' or cst_cofins='56') and dono='$xdono')";

                         $xsql_d="select dono,cprod,sum(vprod) as vvprod,sum(vfrete) as vvfrete,sum(vseg) as vvseg,sum(voutro) as vvoutro,sum(vicmsst) as vvicmsst,sum(vipi) as vvipi,sum(vdesc) as vvdesc,cst_cofins,sum(vbc_cofins) as vvbc_cofins,pcofins,sum(vcofins) as vvcofins FROM $TITEM_FLUXO where $filtromodelo group by cprod,cst_cofins order by cprod,cst_cofins";

                         $selunidade_d = mysql_query("$xsql_d",$CONTITEM_FLUXO);
                         while ( $punidade_d = mysql_fetch_assoc($selunidade_d) ) {

                              $cod_item=$punidade_d[cprod];

                             
//                              $vl_item=_myfunc_valor_base_pis_cofins($punidade_d);  // 13/07/2013
				$vl_item=($punidade_d[vvprod]+$punidade_d[vvfrete]+$punidade_d[vvseg]+$punidade_d[vvicmsst]+$punidade_d[vvipi]+$punidade_d[vvoutro])-$punidade_d[vvdesc];
                               if ($vl_item==0) {
                                   $vl_item='0';
                               }else{
                                   $vl_item=number_format(abs($vl_item), 2, ",", "")  ;
                               }

                               $nat_bc_cred='13'; //Código da base de cálculo do crédito,conforme tabela 4.3.7
                               //03	Aquisição de serviços utilizados como insumo
                               //13	Outras operações com direito a crédito

                               $cst_cofins=$punidade_d[cst_cofins];
                               $vl_bc_cofins=$vl_item; //$punidade_d[vvbc_cofins];
                               $vl_bc_pis_tot_m505=$vl_bc_pis_tot_m505+$vl_bc_cofins; // para registros M505
                               if ($vl_bc_cofins==0) {
                                   $vl_bc_cofins='0';
                               }else{
                                   $vl_bc_cofins=number_format(abs($vl_bc_cofins), 2, ",", "")  ;
                               }

                               $aliq_cofins=$punidade_d[pcofins];
                               if ($aliq_cofins==0) {
                                   $aliq_cofins='0';
                               }else{
                                   $aliq_cofins=number_format(abs($aliq_cofins), 2, ",", "")  ;
                               }

                               $vl_cofins=$punidade_d[vvcofins];
                               if ($vl_cofins==0) {
                                   $vl_cofins='0';
                               }else{
                                   $vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;
                               }

                               $cod_cta='';
                               $reg='D505';
                               $linha='|'.$reg.'|'.$cst_cofins.'|'.$vl_item.'|'.$nat_bc_cred.'|'.$vl_bc_cofins.'|'.$aliq_cofins.'|'.$vl_cofins.'|'.$cod_cta.'|';

                               _matriz_linha($linha);
                               $tot_registro_bloco++;
                               $REG_BLC[]='|D505|'.$tot_registro_bloco.'|';
                               $qtd_lin_D=$qtd_lin_D+$tot_registro_bloco;

                         }


}

//PROCESSO REFERENCIADO
function sped_efd_pis_registro_D509(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_D509;

   $reg='D509';

   $num_proc='';
   $tamanho20=20;
   $num_proc=_myfunc_espaco_a_direita($num_proc,$tamanho20);

   $ind_proc='';

   $linha='|'.$reg.'|'.$num_proc.'|'.$ind_proc.'|';
   $qtde_linha_bloco_D509++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_D509=$total_registro_bloco;

   $REG_BLC[]='|D509|'.$total_registro_bloco.'|';
   return;

}

//CONSOLIDAÇÃO DA PRESTAÇÃO DE SERVIÇOS - NOTAS DE SERVIÇO DE COMUNICAÇÃO (CÓDIGO 21) E DE SERVIÇO DE TELECOMUNICAÇÃO (CÓDIGO 22)
function sped_efd_pis_registro_D600(){
global $qtd_lin_D,$tot_registro_bloco_D601,$tot_registro_bloco_D605,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$TLANCAMENTOS,$TNFDOCUMENTOS,$TITEM_FLUXO;
	global $TNFDOCUMENTOS_TMP,$TNFDOCUMENTOS,$CONTNFDOCUMENTOS;


	$filtro_lancamentos=" and POSITION(modelo IN ':21:22:') > 0";
        $sql_lancamentos= _myfunc_sql_receitas_despesas_documentos('RECEITAS',"$filtro_lancamentos",'','','');

if (mysql_num_rows($sql_lancamentos)<=0) {
		return;
		}
	$data_menor=999999999999999;
	$data_maior=0;
	$tvl_doc=0.00;
	$tvl_desc=0.00;
	$tvl_serv=0.00;
	 $tvl_bc_icms=0.00;
	 $tvl_icms=0.00;
	$tvl_pis=0.00;
 
$cod_mun=$info_segmento[cod_mun];
	$ind_rec='0';  // receita propria
     $qtd_cons=0;
        while ($v=mysql_fetch_assoc($sql_lancamentos)) {
	    $dono=$v[dono];
	    include('documentos_situacao_erp.php');
		 $cod_mod=$v[modelo];
  		 $ser=$info_nfdocumentos[serie];
		 $sub='';
		if ($info_nfdocumentos[data]>$data_maior) {
	    		$data_maior=$info_nfdocumentos[data];
     		}
	   
		if ($info_nfdocumentos[data]<$data_menor) {
			    $data_menor=$info_nfdocumentos[data];
		}
	  
	 	//$vl_doc=($v[svprod]+$v[svfrete]+$v[svseg]+$v[svicmsst]+$v[svipi]+$v[svoutro])-$v[svdesc];
		$vl_doc=_myfunc_valor_liquido_itens($v);
		$tvl_doc=$tvl_doc+$vl_doc;
		$tvl_desc=$tvl_desc+$v['svdesc'];
		$tvl_serv=$tvl_serv+$v[svprod];
		$tvl_serv_nt=0.00;
		$tvl_terc=0.00;
		$tvl_da=0.00;
	 	$tvl_bc_icms=$tvl_bc_icms+$v[svbc];
		$tvl_icms=$tvl_icms+$v[svicms];
		$tvl_pis=$tvl_pis+$v['svpis'];
		$tvl_cofins=$tvl_cofins+$v['svcofins'];
		$qtd_cons++;

        }

 

   $reg='D600';

 
  

   $ind_rec='0';

 

   $dt_doc_ini='';
   $dt_doc_ini=_myfunc_stod($data_menor);
   $dt_doc_ini=_myfunc_ddmmaaaa($dt_doc_ini);

   $dt_doc_fin='';
   $dt_doc_fin=_myfunc_stod($data_maior);
   $dt_doc_fin=_myfunc_ddmmaaaa($dt_doc_fin);

  
 		   $dt_doc_ini=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo1));
        	   $dt_doc_fin=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo2));
		 

 
  $vl_doc=number_format(abs($tvl_doc), 2, ",", "")  ;

 
   $vl_desc=number_format(abs($tvl_desc), 2, ",", "")  ;
 
  $vl_serv=number_format(abs($tvl_serv), 2, ",", "")  ;

   
    $vl_serv_nt=number_format(abs($tvl_serv_nt), 2, ",", "")  ;
 
   $vl_terc=number_format(abs($tvl_terc), 2, ",", "")  ;

   
   $vl_da=number_format(abs($tvl_da), 2, ",", "")  ;
 
   $vl_bc_icms=number_format(abs($tvl_bc_icms), 2, ",", "")  ;
 
   $vl_icms=number_format(abs($tvl_icms), 2, ",", "")  ;

   $vl_pis=number_format(abs($tvl_pis), 2, ",", "")  ;
 
   $vl_cofins=number_format(abs($tvl_cofins), 2, ",", "")  ;

   $linha='|'.$reg.'|'.$cod_mod.'|'.$cod_mun.'|'.$ser.'|'.$sub.'|'.$ind_rec.'|'.$qtd_cons.'|'.$dt_doc_ini.'|'.$dt_doc_fin.'|'.$vl_doc.'|'.$vl_desc.'|'.$vl_serv.'|'.$vl_serv_nt.'|'.$vl_terc.'|'.$vl_da.'|'.$vl_bc_icms.'|'.$vl_icms.'|'.$vl_pis.'|'.$vl_cofins.'|';
  _matriz_linha($linha);
	   $tot_registro_bloco++;

	
	   // D601 filho
		sped_efd_pis_registro_D601();  // agrupa todos

   // D605 filho
	sped_efd_pis_registro_D605();



                                   
 
          $REG_BLC[]='|D600|'.$tot_registro_bloco.'|';
	   $qtd_lin_D=$qtd_lin_D+$tot_registro_bloco;

          $REG_BLC[]='|D601|'.$tot_registro_bloco_D601.'|';
	   $qtd_lin_D=$qtd_lin_D+$tot_registro_bloco_D601;
 		 
          $REG_BLC[]='|D605|'.$tot_registro_bloco_D605.'|';
	   $qtd_lin_D=$qtd_lin_D+$tot_registro_bloco_D605;

 	 

          return ;

}


//COMPLEMENTO DA CONSOLIDAÇÃO DA PRESTAÇÃO DE SERVIÇOS (CÓDIGOS 21 E 22) - PIS/PASEP
function sped_efd_pis_registro_D601(){
 	global $qtd_lin_D,$tot_registro_bloco_D601,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$TLANCAMENTOS,$TNFDOCUMENTOS,$TITEM_FLUXO;
	global $TNFDOCUMENTOS_TMP,$TNFDOCUMENTOS,$CONTNFDOCUMENTOS;
	$filtro_lancamentos=" and POSITION(modelo IN ':21:22:') > 0";
        $sql_lancamentos= _myfunc_sql_receitas_despesas_documentos('RECEITAS',"$filtro_lancamentos",'','a.cst_pis,a.ppis','');
 
    while ($v=mysql_fetch_assoc($sql_lancamentos)) {


	    $dono=$v[dono];
	    include('documentos_situacao_erp.php');
 

  	    $reg='D601';
	    $cod_class='0102'; // assinatura de servico de comunicacao
	    $vl_item=$v[svprod];
	    $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

if ($vl_desc==0) {
$vl_desc='';
}else{
  $vl_desc=number_format(abs($vl_desc), 2, ",", "")  ;
}

  $cst_pis=$v[cst_pis];
	$vl_bc_pis=$v['svbc_pis'];
	$vl_bc_pis=number_format($vl_bc_pis, 2, ',', '');

	  $alq_pis=$v[ppis];
  	  $alq_pis=number_format(abs($alq_pis), 2, ",", "")  ;

     $vl_pis=$v['svpis'];
	    $vl_pis=number_format($vl_pis, 2, ',', '');
  $cod_cta='';
 
   $linha='|'.$reg.'|'.$cod_class.'|'.$vl_item.'|'.$vl_desc.'|'.$cst_pis.'|'.$vl_bc_pis.'|'.$alq_pis.'|'.$vl_pis.'|'.$cod_cta.'|';
   

 	  		_matriz_linha($linha);
	   		$tot_registro_bloco_D601++;

 }
   return;
}

//COMPLEMENTO DA CONSOLIDAÇÃO DA PRESTAÇÃO DE SERVIÇOS (CÓDIGOS 21 E 22) - COFINS
function sped_efd_pis_registro_D605(){
 	global $qtd_lin_D,$tot_registro_bloco_D605,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$TLANCAMENTOS,$TNFDOCUMENTOS,$TITEM_FLUXO;
	global $TNFDOCUMENTOS_TMP,$TNFDOCUMENTOS,$CONTNFDOCUMENTOS;
	$filtro_lancamentos=" and POSITION(modelo IN ':21:22:') > 0";
        $sql_lancamentos= _myfunc_sql_receitas_despesas_documentos('RECEITAS',"$filtro_lancamentos",'','a.cst_cofins,a.pcofins','');
 
    while ($v=mysql_fetch_assoc($sql_lancamentos)) {


	    $dono=$v[dono];
	    include('documentos_situacao_erp.php');
 

  	    $reg='D605';
	    $cod_class='0102';
	    $vl_item=$v[svprod];
	    $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

  $vl_desc=$v[svdesc];
if ($vl_desc==0) {
$vl_desc='';
}else{
  $vl_desc=number_format(abs($vl_desc), 2, ",", "")  ;
}

  $cst_cofins=$v[cst_cofins];
	$vl_bc_cofins=$v['svbc_cofins'];
	$vl_bc_cofins=number_format($vl_bc_cofins, 2, ',', '');

	  $alq_cofins=$v[pcofins];
  	  $alq_cofins=number_format(abs($alq_cofins), 2, ",", "")  ;

     $vl_cofins=$v['svcofins'];
	    $vl_cofins=number_format($vl_cofins, 2, ',', '');
  $cod_cta='';
 
   $linha='|'.$reg.'|'.$cod_class.'|'.$vl_item.'|'.$vl_desc.'|'.$cst_cofins.'|'.$vl_bc_cofins.'|'.$alq_cofins.'|'.$vl_cofins.'|'.$cod_cta.'|';
   

 	  		_matriz_linha($linha);
	   		$tot_registro_bloco_D605++;

 }
   return;
}

//PROCESSO REFERENCIADO
function sped_efd_pis_registro_D609(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_D609;

   $reg='D609';

   $num_proc='';
   $tamanho20=20;
   $num_proc=_myfunc_espaco_a_direita($num_proc,$tamanho20);

   $ind_proc='';


   $linha='|'.$reg.'|'.$num_proc.'|'.$ind_proc.'|';
   $qtde_linha_bloco_D609++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_D609=$total_registro_bloco;

   $REG_BLC[]='|D609|'.$total_registro_bloco.'|';
   return;

}
//ENCERRAMENTO DO BLOCO D
 
function sped_efd_pis_registro_D990(){
    global $qtd_lin_D,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC;
     
    $reg='D990';
          $qtd_lin_D++;
    $linha='|'.$reg.'|'. $qtd_lin_D.'|';
         
    _matriz_linha($linha);
        
   // $tot_registro_bloco++;
    $REG_BLC[]='|D990|'.$qtd_lin_D.'|';
    return ;
 

}

 






sped_efd_pis_registro_F001(); //ABERTURA DO BLOCO F
sped_efd_pis_registro_F010(); //IDENTIFICAÇÃO DO ESTABELICIMENTO
//sped_efd_pis_registro_F100(); //DEMAIS DOCUMENTOS E OPERAÇÕES GERADAS DE CONTRIBUINDO E CRÉDITOS
//sped_efd_pis_registro_F111(); //PROCESSO REFERENCIADO
//sped_efd_pis_registro_F120(); //BENS INCORPORADOS AO ATIVO IMOBILIZADO - OPERAÇÕES GERADOS DE CRÉDITOS COM BASE NOS ENCARGOS DE DEPRECIAÇÃO E AMORTIZAÇÃO
//sped_efd_pis_registro_F129(); //PROCESSO REFERENCIADO
//sped_efd_pis_registro_F130(); //BENS INCORPORADOS AO ATIVO IMOBILIZADO - OPERAÇÕES GERADAS DE CRÉDITOS COM BASE NO VALOR DE AQUISIÇÃO/CONTRIBUIÇÃO
//sped_efd_pis_registro_F139(); //PROCESSO REFERENCIADO
//sped_efd_pis_registro_F150(); //CRÉDITO PRESUMIDO SOBRE O ESTOQUE DE ABERTURA
//sped_efd_pis_registro_F200(); //OPERAÇÕES DA ATIVIDADE IMOBILIÁRIA - UNIDADE IMOBILIÁRIA VENDIDA
//sped_efd_pis_registro_F205(); //OPERAÇÕES DA ATIVIDADE IMOBILIÁRIA - CUSTO INCORRIDO DA UNIDADE IMOBILIÁRIA
//sped_efd_pis_registro_F210(); //OPERAÇÕES DA ATIVIDADE IMOBILIÁRIA - CUSTO ORÇADO DA UNIDADE IMOBILIÁRIA VENDIDA
//sped_efd_pis_registro_F211(); //PROCESSO REFERENCIADO
//sped_efd_pis_registro_F600(); //CONTRIBUIÇÃO RETIDA NA FONTE
//sped_efd_pis_registro_F700(); //DEDUÇÕES DIVERSAS
//sped_efd_pis_registro_F800(); //CRÉDITOS DECORRENTES DE EVENTOS DE INCORPORAÇÃO, FUSÃO E CISÃO
sped_efd_pis_registro_F990(); //ENCERRAMENTO DO BLOBO F

ECHO "BLOCO F - OK <BR>";
flush();
  
 //ABERTURA DO BLOCO F
function sped_efd_pis_registro_F001(){
global $qtd_lin_F,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC ;

   $reg='F001';
   
   $ind_mov='0'; //0 - com dados e 1 - sem dados.

   $linha='|'.$reg.'|'.$ind_mov.'|';
    _matriz_linha($linha);
        
          $tot_registro_bloco++;
          $REG_BLC[]='|F001|'.$tot_registro_bloco.'|';
	   $qtd_lin_F=$qtd_lin_F+$tot_registro_bloco;
          return ;
   return;
}
//IDENTIFICAÇÃO DO ESTABELECIMENTO
function sped_efd_pis_registro_F010(){
global $qtd_lin_F,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC ;

   $reg='F010';

   $cnpj=$info_segmento['cnpjcpf'];
   
   $linha='|'.$reg.'|'.$cnpj.'|';
     _matriz_linha($linha);
        
          $tot_registro_bloco++;
          $REG_BLC[]='|F010|'.$tot_registro_bloco.'|';
	   $qtd_lin_F=$qtd_lin_F+$tot_registro_bloco;
          return ;
   
}

//DEMAIS DOCUMENTOS E OPERAÇÕES GERADAS DE CONTRIBUINDO E CRÉDITOS
function sped_efd_pis_registro_F100(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_F100;

   $reg='F100';

   $ind_oper='';

   $cod_part='';
   $tamanho60=60;
   $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);

   $cod_item='';
   $tamanho60=60;
   $cod_item=_myfunc_espaco_a_direita($cod_item,$tamanho60);

   $dt_oper='';
   $dt_oper=_myfunc_stod($dt_oper);
   $dt_oper=_myfunc_ddmmaaaa($dt_oper);

   $vl_oper='';
   //$vl_oper=number_format(abs($vl_oper), 2, ",", "")  ;

   $cst_pis='';
   $tamanho2=2;
   $cst_pis=_myfunc_espaco_a_direita($cst_pis,$tamanho2);

   $vl_bc_pis='';
   //$vl_bc_pis=number_format(abs($vl_bc_pis), 4, ",", "")  ;

   $aliq_pis='';
   $tamanho8=8;
   $aliq_pis=_myfunc_zero_a_esquerda($aliq_pis,$tamanho8) ;
   //$aliq_pis=number_format(abs($aliq_pis), 4, ",", "")  ;

   $vl_pis='';
   //$vl_pis=number_format(abs($vl_pis), 4, ",", "")  ;

   $cst_cofins='';
   $tamanho2=2;
   $cst_cofins=_myfunc_zero_a_esquerda($cst_cofins,$tamanho2) ;

   $vl_bc_cofins='';
   //$vl_bc_cofins=number_format(abs($vl_bc_cofins), 4, ",", "")  ;

   $aliq_cofins='';
   $tamanho8=8;
   $aliq_cofins=_myfunc_zero_a_esquerda($aliq_cofins,$tamanho8) ;
   $aliq_cofins=number_format(abs($aliq_cofins), 4, ",", "")  ;

   $vl_cofins='';
   //$vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;

                    $nat_bc_cred='13'; //  ??????

/*
01 Aquisição de bens para revenda
02 Aquisição de bens utilizados como insumo
04 Energia elétrica utilizada nos estabelecimentos da pessoa jurídica
13 Outras operações com direito a crédito
*/
   $tamanho2=2;
   $nat_bc_cred=_myfunc_espaco_a_direita($nat_bc_cred,$tamanho2);

   $ind_orig_cred='';

   $cod_cta='';
   $tamanho60=60;
   $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);

   $cod_ccus='';
   $tamanho60=60;
   $cod_ccus=_myfunc_espaco_a_direita($cod_ccus,$tamanho60);

   $desc_doc_oper='';
   $linha='|'.$reg.'|'.$ind_oper.'|'.$cod_part.'|'.$cod_item.'|'.$dt_oper.'|'.$vl_oper.'|'.$cst_pis.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$vl_pis.'|'.$cst_cofins.'|'.$vl_bc_cofins.'|'.$aliq_cofins.'|'.$vl_cofins.'|'.$nat_bc_cred.'|'.$ind_orig_cred.'|'.$cod_cta.'|'.$cod_ccus.'|'.$desc_doc_oper.'|';
   $qtde_linha_bloco_F100++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=1;
   $tot_F100=$total_registro_bloco;

   $REG_BLC[]='|F100|'.$total_registro_bloco.'|';
   return;

}

//PROCESSO REFERENCIADO
function sped_efd_pis_registro_F111(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_F111;

   $reg='F111';

   $num_proc='';
   $tamanho20=20;
   $num_proc=_myfunc_espaco_a_direita($num_proc,$tamanho20);

   $ind_proc='';

   $linha='|'.$reg.'|'.$num_proc.'|'.$ind_proc.'|';
   $qtde_linha_bloco_F111++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_F111=$total_registro_bloco;

   $REG_BLC[]='|F111|'.$total_registro_bloco.'|';
   return;

}

//BENS INCORPORADOS AO ATIVO IMOBILIZADO - OPERAÇÕES GERADOS DE CRÉDITOS COM BASE NOS ENCARGOS DE DEPRECIAÇÃO E AMORTIZAÇÃO
function sped_efd_pis_registro_F120(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_F120;

   $reg='F120';

                   $nat_bc_cred='13'; //  ??????

/*
01 Aquisição de bens para revenda
02 Aquisição de bens utilizados como insumo
04 Energia elétrica utilizada nos estabelecimentos da pessoa jurídica
13 Outras operações com direito a crédito
*/
   $tamanho2=2;
   $nat_bc_cred=_myfunc_espaco_a_direita($nat_bc_cred,$tamanho2);

   $ident_bem_imob='';
   $tamanho2=2;
   $ident_bem_imob=_myfunc_zero_a_esquerda($ident_bem_imob,$tamanho2) ;

   $ind_orig_cred='';

   $ind_util_bem_imob='';

   $vl_oper_dep='';
   //$vl_oper_dep=number_format(abs($vl_oper_dep), 2, ",", "")  ;

   $parc_oper_nao_bc_cred='';
   //$parc_oper_nao_bc_cred=number_format(abs($parc_oper_nao_bc_cred), 2, ",", "")  ;

   $cst_pis='';
   $tamanho2=2;
   $cst_pis=_myfunc_zero_a_esquerda($cst_pis,$tamanho2) ;

   $vl_bc_pis='';
   //$vl_bc_pis=number_format(abs($vl_bc_pis), 2, ",", "")  ;

   $alq_pis='';
   $tamanho8=8;
   $aliq_pis=_myfunc_zero_a_esquerda($aliq_pis,$tamanho8) ;
   $aliq_pis=number_format(abs($aliq_pis), 4, ",", "")  ;

   $vl_pis='';
   //$vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;

   $cst_cofins='';
   $tamanho2=2;
   $cst_cofins=_myfunc_zero_a_esquerda($cst_cofins,$tamanho2) ;

   $vl_bc_cofins='';
   //$vl_bc_cofins=number_format(abs($vl_bc_cofins), 2, ",", "")  ;

   $aliq_cofins='';
   $tamanho8=8;
   $aliq_cofins=_myfunc_zero_a_esquerda($aliq_cofins,$tamanho8) ;
   $aliq_cofins=number_format(abs($aliq_cofins), 4, ",", "")  ;

   $vl_cofins='';
   //$vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;

   $cod_cta='';
   $tamanho60=60;
   $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);

   $cod_ccus='';
   $tamanho60=60;
   $cod_ccus=_myfunc_espaco_a_direita($cod_ccus,$tamanho60);

   $desc_bem_imob='';

   $linha='|'.$reg.'|'.$nat_bc_cred.'|'.$ident_bem_imob.'|'.$ind_orig_cred.'|'.$ind_util_bem_imob.'|'.$vl_oper_dep.'|'.$parc_oper_nao_bc_cred.'|'.$cst_pis.'|'.$vl_bc_pis.'|'.$alq_pis.'|'.$vl_pis.'|'.$cst_cofins.'|'.$vl_bc_cofins.'|'.$aliq_cofins.'|'.$vl_cofins.'|'.$cod_cta.'|'.$cod_ccus.'|'.$desc_bem_imob.'|';
   $qtde_linha_bloco_F120++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_F120=$total_registro_bloco;

   $REG_BLC[]='|F120|'.$total_registro_bloco.'|';
   return;

}

//PROCESSO REFERENCIADO
function sped_efd_pis_registro_F129(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_F129;

   $reg='F129';

   $num_proc='';
   $tamanho20=20;
   $num_proc=_myfunc_espaco_a_direita($num_proc,$tamanho20);

   $ind_proc='';

   $linha='|'.$reg.'|'.$num_proc.'|'.$ind_proc.'|';
   $qtde_linha_bloco_F129++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_F129=$total_registro_bloco;

   $REG_BLC[]='|F129|'.$total_registro_bloco.'|';
   return;
}

//BENS INCORPORADOS AO ATIVO IMOBILIZADO - OPERAÇÕES GERADAS DE CRÉDITOS COM BASE NO VALOR DE AQUISIÇÃO/CONTRIBUIÇÃO
function sped_efd_pis_registro_F130(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_F130;

   $reg='F130';

                   $nat_bc_cred='13'; //  ??????

/*
01 Aquisição de bens para revenda
02 Aquisição de bens utilizados como insumo
04 Energia elétrica utilizada nos estabelecimentos da pessoa jurídica
13 Outras operações com direito a crédito
*/
   $tamanho2=2;
   $nat_bc_cred=_myfunc_espaco_a_direita($nat_bc_cred,$tamanho2);

   $ident_bem_imob='';
   $tamanho2=2;
   $ident_bem_imob=_myfunc_zero_a_esquerda($ident_bem_imob,$tamanho2) ;

   $ind_orig_cred='';

   $ind_util_bem_imob='';

   $mes_oper_aquis='';
   $tamanho2=2;
   $mes_oper_aquis=_myfunc_zero_a_esquerda($mes_oper_aquis,$tamanho2) ;

   $vl_oper_aquis='';
   //$vl_oper_aquis=number_format(abs($vl_oper_aquis), 2, ",", "")  ;

   $parc_oper_nao_bc_cred='';
   //$parc_oper_nao_bc_cred=number_format(abs($parc_oper_nao_bc_cred), 2, ",", "")  ;

   $vl_bc_cred='';
   //$vl_bc_cred=number_format(abs($vl_bc_cred), 2, ",", "")  ;

   $ind_nr_parc='';

   $cst_pis='';
   $tamanho2=2;
   $cst_pis=_myfunc_zero_a_esquerda($cst_pis,$tamanho2) ;

   $vl_bc_pis='';
   //$vl_bc_pis=number_format(abs($vl_bc_pis), 2, ",", "")  ;

   $aliq_pis='';
   $tamanho8=8;
   $aliq_pis=_myfunc_zero_a_esquerda($aliq_pis,$tamanho8) ;
   //$aliq_pis=number_format(abs($aliq_pis), 4, ",", "")  ;

   $vl_pis='';
   //$vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;

   $cst_cofins='';
   $tamanho2=2;
   $cst_cofins=_myfunc_zero_a_esquerda($cst_cofins,$tamanho2) ;

   $vl_bc_cofins='';
   //$vl_bc_cofins=number_format(abs($vl_bc_cofins), 2, ",", "")  ;

   $aliq_cofins='';
   $tamanho8=8;
   $aliq_cofins=_myfunc_zero_a_esquerda($aliq_cofins,$tamanho8) ;
   //$aliq_cofins=number_format(abs($aliq_cofins), 4, ",", "")  ;

   $vl_cofins='';
   //$vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;

   $cod_cta='';
   $tamanho60=60;
   $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);

   $cod_ccus='';
   $tamanho60=60;
   $cod_ccus=_myfunc_espaco_a_direita($cod_ccus,$tamanho60);

   $desc_bem_imob='';

   $linha='|'.$reg.'|'.$nat_bc_cred.'|'.$ident_bem_imob.'|'.$ind_orig_cred.'|'.$ind_util_bem_imob.'|'.$mes_oper_aquis.'|'.$vl_oper_aquis.'|'.$parc_oper_nao_bc_cred.'|'.$vl_bc_cred.'|'.$ind_nr_parc.'|'.$cst_pis.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$vl_pis.'|'.$cst_cofins.'|'.$vl_bc_cofins.'|'.$aliq_cofins.'|'.$vl_cofins.'|'.$cod_cta.'|'.$cod_ccus.'|'.$desc_bem_imob.'|';
   $qtde_linha_bloco_F130++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_F130=$total_registro_bloco;

   $REG_BLC[]='|F130|'.$total_registro_bloco.'|';
   return;

}

//PROCESSO REFERENCIADO
function sped_efd_pis_registro_F139(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_F139;

   $reg='F139';

   $num_proc='';
   $tamanho20=20;
   $num_proc=_myfunc_espaco_a_direita($num_proc,$tamanho20);

   $ind_proc='';

   $linha='|'.$reg.'|'.$num_proc.'|'.$ind_proc.'|';
   $qtde_linha_bloco_F139++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_F139=$total_registro_bloco;

   $REG_BLC[]='|F139|'.$total_registro_bloco.'|';
   return;
}

//CRÉDITO PRESUMIDO SOBRE O ESTOQUE DE ABERTURA
function sped_efd_pis_registro_F150(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_F150;

   $reg='F150';

                   $nat_bc_cred='13'; //  ??????

/*
01 Aquisição de bens para revenda
02 Aquisição de bens utilizados como insumo
04 Energia elétrica utilizada nos estabelecimentos da pessoa jurídica
13 Outras operações com direito a crédito
*/
   $tamanho2=2;
   $nat_bc_cred=_myfunc_espaco_a_direita($nat_bc_cred,$tamanho2);

   $vl_tot_est='';
   //$vl_tot_est=number_format(abs($vl_tot_est), 2, ",", "")  ;

   $est_imp='';
   //$est_imp=number_format(abs($est_imp), 2, ",", "")  ;

   $vl_bc_est='';
   //$vl_bc_est=number_format(abs($vl_bc_est), 2, ",", "")  ;

   $vl_bc_men_est='';
   //$vl_bc_men_est=number_format(abs($vl_bc_men_est), 2, ",", "")  ;

   $cst_pis='';
   $tamanho2=2;
   $cst_pis=_myfunc_zero_a_esquerda($cst_pis,$tamanho2) ;

   $aliq_pis='';
   $tamanho8=8;
   $aliq_pis=_myfunc_zero_a_esquerda($aliq_pis,$tamanho8) ;
   //$aliq_pis=number_format(abs($aliq_pis), 4, ",", "")  ;

   $vl_cred_pis='';
   //$vl_cred_pis=number_format(abs($vl_cred_pis), 2, ",", "")  ;

   $cst_cofins='';
   $tamanho2=2;
   $cst_cofins=_myfunc_zero_a_esquerda($cst_cofins,$tamanho2) ;

   $aliq_cofins='';
   $tamanho8=8;
   $aliq_cofins=_myfunc_zero_a_esquerda($aliq_cofins,$tamanho8) ;
   //$aliq_cofins=number_format(abs($aliq_cofins), 4, ",", "")  ;

   $vl_cred_cofins='';
   //$vl_cred_cofins=number_format(abs($vl_cred_cofins), 2, ",", "")  ;

   $desc_est='';
   $tamanho100=100;
   $desc_est=_myfunc_espaco_a_direita($desc_est,$tamanho100);

   $cod_cta='';
   $tamanho60=60;
   $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);

   $linha='|'.$reg.'|'.$nat_bc_cred.'|'.$vl_tot_est.'|'.$est_imp.'|'.$vl_bc_est.'|'.$vl_bc_men_est.'|'.$cst_pis.'|'.$aliq_pis.'|'.$vl_cred_pis.'|'.$cst_cofins.'|'.$aliq_cofins.'|'.$vl_cred_cofins.'|'.$desc_est.'|'.$cod_cta.'|';
   $qtde_linha_bloco_F150++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_F150=$total_registro_bloco;

   $REG_BLC[]='|F150|'.$total_registro_bloco.'|';
   return;

}


//OPERAÇÕES DA ATIVIDADE IMOBILIÁRIA - UNIDADE IMOBILIÁRIA VENDIDA
function sped_efd_pis_registro_F200(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_F200;

   $reg='F200';

   $ind_oper='';
   $tamanho2=2;
   $ind_oper=_myfunc_zero_a_esquerda($ind_oper,$tamanho2) ;

   $unid_imob='';
   $tamanho2=2;
   $unid_imob=_myfunc_zero_a_esquerda($unid_imob,$tamanho2) ;

   $ident_emp='';

   $desc_unid_imob='';
   $tamanho90=90;
   $desc_unid_imob=_myfunc_espaco_a_direita($desc_unid_imob,$tamanho90);

   $num_cont='';
   $tamanho90=90;
   $num_cont=_myfunc_espaco_a_direita($num_cont,$tamanho90);

   $cpf_cnpj_adqu='';
   $tamanho14=14;
   $cpf_cnpj_adqu=_myfunc_espaco_a_direita($cpf_cnpj_adqu,$tamanho14);

   $dt_oper='';
   $dt_oper=_myfunc_stod($dt_oper);
   $dt_oper=_myfunc_ddmmaaaa($dt_oper);

   $vl_tot_vend='';
   //$vl_tot_vend=number_format(abs($vl_tot_vend), 2, ",", "")  ;

   $vl_rec_acum='';
   //$vl_rec_acum=number_format(abs($vl_rec_acum), 2, ",", "")  ;

   $vl_tot_rec='';
   //$vl_tot_rec=number_format(abs($vl_tot_rec), 2, ",", "")  ;

   $cst_pis='';
   $tamanho2=2;
   $cst_pis=_myfunc_zero_a_esquerda($cst_pis,$tamanho2) ;

   $vl_bc_pis='';
   //$vl_bc_pis=number_format(abs($vl_bc_pis), 2, ",", "")  ;

   $aliq_pis='';
   $tamanho8=8;
   $aliq_pis=_myfunc_zero_a_esquerda($aliq_pis,$tamanho8) ;
   //$aliq_pis=number_format(abs($aliq_pis), 4, ",", "")  ;

   $vl_pis='';
   //$vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;

   $cst_cofins='';
   $tamanho2=2;
   $cst_cofins=_myfunc_zero_a_esquerda($cst_cofins,$tamanho2) ;

   $vl_bc_cofins='';
   //$vl_bc_cofins=number_format(abs($vl_bc_cofins), 2, ",", "")  ;

   $aliq_cofins='';
   $tamanho8=8;
   $aliq_cofins=_myfunc_zero_a_esquerda($aliq_cofins,$tamanho8) ;
   $aliq_cofins=number_format(abs($aliq_cofins), 4, ",", "")  ;

   $vl_cofins='';
   //$vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;

   $perc_rec_receb='';
   $tamanho6=6;
   $perc_rec_receb=_myfunc_zero_a_esquerda($perc_rec_receb,$tamanho6) ;
   $perc_rec_receb=number_format(abs($perc_rec_receb), 2, ",", "")  ;

   $ind_nat_emp='';

   $inf_comp='';
   $tamanho90=90;
   $inf_comp=_myfunc_espaco_a_direita($inf_comp,$tamanho90);


$linha='|'.$reg.'|'.$ind_oper.'|'.$unid_imob.'|'.$ident_emp.'|'.$desc_unid_imob.'|'.$num_cont.'|'.$cpf_cnpj_adqu.'|'.$dt_oper.'|'.$vl_tot_vend.'|'.$vl_rec_acum.'|'.$vl_tot_rec.'|'.$cst_pis.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$vl_pis.'|'.$cst_cofins.'|'.$vl_bc_cofins.'|'.$aliq_cofins.'|'.$vl_cofins.'|'.$perc_rec_receb.'|'.$ind_nat_emp.'|'.$inf_comp.'|';
   $qtde_linha_bloco_F200++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_F200=$total_registro_bloco;

   $REG_BLC[]='|F200|'.$total_registro_bloco.'|';
   return;

}


//OPERAÇÕES DA ATIVIDADE IMOBILIÁRIA - CUSTO INCORRIDO DA UNIDADE IMOBILIÁRIA
function sped_efd_pis_registro_F205(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_F205;

   $reg='F205';

   $vl_cus_inc_acum_ant='';
   //$vl_cus_inc_acum_ant=number_format(abs($vl_cus_inc_acum_ant), 2, ",", "")  ;

   $vl_cus_inc_per_esc='';
   //$vl_cus_inc_per_esc=number_format(abs($vl_cus_inc_per_esc), 2, ",", "")  ;

   $vl_cus_inc_acum='';
   //$vl_cus_inc_acum=number_format(abs($vl_cus_inc_acum), 2, ",", "")  ;

   $vl_exc_bc_cus_inc_acum='';
   //$vl_exc_bc_cus_inc_acum=number_format(abs($vl_exc_bc_cus_inc_acum), 2, ",", "")  ;

   $vl_bc_cus_inc='';
   //$vl_bc_cus_inc=number_format(abs($vl_bc_cus_inc), 2, ",", "")  ;

   $cst_pis='';
   $tamanho2=2;
   $cst_pis=_myfunc_zero_a_esquerda($cst_pis,$tamanho2) ;

   $aliq_pis='';
   $tamanho8=8;
   $aliq_pis=_myfunc_zero_a_esquerda($aliq_pis,$tamanho8) ;
   //$aliq_pis=number_format(abs($aliq_pis), 4, ",", "")  ;

   $vl_cred_pis_acum='';
   //$vl_cred_pis_acum=number_format(abs($vl_cred_pis_acum), 2, ",", "")  ;

   $vl_cred_pis_desc_ant='';
   //$vl_cred_pis_desc_ant=number_format(abs($vl_cred_pis_desc_ant), 2, ",", "")  ;

   $vl_cred_pis_desc='';
   //$vl_cred_pis_desc=number_format(abs($vl_cred_pis_desc), 2, ",", "")  ;

   $vl_cred_pis_desc_fut='';
   //$vl_cred_pis_desc_fut=number_format(abs($vl_cred_pis_desc_fut), 2, ",", "")  ;

   $cst_cofins='';
   $tamanho2=2;
   $cst_cofins=_myfunc_zero_a_esquerda($cst_cofins,$tamanho2) ;

   $aliq_cofins='';
   $tamanho8=8;
   $aliq_cofins=_myfunc_zero_a_esquerda($aliq_cofins,$tamanho8) ;
   //$aliq_cofins=number_format(abs($aliq_cofins), 4, ",", "")  ;

   $vl_cred_cofins_acum='';
   //$vl_cred_cofins_acum=number_format(abs($vl_cred_cofins_acum), 2, ",", "")  ;

   $vl_cred_cofins_desc_ant='';
   //$vl_cred_cofins_desc_ant=number_format(abs($vl_cred_cofins_desc_ant), 2, ",", "")  ;

   $vl_cred_cofins_desc='';
  //$vl_cred_cofins_desc=number_format(abs($vl_cred_pis_desc), 2, ",", "")  ;

   $vl_cred_cofins_desc_fut='';
   //$vl_cred_cofins_desc_fut=number_format(abs($vl_cred_cofins_desc_fut), 2, ",", "")  ;

$linha='|'.$reg.'|'.$vl_cus_inc_acum_ant.'|'.$vl_cus_inc_per_esc.'|'.$vl_cus_inc_acum.'|'.$vl_exc_bc_cus_inc_acum.'|'.$vl_bc_cus_inc.'|'.$cst_pis.'|'.$aliq_pis.'|'.$vl_cred_pis_acum.'|'.$vl_cred_pis_desc_ant.'|'.$vl_cred_pis_desc.'|'.$vl_cred_pis_desc_fut.'|'.$cst_cofins.'|'.$aliq_cofins.'|'.$vl_cred_cofins_acum.'|'.$vl_cred_cofins_desc_ant.'|'.$vl_cred_cofins_desc.'|'.$vl_cred_cofins_desc_fut.'|';
   $qtde_linha_bloco_F205++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_F205=$total_registro_bloco;

   $REG_BLC[]='|F205|'.$total_registro_bloco.'|';
   return;
}


//OPERAÇÕES DA ATIVIDADE IMOBILIÁRIA - CUSTO ORÇADO DA UNIDADE IMOBILIÁRIA VENDIDA
function sped_efd_pis_registro_F210(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_F210;

   $reg='F210';

   $vl_cus_orc='';
   //$vl_cus_orc=number_format(abs($vl_cus_orc), 2, ",", "")  ;

   $vl_exc='';
   //$vl_exc=number_format(abs($vl_exc), 2, ",", "")  ;

   $vl_cus_orc_aju='';
   //$vl_cus_orc_aju=number_format(abs($vl_cus_orc_aju), 2, ",", "")  ;

   $vl_bc_cred='';
   //$vl_bc_cred=number_format(abs($vl_bc_cred), 2, ",", "")  ;

   $cst_pis='';
   $tamanho2=2;
   $cst_pis=_myfunc_zero_a_esquerda($cst_pis,$tamanho2) ;

   $aliq_pis='';
   $tamanho8=8;
   $aliq_pis=_myfunc_zero_a_esquerda($aliq_pis,$tamanho8) ;
   //$aliq_pis=number_format(abs($aliq_pis), 4, ",", "")  ;

   $vl_cred_pis_util='';
   //$vl_cred_pis_util=number_format(abs($vl_cred_pis_util), 2, ",", "")  ;

   $cst_cofins='';
   $tamanho2=2;
   $cst_cofins=_myfunc_zero_a_esquerda($cst_cofins,$tamanho2) ;

   $aliq_cofins='';
   $tamanho8=8;
   $aliq_cofins=_myfunc_zero_a_esquerda($aliq_cofins,$tamanho8) ;
   //$aliq_cofins=number_format(abs($aliq_cofins), 4, ",", "")  ;

   $vl_cred_cofins_util='';
   //$vl_cred_cofins_util=number_format(abs($vl_cred_cofins_util), 2, ",", "")  ;

$linha='|'.$reg.'|'.$vl_cus_orc.'|'.$vl_exc.'|'.$vl_cus_orc_aju.'|'.$vl_bc_cred.'|'.$cst_pis.'|'.$aliq_pis.'|'.$vl_cred_pis_util.'|'.$cst_cofins.'|'.$aliq_cofins.'|'.$vl_cred_cofins_util.'|';
   $qtde_linha_bloco_F210++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_F210=$total_registro_bloco;

   $REG_BLC[]='|F210|'.$total_registro_bloco.'|';
   return;

}

//PROCESSO REFERENCIADO
function sped_efd_pis_registro_F211(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_F211;

   $reg='F211';

   $num_proc='';
   $tamanho20=20;
   $num_proc=_myfunc_espaco_a_direita($num_proc,$tamanho20);

   $ind_proc='';

   $linha='|'.$reg.'|'.$num_proc.'|'.$ind_proc.'|';
   $qtde_linha_bloco_F211++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_F211=$total_registro_bloco;

   $REG_BLC[]='|F211|'.$total_registro_bloco.'|';
   return;

}


//CONTRIBUIÇÃO RETIDA NA FONTE
function sped_efd_pis_registro_F600(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_F600;

   $reg='F600';

   $ind_nat_ret='';

   $dt_ret='';
   $dt_ret=_myfunc_stod($dt_ret);
   $dt_ret=_myfunc_ddmmaaaa($dt_ret);

   $vl_bc_ret='';
   //$vl_bc_ret=number_format(abs($vl_bc_ret), 4, ",", "")  ;

   $vl_ret='';
   //$vl_ret=number_format(abs($vl_ret), 2, ",", "")  ;

   $cod_rec='';
   $tamanho4=4;
   $cod_rec=_myfunc_espaco_a_direita($cod_rec,$tamanho4);

   $ind_nat_rec='';

   $cnpj='';
   $tamanho14=14;
   $cnpj=_myfunc_zero_a_esquerda($cnpj,$tamanho14) ;

   $vl_ret_pis='';
   //$vl_ret_pis=number_format(abs($vl_ret_pis), 2, ",", "")  ;

   $vl_ret_cofins='';
   //$vl_ret_cofins=number_format(abs($vl_ret_cofins), 2, ",", "")  ;

   $ind_rec='';

   $linha='|'.$reg.'|'.$ind_nat_ret.'|'.$dt_ret.'|'.$vl_bc_ret.'|'.$vl_ret.'|'.$cod_rec.'|'.$ind_nat_rec.'|'.$cnpj.'|'.$vl_ret_pis.'|'.$vl_ret_cofins.'|'.$ind_rec.'|';
   $qtde_linha_bloco_F600++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_F600=$total_registro_bloco;

   $REG_BLC[]='|F600|'.$total_registro_bloco.'|';
   return;
}

//DEDUÇÕES DIVERSAS
function sped_efd_pis_registro_F700(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_F700;

   $reg='F700';

   $ind_ori_ded='';

   $ind_nat_ded='';

   $vl_ded_pis='';
   //$vl_ded_pis=number_format(abs($vl_ded_pis), 2, ",", "")  ;

   $vl_ded_cofins='';
   //$vl_ded_cofins=number_format(abs($vl_ded_cofins), 2, ",", "")  ;

   $vl_bc_oper='';
   //$vl_bc_oper=number_format(abs($vl_bc_oper), 2, ",", "")  ;

   $cnpj='';
   $tamanho14=14;
   $cnpj=_myfunc_zero_a_esquerda($cnpj,$tamanho14) ;

   $inf_comp='';
   $tamanho90=90;
   $inf_comp=_myfunc_espaco_a_direita($inf_comp,$tamanho90);
   $linha='|'.$reg.'|'.$ind_ori_ded.'|'.$ind_nat_ded.'|'.$vl_ded_pis.'|'.$vl_ded_cofins.'|'.$vl_bc_oper.'|'.$cnpj.'|'.$inf_comp.'|';
   $qtde_linha_bloco_F700++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_F700=$total_registro_bloco;

   $REG_BLC[]='|F700|'.$total_registro_bloco.'|';
   return;
}

//CRÉDITOS DECORRENTES DE EVENTOS DE INCORPORAÇÃO, FUSÃO E CISÃO
function sped_efd_pis_registro_F800(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_F800;

   $reg='F800';

   $ind_nat_even='';

   $dt_even='';
   $dt_even=_myfunc_stod($dt_even);
   $dt_even=_myfunc_ddmmaaaa($dt_even);

   $cnpj_suced='';
   $tamanho14=14;
   $cnpj_suced=_myfunc_zero_a_esquerda($cnpj_suced,$tamanho14) ;

   $pa_cont_cred='';
   $pa_cont_cred=_myfunc_stod($pa_cont_cred);
   //$pa_cont_cred=_myfunc_mmaaaa($pa_cont_cred);

   $cod_cred='';
   $tamanho3=3;
   $cod_cred=_myfunc_zero_a_esquerda($cod_cred,$tamanho3) ;

   $vl_cred_pis='';
   //$vl_cred_pis=number_format(abs($vl_cred_pis), 2, ",", "")  ;

   $vl_cred_cofins='';
   //$vl_cred_cofins=number_format(abs($vl_cred_cofins), 2, ",", "")  ;

   $per_cred_cis='';
   $tamanho6=6;
   $per_cred_cis=_myfunc_zero_a_esquerda($per_cred_cis,$tamanho6) ;
   //$per_cred_cis=number_format(abs($per_cred_cis), 2, ",", "")  ;

   $linha='|'.$reg.'|'.$ind_nat_even.'|'.$dt_even.'|'.$cnpj_suced.'|'.$pa_cont_cred.'|'.$cod_cred.'|'.$vl_cred_pis.'|'.$vl_cred_cofins.'|'.$per_cred_cis.'|';
   $qtde_linha_bloco_F800++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_F800=$total_registro_bloco;

   $REG_BLC[]='|F800|'.$total_registro_bloco.'|';
   return;

}

//ENCERRAMENTO DO BLOBO F
function sped_efd_pis_registro_F990(){
global $qtd_lin_F,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC;
     
   
 

  $reg='F990';
          $qtd_lin_F++ ;
          $linha='|'.$reg.'|'. $qtd_lin_F.'|';
         
          _matriz_linha($linha);
        
          $tot_registro_bloco=$tot_registro_bloco+1;
          $REG_BLC[]='|F990|'.$tot_registro_bloco.'|';
          return ;
 
}



//ABERTURA DO BLOCO M

 

sped_efd_pis_registro_M001(); //ABERTURA DO BLOCO M
//sped_efd_pis_registro_M100(); //CRÉDITO DE PIS/PASEP RELATIVO AO PERÍODO
//sped_efd_pis_registro_M105(); //DETALHAMENTO DA BASE DE CALCULO DO CRÉDITO APURADO NO PERÍODO - PIS/PASEP
//sped_efd_pis_registro_M110(); //AJUSTES DO CRÉDITO DE PIS/PASEP APURADO
//sped_efd_pis_registro_M200(); //CONSOLIDAÇÃO DA CONTRIBUIÇÃO PARA O PIS/PASEP DO PERÍODO
//sped_efd_pis_registro_M210(); //DETALHAMENTO DA CONTRIBUIÇÃO PARA O PIS/PASEP DO PERÍODO
//sped_efd_pis_registro_M211(); //SOCIEDADES COOPERATIVAS - COMPOSIÇÃO DA BASE DE CALCULO - PIS/PASEP
//sped_efd_pis_registro_M220(); //AJUSTES DA CONTRIBUIÇÃO PARA O PIS/PASEP APURADA
//sped_efd_pis_registro_M230(); //INFORMAÇÃO ADICIONAIS DE DIFERIMENTO
//sped_efd_pis_registro_M300(); //CONTRIBUIÇÃO DE PIS/PASEP DIFERIDA EM PERÍODOS ANTERIORES - VALORES A PAGAR NO PERÍODO
//sped_efd_pis_registro_M350(); //PIS/PASEP - FOLHA DE SALÁRIOS
//sped_efd_pis_registro_M400(); //RECEITAS ISENTAS, NÃO ALCANÇADAS PELA INCIDÊNCIA SA CONTRIBUIÇÃO, SUJEITAS A ALÍQUOTA ZERO OU DE VENDAS COM SUSPENSÃO - PIS/PASEP
//sped_efd_pis_registro_M410(); //DETALHAMENTO DEAS RECEITAS ISENTAS, NÃO ALCANÇADAS PELA INCIDÊNCIA DA CONTRIBUIÇÃO, SUJEITAS A ALÍQUOTA ZERO OU DE VENDAS COM SUSPENSÃO - PIS/PASEP
//sped_efd_pis_registro_M500(); //CRÉDITOS COFINS RELATIVO AO PERÍODO
//sped_efd_pis_registro_M505(); //DETALHAMENTO DA BASE DE CALCULO DO CRÉDITO APURADO NO PERÍODO - COFINS
//sped_efd_pis_registro_M510(); //AJUSTE DO CRÉDITO DE COFINS APURADO
//sped_efd_pis_registro_M600(); //CONSOLIDAÇÃO DA CONTRIBUIÇÃO PARA A SEGURIDADE SOCIAL - COFINS DO PERÍODO
//sped_efd_pis_registro_M610(); //DETALHAMENTO DA CONTRIBUIÇÃO PARA A SEGURIDADE SOCIAL - COFINS DO PERÍODO
//sped_efd_pis_registro_M611(); //SOCIEDADES COOPERATIVAS - COMPOSIÇÃO DA BASE DE CALCULO - COFINS
//sped_efd_pis_registro_M620(); //AJUSTES DA COFINS APURADA
//sped_efd_pis_registro_M630(); //INFORMAÇÕES ADICIONAIS DE DIFERIMENTO
//sped_efd_pis_registro_M700(); //COFINS DIFERIDA EM PERÍODOS ANTERIORES - VALORES A PAGAR NO PERÍODO
//sped_efd_pis_registro_M800(); //RECEITAS ISENTAS, NÃO ALCANÇADAS PELO INCIDÊNCIA DA CONTRIBUIÇÃO, SUJEITAS A ALÍQUOTA ZERO OU DE VENDAS COM SUSPENSÃO - COFINS
//sped_efd_pis_registro_M810(); //DETALHAMENTO DAS RECEITAS ISENTAS, NÃO ALCANÇADAS PELA INCIDÊNCIA DA CONTRIBUIÇÃO, SUJEITAS A ALÍQUOTAS ZERO OU DE VENDAS COM SUSPENSÃO - COFINS
sped_efd_pis_registro_M990(); //ENCERRAMENTO DO BLOCO M


ECHO "BLOCO M - OK <BR>";
flush();




//ABERTURA DO BLOCO M
function sped_efd_pis_registro_M001(){
global $qtd_lin_M,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC ;

   $reg='M001';
   
   $ind_mov='1'; //0 - com dados e 1 - sem dados.

   $linha='|'.$reg.'|'.$ind_mov.'|';
    _matriz_linha($linha);
        
          $tot_registro_bloco++;
          $REG_BLC[]='|M001|'.$tot_registro_bloco.'|';
	   $qtd_lin_M=$qtd_lin_M+$tot_registro_bloco;
          return ;
   return;
}
 

//CRÉDITO DE PIS/PASEP RELATIVO AO PERÍODO
function sped_efd_pis_registro_M100(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M100;

   $reg='M100';

   $cod_cred='';
   $tamanho3=3;
   $cod_cred=_myfunc_espaco_a_direita($cod_cred,$tamanho3);

   $ind_cred_ori='';

   $vl_bc_pis='';
   //$vl_bc_pis=number_format(abs($vl_bc_pis), 2, ",", "")  ;

   $aliq_pis='';
   $tamanho8=8;
   $aliq_pis=_myfunc_zero_a_esquerda($aliq_pis,$tamanho8) ;
   //$aliq_pis=number_format(abs($aliq_pis), 4, ",", "")  ;

   $quant_bc_pis='';
   //$quant_bc_pis=number_format(abs($quant_bc_pis), 3, ",", "")  ;

   $aliq_pis_quant='';
   //$aliq_pis_quant=number_format(abs($aliq_pis_quant), , ",", "")  ;

   $vl_cred='';
   //$vl_cred=number_format(abs($vl_cred), 2, ",", "")  ;

   $vl_ajus_acres='';
   //$vl_ajus_acres=number_format(abs($vl_ajus_acres), 2, ",", "")  ;

   $vl_ajus_reduc='';
   //$vl_ajus_reduc=number_format(abs($vl_ajus_reduc), 2, ",", "")  ;

   $vl_cred_dif='';
   //$vl_cred_dif=number_format(abs($vl_cred_dif), 2, ",", "")  ;

   $vl_cred_disp='';
   //$vl_cred_disp=number_format(abs($vl_cred_disp), 2, ",", "")  ;

   $ind_desc_cred='';

   $vl_cred_desc='';
   //$vl_cred_desc=number_format(abs($vl_cred_desc), 2, ",", "")  ;

   $sld_cred='';
   //$sld_cred=number_format(abs($sld_cred), 2, ",", "")  ;
   $linha='|'.$reg.'|'.$cod_cred.'|'.$ind_cred_ori.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$quant_bc_pis.'|'.$aliq_pis_quant.'|'.$vl_cred.'|'.$vl_ajus_acres.'|'.$vl_ajus_reduc.'|'.$vl_cred_dif.'|'.$vl_cred_disp.'|'.$ind_desc_cred.'|'.$vl_cred_desc.'|'.$sld_cred.'|';
   $qtde_linha_bloco_M100++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M100=$total_registro_bloco;

   $REG_BLC[]='|M100|'.$total_registro_bloco.'|';
   return;

}

//DETALHAMENTO DA BASE DE CALCULO DO CRÉDITO APURADO NO PERÍODO - PIS/PASEP
function sped_efd_pis_registro_M105(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M105;

   $reg='M105';

                 $nat_bc_cred='13'; //  ??????

/*
01 Aquisição de bens para revenda
02 Aquisição de bens utilizados como insumo
04 Energia elétrica utilizada nos estabelecimentos da pessoa jurídica
13 Outras operações com direito a crédito
*/
   $tamanho2=2;
   $nat_bc_cred=_myfunc_espaco_a_direita($nat_bc_cred,$tamanho2);

   $cst_pis='';
   $tamanho2=2;
   $cst_pis=_myfunc_zero_a_esquerda($cst_pis,$tamanho2) ;

   $vl_bc_pis_tot='';
   //$vl_bc_pis_tot=number_format(abs($vl_bc_pis_tot), 2, ",", "")  ;

   $vl_bc_pis_cum='';
   //$vl_bc_pis_cum=number_format(abs($vl_bc_pis_cum), 2, ",", "")  ;

   $vl_bc_pis_nc='';
   //$vl_bc_pis_nc=number_format(abs($vl_bc_pis_nc), 2, ",", "")  ;

   $vl_bc_pis='';
   //$vl_bc_pis=number_format(abs($vl_bc_pis), 2, ",", "")  ;

   $quant_bc_pis_tot='';
   //$quant_bc_pis_tot=number_format(abs($quant_bc_pis_tot), 3, ",", "")  ;

   $quant_bc_pis='';
   //$quant_bc_pis=number_format(abs($quant_bc_pis), 3, ",", "")  ;

   $desc_cred='';
   $tamanho60=60;
   $desc_cred=_myfunc_espaco_a_direita($desc_cred,$tamanho60);

   $linha='|'.$reg.'|'.$nat_bc_cred.'|'.$cst_pis.'|'.$vl_bc_pis_tot.'|'.$vl_bc_pis_cum.'|'.$vl_bc_pis_nc.'|'.$vl_bc_pis.'|'.$quant_bc_pis_tot.'|'.$quant_bc_pis.'|'.$desc_cred.'|';
   $qtde_linha_bloco_M105++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M105=$total_registro_bloco;

   $REG_BLC[]='|M105|'.$total_registro_bloco.'|';
   return;

}

//AJUSTES DO CRÉDITO DE PIS/PASEP APURADO
function sped_efd_pis_registro_M110(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M110;

   $reg='M110';

   $ind_aj='';

   $vl_aj='';
   //$vl_aj=number_format(abs($vl_aj), 2, ",", "")  ;

   $cod_aj='';
   $tamanho2=2;
   $cod_aj=_myfunc_espaco_a_direita($cod_aj,$tamanho2);

   $num_doc='';

   $descr_aj='';

   $dt_ref='';
   $dt_ref=_myfunc_stod($dt_ref);
   $dt_ref=_myfunc_ddmmaaaa($dt_ref);


   $linha='|'.$reg.'|'.$ind_aj.'|'.$vl_aj.'|'.$cod_aj.'|'.$num_doc.'|'.$descr_aj.'|'.$dt_ref.'|';
   $qtde_linha_bloco_M110++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M110=$total_registro_bloco;

   $REG_BLC[]='|M110|'.$total_registro_bloco.'|';
   return;

}

//CONSOLIDAÇÃO DA CONTRIBUIÇÃO PARA O PIS/PASEP DO PERÍODO
function sped_efd_pis_registro_M200(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M200;

   $reg='M200';

   $vl_tot_cont_nc_per='';
   //$vl_tot_cont_nc_per=number_format(abs($vl_tot_cont_nc_per), 2, ",", "")  ;

   $vl_tot_cred_desc='';
   //$vl_tot_cred_desc=number_format(abs($vl_tot_cred_desc), 2, ",", "")  ;

   $vl_tot_cred_desc_ant='';
   //$vl_tot_cred_desc_ant=number_format(abs($vl_tot_cred_desc_ant), 2, ",", "")  ;

   $vl_tot_cont_nc_dev='';
   //$vl_tot_cont_nc_dev=number_format(abs($vl_tot_cont_nc_dev), 2, ",", "")  ;

   $vl_ret_nc='';
   //$vl_ret_nc=number_format(abs($vl_ret_nc), 2, ",", "")  ;

   $vl_out_ded_nc='';
   //$vl_out_ded_nc=number_format(abs($vl_out_ded_nc), 2, ",", "")  ;

   $vl_cont_nc_rec='';
   //$vl_cont_nc_rec=number_format(abs($vl_cont_nc_rec), 2, ",", "")  ;

   $vl_tot_cont_cum_per='';
   //$vl_tot_cont_cum_per=number_format(abs($vl_tot_cont_cum_per), 2, ",", "")  ;

   $vl_ret_cum='';
   //$vl_ret_cum=number_format(abs($vl_ret_cum), 2, ",", "")  ;

   $vl_out_ded_cum='';
   //$vl_out_ded_cum=number_format(abs($vl_out_ded_cum), 2, ",", "")  ;

   $vl_cont_cum_rec='';
   //$vl_cont_cum_rec=number_format(abs($vl_cont_cum_rec), 2, ",", "");

   $vl_tot_cont_rec='';
   //$vl_tot_cont_rec=number_format(abs($vl_tot_cont_rec), 2, ",", "");
   $linha='|'.$reg.'|'.$vl_tot_cont_nc_per.'|'.$vl_tot_cred_desc.'|'.$vl_tot_cred_desc_ant.'|'.$vl_tot_cont_nc_dev.'|'.$vl_ret_nc.'|'.$vl_out_ded_nc.'|'.$vl_cont_nc_rec.'|'.$vl_tot_cont_cum_per.'|'.$vl_ret_cum.'|'.$vl_out_ded_cum.'|'.$vl_cont_cum_rec.'|'.$vl_tot_cont_rec.'|';
   $qtde_linha_bloco_M200++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M200=$total_registro_bloco;

   $REG_BLC[]='|M200|'.$total_registro_bloco.'|';
   return;

}

//DETALHAMENTO DA CONTRIBUIÇÃO PARA O PIS/PASEP DO PERÍODO
function sped_efd_pis_registro_M210(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M210;

   $reg='M210';

   $cod_cont='';
   $tamanho2=2;
   $cod_cont=_myfunc_espaco_a_direita($cod_cont,$tamanho2);

   $vl_rec_brt='';
   //$vl_rec_brt=number_format(abs($vl_rec_brt), 2, ",", "")  ;

   $vl_bc_cont='';
   //$vl_bc_cont=number_format(abs($vl_bc_cont), 2, ",", "")  ;

   $aliq_pis='';
   $tamanho8=8;
   $aliq_cofins=_myfunc_zero_a_esquerda($aliq_cofins,$tamanho8) ;
   //$aliq_cofins=number_format(abs($aliq_cofins), 4, ",", "")  ;

   $quant_bc_pis='';
   //$quant_bc_pis=number_format(abs($quant_bc_pis), 3, ",", "")  ;

   $aliq_pis_quant='';
   //$aliq_pis_quant=number_format(abs($aliq_pis_quant), 4, ",", "")  ;

   $vl_cont_apur='';
   //$vl_cont_apur=number_format(abs($vl_cont_apur), 2, ",", "")  ;

   $vl_ajus_acres='';
   //$vl_ajus_acres=number_format(abs($vl_ajus_acres), 2, ",", "")  ;

   $vl_ajus_reduc='';
   //$vl_ajus_acres=number_format(abs($vl_ajus_acres), 2, ",", "")  ;

   $vl_cont_difer='';
   //$vl_cont_difer=number_format(abs($vl_cont_difer), 2, ",", "")  ;

   $vl_cont_difer_ant='';
   //$vl_cont_difer_ant=number_format(abs($vl_cont_difer_ant), 2, ",", "")  ;

   $vl_cont_per='';
   //$vl_cont_per=number_format(abs($vl_cont_per), 2, ",", "")  ;

   $linha='|'.$reg.'|'.$cod_cont.'|'.$vl_rec_brt.'|'.$vl_bc_cont.'|'.$aliq_pis.'|'.$quant_bc_pis.'|'.$aliq_pis_quant.'|'.$vl_cont_apur.'|'.$vl_ajus_acres.'|'.$vl_ajus_reduc.'|'.$vl_cont_difer.'|'.$vl_cont_difer_ant.'|'.$vl_cont_per.'|';
   $qtde_linha_bloco_M210++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M210=$total_registro_bloco;

   $REG_BLC[]='|M210|'.$total_registro_bloco.'|';
   return;

}

//SOCIEDADES COOPERATIVAS - COMPOSIÇÃO DA BASE DE CALCULO - PIS/PASEP
function sped_efd_pis_registro_M211(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M211;

   $reg='M211';

   $ind_tip_coop='';

   $vl_bc_cont_ant_exc_coop='';
   //$vl_bc_cont_ant_exc_coop=number_format(abs($vl_bc_cont_ant_exc_coop), 2, ",", "")  ;

   $vl_exc_coop_ger='';
   //$vl_exc_coop_ger=number_format(abs($vl_exc_coop_ger), 2, ",", "")  ;

   $vl_exc_esp_coop='';
   //$vl_exc_esp_coop=number_format(abs($vl_exc_esp_coop), 2, ",", "")  ;

   $vl_bc_cont='';
   //$vl_bc_cont=number_format(abs($vl_bc_cont), 2, ",", "")  ;


   $linha='|'.$reg.'|'.$ind_tip_coop.'|'.$vl_bc_cont_ant_exc_coop.'|'.$vl_exc_coop_ger.'|'.$vl_exc_esp_coop.'|'.$vl_bc_cont.'|';
   $qtde_linha_bloco_M211++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M211=$total_registro_bloco;

   $REG_BLC[]='|M211|'.$total_registro_bloco.'|';
   return;
}

//AJUSTES DA CONTRIBUIÇÃO PARA O PIS/PASEP APURADA
function sped_efd_pis_registro_M220(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M220;

   $reg='M220';

   $ind_aj='';

   $vl_aj='';
   //$vl_aj=number_format(abs($vl_aj), 2, ",", "")  ;

   $cod_aj='';
   $tamanho2=2;
   $cod_aj=_myfunc_espaco_a_direita($cod_aj,$tamanho2);

   $num_doc='';

   $descr_aj='';

   $dt_ref='';
   $dt_ref=_myfunc_stod($dt_ref);
   $dt_ref=_myfunc_ddmmaaaa($dt_ref);

   $linha='|'.$reg.'|'.$ind_aj.'|'.$vl_aj.'|'.$cod_aj.'|'.$num_doc.'|'.$descr_aj.'|'.$dt_ref.'|';
   $qtde_linha_bloco_M220++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M220=$total_registro_bloco;

   $REG_BLC[]='|M220|'.$total_registro_bloco.'|';
   return;

}

//INFORMAÇÃO ADICIONAIS DE DIFERIMENTO
function sped_efd_pis_registro_M230(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M230;

   $reg='M230';

   $cnpj='';
   $tamanho14=14;
   $cnpj=_myfunc_zero_a_esquerda($cnpj,$tamanho14) ;

   $vl_vend='';
   //$vl_vend=number_format(abs($vl_vend), 2, ",", "")  ;

   $vl_nao_receb='';
   //$vl_nao_receb=number_format(abs($vl_nao_receb), 2, ",", "")  ;

   $vl_cont_dif='';
   //$vl_cont_dif=number_format(abs($vl_cont_dif), 2, ",", "")  ;

   $vl_cred_dif='';
   //$vl_cred_dif=number_format(abs($vl_cred_dif), 2, ",", "")  ;

   $cod_cred='';
   $tamanho14=14;
   $cod_cred=_myfunc_zero_a_esquerda($cod_cred,$tamanho14) ;


   $linha='|'.$reg.'|'.$cnpj.'|'.$vl_vend.'|'.$vl_nao_receb.'|'.$vl_cont_dif.'|'.$vl_cred_dif.'|'.$cod_cred.'|';
   $qtde_linha_bloco_M230++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M230=$total_registro_bloco;

   $REG_BLC[]='|M230|'.$total_registro_bloco.'|';
   return;
}

//CONTRIBUIÇÃO DE PIS/PASEP DIFERIDA EM PERÍODOS ANTERIORES - VALORES A PAGAR NO PERÍODO
function sped_efd_pis_registro_M300(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M300;

   $reg='M300';

   $cod_cont='';
   $tamanho2=2;
   $cod_cont=_myfunc_espaco_a_direita($cod_cont,$tamanho2);

   $vl_cont_apur_difer='';
   //$vl_cont_apur_difer=number_format(abs($vl_cont_apur_difer), 2, ",", "")  ;

   $nat_cred_desc='';
   $tamanho2=2;
   $nat_cred_desc=_myfunc_espaco_a_direita($nat_cred_desc,$tamanho2);

   $vl_cred_desc_difer='';
   //$vl_cred_desc_difer=number_format(abs($vl_cred_desc_difer), 2, ",", "")  ;

   $vl_cont_difer_ant='';
   //$vl_cont_difer_ant=number_format(abs($vl_cont_difer_ant), 2, ",", "")  ;

   $per_apur='';
   $tamanho6=6;
   $per_apur=_myfunc_zero_a_esquerda($per_apur,$tamanho6) ;

   $dt_receb='';
   $tamanho8=8;
   $dt_receb=_myfunc_zero_a_esquerda($dt_receb,$tamanho8) ;

   $linha='|'.$reg.'|'.$cod_cont.'|'.$vl_cont_apur_difer.'|'.$nat_cred_desc.'|'.$vl_cred_desc_difer.'|'.$vl_cont_difer_ant.'|'.$per_apur.'|'.$dt_receb.'|';
   $qtde_linha_bloco_M300++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M300=$total_registro_bloco;

   $REG_BLC[]='|M300|'.$total_registro_bloco.'|';
   return;

}

//PIS/PASEP - FOLHA DE SALÁRIOS
function sped_efd_pis_registro_M350(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M350;

   $reg='M350';

   $vl_tot_fol='';
   //$vl_tot_fol=number_format(abs($vl_tot_fol), 2, ",", "")  ;

   $vl_exc_bc='';
   //$vl_exc_bc=number_format(abs($vl_exc_bc), 2, ",", "")  ;

   $vl_tot_bc='';
   //$vl_tot_bc=number_format(abs($vl_tot_bc), 2, ",", "")  ;

   $aliq_pis_fol='';
   $tamanho8=8;
   $aliq_pis_fol=_myfunc_zero_a_esquerda($aliq_pis_fol,$tamanho8) ;

   $vl_tot_cont_fol='';
   //$vl_tot_cont_fol=number_format(abs($vl_tot_cont_fol), 2, ",", "")  ;

   $linha='|'.$reg.'|'.$vl_tot_fol.'|'.$vl_exc_bc.'|'.$vl_tot_bc.'|'.$aliq_pis_fol.'|'.$vl_tot_cont_fol.'|';
   $qtde_linha_bloco_M350++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M350=$total_registro_bloco;

   $REG_BLC[]='|M350|'.$total_registro_bloco.'|';
   return;

}


//RECEITAS ISENTAS, NÃO ALCANÇADAS PELA INCIDÊNCIA SA CONTRIBUIÇÃO, SUJEITAS A ALÍQUOTA ZERO OU DE VENDAS COM SUSPENSÃO - PIS/PASEP
function sped_efd_pis_registro_M400(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M400;

   $reg='M400';

   $cs_pis='';
   $tamanho2=2;
   $cs_pis=_myfunc_espaco_a_direita($cs_pis,$tamanho2);

   $vl_tot_rec='';
   //$vl_tot_rec=number_format(abs($vl_tot_rec), 2, ",", "")  ;

   $cod_cta='';
   $tamanho60=60;
   $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);

   $desc_compl='';


   $linha='|'.$reg.'|'.$cs_pis.'|'.$vl_tot_rec.'|'.$cod_cta.'|'.$desc_compl.'|';
   $qtde_linha_bloco_M400++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M400=$total_registro_bloco;

   $REG_BLC[]='|M400|'.$total_registro_bloco.'|';
   return;
}

//DETALHAMENTO DEAS RECEITAS ISENTAS, NÃO ALCANÇADAS PELA INCIDÊNCIA DA CONTRIBUIÇÃO, SUJEITAS A ALÍQUOTA ZERO OU DE VENDAS COM SUSPENSÃO - PIS/PASEP
function sped_efd_pis_registro_M410(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M410;

   $reg='M410' ;

   $nat_rec='';
   $tamanho3=3;
   $nat_rec=_myfunc_espaco_a_direita($nat_rec,$tamanho3);

   $vl_rec='';
   //$vl_rec=number_format(abs($vl_rec), 2, ",", "")  ;

   $cod_cta='';
   $tamanho3=3;
   $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho3);

   $desc_compl='';

   $linha='|'.$reg.'|'.$nat_rec.'|'.$vl_rec.'|'.$cod_cta.'|'.$desc_compl.'|';
   $qtde_linha_bloco_M410++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M410=$total_registro_bloco;

   $REG_BLC[]='|M410|'.$total_registro_bloco.'|';
   return;

}

//CRÉDITOS COFINS RELATIVO AO PERÍODO
function sped_efd_pis_registro_M500(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M500;

   $reg='M500';

   $cod_cred='';
   $tamanho3=3;
   $cod_cred=_myfunc_espaco_a_direita($cod_cred,$tamanho3);

   $ind_cred_ori='';

   $vl_bc_cofins='';
   //$vl_bc_cofins=number_format(abs($vl_bc_cofins), 2, ",", "")  ;

   $aliq_cofins='';
   $tamanho8=8;
   $aliq_cofins=_myfunc_zero_a_esquerda($aliq_cofins,$tamanho8) ;
   //$aliq_cofins=number_format(abs($aliq_cofins), 4, ",", "")  ;

   $quant_bc_cofins='';
   //$quant_bc_cofins=number_format(abs($quant_bc_cofins), 3, ",", "")  ;

   $aliq_cofins_quant='';
   //$aliq_cofins_quant=number_format(abs($aliq_cofins_quant), 4, ",", "")  ;

   $vl_cred='';
   //$vl_cred=number_format(abs($vl_cred), 2, ",", "")  ;

   $vl_ajus_acres='';
   //$vl_ajus_acres=number_format(abs($vl_ajus_acres), 2, ",", "")  ;

   $vl_ajus_reduc='';
   //$vl_ajus_reduc=number_format(abs($vl_ajus_reduc), 2, ",", "")  ;

   $vl_cred_difer='';
   //$vl_cred_difer=number_format(abs($vl_cred_difer), 2, ",", "")  ;

   $vl_cred_disp='';
   //$vl_cred_disp=number_format(abs($vl_cred_disp), 2, ",", "")  ;

   $ind_desc_cred='';

   $vl_cred_desc='';
   //$vl_cred_desc=number_format(abs($vl_cred_desc), 2, ",", "")  ;

   $sld_cred='';
   //$sld_cred=number_format(abs($sld_cred), 2, ",", "")  ;
   $linha='|'.$reg.'|'.$cod_cred.'|'.$ind_cred_ori.'|'.$vl_bc_cofins.'|'.$aliq_cofins.'|'.$quant_bc_cofins.'|'.$aliq_cofins_quant.'|'.$vl_cred.'|'.$vl_ajus_acres.'|'.$vl_ajus_reduc.'|'.$vl_cred_difer.'|'.$vl_cred_disp.'|'.$ind_desc_cred.'|'.$vl_cred_desc.'|'.$sld_cred.'|';
   $qtde_linha_bloco_M500++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M500=$total_registro_bloco;

   $REG_BLC[]='|M500|'.$total_registro_bloco.'|';
   return;


}

//DETALHAMENTO DA BASE DE CALCULO DO CRÉDITO APURADO NO PERÍODO - COFINS
function sped_efd_pis_registro_M505(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M505;

   $reg='M505';

                 $nat_bc_cred='13'; //  ??????

/*
01 Aquisição de bens para revenda
02 Aquisição de bens utilizados como insumo
04 Energia elétrica utilizada nos estabelecimentos da pessoa jurídica
13 Outras operações com direito a crédito
*/
   $tamanho2=2;
   $nat_bc_cred=_myfunc_espaco_a_direita($nat_bc_cred,$tamanho2);

   $cst_cofins='';
   $tamanho2=2;
   $cst_cofins=_myfunc_zero_a_esquerda($cst_cofins,$tamanho2) ;

   $vl_bc_cofins_tot='';
  //$sld_cred=number_format(abs($sld_cred), 2, ",", "")  ;

   $vl_bc_cofins_cum='';
  //$vl_bc_cofins_cum=number_format(abs($vl_bc_cofins_cum), 2, ",", "")  ;

   $vl_bc_cofins_nc='';
  //$vl_bc_cofins_nc=number_format(abs($vl_bc_cofins_nc), 2, ",", "")  ;

   $vl_bc_cofins='';
  //$vl_bc_cofins=number_format(abs($vl_bc_cofins), 2, ",", "")  ;

   $quant_bc_cofins_tot='';
  //$quant_bc_cofins_tot=number_format(abs($quant_bc_cofins_tot), 3, ",", "")  ;

   $quant_bc_cofins='';
  //$quant_bc_cofins=number_format(abs($quant_bc_cofins), 3, ",", "")  ;

   $desc_cred='';
   $tamanho60=60;
   $desc_cred=_myfunc_espaco_a_direita($desc_cred,$tamanho60);

$linha='|'.$reg.'|'.$nat_bc_cred.'|'.$cst_cofins.'|'.$vl_bc_cofins_tot.'|'.$vl_bc_cofins_cum.'|'.$vl_bc_cofins_nc.'|'.$vl_bc_cofins.'|'.$quant_bc_cofins_tot.'|'.$quant_bc_cofins.'|'.$desc_cred.'|';
   $qtde_linha_bloco_M505++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M505=$total_registro_bloco;

   $REG_BLC[]='|M505|'.$total_registro_bloco.'|';
   return;

}

//AJUSTE DO CRÉDITO DE COFINS APURADO
function sped_efd_pis_registro_M510(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M510;

   $reg='M510';

   $ind_aj='';

   $vl_aj='';
  //$vl_aj=number_format(abs($vl_aj), 3, ",", "")  ;

   $cod_aj='';
   $tamanho2=2;
   $cod_aj=_myfunc_espaco_a_direita($cod_aj,$tamanho2);

   $num_doc='';

   $descr_aj='';

   $dt_ref='';
   $dt_ref=_myfunc_stod($dt_ref);
   $dt_ref=_myfunc_ddmmaaaa($dt_ref);

   $linha='|'.$reg.'|'.$ind_aj.'|'.$vl_aj.'|'.$cod_aj.'|'.$num_doc.'|'.$descr_aj.'|'.$dt_ref.'|';
   $qtde_linha_bloco_M510++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M510=$total_registro_bloco;

   $REG_BLC[]='|M510|'.$total_registro_bloco.'|';
   return;

}

//CONSOLIDAÇÃO DA CONTRIBUIÇÃO PARA A SEGURIDADE SOCIAL - COFINS DO PERÍODO
function sped_efd_pis_registro_M600(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M600;

   $reg='M600';

   $vl_tot_cont_nc_per='';
  //$vl_tot_cont_nc_per=number_format(abs($vl_tot_cont_nc_per), 2, ",", "")  ;

   $vl_tot_cred_desc='';
  //$vl_tot_cred_desc=number_format(abs($vl_tot_cred_desc), 2, ",", "")  ;

   $vl_tot_cred_desc_ant='';
  //$vl_tot_cred_desc_ant=number_format(abs($vl_tot_cred_desc_ant), 2, ",", "")  ;

   $vl_tot_cont_nc_dev='';
  //$vl_tot_cont_nc_dev=number_format(abs($vl_tot_cont_nc_dev), 2, ",", "")  ;

   $vl_ret_nc='';
  //$vl_ret_nc=number_format(abs($vl_ret_nc), 2, ",", "")  ;

   $vl_out_ded_nc='';
  //$vl_out_ded_nc=number_format(abs($vl_out_ded_nc), 2, ",", "")  ;

   $vl_cont_nc_rec='';
  //$vl_cont_nc_rec=number_format(abs($vl_cont_nc_rec), 2, ",", "")  ;

   $vl_tot_cont_cum_per='';
  //$vl_tot_cont_cum_per=number_format(abs($vl_tot_cont_cum_per), 2, ",", "")  ;

   $vl_ret_cum='';
  //$vl_ret_cum=number_format(abs($vl_ret_cum), 2, ",", "")  ;

   $vl_out_ded_cum='';
  //$vl_out_ded_cum=number_format(abs($vl_out_ded_cum), 2, ",", "")  ;

   $vl_cont_cum_rec='';
  //$vl_cont_cum_rec=number_format(abs($vl_cont_cum_rec), 2, ",", "")  ;

   $vl_tot_cont_rec='';
  //$vl_tot_cont_rec=number_format(abs($vl_tot_cont_rec), 2, ",", "")  ;

   $linha='|'.$reg.'|'.$vl_tot_cont_nc_per.'|'.$vl_tot_cred_desc.'|'.$vl_tot_cred_desc_ant.'|'.$vl_tot_cont_nc_dev.'|'.$vl_ret_nc.'|'.$vl_out_ded_nc.'|'.$vl_cont_nc_rec.'|'.$vl_tot_cont_cum_per.'|'.$vl_ret_cum.'|'.$vl_out_ded_cum.'|'.$vl_cont_cum_rec.'|'.$vl_tot_cont_rec.'|';
   $qtde_linha_bloco_M600++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M600=$total_registro_bloco;

   $REG_BLC[]='|M600|'.$total_registro_bloco.'|';
   return;

}

//DETALHAMENTO DA CONTRIBUIÇÃO PARA A SEGURIDADE SOCIAL - COFINS DO PERÍODO
function sped_efd_pis_registro_M610(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M610;

   $reg='M610';

   $cod_cont='';
   $tamanho2=2;
   $cod_cont=_myfunc_espaco_a_direita($cod_cont,$tamanho2);

   $vl_rec_brt='';
  //$vl_rec_brt=number_format(abs($vl_rec_brt), 2, ",", "")  ;

   $vl_bc_cont='';
  //$vl_bc_cont=number_format(abs($vl_bc_cont), 2, ",", "")  ;

   $aliq_cofins='';
   $tamanho8=8;
   $aliq_cofins=_myfunc_zero_a_esquerda($aliq_cofins,$tamanho8) ;
   //$aliq_cofins=number_format(abs($aliq_cofins), 4, ",", "")  ;

   $quant_bc_cofins='';
  //$quant_bc_cofins=number_format(abs($quant_bc_cofins), 3, ",", "")  ;

   $aliq_cofins_quant='';
  //$aliq_cofins_quant=number_format(abs($aliq_cofins_quant), 4, ",", "")  ;

   $vl_cont_apur='';
  //$vl_cont_apur=number_format(abs($vl_cont_apur), 2, ",", "")  ;

   $vl_ajus_acres='';
  //$vl_ajus_acres=number_format(abs($vl_ajus_acres), 2, ",", "")  ;

   $vl_ajus_reduc='';
  //$vl_ajus_reduc=number_format(abs($vl_ajus_reduc), 2, ",", "")  ;

   $vl_cont_difer='';
  //$vl_cont_difer=number_format(abs($vl_cont_difer), 2, ",", "")  ;

   $vl_cont_difer_ant='';
  //$vl_cont_difer_ant=number_format(abs($vl_cont_difer_ant), 2, ",", "")  ;

   $vl_cont_per='';
  //$vl_cont_per=number_format(abs($vl_cont_per), 2, ",", "")  ;


   $linha='|'.$reg.'|'.$cod_cont.'|'.$vl_rec_brt.'|'.$vl_bc_cont.'|'.$aliq_cofins.'|'.$quant_bc_cofins.'|'.$aliq_cofins_quant.'|'.$vl_cont_apur.'|'.$vl_ajus_acres.'|'.$vl_ajus_reduc.'|'.$vl_cont_difer.'|'.$vl_cont_difer_ant.'|'.$vl_cont_per.'|';
   $qtde_linha_bloco_M610++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M610=$total_registro_bloco;

   $REG_BLC[]='|M610|'.$total_registro_bloco.'|';
   return;

}

//SOCIEDADES COOPERATIVAS - COMPOSIÇÃO DA BASE DE CALCULO - COFINS
function sped_efd_pis_registro_M611(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M611;

   $reg='M611';

   $ind_tip_coop='';
   $tamanho2=2;
   $ind_tip_coop=_myfunc_zero_a_esquerda($ind_tip_coop,$tamanho2) ;

   $vl_bc_cont_ant_exc_coop='';
  //$vl_bc_cont_ant_exc_coop=number_format(abs($vl_bc_cont_ant_exc_coop), 2, ",", "")  ;

   $vl_exc_coop_ger='';
  //$vl_exc_coop_ger=number_format(abs($vl_exc_coop_ger), 2, ",", "")  ;

   $vl_exc_esp_coop='';
  //$vl_exc_esp_coop=number_format(abs($vl_exc_esp_coop), 2, ",", "")  ;

   $vl_bc_cont='';
  //$vl_bc_cont=number_format(abs($vl_bc_cont), 2, ",", "")  ;
   $linha='|'.$reg.'|'.$ind_tip_coop.'|'.$vl_bc_cont_ant_exc_coop.'|'.$vl_exc_coop_ger.'|'.$vl_exc_esp_coop.'|'.$vl_bc_cont.'|';
   $qtde_linha_bloco_M611++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M611=$total_registro_bloco;

   $REG_BLC[]='|M611|'.$total_registro_bloco.'|';
   return;
}


//AJUSTES DA COFINS APURADA
function sped_efd_pis_registro_M620(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M620;

   $reg='M620';

   $ind_aj='';

   $vl_aj='';
  //$vl_aj=number_format(abs($vl_aj), 2, ",", "")  ;

   $cod_aj='';
   $tamanho2=2;
   $cod_aj=_myfunc_espaco_a_direita($cod_aj,$tamanho2);

   $num_doc='';

   $descr_aj='';

   $dt_ref='';
   $dt_ref=_myfunc_stod($dt_ref);
   $dt_ref=_myfunc_ddmmaaaa($dt_ref);


   $linha='|'.$reg.'|'.$ind_aj.'|'.$vl_aj.'|'.$cod_aj.'|'.$num_doc.'|'.$descr_aj.'|'.$dt_ref.'|';
   $qtde_linha_bloco_M620++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M620=$total_registro_bloco;

   $REG_BLC[]='|M620|'.$total_registro_bloco.'|';
   return;

}

//INFORMAÇÕES ADICIONAIS DE DIFERIMENTO
function sped_efd_pis_registro_M630(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M630;

   $reg='M630';

   $cnpj='';
   $tamanho14=14;
   $cnpj=_myfunc_zero_a_esquerda($cnpj,$tamanho14) ;

   $vl_vend='';
  //$vl_vend=number_format(abs($vl_vend), 2, ",", "")  ;

   $vl_nao_receb='';
  //$vl_nao_receb=number_format(abs($vl_nao_receb), 2, ",", "")  ;

   $vl_cont_dif='';
  //$vl_cont_dif=number_format(abs($vl_cont_dif), 2, ",", "")  ;

   $vl_cred_dif='';
  //$vl_cred_dif=number_format(abs($vl_cred_dif), 2, ",", "")  ;

   $cod_cred='';
   $tamanho3=3;
   $cod_cred=_myfunc_espaco_a_direita($cod_cred,$tamanho3);

   $linha='|'.$reg.'|'.$cnpj.'|'.$vl_vend.'|'.$vl_nao_receb.'|'.$vl_cont_dif.'|'.$vl_cred_dif.'|'.$cod_cred.'|';
   $qtde_linha_bloco_M630++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M630=$total_registro_bloco;

   $REG_BLC[]='|M630|'.$total_registro_bloco.'|';
   return;

}

//COFINS DIFERIDA EM PERÍODOS ANTERIORES - VALORES A PAGAR NO PERÍODO
function sped_efd_pis_registro_M700(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M700;

   $reg='M700';

   $cod_cont='';
   $tamanho2=2;
   $cod_cont=_myfunc_espaco_a_direita($cod_cont,$tamanho2);

   $vl_cont_apur_difer='';
  //$vl_cont_apur_difer=number_format(abs($vl_cont_apur_difer), 2, ",", "")  ;

   $nat_cred_desc='';

   $vl_cred_desc_difer='';
  //$vl_cred_desc_difer=number_format(abs($vl_cred_desc_difer), 2, ",", "")  ;

   $vl_cont_difer_ant='';
  //$vl_cont_difer_ant=number_format(abs($vl_cont_difer_ant), 2, ",", "")  ;

   $per_apur='';
   $dt_doc=_myfunc_stod($dt_doc);
   //$dt_doc=_myfunc_mmaaaa($dt_doc);

   $dt_receb='';
   $dt_receb=_myfunc_stod($dt_receb);
   $dt_receb=_myfunc_ddmmaaaa($dt_receb);
   $linha='|'.$reg.'|'.$cod_cont.'|'.$vl_cont_apur_difer.'|'.$nat_cred_desc.'|'.$vl_cred_desc_difer.'|'.$vl_cont_difer_ant.'|'.$per_apur.'|'.$dt_receb.'|';
   $qtde_linha_bloco_M700++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M700=$total_registro_bloco;

   $REG_BLC[]='|M700|'.$total_registro_bloco.'|';
   return;

}


//RECEITAS ISENTAS, NÃO ALCANÇADAS PELO INCIDÊNCIA DA CONTRIBUIÇÃO, SUJEITAS A ALÍQUOTA ZERO OU DE VENDAS COM SUSPENSÃO - COFINS
function sped_efd_pis_registro_M800(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M800;

   $reg='M800';

   $cst_cofins='';
   $tamanho2=2;
   $cod_cofns=_myfunc_espaco_a_direita($cod_cofins,$tamanho2);

   $vl_tot_rec='';
  //$vl_tot_rec=number_format(abs($vl_tot_rec), 2, ",", "")  ;

   $cod_cta='';
   $tamanho60=60;
   $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);

   $desc_compl='';

   $linha='|'.$reg.'|'.$cst_cofins.'|'.$vl_tot_rec.'|'.$cod_cta.'|'.$desc_compl.'|';
   $qtde_linha_bloco_M800++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M800=$total_registro_bloco;

   $REG_BLC[]='|M800|'.$total_registro_bloco.'|';
   return;

}

//DETALHAMENTO DAS RECEITAS ISENTAS, NÃO ALCANÇADAS PELA INCIDÊNCIA DA CONTRIBUIÇÃO, SUJEITAS A ALÍQUOTAS ZERO OU DE VENDAS COM SUSPENSÃO - COFINS
function sped_efd_pis_registro_M810(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_M810;

   $reg='M810';

   $nat_rec='';
   $tamanho2=2;
   $nat_rec=_myfunc_espaco_a_direita($nat_rec,$tamanho2);

   $vl_rec='';
  //$vl_rec=number_format(abs($vl_rec), 2, ",", "")  ;

   $cod_cta='';
   $tamanho60=60;
   $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);

   $desc_compl='';

   $linha='|'.$reg.'|'.$nat_rec.'|'.$vl_rec.'|'.$cod_cta.'|'.$desc_compl.'|';
   $qtde_linha_bloco_M810++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_M810=$total_registro_bloco;

   $REG_BLC[]='|M810|'.$total_registro_bloco.'|';
   return;

}


//ENCERRAMENTO DO BLOCO M
function sped_efd_pis_registro_M990(){
global $qtd_lin_M,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC;
     
   
 

  $reg='M990';
          $qtd_lin_M++ ;
          $linha='|'.$reg.'|'. $qtd_lin_M.'|';
         
          _matriz_linha($linha);
        
          $tot_registro_bloco=$tot_registro_bloco+1;
          $REG_BLC[]='|M990|'.$tot_registro_bloco.'|';
          return ;
 

}

//ABERTURA DO BLOCO P


 if ($vl_rec_tot>0){  //  caso menor<0, sem dados sem bloco P  13/07/2013

	sped_efd_pis_registro_P001(); //ABERTURA DO BLOCO P
	//sped_efd_pis_registro_P010(); //
	//sped_efd_pis_registro_P100(); //
	//sped_efd_pis_registro_P110(); //DETALHAMENTO DA APURAÇÃO DA CONTRIBUIÇÃO - OPCIONAL
	//sped_efd_pis_registro_P119(); //PROCESSO REFERENCIADO
	sped_efd_pis_registro_P200(); //CONSOLIDAÇÃO DA CONTRIBUIÇÃO PREVIDENCIÁRIA SOBRE A RECEITA BRUTA (TOTALIZA QTAS EMPRESAS EXISTEREM)
	//sped_efd_pis_registro_P210(); //AJUSTE DA CONTRIBUIÇÃO PREVIDENCIÁRIA SOBRE A RECEITA BRUTA
	sped_efd_pis_registro_P990(); //ENCERRAMENTO DO BLOCO P


	ECHO "BLOCO P - OK <BR>";

}

//ABERTURA DO BLOCO P
function sped_efd_pis_registro_P001(){
  global $qtd_lin_P,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC ;
  global $vl_rec_tot;
  
   $reg='P001';


   $ind_mov='1'; //0 - com dados e 1 - sem dados.
   if($vl_rec_tot>0){
      $ind_mov='0'; //0 - com dados e 1 - sem dados.

    
   }

   $linha='|'.$reg.'|'.$ind_mov.'|';
    _matriz_linha($linha);

   $tot_registro_bloco++;
   $REG_BLC[]='|P001|'.$tot_registro_bloco.'|';
   $qtd_lin_P=$qtd_lin_P+$tot_registro_bloco;

   if($ind_mov=='0'){

      // REGSITRO P010 - IDENT. DO ESTABELECIMENTO (CENTRALIZADO)
      // NIVEL - 2
      sped_efd_pis_registro_P010();

      //  REGSITRO P100 - CONTRIBUIÇÃO PREVIDENCIAR SOBRE A RECEITA BRUTA
      // NIVEL -3
      sped_efd_pis_registro_P100();

   }

   return;
}

// REGSITRO P010 - IDENT. DO ESTABELECIMENTO (CENTRALIZADO)
// NIVEL - 2
function sped_efd_pis_registro_P010(){
global $qtd_lin_P,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_P010;

   $reg='P010';

   $cod_est=$info_segmento['cnpjcpf'];

   $linha='|'.$reg.'|'.$cod_est.'|';
   _matriz_linha($linha);
   $tot_registro_bloco=1;
   $REG_BLC[]='|P010|'.$tot_registro_bloco.'|';
   $qtd_lin_P++;

   return;
}

//  REGSITRO P100 - CONTRIBUIÇÃO PREVIDENCIAR SOBRE A RECEITA BRUTA
// NIVEL -3
function sped_efd_pis_registro_P100(){
   global $qtd_lin_P,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_P100;
   global $TLANCAMENTOS,$TNFDOCUMENTOS,$TITEM_FLUXO,$TNFDOCUMENTOS_TMP,$TNFDOCUMENTOS,$CONTNFDOCUMENTOS,$info_cnpj_segmento;
   global $vl_tot_cont_apu; // Para totalização do registro P100

    $reg='P100';
    $vl_rec_tot_est=0.00;

    $dt_ini=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo1));
    $dt_fin=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo2));

	$filtro_lancamentos=" and POSITION(modelo IN ':01:1B:2D:04:55:') > 0 and movimento='RECEITAS'";
    $sql_lancamentos= _myfunc_sql_receitas_despesas_documentos('',"$filtro_lancamentos",'','','');

    while ($v=mysql_fetch_assoc($sql_lancamentos)) {

	    $dono=$v[dono];
	    //include('documentos_situacao_erp.php');
	    $cst_pis=$v[cst_pis];
        if($cst_pis=='01'){
           $vl_doc=($v[svprod]+$v[svfrete]+$v[svseg]+$v[svicmsst]+$v[svipi]+$v[svoutro])-$v[svdesc];
           $vl_rec_tot_est=$vl_rec_tot_est+$vl_doc;
        }

    }


    $cod_ativ_econ='99999999'; // Código indicador da ativ. sujeita a incidência da Contribuição Previdenciaria, tabela 5.1.1
    $vl_rec_ativ_estab=$vl_rec_tot_est;

    $vl_bc_cont=$vl_rec_tot_est; // Base de calculo da cont. previdenciária sobre a receita bruta ($vl_rec_ativ_estab-$vl_exc)

    $aliq_cont='1.00';

    $vl_cont_apu=$vl_bc_cont*($aliq_cont/100);

    $vl_tot_cont_apu=$vl_tot_cont_apu+$vl_cont_apu; // Para totalização do registro P100

    $tamanho8=8;
    $aliq_cont=_myfunc_zero_a_esquerda($aliq_cont,$tamanho8) ;
    $aliq_cont=number_format(abs($aliq_cont), 4, ",", "")  ;

    $vl_rec_tot_est=number_format(abs($vl_rec_tot_est), 2, ",", "") ;
    $vl_rec_ativ_estab=number_format(abs($vl_rec_tot_est), 2, ",", "") ;
    $vl_exc=''; // Valor das exclusões da receita bruta informada em $vl_rec_ativ_estab
    $vl_bc_cont=number_format(abs($vl_rec_tot_est), 2, ",", "") ;
    $vl_cont_apu=number_format(abs($vl_cont_apu), 2, ",", "") ;

    $cod_cta='';
    $info_compl='';
    
    $linha='|'.$reg.'|'.$dt_ini.'|'.$dt_fin.'|'.$vl_rec_tot_est.'|'.$cod_ativ_econ.'|'.$vl_rec_ativ_estab.'|'.$vl_exc.'|'.$vl_bc_cont.'|'.$aliq_cont.'|'.$vl_cont_apu.'|'.$cod_cta.'|'.$info_compl.'|';
    $qtde_linha_bloco_P100++ ;

    $qtd_lin_P++;
	_matriz_linha($linha);
	$tot_registro_bloco++;
    $tot_P100=$total_registro_bloco;

    $REG_BLC[]='|P100|'.$tot_registro_bloco.'|';
   return;

}


//CONSOLIDAÇÃO DA CONTRIBUIÇÃO PREVIDENCIÁRIA SOBRE A RECEITA BRUTA (TOTALIZA QTAS EMPRESAS EXISTEREM)
// NIVEL - 2
function sped_efd_pis_registro_P200(){
   global $qtd_lin_P,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_P200;
   global  $vl_tot_cont_apu; // Para totalização do registro P100

    $reg='P200';

    $per_ref=substr(_myfunc_stod($lanperiodo2),3,2).substr(_myfunc_stod($lanperiodo2),6,4);

    $vl_tot_cont_apu=number_format(abs($vl_tot_cont_apu), 2, ",", "") ;
    $vl_tot_aj_reduc='';
    $vl_tot_aj_acres='';
    $vl_tot_cont_dev=$vl_tot_cont_apu;
    $cod_rec='299101'; //Código de receita referente à contr. previdenciária, conforme informado em DCTF.

    $linha='|'.$reg.'|'.$per_ref.'|'.$vl_tot_cont_apu.'|'.$vl_tot_aj_reduc.'|'.$vl_tot_aj_acres.'|'.$vl_tot_cont_dev.'|'.$cod_rec.'|';
    $qtde_linha_bloco_P200++ ;

    $qtd_lin_P++;
	_matriz_linha($linha);
	$tot_registro_bloco++;
    $tot_P200=$total_registro_bloco;

    $REG_BLC[]='|P200|'.$tot_registro_bloco.'|';

   return;

}

//ENCERRAMENTO DO BLOCO P
function sped_efd_pis_registro_P990(){
global $qtd_lin_P,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC;

    $reg='P990';
    $qtd_lin_P++ ;
    $linha='|'.$reg.'|'. $qtd_lin_P.'|';

    _matriz_linha($linha);

    $tot_registro_bloco=$tot_registro_bloco+1;
    $REG_BLC[]='|P990|'.$tot_registro_bloco.'|';
    return ;


}


sped_efd_pis_registro_1001(); //ABERTURA DO BLOCO 1
//sped_efd_pis_registro_1010(); //PROCESSO REFERENCIADO - AÇÃO JUDICIAL
//sped_efd_pis_registro_1020(); //PROCESSO REFERENCIADO - PROCESSO ADMINISTRATIVO
//sped_efd_pis_registro_1100(); //CONTROLE DE CRÉDITOS FISCAIS - PIS/PASEP
//sped_efd_pis_registro_1101(); //APURAÇÃO DE CRÉDITO EXTEMPORÂNEO - DOCUMENTOS E OPERAÇÕES DE PERÍODOS ANTERIORES - PIS/PASEP
//sped_efd_pis_registro_1102(); //DETALHAMENTO DO CRÉDITO EXTEMPORÂNEO VINCULADO A MAIS DE UM TIPO DE RECEITA - PIS/PASEP
//sped_efd_pis_registro_1200(); //CONTRIBUIÇÃO SOCIAL EXTEMPORÂNEA - PIS/PASEP
//sped_efd_pis_registro_1210(); //DETALHAMENTO DA CONTRIBUIÇÃO SOCIAL EXTEMPORÂNEA - PIS/PASEP
//sped_efd_pis_registro_1220(); //DEMONSTRAÇÃO DO CRÉDITO A DESCONTAR DA CONTRIBUIÇÃO EXTEMPORÂNEA - PIS/PASEP
//sped_efd_pis_registro_1300(); //CONTROLE DOS VALORES RETIDOS NA FONTE - PIS/PASEP
//sped_efd_pis_registro_1500(); //CONTROLE DE CRÉDITOS FISCAIS - COFINS
//sped_efd_pis_registro_1501(); //APURAÇÃO DE CRÉDITO EXTEMPORÂNEO - DOCUMENTOS E OPERAÇÕES DE PERÍODOS ANTERIORES - COFINS
//sped_efd_pis_registro_1502(); //DETALHAMENTO DO CRÉDITO EXTEMPORÂNEO VINCULADO A MAIS DE UM TIPO DE RECEITA - COFINS
//sped_efd_pis_registro_1600(); //CONTRIBUIÇÃO SOCIAL EXTEMPORÂNEA - COFINS
//sped_efd_pis_registro_1610(); //DETALHAMENTO DA CONTRIBUIÇÃO SOCIAL EXTEMPORÂNEA - COFINS
//sped_efd_pis_registro_1620(); //DEMONSTRAÇÃO DO CRÉDITO A DESCONTAR DA CONTRIBUIÇÃO EXTEMPORÂNEA - COFINS
//sped_efd_pis_registro_1700(); //CONTROLE DOS VALORES RETIDOS NA FONTE - COFINS
//sped_efd_pis_registro_1800(); //INCORPORAÇÃO IMOBILIÁRIA - RET
//sped_efd_pis_registro_1809(); //PROCESSO REFERENCIADO
sped_efd_pis_registro_1990(); //ENCERRAMENTO DO BLOCO 1

ECHO "BLOCO 1 - OK <BR>";
flush();
 


//ABERTURA DO BLOCO 1
//ABERTURA DO BLOCO F
function sped_efd_pis_registro_1001(){
global $qtd_lin_1,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC ;

   $reg='1001';
   
   $ind_mov='1'; //0 - com dados e 1 - sem dados.

   $linha='|'.$reg.'|'.$ind_mov.'|';
    _matriz_linha($linha);
        
          $tot_registro_bloco++;
          $REG_BLC[]='|1001|'.$tot_registro_bloco.'|';
	   $qtd_lin_1=$qtd_lin_1+$tot_registro_bloco;
          return ;
   return;
}

//PROCESSO REFERENCIADO - AÇÃO JUDICIAL
function sped_efd_pis_registro_1010(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_1010;

   $reg='1010';

   $num_proc='';
   $tamanho20=20;
   $num_proc=_myfunc_espaco_a_direita($num_proc,$tamanho20);

   $id_sec_jud='';

   $id_vara='';
   $tamanho20=20;
   $num_proc=_myfunc_espaco_a_direita($num_proc,$tamanho20);

   $ind_nat_acao='';

   $desc_dec_jud='';
   $tamanho100=100;
   $desc_dec_jud=_myfunc_espaco_a_direita($desc_dec_jud,$tamanho100);

   $dt_sent_jud='';
   $dt_sent_jud=_myfunc_stod($dt_sent_jud);
   $dt_sent_jud=_myfunc_ddmmaaaa($dt_sent_jud);

   $linha='|'.$reg.'|'.$num_proc.'|'.$id_sec_jud.'|'.$id_vara.'|'.$ind_nat_acao.'|'.$desc_dec_jud.'|'.$dt_sent_jud.'|';
   $qtde_linha_bloco_1010++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_1010=$total_registro_bloco;

   $REG_BLC[]='|1010|'.$total_registro_bloco.'|';
   return;


}


//PROCESSO REFERENCIADO - PROCESSO ADMINISTRATIVO
function sped_efd_pis_registro_1020(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_1020;

   $reg='1020';

   $num_proc='';
   $tamanho2=2;
   $cod_mod=_myfunc_espaco_a_direita($cod_mod,$tamanho2);

   $ind_nat_acao='';
   $tamanho2=2;
   $cod_mod=_myfunc_espaco_a_direita($cod_mod,$tamanho2);


   $dt_dec_adm='';
   $dt_dec_adm=_myfunc_stod($dt_dec_adm);
   $dt_dec_adm=_myfunc_ddmmaaaa($dt_dec_adm);

   $linha='|'.$reg.'|'.$num_proc.'|'.$ind_nat_acao.'|'.$dt_dec_adm.'|';
   $qtde_linha_bloco_1020++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_1020=$total_registro_bloco;

   $REG_BLC[]='|1020|'.$total_registro_bloco.'|';
   return;

}

//CONTROLE DE CRÉDITOS FISCAIS - PIS/PASEP
function sped_efd_pis_registro_1100(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_1100;

   $reg='1100';

   $per_apu_cred='';
   $per_apu_cred=_myfunc_stod($per_apu_cred);
   //$per_apu_cred=_myfunc_mmaaaa($per_apu_cred);

   $orig_cred='';
   $tamanho2=2;
   $orig_cred=_myfunc_zero_a_esquerda($orig_cred,$tamanho2) ;

   $cnpj_suc='';
   $tamanho14=14;
   $cnpj_suc=_myfunc_zero_a_esquerda($cnpj_suc,$tamanho14) ;

   $cod_cred='';
   $tamanho3=3;
   $cod_cred=_myfunc_zero_a_esquerda($cod_cred,$tamanho3) ;

   $vl_cred_apu='';
   //$vl_cred_apu=number_format(abs($vl_cred_apu), 2, ",", "")  ;

   $vl_cred_ext_apu='';
   //$vl_cred_ext_apu=number_format(abs($vl_cred_ext_apu), 2, ",", "")  ;

   $vl_tot_cred_apu='';
   //$vl_tot_cred_apu=number_format(abs($vl_tot_cred_apu), 2, ",", "")  ;

   $vl_cred_desc_pa_ant='';
   //$vl_cred_desc_pa_ant=number_format(abs($vl_cred_desc_pa_ant), 2, ",", "")  ;

   $vl_cred_per_pa_ant='';
   //$vl_cred_per_pa_ant=number_format(abs($vl_cred_per_pa_ant), 2, ",", "")  ;

   $vl_cred_dcomp_pa_ant='';
   //$vl_cred_dcomp_pa_ant=number_format(abs($vl_cred_dcomp_pa_ant), 2, ",", "")  ;

   $sd_cred_disp_efd='';
   //$sd_cred_disp_efd=number_format(abs($sd_cred_disp_efd), 2, ",", "")  ;

   $vl_cred_desc_efd='';
   //$vl_cred_desc_efd=number_format(abs($vl_cred_desc_efd), 2, ",", "")  ;

   $vl_cred_per_efd='';
   //$vl_cred_per_efd=number_format(abs($vl_cred_per_efd), 2, ",", "")  ;

   $vl_cred_dcomp_efd='';
   //$vl_cred_dcomp_efd=number_format(abs($vl_cred_dcomp_efd), 2, ",", "")  ;

   $vl_cred_trans='';
   //$vl_cred_trans=number_format(abs($vl_cred_trans), 2, ",", "")  ;

   $vl_cred_out='';
   //$vl_cred_out=number_format(abs($vl_cred_out), 2, ",", "")  ;

   $sld_cred_fim='';
   //$sld_cred_fim=number_format(abs($sld_cred_fim), 2, ",", "")  ;

   $linha='|'.$reg.'|'.$per_apu_cred.'|'.$orig_cred.'|'.$cnpj_suc.'|'.$cod_cred.'|'.$vl_cred_apu.'|'.$vl_cred_ext_apu.'|'.$vl_tot_cred_apu.'|'.$vl_cred_desc_pa_ant.'|'.$vl_cred_per_pa_ant.'|'.$vl_cred_dcomp_pa_ant.'|'.$sd_cred_disp_efd.'|'.$vl_cred_desc_efd.'|'.$vl_cred_per_efd.'|'.$vl_cred_dcomp_efd.'|'.$vl_cred_trans.'|'.$vl_cred_out.'|'.$sld_cred_fim.'|';
   $qtde_linha_bloco_1100++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_1100=$total_registro_bloco;

   $REG_BLC[]='|1100|'.$total_registro_bloco.'|';
   return;
}

//APURAÇÃO DE CRÉDITO EXTEMPORÂNEO - DOCUMENTOS E OPERAÇÕES DE PERÍODOS ANTERIORES - PIS/PASEP
function sped_efd_pis_registro_1101(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_1101;

    $reg='1101';

    $cod_part='';
    $tamanho60=60;
    $cod_part=_myfunc_espaco_a_direita($cod_part,$tamanho60);

    $cod_item='';
    $tamanho60=60;
    $cod_item=_myfunc_espaco_a_direita($cod_item,$tamanho60);

    $cod_mod='';
    $tamanho2=2;
    $cod_mod=_myfunc_espaco_a_direita($cod_mod,$tamanho2);

    $ser='';
    $tamanho4=4;
    $ser=_myfunc_espaco_a_direita($ser,$tamanho4);

    $sub_ser='';
    $tamanho3=3;
    $sub_ser=_myfunc_espaco_a_direita($sub_ser,$tamanho3);

    $num_doc='';
    $tamanho9=9;
    $num_doc=_myfunc_zero_a_esquerda($num_doc,$tamanho9) ;

    $dt_oper='';
    $dt_oper=_myfunc_stod($dt_oper);
    $dt_oper=_myfunc_ddmmaaaa($dt_oper);

    $chv_nfe='';
    $tamanho44=44;
    $chv_nfe=_myfunc_zero_a_esquerda($chv_nfe,$tamanho44) ;

    $vl_oper='';
    //$vl_oper=number_format(abs($vl_oper), 2, ",", "")  ;

    $cfop='';
    $tamanho4=4;
    $cfop=_myfunc_zero_a_esquerda($cfop,$tamanho4) ;
                 $nat_bc_cred='13'; //  ??????

/*
01 Aquisição de bens para revenda
02 Aquisição de bens utilizados como insumo
04 Energia elétrica utilizada nos estabelecimentos da pessoa jurídica
13 Outras operações com direito a crédito
*/
    $tamanho2=2;
    $nat_bc_cred=_myfunc_zero_a_esquerda($nat_bc_cred,$tamanho2) ;

    $ind_orig_cred='';

    $cst_pis='';
    $tamanho2=2;
    $cst_pis=_myfunc_zero_a_esquerda($cst_pis,$tamanho2) ;

    $vl_bc_pis='';
    //$vl_bc_pis=number_format(abs($vl_bc_pis), 3, ",", "")  ;

    $aliq_pis='';
    //$aliq_pis=number_format(abs($aliq_pis), 4, ",", "")  ;

    $vl_pis='';
    //$vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;

    $cod_cta='';
    $tamanho60=60;
    $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);

    $cod_ccus='';
    $tamanho60=60;
    $cod_ccus=_myfunc_espaco_a_direita($cod_ccus,$tamanho60);

    $desc_compl='';

    $per_escrit='';
    $tamanho6=6;
    $per_escrit=_myfunc_zero_a_esquerda($per_escrit,$tamanho6) ;

    $cnpj='';
    $tamanho14=14;
    $cnpj=_myfunc_zero_a_esquerda($cnpj,$tamanho14) ;

    $linha='|'.$reg.'|'.$cod_part.'|'.$cod_item.'|'.$cod_mod.'|'.$ser.'|'.$sub_ser.'|'.$num_doc.'|'.$dt_oper.'|'.$chv_nfe.'|'.$vl_oper.'|'.$cfop.'|'.$nat_bc_cred.'|'.$ind_orig_cred.'|'.$cst_pis.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$vc_pis.'|'.$cod_cta.'|'.$cod_ccus.'|'.$per_escrit.'|'.$cnpj.'|';
   $qtde_linha_bloco_1101++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_1101=$total_registro_bloco;

   $REG_BLC[]='|1101|'.$total_registro_bloco.'|';
   return;

}


//DETALHAMENTO DO CRÉDITO EXTEMPORÂNEO VINCULADO A MAIS DE UM TIPO DE RECEITA - PIS/PASEP
function sped_efd_pis_registro_1102(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_1102;

   $reg='1102';

   $vl_cred_pis_trib_mi='';
   //$vl_cred_pis_trib_mi=number_format(abs($vl_cred_pis_trib_mi), 2, ",", "")  ;

   $vl_cred_pis_nt_mi='';
   //$vl_cred_pis_nt_mi=number_format(abs($vl_cred_pis_nt_mi), 2, ",", "")  ;

   $vl_cred_pis_exp='';
   //$vl_cred_pis_exp=number_format(abs($vl_cred_pis_exp), 2, ",", "")  ;


   $linha='|'.$reg.'|'.$vl_cred_pis_trib_mi.'|'.$vl_cred_pis_nt_mi.'|'.$vl_cred_pis_exp.'|';
   $qtde_linha_bloco_1102++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_1102=$total_registro_bloco;

   $REG_BLC[]='|1102|'.$total_registro_bloco.'|';
   return;


}

//CONTRIBUIÇÃO SOCIAL EXTEMPORÂNEA - PIS/PASEP
function sped_efd_pis_registro_1200(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_1200;

   $reg='1200';

   $per_apur_ant='';
   $per_apur_ant=_myfunc_stod($per_apur_ant);
   //$per_apur_ant=_myfunc_mmaaaa($per_apur_ant);

   $nat_cont_rec='';
   $tamanho2=2;
   $nat_cont_rec=_myfunc_espaco_a_direita($nat_cont_rec,$tamanho2);

   $vl_cont_apur='';
   //$vl_cont_apur=number_format(abs($vl_cont_apur), 2, ",", "")  ;

   $vl_cred_pis_desc='';
   //$vl_cred_pis_desc=number_format(abs($vl_cred_pis_desc), 2, ",", "")  ;

   $vl_cont_dev='';
   //$vl_cont_dev=number_format(abs($vl_cont_dev), 2, ",", "")  ;

   $vl_out_ded='';
   //$vl_out_ded=number_format(abs($vl_out_ded), 2, ",", "")  ;

   $vl_cont_ext='';
   //$vl_cont_ext=number_format(abs($vl_cont_ext), 2, ",", "")  ;

   $vl_mul='';
   //$vl_mul=number_format(abs($vl_mul), 2, ",", "")  ;

   $vl_jur='';
   //$vl_jur=number_format(abs($vl_jur), 2, ",", "")  ;

   $dt_recol='';
   $dt_recol=_myfunc_stod($dt_recol);
   $dt_recol=_myfunc_ddmmaaaa($dt_recol);


   $linha='|'.$reg.'|'.$per_apur_ant.'|'.$nat_cont_rec.'|'.$vl_cont_apur.'|'.$vl_cred_pis_desc.'|'.$vl_cont_dev.'|'.$vl_out_ded.'|'.$vl_cont_ext.'|'.$vl_mul.'|'.$vl_jur.'|'.$dt_recol.'|';
   $qtde_linha_bloco_1200++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_1200=$total_registro_bloco;

   $REG_BLC[]='|1200|'.$total_registro_bloco.'|';
   return;
}

//DETALHAMENTO DA CONTRIBUIÇÃO SOCIAL EXTEMPORÂNEA - PIS/PASEP
function sped_efd_pis_registro_1210(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_1210;

   $reg='1210';

   $cnpj='';
   $tamanho2=2;
   $cnpj=_myfunc_espaco_a_direita($cnpj,$tamanho2);

   $cst_pis='';
   $tamanho2=2;
   $cst_pis=_myfunc_espaco_a_direita($cst_pis,$tamanho2);

   $cod_part='';
   $tamanho60=60;
   $cod_part=_myfunc_espaco_a_direita($cod_part,$tamanho60);

   $dt_oper='';
   $dt_oper=_myfunc_stod($dt_oper);
   $dt_oper=_myfunc_ddmmaaaa($dt_oper);

   $vl_oper='';
   //$vl_oper=number_format(abs($vl_oper), 2, ",", "")  ;

   $vl_bc_pis='';
   //$vl_bc_pis=number_format(abs($vl_bc_pis), 3, ",", "")  ;

   $aliq_pis='';
   //$aliq_pis=number_format(abs($aliq_pis), 4, ",", "")  ;

   $vl_pis='';
   //$vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;

   $cod_cta='';
   $tamanho60=60;
   $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);

   $desc_compl='';

$linha='|'.$reg.'|'.$cnpj.'|'.$cst_pis.'|'.$cod_part.'|'.$dt_oper.'|'.$vl_oper.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$vl_pis.'|'.$cod_cta.'|'.$desc_compl.'|';
   $qtde_linha_bloco_1210++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_1210=$total_registro_bloco;

   $REG_BLC[]='|1210|'.$total_registro_bloco.'|';
   return;
}

//DEMONSTRAÇÃO DO CRÉDITO A DESCONTAR DA CONTRIBUIÇÃO EXTEMPORÂNEA - PIS/PASEP
function sped_efd_pis_registro_1220(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_1220;

   $reg='1220';

   $per_apu_cred='';
   $per_apu_cred=_myfunc_stod($per_apu_cred);
   $per_apu_cred=_myfunc_ddmmaaaa($per_apu_cred);

   $orig_cred='';
   $tamanho2=2;
   $orig_cred=_myfunc_zero_a_esquerda($orig_cred,$tamanho2) ;

   $cod_cred='';
   $tamanho3=3;
   $cod_cred=_myfunc_zero_a_esquerda($cod_cred,$tamanho3) ;

   $vl_cred='';
   //$vl_cred=number_format(abs($vl_cred), 2, ",", "")  ;

   $linha='|'.$reg.'|'.$per_apu_cred.'|'.$orig_cred.'|'.$cod_cred.'|'.$vl_cred.'|';
   $qtde_linha_bloco_1220++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_1220=$total_registro_bloco;

   $REG_BLC[]='|1220|'.$total_registro_bloco.'|';
   return;
}

//CONTROLE DOS VALORES RETIDOS NA FONTE - PIS/PASEP
function sped_efd_pis_registro_1300(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_1300;

   $reg='1300';

   $ind_nat_ret='';
   $tamanho2=2;
   $ind_nat_ret=_myfunc_zero_a_esquerda($ind_nat_ret,$tamanho2) ;

   $pr_rec_ret='';
   $tamanho6=6;
   $pr_rec_ret=_myfunc_zero_a_esquerda($pr_rec_ret,$tamanho6) ;

   $vl_ret_apu='';
   //$vl_ret_apu=number_format(abs($vl_ret_apu), 2, ",", "")  ;

   $vl_ret_ded='';
   //$vl_ret_ded=number_format(abs($vl_ret_ded), 2, ",", "")  ;

   $vl_ret_per='';
   //$vl_ret_per=number_format(abs($vl_ret_per), 2, ",", "")  ;

   $vl_ret_dcomp='';
   //$vl_ret_dcomp=number_format(abs($vl_ret_dcomp), 2, ",", "")  ;

   $sld_ret='';
   //$vl_ret=number_format(abs($vl_ret), 2, ",", "")  ;

   $linha='|'.$reg.'|'.$ind_nat_ret.'|'.$pr_rec_ret.'|'.$vl_ret_apu.'|'.$vl_ret_ded.'|'.$vl_ret_per.'|'.$vl_ret_dcomp.'|'.$sld_ret.'|';
   $qtde_linha_bloco_1300++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_1300=$total_registro_bloco;

   $REG_BLC[]='|1300|'.$total_registro_bloco.'|';
   return;
}

//CONTROLE DE CRÉDITOS FISCAIS - COFINS
function sped_efd_pis_registro_1500(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_1500;

   $reg='1500';

   $per_apu_cred='';
   $tamanho6=6;
   $per_apu_cred=_myfunc_zero_a_esquerda($per_apu_cred,$tamanho6) ;

   $orig_cred='';
   $tamanho2=2;
   $orig_cred=_myfunc_zero_a_esquerda($orig_cred,$tamanho2) ;

   $cnpj_suc='';
   $tamanho14=14;
   $cnpj_suc=_myfunc_zero_a_esquerda($cnpj_suc,$tamanho14) ;

   $cod_cred='';
   $tamanho3=3;
   $cnpj_suc=_myfunc_zero_a_esquerda($cnpj_suc,$tamanho3);

   $vl_cred_apu='';
   //$vl_cred_apu=number_format(abs($vl_cred_apu), 2, ",", "")  ;

   $vl_cred_ext_apu='';
   //$vl_cred_ext_apu=number_format(abs($vl_cred_ext_apu), 2, ",", "")  ;

   $vl_tot_cred_apu='';
   //$vl_tot_cred_apu=number_format(abs($vl_tot_cred_apu), 2, ",", "")  ;

   $vl_cred_desc_pa_ant='';
   //$vl_cred_desc_pa_ant=number_format(abs($vl_cred_desc_pa_ant), 2, ",", "")  ;

   $vl_cred_per_pa_ant='';
   //$vl_cred_per_pa_ant=number_format(abs($vl_cred_per_pa_ant), 2, ",", "")  ;

   $vl_cred_dcomp_pa_ant='';
   //$vl_cred_dcomp_pa_ant=number_format(abs($vl_cred_dcomp_pa_ant), 2, ",", "")  ;

   $sd_cred_disp_efd='';
   //$sd_cred_disp_efd=number_format(abs($sd_cred_disp_efd), 2, ",", "")  ;

   $vl_cred_desp_efd='';
   //$vl_cred_desp_efd=number_format(abs($vl_cred_desp_efd), 2, ",", "")  ;

   $vl_cred_per_efd='';
   //$vl_cred_per_efd=number_format(abs($vl_cred_per_efd), 2, ",", "")  ;

   $vl_cred_dcomp_efd='';
   //$vl_cred_dcomp_efd=number_format(abs($vl_cred_dcomp_efd), 2, ",", "")  ;

   $vl_cred_trans='';
   //$vl_cred_trans=number_format(abs($vl_cred_trans), 2, ",", "")  ;

   $vl_cred_out='';
   //$vl_cred_out=number_format(abs($vl_cred_out), 2, ",", "")  ;

   $sld_cred_fim='';
   //$sld_cred_fim=number_format(abs($sld_cred_fim), 2, ",", "")  ;

    $linha='|'.$reg.'|'.$per_apu_cred.'|'.$orig_cred.'|'.$cnpj_suc.'|'.$cod_cred.'|'.$vl_cred_apu.'|'.$vl_cred_ext_apu.'|'.$vl_tot_cred_apu.'|'.$vl_cred_desc_pa_ant.'|'.$vl_cred_per_pa_ant.'|'.$vl_cred_dcomp_pa_ant.'|'.$sd_cred_disp_efd.'|'.$vl_cred_desp_efd.'|'.$vl_cred_per_efd.'|'.$vl_cred_dcomp_efd.'|'.$vl_cred_trans.'|'.$vl_cred_out.'|'.$sld_cred_fim.'|';
   $qtde_linha_bloco_1500++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_1500=$total_registro_bloco;

   $REG_BLC[]='|1500|'.$total_registro_bloco.'|';
   return;
}


//APURAÇÃO DE CRÉDITO EXTEMPORÂNEO - DOCUMENTOS E OPERAÇÕES DE PERÍODOS ANTERIORES - COFINS
function sped_efd_pis_registro_1501(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_1501;

   $reg='1501';

   $cod_part='';
   $tamanho60=60;
   $cod_part=_myfunc_espaco_a_direita($cod_part,$tamanho60);

   $cod_item='';
   $tamanho60=60;
   $cod_item=_myfunc_espaco_a_direita($cod_item,$tamanho60);

   $cod_mod='';
   $tamanho2=2;
   $cod_mod=_myfunc_espaco_a_direita($cod_mod,$tamanho2);

   $ser='';
   $tamanho4=4;
   $ser=_myfunc_espaco_a_direita($ser,$tamanho4);

   $sub_ser='';
   $tamanho3=3;
   $sub_ser=_myfunc_espaco_a_direita($sub_ser,$tamanho3);

   $num_doc='';
   $tamanho9=9;
   $num_doc=_myfunc_zero_a_esquerda($num_doc,$tamanho9) ;

   $dt_oper='';
   $dt_oper=_myfunc_stod($dt_oper);
   $dt_oper=_myfunc_ddmmaaaa($dt_oper);

   $chv_nfe='';
   $tamanho44=44;
   $chv_nfe=_myfunc_zero_a_esquerda($chv_nfe,$tamanho44) ;

   $vl_oper='';
   //$vl_oper=number_format(abs($vl_oper), 2, ",", "")  ;

   $cfop='';
   $tamanho9=9;
   $cfop=_myfunc_zero_a_esquerda($cfop,$tamanho9) ;

                   $nat_bc_cred='13'; //  ??????

/*
01 Aquisição de bens para revenda
02 Aquisição de bens utilizados como insumo
04 Energia elétrica utilizada nos estabelecimentos da pessoa jurídica
13 Outras operações com direito a crédito
*/
   $tamanho2=2;
   $nat_bc_cred=_myfunc_espaco_a_direita($nat_bc_cred,$tamanho2);

   $ind_orig_cred='';

   $cst_cofins='';
   $tamanho2=2;
   $cst_cofins=_myfunc_espaco_a_direita($cst_cofins,$tamanho2);

   $vl_bc_cofins='';
   //$vl_bc_cofins=number_format(abs($vl_bc_cofins), 3, ",", "")  ;

   $aliq_cofins='';
   //$aliq_cofins=number_format(abs($aliq_cofins), 4, ",", "")  ;

   $vl_cofins='';
   //$vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;

   $cod_cta='';
   $tamanho60=60;
   $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);

   $cod_ccus='';
   $tamanho60=60;
   $cod_ccus=_myfunc_espaco_a_direita($cod_ccus,$tamanho60);

   $desc_compl='';

   $per_escrit='';
   $tamanho2=2;
   $per_escrit=_myfunc_zero_a_esquerda($per_escrit,$tamanho2) ;

   $cnpj='';
   $tamanho14=14;
   $cnpj=_myfunc_zero_a_esquerda($cnpj,$tamanho14) ;

$linha='|'.$reg.'|'.$cod_part.'|'.$cod_item.'|'.$cod_mod.'|'.$ser.'|'.$sub_ser.'|'.$num_doc.'|'.$dt_oper.'|'.$chv_nfe.'|'.$vl_oper.'|'.$cfop.'|'.$nat_bc_cred.'|'.$ind_orig_cred.'|'.$cst_cofins.'|'.$vl_bc_cofins.'|'.$aliq_cofins.'|'.$vl_cofins.'|'.$cod_cta.'|'.$cod_ccus.'|'.$desc_compl.'|'.$per_escrit.'|'.$cnpj.'|';
   $qtde_linha_bloco_1501++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_1501=$total_registro_bloco;

   $REG_BLC[]='|1501|'.$total_registro_bloco.'|';
   return;
}

//DETALHAMENTO DO CRÉDITO EXTEMPORÂNEO VINCULADO A MAIS DE UM TIPO DE RECEITA - COFINS
function sped_efd_pis_registro_1502(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_1502;

   $reg='1502';

   $vl_cred_cofins_trib_mi='';
   //$vl_cred_cofins_trib_mi=number_format(abs($vl_cred_cofins_trib_mi), 2, ",", "")  ;

   $vl_cred_cofins_nt_mi='';
   //$vl_cred_cofins_nt_mi=number_format(abs($vl_cred_cofins_nt_mi), 2, ",", "")  ;

   $vl_cred_cofins_exp='';
   //$vl_cred_cofins_exp=number_format(abs($vl_cred_cofins_exp), 2, ",", "")  ;

   $linha='|'.$reg.'|'.$vl_cred_cofins_trib_mi.'|'.$vl_cred_cofins_nt_mi.'|'.$vl_cred_cofins_exp.'|';
   $qtde_linha_bloco_1502++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_1502=$total_registro_bloco;

   $REG_BLC[]='|1502|'.$total_registro_bloco.'|';
   return;
}

//CONTRIBUIÇÃO SOCIAL EXTEMPORÂNEA - COFINS
function sped_efd_pis_registro_1600(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_1600;

   $reg='1600';

   $per_apur_ant='';
   $tamanho6=6;
   $per_apur_ant=_myfunc_zero_a_esquerda($per_apur_ant,$tamanho6) ;

   $nat_cont_rec='';
   $tamanho2=2;
   $nat_cont_rec=_myfunc_espaco_a_direita($nat_cont_rec,$tamanho2);

   $vl_cont_apur='';
   //$vl_cont_apur=number_format(abs($vl_cont_apur), 2, ",", "")  ;

   $vl_cred_cofins_desc='';
   //$vl_cred_cofins_desc=number_format(abs($vl_cred_cofins_desc), 2, ",", "")  ;

   $vl_cont_dev='';
   //$vl_cont_dev=number_format(abs($vl_cont_dev), 2, ",", "")  ;

   $vl_out_ded='';
   //$vl_out_ded=number_format(abs($vl_out_ded), 2, ",", "")  ;

   $vl_cont_ext='';
   //$vl_cont_ext=number_format(abs($vl_cont_ext), 2, ",", "")  ;

   $vl_mul='';
   //$vl_mul=number_format(abs($vl_mul), 2, ",", "")  ;

   $vl_jur='';
   //$vl_jur=number_format(abs($vl_jur), 2, ",", "")  ;

   $dt_recol='';
   $dt_recol=_myfunc_stod($dt_recol);
   $dt_recol=_myfunc_ddmmaaaa($dt_recol);


   $linha='|'.$reg.'|'.$per_apur_ant.'|'.$nat_cont_rec.'|'.$vl_cont_apur.'|'.$vl_cred_cofins_desc.'|'.$vl_cont_dev.'|'.$vl_out_ded.'|'.$vl_cont_ext.'|'.$vl_mul.'|'.$vl_jur.'|'.$dt_recol.'|';
   $qtde_linha_bloco_1600++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_1600=$total_registro_bloco;

   $REG_BLC[]='|1600|'.$total_registro_bloco.'|';
   return;
}

//DETALHAMENTO DA CONTRIBUIÇÃO SOCIAL EXTEMPORÂNEA - COFINS
function sped_efd_pis_registro_1610(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_1610;

   $reg='1610';

   $cnpj='';
   $tamanho14=14;
   $cnpj=_myfunc_zero_a_esquerda($cnpj,$tamanho14) ;

   $cst_cofins='';
   $tamanho2=2;
   $cst_cofins=_myfunc_zero_a_esquerda($cst_cofins,$tamanho2) ;

   $cod_part='';
   $tamanho60=60;
   $cod_part=_myfunc_espaco_a_direita($cod_part,$tamanho60);

   $dt_oper='';
   $dt_oper=_myfunc_stod($dt_oper);
   $dt_oper=_myfunc_ddmmaaaa($dt_oper);

   $vl_oper='';
   //$vl_oper=number_format(abs($vl_oper), 2, ",", "")  ;

   $vl_bc_cofins='';
   //$vl_bc_cofins=number_format(abs($vl_bc_cofins), 3, ",", "")  ;

   $aliq_cofins='';
   //$aliq_cofins=number_format(abs($aliq_cofins), 4, ",", "")  ;

   $vl_cofins='';
   //$vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;

   $cod_cta='';
   $tamanho60=60;
   $cod_cta=_myfunc_espaco_a_direita($cod_cta,$tamanho60);

   $desc_compl='';

   $linha='|'.$reg.'|'.$cnpj.'|'.$cst_cofins.'|'.$cod_part.'|'.$dt_oper.'|'.$vl_oper.'|'.$vl_bc_cofins.'|'.$aliq_cofins.'|'.$vl_cofins.'|'.$cod_cta.'|'.$desc_compl.'|';
   $qtde_linha_bloco_1610++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_1610=$total_registro_bloco;

   $REG_BLC[]='|1610|'.$total_registro_bloco.'|';
   return;
}

//DEMONSTRAÇÃO DO CRÉDITO A DESCONTAR DA CONTRIBUIÇÃO EXTEMPORÂNEA - COFINS
function sped_efd_pis_registro_1620(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_1620;

   $reg='1620';

   $per_apu_cred='';
   $tamanho6=6;
   $per_apu_cred=_myfunc_zero_a_esquerda($per_apu_cred,$tamanho6) ;

   $orig_cred='';
   $tamanho2=2;
   $orig_cred=_myfunc_zero_a_esquerda($orig_cred,$tamanho2) ;

   $cod_cred='';
   $tamanho3=3;
   $cod_cred=_myfunc_zero_a_esquerda($cod_cred,$tamanho3) ;

   $vl_cred='';
   //$vl_cred=number_format(abs($vl_cred), 2, ",", "")  ;



   $linha='|'.$reg.'|'.$per_apu_cred.'|'.$orig_cred.'|'.$cod_cred.'|'.$vl_cred.'|';
   $qtde_linha_bloco_1620++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_1620=$total_registro_bloco;

   $REG_BLC[]='|1620|'.$total_registro_bloco.'|';
   return;
}

//CONTROLE DOS VALORES RETIDOS NA FONTE - COFINS
function sped_efd_pis_registro_1700(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_1700;

   $reg='1700';

   $ind_nat_ret='';
   $tamanho2=2;
   $ind_nat_ret=_myfunc_zero_a_esquerda($ind_nat_ret,$tamanho2) ;

   $pr_rec_ret='';
   $pr_rec_ret=_myfunc_stod($pr_rec_ret);
   //$pr_rec_ret=_myfunc_mmaaaa($pr_rec_ret);

   $vl_ret_apu='';
   //$vl_ret_apu=number_format(abs($vl_ret_apu), 2, ",", "")  ;

   $vl_ret_ded='';
   //$vl_ret_ded=number_format(abs($vl_ret_ded), 2, ",", "")  ;

   $vl_ret_per='';
   //$vl_ret_per=number_format(abs($vl_ret_per), 2, ",", "")  ;

   $vl_ret_dcomp='';
   //$vl_ret_dcomp=number_format(abs($vl_ret_dcomp), 2, ",", "");

   $sld_ret='';
   //$vl_ret=number_format(abs($vl_ret), 2, ",", "");


$linha='|'.$reg.'|'.$ind_nat_ret.'|'.$pr_rec_ret.'|'.$vl_ret_apu.'|'.$vl_ret_ded.'|'.$vl_ret_per.'|'.$vl_ret_dcomp.'|'.$sld_ret.'|';
   $qtde_linha_bloco_1700++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_1700=$total_registro_bloco;

   $REG_BLC[]='|1700|'.$total_registro_bloco.'|';
   return;
}

//INCORPORAÇÃO IMOBILIÁRIA - RET
function sped_efd_pis_registro_1800(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_1800;

   $reg='1800';

   $inc_imob='';
   $tamanho90=90;
   $inc_imob=_myfunc_espaco_a_direita($inc_imob,$tamanho90);

   $rec_receb_ret='';
   //$rec_receb_ret=number_format(abs($rec_receb_ret), 2, ",", "");

   $rec_fin_ret='';
   //$rec_fin_ret=number_format(abs($rec_fin_ret), 2, ",", "");

   $bc_ret='';
   //$bc_ret=number_format(abs($bc_ret), 2, ",", "");

   $aliq_ret='';
   $tamanho6=6;
   $aliq_ret=_myfunc_zero_a_esquerda($aliq_ret,$tamanho6) ;
   //$aliq_ret=number_format(abs($aliq_ret), 2, ",", "");

   $vl_rec_uni='';
   //$vl_rec_uni=number_format(abs($vl_rec_uni), 2, ",", "");

   $dt_rec_uni='';
   $pr_rec_uni=_myfunc_stod($pr_rec_uni);
   //$pr_rec_uni=_myfunc_mmaaaa($pr_rec_uni);

   $cod_rec='';
   $tamanho90=90;
   $cod_rec=_myfunc_espaco_a_direita($cod_rec,$tamanho60);


   $linha='|'.$reg.'|'.$inc_imob.'|'.$rec_receb_ret.'|'.$rec_fin_ret.'|'.$bc_ret.'|'.$aliq_ret.'|'.$vl_rec_uni.'|'.$dt_rec_uni.'|'.$cod_rec.'|';
   $qtde_linha_bloco_1800++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_1800=$total_registro_bloco;

   $REG_BLC[]='|1800|'.$total_registro_bloco.'|';
   return;
}
//PROCESSO REFERENCIADO
function sped_efd_pis_registro_1809(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$tot_1809;

   $reg='1809';

   $num_proc='';
   $tamanho20=20;
   $num_proc=_myfunc_espaco_a_direita($num_proc,$tamanho20);

   $ind_proc='';

   $linha='|'.$reg.'|'.$num_proc.'|'.$ind_proc.'|';
   $qtde_linha_bloco_1809++ ;

   $escreve = fwrite($fp, "$linha\r\n");
   $total_registro_bloco=$total_registro_bloco+1;
   $tot_1809=$total_registro_bloco;

   $REG_BLC[]='|1809|'.$total_registro_bloco.'|';
   return;
}

//ENCERRAMENTO DO BLOCO 1
function sped_efd_pis_registro_1990(){
global $qtd_lin_1,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC;
     
   
 

  $reg='1990';
          $qtd_lin_1++ ;
          $linha='|'.$reg.'|'. $qtd_lin_1.'|';
         
          _matriz_linha($linha);
        
          $tot_registro_bloco=$tot_registro_bloco+1;
          $REG_BLC[]='|1990|'.$tot_registro_bloco.'|';
          return ;
 

}


sped_efd_pis_registro_9001(); //ABERTURA DO BLOCO 9
sped_efd_pis_registro_9900(); //REGISTROS DO ARQUIVO
sped_efd_pis_registro_9990(); //ENCERRAMENTO DO BLOCO 9
sped_efd_pis_registro_9999(); //ENCERRAMENTO DO ARQUIVO DIGITAL



escreve_matriz_linha();
return;


// REGISTRO 9001: ABERTURA DO BLOCO 9

function sped_efd_pis_registro_9001() {
             global $info_segmento,$fp;


                 $linha="|9001|0|";
		     _matriz_linha($linha);
               
                 return;
}


// REGISTRO 9900: REGISTROS DO ARQUIVO.

function sped_efd_pis_registro_9900() {
             global $info_segmento,$fp,$matriz_linha_sped,$CONTLANCAMENTOS ;

		$sql="drop table IF EXISTS registros_efd";
		    if ( mysql_query($sql) or die (mysql_error()) ) {
		    }

	  $sql="CREATE  temporary TABLE  registros_efd (registro varchar(4),id int(11))";
	    if ( mysql_query($sql) or die (mysql_error()) ) {
	    }

  
	 


        $cont=0;
	$xcont=0;
        $i = count($matriz_linha_sped);
	 $m_reg_blocos=Array();
        while($cont < $i) {
                $linha = trim($matriz_linha_sped[$cont]);
                $reg_bloco=explode('|',$linha);
		$reg_bloco_k=$reg_bloco[1];
		 $sql_reg="INSERT INTO  registros_efd (registro,id) value ('$reg_bloco_k','$cont')";

		     if ( mysql_query($sql_reg) or die (mysql_error()) ) {
		    }
		 

		$cont++;
        }

 	$xsql="SELECT registro,count(1) as qtde  FROM registros_efd group by registro order by id";
 	 		 		    
			$selreg=mysql_query("$xsql",  $CONTLANCAMENTOS);
		     $qreg=0;
		     while ($regl = mysql_fetch_assoc($selreg) ) {
			   $linha="|9900|".$regl[registro]."|".$regl[qtde]."|";
			   _matriz_linha($linha);
			   $qreg=$qreg+1;

			}
			$qreg=$qreg+3;
			$linha="|9900|9900|".$qreg."|";
			   _matriz_linha($linha);

			$linha="|9900|9990|1|";
			_matriz_linha($linha);
			
			$linha="|9900|9999|1|";
			_matriz_linha($linha);

	

                 return;
}

//REGISTRO 9990: ENCERRAMENTO DO BLOCO 9
function sped_efd_pis_registro_9990() {
                     global $info_segmento,$fp;
                     $qtde_linha_bloco=_myfunc_qtde_registro_matriz_linha_sped('9') + 2;
                     $linha='|9990|'.$qtde_linha_bloco.'|';
		     _matriz_linha($linha);
                     return;
}


//REGISTRO 9999: ENCERRAMENTO DO arquivo digital
function sped_efd_pis_registro_9999() {
                       global $info_segmento,$fp,$matriz_linha_sped;
			 
		             $qtde_linha_bloco=count($matriz_linha_sped)+1;
		             $linha='|9999|'.$qtde_linha_bloco.'|';
			     _matriz_linha($linha);
                     return;


}

function  _matriz_linha($conteudo) {
         global $qtd_lin_C,$matriz_linha_sped,$l030,$J900;
         if (trim($conteudo)<> '') {
         $matriz_linha_sped[]=$conteudo;
         if (substr($conteudo,1,4)=='I030') {
            $l030 = count($matriz_linha_sped);
         }
         if (substr($conteudo,1,4)=='J900') {
            $J900 = count($matriz_linha_sped);
         }
         }
IF ($qtd_lin_C>0) {
// ECHO "<BR>c: ".$qtd_lin_C."---".$conteudo; 
}
         return;
}
function escreve_matriz_linha(){
        global $matriz_linha_sped,$fp,$qtd_lin,$l030,$J900;
 
        $l030=$l030-1;
        $J900=$J900-1;
        $string = $matriz_linha_sped[$l030];
        $string1 = $matriz_linha_sped[$J900];
     //   $matriz_linha_sped[$l030] = ereg_replace('xyzqw',"$qtd_lin" , $string);
     //   $matriz_linha_sped[$J900] = ereg_replace('www',"$qtd_lin" , $string1);
        $cont=0;
        $i = count($matriz_linha_sped);
        


 
      
        
        while($cont < $i) {
                $linha = trim($matriz_linha_sped[$cont]);
                $escreve = fwrite($fp,"$linha\r\n");
 

                $cont++;
        }

        return ;
}



?>
