<?
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
 * @name      sped_efd_funcoes.php
 * @version   2.0  20120919
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL v.3
 * @copyright 2012 &copy; PLANO D/C
 * @link      http:planodecontas.net
 * @author    Walber S Sales <eng.walber at gmail dot com>



 *        CONTRIBUIDORES (em ordem alfabetica):

 *        AUREO NEVES DE SOUZA JUNIOR <onlinesistema at hotmail.com.br>

              
 

 
*/

 



set_time_limit(0);

include('mysql_performace.php'); 

global $chkinventario,$REG_BLC;
$qtde_linha_bloco_0=0;
$qtde_linha_bloco_c=0;
$qtde_linha_bloco_d=0;
$box_inventario=$_POST['box_inventario'];
 
 // rever 175,400, c500 ,c590
 

// H010  // $ind_prop='0';  $cod_part='';  $txt_compl='';  $cod_cta='';


// gerando efd




//REGISTRO 0000: ABERTURA DO ARQUIVO DIGITAL E IDENTIFICAÇÃO DA ENTIDADE
sped_efd_registro_0000();
 
 
//REGISTRO 0001: ABERTURA DO BLOCO 0
sped_efd_registro_0001();

//    REGISTRO 0005: DADOS COMPLEMENTARES DA ENTIDADE
sped_efd_registro_0005();

//REGISTRO 0015: DADOS DO CONTRIBUINTE SUBSTITUTO
//????
// sped_efd_registro_0015();
 
//REGISTRO 0100: DADOS DO CONTABILISTA
sped_efd_registro_0100();

//REGISTRO 0150: TABELA DE CADASTRO DO PARTICIPANTE
sped_efd_registro_0150();
 
 // n3: REGISTRO 0175: ALTERAÇÃO DA TABELA DE CADASTRO DE PARTICIPANTE
 //???
 //sped_efd_registro_0175();
 
 
//REGISTRO 0190: IDENTIFICAÇÃO DAS UNIDADES DE MEDIDA
sped_efd_registro_0190();

//REGISTRO 0200: TABELA DE IDENTIFICAÇÃO DO ITEM (PRODUTO E SERVIÇOS)
sped_efd_registro_0200();

 
     // n3: REGISTRO 0205: ALTERAÇÃO DO ITEM

     
     // n3: REGISTRO 0206: CÓDIGO DE PRODUTO CONFORME TABELA PUBLICADA PELA ANP (COMBUSTÍVEIS) Este registro tem por objetivo informar o código correspondente
     
     // n3: REGISTRO 0220: FATORES DE CONVERSÃO DE UNIDADES
     

// n2: REGISTRO 0300: CADASTRO DE BENS OU COMPONENTES DO ATIVO IMOBILIZADO

// n3: REGISTRO 0305  INFORMAÇÃO SOBRE A UTILIZAÇÃO DO BEM


// REGISTRO 0400: TABELA DE NATUREZA DA OPERAÇÃO/PRESTAÇÃO
sped_efd_registro_0400() ;

//REGISTRO 0450: TABELA DE INFORMAÇÃO COMPLEMENTAR DO DOCUMENTO FISCAL
sped_efd_registro_0450();

// REGISTRO 0460: TABELA DE OBSERVAÇÕES DO LANÇAMENTO FISCAL
 

// REGISTRO 0500: PLANO DE CONTAS CONTÁBEIS

 sped_efd_registro_0500();  // APENAS PARA OS REGISTRO DE CONTAS

sped_efd_registro_0600(); //CENTRO DE CUSTOS

//REGISTRO 0990: ENCERRAMENTO DO BLOCO 0
sped_efd_registro_0990();

 

//REGISTRO 0000: ABERTURA DO ARQUIVO DIGITAL E IDENTIFICAÇÃO DA ENTIDADE
function sped_efd_registro_0000() {
             global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$pcind_perfil,$cod_ver;
                      $cod_finalidade=$_POST['cod_finalidade'];

                      //$cod_ver=$_POST[cod_ver];
                      $tamanho3=3;
                      $cod_ver=_myfunc_zero_a_esquerda($cod_ver,$tamanho3) ;


                      $dt_ini=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo1));
                      $dt_fin=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo2));
                      $xnome=_myfunc_removeacentos($info_segmento[razaosocial]);
                      $cmun=_apenas_numeros($info_segmento[cod_mun]);
                      $im=$info_segmento[im];
                      $xcnpj=$info_segmento[cnpjcpf];
                      $xcpf='';
                      $pcind_perfil=$_POST[ind_perfil];
                      $linha='|0000|'.$cod_ver.'|'.$cod_finalidade.'|'.$dt_ini.'|'.$dt_fin.'|'.$xnome.'|'.$xcnpj.'|'.$xcpf.'|'.$info_segmento[uf].'|'.$info_segmento[ie].'|'.$cmun.'|'.$im.'|'.$info_segmento[suframa].'|'.$pcind_perfil.'|'.$info_segmento[ind_ativ].'|';
		      _matriz_linha($linha);

	   
           return;
}


//REGISTRO 0001: ABERTURA DO BLOCO 0
function sped_efd_registro_0001() {
             global $info_segmento,$fp;
                 $linha="|0001|0|";
		 _matriz_linha($linha);

                 return;
}

//    REGISTRO 0005: DADOS COMPLEMENTARES DA ENTIDADE

function sped_efd_registro_0005() {
             global $info_segmento,$fp;
                $xfantasia=_myfunc_removeacentos($info_segmento[fantasia]);
                $xfone='000000000'._apenas_numeros($info_segmento[tel]);
                $xfone=substr($xfone,-10);
                $xfax='0000000000'._apenas_numeros($info_segmento[fax]);
                $xfax=substr($xfax,-10);
                $linha='|0005|'.$xfantasia.'|'.$info_segmento[cep].'|'.$info_segmento[endereco].'|'.$info_segmento[num].'|'.$info_segmento[compl].'|'.$info_segmento[bairro].'|'.$xfone.'|'.$xfax.'|'.$info_segmento[email].'|';
                $qtde_linha_bloco_0++;
                _matriz_linha($linha);
	   

                return;
}



//REGISTRO 0100: DADOS DO CONTABILISTA
function sped_efd_registro_0100() {
                global $info_segmento,$fp;
                global $TCONTABILISTA,$CONTCONTABILISTA,$TCNPJCPF;
                $sel_cnpj = mysql_query("SELECT a.*,b.razao,b.tel,b.fax,b.cep,b.endereco,b.num,b.compl,b.bairro,b.cod_mun FROM $TCONTABILISTA as a,$TCNPJCPF as b WHERE a.cpf=b.cnpj",$CONTCONTABILISTA);
                // contador nao cadastrado
                        if ( mysql_num_rows($sel_cnpj) ) {
                    $info_contador = mysql_fetch_assoc($sel_cnpj);
                }
                $cpfcont=$info_contador[cpf];
                $xnome=_myfunc_removeacentos($info_contador[razao]);
                $xfone='000000000'._apenas_numeros($info_contador[tel]);
                $xfone=substr($xfone,-10);
                $xfax='0000000000'._apenas_numeros($info_contador[fax]);
                $xfax=substr($xfax,-10);
                $cmun=_apenas_numeros($info_contador[cod_mun]);
                $linha='|0100|'.$xnome.'|'.$cpfcont.'|'.$info_contador[crc].'|'.$info_contador[cnpj].'|'.$info_contador[cep].'|'.$info_contador[endereco].'|'.$info_contador[num].'|'.$info_contador[compl].'|'.$info_contador[bairro].'|'.$xfone.'|'.$xfax.'|'.$info_contador[email].'|'.$cmun.'|';
                $qtde_linha_bloco_0++;
                _matriz_linha($linha);
		   
 

                RETURN;
}

//TABELA DO CADASTRO DO PARTICIPANTE
function sped_efd_registro_0150() {

	global $qtd_lin_0,$info_segmento,$fp,$TLANCAMENTOS,$TCNPJCPF,$lanperiodo1,$lanperiodo2,$livro_reg;
 

            $modelos_inclusos="|01|1B|04|06|07|08|8B|09|10|11|21|22|26|27|28|29|55|57|";
			$filtro_modelos=" and POSITION(a.modelo IN '$modelos_inclusos')>0";
 
               

 
        $sql_lancamentos= _myfunc_sql_receitas_despesas_documentos('',"$filtro_modelos",'',"",'');

        $sql_participantes="select a.cnpjcpf,b.razao from $livro_reg as a,$TCNPJCPF as b where a.cnpjcpf=b.cnpj group by a.cnpjcpf order by b.razao";
 
	$sel_participantes=mysql_query("$sql_participantes");
        
     	while ( $vp = mysql_fetch_assoc($sel_participantes)) {

     
             $reg='0150';

             $cod_part=trim($vp[cnpjcpf]);
	     $partipantes=_myfun_dados_cnpjcpf("$cod_part");
             $nome=$partipantes['razao'];
             $cod_pais=$partipantes['pais'];
	     if (trim($cod_pais)=='') {
		$cod_pais='01058';
	     }

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



	   }

       return;


}


 
 


//REGISTRO 0190: IDENTIFICAÇÃO DAS UNIDADES DE MEDIDA

function sped_efd_registro_0190() {
                 return ;  // esta em 0200
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
function sped_efd_registro_0200() {
global $CONTITEM_FLUXO,$TUNIDADE_FATOR_CONVERSAO,$livro_reg,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$TITEM_FLUXO,$TPRODUTOS,$CONTITEM_FLUXO,$TSERVICOS,$info_cnpj_segmento,$TVEICULOS,$CONTVEICULOS;
 
//Este registro tem por objetivo informar as mercadorias, serviços, produtos ou quaisquer outros itens concernentes às transações representativas de receitas e/ou geradoras de créditos
// O Código do Item deverá ser preenchido com as informações utilizadas na última ocorrência do período.
          
	 
 $sel_itens=_myfunc_sql_receitas_despesas_itens('','') ;

         $modelos_inclusos="|01|1B|04|06|07|08|8B|09|10|11|21|22|26|27|28|29|57|";
	$filtro_modelos="   (POSITION(a.modelo IN '$modelos_inclusos')>0 or (a.flag_mult=1 and a.modelo<>'03') )";    

//         $modelos_inclusos="|01|1B|04|06|07|08|8B|09|10|11|21|22|26|27|28|29|55|57|"; 
//	 $filtro_modelos="   POSITION(a.modelo IN '$modelos_inclusos')>0 ";    

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
				// $descr_item = $dados_item['modelo'];
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

			    
			  
			     //$alqicms= number_format($alqicms, 2, ',', '.');

			     $linha='|0200|'.$cod_item.'|'.$descr_item.'|'.$cod_barra.'|'.$cod_ant.'|'.$xunidade.'|'.$tipo_item.'|'.$cod_ncm.'|'.$tipi.'|'.$cod_gen.'|'.$cod_lst.'|'.$alqicms.'|';
			     
				   _matriz_linha($linha);

				sped_efd_registro_0220($xunidade);
				   
			     

			  }

		   		  
        
}




//REGISTRO 0220: FATORES DE CONVERSÃO DE UNIDADES
function sped_efd_registro_0220($unidade) {

                global $info_segmento,$fp,$qtde_linha_bloco_0,$qtde_linha_bloco_c,$REG_BLC;
                global $TUNIDADE_FATOR_CONVERSAO,$TITEM_FLUXO,$CONTITEM_FLUXO,$info_cnpj_segmento,$tot_registro_bloco_0220;

                $selunidade = mysql_query("SELECT * FROM $TUNIDADE_FATOR_CONVERSAO  where (unidad_conv='$unidade')",$CONTITEM_FLUXO);

                while ( $punidade = mysql_fetch_assoc($selunidade) ) {
                      $linha='|0220|'.$punidade[unidad_conv].'|'.$punidade[fat_conv].'|';
                        _matriz_linha($linha);
                }


                return;
}




//REGISTRO 0400: TABELA DE NATUREZA DA OPERAÇÃO/PRESTAÇÃO

function sped_efd_registro_0400() {
                global $info_segmento,$fp,$qtde_linha_bloco_0,$qtde_linha_bloco_c,$REG_BLC;
                global $TLANCAMENTOS,$CONTLANCAMENTOS_TMP,$info_cnpj_segmento,$filtromovimento,$filtroconsulta,$TCNPJCPF,$CONTCNPJCPF,$ordem ,$tordem,$TNATUREZAOPERACAO ,$CONTNATUREZAOPERACAO,$perdtos1,$perdtos2;
                $tordem = 'ASC';
                $ordem = 'codnat';
                //$seldiferedono=_myfunc_gerar_tabelas_fluxo($TLANCAMENTOS,'ATV');
                $xsqlx="SELECT dono,cod_sit,modelo,if(movimento='RECEITAS','0','1') as ind_emit,movimento,codnat,valor from $TLANCAMENTOS where cnpjcpfseg='$info_cnpj_segmento' and ((data >= $perdtos1) and (data <= $perdtos2)) and lan_impostos<>'S' and movimento<>'TRANSFERE' and modelo<>'03' group by codnat,modelo,cod_sit order by codnat";
                
                //echo "SELECT dono,cod_sit,modelo,if(movimento='RECEITAS','0','1') as ind_emit,movimento,codnat,valor from $TLANCAMENTOS where cnpjcpfseg='$info_cnpj_segmento' and ((data >= $perdtos1) and (data <= $perdtos2)) and lan_impostos<>'S' and movimento<>'TRANSFERE' and modelo<>'03' group by codnat,modelo,cod_sit order by codnat";

                $seldiferedono=mysql_query($xsqlx,$CONTLANCAMENTOS_TMP) or die (mysql_error());

                $xxcodnat='(*^!#*(';
                $tot_registro_bloco=0;
                         while ( $pdono = mysql_fetch_assoc($seldiferedono) ) {

                                $ind_emit=$pdono[ind_emit];  // 0- propria,1-terceiro
                                $modelo=$pdono[modelo];
                                $dono=$pdono[dono];

                                if ($pdono[codnat]<>$xxcodnat and $pdono[codnat]<>'' and $modelo<>'') {
                                      $xxcodnat=$pdono[codnat];
                                      // aponta para natureza de operação
                                      $selnatureza = mysql_query("SELECT * FROM $TNATUREZAOPERACAO WHERE codnat = '$xxcodnat'",$CONTNATUREZAOPERACAO);
                                      $infonatureza = mysql_fetch_assoc($selnatureza);
                                      
                                      if ($ind_emit=='1' or ($modelo=='01' or $modelo=='1B' or $modelo=='04')){
                                         $linha='|0400|'.$pdono[codnat].'|'.$infonatureza[descricaonatureza].'|';
                                           _matriz_linha($linha);
                                      }
                                }

                         }
              
                 return;
}


function sped_efd_registro_0450() {

                         global $info_segmento,$fp,$qtde_linha_bloco_0,$qtde_linha_bloco_c,$REG_BLC;
                         global $TINFOCPL,$TITEM_FLUXO,$TPRODUTOS ,$CONTITEM_FLUXO,$TSERVICOS,$info_cnpj_segmento,$perdtos1,$perdtos2,$TLANCAMENTOS;
                         $xsql_d="SELECT *,if(movimento='RECEITAS','0','1') as ind_emit FROM $TITEM_FLUXO where  cnpjcpfseg='$info_cnpj_segmento'  and ((data >= $perdtos1) and (data <= $perdtos2)) group by codigo_infcpl";

                         $xsql_d="SELECT * FROM $TITEM_FLUXO where  ((data >= $perdtos1) and (data <= $perdtos2)) and  cnpjcpfseg='$info_cnpj_segmento' group by codigo_infcpl";


                         $selinfocpl = mysql_query("$xsql_d",$CONTITEM_FLUXO);
                         $tot_registro_bloco=0;

                         while ( $pinfocpl = mysql_fetch_array($selinfocpl) ) {
                               $codigo_infocpl=trim($pinfocpl[codigo_infcpl]);


                               $ind_emit=$pinfocpl[ind_emit];  // Somente para emissÃ£o de terceiros
                                                               // No C110 esta apresentando apenas para emissão própria,linha 973
                               if (!(empty($codigo_infocpl)) ) {
                                  $sql="SELECT  * from $TINFOCPL WHERE id = '".$codigo_infocpl."'";
                                  $result = mysql_query($sql);
                                  $info_cpl = mysql_fetch_array($result);
                                  $xinfcpl=_myfunc_removeacentos($info_cpl[historico]);
                                  if (!empty($xinfcpl)) {
                                   		$linha='|0450|'.$codigo_infocpl.'|'.$xinfcpl.'|';
                                        _matriz_linha($linha);
                                  }
                               }
                          }

 
                return;
}




//REGISTRO 0500: PLANO DE CONTAS CONTÁBEIS
/*
Este registro tem o objetivo de identificar as contas contábeis utilizadas pelo contribuinte informante em sua Contabilidade
Geral, no que se refere às contas referenciadas nos registros 0300, 0305, C170, C300, C350, C510, C610, D100, D300,
D400, D500, D510, D610, H010 e 1510.
*/
//PLANO DE CONTAS CONTÁBEIS
function sped_efd_registro_0500(){
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

       $cod_cta=trim($cod_cta);
         $nome_cta=trim($v['descricao']);
        

         $cnpj_est=$info_cnpj_segmento;
         $tamanho14=14;
         $cnpj_est=_myfunc_zero_a_esquerda($cnpj_est,$tamanho14) ;

        $linha='|'.'0500'.'|'.$dt_alt.'|'.$cod_nat_cc.'|'.$ind_cta.'|'.$nivel.'|'.$cod_cta.'|'.$nome_cta.'|';
         _matriz_linha($linha);
		   $tot_registro_bloco=$tot_registro_bloco+1;
             

	  }
   		   $REG_BLC[]='|0500|'.$tot_registro_bloco.'|';
 		   $qtd_lin_0=$qtd_lin_0+  $tot_registro_bloco;
        return;
}

//CENTRO DE CUSTOS
function sped_efd_registro_0600(){
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
		    
             

	  } 
          return;


}

//REGISTRO 0990: ENCERRAMENTO DO BLOCO 0
function sped_efd_registro_0990() {
                     global $info_segmento,$fp,$qtde_linha_bloco_0,$qtde_linha_bloco_c,$REG_BLC;
                     $qtde_linha_bloco=_myfunc_qtde_registro_matriz_linha_sped('0') + 1;
                     $linha='|0990|'.$qtde_linha_bloco.'|';
		     _matriz_linha($linha);

			echo "<br> BLOCO 0";
			flush();

 
                     return;
}

 

////////////////////////////////////////////////////////
//BLOCO C: DOCUMENTOS FISCAIS I - MERCADORIAS (ICMS/IPI)
////////////////////////////////////////////////////////


//REGISTRO C001: ABERTURA DO BLOCO C
sped_efd_registro_c001();



//REGISTRO C100: NOTA FISCAL (CÓDIGO 01), NOTA FISCAL AVULSA (CÓDIGO 1B), NOTA FISCAL DE PRODUTOR (CÓDIGO 04) E NFE (CÓDIGO 55).
sped_efd_registro_c100();


 
//  n3: REGISTRO C105  OPERAÇÕES COM ICMS ST RECOLHIDO PARA UF DIVERSA DO DESTINATÁRIO DO DOCUMENTO FISCAL (CÓDIGO 55).
 

//n3: REGISTRO C110: INFORMAÇÃO COMPLEMENTAR DA NOTA FISCAL (CÓDIGO 01, 1B, 04 e 55).
  // dentro do loop do c100
 
 
         //  n4: REGISTRO C111: PROCESSO REFERENCIADO  ?
         //  n4: REGISTRO C112: DOCUMENTO DE ARRECADAÇÃO REFERENCIADO. ?
         //  n4: REGISTRO C113: DOCUMENTO FISCAL REFERENCIADO. ?
         //  n4: REGISTRO C114: CUPOM FISCAL REFERENCIADO. ?
         //  n4: REGISTRO C115: LOCAL DA COLETA E/OU ENTREGA (CÓDIGO 01, 1B E 04). ?
     
     //  n3: REGISTRO C120: OPERAÇÕES DE IMPORTAÇÃO (CÓDIGO 01). ?
     
     //  n3: REGISTRO C130: ISSQN, IRRF E PREVIDÊNCIA SOCIAL.
     
     //  n3: REGISTRO C140: FATURA (CÓDIGO 01)
         // n4: REGISTRO C141: VENCIMENTO DA FATURA (CÓDIGO 01).
         
     //  n3: REGISTRO C160: VOLUMES TRANSPORTADOS (CÓDIGO 01 E 04) - EXCETO COMBUSTÍVEIS. ?
     
     //  n3: REGISTRO C165: OPERAÇÕES COM COMBUSTÍVEIS (CÓDIGO 01). ?
     
     //  n3: REGISTRO C170: ITENS DO DOCUMENTO (CÓDIGO 01, 1B, 04 e 55).

         // n4: REGISTRO C171: ARMAZENAMENTO DE COMBUSTIVEIS (código 01, 55).
         // n4: REGISTRO C172: OPERAÇÕES COM ISSQN (CÓDIGO 01)
     
         // n4: REGISTRO C173: OPERAÇÕES COM MEDICAMENTOS (CÓDIGO 01 e 55). ?
         // n4: REGISTRO C174: OPERAÇÕES COM ARMAS DE FOGO (CÓDIGO 01).  ?
         // n4: REGISTRO C175: OPERAÇÕES COM VEÍCULOS NOVOS (CÓDIGO 01 e 55). ?
         // n4: REGISTRO C176: RESSARCIMENTO DE ICMS EM OPERAÇÕES COM SUBSTITUIÇÃO TRIBUTÁRIA (CÓDIGO 01, 55). ?
         // n4: REGISTRO C177: OPERAÇÕES COM PRODUTOS SUJEITOS A SELO DE CONTROLE IPI. ?
         // n4: REGISTRO C178: OPERAÇÕES COM PRODUTOS SUJEITOS À TRIBUTAÇÀO DE IPI POR UNIDADE OU QUANTIDADE DE PRODUTO. ?
         // n4: REGISTRO C179: INFORMAÇÕES COMPLEMENTARES ST (CÓDIGO 01). ?
         

     // n3: REGISTRO C190: REGISTRO ANALÍTICO DO DOCUMENTO (CÓDIGO 01, 1B, 04 E 55).
         
     // n3: REGISTRO C195: OBSERVAÇOES DO LANÇAMENTO FISCAL (CÓDIGO 01,1B E 55) ?
        // n4 REGISTRO C197: OUTRAS OBRIGAÇÕES TRIBUTÁRIAS, AJUSTES E INFORMAÇÕESDE VALORES PROVENIENTES DE DOCUMENTO FISCAL. ?
       


// REGISTRO C300: RESUMO DIÁRIO DAS NOTAS FISCAIS DE VENDA A CONSUMIDOR (CÓDIGO 02)

 
 sped_efd_registro_c300();


// até c390

// REGISTRO C400- EQUIPAMENTO ECF (CÓDIGO 02 e 2D). Este registro tem por objetivo identificar os equipamentos de ECF e deve ser informado por
// Nivel - 2
sped_efd_registro_c400();

// REGISTRO C405 - REDUÇÃO Z CÓDIGO 02 e 2D)
// Nivel - 3
//sped_efd_registro_c405();
// até c495

// REGISTRO C500- ENERGIA
// Nivel - 2
sped_efd_registro_c500();

// ....

// REGISTRO C990: ENCERRAMENTO DO BLOCO C
sped_efd_registro_c990();



 




 // REGISTRO C001: ABERTURA DO BLOCO C
           function sped_efd_registro_c001() {
                    global $info_segmento,$fp,$qtde_linha_bloco_0,$qtde_linha_bloco_c,$REG_BLC;
                    $qtde_linha_bloco_c++      ;
                    $linha='|C001|0'.'|';
                    _matriz_linha($linha);
                    return;

                 }
                 



//DOCUMENTO - NOTA FISCAL(CÓDIGO 01),NOTA FISCAL AVULSA(CÓDIGO 1B), NOTA FISCAL DE PRODUTOR(CÓDIGO 04) E NFE(CÓDIGO 55)
function sped_efd_registro_C100(){
	global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS,$TNFDOCUMENTOS,$TITEM_FLUXO;
	global $TNFDOCUMENTOS_TMP,$TNFDOCUMENTOS,$CONTNFDOCUMENTOS;

 //   $modelos_inclusos="|01|1B|03|04|55|";  // 03 nao devia estar, mas propaganda , publicidade etc
   $modelos_inclusos="|01|1B|04|55|";  //

			$filtro_modelos=" and POSITION(a.modelo IN '$modelos_inclusos')>0";                                                                                                                                  
 
               
 
        $sql_lancamentos= _myfunc_sql_receitas_despesas_documentos('',"$filtro_modelos",'','','');
 
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

		    $vl_bc_icms_st=$v['svbcst'];
		    $vl_bc_icms_st=number_format($vl_bc_icms_st, 2, ',', '');

		    $vl_icms_st=$v['svicmsst'];
		    $vl_icms_st=number_format($vl_icms_st, 2, ',', '');

		    $vl_ipi=$v['svipi'];
		    $vl_ipi=number_format($vl_ipi, 2, ',', '');

		    $vl_pis=$v['svpis'];
		    $vl_pis=number_format($vl_pis, 2, ',', '');

		    $vl_cofins=$v['svcofins'];
		    $vl_cofins=number_format($vl_cofins, 2, ',', '');

		    $vl_pis_st=0.00; //$v['svpisst'];
		    $vl_pis_st=number_format($vl_pis_st, 2, ',', '');

		    $vl_cofins_st=0.00;
		    //$vl_cofins_st=number_format($vl_cofins_st, 2, ',', '');
		   $vl_doc=number_format($vl_doc, 2, ',', '');

		    $linha='|'.$reg.'|'.$ind_oper.'|'.$ind_emit.'|'.$cod_part.'|'.$cod_mod.'|'.$cod_sit.'|'.$ser.'|'
		   .$num_doc.'|'.$chv_nfe.'|'.$dt_doc.'|'.$dt_e_s.'|'.$vl_doc.'|'.$ind_pgto.'|'.$vl_desc.
		   '|'.$vl_abat_nt.'|'.$vl_merc.'|'.$ind_frt.'|'.$vl_frt.'|'.$vl_seg.'|'.$vl_out_da.
		   '|'.$vl_bc_icms.'|'.$vl_icms.'|'.$vl_bc_icms_st.'|'.$vl_icms_st.'|'.$vl_ipi.'|'
		   .$vl_pis.'|'.$vl_cofins.'|'.$vl_pis_st.'|'.$vl_cofins_st.'|';

		 
	  		_matriz_linha($linha);
	   


                                    //c110  filho
                                    //REGISTRO C110: INFORMAÇÃO COMPLEMENTAR DA NOTA FISCAL (CÓDIGO 01, 1B, 04 e 55).
                                    // Para código 55 (NFe) Informar apenas de emissão de terceiros
                                    if ($info_nfdocumentos[modelo]=='55' and $ind_emit=='0'){
                    					sped_efd_registro_C110($dono); //COMPLEMENTO DO DOCUMENTO - INFORMAÇÃO COMPLEMENTAR DA NF
                                    }
		  
		 if ($ind_oper=='0') { 
			sped_efd_registro_C170("$dono"); //COMPLEMENTO DO DOCUMENTO - ITENS DO DOCUMENTO
		}
		sped_efd_registro_C190("$dono"); //     REGISTRO ANALÍTICO DO DOCUMENTO (CÓDIGO 01, 1B, 04 E 55).

 }
          return ;

}


//REGISTRO C110: INFORMAÇÃO COMPLEMENTAR DA NOTA FISCAL (CÓDIGO 01, 1B, 04 e 55). N:3
function sped_efd_registro_C110($dono) {

                         global $info_segmento,$fp,$qtde_linha_bloco_0,$qtde_linha_bloco_c,$tot_registro_bloco_C110,$REG_BLC;
                         global $TINFOCPL,$TITEM_FLUXO,$TPRODUTOS ,$CONTITEM_FLUXO,$TSERVICOS,$info_cnpj_segmento,$perdtos1,$perdtos2,$TLANCAMENTOS;
                         $xsql_d="SELECT * FROM $TITEM_FLUXO where dono='$dono' and  cnpjcpfseg='$info_cnpj_segmento' group by codigo_infcpl";

                         $selinfocpl = mysql_query("$xsql_d",$CONTITEM_FLUXO);

                         while ( $pinfocpl = mysql_fetch_array($selinfocpl) ) {
                               $codigo_infocpl=trim($pinfocpl[codigo_infcpl]);
                               if (!(empty($codigo_infocpl))) {
                                  $sql="SELECT  * from $TINFOCPL WHERE id = '".$codigo_infocpl."'";
                                  $result = mysql_query($sql);
                                  $info_cpl = mysql_fetch_array($result);
                                  $xinfcpl=_myfunc_removeacentos($info_cpl[historico]);
                                  if (!empty($xinfcpl)) {
                                           $linha='|C110|'.$codigo_infocpl.'|'.$xinfcpl.'|';
                                          _matriz_linha($linha);
                                  }
                               }
                          }
                          



                return;
}

//COMPLEMENTO DO DOCUMENTO - ITENS DO DOCUMENTO (CÓDIGOS 01,1B,04 E 55)
function sped_efd_registro_C170($xdono){
	global $info_segmento,$fp,$REG_BLC,$TITEM_FLUXO,$CONTITEM_FLUXO,$TPRODUTOS,$TSERVICOS,$info_cnpj_segmento,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS;


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
                 //$punidade_d['vprod'];
                 $descr_compl=$punidade_d['xprod'];
                 $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

                 $vl_desc=$punidade_d['vdesc'];
                 $vl_desc=number_format(abs($vl_desc), 2, ",", "")  ;

                 

                 $ind_mov='0' ; //sim  TEVE FLUXO?  POR NATUREZA / CFOP  COMPLETAR  0 SIM  1 NAO
 
                
 
                 $cst_icms=$punidade_d['cst'];
		         if (strlen($cst_icms)<3) {
			         $cst_icms='0'.$cst_icms;
		         }
                
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

                 $vl_bc_icms_st=$punidade_d['vbcst']; //Somente para empresa Substituta tributária
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

                  $linha='|C170|'.$num_item.'|'.$cod_item.'|'.$descr_compl.'|'.$qtd.'|'.$unid.'|'.$vl_item.'|'.$vl_desc.'|'.$ind_mov.'|'.$cst_icms.'|'.$cfop.'|'.$cod_nat.'|'.$vl_bc_icms.'|'.$aliq_icms.'|'.$vl_icms.'|'.$vl_bc_icms_st.'|'.$aliq_st.'|'.$vl_icms_st.'|'.$ind_apur.'|'.$cst_ipi.'|'.$cod_enq.'|'.$vl_bc_ipi.'|'.$aliq_ipi.'|'.$vl_ipi.'|'.$cst_pis.'|'.$vl_bc_pis.'|'.$aliq_pis.'|'.$quant_bc_pis.'|'.$aliq_pis_quant.'|'.$vl_pis.'|'.$cst_cofins.'|'.$vl_bc_cofins.'|'.$aliq_cofins.'|'.$quant_bc_cofins.'|'.$aliq_cofins_quant.'|'.$vl_cofins.'|'.$cod_cta.'|';
   
                 _matriz_linha($linha);
        
                
	}
 
          return ;
    
 
}


 
//Registro C175:Veiculos -  Para Concessionária de veiculos novos

function sped_efd_registro_c175($xdono) {
                         global $info_segmento,$fp,$qtde_linha_bloco_c,$REG_BLC,$tot_registro_bloco_C175;
                         global $TITEM_FLUXO,$TPRODUTOS ,$CONTITEM_FLUXO,$TSERVICOS,$info_cnpj_segmento,$perdtos1,$perdtos2,$TLANCAMENTOS;
                         $xsql_d="SELECT a.*,b.codnat FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b where a.dono='$xdono' and a.dono=b.dono and b.contad<>'' and a.cnpjcpfseg='$info_cnpj_segmento'  order by a.dono,a.id";

                         $selunidade_d = mysql_query("$xsql_d",$CONTITEM_FLUXO);
                         $ordem_documento_emitido=0;
                         $xdono='######';
                         while ( $punidade_d = mysql_fetch_assoc($selunidade_d) ) {
                               if ($xdono<>$punidade_d[dono]) {
                                  $xdono=$punidade_d[dono];
                               }
                               $ind_veic_oper='3' ;
                               /*
                                0 - Venda para concessionária;
                                1 - Faturamento direto;
                                2 - Venda direta;
                                3 - Venda da concessionária;
                                9 - Outros.
                               */
                               $cnpj=$punidade_d[cnpjcpfseg];
                               $uf='MG';
                               $chassi_veic=$punidade_d[cprod];
                               
                               $linha1='|C175|'.$ind_veic_oper.'|'.$cnpj.'|'.$uf.'|'.$chassi_veic.'|';
                               _matriz_linha($linha);

                         }

 }

 
 //REGISTRO C190: REGISTRO ANALÍTICO DO DOCUMENTO (CÓDIGO 01,1B, 04 E 55).
 

function sped_efd_registro_C190($xdono){
	global $livro_reg,$info_segmento,$fp,$TITEM_FLUXO,$CONTITEM_FLUXO,$TPRODUTOS,$TSERVICOS,$info_cnpj_segmento,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS;
           
 		

 	$xsql_d=_myfunc_sql_receitas_despesas_itens('',$xdono);
    $xsql_d="SELECT *,sum(vprod) as vvprod,sum(vbc) as vvbc,sum(vicms) as vvicms,sum(vfrete) as vvfrete,sum(vseg) as vvseg,sum(voutro) as vvoutro,sum(vbcst) as vvbcst,sum(vicmsst) as vvicmsst,sum(vipi) as vvipi,sum(vdesc) as vvdesc FROM $livro_reg  group by cst,cfop,picms order by dono,cst,cfop,picms";
 
$selunidade_d=mysql_query("$xsql_d",$CONTITEM_FLUXO);
// $xsql_pdf="SELECT a.ucom,a.tipo_lancamento,a.qcom,a.cprod,c.movimento,a.conta_plano,a.dono,cfop,c.data,c.cnpjcpf,c.codnat,c.modelo,c.documento,picms,valiq_iss,'             ' as obs,$svsub_contabil, $svsub_isent_ntri , $svsub_pis_cofins FROM $TITEM_FLUXO  as a ,$lanca_pdf as c WHERE  a.dono=c.dono $filtro_movimento $filtro_segmento_relatorios_a";
  
                         while ( $punidade_d = mysql_fetch_assoc($selunidade_d) ) {

                              $cfop=$punidade_d[cfop];                              
                              $vvprod=($punidade_d[vvprod]+$punidade_d[vvfrete]+$punidade_d[vvseg]+$punidade_d[vvipi]+$punidade_d[vvicmsst]+$punidade_d[vvoutro])-$punidade_d[vvdesc];
                               if ($vvprod==0) {
                                   $vvprod='0';
                               }else{
                                   $vvprod=number_format(($vvprod), 2, ",", "")  ;
                               }


                               $cst=trim($punidade_d[cst]);
			                   if (strlen($cst)==2) {
					              $cst='0'. $cst;
				               }
                               $xalq_icms=$punidade_d[picms];
                               $xalq_icms=number_format(($xalq_icms), 2, ",", "")  ;
                              

                               $vl_icms=$punidade_d[vvicms];
                               if ($vl_icms==0) {
                                   $vl_icms='0';
                               }else{
                                   $vl_icms=number_format(abs($vl_icms), 2, ",", "")  ;
                               }

                               $vl_bc=$punidade_d[vvbc];
                               if ($vl_bc==0 or $vl_icms=='0'){
                                   $vl_bc='0';
                               }else{
                                   $vl_bc=number_format(($vl_bc), 2, ",", "")  ;
                               }

                               $vl_bcst=$punidade_d[vvbcst];
                               if ($vl_bcst==0) {
                                   $vl_bcst='0';
                               }else{
                                   $vl_bcst=number_format(($vl_bcst), 2, ",", "")  ;
                               }


                               $vl_icmsst=$punidade_d[vvicmsst];
                               if ($vl_icmsst==0) {
                                   $vl_icmsst='0';
                               }else{
                                    $vl_icmsst=number_format(($vl_icmsst), 2, ",", "") ;
                               }

                               $vl_ipi=$punidade_d[vvipi];
                               if ($vl_ipi==0) {
                                   $vl_ipi='0';
                               }else{
                                   $vl_ipi=number_format(($vl_ipi), 2, ",", "")  ;

                               }
                               
                               $vl_bcred=0.00;
                               if ($cst=='020' OR $cst=='070') {
                                  $vl_bcred=$vvprod-$vl_bc;
                                  }
                               if ($vl_bcred==0) {
                                   $vl_bcred='0';
                               }else{
                                   $vl_bcred=number_format(abs($vl_bcred), 2, ",", "")  ;
                               }

                               $cod_obs='';

                               $linha='|C190|'.$cst.'|'.$cfop.'|'.$xalq_icms.'|'.$vvprod.'|'.$vl_bc.'|'.$vl_icms.'|'.$vl_bcst.'|'.$vl_icmsst.'|'.$vl_bcred.'|'.$vl_ipi.'|'.$cod_obs.'|';
                               
                                 _matriz_linha($linha);
                         }

                         // REGISTRO C195: OBSERVAÇOES DO LANÇAMENTO FISCAL (CÓDIGO 01, 1B E 55)
                         // n:3
                         
                         // REGISTRO C197: OUTRAS OBRIGAÇÕES TRIBUTÁRIAS, AJUSTES E INFORMAÇÕES DE VALORES PROVENIENTES DE DOCUMENTO FISCAL.
                         // n:3
                         

 
}




 
// REGISTRO C300 - REGISTRO C300: RESUMO DIARIO DAS NOTAS FISCAIS DE VENDA A CONSUMIDOR (CODIGO 02)

// Nivel - 2
function sped_efd_registro_c300(){
	global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS,$TNFDOCUMENTOS,$TITEM_FLUXO;
	global $livro_reg,$TNFDOCUMENTOS_TMP,$TNFDOCUMENTOS,$CONTNFDOCUMENTOS;


   $modelos_inclusos="|02|";  //

			$filtro_lancamentos=" and POSITION(a.modelo IN '$modelos_inclusos')>0 ";                                                                                                                                  
 
           $sql_lancamentos= _myfunc_sql_receitas_despesas_documentos('RECEITAS',"$filtro_lancamentos",'','c.data,c.serie','c.data')   ;
 

$sql_c300="select * from $livro_reg ";
 
		 
			$sel_itens=mysql_query("$sql_c300");

 
    while ($v=mysql_fetch_assoc($sel_itens)) {

 
	    $dono=$v[dono];
	   // include('documentos_situacao_erp.php');
 
  

    $reg='C300';

    $movimento=$v['movimento'];

    $cod_mod=$v['modelo'];
    $cod_sit=(empty($v[cod_sit]))  ? '00' : $v[cod_sit];  // se for receitas ,emissão propria
    $ser=$v[serie];
    $sub='';
    $num_doc=$v[documento];
$sql_doc_i="select documento from $TLANCAMENTOS where data='$v[data]' and modelo='02' and movimento='RECEITAS' GROUP BY documento order by documento asc limit 1 ";
$sel_doc_i=mysql_query("$sql_doc_i");
$vdoc=mysql_fetch_assoc($sel_doc_i);
$num_doc_i=substr($vdoc[documento],-6);

$sql_doc_f="select documento from $TLANCAMENTOS where data='$v[data]' and modelo='02' and movimento='RECEITAS'  GROUP BY documento  order by documento desc limit 1 ";
$sel_doc_f=mysql_query("$sql_doc_f");
$vdoc=mysql_fetch_assoc($sel_doc_f);
$num_doc_f=substr($vdoc[documento],-6);

    $chv_nfe=$info_nfdocumentos['gerar_id'];
    $dt_doc=$v[data];
    $dt_doc=_myfunc_stod($dt_doc);
    $dt_doc=_myfunc_ddmmaaaa($dt_doc);
    $dt_e_s= $dt_doc;
    $vl_doc=($v[svprod]+$v[svfrete]+$v[svseg]+$v[svicmsst]+$v[svipi]+$v[svoutro])-$v[svdesc];
    $vl_desc=$v['svdesc'];
    $vl_desc=number_format($vl_desc, 2, ',', '');

	 

	    $vl_pis=$v['svpis'];


	    $vl_pis=number_format($vl_pis, 2, ',', '');
 

	    $vl_cofins=$v['svcofins'];
	    $vl_cofins=number_format($vl_cofins, 2, ',', '');

	   
  
   $vl_doc=number_format($vl_doc, 2, ',', '');

    $linha='|'.$reg.'|'.$cod_mod.'|'.$ser.'|'.$sub.'|'.$num_doc_i.'|'.$num_doc_f.'|'.$dt_doc.'|'.$vl_doc.'|'.$vl_pis.'|'.$vl_cofins.'|'.''.'|';

 
	  _matriz_linha($linha);
	   

 
		 
		sped_efd_registro_C320("$v[data]","$v[serie]"); //     REGISTRO ANALÍTICO DO itens modelo 02 reeitas na data e serie

		

 }
          return ;

}


// REGISTRO C320: REGISTRO ANALiTICO DO RESUMO DIaRIO DAS NOTAS     FISCAIS DE VENDA A CONSUMIDOR (CoDIGO 02).


// Nivel - 3
function sped_efd_registro_c320($data,$serie){
	global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS,$TNFDOCUMENTOS,$TITEM_FLUXO;
	global $livro_reg,$TNFDOCUMENTOS_TMP,$TNFDOCUMENTOS,$CONTNFDOCUMENTOS,$info_cnpj_segmento;


   $modelos_inclusos="|02|";  //

			$filtro_lancamentos="POSITION(modelo IN '$modelos_inclusos')>0 and cnpjcpfseg='$info_cnpj_segmento' and movimento='RECEITAS' and data='$data' and serie='$serie' ";                                                                                                                                  


	  $xsql_pdf="SELECT  dono,data,cnpjcpf,codnat,modelo,documento,movimento,cod_sit,serie FROM $TLANCAMENTOS as a WHERE  lan_impostos<>'S' and valor>0 and $filtro_lancamentos   group by dono";


	  $lanca_pdf='lanca_pdf_'.$info_cnpj;
          $sql="drop table IF EXISTS $lanca_pdf";
    	  if ( mysql_query($sql) or die (mysql_error()) ) {
          }
          $sql_tab_tmp="create  temporary   table $lanca_pdf as $xsql_pdf";
	  if ( mysql_query($sql_tab_tmp) or die (mysql_error()) ) {
  	  }


  
  $svsub_contabil="sum(vprod) as svprod,sum(vfrete) as svfrete,sum(vseg) as svseg,sum(vdesc) as svdesc,sum(vbc) as svbc,sum(vicms) as svicms,sum(vissqn) as svissqn";
          $svsub_isent_ntri="sum(vbcst) as svbcst,sum(vicmsst) as svicmsst, sum(vipi) as svipi";
          $svsub_pis_cofins="sum(vbc_pis) as svbc_pis,sum(vpis) as svpis,sum(vbc_cofins) as svbc_cofins,sum(vcofins) as svcofins,sum(vbc_iss) as svbc_iss,sum(vpisst) as svpisst,sum(vcofinsst) as svcofinsst";

$sql_c320="select $svsub_contabil, $svsub_isent_ntri , $svsub_pis_cofins  from $lanca_pdf as b, $TITEM_FLUXO as a where a.dono=b.dono group by a.cst,a.cfop,a.picms ";
 
 
		 
			$sel_itens=mysql_query("$sql_c320");

 
    while ($v=mysql_fetch_assoc($sel_itens)) {

  
 
  

    $reg='C320';

    $movimento=$v['movimento'];
    $cst_icms=$v[cst];
    $cfop=$v[cfop];
    $picms=$v[picms];
    $picms=number_format(abs($picms), 2, ",", "")  ;
    $vl_doc=($v[svprod]+$v[svfrete]+$v[svseg]+$v[svicmsst]+$v[svipi]+$v[svoutro])-$v[svdesc];
  
	$v_bcicms=$v[svbc];
    $v_bcicms=number_format(abs($v_bcicms), 2, ",", "")  ;

	$v_vicms=$v[svicms];
    $v_vicms=number_format(abs($v_vicms), 2, ",", "")  ;

$v_red_bc=$vl_doc-$v[svbc];
    $v_red_bc=number_format(abs($v_red_bc), 2, ",", "")  ;

   $vl_doc=number_format(abs($vl_doc), 2, ",", "")  ;
$obs='';

      
    $linha='|'.$reg.'|'.$cst_icms.'|'.$cfop.'|'.$picms.'|'.$vl_doc.'|'.$v_bcicms.'|'.$v_vicms.'|'.$v_red_bc.'|'.$obs.'|';

	  _matriz_linha($linha);
	   
	sped_efd_registro_C321("$data","$serie"); //     REGISTRO C321: ITENS DO RESUMO DIaRIO DOS DOCUMENTOS (CoDIGO  02).
 
		 
 }
          return ;

}

// REGISTRO C321: ITENS DO RESUMO DIaRIO DOS DOCUMENTOS (CoDIGO  02).



// Nivel - 4
function sped_efd_registro_c321($data,$serie){
	global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS,$TNFDOCUMENTOS,$TITEM_FLUXO;
	global $livro_reg,$TNFDOCUMENTOS_TMP,$TNFDOCUMENTOS,$CONTNFDOCUMENTOS,$info_cnpj_segmento;


   $modelos_inclusos="|02|";  //

			$filtro_lancamentos="POSITION(modelo IN '$modelos_inclusos')>0 and cnpjcpfseg='$info_cnpj_segmento' and movimento='RECEITAS' and data='$data' and serie='$serie' ";                                                                                                                                  


	  $xsql_pdf="SELECT  dono,data,cnpjcpf,codnat,modelo,documento,movimento,cod_sit,serie FROM $TLANCAMENTOS as a WHERE  lan_impostos<>'S' and valor>0 and $filtro_lancamentos   group by dono";


	  $lanca_pdf='lanca_pdf_'.$info_cnpj;
          $sql="drop table IF EXISTS $lanca_pdf";
    	  if ( mysql_query($sql) or die (mysql_error()) ) {
          }
          $sql_tab_tmp="create  temporary   table $lanca_pdf as $xsql_pdf";
	  if ( mysql_query($sql_tab_tmp) or die (mysql_error()) ) {
  	  }
 
$sql_c321="select a.* from $lanca_pdf as b, $TITEM_FLUXO as a where a.dono=b.dono  ";

 
 
		 
			$sel_itens=mysql_query("$sql_c321");

 
    while ($v=mysql_fetch_assoc($sel_itens)) {

  
 
  

    $reg='C321';

    $movimento=$v['movimento'];
    $cod_item=$v[cprod];
    $qtd=$v[qcom];
 $qtd=number_format(abs($qtd), 3, ",", "")  ;
    $unid=$v[unidade];
    $picms=number_format(abs($picms), 2, ",", "")  ;
    $vl_item=($v[vprod]+$v[vfrete]+$v[vseg]+$v[vicmsst]+$v[vipi]+$v[voutro])-$v[vdesc];
     $vl_desc=$v[vdesc];
     $vl_bc_icms=$v[vbc];
     $vl_icms=$v[vicms];
     $vl_pis=$v[vpis];
     $vl_cofins=$v[vcofins];

$vl_item=number_format(abs($vl_item), 2, ",", "")  ;
$vl_desc=number_format(abs($vl_desc), 2, ",", "")  ;
$vl_bc_icms=number_format(abs($vl_bc_icms), 2, ",", "")  ;
$vl_icms=number_format(abs($vl_icms), 2, ",", "")  ;


$vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;
$vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;
      
    $linha='|'.$reg.'|'.$cod_item.'|'.$qtd.'|'.$unid.'|'.$vl_item.'|'.$vl_desc.'|'.$vl_bc_icms.'|'.$vl_icms.'|'.$vl_pis.'|'.$vl_cofins.'|';

	  _matriz_linha($linha);
	   

 
		 
 }
          return ;

}



 
// REGISTRO C400 - EQUIPAMENTO ECF (CÓDIGO 02 e 2D)
// Nivel - 2
function sped_efd_registro_c400(){
         global $info_segmento,$info_cnpj_segmento,$fp,$qtde_linha_bloco_0,$qtde_linha_bloco_c,$pcind_perfil,$REG_BLC;
         global $TITEM_FLUXO,$CONTITEM_FLUXO,$TMAPA_RESUMO,$CONTMAPA_RESUMO,$TLANCAMENTOS,$TNFDOCUMENTOS,$perdtos1,$perdtos2,$lanperiodo1,$lanperiodo2,$dtreducaoz;
         global $tot_registro_bloco_C400,$tot_registro_bloco_C405,$tot_registro_bloco_C410,$tot_registro_bloco_C420,$tot_registro_bloco_C425,$tot_registro_bloco_C460,$tot_registro_bloco_C470,$tot_registro_bloco_C490,$tot_registro_bloco_C495;

         $tot_registro_bloco_C400=0;
         $tot_registro_bloco_C405=0;
         $tot_registro_bloco_C410=0;
         $tot_registro_bloco_C420=0;
         $tot_registro_bloco_C425=0;
         $tot_registro_bloco_C460=0;
         $tot_registro_bloco_C470=0;
         $tot_registro_bloco_C490=0;
         $tot_registro_bloco_C495=0;

         $xsql="SELECT * FROM $TMAPA_RESUMO where cnpjcpfseg='$info_cnpj_segmento' and ((dt_mapa >= $perdtos1) and (dt_mapa <= $perdtos2)) group by serial_imp";

         $seleC400 = mysql_query("$xsql",$CONTMAPA_RESUMO);

         while ( $info_C400 = mysql_fetch_assoc($seleC400) ) {

              $cod_mod='2D';
              $ecf_mod='MP 2100 TH FI';
              $ecf_fab=$info_C400[serial_imp];
              $ecf_cx=$info_C400[numif];

              $linha1='|C400|'.$cod_mod.'|'.$ecf_mod.'|'.$ecf_fab.'|'.$ecf_cx.'|';
           //   $qtde_linha_bloco_c++;
          //    $escreve = fwrite($fp, "$linha1"."\r\n");
          //    $tot_registro_bloco_C400=$tot_registro_bloco_C400+1;

	  _matriz_linha($linha1);

              // Para ser usado no c425 , estava demorando demais o processamento
              // Temporaria LANCAMENTOS para agilizar esta pesquisa
              $xsql_p_lan="SELECT documento,modelo,dono,data,cnpjcpfseg,cod_sit FROM $TLANCAMENTOS where modelo='2D' and cnpjcpfseg='$info_cnpj_segmento'  and ((data >= $perdtos1) and (data <= $perdtos2)) and contad<>'' and SUBSTRING(dono,1,3)='LAN' group by dono order by dono ASC";
              $sql_error='';
              $sql="drop table IF EXISTS tabela_lan_prov";  // apaga anterior
              if ( mysql_query($sql) or die (mysql_error()) ) {
                  }
              $sql_lan_provisorio="create table tabela_lan_prov($xsql_p_lan)";
              if ( mysql_query($sql_lan_provisorio) or die (mysql_error()) ) {
                 }
              // Fim temporario LANCAMENTOS


              $xsql_ifc425="SELECT a.*,b.modelo,b.data as data_e_s,b.cod_sit,b.documento,c.ecf_numimp as serial_imp,FROM_UNIXTIME(a.data,'%d/%m/%Y')  FROM $TITEM_FLUXO as a,tabela_lan_prov as b,$TNFDOCUMENTOS as c where a.cnpjcpfseg='$info_cnpj_segmento' and b.modelo='2D' and (a.dono=b.dono and a.dono=c.dono) and (a.data >= '$perdtos1' and a.data<='$perdtos2') order by a.id";
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
               sped_efd_registro_c405($ecf_fab);
              // até c495


         }
         /*else
         {
              echo '<br>.* Não encontrado MAPA RESUMO para o período';
         }*/

        if ($tot_registro_bloco_C400>0) {
            $REG_BLC[]='|C400|'.$tot_registro_bloco_C400.'|';
        }
        if ($tot_registro_bloco_C405>0) {
             $REG_BLC[]='|C405|'.$tot_registro_bloco_C405.'|';
        }
        if ($tot_registro_bloco_C410>0) {
             $REG_BLC[]='|C410|'.$tot_registro_bloco_C410.'|';
        }
        if ($tot_registro_bloco_C420>0) {
             $REG_BLC[]='|C420|'.$tot_registro_bloco_C420.'|';
        }
        if ($tot_registro_bloco_C425>0) {
             $REG_BLC[]='|C425|'.$tot_registro_bloco_C425.'|';
        }
        if ($tot_registro_bloco_C460>0) {
             $REG_BLC[]='|C460|'.$tot_registro_bloco_C460.'|';
        }
        if ($tot_registro_bloco_C470>0) {
            $REG_BLC[]='|C470|'.$tot_registro_bloco_C470.'|';
        }
        if ($tot_registro_bloco_C490>0) {
                $REG_BLC[]='|C490|'.$tot_registro_bloco_C490.'|';
        }
        if ($tot_registro_bloco_C495>0) {
                $REG_BLC[]='|C495|'.$tot_registro_bloco_C495.'|';
        }

        return;

}

// REGISTRO C405 - REDUÇÃO Z CÓDIGO 02 e 2D)
// Nivel - 3
function sped_efd_registro_c405($ecf_fab){
         global $info_segmento,$fp,$qtde_linha_bloco_0,$qtde_linha_bloco_c,$pcind_perfil,$tot_registro_bloco_C405,$REG_BLC;
         global $TITEM_FLUXO,$CONTITEM_FLUXO,$info_cnpj_segmento,$perdtos1,$perdtos2,$dtreducaoz,$serialimpressora,$TMAPA_RESUMO,$CONTMAPA_RESUMO;

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


                $linha1='|C405|'.$dt_doc.'|'.$cro.'|'.$crz.'|'.$num_coo_fin.'|'.$gt_fin.'|'.$vl_brt.'|';
	  _matriz_linha($linha1);
// //               $qtde_linha_bloco_c++;
    //            $escreve = fwrite($fp, "$linha1\r\n");
                $tot_registro_bloco_C405=$tot_registro_bloco_C405+1;

                // REGISTRO C410 - PIS COFINS TOTALIZADOS NO DIA (CÓDIGO 02 e 2D)
                // Nivel - 4
                sped_efd_registro_c410($dtreducaoz,$serialimpressora);

                // REGISTRO C420 - REGISTRO DOS TOTALIZADORES PARCIAIS DA REDUÇÃO Z (CÓDIGO 02 e 2D)
                // Nivel - 4
                sped_efd_registro_c420($dtreducaoz,$serialimpressora);

                // REGISTRO C460 - DOCUMENTOS FISCAIS EMITIDOS POR ECF (CÓDIGO 02 e 2D)
                // Nivel - 4
                if($pcind_perfil=='A')
                {
                  $filtroaliq="and ecf_numimp='$serialimpressora'"; // para filhos
                  sped_efd_registro_c460($dtreducaoz,$serialimpressora);
                }

                // C490   filho -4 (c405)
                //REGISTRO C490: REGISTRO ANALITICO DO MOVIMENTO DIARIO (CÓDIGO 02, 2D)
                $filtroaliq="and ecf_numimp='$serialimpressora'"; // para filhos
                sped_efd_registro_c490($dtreducaoz,$serialimpressora);

             }
        }


        return;


}

// REGISTRO C410 - PIS COFINS TOTALIZADOS NO DIA (CÓDIGO 02 e 2D)
// Nivel - 4
function sped_efd_registro_c410(){
         global $info_segmento,$fp,$qtde_linha_bloco_0,$qtde_linha_bloco_c,$tot_registro_bloco_C410,$REG_BLC;
         global $TITEM_FLUXO,$CONTITEM_FLUXO,$info_cnpj_segmento,$perdtos1,$perdtos2,$dtreducaoz,$serialimpressora;
         $xsql="SELECT sum(vpis) as svpis,sum(vcofins) as svcofins FROM tabela_c425_provisorio where data = '$dtreducaoz' and serial_imp='$serialimpressora' group by data order by id";

         $sele410 = mysql_query("$xsql",$CONTITEM_FLUXO);
         while ( $ppis = mysql_fetch_assoc($sele410) ) {
            if ($ppis[svpis]>0) {
                $vl_pis=$ppis[svpis];
                $vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;
                if ($vl_pis==0) {
                     $vl_pis='0';
                }

                $vl_cofins=$ppis[svcofins];
                $vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;
                if ($vl_cofins==0) {
                      $vl_cofins='0';
                }

                $linha1='|C410|'.$vl_pis.'|'.$vl_cofins.'|';
	  _matriz_linha($linha1);
//                $qtde_linha_bloco_c++;
  //              $escreve = fwrite($fp, "$linha1"."\r\n");
    //            $tot_registro_bloco_C410=$tot_registro_bloco_C410+1;
             }
        }



}

// REGISTRO C420 - REGISTRO DOS TOTALIZADORES PARCIAIS DA REDUÇÃO Z (CÓDIGO 02 e 2D)
// Nivel - 4
function sped_efd_registro_c420(){
         global $info_segmento,$fp,$qtde_linha_bloco_0,$qtde_linha_bloco_c,$tot_registro_bloco_C420,$pcind_perfil,$REG_BLC;
         global $TITEM_FLUXO,$CONTITEM_FLUXO,$info_cnpj_segmento,$perdtos1,$perdtos2,$dtreducaoz,$serialimpressora,$TMAPA_RESUMO;
         $xsql="SELECT * from $TMAPA_RESUMO where cnpjcpfseg='$info_cnpj_segmento'  and dt_mapa = '$dtreducaoz' and serial_imp='$serialimpressora'";

         $sele420 = mysql_query("$xsql",$CONTITEM_FLUXO);
         while ( $pc420 = mysql_fetch_assoc($sele420) ) {

            if ($pc420[canc]>0) { // CANCELAMENTOS
                $cod_tot_par='Can-T';

                $vl_acum_tot=$pc420[canc];
                $vl_acum_tot=number_format(abs($vl_acum_tot), 2, ",", "")  ;

                $nr_tot='';
                $descr_nr_tot='';

                $linha1='|C420|'.$cod_tot_par.'|'.$vl_acum_tot.'|'.$nr_tot.'|'.$descr_nr_tot.'|';
	  _matriz_linha($linha1);
             //   $qtde_linha_bloco_c++;
              //  $escreve = fwrite($fp, "$linha1"."\r\n");
              //  $tot_registro_bloco_C420=$tot_registro_bloco_C420+1;
             }

            if ($pc420[desconto]>0) { // DESCONTOS tributados ICMS
                $cod_tot_par='DT';

                $vl_acum_tot=$pc420[desconto];
                $vl_acum_tot=number_format(abs($vl_acum_tot), 2, ",", "")  ;

                $nr_tot='';
                $descr_nr_tot='';

                $linha1='|C420|'.$cod_tot_par.'|'.$vl_acum_tot.'|'.$nr_tot.'|'.$descr_nr_tot.'|';
	  _matriz_linha($linha1);
          //      $qtde_linha_bloco_c++;
           //     $escreve = fwrite($fp, "$linha1"."\r\n");
            //    $tot_registro_bloco_C420=$tot_registro_bloco_C420+1;
             }

            if ($pc420[subst]>0) { // Substituição Tributaria-ICMS
                $cod_tot_par='F1';

                $vl_acum_tot=$pc420[subst];
                $vl_acum_tot=number_format(abs($vl_acum_tot), 2, ",", "")  ;

                $nr_tot='';
                $descr_nr_tot='';//Substituição Tributaria-ICMS';

                $linha1='|C420|'.$cod_tot_par.'|'.$vl_acum_tot.'|'.$nr_tot.'|'.$descr_nr_tot.'|';
	  _matriz_linha($linha1);
            //    $qtde_linha_bloco_c++;
            //    $escreve = fwrite($fp, "$linha1"."\r\n");
            //    $tot_registro_bloco_C420=$tot_registro_bloco_C420+1;


                $npbx='060';
                // REGISTRO C425 - RESUMO DOS ITENS DO MOVIMENTO DIARIO (CÓDIGO 02 e 2D)
                if($pcind_perfil=='B')
                {

                   $filtroaliq="and cst='$npbx' and serial_imp='$serialimpressora'"; // para filhos
                   sped_efd_registro_c425($dtreducaoz,$filtroaliq);
                }

             }

            if ($pc420[isen]>0) { // Isento-ICMS
                $cod_tot_par='I1';

                $vl_acum_tot=$pc420[isen];
                $vl_acum_tot=number_format(abs($vl_acum_tot), 2, ",", "")  ;

                $nr_tot='';
                $descr_nr_tot='';//Isento-ICMS';

                $linha1='|C420|'.$cod_tot_par.'|'.$vl_acum_tot.'|'.$nr_tot.'|'.$descr_nr_tot.'|';
	  _matriz_linha($linha1);
//                $qtde_linha_bloco_c++;
 //               $escreve = fwrite($fp, "$linha1"."\r\n");
  //              $tot_registro_bloco_C420=$tot_registro_bloco_C420+1;

                $npbx='030';
                // REGISTRO C425 - RESUMO DOS ITENS DO MOVIMENTO DIARIO (CÓDIGO 02 e 2D)
                if($pcind_perfil=='B')
                {
                    $filtroaliq="and cst='$npbx' and serial_imp='$serialimpressora'"; // para filtro no c425
                    sped_efd_registro_c425($dtreducaoz,$filtroaliq);
                }

             }

            if ($pc420[b1]>0) { // Não-incidencia-ICMS
                $cod_tot_par='N1';

                $vl_acum_tot=$pc420[b1];
                $vl_acum_tot=number_format(abs($vl_acum_tot), 2, ",", "")  ;

                $nr_tot='';
                $descr_nr_tot='';//Não-incidencia-ICMS';

                $linha1='|C420|'.$cod_tot_par.'|'.$vl_acum_tot.'|'.$nr_tot.'|'.$descr_nr_tot.'|';
	  _matriz_linha($linha1);
//                $qtde_linha_bloco_c++;
 //               $escreve = fwrite($fp, "$linha1"."\r\n");
  //              $tot_registro_bloco_C420=$tot_registro_bloco_C420+1;

                $npbx='040';
                // REGISTRO C425 - RESUMO DOS ITENS DO MOVIMENTO DIARIO (CÓDIGO 02 e 2D)
                if($pcind_perfil=='B')
                {
                   $filtroaliq="and (cst='$npbx' or cst='041' or cst='070' or cst='051' or cst='050') and serial_imp='$serialimpressora'"; // para filtro no c425
                   sped_efd_registro_c425($dtreducaoz,$filtroaliq);
                }

             }


            if ($pc420[b2]>0) { // Tributados   - 1
                $npb2=$pc420[pb2]/100;
                $npbx=number_format(abs($npb2), 2, ".", "")  ;

                $filtroaliq="and picms='$npbx'";

                $pb2=$pc420[pb2];
                $tamanho4=4;
                $pb2=_myfunc_zero_a_esquerda($pb2,$tamanho4) ;

                $nr_tot='';
                switch($pb2){
                    case "0700":
                      $nr_tot='01';
                      break;
                    case "0720":
                      $nr_tot='01';
                      break;
                    case "1200":
                      $nr_tot='02';
                      break;
                    case "1700":
                      $nr_tot='02'; // Devido a GO
                      break;
                    case "1800":
                      $nr_tot='03';
                      break;

                }

                $descr_nr_tot='';

                $cod_tot_par='T'.$pb2;

                $vl_acum_tot=$pc420[b2];
                $vl_acum_tot=number_format(abs($vl_acum_tot), 2, ",", "")  ;

                $linha1='|C420|'.$cod_tot_par.'|'.$vl_acum_tot.'|'.$nr_tot.'|'.$descr_nr_tot.'|';
	  _matriz_linha($linha1);
//                $qtde_linha_bloco_c++;
  //              $escreve = fwrite($fp, "$linha1"."\r\n");
    //            $tot_registro_bloco_C420=$tot_registro_bloco_C420+1;

                // REGISTRO C425 - RESUMO DOS ITENS DO MOVIMENTO DIARIO (CÓDIGO 02 e 2D)
                if($pcind_perfil=='B')
                {
                   $filtroaliq="and picms='$npbx'";
                   if($npbx=='12.00' and $info_cnpj_segmento=='03116557000180'){
                      $npbx='18.00';
                      $filtroaliq="and picms='$npbx' and cst='020'";
                   }

                   $filtroaliq=$filtroaliq." and serial_imp='$serialimpressora'"; // para filtro no c425
                   sped_efd_registro_c425($dtreducaoz,$filtroaliq);
                }

             }

            if ($pc420[b3]>0) { // Tributados - 2
                $npb3=$pc420[pb3]/100;
                $npbx=number_format(abs($npb3), 2, ".", "")  ;

                $pb3=$pc420[pb3];
                $tamanho4=4;
                $pb3=_myfunc_zero_a_esquerda($pb3,$tamanho4) ;

                $nr_tot='';
                switch($pb3){
                    case "0700":
                      $nr_tot='01';
                      break;
                    case "0720":
                      $nr_tot='01';
                      break;
                    case "1200":
                      $nr_tot='02';
                      break;
                    case "1700":
                      $nr_tot='02'; // Devido a GO
                      break;
                    case "1800":
                      $nr_tot='03';
                      break;
                }

                $descr_nr_tot='';

                $cod_tot_par='T'.$pb3;

                $vl_acum_tot=$pc420[b3];
                $vl_acum_tot=number_format(abs($vl_acum_tot), 2, ",", "")  ;

                $linha1='|C420|'.$cod_tot_par.'|'.$vl_acum_tot.'|'.$nr_tot.'|'.$descr_nr_tot.'|';
	  _matriz_linha($linha1);
//                $qtde_linha_bloco_c++;
  //              $escreve = fwrite($fp, "$linha1"."\r\n");
    //            $tot_registro_bloco_C420=$tot_registro_bloco_C420+1;

                // REGISTRO C425 - RESUMO DOS ITENS DO MOVIMENTO DIARIO (CÓDIGO 02 e 2D)
                if($pcind_perfil=='B')
                {
                   $filtroaliq="and picms='$npbx'";
                   if($npbx=='12.00' and $info_cnpj_segmento=='03116557000180'){
                      $npbx='18.00';
                      $filtroaliq="and picms='$npbx' and cst='020'";
                   }

                   $filtroaliq=$filtroaliq." and serial_imp='$serialimpressora'"; // para filtro no c425
                   sped_efd_registro_c425($dtreducaoz,$filtroaliq);
                }

             }

            if ($pc420[b4]>0) { // Tributados - 3
                $npb4=intval($pc420[pb4]/100);
                $npbx=number_format(abs($npb4), 2, ".", "")  ;

                $pb4=$pc420[pb4];
                $tamanho4=4;
                $pb4=_myfunc_zero_a_esquerda($pb4,$tamanho4) ;

                $nr_tot='';
                switch($pb4){
                    case "0700":
                      $nr_tot='01';
                      break;
                    case "0720":
                      $nr_tot='01';
                      break;
                    case "1200":
                      $nr_tot='02';
                      break;
                    case "1700":
                      $nr_tot='02'; // Devido a GO
                      break;
                    case "1800":
                      $nr_tot='03';
                      break;
                }

                $descr_nr_tot='';

                $cod_tot_par='T'.$pb4;

                $vl_acum_tot=$pc420[b4];
                $vl_acum_tot=number_format(abs($vl_acum_tot), 2, ",", "")  ;

                $linha1='|C420|'.$cod_tot_par.'|'.$vl_acum_tot.'|'.$nr_tot.'|'.$descr_nr_tot.'|';
	  _matriz_linha($linha1);
//                $qtde_linha_bloco_c++;
  //              $escreve = fwrite($fp, "$linha1"."\r\n");
    //            $tot_registro_bloco_C420=$tot_registro_bloco_C420+1;

                // REGISTRO C425 - RESUMO DOS ITENS DO MOVIMENTO DIARIO (CÓDIGO 02 e 2D)
                if($pcind_perfil=='B')
                {
                   $filtroaliq="and picms='$npbx'" ;
                   if($npbx=='12.00' and $info_cnpj_segmento=='03116557000180'){
                      $npbx='18.00';
                      $filtroaliq="and picms='$npbx' and cst='020'";
                   }

                   $filtroaliq=$filtroaliq." and serial_imp='$serialimpressora'"; // para filtro no c425
                   sped_efd_registro_c425($dtreducaoz,$filtroaliq);
                }

             }

            if ($pc420[b5]>0) { // Tributados - 4
                $npb5=intval($pc420[pb5]/100);
                $npbx=number_format(abs($npb5), 2, ".", "")  ;

                $pb5=$pc420[pb5];
                $tamanho4=4;
                $pb5=_myfunc_zero_a_esquerda($pb5,$tamanho4) ;

                $nr_tot='';
                switch($pb5){
                    case "0700":
                      $nr_tot='01';
                      break;
                    case "0720":
                      $nr_tot='01';
                      break;
                    case "1200":
                      $nr_tot='02';
                      break;
                    case "1700":
                      $nr_tot='02'; // Devido a GO
                      break;
                    case "1800":
                      $nr_tot='03';
                      break;
                }

                $descr_nr_tot='';

                $cod_tot_par='T'.$pb5;

                $vl_acum_tot=$pc420[b5];
                $vl_acum_tot=number_format(abs($vl_acum_tot), 2, ",", "")  ;

                $linha1='|C420|'.$cod_tot_par.'|'.$vl_acum_tot.'|'.$nr_tot.'|'.$descr_nr_tot.'|';
	  _matriz_linha($linha1);
//                $qtde_linha_bloco_c++;
  //              $escreve = fwrite($fp, "$linha1"."\r\n");
    //            $tot_registro_bloco_C420=$tot_registro_bloco_C420+1;

                // REGISTRO C425 - RESUMO DOS ITENS DO MOVIMENTO DIARIO (CÓDIGO 02 e 2D)
                if($pcind_perfil=='B')
                {
                   $filtroaliq="and picms='$npbx'" ;
                   if($npbx=='12.00' and $info_cnpj_segmento=='03116557000180'){
                      $npbx='18.00';
                      $filtroaliq="and picms='$npbx' and cst='020'";
                   }

                   $filtroaliq=$filtroaliq." and serial_imp='$serialimpressora'"; // para filtro no c425
                   sped_efd_registro_c425($dtreducaoz,$filtroaliq);
                }

             }


            if ($pc420[b6]>0) { // Tributados - 5
                $npb6=intval($pc420[pb6]/100);
                $npbx=number_format(abs($npb6), 2, ".", "")  ;


                $pb6=$pc420[pb6];
                $tamanho4=4;
                $pb6=_myfunc_zero_a_esquerda($pb6,$tamanho4);

                $nr_tot='';
                switch($pb6){
                    case "0700":
                      $nr_tot='01';
                      break;
                    case "0720":
                      $nr_tot='01';
                      break;
                    case "1200":
                      $nr_tot='02';
                      break;
                    case "1700":
                      $nr_tot='02'; // Devido a GO
                      break;
                    case "1800":
                      $nr_tot='03';
                      break;
                }

                $descr_nr_tot='';

                $cod_tot_par='T'.$pb6;

                $vl_acum_tot=$pc420[b6];
                $vl_acum_tot=number_format(abs($vl_acum_tot), 2, ",", "")  ;

                $linha1='|C420|'.$cod_tot_par.'|'.$vl_acum_tot.'|'.$nr_tot.'|'.$descr_nr_tot.'|';
	  _matriz_linha($linha1);
          //      $qtde_linha_bloco_c++;
      //          $escreve = fwrite($fp, "$linha1"."\r\n");
        //        $tot_registro_bloco_C420=$tot_registro_bloco_C420+1;

                // REGISTRO C425 - RESUMO DOS ITENS DO MOVIMENTO DIARIO (CÓDIGO 02 e 2D)
                if($pcind_perfil=='B')
                {

                   $filtroaliq="and picms='$npbx'";
                   if($npbx=='12.00' and $info_cnpj_segmento=='03116557000180'){
                      $npbx='18.00';
                      $filtroaliq="and picms='$npbx' and cst='020'";
                   }

                   $filtroaliq=$filtroaliq." and serial_imp='$serialimpressora'"; // para filtro no c425
                   sped_efd_registro_c425($dtreducaoz,$filtroaliq);
                }

             }


        }



}


// REGISTRO C425 - RESUMO DOS ITENS DO MOVIMENTO DIARIO (CÓDIGO 02 e 2D)
// Nivel - 5
function sped_efd_registro_c425($dtreducaoz,$filtroaliq){
                         global $info_segmento,$fp,$qtde_linha_bloco_0,$qtde_linha_bloco_c,$tot_registro_bloco_C425,$serialimpressora,$REG_BLC;
                         global $TITEM_FLUXO,$TLANCAMENTOS,$CONTITEM_FLUXO,$info_cnpj_segmento,$perdtos1,$perdtos2,$dtreducaoz,$serialimpressora;

                         $xsql_z="SELECT picms,cst,ucom,cprod,xprod,vuncom,cean,sum(qcom) as sqcom,sum(vprod-vdesc) as svprod,sum(vpis) as svpis,sum(vcofins) as svcofins,sum(vdesc) as svdesc,modelo FROM tabela_c425_provisorio where data='$dtreducaoz' $filtroaliq group by data,cprod order by id";

                         $selunidade_z = mysql_query("$xsql_z",$CONTITEM_FLUXO);
                         while ( $punidade_d = mysql_fetch_assoc($selunidade_z)) {

                               $picms=$punidade_d[picms];

                               $qcom=$punidade_d[sqcom];
                               $qcom=number_format(abs($qcom), 3, ",", "");

                               $cprod=$punidade_d[cprod];
                               $unidade=$punidade_d[ucom];


                               $vl_item=$punidade_d[svprod];//-$punidade_d[svdesc];
                               if ($vl_item==0) {
                                   $vl_item='0';
                               }else{
                                   $vl_item=number_format(abs($vl_item), 2, ",", "")  ;
                               }


                               $vl_pis=$punidade_d[svpis];
                               $vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;
                               if ($vl_pis==0) {
                                   $vl_pis='0';
                               }

                               $vl_cofins=$punidade_d[svcofins];
                               $vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;
                               if ($vl_cofins==0) {
                                   $vl_cofins='0';
                               }

                               if ($punidade_z[cean]<>''){ // Caso tenha o cean pegar ele devido a entrada pelo xml
                                   $cprod=$punidade_d[cean];
                               }else{
                                   $cprod=$punidade_d[cprod];
                               }

                               $linha1='|C425|'.$cprod.'|'.$qcom.'|'.$unidade.'|'.$vl_item.'|'.$vl_pis.'|'.$vl_cofins.'|';
	  _matriz_linha($linha1);
//                               $qtde_linha_bloco_c++;
  //                             $escreve = fwrite($fp, "$linha1"."\r\n");
    //                           $tot_registro_bloco_C425=$tot_registro_bloco_C425+1;


                         }



}

// REGISTRO C460 - DOCUMENTOS FISCAIS EMITIDOS POR ECF (CÓDIGO 02 e 2D)
// Nivel - 4
function sped_efd_registro_c460($dtreducaoz,$filtroaliq){
                global $info_segmento,$fp,$qtde_linha_bloco_0,$qtde_linha_bloco_c,$tot_registro_bloco_C460,$pcind_perfil,$REG_BLC;
                global $TLANCAMENTOS,$CONTLANCAMENTOS_TMP,$filtromovimento,$filtroconsulta,$TCNPJCPF,$CONTCNPJCPF,$ordem ,$tordem,$TNFDOCUMENTOS,$CONTNFDOCUMENTOS,$info_cnpj_segmento,$TITEM_FLUXO,$CONTITEM_FLUXO,$perdtos1,$perdtos2,$dtreducaoz,$serialimpressora;

                global $tot_registro_bloco_C460,$tot_registro_bloco_C470;

                $xsqldx="SELECT modelo,dono,cod_sit,documento,data,cfop,sum(vbc) as svbc,sum(vicms) as svicms,sum(vpis) as svpis,sum(vcofins) as svcofins,sum(vdesc) as svdesc,sum(vprod) as svprod,serial_imp from tabela_c425_provisorio where data = '$dtreducaoz' and modelo='2D' and serial_imp='$serialimpressora' group by dono";

                $seldiferedono=mysql_query($xsqldx,$CONTITEM_FLUXO) or die (mysql_error());

                while ( $pdono = mysql_fetch_assoc($seldiferedono) ) {
                       if (substr($pdono[dono],0,3)=='LAN' and $pdono[svprod]<>0) {
                                    $n++;
                                    $dono=$pdono[dono];

                                    //$sel_existe_ifdocumentos=mysql_query("SELECT cfop,sum(vbc) as svbc,sum(vicms) as svicms,sum(vpis) as svpis,sum(vcofins) as svcofins,sum(vdesc) as svdesc,sum(vprod) as svprod FROM $TITEM_FLUXO WHERE dono='$dono' and data='$dtreducaoz' group by dono",$CONTITEM_FLUXO);

                                    //If (@mysql_num_rows($sel_existe_ifdocumentos)) {
                                    //    $info_ifdocumentos= mysql_fetch_assoc($sel_existe_ifdocumentos);
                                    //}ELSE{
                                    //    echo "Não encontrado registro C460 para $dono - $TITEM_FLUXO em (sped_funcoes)!".'<br>';
                                    //}

                                    $modelo=$pdono[modelo];
                                    $cod_mod=$modelo;
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

      			            $cod_sit=(empty($pdono[cod_sit]))  ? '00' : $pdono[cod_sit];  // situação do documento

                            $num_doc=trim($pdono[documento]); // no caso de ECF que tem 6 caracteres
                            //if($modelo='55'){
                            //   $num_doc=substr($pdono[documento], 3, 8); // no caso de NF-e que tem 9 caracteres,buscar apenas 6
                            //   }
                            $tamanho6=6;
                            $num_doc=substr(_myfunc_zero_a_esquerda($num_doc,$tamanho6),-6) ;// pegar apenas 6 caracteres
                            $dt_doc=_myfunc_ddmmaaaa(_myfunc_stod($pdono[data]));

                            $vl_doc=$pdono[svprod]-$pdono[svdesc];
                            //$vl_doc=number_format(abs($vl_doc), 2, ",", "");
                            if ($vl_doc==0) {
                                $vl_doc='0';
                            }else{
                                $vl_doc=number_format(abs($vl_doc), 2, ",", "");
                            }

                            $vl_pis=$pdono[svpis];
                            if ($vl_pis==0) {
                                $vl_pis='0';
                            }else{
                                $vl_pis=number_format(abs($vl_pis), 2, ",", "");
                            }

                            $vl_cofins=$pdono[svcofins];
                            if ($vl_cofins==0) {
                                $vl_cofins='0';
                            }else{
                                $vl_cofins=number_format(abs($vl_cofins), 2, ",", "");
                            }

                            $xxcnpjcpf=''; //$pdono[cnpjcpf];
                            $xxrazao=''; //$pdono[razao];

                           // REG, IND_OPER, IND_EMIT, COD_MOD, COD_SIT, SER e NUM_DOC
                           if (preg_match("/$cod_sit/", "02030405")) {
                                  $xxcnpjcpf='';
                                  $dt_doc='';
                                  $dt_e_s='';
                                  $vl_doc='';
                                  $vl_pis='';
                                  $vl_cofins='';
                           }


                           $linha1='|C460|'.$cod_mod.'|'.$cod_sit.'|'.$num_doc.'|'.$dt_doc.'|'.$vl_doc.'|'.$vl_pis.'|'.$vl_cofins.'|'.$xxcnpjcpf.'|'.$xxrazao.'|';
	  _matriz_linha($linha1);
//                           $qtde_linha_bloco_c++ ;
  //                         $escreve = fwrite($fp, "$linha1\r\n");
    //                       $tot_registro_bloco_C460=$tot_registro_bloco_C460+1;


                          //C470   filho -5 (c460)
                          //REGISTRO C470: ITENS DO DOCUMENTO (CÓDIGO 02, 2D)
                          sped_efd_registro_c470($dono);
                          //}


                   }

                }

                return;


}

// REGISTRO C470 - ITENS DO DOCUMENTOS FISCAIS EMITIDOS POR ECF (CÓDIGO 02 e 2D)
// Nivel - 5
function sped_efd_registro_c470($dono){
                         global $info_segmento,$fp,$qtde_linha_bloco_0,$qtde_linha_bloco_c,$REG_BLC,$tot_registro_bloco_C470;
                         global $TITEM_FLUXO,$TPRODUTOS ,$CONTITEM_FLUXO,$info_cnpj_segmento,$perdtos1,$perdtos2,$TLANCAMENTOS,$dtreducaoz;

                         $xsql_d="SELECT cprod,picms,cfop,cst,vprod,vdesc,modelo,ucom,qcom,vpis,vcofins  FROM tabela_c425_provisorio where dono='$dono' and flag_mult=-1";

                         $selunidade_d = mysql_query("$xsql_d",$CONTITEM_FLUXO);
                         while ( $punidade_d = mysql_fetch_assoc($selunidade_d) ) {

                               $cod_item=$punidade_d[cprod];

                               $qtd=number_format(abs($punidade_d[qcom]), 3, ",", "");

                               $qtd_canc='';
                               $unid=$punidade_d[ucom];
                               $vl_item=$punidade_d[vprod]-$punidade_d[vdesc];
                               if ($vl_item==0) {
                                   $vl_item='0';
                               }else{
                                    $vl_item=number_format(abs($vl_item), 2, ",", "")  ;
                               }


/*                                    $vl_bc_icms=$info_nfdocumentos[svbc];
                                    $vl_bc_icms_nfdocumentos=$vl_bc_icms; // para verificar bc_icms em outros registros
                                    if ($vl_bc_icms==0 or $vl_icms=='0') {
                                        $vl_bc_icms='0';
                                    }else{
                                        $vl_bc_icms=number_format(abs($vl_bc_icms), 2, ",", "");
                                    }
*/
                               $cst_icms=$punidade_d[cst];
                               $tamanho3=3;
                               $cst_icms=_myfunc_zero_a_esquerda($cst_icms,$tamanho3) ;

                               $cfop=$punidade_d[cfop];

                               $aliq_icms=$punidade_d[picms];
                               $aliq_icms=number_format(abs($aliq_icms), 2, ",", "")  ;
                               if ($aliq_icms==0){
                                   $aliq_icms='0';
                               }

                               $vl_pis=$punidade_d[vpis];
                               $vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;
                               if ($vl_pis==0) {
                                   $vl_pis='0';
                               }

                               $vl_cofins=$punidade_d[vcofins];
                               $vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;
                               if ($vl_cofins==0) {
                                   $vl_cofins='0';
                               }

                               $linha1='|C470|'.$cod_item.'|'.$qtd.'|'.$qtd_canc.'|'.$unid.'|'.$vl_item.'|'.$cst_icms.'|';
                               $linha2=$cfop.'|'.$aliq_icms.'|'.$vl_pis.'|'.$vl_cofins.'|';
	  _matriz_linha($linha1.$linha2);
      //                         $qtde_linha_bloco_c++;
        //                       $escreve = fwrite($fp, "$linha1"."$linha2"."\r\n");
          //                     $tot_registro_bloco_C470=$tot_registro_bloco_C470+1;


                         }



}

// REGISTRO C490 - REGISTRO ANALÍTICO DO MOVIMENTO DIARIO (CÓDIGO 02 e 2D)
// Nivel - 4

function sped_efd_registro_c490($dtreducaoz,$serialimpressora){
                        global $info_segmento,$fp,$qtde_linha_bloco_0,$qtde_linha_bloco_c,$REG_BLC,$tot_registro_bloco_C490;
                        global $TITEM_FLUXO,$CONTITEM_FLUXO,$info_cnpj_segmento,$perdtos1,$perdtos2,$TLANCAMENTOS,$TNFDOCUMENTOS;

                         $xsql_d="SELECT cst,picms,cfop,sum(vprod-vdesc) as vvprod,sum(vbc) as vvbc,sum(vicms) as vvicms,sum(vbcst) as vvbcst,sum(vicmsst) as vvicmsst,sum(vipi) as vvipi,sum(vdesc) as vvdesc,modelo FROM tabela_c425_provisorio where data='$dtreducaoz' and modelo='2D' group by cst,cfop,picms order by id";

                         $selunidade_d = mysql_query("$xsql_d",$CONTITEM_FLUXO);
                         while ( $punidade_d = mysql_fetch_assoc($selunidade_d) ) {

                              $cfop=$punidade_d[cfop];

                              $vl_oper=$punidade_d[vvprod]; //-$punidade_d[vvdesc];
                              if ($vl_oper==0) {
                                   $vl_oper='0';
                               }else{
                                   $vl_oper=number_format(abs($vl_oper), 2, ",", "")  ;
                               }

                               $cst_icms=$punidade_d[cst];
                               $tamanho3=3;
                               $cst_icms=_myfunc_zero_a_esquerda($cst_icms,$tamanho3) ;

                               $xalq_icms=$punidade_d[picms];
                               $xalq_icms=number_format(abs($xalq_icms), 2, ",", "")  ;
                               if ($xalq_icms==0 and (substr($cst,1,2)=='00' or substr($cst,1,2)=='10' or substr($cst,1,2)=='20')) {
                                   $xalq_icms=7.00;
                               }else{
                                   if ($xalq_icms==0){
                                      $xalq_icms='0';
                                   }

                               }


                               $vl_icms=$punidade_d[vvicms];
                               if ($vl_icms==0) {
                                   $vl_icms='0';
                               }else{
                                   $vl_icms=number_format(abs($vl_icms), 2, ",", "")  ;
                               }

                               $vl_bc=$punidade_d[vvbc];
                               if ($vl_bc==0 or $vl_icms=='0'){
                                   $vl_bc='0';
                               }else{
                                  $vl_bc=number_format(abs($vl_bc), 2, ",", "")  ;
                               }

                               // Devido redução base Macro
                               if($cst_icms=='020' and $info_cnpj_segmento=='03116557000180'){
                                  $xalq_icms='12,00';
                                  $vl_bc=$vl_oper;
                               }

                               $cod_obs='';

                               $linha1='|C490|'.$cst_icms.'|'.$cfop.'|'.$xalq_icms.'|'.$vl_oper.'|'.$vl_bc.'|'.$vl_icms.'|'.$cod_obs.'|';
	  _matriz_linha($linha1);

//                               $qtde_linha_bloco_c++;
  //                             $escreve = fwrite($fp, "$linha1\r\n");
    //                           $tot_registro_bloco_C490=$tot_registro_bloco_C490+1;
                         }




}


// REGISTRO C495 - RESUMO MENSAL DE ITENS DO ECF POR ESTABELECIMENTO (CÓDIGO 02 e 2D)
// Nivel - 2
function sped_efd_registro_c495(){
// Somente para contribuinte domiciliado no estado da Bahia
                         global $info_segmento,$fp,$qtde_linha_bloco_0,$qtde_linha_bloco_c,$tot_registro_bloco_C495,$REG_BLC;
                         global $TITEM_FLUXO,$TLANCAMENTOS,$CONTITEM_FLUXO,$info_cnpj_segmento,$perdtos1,$perdtos2,$dtreducaoz;

                         $xsql_z="SELECT picms,cst,ucom,cprod,xprod,vuncom,cean,sum(qcom) as sqcom,sum(vprod) as svprod,sum(vpis) as svpis,sum(vcofins) as svcofins,sum(vdesc) as svdesc,modelo FROM tabela_c425_provisorio where (data >= '$perdtos1' and data<='$perdtos2') group by cprod order by cst,picms";

                         $selunidade_z = mysql_query("$xsql_z",$CONTITEM_FLUXO);
                         while ( $punidade_d = mysql_fetch_assoc($selunidade_z) ) {

                               $picms=$punidade_d[picms];

                               $qcom=$punidade_d[sqcom];
                               $qcom=number_format(abs($qcom), 3, ",", "");

                               $cprod=$punidade_d[cprod];
                               $unidade=$punidade_d[ucom];

                               $vl_item=$punidade_d[svprod]-$punidade_d[svdesc];
                               $vl_item=number_format(abs($vl_item), 2, ",", "")  ;
                               if ($vl_item==0) {
                                   $vl_item='0';
                               }

                               $vl_pis=$punidade_d[svpis];
                               $vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;
                               if ($vl_pis==0) {
                                   $vl_pis='0';
                               }

                               $vl_cofins=$punidade_d[svcofins];
                               $vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;
                               if ($vl_cofins==0) {
                                   $vl_cofins='0';
                               }

                               if ($punidade_z[cean]<>''){ // Caso tenha o cean pegar ele devido a entrada pelo xml
                                   $cprod=$punidade_d[cean];
                               }else{
                                   $cprod=$punidade_d[cprod];
                               }

                               $linha1='|C495|'.$cprod.'|'.$qcom.'|'.$unidade.'|'.$vl_item.'|'.$vl_pis.'|'.$vl_cofins.'|';
	  _matriz_linha($linha1);
      //                         $qtde_linha_bloco_c++;
        //                       $escreve = fwrite($fp, "$linha1"."\r\n");
          //                     $tot_registro_bloco_C495=$tot_registro_bloco_C495+1;


                         }

}

//NOTA FISCAL/CONTA DE ENERGIA ELÉTRICA (CÓDIGO 06),NOTA FISCAL/CONTA DE FORNECIMENTO D'ÁGUA CANALIZADA (CÓSIGO 29) E NOTA FISCAL CONSUMO FORNECIMENTO DE GÁS (CÓDIGO 28) - DOCUMENTOS DE ENTRADA/AQUISIÇÃO COM CRÉDITO
//A AGUA E O GÁS UTILIZADOS COMO INSUMO.
function sped_efd_registro_C500(){

	global $qtd_lin_C,$tot_registro_bloco_C501,$tot_registro_bloco_C505,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$TLANCAMENTOS,$TNFDOCUMENTOS,$TITEM_FLUXO;
	global $info_cnpj_segmento,$TNFDOCUMENTOS_TMP,$TNFDOCUMENTOS,$CONTNFDOCUMENTOS;
	$filtro_lancamentos=" and POSITION(modelo IN ':06:29:28:') > 0";
        $sql_lancamentos= _myfunc_sql_receitas_despesas_documentos('',"$filtro_lancamentos",'','','');
 
    while ($v=mysql_fetch_assoc($sql_lancamentos)) {
		$dono=$v[dono];
	   
 	if ($v[movimento]=='RECEITAS') { //0 - Serviços Contratados pelo Estabelecimento, 1 - Serviços Prestação pelo Estabelecimento
		$ind_oper='1';
		 $ind_emit='0'; //0 - Emissão Própria, 1 - Emissão de Terceiros
            }ELSE{
		$ind_oper='0';
		 $ind_emit='1';

			IF ($info_cnpj_segmento==$v[cnpjcpf])  {
				$ind_emit='0'; //0 - Emissão própria   devolucao
			    }

	    }
  
 
          $cod_part=$v['cnpjcpf'];
       
          $cod_mod=$v['modelo'];
      
          	 //  00 Documento regular  01 Documento regular extemporâneo  02 Documento cancelado 03 Documento cancelado extemporâneo  04 NF-e ou CT-e denegado  05 NF-e ou CT-e  Numeração inutilizada   06 Documento Fiscal Complementar  07 Documento Fiscal Complementar extemporâneo.    08 Documento Fiscal emitido com base em Regime Especial ou Norma Específica
                                                
            $cod_sit=(empty($v[cod_sit]))  ? '00' : $v[cod_sit];  // se for receitas ,emissão propria
 
          $ser=$v['serie'];
         
          $sub=_myfunc_zero_a_esquerda($sub,$tamanho3) ;
$cod_cons='02'; // Código de classe de consumo de energia elétrica ou gás:

          $num_doc=$v['documento'];
        
          $dt_doc=$v['data'];
          $dt_doc=_myfunc_stod($dt_doc);
          $dt_doc=_myfunc_ddmmaaaa($dt_doc);

          $dt_ent=$dt_doc;
		$vl_doc=($v[svprod]+$v[svfrete]+$v[svseg]+$v[svicmsst]+$v[svipi]+$v[svoutro])-$v[svdesc];
	  
	    $vl_doc=number_format($vl_doc, 2, ',', '');
	    $vl_desc=0;
	    $vl_forn=$vl_doc;

          $vl_ivmcs=$v['svicms'];
          $vl_ivmcs=number_format(abs($vl_ivmcs), 2, ",", "")  ;

          $cod_inf='';  // ???????
  


          $vl_pis=$v['vpis'];
          $vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;

          $vl_cofins=$v['vcofins'];
          $vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;

$vl_serv_nt=$sv[svbc_iss];
$vl_serv_nt=number_format(abs($vl_serv_nt), 2, ",", "")  ;
$vl_terc=0;
$vl_da=0;
$vl_bc_icms=$v['svbc'];
          $vl_bc_icms=number_format(abs($vl_bc_icms), 2, ",", "")  ;

$vl_bc_icms_st=$v['svbcst'];
          $vl_bc_icms_st=number_format(abs($vl_bc_icms_st), 2, ",", "")  ;
$tp_ligacao='';
$cod_grupo_tensao='';

$vicmsst=$v['svicmsst'];
          $vicmsst=number_format(abs($vicmsst), 2, ",", "")  ;
	$linha='|C500|'.$ind_oper.'|'.$ind_emit.'|'.$cod_part.'|'.$cod_mod.'|'.$cod_sit.'|'.$ser.'|'.$sub.'|'.$cod_cons.'|'.$num_doc.'|'.$dt_doc.'|'.$dt_ent.'|'.$vl_doc.'|'.$vl_desc.'|'.$vl_forn.'|'.$vl_serv_nt.'|'.$vl_terc.'|'.$vl_da.'|'.$vl_bc_icms.'|'.$vl_icms.'|'.$vl_bc_icms_st.'|'.$vl_bc_icms_st.'|'.$cod_inf.'|'.$vl_pis.'|'.$vl_cofins.'|'.$tp_ligacao.'|'.$cod_grupo_tensao.'|';


	  _matriz_linha($linha);
	 

	   // c510 filho
	 	//sped_efd_registro_C510($dono); 
 	// c590 analitico
	 	sped_efd_registro_C590($dono); 

		 
	 
}



       
 	 
          return ;

}





function sped_efd_registro_C510($xdono){
	global $info_segmento,$fp,$REG_BLC,$TITEM_FLUXO,$CONTITEM_FLUXO,$TPRODUTOS,$TSERVICOS,$info_cnpj_segmento,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS;


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
$cod_class='';
                $descr_compl=$punidade_d['xprod'];
 		$qtd=number_format(abs($punidade_d['qcom']), 5, ",", "");

                 $unid=$punidade_d['ucom'];
 
                 $vl_item=_myfunc_valor_base_pis_cofins($punidade_d);
//$punidade_d['vprod'];
                 $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

                 $vl_desc=$punidade_d['vdesc'];
                 $vl_desc=number_format(abs($vl_desc), 2, ",", "")  ;

                 

                 $ind_mov='0' ; //sim  TEVE FLUXO?  POR NATUREZA / CFOP  COMPLETAR  0 SIM  1 NAO
 
                
 
                 $cst_icms=$punidade_d['cst_icms'];
                
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

              

 

                   

                  $vl_cofins=$punidade_d['vcofins'];
                  $vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;

                  $cod_cta='';
 $movimento=$v['movimento'];

    if($movimento=='DESPESAS'){
       $ind_rec='1'; //ENTRADA
    }else{
       $ind_rec='1'; //SAIDAS
    }

$cod_part=$v[cnpjcpf];
                    $linha='|C510|'.$num_item.'|'.$cod_item.'|'.$cod_class.'|'.$qtd.'|'.$unid.'|'.$vl_item.'|'.$vl_desc.'|'.$cst_icms.'|'.$cfop.'|'.$vl_bc_icms.'|'.$aliq_icms.'|'.$vl_icms.'|'.$vl_bc_icms_st.'|'.$aliq_st.'|'.$vl_icms_st.'|'.$ind_rec.'|'.$cod_part.'|'.$vl_pis.'|'.$vl_cofins.'|'.$cod_cta.'|';
   
                 _matriz_linha($linha);
        
                
	}
 
          return ;
    
 
}








 //REGISTRO C590: REGISTRO ANALÍTICO DO DOCUMENTO (CÓDIGO 06,28 E 29).
function sped_efd_registro_c590($xdono) {
                        	global $livro_reg,$info_segmento,$fp,$TITEM_FLUXO,$CONTITEM_FLUXO,$TPRODUTOS,$TSERVICOS,$info_cnpj_segmento,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS;
           
 		

 	$xsql_d=_myfunc_sql_receitas_despesas_itens('',$xdono);
        $xsql_d="SELECT *,sum(vprod) as vvprod,sum(vbc) as vvbc,sum(vicms) as vvicms,sum(vfrete) as vvfrete,sum(vseg) as vvseg,sum(voutro) as vvoutro,sum(vbcst) as vvbcst,sum(vicmsst) as vvicmsst,sum(vipi) as vvipi,sum(vdesc) as vvdesc FROM $livro_reg  group by cst,cfop,picms order by dono,cst,cfop,picms";
 
	$selunidade_d=mysql_query("$xsql_d",$CONTITEM_FLUXO);
	// $xsql_pdf="SELECT a.ucom,a.tipo_lancamento,a.qcom,a.cprod,c.movimento,a.conta_plano,a.dono,cfop,c.data,c.cnpjcpf,c.codnat,c.modelo,c.documento,picms,valiq_iss,'             ' as obs,$svsub_contabil, $svsub_isent_ntri , $svsub_pis_cofins FROM $TITEM_FLUXO  as a ,$lanca_pdf as c WHERE  a.dono=c.dono $filtro_movimento $filtro_segmento_relatorios_a";
  
                         while ( $punidade_d = mysql_fetch_assoc($selunidade_d) ) {

                              $cfop=$punidade_d[cfop];                              
                              $vvprod=($punidade_d[vvprod]+$punidade_d[vvfrete]+$punidade_d[vvseg]+$punidade_d[vvipi]+$punidade_d[vvicmsst]+$punidade_d[vvoutro])-$punidade_d[vvdesc];
                               if ($vvprod==0) {
                                   $vvprod='0';
                               }else{
                                   $vvprod=number_format(($vvprod), 2, ",", "")  ;
                               }


                               $cst=trim($punidade_d[cst]);
			       if (strlen($cst)==2) {
					 $cst='0'. $cst;
				}
                               $xalq_icms=$punidade_d[picms];
                               $xalq_icms=number_format(($xalq_icms), 2, ",", "")  ;
                              

                               $vl_icms=$punidade_d[vvicms];
                               if ($vl_icms==0) {
                                   $vl_icms='0';
                               }else{
                                   $vl_icms=number_format(abs($vl_icms), 2, ",", "")  ;
                               }

                               $vl_bc=$punidade_d[vvbc];
                               if ($vl_bc==0 or $vl_icms=='0'){
                                   $vl_bc='0';
                               }else{
                                   $vl_bc=number_format(($vl_bc), 2, ",", "")  ;
                               }

                               $vl_bcst=$punidade_d[vvbcst];
                               if ($vl_bcst==0) {
                                   $vl_bcst='0';
                               }else{
                                   $vl_bcst=number_format(($vl_bcst), 2, ",", "")  ;
                               }


                               $vl_icmsst=$punidade_d[vvicmsst];
                               if ($vl_icmsst==0) {
                                   $vl_icmsst='0';
                               }else{
                                    $vl_icmsst=number_format(($vl_icmsst), 2, ",", "") ;
                               }
                              


                               $vl_ipi=$punidade_d[vvipi];
                               if ($vl_ipi==0) {
                                   $vl_ipi='0';
                               }else{
                                   $vl_ipi=number_format(($vl_ipi), 2, ",", "")  ;

                               }
                               
                               $vl_bcred=0.00;
                               if ($cst=='020' OR $cst=='070') {
                                  $vl_bcred=$vvprod-$vl_bc;
                                  }
                               if ($vl_bcred==0) {
                                   $vl_bcred='0';
                               }else{
                                   $vl_bcred=number_format(abs($vl_bcred), 2, ",", "")  ;
                               }

                               $cod_obs='';

                               $linha='|C590|'.$cst.'|'.$cfop.'|'.$xalq_icms.'|'.$vvprod.'|'.$vl_bc.'|'.$vl_icms.'|'.$vl_bcst.'|'.$vl_icmsst.'|'.$vl_bcred.'|'.$cod_obs.'|';
                               
                                 _matriz_linha($linha);
                         }

                        




}

 

//REGISTRO C990: ENCERRAMENTO DO BLOCO C
function sped_efd_registro_c990() {
                     global $info_segmento,$fp,$qtde_linha_bloco_0,$qtde_linha_bloco_c,$REG_BLC;
                     $qtde_linha_bloco=_myfunc_qtde_registro_matriz_linha_sped('C') + 1;
                     $linha='|C990|'.$qtde_linha_bloco.'|';
		     _matriz_linha($linha);

echo "<br> BLOCO C";
flush();
                     return;
}


 
///////////////////////////////////////////////////
// BLOCO D: DOCUMENTOS FISCAIS II - SERVIÇOS (ICMS)
///////////////////////////////////////////////////

//REGISTRO D001: ABERTURA DO BLOCO D
sped_efd_registro_D001();
//sped_efd_registro_D100();
sped_efd_registro_D500();
sped_efd_registro_D990();

 

//REGISTRO D001: ABERTURA DO BLOCO D
function sped_efd_registro_D001(){
         global $info_segmento,$info_cnpj_segmento,$fp;
         global $TLANCAMENTOS,$CONTLANCAMENTOS,$perdtos1,$perdtos2,$lanperiodo1,$lanperiodo2,$filtromodeloD;
 
 
		$filtro_lancamentos=" and POSITION(modelo IN '|07|08|8B|09|10|11|26|27|57|') > 0";
        $sql_lancamentos= _myfunc_sql_receitas_despesas_documentos('',"$filtro_lancamentos",'','','');
 
   

         if (mysql_num_rows($sql_lancamentos)>0) {
              $linha="|D001|0|";  // tem informação
	       _matriz_linha($linha);

 
		 sped_efd_registro_D100(); // registro D100
           
              return;
         }else{
               $linha="|D001|1|";  // sem informação
	       _matriz_linha($linha);           
              return;
         }
     
return;

}
 

function sped_efd_registro_D100() {
               
                 global $info_segmento,$info_cnpj_segmento,$fp;
         	global $TNFDOCUMENTOS,$TNFDOCUMENTOS_TMP,$CONTNFDOCUMENTOS,$CONTNFDOCUMENTOS_TMP,$TLANCAMENTOS,$CONTLANCAMENTOS,$perdtos1,$perdtos2,$lanperiodo1,$lanperiodo2,$filtromodeloD;
 
 
	 
               

		$filtro_lancamentos=" and POSITION(modelo IN '|07|08|8B|09|10|11|26|27|57|') > 0";
        	$sql_lancamentos= _myfunc_sql_receitas_despesas_documentos('',"$filtro_lancamentos",'','c.documento,c.modelo,c.serie,c.cnpjcpf','c.documento');
 

                while ( $pdono = mysql_fetch_assoc($sql_lancamentos) ) {
                      
                          	 $dono=$pdono[dono];
 
	    			  include('documentos_situacao_erp.php');
                                    $ind_oper=($pdono[movimento]=='RECEITAS')  ? '1' : '0';
                                    $ind_emit=($pdono[movimento]=='RECEITAS')  ? '0' : '1';  // se for receitas ,emissão propria

				     IF (($info_cnpj_segmento==$v[cnpjcpf]) and $pdono[movimento]=='DESPESAS') {
        					$ind_emit='0'; //0 - Emissão própria   devolucao
    					}

                                                /*  tabela 4.1.2
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
				        $cod_part=$pdono[cnpjcpf];
                        $modelo=$pdono[modelo];
                        $cod_sit=(empty($pdono[cod_sit]))  ? '00' : $pdono[cod_sit];  // se for receitas ,emissão propria
                        $dt_doc=_myfunc_ddmmaaaa(_myfunc_stod($pdono[data]));
                        $dt_e_s=_myfunc_ddmmaaaa(_myfunc_stod($pdono[data]));
 						$ser=$info_nfdocumentos[serie];
	                    $sub='';
	 
	   					$num_doc=$info_nfdocumentos[numero];

						 
						    $chv_nfe=$info_nfdocumentos['gerar_id'];
					  	    $dt_doc=$info_nfdocumentos[data];
						    $dt_doc=_myfunc_stod($dt_doc);
						    $dt_doc=_myfunc_ddmmaaaa($dt_doc);

						    $dt_e_s= $dt_doc;
						   
					 	    


                                    $vl_doc=$info_nfdocumentos[vcontabilnf];
                                    $vl_doc=number_format(abs($vl_doc), 2, ",", "");
                                    if ($vl_doc==0) {
                                       $vl_doc='0';
                                       $ind_pgto='9';
                                    }
                                    $vl_desc=$info_nfdocumentos[vdescprodutosnf]+$info_nfdocumentos[vdescserviconf];
                                    $vl_desc=number_format(abs($vl_desc), 2, ",", "");
                                    if ($vl_desc==0) {
                                       $vl_desc='0';
                                    }

                                    /*
                                    Indicador do tipo do frete:
                                    0- Por conta de terceiros;
                                    1- Por conta do emitente;
                                    2- Por conta do destinatário;
                                    9- Sem cobrança de frete.
                                    */
                                    $ind_frt=$info_nfdocumentos[modfrete];
				    IF ($ind_frt=='') {
					    $ind_frt='9';
				    }


                                    $vl_serv=$info_nfdocumentos[servicosnf];
                                    $vl_serv=number_format(abs($vl_serv), 2, ",", "");
                                    if ($vl_serv==0) {
                                       $vl_serv='0';
                                    }

                                    $vl_bc_icms=$info_nfdocumentos[vbcicmsnf];
                                    $vl_bc_icms=number_format(abs($vl_bc_icms), 2, ",", "");
                                    if ($vl_bc_icms==0) {
                                       $vl_bc_icms='0';
                                    }

                                    $vl_icms=$info_nfdocumentos[vicmsnf];
                                    $vl_icms=number_format(abs($vl_icms), 2, ",", "");
                                    if ($vl_icms==0) {
                                       $vl_icms='0';
                                    }

                                    // Valor Não-tributado
                                    $vl_nt=$vl_doc-$vl_bc_icms;
                                    $vl_nt=number_format(abs($vl_nt), 2, ",", "");
                                    if ($vl_nt==0) {
                                       $vl_nt='0';
                                    }
 
                                    $cod_cta=''; // codigo conta analitica contábil debitada/creditada
                                    $subserie=''; //Sub-serie do documento fiscal
                                    $tp_ct_e=''; //Tipo do conh. transporte eletronico
                                    
                                    $chv_cte_ref=$info_nfdocumentos[nfereferenciada]; //Chave do ct-e cujos valores foram complementados
                                    
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



                                    $linha1='|D100|'.$ind_oper.'|'.$ind_emit.'|'.$cod_part.'|'.$modelo.'|'.$cod_sit.'|';
                                    $linha2=$ser.'|'.$sub.'|'.$num_doc.'|'.$chv_nfe.'|'.$dt_doc.'|'.$dt_e_s.'|';
                                    $linha3=$tp_ct_e.'|'.$chv_cte_ref.'|'.$vl_doc.'|'.$vl_desc.'|'.$ind_frt.'|'.$vl_serv.'|'.$vl_bc_icms.'|'.$vl_icms.'|'.$vl_nt.'|'.$cod_inf.'|'.$cod_cta.'|';
				                    $linha=$linha1.$linha2.$linha3;
                                    _matriz_linha($linha);

 
                                   // D110   filho -3 (D110)
                                   IF ($modelo=='07') { //         ITENS DO DOCUMENTO - NOTA FISCAL DE SERVIÇOS DE TRANSPORTE (CÓDIGO 07)

                                    //	sped_efd_registro_D110($dono);


                                    }   
					IF ($modelo=='8B' or $modelo=='08') { //         ITENS DO DOCUMENTO - NOTA FISCAL DE SERVIÇOS DE TRANSPORTE (CÓDIGO 07)
						//sped_efd_registro_D130($dono);   
					}


				sped_efd_registro_D190($dono);                
                
		}

                return;
}

 //REGISTRO D110:          ITENS DO DOCUMENTO - NOTA FISCAL DE SERVIÇOS DE TRANSPORTE (CÓDIGO 07)

 function sped_efd_registro_D110($xdono) {
	global $info_segmento,$fp,$REG_BLC,$TITEM_FLUXO,$CONTITEM_FLUXO,$TPRODUTOS,$TSERVICOS,$info_cnpj_segmento,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS;


 	$xsql_d=_myfunc_sql_receitas_despesas_itens('',$xdono);

      // $selunidade_d = mysql_query("$xsql_d",$CONTITEM_FLUXO);
     
 $num_item=0;
           while ( $punidade_d = mysql_fetch_assoc($xsql_d)) {
                 
		 

		$num_item=$num_item+1;
                $cod_item=$punidade_d['cprod'];
                
                 $vl_item=_myfunc_valor_base_pis_cofins($punidade_d);
 
                 $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

                 $vl_out=0;
                 

                 


                    $linha='|D110|'.$num_item.'|'.$cod_item.'|'.$vl_item.'|'.$vl_out.'|';
   
                 _matriz_linha($linha);
        
                
	  }
 
          return ;
    
 
}

 //REGISTRO D190: REGISTRO ANALÍTICO DO DOCUMENTO (CÓDIGO 07,08,8B,09,10,11,26,27 E 57).
function sped_efd_registro_D190($xdono) {
                      global $info_segmento,$fp,$REG_BLC,$TITEM_FLUXO,$CONTITEM_FLUXO,$TPRODUTOS,$TSERVICOS,$info_cnpj_segmento,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS;


 	$xsql_d=_myfunc_sql_receitas_despesas_itens('',$xdono);

      // $selunidade_d = mysql_query("$xsql_d",$CONTITEM_FLUXO);
       $ordem_documento_emitido=0;
       $xdono='######';
 
           while ( $punidade_d = mysql_fetch_assoc($xsql_d)) {
                         

                              $cfop=$punidade_d[cfop];

                              $vvprod=_myfunc_valor_base_pis_cofins($punidade_d); //$punidade_d[vvprod]+$punidade_d[vvfrete]+$punidade_d[vvseg]+$punidade_d[vvipi]+$punidade_d[vvicmsst]+$punidade_d[vvoutro];
                              if ($vvprod==0) {
                                  $vvprod='0';
                              }else{
                                  $vvprod=number_format(abs($vvprod), 2, ",", "")  ;
                              }


                               $cst=$punidade_d[cst];
                               $tamanho3=3;
                               $cst=_myfunc_zero_a_esquerda($cst,$tamanho3) ;

                               $xalq_icms=$punidade_d[picms];
                               $xalq_icms=number_format(abs($xalq_icms), 2, ",", "")  ;
                               if ($xalq_icms==0 and (substr($cst,1,2)=='00' or substr($cst,1,2)=='10' or substr($cst,1,2)=='20')) {
                                   $xalq_icms=7.00;
                               }else{
                                   if ($xalq_icms==0){
                                      $xalq_icms='0';
                                   }

                               }

                               $vl_icms=$punidade_d[vvicms];
                               if ($vl_icms==0) {
                                   $vl_icms='0';
                               }else{
                                   $vl_icms=number_format(abs($vl_icms), 2, ",", "")  ;
                               }

                               $vl_bc=$punidade_d[vvbc];
                               if ($vl_bc==0 or $vl_icms=='0'){
                                   $vl_bc='0';
                               }else{
                                   $vl_bc=number_format(abs($vl_bc), 2, ",", "")  ;
                               }

                               $vl_bcred=0.00;
                               if ($cst=='020' OR $cst=='070') {
                                  $vl_bcred=$vvprod-$vl_bc;
                                  }
                               $vl_bcred=number_format(abs($vl_bcred), 2, ",", "")  ;
                               if ($vl_bcred==0) {
                                   $vl_bcred='0';
                               }

                               $cod_obs='';

                               $linha='|D190|'.$cst.'|'.$cfop.'|'.$xalq_icms.'|'.$vvprod.'|'.$vl_bc.'|'.$vl_icms.'|'.$vl_bcred.'|'.$cod_obs.'|';
  				 _matriz_linha($linha);
                         }


}





//NOTA FISCAL DE SERVIÇO DE COMUNICAÇÃO (CÓDIGO 21) E NOTA FISCAL DE SERVIÇO DE TELECOMUNICAÇÃO (CÓDIGO 22) - DOCUMENTOS DE AQUISIÇÃO COM DIREITO A CRÉDITO
function sped_efd_registro_D500(){
	global $qtd_lin_D,$tot_registro_bloco_D501,$tot_registro_bloco_D505,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$TLANCAMENTOS,$TNFDOCUMENTOS,$TITEM_FLUXO;
	global $TNFDOCUMENTOS_TMP,$TNFDOCUMENTOS,$CONTNFDOCUMENTOS;
//$filtro_item_fluxo=" and POSITION(cst_pis IN ':50:56:') > 0";
$filtro_lancamentos=" and POSITION(modelo IN ':21:22:') > 0";
        $sql_lancamentos= _myfunc_sql_receitas_despesas_documentos('',"$filtro_lancamentos","$filtro_item_fluxo",'','');
 
    while ($v=mysql_fetch_assoc($sql_lancamentos)) {

 
	    $dono=$v[dono];
	    include('documentos_situacao_erp.php');
 
   $reg='D500' ;

   $ind_oper='0';

   $ind_emit='1';

   $cod_part=$v[cnpjcpf];
   

   $cod_mod=$v[modelo];
  	 //  00 Documento regular  01 Documento regular extemporâneo  02 Documento cancelado 03 Documento cancelado extemporâneo  04 NF-e ou CT-e denegado  05 NF-e ou CT-e  Numeração inutilizada   06 Documento Fiscal Complementar  07 Documento Fiscal Complementar extemporâneo.    08 Documento Fiscal emitido com base em Regime Especial ou Norma Específica
                                                
            $cod_sit=(empty($v[cod_sit]))  ? '00' : $v[cod_sit];  // se for receitas ,emissão propria
 
    
	    $ser=$info_nfdocumentos[serie];
	   
	    $sub='';
	 
	    $num_doc=$info_nfdocumentos[numero];

 
  	    $dt_doc=$info_nfdocumentos[data];
	    $dt_doc=_myfunc_stod($dt_doc);
	    $dt_doc=_myfunc_ddmmaaaa($dt_doc);

	   $dt_a_p= $dt_doc;
	   
 	    $vl_doc=($v[svprod]+$v[svfrete]+$v[svseg]+$v[svicmsst]+$v[svipi]+$v[svoutro])-$v[svdesc];
	  
	    $vl_doc=number_format($vl_doc, 2, ',', '');


	    $vl_desc=$v['svdesc'];
	    $vl_desc=number_format($vl_desc, 2, ',', '');



   $vl_serv='';
   $vl_serv=number_format(abs($vl_serv), 2, ",", "")  ;

   $vl_serv_nt='';
   $vl_serv_nt=number_format(abs($vl_serv_nt), 2, ",", "")  ;	 

   $vl_terc='';
   $vl_terc=number_format(abs($vl_terc), 2, ",", "")  ;
  
    $vl_da='';
   $vl_da=number_format(abs($vl_da), 2, ",", "")  ;


	    $vl_pis=$v['svpis'];
	    $vl_pis=number_format($vl_pis, 2, ',', '');
 

	    $vl_cofins=$v['svcofins'];
	    $vl_cofins=number_format($vl_cofins, 2, ',', '');



 
  
 
   $vl_bc_icms=$v[svbc];
   $vl_bc_icms=number_format(abs($vl_bc_icms), 2, ",", "")  ;

   $vl_icms=$v[svicms];
   $vl_icms=number_format(abs($vl_icms), 2, ",", "")  ;

   $cod_inf='';
 
   $vl_pis=$v[svpis];
   $vl_pis=number_format(abs($vl_pis), 2, ",", "")  ;

   $vl_cofins=$v[svcofins];
   $vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;

$cod_cta='';
$tp_assinante='';
$linha='|'.$reg.'|'.$ind_oper.'|'.$ind_emit.'|'.$cod_part.'|'.$cod_mod.'|'.$cod_sit.'|'.$ser.'|'.$sub.'|'.$num_doc.'|'.$dt_doc.'|'.$dt_a_p.'|'.$vl_doc.'|'.$vl_desc.'|'.$vl_serv.'|'.$vl_serv_nt.'|'.$vl_terc.'|'.$vl_da.'|'.$vl_bc_icms.'|'.$vl_icms.'|'.$cod_inf.'|'.$vl_pis.'|'.$vl_cofins.'|'.$cod_cta.'|'.$tp_assinante.'|';

	  _matriz_linha($linha);
	   

	// sped_efd_registro_D510($dono); //     ITENS DO DOCUMENTO  NOTA FISCAL (CODIGO 21) E SERVICO DE TELECOMUNICACA (CODIGO 22)
		 sped_efd_registro_D590($dono); //    ANALITICO POR CFOP, ALIQUOTA (21 E 22)



                                   
}
       

          return ;

}








// REGISTRO D510    ITENS DO DOCUMENTO  NOTA FISCAL (CODIGO 21) E SERVICO DE TELECOMUNICACA (CODIGO 22)
function sped_efd_registro_D510($xdono){
	global $info_segmento,$fp,$REG_BLC,$TITEM_FLUXO,$CONTITEM_FLUXO,$TPRODUTOS,$TSERVICOS,$info_cnpj_segmento,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS;

 
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
		$cod_class='';
                $descr_compl=$punidade_d['xprod'];
 		$qtd=number_format(abs($punidade_d['qcom']), 5, ",", "");

                 $unid=$punidade_d['ucom'];
 
                 $vl_item=_myfunc_valor_base_pis_cofins($punidade_d);
//$punidade_d['vprod'];
                 $vl_item=number_format(abs($vl_item), 2, ",", "")  ;

                 $vl_desc=$punidade_d['vdesc'];
                 $vl_desc=number_format(abs($vl_desc), 2, ",", "")  ;

                 

                 $ind_mov='0' ; //sim  TEVE FLUXO?  POR NATUREZA / CFOP  COMPLETAR  0 SIM  1 NAO
 
                
 
                 $cst_icms=$punidade_d['cst_icms'];
                
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

              
$vl_bc_icms_uf='';
$vl_bc_icms='';
 

                   

                  $vl_cofins=$punidade_d['vcofins'];
                  $vl_cofins=number_format(abs($vl_cofins), 2, ",", "")  ;

                  $cod_cta='';
 $movimento=$v['movimento'];

    if($movimento=='DESPESAS'){
       $ind_rec='1'; //ENTRADA
    }else{
       $ind_rec='1'; //SAIDAS
    }

$cod_part=$v[cnpjcpf];


                    $linha='|D510|'.$num_item.'|'.$cod_item.'|'.$cod_class.'|'.$qtd.'|'.$unid.'|'.$vl_item.'|'.$vl_desc.'|'.$cst_icms.'|'.$cfop.'|'.$vl_bc_icms.'|'.$aliq_icms.'|'.$vl_icms.'|'.$vl_bc_icms_uf.'|'.$vl_bc_icms.'|'.$ind_rec.'|'.$cod_part.'|'.$vl_pis.'|'.$vl_cofins.'|'.$cod_cta.'|';
    
                 _matriz_linha($linha);
        
                
	}
 
          return ;
    
 
}















//REGISTRO D590: REGISTRO ANALÍTICO DO DOCUMENTO (CÓDIGO 21 E 22).
 

function sped_efd_registro_D590($xdono){
	global $livro_reg,$info_segmento,$fp,$TITEM_FLUXO,$CONTITEM_FLUXO,$TPRODUTOS,$TSERVICOS,$info_cnpj_segmento,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS;
           
 		

 	$xsql_d=_myfunc_sql_receitas_despesas_itens('',$xdono);
        $xsql_d="SELECT *,sum(vprod) as vvprod,sum(vbc) as vvbc,sum(vicms) as vvicms,sum(vfrete) as vvfrete,sum(vseg) as vvseg,sum(voutro) as vvoutro,sum(vbcst) as vvbcst,sum(vicmsst) as vvicmsst,sum(vipi) as vvipi,sum(vdesc) as vvdesc FROM $livro_reg  group by cst,cfop,picms order by dono,cst,cfop,picms";
 
$selunidade_d=mysql_query("$xsql_d",$CONTITEM_FLUXO);
// $xsql_pdf="SELECT a.ucom,a.tipo_lancamento,a.qcom,a.cprod,c.movimento,a.conta_plano,a.dono,cfop,c.data,c.cnpjcpf,c.codnat,c.modelo,c.documento,picms,valiq_iss,'             ' as obs,$svsub_contabil, $svsub_isent_ntri , $svsub_pis_cofins FROM $TITEM_FLUXO  as a ,$lanca_pdf as c WHERE  a.dono=c.dono $filtro_movimento $filtro_segmento_relatorios_a";
  
                         while ( $punidade_d = mysql_fetch_assoc($selunidade_d) ) {

                              $cfop=$punidade_d[cfop];                              
                              $vvprod=($punidade_d[vvprod]+$punidade_d[vvfrete]+$punidade_d[vvseg]+$punidade_d[vvipi]+$punidade_d[vvicmsst]+$punidade_d[vvoutro])-$punidade_d[vvdesc];
                               if ($vvprod==0) {
                                   $vvprod='0';
                               }else{
                                   $vvprod=number_format(($vvprod), 2, ",", "")  ;
                               }


                               $cst=trim($punidade_d[cst]);
			       if (strlen($cst)==2) {
					 $cst='0'. $cst;
				}
                               $xalq_icms=$punidade_d[picms];
                               $xalq_icms=number_format(($xalq_icms), 2, ",", "")  ;
                              

                               $vl_icms=$punidade_d[vvicms];
                               if ($vl_icms==0) {
                                   $vl_icms='0';
                               }else{
                                   $vl_icms=number_format(abs($vl_icms), 2, ",", "")  ;
                               }

                               $vl_bc=$punidade_d[vvbc];
                               if ($vl_bc==0 or $vl_icms=='0'){
                                   $vl_bc='0';
                               }else{
                                   $vl_bc=number_format(($vl_bc), 2, ",", "")  ;
                               }

                              $vl_bc_icms_st=$punidade_d[vvbcst];
                              if ($vl_bc_icms_st==0) {
                                   $vl_bc_icms_st='0';
                              }else{
                                   $vl_bc_icms_st=number_format(abs($vl_bc_icms_st), 2, ",", "")  ;
                              }

                              $vl_icms_st=$punidade_d[vvicmsst];
                              if ($vl_icms_st==0) {
                                   $vl_icms_st='0';
                              }else{
                                   $vl_icms_st=number_format(abs($vl_icms_st), 2, ",", "")  ;
                              }

                               $vl_bcred=0.00;
                               if ($cst=='020' OR $cst=='070') {
                                  $vl_bcred=$vvprod-$vl_bc;
                                  }
                               if ($vl_bcred==0) {
                                   $vl_bcred='0';
                               }else{
                                   $vl_bcred=number_format(abs($vl_bcred), 2, ",", "")  ;
                               }

                               $cod_obs='';

                               $linha='|D590|'.$cst.'|'.$cfop.'|'.$xalq_icms.'|'.$vvprod.'|'.$vl_bc.'|'.$vl_icms.'|'.$vl_bc_icms_st.'|'.$vl_icms_st.'|'.$vl_bcred.'|'.$cod_obs.'|';
                               
                                 _matriz_linha($linha);
                         }

                       
                         

 
}


//REGISTRO D990: ENCERRAMENTO DO BLOCO D
function sped_efd_registro_D990() {
 
                     global $info_segmento,$fp,$info_titulo;
                     $qtde_linha_bloco=_myfunc_qtde_registro_matriz_linha_sped('D') + 1;
                     $linha='|D990|'.$qtde_linha_bloco.'|';
		     _matriz_linha($linha);
echo "<br> BLOCO D";
flush();


                     return;
}


 

////////////////////////////////////////////////
// BLOCO E: APURAÇÃO DO ICMS E DO IPI
////////////////////////////////////////////////




//REGISTRO E001: ABERTURA DO BLOCO E
sped_efd_registro_E001();

//REGISTRO E100: PERÍODO DA APURAÇÃO DO ICMS.
sped_efd_registro_E100();

//REGISTRO E110: APURAÇÃO DO ICMS  OPERAÇÕES PRÓPRIAS.
sped_efd_registro_E110();

// REGISTRO E116: OBRIGAÇÕES DO ICMS A RECOLHER OPERAÇÕES PRÓPRIAS.
sped_efd_registro_E116();

// ???  E111,E112,E113,E115  ???

// REGISTRO E200: PERÍODO DA APURAÇÃO DO ICMS - SUBSTITUIÇÃO TRIBUTÁRIA.
sped_efd_registro_E200();


//REGISTRO E210: APURAÇÃO DO ICMS  SUBSTITUIÇÃO TRIBUTÁRIA.
//sped_efd_registro_E210();

// apenas para industrias
    $industria=$infotitulo[ind_ativ];
  // quando é industria calcula
  if ($industria=='0') {  // 0 é industria
        // REGISTRO E500: PERÍODO DE APURAÇÃO DO IPI.
        sped_efd_registro_E500();
        // REGISTRO E510: CONSOLIDAÇÃO DOS VALORES DO IPI.
          sped_efd_registro_E510() ;
          // REGISTRO E520: APURAÇÃO DO IPI.  n:3
        sped_efd_registro_E520();
        // //REGISTRO E530: AJUSTES DA APURAÇÃO DO IPI. n:4
  }

 
 


//REGISTRO E990: ENCERRAMENTO DO BLOCO E
sped_efd_registro_E990();

 


//REGISTRO E001: ABERTURA DO BLOCO E
function sped_efd_registro_E001() {
             global $info_segmento,$fp;
                 $linha="|E001|0|";
		 _matriz_linha($linha);
                 return;
}

//REGISTRO E100: PERÍODO DA APURAÇÃO DO ICMS.
 function sped_efd_registro_E100() {
             global $info_segmento,$fp,$lanperiodo1,$lanperiodo2;

                 $dt_ini=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo1));
                 $dt_fin=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo2));
		 $linha="|E100|$dt_ini|$dt_fin|";
		 _matriz_linha($linha);
                
                 return;
}


//REGISTRO E110: APURAÇÃO DO ICMS  OPERAÇÕES PRÓPRIAS.
 function sped_efd_registro_E110() {
             global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$perdtos1,$perdtos2,$REG_BLC;
             global $TITEM_FLUXO,$TPRODUTOS ,$CONTITEM_FLUXO,$TSERVICOS,$info_cnpj_segmento,$TLANCAMENTOS,$dados_sped_efd_icms;

            
		//////////////////
		// $vl_tot_debitos
        //////////////////

        $modelos_inclusos="|01|1B|04|06|07|08|8B|09|10|11|21|22|26|27|28|29|55|57|2D|";
    	$filtro_lancamentos=" and POSITION(modelo IN '$modelos_inclusos')>0";
		$filtro_item_fluxo=" and vicms>0 and cfop<>'5605'";

		$sql_lancamentos= _myfunc_sql_receitas_despesas_documentos('RECEITAS',"$filtro_lancamentos","$filtro_item_fluxo",'movimento','');
	 
	 	$v=mysql_fetch_assoc($sql_lancamentos);
		$vl_tot_debitos=$v[svicms];

		// INCLUIR O CFOP 1605
		$filtro_item_fluxo=" and cfop='1605'";
		$sql_lancamentos= _myfunc_sql_receitas_despesas_documentos('DESPESAS',"$filtro_lancamentos","$filtro_item_fluxo",'movimento','');
	 	$v=mysql_fetch_assoc($sql_lancamentos);
		$vl_icms_cfop_1605=$v[svicms];

		$vl_tot_debitos=$vl_tot_debitos+$vl_icms_cfop_1605;
  	
             $vl_aj_debitos='0';
             $vl_tot_aj_debitos='0';
             $vl_estornos_cred='0'; 
		
		//////////////////
		// $vl_tot_creditos
        //////////////////
		//$filtro_lancamentos=" and (POSITION( cod_sit IN ':01:07' ) =0 AND cod_sit IS NOT NULL) ";
		$filtro_item_fluxo=" and vicms>0 and cfop<>'1605'";

		$sql_lancamentos= _myfunc_sql_receitas_despesas_documentos('DESPESAS',"$filtro_lancamentos","$filtro_item_fluxo",'movimento','');
	 
	 	$v=mysql_fetch_assoc($sql_lancamentos);
		$vl_tot_creditos=$v[svicms];

		// INCLUIR O CFOP 1605
		$filtro_item_fluxo=" and cfop='5605'";
		$sql_lancamentos= _myfunc_sql_receitas_despesas_documentos('RECEITAS',"$filtro_lancamentos","$filtro_item_fluxo",'movimento','');
	 	$v=mysql_fetch_assoc($sql_lancamentos);
		$vl_icms_cfop_5605=$v[svicms];

		$vl_tot_creditos=$vl_tot_creditos+$vl_icms_cfop_5605;

	 	$vl_aj_creditos='0';
	    $vl_tot_aj_creditos='0';
        $vl_estornos_deb='0';
		
		$vl_sld_credor_ant=$dados_sped_efd_icms[sped_efd_vl_sld_credor_ant];

 		$vl_sld_apurado=(($vl_tot_debitos)+($vl_aj_debitos+$vl_tot_aj_debitos)+($vl_estornos_cred))-(($vl_tot_creditos)-($vl_aj_creditos+$vl_tot_aj_creditos)-($vl_estornos_deb) -($vl_sld_credor_ant));

                   if ($vl_sld_apurado>=0) {
                       $vl_sld_credor_transportar='0';
                   }

                   if ($vl_sld_apurado<0) {
                       $vl_sld_credor_transportar=abs($vl_sld_apurado);
                       $vl_sld_apurado='0';
                   }



              $vl_tot_ded=0;
              $vl_icms_recolher=$vl_sld_apurado-$vl_tot_ded;
 

              $vl_tot_debitos=number_format(abs($vl_tot_debitos), 2, ",", "");
              $vl_tot_creditos=number_format(abs($vl_tot_creditos), 2, ",", "");
              $vl_sld_apurado=number_format(abs($vl_sld_apurado), 2, ",", "");
              $vl_icms_recolher=number_format(abs($vl_icms_recolher), 2, ",", "");
              $vl_sld_credor_ant=number_format(abs($vl_sld_credor_ant), 2, ",", "");

              $vl_sld_credor_transportar=number_format(abs($vl_sld_credor_transportar), 2, ",", "");


              $deb_esp='0';

              $linha1='|E110|'. $vl_tot_debitos.'|'.$vl_aj_debitos.'|'.$vl_tot_aj_debitos.'|'.$vl_estornos_deb.'|';
              $linha2=$vl_tot_creditos.'|'.$vl_aj_creditos.'|'.$vl_tot_aj_creditos.'|'.$vl_estornos_cred.'|';
              $linha3=$vl_sld_credor_ant.'|'.$vl_sld_apurado.'|'.$vl_tot_ded.'|'.$vl_icms_recolher.'|'.$vl_sld_credor_transportar.'|'.$deb_esp.'|';

              $linha=$linha1.$linha2.$linha3;
               _matriz_linha($linha);


 

}
// REGISTRO E111: AJUSTE/BENEFÍCIO/INCENTIVO DA APURAÇÃO DO ICMS.
// n:4

// REGISTRO E112: INFORMAÇÕES ADICIONAIS DOS AJUSTES DA APURAÇÃO DO ICMS.
// n:5

// REGISTRO E113: INFORMAÇÕES ADICIONAIS DOS AJUSTES DA APURAÇÃO  DO ICMS  IDENTIFICAÇÃO DOS DOCUMENTOS FISCAIS.
// n:5

// REGISTRO E115: INFORMAÇÕES ADICIONAIS DA APURAÇÃO  VALORES DECLARATÓRIOS.
// n:4

// REGISTRO E116: OBRIGAÇÕES DO ICMS A RECOLHER OPERAÇÕES PRÓPRIAS.
 function sped_efd_registro_E116() {
             global $info_segmento,$fp,$qtde_linha_bloco_e,$lanperiodo1,$lanperiodo2,$perdtos1,$perdtos2,$REG_BLC;
             global $TITEM_FLUXO,$TPRODUTOS ,$CONTITEM_FLUXO,$TSERVICOS,$info_cnpj_segmento,$perdtos1,$perdtos2,$TLANCAMENTOS;

             //$xsql_r="SELECT a.movimento,a.data,sum(a.vprod) as vvprod,sum(a.vbc) as vvbc,sum(a.vicms) as vvicms,sum(a.vbcst) as vvbcst,sum(a.vicmsst) as vvicmsst,sum(a.vipi) as vvipi,b.modelo FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b where a.dono=b.dono and contac<>'' and a.movimento='RECEITAS' and a.cnpjcpfseg='$info_cnpj_segmento' and ((a.data >= $perdtos1) and (a.data <= $perdtos2)) group by a.movimento";

             $modelos_inclusos="|01|1B|04|06|07|08|8B|09|10|11|21|22|26|27|28|29|55|57|2D|";
         	 $filtro_lancamentos=" and POSITION(b.modelo IN '$modelos_inclusos')>0";

             $xsql_r="SELECT a.movimento,a.data,sum(a.vprod) as vvprod,sum(a.vbc) as vvbc,sum(a.vicms) as vvicms,sum(a.vbcst) as vvbcst,sum(a.vicmsst) as vvicmsst,sum(a.vipi) as vvipi,b.modelo FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b where a.dono=b.dono and b.contac<>'' and b.lan_impostos<>'S' and a.movimento='RECEITAS' and a.cnpjcpfseg='$info_cnpj_segmento' and ((a.data >= $perdtos1) and (a.data <= $perdtos2)) $filtro_lancamentos group by a.movimento";

             $selunidade_r = mysql_query("$xsql_r",$CONTITEM_FLUXO);
             $vl_tot_debitos='0';

             $vl_aj_debitos='0';
             $vl_tot_aj_debitos='0';
             $vl_estornos_cred='0';

             $vl_aj_creditos='0';
             $vl_tot_aj_creditos='0';
             $vl_estornos_deb='0';
             

             while ( $punidade_r = mysql_fetch_assoc($selunidade_r) ) {
                   $vl_tot_debitos=$punidade_r[vvicms];
             }

             $xsql_r="SELECT *,sum(vprod) as vvprod,sum(vbc) as vvbc,sum(vicms) as vvicms,sum(vbcst) as vvbcst,sum(vicmsst) as vvicmsst,sum(vipi) as vvipi FROM $TITEM_FLUXO where  movimento='DESPESAS' and cnpjcpfseg='$info_cnpj_segmento'  and ((data >= $perdtos1) and (data <= $perdtos2)) group by movimento";

             $selunidade_c = mysql_query("$xsql_r",$CONTITEM_FLUXO);
             $vl_tot_creditos='0';
             while ( $punidade_c = mysql_fetch_assoc($selunidade_c) ) {
                   $vl_tot_creditos=$punidade_c[vvicms];
             }

              $vl_sld_credor_ant=$info_segmento[sped_efd_vl_sld_credor_ant];

              $vl_sld_apurado=($vl_tot_debitos)+($vl_aj_debitos+$vl_tot_aj_debitos)+($vl_estornos_cred)-($vl_tot_creditos)-($vl_aj_creditos+$vl_tot_aj_creditos)-($vl_estornos_deb) -($vl_sld_credor_ant);

                   if ($vl_sld_apurado>=0) {
                       $vl_sld_credor_transportar='0';
                   }

                   if ($vl_sld_apurado<0) {
                       $vl_sld_credor_transportar=abs($vl_sld_apurado);
                       $vl_sld_apurado='0';
                   }



              $vl_tot_ded=0;
              $vl_icms_recolher=$vl_sld_apurado-$vl_tot_ded;

              $vl_tot_debitos=number_format(abs($vl_tot_debitos), 2, ",", "");
              $vl_tot_creditos=number_format(abs($vl_tot_creditos), 2, ",", "");
              $vl_sld_apurado=number_format(abs($vl_sld_apurado), 2, ",", "");
              $vl_icms_recolher=number_format(abs($vl_icms_recolher), 2, ",", "");
              $vl_sld_credor_ant=number_format(abs($vl_sld_credor_ant), 2, ",", "");


              $vl_sld_credor_transportar=number_format(abs($vl_sld_credor_transportar), 2, ",", "");

              $deb_esp='0';
              $cod_or='000';
              /*
              Código da obrigação a recolher,conforme tabela 5.4
              000    ICMS a recolher
              001    ICMS da substituição tributária pelas entradas
              002    ICMS da substituição tributária pelas saídas para o Estado
              003    Antecipação do diferencial de alíquotas do ICMS
              004    Antecipação do ICMS da importação
              005    Antecipação tributária
              006    ICMS resultante da alíquota adicional dos itens incluídos no Fundo de Combate à Pobreza
              090    Outras obrigações do ICMS
              999    ICMS da substituição tributária pelas saídas para outro Estado
              */
              $dt_vcto=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo2));
              $cod_rec='DAE'; //Código de receita referente a obrigação,proprio da uf,conf. legislação estadual
              $num_proc=''; //Número do processo ou ato de infração ao qual a obrigação esta vinculada,se houver.
              $ind_proc='';
              /* Indicador de origem do processo
              0- Sefaz
              1- Justiça federal
              2- Justiça estadual
              9- Outros
              */
              $proc='';  //Descrição resumida do processo que embassou o lançamento
              $txt_compl='';         //Descrição complementar da obrigação a recolher
              $mes_ref=substr(_myfunc_stod($lanperiodo2),3,2).substr(_myfunc_stod($lanperiodo2),6,4);


              $linha1='|E116|'. $cod_or.'|'.$vl_icms_recolher.'|'.$dt_vcto.'|'.$cod_rec.'|'.$num_proc.'|'.$ind_proc.'|'.$proc.'|';
              $linha2=$txt_compl.'|'.$mes_ref.'|';
              
              $linha=$linha1.$linha2;
		      _matriz_linha($linha);
              return;
}





// REGISTRO E200: PERÍODO DA APURAÇÃO DO ICMS - SUBSTITUIÇÃO TRIBUTÁRIA.

 function sped_efd_registro_E200() {

       global $info_segmento,$fp,$qtde_linha_bloco_0,$qtde_linha_bloco_e,$REG_BLC;
       global $TITEM_FLUXO,$CONTITEM_FLUXO,$info_cnpj_segmento,$perdtos1,$perdtos2,$TCNPJCPF,$lanperiodo1,$lanperiodo2;

       $xsql="SELECT sum(a.vicmsst) as vvicmsst,a.cnpjcpf,b.uf as estado FROM $TITEM_FLUXO as a,$TCNPJCPF as b where a.cnpjcpf=b.cnpj and cnpjcpfseg='$info_cnpj_segmento'  and ((a.data >= $perdtos1) and (a.data <= $perdtos2)) group by estado order by estado";

       $sele200 = mysql_query("$xsql",$CONTITEM_FLUXO);
       $ordem_documento_emitido=0;
       $dt_ini=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo1));
       $dt_fin=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo2));
       $tot_registro_bloco_E200=0;
       $tot_registro_bloco_E210=0;
       while ( $puf = mysql_fetch_assoc($sele200) ) {
            if ($puf[vvicmsst]>0) {
                $estado=$puf[estado];
                $linha='|E200|'.$estado.'|'.$dt_ini.'|'.$dt_fin.'|';
			    _matriz_linha($linha);
                                  
                //REGISTRO E210: APURAÇÃO DO ICMS  SUBSTITUIÇÃO TRIBUTÁRIA.
                sped_efd_registro_E210($estado);
             }
       }
                        


}




//REGISTRO E210: APURAÇÃO DO ICMS  SUBSTITUIÇÃO TRIBUTÁRIA.
 function sped_efd_registro_E210($estado) {

                        global $info_segmento,$fp,$qtde_linha_bloco_0,$qtde_linha_bloco_e,$REG_BLC;
                        global $TITEM_FLUXO,$CONTITEM_FLUXO,$info_cnpj_segmento,$perdtos1,$perdtos2,$TCNPJCPF,$lanperiodo1,$lanperiodo2;
                         $xsql="SELECT sum(a.vicmsst) as vvicmsst,a.cnpjcpf,b.uf as estado FROM $TITEM_FLUXO as a,$TCNPJCPF as b where a.cnpjcpf=b.cnpj and cnpjcpfseg='$info_cnpj_segmento' and ((a.data >= $perdtos1) and (a.data <= $perdtos2)) and b.uf='$estado' group by estado order by estado";

                         $sele210 = mysql_query("$xsql",$CONTITEM_FLUXO);
                         $ordem_documento_emitido=0;
                         $dt_ini=_myfunc_ddmmaaaa($lanperiodo1);
                         $dt_fin=_myfunc_ddmmaaaa($lanperiodo2);

                         $p210 = mysql_fetch_assoc($sele210);
                         $IND_MOV_ST='0';
                         if ($p210[vvicmsst]>0) {
                             $IND_MOV_ST='1';
                         }

                         $VL_SLD_CRED_ANT_ST=$info_segmento[sped_efd_vl_sld_cred_ant_st];

                         $VL_DEVOL_ST=0;
                         $cfops='a.cfop IN (1410|1411|1414|1415|1660|1661|1662|2410|2411|2414|2415|2660|2661|2662)';
                         $xsql="SELECT sum(a.vicmsst) as vvicmsst,a.cnpjcpf,b.uf as estado FROM $TITEM_FLUXO as a,$TCNPJCPF as b where a.cnpjcpf=b.cnpj and cnpjcpfseg='$info_cnpj_segmento'  and ((a.data >= $perdtos1) and (a.data <= $perdtos2)) and $cfops and b.uf='$estado' group by a.cnpjcpfseg";

                         $sele210a = mysql_query("$xsql",$CONTITEM_FLUXO);
                         if (mysql_num_rows($sele210a)>0) {
                            $p210a = mysql_fetch_assoc($sele210a)  ;
                            $VL_DEVOL_ST=$p210a[vvicmsst];
                         }

                         $VL_RESSARC_ST=0;
                         $cfops='a.cfop IN (1603|2603)';
                         $xsql="SELECT sum(a.vicmsst) as vvicmsst,a.cnpjcpf,b.uf as estado FROM $TITEM_FLUXO as a,$TCNPJCPF as b where a.cnpjcpf=b.cnpj and cnpjcpfseg='$info_cnpj_segmento'  and ((a.data >= $perdtos1) and (a.data <= $perdtos2)) and $cfops and b.uf='$estado' group by a.cnpjcpfseg";

                         $sele210b = mysql_query("$xsql",$CONTITEM_FLUXO);
                         if (mysql_num_rows($sele210b)>0) {
                            $p210b = mysql_fetch_assoc($sele210b)  ;
                            $VL_RESSARC_ST=$p210b[vvicmsst];
                         }
                         $VL_RESSARC_ST=0;

                         $VL_AJ_CREDITOS_ST=0;
                         $VL_RETENCAO_ST=0;
                         $filtro_c="and (substring(cfop,1,1)='1' or substring(cfop,1,1)='2')";
                         $xsql="SELECT sum(a.vicmsst) as vvicmsst,a.cnpjcpf,b.uf as estado FROM $TITEM_FLUXO as a,$TCNPJCPF as b where a.cnpjcpf=b.cnpj and cnpjcpfseg='$info_cnpj_segmento'  and ((a.data >= $perdtos1) and (a.data <= $perdtos2)) $filtro_c and b.uf='$estado' group by a.cnpjcpfseg";
                         
                         $VL_OUT_CRED_ST=0;
                         $sele210c = mysql_query("$xsql",$CONTITEM_FLUXO);
                         if (mysql_num_rows($sele210c)>0) {
                            $p210c = mysql_fetch_assoc($sele210c)  ;
                            $VL_OUT_CRED_ST=$p210c[vvicmsst];
                         }

                        // echo '<br>'.$estado.'|'.$p210c[vvicmsst].'<br>';

                         $VL_OUT_DEB_ST=0;
                         $VL_AJ_DEBITOS_ST=0;
                         $VL_SLD_DEV_ANT_ST=($VL_RETENCAO_ST+$VL_OUT_DEB_ST+$VL_AJ_DEBITOS_ST)-($VL_SLD_CRED_ANT_ST+$VL_DEVOL_ST+$VL_RESSARC_ST+$VL_OUT_CRED_ST+$VL_AJ_CREDITOS_ST);

                         $VL_DEDUCOES_ST=0;
                         $VL_ICMS_RECOL_ST=0;

                         $VL_SLD_CRED_ST_TRANSPORTAR=0;
                         IF ($VL_SLD_DEV_ANT_ST>=0) {
                            $VL_SLD_CRED_ST_TRANSPORTAR=0;
                         }ELSE{
                            $VL_SLD_CRED_ST_TRANSPORTAR=ABS($VL_SLD_DEV_ANT_ST);
                            $VL_SLD_DEV_ANT_ST=0;

                         }
                         $VL_ICMS_RECOL_ST=$VL_SLD_DEV_ANT_ST-$VL_DEDUCOES_ST;


                         $DEB_ESP_ST=0;

                         $VL_SLD_CRED_ANT_ST=_function_formata_valor_real_2_decimais_virgula_sped($VL_SLD_CRED_ANT_ST);
                         $VL_DEVOL_ST=_function_formata_valor_real_2_decimais_virgula_sped($VL_DEVOL_ST);
                         $VL_RESSARC_ST=_function_formata_valor_real_2_decimais_virgula_sped($VL_RESSARC_ST);
                         $VL_OUT_CRED_ST=number_format(abs($VL_OUT_CRED_ST), 2, ",", "");

                         $VL_AJ_CREDITOS_ST=_function_formata_valor_real_2_decimais_virgula_sped($VL_AJ_CREDITOS_ST);
                         $VL_RETENCAO_ST=_function_formata_valor_real_2_decimais_virgula_sped($VL_RETENCAO_ST);
                         $VL_OUT_DEB_ST=_function_formata_valor_real_2_decimais_virgula_sped($VL_OUT_DEB_ST);
                         $VL_AJ_DEBITOS_ST=_function_formata_valor_real_2_decimais_virgula_sped($VL_AJ_DEBITOS_ST);
                         $VL_SLD_DEV_ANT_ST=_function_formata_valor_real_2_decimais_virgula_sped($VL_SLD_DEV_ANT_ST);
                         $VL_DEDUCOES_ST=_function_formata_valor_real_2_decimais_virgula_sped($VL_DEDUCOES_ST);
                         $VL_ICMS_RECOL_ST=_function_formata_valor_real_2_decimais_virgula_sped($VL_ICMS_RECOL_ST);
                         $VL_SLD_CRED_ST_TRANSPORTAR=number_format(abs($VL_SLD_CRED_ST_TRANSPORTAR), 2, ",", "");
                         $DEB_ESP_ST=_function_formata_valor_real_2_decimais_virgula_sped($DEB_ESP_ST);


                         $linha='|E210|'.$IND_MOV_ST.'|'.$VL_SLD_CRED_ANT_ST.'|'.$VL_DEVOL_ST.'|'.$VL_RESSARC_ST.'|'.$VL_OUT_CRED_ST.'|'.$VL_AJ_CREDITOS_ST.'|'.$VL_RETENCAO_ST.'|'.$VL_OUT_DEB_ST.'|'.$VL_AJ_DEBITOS_ST.'|'.$VL_SLD_DEV_ANT_ST.'|'.$VL_DEDUCOES_ST.'|'.$VL_ICMS_RECOL_ST.'|'.$VL_SLD_CRED_ST_TRANSPORTAR.'|'.$DEB_ESP_ST.'|';
				         _matriz_linha($linha);



}

// REGISTRO E220: AJUSTE/BENEFÍCIO/INCENTIVO DA APURAÇÃO DO ICMS SUBSTITUIÇÃO TRIBUTÁRIA.
// n:4

// REGISTRO E230: INFORMAÇÕES ADICIONAIS DOS AJUSTES DA APURAÇÃO DO ICMS SUBSTITUIÇÃO TRIBUTÁRIA.
// n:5

// EGISTRO E240: INFORMAÇÕES ADICIONAIS DOS AJUSTES DA APURAÇÃO DO ICMS SUBSTITUIÇÃO TRIBUTÁRIA  IDENTIFICAÇÃO DOS DOCUMENTOS FISCAIS.
// n:5

// REGISTRO E250: OBRIGAÇÕES DO ICMS A RECOLHER  SUBSTITUIÇÃO TRIBUTÁRIA.
// n:4






//REGISTRO E500: PERÍODO DE APURAÇÃO DO IPI.  N:2

 function sped_efd_registro_E500() {
             global $info_segmento,$fp,$qtde_linha_bloco_e,$lanperiodo1,$lanperiodo2,$REG_BLC;
                 $dt_ini=_myfunc_ddmmaaaa($lanperiodo1);
                 $dt_fin=_myfunc_ddmmaaaa($lanperiodo2);
                 $qtde_linha_bloco_e++;
                 $tot_registro_bloco_E500=1;
                 $ind_apur='0';
                 $linha="|E500|$ind_apur|$dt_ini|$dt_fin|";
		         _matriz_linha($linha);
                 return;
}

// REGISTRO E510: CONSOLIDAÇÃO DOS VALORES DO IPI.  n:3

function sped_efd_registro_E510() {
                        global $info_segmento,$fp,$TITEM_FLUXO,$CONTITEM_FLUXO,$info_cnpj_segmento,$perdtos1,$perdtos2,$qtde_linha_bloco_e,$REG_BLC;
                         $xsql_e510="SELECT cfop,cstipi,sum(vprod) as s_vcont_ipi,sum(vbcipi) as s_vbcipi,sum(vipi) as s_vipi FROM $TITEM_FLUXO where cnpjcpfseg='$info_cnpj_segmento' and vipi>0 and ((data >= $perdtos1) and (data <= $perdtos2)) group by cfop,cstipi";

                           
                         $sel_e510 = mysql_query("$xsql_e510",$CONTITEM_FLUXO);
                         $tot_registro_bloco_E510;
                         while ( $p_e510 = mysql_fetch_assoc($sel_e510) ) {
                               $cfop=$p_e510[cfop];
                               $cst_ipi=$p_e510[cstipi];
                               
                               $vl_vcont_ipi=$p_e510[s_vcont_ipi];  $vl_bcipi=number_format(abs($vl_vcont_ipi), 2, ",", "")  ;
                               if ($vl_vcont_ipi==0) {
                                   $vl_vcont_ipi='0';
                               }
                               $vl_bcipi=$p_e510[s_vbcipi];  $vl_bcipi=number_format(abs($vl_bcipi), 2, ",", "")  ;
                               if ($vl_bcipi==0) {
                                   $vl_bcipi='0';
                               }



                               $vl_ipi=$p_e510[s_vipi];  $vl_ipi=number_format(abs($vl_ipi), 2, ",", "")  ;
                               if ($vl_ipi==0) {
                                   $vl_ipi='0';
                               }

                              $linha="|E510|$cfop|$cst_ipi|$vl_vcont_ipi|$vl_bcipi|$vl_ipi|";
				 _matriz_linha($linha);


                         }
                           


}

// REGISTRO E520: APURAÇÃO DO IPI.  n:3
 function sped_efd_registro_E520() {
global $info_segmento,$fp,$TITEM_FLUXO,$CONTITEM_FLUXO,$info_cnpj_segmento,$perdtos1,$perdtos2,$qtde_linha_bloco_e,$REG_BLC;

                        $vl_sd_ant_ipi=$info_segmento[sped_efd_vl_sld_ant_ipi];
                        $vl_sd_ant_ipi=number_format(abs($vl_sd_ant_ipi), 2, ",", "")  ;
                        if ($vl_sd_ant_ipi==0) {
                            $vl_sd_ant_ipi='0';
                        }
                        $vl_deb_ipi=0;
                        $filtro_c="substring(cfop,1,1)='5' or substring(cfop,1,1)='6'";
                        $xsql_e520="SELECT cfop,cstipi,sum(vipi) as s_vipi FROM $TITEM_FLUXO where $filtro_c and cnpjcpfseg='$info_cnpj_segmento' and vipi>0 and ((data >= $perdtos1) and (data <= $perdtos2)) group by cnpjcpfseg";
                        $sel_e520 = mysql_query("$xsql_e520",$CONTITEM_FLUXO);
                        if (mysql_num_rows($sel_e520)>0) {
                            $p520 = mysql_fetch_assoc($sel_e520)  ;
                            $vl_deb_ipi=$p520[s_vipi];
                        }
                        if ($vl_deb_ipi==0) {
                            $vl_deb_ipi='0';
                        }

                        $vl_cred_ipi=0;
                        $filtro_c="substring(cfop,1,1)='1' or substring(cfop,1,1)='2'  or substring(cfop,1,1)='3'";
                        $xsql_e520="SELECT cfop,cstipi,sum(vipi) as s_vipi FROM $TITEM_FLUXO where $filtro_c and cnpjcpfseg='$info_cnpj_segmento' and vipi>0 and ((data >= $perdtos1) and (data <= $perdtos2)) group by cnpjcpfseg";
                        $sel_e520 = mysql_query("$xsql_e520",$CONTITEM_FLUXO);
                        if (mysql_num_rows($sel_e520)>0) {
                            $p520 = mysql_fetch_assoc($sel_e520)  ;
                            $vl_cred_ipi=$p520[s_vipi];
                        }
                        if ($vl_cred_ipi==0) {
                            $vl_cred_ipi='0';
                        }


                        $vl_od_ipi=0;
                        $vl_oc_ipi=0;
                        
                        $vl_calc=(($vl_deb_ipi+$vl_od_ipi) - ($vl_sd_ant_ipi+$vl_cred_ipi+$vl_oc_ipi));
                        
                        if($vl_calc<0) {
                          $vl_sc_ipi=abs($vl_calc);
                          $vl_sd_ipi=0;
                        }else{
                          $vl_sc_ipi=0;
                          $vl_sd_ipi=abs($vl_calc);
                        
                        }
                        if ($vl_sc_ipi==0) {
                            $vl_sc_ipi='0';
                        }
                        
                        if ($vl_sd_ipi==0) {
                            $vl_sd_ipi='0';
                        }

                        $qtde_linha_bloco_e++;
                        $linha="|E520|".$vl_sd_ant_ipi."|".$vl_deb_ipi."|".$vl_cred_ipi."|".$vl_od_ipi."|".$vl_oc_ipi."|".$vl_sc_ipi."|".$vl_sd_ipi."|";
				 _matriz_linha($linha);


                        
}


//REGISTRO E530: AJUSTES DA APURAÇÃO DO IPI. n:4


//REGISTRO E990: ENCERRAMENTO DO BLOCO E
function sped_efd_registro_E990() {
                     global $info_segmento,$fp;
                     $qtde_linha_bloco=_myfunc_qtde_registro_matriz_linha_sped('E') + 1;
                     $linha='|E990|'.$qtde_linha_bloco.'|';
		     _matriz_linha($linha);
echo "<br> BLOCO E";
flush();

                     return;
}


//BLOCO G: CONTROLE DE CREDITO DE ICMS DO ATIVO PERMANENTE
// REGISTRO G001: ABERTURA DO BLOCO G



 

sped_efd_registro_G001();

sped_efd_registro_G990();



// REGISTRO G001: ABERTURA DO BLOCO G
function sped_efd_registro_G001() {
             global $info_segmento,$fp,$qtde_linha_bloco_g,$REG_BLC;
                 $qtde_linha_bloco_g++;
                 $linha="|G001|1|";
		 _matriz_linha($linha);
                 return;
}


//REGISTRO G990: ENCERRAMENTO DO BLOCO G

function sped_efd_registro_G990() {
                     global $info_segmento,$fp;
                     $qtde_linha_bloco=_myfunc_qtde_registro_matriz_linha_sped('G') + 1;
                     $linha='|G990|'.$qtde_linha_bloco.'|';
		     _matriz_linha($linha);
echo "<br> BLOCO G";
flush();

                     return;
}



//BLOCO H: INVENTÁRIO FÍSICO
// REGISTRO H001: ABERTURA DO BLOCO H
sped_efd_registro_H001();


//REGISTRO H005: TOTAIS DO INVENTÁRIO N:2
if($chkinventario=="on"){
   $vl_inv=sped_efd_registro_H005() ;
   IF ($vl_inv>0) {  // APENAS SE $vl_inv>0 , TEM ITENS
      //REGISTRO H010: INVENTÁRIO. n:3
      sped_efd_registro_H010() ;
   }
}

//REGISTRO H990: ENCERRAMENTO DO BLOCO H.
sped_efd_registro_H990() ;


//REGISTRO H001: ABERTURA DO BLOCO H
function sped_efd_registro_H001() {
             global $info_segmento,$fp,$chkinventario;
                 $qtde_linha_bloco_h++;
                 $linha ="|H001|1|";
                 if($chkinventario=="on"){
			                 $linha ="|H001|0|";
                 }
		 _matriz_linha($linha);
echo "<br> BLOCO H";
flush();

                 return;
}

//REGISTRO H005: TOTAIS DO INVENTÁRIO N:2
function sped_efd_registro_H005() {
                        global $info_segmento,$fp,$TITEM_FLUXO,$CONTITEM_FLUXO,$info_cnpj_segmento,$perdtos1,$perdtos2,$qtde_linha_bloco_h,$TPRODUTOS,$lanperiodo2,$REG_BLC;
                        $xsql_h005="SELECT a.cprod,b.conta,b.descricao,sum(qcom*flag_mult) as qtotal,b.ccustodoc,b.ccustomedio from $TITEM_FLUXO as a,$TPRODUTOS as b where a.cprod=b.conta and cnpjcpfseg='$info_cnpj_segmento' and (data <= $perdtos2) group by a.cprod";
                        $sel_h005 = mysql_query("$xsql_h005",$CONTITEM_FLUXO);
                        $vl_inv=0;
                        if ($p_h005[qtotal]>0) {
                           while ( $p_h005 = mysql_fetch_assoc($sel_h005) ) {
                                 $vl_inv=$vl_inv+ ($p_h005[ccustodoc]*$p_h005[qtotal]);
                           }
                        }
                        $vl_inv=number_format(abs($vl_inv), 2, ",", "")  ;
                               if ($vl_inv==0) {
                                   $vl_inv='0';
                               }
                        $dt_fin=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo2));

                        $linha = "|H005|$dt_fin|$vl_inv";
			 _matriz_linha($linha);

                        RETURN $vl_inv;  // RETORNA VALOR DO INVENTÁRIO, CASO 0 NAO GERA O H010

                        

}
//REGISTRO H010: TOTAIS DO INVENTÁRIO N:2
function sped_efd_registro_H010() {
                        global $info_segmento,$fp,$TITEM_FLUXO,$CONTITEM_FLUXO,$info_cnpj_segmento,$perdtos1,$perdtos2,$qtde_linha_bloco_h,$TPRODUTOS,$lanperiodo2,$REG_BLC;
                        $xsql_h010="SELECT a.cprod,b.conta,b.descricao,b.unidade,sum(qcom*flag_mult) as qtotal,b.ccustodoc,b.ccustomedio from $TITEM_FLUXO as a,$TPRODUTOS as b where a.cprod=b.conta and cnpjcpfseg='$info_cnpj_segmento' and (data <= $perdtos2) group by a.cprod";
                        $sel_h010 = mysql_query("$xsql_h010",$CONTITEM_FLUXO);

                        $tot_registro_bloco_H010=0;
                        if ($p_h010[qtotal]>0) {
		                while ( $p_h010 = mysql_fetch_assoc($sel_h010) ) {
		                      $cod_item=$p_h010[conta];
		                      $unid=$p_h010[unidade];
		                      $qtd=$p_h010[qtotal];
		                      $vl_unit=$p_h010[ccustodoc];
		                      $vl_item=$p_h010[ccustodoc]*$p_h010[qtotal];
		                      $ind_prop='0';
		                      $cod_part='';
		                      $txt_compl=$p_h010[descricao];
		                      $cod_cta='';
		                      $vl_unit=number_format(abs($vl_unit), 2, ",", "")  ;
		                       if ($vl_unit==0) {
		                           $vl_unit='0';
		                       }
		                       $vl_item=number_format(abs($vl_item), 2, ",", "")  ;
		                       if ($vl_item==0) {
		                           $vl_item='0';
		                       }

	
		                       $linha= "H010|".$cod_item."|".$unid."|".$qtd."|".$vl_unit."|".$vl_item."|".$ind_prop."|".$txt_compl."|".$cod_cta."|";
					 _matriz_linha($linha);

		                }
                        }



}


function sped_efd_registro_H990() {
                  
                     global $info_segmento,$fp;
                     $qtde_linha_bloco=_myfunc_qtde_registro_matriz_linha_sped('H') + 1;
                     $linha='|H990|'.$qtde_linha_bloco.'|';
		     _matriz_linha($linha);

                     return;
}





  



/////////////////////////////////
// REGISTRO 1: OUTRAS INFORMAÇÕES
/////////////////////////////////
	sped_efd_registro_1001();
if ($cod_ver>='006') {
	sped_efd_registro_1010();
}
		if ($pcind_perfil=='A')    {
		    // REGISTRO 1001: ABERTURA DO BLOCO 1

		   //REGISTRO 1100: REGISTRO DE INFORMAÇÕES SOBRE EXPORTAÇÃO

		   //REGISTRO 1105: DOCUMENTOS FISCAIS DE EXPORTAÇÃO

		   //REGISTRO 1110: OPERAÇÕES DE EXPORTAÇÃO INDIRETA DE PRODUTOS NÃO INDUSTRIALIZADOS PELO ESTABELECIMENTO EMITENTE

		   //REGISTRO 1200: CONTROLE DE CRÉDITOS FISCAIS - ICMS

		   //REGISTRO 1210: UTILIZAÇÃO DE CRÉDITOS FISCAIS - ICMS

		   //REGISTRO 1300: MOVIMENTAÇÃO DIARIA DE COMBUSTIVEIS
		   // N:2
		  //  sped_efd_registro_1300();

		   // registro 1350
		   //REGISTRO 1350: BOMBAS
		   // N:2
		   //sped_efd_registro_1350();

		   //REGISTRO 1310: MOVIMENTAÇÃO DIARIA DE COMBUSTIVEIS POR TANQUE
			   // Nivel - 3

		   //REGISTRO 1320: VOLUME DE VENDAS
			   // Nivel - 4

		   //REGISTRO 1350: BOMBAS
			   // Nivel - 2

		   //REGISTRO 1350: LACRES DA BOMBA
			   // Nivel - 3

		   //REGISTRO 1370: BICOS DA BOMBA
			   // Nivel - 3


		    }

		//REGISTRO 1990: ENCERRAMENTO DO BLOCO 1
		sped_efd_registro_1990();




		// REGISTRO 1001: ABERTURA DO BLOCO 1

		function sped_efd_registro_1001() {
			     global $info_segmento,$fp,$cod_ver;
				if ($cod_ver>='006') {
					 $linha="|1001|0|";  
				}else{
					 $linha="|1001|1|";  
				}
				     _matriz_linha($linha);
			     return;

		}
		function sped_efd_registro_1010() {
			     global $info_segmento,$fp;

				$ind_exp='N';
				$ind_ccrf='N';
				$ind_comb='N';
				$ind_usina='N';
				$ind_va='N';
				$ind_ee='N';
				$ind_cart='N';
				$ind_form='N';
				$ind_aer='N';


			     $linha="|1010|$ind_exp|$ind_ccrf|$ind_comb|$ind_usina|$ind_va|$ind_ee|$ind_cart|$ind_form|$ind_aer|";  
				     _matriz_linha($linha);
			     return;

		}


	// REGISTRO 1010: OBRIGATORIEDADE DE REGISTROS DO BLOCO 1

 


//REGISTRO 1100: REGISTRO DE INFORMAÇÕES SOBRE EXPORTAÇÃO

//REGISTRO 1105: DOCUMENTOS FISCAIS DE EXPORTAÇÃO

//REGISTRO 1110: OPERAÇÕES DE EXPORTAÇÃO INDIRETA DE PRODUTOS NÃO INDUSTRIALIZADOS PELO ESTABELECIMENTO EMITENTE

//REGISTRO 1200: CONTROLE DE CRÉDITOS FISCAIS - ICMS

//REGISTRO 1210: UTILIZAÇÃO DE CRÉDITOS FISCAIS - ICMS

//REGISTRO 1300: MOVIMENTAÇÃO DIARIA DE COMBUSTIVEIS
function sped_efd_registro_1300(){
                global $info_segmento,$fp,$qtde_linha_bloco,$qtde_linha_bloco_1,$REG_BLC,$TLMC,$CONTLMC,$info_cnpj_segmento;
                global $tot_registro_bloco_1300,$tot_registro_bloco_1310,$tot_registro_bloco_1320,$info_cnpj_segmento,$perdtos1,$perdtos2;

                $xsql_1300="SELECT *,sum(ab_tanque) as vab_tanque,sum(entrada_nf) as ventrada_nf,sum(venda_b1) as vvd_b1,sum(venda_b2) as vvd_b2,sum(venda_b3) as vvd_b3,sum(venda_b4) as vvd_b4,sum(venda_b5) as vvd_b5,sum(estoque_ini) as vestoque_ini,sum(per_sob) as vper_sob,sum(estoque_final) as vestoque_final from $TLMC where cnpjcpfseg='$info_cnpj_segmento' and ((data_e_s >= $perdtos1) and (data_e_s <= $perdtos2)) group by data_e_s,cprod order by data_e_s,cprod";
                $seldiferedono = mysql_query("$xsql_1300",$CONTLMC);

                $tot_registro_bloco=0;
                $tot_registro_bloco_1300=0;
                $tot_registro_bloco_1310=0;
                $tot_registro_bloco_1320=0;


                while ( $pdono = mysql_fetch_assoc($seldiferedono) ) {

                          $cod_item=$pdono[cprod];
                          $data_parametro=$pdono[data_e_s];
                          $dt_fech=_myfunc_ddmmaaaa(_myfunc_stod($data_parametro));
                          //$estq_abert=$pdono[vab_tanque];
                          $estq_abert=number_format(abs($pdono[vab_tanque]), 2, ",", "")  ;
                          if ($estq_abert==0) {
                              $estq_abert='0';
                          }
                          $vol_entr=number_format(abs($pdono[ventrada_nf]), 2, ",", "");
                          if ($vol_entr==0) {
                              $vol_entr='0';
                          }

                          $vol_disp=number_format(abs($pdono[ventrada_nf]+$pdono[vab_tanque]), 2, ",", "");
                          if ($vol_disp==0) {
                              $vol_disp='0';
                          }
                          
                          $vol_saidas=number_format(abs($pdono[vvd_b1]+$pdono[vvd_b2]+$pdono[vvd_b3]+$pdono[vvd_b4]+$pdono[vvd_b5]), 2, ",", "");
                          if ($vol_saidas==0) {
                              $vol_saidas='0';
                          }

                          $estq_escr=number_format(abs($pdono[vestoque_ini]), 2, ",", "");
                          if ($estq_escr==0) {
                              $estq_escr='0';
                          }

                          $vl_aj_perda=number_format(abs($pdono[vper_sob]), 2, ",", "");
                          if ($vl_aj_perda==0) {
                              $vl_aj_perda='0';
                          }

                          $vl_aj_ganho=number_format(abs($pdono[vper_sob]), 2, ",", "");
                          if ($vl_aj_ganho==0) {
                              $vl_aj_ganho='0';
                          }

                          $fech_fisico=number_format(abs($pdono[vestoque_final]), 2, ",", "");
                          if ($fech_fisico==0) {
                              $fech_fisico='0';
                          }
                          
                          
                          $linha1='|1300|'.$cod_item.'|'.$dt_fech.'|'.$estq_abert.'|'.$vol_entr.'|'.$vol_disp.'|'.$vol_saidas.'|';
                          $linha2=$estq_escr.'|'.$vl_aj_perda.'|'.$vl_aj_ganho.'|'.$fech_fisico.'|';
                          $linha="$linha1"."$linha2";
                          $qtde_linha_bloco_1++ ;
                          $escreve = fwrite($fp, "$linha\r\n");
                          $tot_registro_bloco_1300=$tot_registro_bloco_1300+1;

                          //1310  filho
                          //REGISTRO 1310: MOVIMENTAÇÃO DIARIA DE COMBUSTIVEL POR TANQUE
                          //N:3
                          sped_efd_registro_1310($data_parametro);
                                   

                }

                 if ($tot_registro_bloco_1300>0) {
                   $REG_BLC[]='|1300|'.$tot_registro_bloco_1300.'|';
                }

                if ($tot_registro_bloco_1310>0) {
                   $REG_BLC[]='|1310|'.$tot_registro_bloco_1310.'|';
                }
                if ($tot_registro_bloco_1320>0) {
                   $REG_BLC[]='|1320|'.$tot_registro_bloco_1320.'|';
                }
                return;
}


//REGISTRO 1310: MOVIMENTAÇÃO DIARIA DE COMBUSTIVEIS POR TANQUE
// Nivel - 3
function sped_efd_registro_1310($data_parametro) {
                global $info_segmento,$fp,$qtde_linha_bloco,$qtde_linha_bloco_1,$REG_BLC;
                global $TLMC,$CONTLMC,$info_cnpj_segmento,$tot_registro_bloco_1310,$tot_registro_bloco_1320;
                
                $xsql_1310="SELECT * from $TLMC where cnpjcpfseg='$info_cnpj_segmento' and data_e_s=$data_parametro order by tanque1";
                $seldiferedono = mysql_query("$xsql_1310",$CONTLMC);

                while ( $pdono310 = mysql_fetch_assoc($seldiferedono) ) {

                          $num_tanque=$pdono310[tanque1];
                          $estq_abert=$pdono310[qtde_tq1];
                          if ($estq_abert==0) {
                              $estq_abert='0';
                          }else{
                              $estq_abert=number_format(abs($pdono310[qtde_tq1]), 2, ",", "")  ;
                          }


                          $vol_entr=$pdono310[qt_nf1]+$pdono310[qt_nf2]+$pdono310[qt_nf3]+$pdono310[qt_nf4]+$pdono310[qt_nf5];
                          $vol_entr=number_format(abs($vol_entr), 2, ",", "")  ;
                          if ($vol_entr==0) {
                              $vol_entr='0';
                          }

                          $vol_disp=$pdono310[qtde_tq1]+$pdono310[qt_nf1]+$pdono310[qt_nf2]+$pdono310[qt_nf3]+$pdono310[qt_nf4]+$pdono310[qt_nf5];
                          $xvol_disp=$vol_disp;
                          $vol_disp=number_format(abs($vol_disp), 2, ",", "")  ;
                          if ($vol_disp==0) {
                              $vol_disp='0';
                          }

                          $vol_saidas=$pdono310[venda_b1]+$pdono310[venda_b2]+$pdono310[venda_b3]+$pdono310[venda_b4]+$pdono310[venda_b5];
                          $xvol_saidas=$vol_saidas;
                          $vol_saidas=number_format(abs($vol_saidas), 2, ",", "")  ;
                          if ($vol_saidas==0) {
                              $vol_saidas='0';
                          }

                          $estq_escr=$xvol_disp-$xvol_saidas;
                          $estq_escr=number_format(abs($estq_escr), 2, ",", "")  ;
                          if ($estq_escr==0) {
                              $estq_escr='0';
                          }

                          $vl_aj_perda=$pdono310[per_sob];
                          $vl_aj_perda=number_format(abs($vl_aj_perda), 2, ",", "")  ;
                          if ($vl_aj_perda==0) {
                              $vl_aj_perda='0';
                          }

                          $vl_aj_ganho=$pdono310[per_sob];
                          $vl_aj_ganho=number_format(abs($vl_aj_ganho), 2, ",", "")  ;
                          if ($vl_aj_ganho==0) {
                              $vl_aj_ganho='0';
                          }

                          $fech_fisico=$pdono310[estoque_final];
                          $fech_fisico=number_format(abs($fech_fisico), 2, ",", "")  ;
                          if ($fech_fisico==0) {
                              $fech_fisico='0';
                          }
                          
                          
                          $linha1='|1310|'.$num_tanque.'|'.$estq_abert.'|'.$vol_entr.'|'.$vol_disp.'|'.$vol_saidas.'|';
                          $linha2=$estq_escr.'|'.$vl_aj_perda.'|'.$vl_aj_ganho.'|'.$fech_fisico.'|';
                          $linha="$linha1"."$linha2";
                          $qtde_linha_bloco_1++ ;
                          $escreve = fwrite($fp, "$linha\r\n");
                          $tot_registro_bloco_1310=$tot_registro_bloco_1310+1;

                          // registro 1320
                          //REGISTRO 1320: VOLUME DE VENDAS
                          // N:4
                          sped_efd_registro_1320($data_parametro,$num_tanque);

                          //FIM REGISTROS APRESENTADOS APENAS NAS SAÍDAS     */

                }

                return;
}

//REGISTRO 1320: VOLUME DE VENDAS
// Nivel - 4
function sped_efd_registro_1320($data_parametro,$num_tanque) {
                global $info_segmento,$fp,$qtde_linha_bloco,$qtde_linha_bloco_1,$REG_BLC;
                global $TLMC,$CONTLMC,$info_cnpj_segmento,$tot_registro_bloco_1320;
                
                $xsql_1320="SELECT * from $TLMC where cnpjcpfseg='$info_cnpj_segmento' and data_e_s=$data_parametro and tanque1='$num_tanque' order by tanque1";
                $seldiferedono = mysql_query("$xsql_1320",$CONTLMC);

                while ( $pdono320 = mysql_fetch_assoc($seldiferedono) ) {

                          $nr_interv='';
                          $mot_interv='';
                          $nom_interv='';
                          $cnpj_interv='';
                          $cpf_interv='';
                          if($pdono320[venda_b1]>0) 
                          {
                             $num_bico=$pdono320[bico1];
                             $val_fecha=$pdono320[ence_f_b1];
                             $val_fecha=number_format(abs($val_fecha), 2, ",", "")  ;
                             if ($val_fecha==0) {
                                 $val_fecha='0';
                             }

                             $val_abert=$pdono320[ence_i_b1];
                             $val_abert=number_format(abs($val_abert), 2, ",", "")  ;
                             if ($val_abert==0) {
                                 $val_abert='0';
                             }

                             $vol_aferi=$pdono320[afer_b1];
                             $vol_aferi=number_format(abs($vol_aferi), 2, ",", "")  ;
                             if ($vol_aferi==0) {
                                 $vol_aferi='0';
                             }

                             $vol_vendas=$pdono320[venda_b1];
                             $vol_vendas=number_format(abs($vol_vendas), 2, ",", "")  ;
                             if ($vol_vendas==0) {
                                 $vol_vendas='0';
                             }

                             $linha='|1320|'.$num_bico.'|'.$nr_interv.'|'.$mot_interv.'|'.$nom_interv.'|'.$cnpj_interv.'|'.$cpf_interv.'|'.$val_fecha.'|'.$val_abert.'|'.$vol_aferi.'|'.$vol_vendas.'|';
                             $qtde_linha_bloco_1++ ;
                             $escreve = fwrite($fp, "$linha\r\n");
                             $tot_registro_bloco_1320=$tot_registro_bloco_1320+1;

                          }
                          
                          if($pdono320[venda_b2]>0) 
                          {
                             $num_bico=$pdono320[bico2];
                             $val_fecha=$pdono320[ence_f_b2];
                             $val_fecha=number_format(abs($val_fecha), 2, ",", "")  ;
                             if ($val_fecha==0) {
                                 $val_fecha='0';
                             }

                             $val_abert=$pdono320[ence_i_b2];
                             $val_abert=number_format(abs($val_abert), 2, ",", "")  ;
                             if ($val_abert==0) {
                                 $val_abert='0';
                             }

                             $vol_aferi=$pdono320[afer_b2];
                             $vol_aferi=number_format(abs($vol_aferi), 2, ",", "")  ;
                             if ($vol_aferi==0) {
                                 $vol_aferi='0';
                             }

                             $vol_vendas=$pdono320[venda_b2];
                             $vol_vendas=number_format(abs($vol_vendas), 2, ",", "")  ;
                             if ($vol_vendas==0) {
                                 $vol_vendas='0';
                             }

                             $linha='|1320|'.$num_bico.'|'.$nr_interv.'|'.$mot_interv.'|'.$nom_interv.'|'.$cnpj_interv.'|'.$cpf_interv.'|'.$val_fecha.'|'.$val_abert.'|'.$vol_aferi.'|'.$vol_vendas.'|';
                             $qtde_linha_bloco_1++ ;
                             $escreve = fwrite($fp, "$linha\r\n");
                             $tot_registro_bloco_1320=$tot_registro_bloco_1320+1;

                          }
                          
                          if($pdono320[venda_b3]>0) 
                          {
                             $num_bico=$pdono320[bico3];
                             $val_fecha=$pdono320[ence_f_b3];
                             $val_fecha=number_format(abs($val_fecha), 2, ",", "")  ;
                             if ($val_fecha==0) {
                                 $val_fecha='0';
                             }

                             $val_abert=$pdono320[ence_i_b3];
                             $val_abert=number_format(abs($val_abert), 2, ",", "")  ;
                             if ($val_abert==0) {
                                 $val_abert='0';
                             }

                             $vol_aferi=$pdono320[afer_b3];
                             $vol_aferi=number_format(abs($vol_aferi), 2, ",", "")  ;
                             if ($vol_aferi==0) {
                                 $vol_aferi='0';
                             }

                             $vol_vendas=$pdono320[venda_b3];
                             $vol_vendas=number_format(abs($vol_vendas), 2, ",", "")  ;
                             if ($vol_vendas==0) {
                                 $vol_vendas='0';
                             }

                             $linha='|1320|'.$num_bico.'|'.$nr_interv.'|'.$mot_interv.'|'.$nom_interv.'|'.$cnpj_interv.'|'.$cpf_interv.'|'.$val_fecha.'|'.$val_abert.'|'.$vol_aferi.'|'.$vol_vendas.'|';
                             $qtde_linha_bloco_1++ ;
                             $escreve = fwrite($fp, "$linha\r\n");
                             $tot_registro_bloco_1320=$tot_registro_bloco_1320+1;

                          }

                          if($pdono320[venda_b4]>0) 
                          {
                             $num_bico=$pdono320[bico4];
                             $val_fecha=$pdono320[ence_f_b4];
                             $val_fecha=number_format(abs($val_fecha), 2, ",", "")  ;
                             if ($val_fecha==0) {
                                 $val_fecha='0';
                             }

                             $val_abert=$pdono320[ence_i_b4];
                             $val_abert=number_format(abs($val_abert), 2, ",", "")  ;
                             if ($val_abert==0) {
                                 $val_abert='0';
                             }

                             $vol_aferi=$pdono320[afer_b4];
                             $vol_aferi=number_format(abs($vol_aferi), 2, ",", "")  ;
                             if ($vol_aferi==0) {
                                 $vol_aferi='0';
                             }

                             $vol_vendas=$pdono320[venda_b4];
                             $vol_vendas=number_format(abs($vol_vendas), 2, ",", "")  ;
                             if ($vol_vendas==0) {
                                 $vol_vendas='0';
                             }

                             $linha='|1320|'.$num_bico.'|'.$nr_interv.'|'.$mot_interv.'|'.$nom_interv.'|'.$cnpj_interv.'|'.$cpf_interv.'|'.$val_fecha.'|'.$val_abert.'|'.$vol_aferi.'|'.$vol_vendas.'|';
                             $qtde_linha_bloco_1++ ;
                             $escreve = fwrite($fp, "$linha\r\n");
                             $tot_registro_bloco_1320=$tot_registro_bloco_1320+1;

                          }

                }

                return;
}

//REGISTRO 1350: BOMBAS
// Nivel - 2

//REGISTRO 1360: LACRES DA BOMBA
// Nivel - 3

//REGISTRO 1370: BICOS DA BOMBA
// Nivel - 3

//REGISTRO 1990: ENCERRAMENTO DO BLOCO 1
function sped_efd_registro_1990() {
               global $info_segmento,$fp;
                     $qtde_linha_bloco=_myfunc_qtde_registro_matriz_linha_sped('1') + 1;
                     $linha='|1990|'.$qtde_linha_bloco.'|';
		     _matriz_linha($linha);
echo "<br> BLOCO 1";
flush();
                     return;
}



// REGISTRO 9001: ABERTURA DO BLOCO 9
sped_efd_registro_9001();

// REGISTRO 9900: REGISTROS DO ARQUIVO.
sped_efd_registro_9900();

// REGISTRO 9990: ENCERRAMENTO DO BLOCO 9
sped_efd_registro_9990();


// REGISTRO 9999: ENCERRAMENTO DO ARQUIVO DIGITAL.
sped_efd_registro_9999();

// REGISTRO 9001: ABERTURA DO BLOCO 9

function sped_efd_registro_9001() {
             global $info_segmento,$fp;


                 $linha="|9001|0|";
		     _matriz_linha($linha);
               
                 return;
}


// REGISTRO 9900: REGISTROS DO ARQUIVO.

function sped_efd_registro_9900() {
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
function sped_efd_registro_9990() {
                     global $info_segmento,$fp;
                     $qtde_linha_bloco=_myfunc_qtde_registro_matriz_linha_sped('9') + 2;
                     $linha='|9990|'.$qtde_linha_bloco.'|';
		     _matriz_linha($linha);
                     return;
}


//REGISTRO 9999: ENCERRAMENTO DO arquivo digital
function sped_efd_registro_9999() {
                       global $info_segmento,$fp,$matriz_linha_sped;
			 
		             $qtde_linha_bloco=count($matriz_linha_sped)+1;
		             $linha='|9999|'.$qtde_linha_bloco.'|';
			     _matriz_linha($linha);
                     return;


}





 escreve_matriz_linha();
return;




function sped_tabelas_temporarias(){
         global $info_segmento,$info_cnpj_segmento;
         global $TITEM_FLUXO,$CONTITEM_FLUXO,$TLANCAMENTOS,$TNFDOCUMENTOS,$perdtos1,$perdtos2,$lanperiodo1,$lanperiodo2;

         //Temporaria dos lancamentos
         /*
         $xsqllan="SELECT * from $TLANCAMENTOS where cnpjcpfseg='$info_cnpj_segmento'  and ((data >= $perdtos1) and (data <= $perdtos2)) order by id";
         $sql_error='';

         $sql="drop table IF EXISTS tabela_lan_provisorio";  // apaga anterior
           if ( mysql_query($sql) or die (mysql_error()) ) {
                 }
         $sql_lan_provisorio="create table tabela_lan_provisorio($xsqllan)";
         if ( mysql_query($sql_lan_provisorio) or die (mysql_error()) ) {
            }
          */
         //Fim tabela lan_provisorio

         // Temporaria item para er usado nos registros C420,C460,C470,C490 , CUPOM FISCAIS , estava demorando demais o processamento
         $xsql_ifc400="SELECT a.*,b.modelo,b.data as data_e_s,b.cod_sit,b.documento,c.ecf_numimp as serial_imp,FROM_UNIXTIME(a.data,'%d/%m/%Y')  FROM $TITEM_FLUXO as a,$TLANCAMENTOS as b,$TNFDOCUMENTOS as c where a.cnpjcpfseg='$info_cnpj_segmento' and b.modelo='2D' and (a.dono=b.dono and a.dono=c.dono) and b.contac<>'' and (b.data >= '$perdtos1' and b.data<='$perdtos2') order by a.id";
         $sql_error='';

         $sql="drop table IF EXISTS tabela_c425_provisorio";  // apaga anterior
           if ( mysql_query($sql) or die (mysql_error()) ) {
                 }

         $sql_c400_provisorio="create table tabela_c425_provisorio($xsql_ifc400)";
         if ( mysql_query($sql_c400_provisorio) or die (mysql_error()) ) {
            }
         // FIM Temporaria item para er usado nos registros C420,C460,C470,C490 , CUPOM FISCAIS , estava demorando demais o processamento


         // Temporaria item para er usado nos registros C100,C170,C190 , NOTAS FISCAIS
         /*
         $xsql_nfc="SELECT * FROM $TITEM_FLUXO where cnpjcpfseg='$info_cnpj_segmento' and  (data >= '$perdtos1' and data<='$perdtos2') order by id";
         $sql_error='';

         $sql="drop table IF EXISTS tabela_itemfluxo_tmp";  // apaga anterior
           if ( mysql_query($sql) or die (mysql_error()) ) {
                 }

         $sql_nfc_provisorio="create table tabela_itemfluxo_tmp($xsql_nfc)";
         if ( mysql_query($sql_nfc_provisorio) or die (mysql_error()) ) {
            }
         // FIM Temporaria item para er usado nos registros C , CUPOM FISCAIS , estava demorando demais o processamento
         */
         return;
}


function  _matriz_linha($conteudo) {
         global $qtd_lin_C,$matriz_linha_sped,$l030,$J900;
         if (trim($conteudo)<> '') {
         $matriz_linha_sped[]=$conteudo;
 
  
         }
 
         return;
}
function escreve_matriz_linha(){
        global $matriz_linha_sped,$fp,$qtd_lin,$l030,$J900;
    
        $cont=0;
        $i = count($matriz_linha_sped);
        
 
 
      
        
        while($cont < $i) {
                $linha = trim($matriz_linha_sped[$cont]);
                $escreve = fwrite($fp,"$linha\r\n");
 

                $cont++;
        }

        return ;
}

 


return;
exit;


 


?>
