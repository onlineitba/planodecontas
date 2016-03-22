<?
 
set_time_limit(0);
global $REG_BLC;

 
 
 /*
  bloco 9 o pva-fcont gera

verificar motozum sobre cta_natureza
Código
Descrição
01
Contas de ativo
02
Passivo circulante e passivo não circulante
03
Patrimônio líquido
04
Contas de resultado
05
Contas de compensação
09
Outras
 
*/
 	

$tbalanco_fcont='balanco_'.$info_cnpj;
$tbalanco_fcont_aencerramento='balanco_aencerramento_'.$info_cnpj;

$tlandiario_fcont='landiario_'.$info_cnpj;

$tbalanco_fcont_rfb='balanco_fcont_rfb_'.$info_cnpj;
$tbalanco_fcont_rfb_aencerramento='balanco_fcont_rfb_aencerramento_'.$info_cnpj;


$cod_finalidade=$_POST['cod_finalidade'];
        $ind_sit_esp=$_POST['ind_sit_esp'];

$ind_sit_esp='';
        $ind_sit_ini_per=$_POST['ind_sit_ini_per'];
        $form_apur=$_POST['form_apur'];
$cod_ent_ref=$_POST['cod_ent_ref'];


 
// ECHO "PROCESSANDO: $lanperiodo1 A $lanperiodo2 <BR>";

include('periodo.php');


$perdtos1=_myfunc_dtos_0hs($lanperiodo1);
$perdtos2=_myfunc_dtos($lanperiodo2);

 

$lanperiodo1=_myfunc_dtos_0hs($lanperiodo1);
$lanperiodo2=_myfunc_dtos($lanperiodo2); 

 
 

$dono_encerramento=_myfunc_chave_lote_encerramento($lanperiodo2);
IF ($dono_encerramento<>'') {
	// echo "<BR>CHAVE DE ENCERRAMENTO: $dono_encerramento";
                                $TLANCAMENTOS_ENCERRA='lancamentos_encerra';

			 	$sql="drop table IF EXISTS $TLANCAMENTOS_ENCERRA";  // apaga anterior
          			if ( mysql_query($sql) or die (mysql_error()) ) {
          			}
				$sql_copia_lancamentos_encerra="create table $TLANCAMENTOS_ENCERRA as select * from lancamentos";

                                IF (mysql_query("$sql_copia_lancamentos_encerra",$CONTLANCAMENTOS)) {
					// echo "lote copiado lancamentos encerra <br>";
}else{
echo "error";
				}
                                

                                $sql_cancela="DELETE FROM $TLANCAMENTOS_ENCERRA WHERE donoanterior = '$dono_encerramento'";

                                IF (mysql_query("$sql_cancela",$CONTLANCAMENTOS)) {
                                   //echo 'Lote '.$donoanterior.' foi cancelado com sucesso!';
				   $TLANCAMENTOS=$TLANCAMENTOS_ENCERRA;
				}


}ELSE{
	//echo "<BR><FONT COLOR=RED>NÃO ENCONTRADO CHAVE DE ENCERRAMENTO ";
}
echo "<br>";
 
   
      include('bala_calc.php');
 
       $sql="drop table IF EXISTS $tbalanco_fcont_aencerramento";  // apaga anterior
          if ( mysql_query($sql) or die (mysql_error()) ) {
       }
 
 
	$xsql_tmp="Select * from $tbalanco_fcont"; 

	$sql_tab_tmp="create  table $tbalanco_fcont_aencerramento as $xsql_tmp";
					  
						 if ( mysql_query($sql_tab_tmp) or die (mysql_error()) ) {
  						 }
  
				   $TLANCAMENTOS='lancamentos';

 
      include('bala_calc.php');
  
  
 // gerar $tbalanco_fcont_rfb final - depois do encerramento
		
 


      $sql="drop table IF EXISTS $tbalanco_fcont_rfb";  // apaga anterior
  	if ( mysql_query($sql) or die (mysql_error()) ) {
  	}


  	$sql="CREATE  TABLE  $tbalanco_fcont_rfb (conta varchar(30),descricao varchar(30),saldo_ante decimal(12,2) ,debito decimal(12,2) ,credito decimal(12,2),conta_ecd varchar(30))";
	  if ( mysql_query($sql) or die (mysql_error()) ) {
	  }

		$sql_rfb= mysql_query("SELECT * FROM $tbalanco_fcont order by conta" );
		while ($v=mysql_fetch_assoc($sql_rfb)) {
			$conta=$v[conta];
			$ind_cta=_myfunc_sped_ind_cta_plano_contas($conta);
			if ($ind_cta=='A') {

				$descricao=$v[descricao];
		                $saldo_ante=$v[saldo_ante];
		                $debito=$v[debito];
		                $credito=$v[credito];
	 			$dados_planoct=_myfun_dados_planoct($conta);
				$cod_cta_ref=$dados_planoct[conta_ecd];
				$conta_ecd=$cod_cta_ref;
				$sql_ins_rfb = "INSERT INTO $tbalanco_fcont_rfb (conta,descricao,saldo_ante,debito,credito,conta_ecd)
								 	     VALUES ('$conta','$descricao','$saldo_ante','$debito','$credito','$conta_ecd')";
						    
								// Cadastro Realizado
								if ( mysql_query($sql_ins_rfb,$CONTPLANOCT) ) {
								}


                        }
			
		}


 // gerar $tbalanco_fcont_rfb antes do encerramento
		
  

      $sql="drop table IF EXISTS $tbalanco_fcont_rfb_aencerramento";  // apaga anterior
 
  	if ( mysql_query($sql) or die (mysql_error()) ) {
  	}

 
  	$sql="CREATE  TABLE  $tbalanco_fcont_rfb_aencerramento (conta varchar(30),descricao varchar(30),saldo_ante decimal(12,2) ,debito decimal(12,2) ,credito decimal(12,2),conta_ecd varchar(30))";
	  if ( mysql_query($sql) or die (mysql_error()) ) {
	  }

		$sql_rfb= mysql_query("SELECT * FROM $tbalanco_fcont_aencerramento order by conta" );
		while ($v=mysql_fetch_assoc($sql_rfb)) {
			$conta=$v[conta];
			$ind_cta=_myfunc_sped_ind_cta_plano_contas($conta);
			if ($ind_cta=='A') {

				$descricao=$v[descricao]; 
		                $saldo_ante=$v[saldo_ante];
		                $debito=$v[debito];
		                $credito=$v[credito];
	 			$dados_planoct=_myfun_dados_planoct($conta);
				$cod_cta_ref=$dados_planoct[conta_ecd];
				$conta_ecd=$cod_cta_ref;
				$sql_ins_rfb = "INSERT INTO $tbalanco_fcont_rfb_aencerramento (conta,descricao,saldo_ante,debito,credito,conta_ecd)
								 	     VALUES ('$conta','$descricao','$saldo_ante','$debito','$credito','$conta_ecd')";
						    
								// Cadastro Realizado
								if ( mysql_query($sql_ins_rfb,$CONTPLANOCT) ) {
								}


                        }
			
		}
 


// ************************************************************************************

//REGISTRO 0000: ABERTURA DO ARQUIVO DIGITAL E IDENTIFICAÇÃO DA PESSOA JURÍDI echo "xxx1";CA
fcont_registro_0000();

//REGISTRO I001: ABERTURA BOLOCO I
fcont_registro_I001();

//REGISTRO I050: PLANO DE CONTAS
fcont_registro_I050();

//REGISTRO I051: PLANO DE CONTAS REFERENCIAL
//fcont_registro_I051();  // nivel 3, esta em I050

//REGISTRO I075: TABELA DE HISTÓRICO PADRONIZADO
fcont_registro_I075();

//REGISTRO I100:CENTRO DE CUSTOS
//fcont_registro_I100();

//REGISTRO I150: SALDOS PERIÓDICOS - IDENTIFICAÇÃO DO PERIÓDO
fcont_registro_I150();

//REGISTRO I155: DETALHE DOS SALDOS PERIÓDICOS
fcont_registro_I155();

//REGISTRO I156: MAPEAMENTO REFERENCIAL DOS TOTAIS DE DÉBITOS E CRÉDITOS
//fcont_registro_I156(); // nivel 3 

//REGISTRO I200: LANÇAMENTOS
//fcont_registro_I200();

//REGISTRO I250: PARTIDAS DO LANÇAMENTO
//fcont_registro_I250(); nivel 3

//REGISTRO I256: MAPEAMENTO REFERENCIAL DAS PARTIDAS DO LANÇAMENTO
//fcont_registro_I256(); nivel 4

//REGISTRO I350: SALDOS DAS CONTAS DE RESULTADO ANTES DO ENCERRAMENTO  - IDENTIFICAÇÃO DA DATA
fcont_registro_I350();

//REGISTRO I355: DETALHES DOS SALDOS DAS CONTAS DE RESULTADO ANTES DO ENCERRAMENTO
fcont_registro_I355();

//REGISTRO I356: MAPEAMENTO REFERENCIAL DOS SALDOS FINAIS DAS CONTAS DE RESULTAOD ANTES DO ENCERRAMENTO
//fcont_registro_I356();

//REGISTRO I990: ENCERRAMENTO DO BLOCO I
fcont_registro_I990();


//REGISTRO J001: ABERTURA DO BLOCO J
fcont_registro_J001();

//REGISTRO J930: IDENTIFICAÇÕA DOS SIGNATÁRIOS DA ESCRITURAÇÃO
fcont_registro_J930();

//REGISTRO J990: ENCERRAMENTO DO BLOCO J
fcont_registro_J990();

//REGSITRO M001: ABERTURA DO BLOCO M
fcont_registro_M001();

//REGISTRO M020: QUALIFICAÇÃO DA PESSOA JURÍDICA E RETIFICAÇÃO
fcont_registro_M020();

//REGISTRO M025: SALDOS INICIAIS DAS CONTAS PATRIMONIAIS RECUPERADOS/PREENCHIDOS
//fcont_registro_M025();

//REGISTRO M030: IDENTIFICAÇÃO DO PERÍODO DE APURAÇÃO
fcont_registro_M030();

//REGISTRO M155: DETALHHE DOS SALDOS PERIÓDICOS FCONT
//fcont_registro_M155();

//REGISTRO M355: DETALHES DOS SALDOS REFERENCIAIS DAS CONTAS DE RESULTADO ANTES DO ENCERRAMENTO
//fcont_registro_M355();

//REGISTRO M990: ENCERRAMENTO DO BLOCO M
fcont_registro_M990();
 
 
 

return;
 


//REGISTRO 0000: ABERTURA DO ARQUIVO DIGITAL E IDENTIFICAÇÃO DO EMPRESÁRIO OU DA SOCIEDADE EMPRESÁRIA
function fcont_registro_0000() {
	global $cod_finalidade, $ind_sit_esp,$ind_sit_ini_per, $forma_apur,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$perdtos1,$perdtos2,$info_cnpj_segmento,$chave_encerra,$tot_0000,$REG_BLC;


        $id_arq='LALU';  
        $dt_ini=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo1));
        $dt_fin=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo2));
        $nome=$info_segmento['razaosocial']; //max 255
	$cnpj=$info_segmento['cnpjcpf'];
        $cnpj=_myfunc_zero_a_esquerda($cnpj,14) ;
        $uf=$info_segmento['uf'];
        $ie=$info_segmento['ie']; // max 255
        $cod_mun=$info_segmento['cod_mun'];
        $im=$info_segmento['im'];  // max 255
        $linha='|'.'0000'.'|'.$id_arq.'|'.$dt_ini.'|'.$dt_fin.'|'.$nome.'|'.$cnpj.'|'.$uf.'|'.$ie.'|'.$cod_mun.'|'.$im.'|'.$ind_sit_esp.'|'.$ind_sit_ini_per.'|';
        $escreve = fwrite($fp, "$linha\r\n");
        $tot_registro_bloco=$tot_registro_bloco+1;
        $tot_0000=$tot_registro_bloco;
        $REG_BLC[]='|'.'0000'.'|'.$tot_registro_bloco.'|';
        return;
}

//REGISTRO I001: ABERTURA BLOCO I
function fcont_registro_I001(){
	global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$perdtos1,$perdtos2,$info_cnpj_segmento,$tot_I001,$REG_BLC;

        $ind_dad='0';//0-Bloco com dados informados, 1-Bloco sem dados informados
        $linha='|'.'I001'.'|'.$ind_dad.'|';
        $escreve = fwrite($fp, "$linha\r\n");
        $tot_registro_bloco=$tot_registro_bloco+1;
        $tot_I001=$tot_registro_bloco;
        $REG_BLC[]='|'.'I001'.'|'.$tot_registro_bloco.'|';
        return;
}

//REGISTRO I050: PLANO DE CONTAS
	function fcont_registro_I050(){
		global $tbalanco_fcont,$info_segmento,$fp,$tot_I050,$REG_BLC,$tot_registro_bloco_I051;
	 

       		$sql_lancamentos= mysql_query("SELECT * FROM $tbalanco_fcont where (abs(saldo_ante)+abs(debito)+abs(credito)>0)order by conta" );

 
		    while ($v=mysql_fetch_assoc($sql_lancamentos)) {

  			 	$cod_cta=$v['conta'];
			        $dados_planoct=_myfun_dados_planoct($cod_cta);
	
				//$dt_alt=$dados_planoct[datacad];  // ou $dt_alt=$perdtos1;
        			//$dt_alt=_myfunc_ddmmaaaa(_myfunc_stod($dt_alt));
	 			$dt_alt='01012009';
				$ind_cta=_myfunc_sped_ind_cta_plano_contas($cod_cta);
                                $nivel=_myfunc_sped_nivel_cta_plano_contas($cod_cta);
			 	$cod_nat=_myfunc_sped_cod_nat_plano_contas($v['conta']);
 				$cta=$v['descricao'];
				$cod_cta=_apenas_numeros($v['conta']);
				$cod_cta_sup=_myfunc_sped_cta_superior_plano_contas($v[conta]);
				$conta=$v['conta'] ;

				$linha='|'.'I050'.'|'.$dt_alt.'|'.$cod_nat.'|'.$ind_cta.'|'.$nivel.'|'.$cod_cta.'|'.$cod_cta_sup.'|'.$cta.'|';
	 
				$escreve = fwrite($fp,"$linha\r\n");

				$tot_registro_bloco=$tot_registro_bloco+1;
				$tot_I050=$tot_registro_bloco;
	 
				if ($ind_cta=='A') {
	 
					$Y=fcont_registro_I051($v['conta']);
		                }

		    }

			$REG_BLC[]='|'.'I050'.'|'.$tot_registro_bloco.'|';
			$REG_BLC[]='|'.'I051'.'|'.$tot_registro_bloco_I051.'|';


			  return;
}

//REGISTRO I051: PLANO DE CONTAS REFERENCIAL
function fcont_registro_I051($cod_cta){
global $cod_ent_ref,$info_segmento,$fp,$REG_BLC,$tot_registro_bloco_I051;
 
 	$dados_planoct=_myfun_dados_planoct($cod_cta);
	$cod_cta_ref=$dados_planoct[conta_ecd];
	//$cod_cta_ref=_apenas_numeros($cod_cta_ref);
	IF ($cod_cta_ref=='') {
		ECHO "Não foi definida conta para Referencial de/para  $cod_cta <br>";
        }else{
	
		$cod_ccus='';
		$linha='|'.'I051'.'|'.$cod_ent_ref.'|'.$cod_ccus.'|'.$cod_cta_ref.'|';
		$escreve = fwrite($fp, "$linha\r\n");
		$tot_registro_bloco_I051=$tot_registro_bloco_I051+1;
		$tot_I051=$tot_registro_bloco_I051;
        }
       return;


}

//REGISTRO I075: TABELA DE HISTÓRICO PADRONIZADO
function fcont_registro_I075(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$perdtos1,$perdtos2,$info_cnpj_segmento,$THISTORICOS,$tot_I075,$REG_BLC;

       $sql_lancamentos= mysql_query("SELECT * FROM $THISTORICOS");

    while ($v=mysql_fetch_assoc($sql_lancamentos)) {

        $cod_hist=$v['id'];
        $cod_hist=_myfunc_zero_a_esquerda($cod_hist,$tamanho4) ;

        $descr_hist=$v['historico'];

        $linha='|'.'I075'.'|'.$cod_hist.'|'.$descr_hist.'|';
        $escreve = fwrite($fp, "$linha\r\n");

        $tot_registro_bloco=$tot_registro_bloco+1;
        $tot_I075=$tot_registro_bloco;
    }
          $REG_BLC[]='|'.'I075'.'|'.$tot_registro_bloco.'|';
          return;
}

//REGISTRO I100:CENTRO DE CUSTOS
function fcont_registro_I100(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$perdtos1,$perdtos2,$info_cnpj_segmento,$TCENTROCUSTO,$tot_I100,$REG_BLC;

       $sql_lancamentos= mysql_query("SELECT * FROM $TCENTROCUSTO");

    while ($v=mysql_fetch_assoc($sql_lancamentos)) {

        $dt_alt=$v['dataatu'];
        $dt_alt=_myfunc_stod($dt_alt);
        $dt_alt=_apenas_numeros($dt_alt);

        $cod_ccus=$v['conta'];
        
        $ccus=$v['descricao'];
        
        $linha='|'.'I100'.'|'.$dt_alt.'|'.$cod_ccus.'|'.$ccus.'|';
        $escreve = fwrite($fp, "$linha\r\n");

        $tot_registro_bloco=$tot_registro_bloco+1;
        $tot_I100=$tot_registro_bloco;
    }
          $REG_BLC[]='|'.'I100'.'|'.$tot_registro_bloco.'|';
          return;
}

//REGISTRO I150: SALDOS PERIÓDICOS - IDENTIFICAÇÃO DO PERIÓDO
function fcont_registro_I150(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$tot_I150,$REG_BLC;

        
        $dt_ini=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo1));
        $dt_fin=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo2));

        $linha='|'.'I150'.'|'.$dt_ini.'|'.$dt_fin.'|';
        $escreve = fwrite($fp, "$linha\r\n");

        $tot_registro_bloco=$tot_registro_bloco+1;
        $tot_I150=$tot_registro_bloco;

        $REG_BLC[]='|'.'I150'.'|'.$tot_registro_bloco.'|';
        return;
}


//REGISTRO I155: DETALHE DOS SALDOS PERIÓDICOS
function fcont_registro_I155(){
	global $tbalanco_fcont,$info_segmento,$fp,$info_cnpj_segmento,$tot_I155,$REG_BLC,$tbalanco_fcont,$tot_registro_bloco_I155,$tot_registro_bloco_I156;

      

       $graumaximo=strlen(_myfun_mascara_x($info_cnpj_segmento));
       $sel_balanco=mysql_query("SELECT * FROM $tbalanco_fcont where length(conta)='$graumaximo' and (abs(saldo_ante)+abs(debito)+abs(credito)>0)");

$deb=0;
$cre=0;


       while ($v=mysql_fetch_assoc($sel_balanco) ) {

        $cod_cta=$v['conta'];
        $cod_cta=_apenas_numeros($cod_cta);
        $cod_cus='';
        $cod_nat=_myfunc_sped_cod_nat_plano_contas($v['conta']);
        $vl_sld_ini=abs($v['saldo_ante']);
        $vl_sld_ini=number_format(abs($vl_sld_ini), 2, ",", "");
 	if ($v['saldo_ante']>0){  
               $ind_dc_ini='D';  
           }else{
               $ind_dc_ini='C';  
        }

        $vl_deb=$v['debito'];

        $vl_cred=$v['credito'];

        $vl_sld_fin=$v['saldo_ante']+$v['debito']-$v['credito'];
 	if ($vl_sld_fin>0){  
               $ind_dc_fin='D';  
           }else{
               $ind_dc_fin='C';  
        }

        $vl_sld_fin=number_format(abs($vl_sld_fin), 2, ",", "");
        $vl_deb=number_format(abs($vl_deb), 2, ",", "");
        $vl_cred=number_format(abs($vl_cred), 2, ",", "");

 
 
  
        
         if ($cod_nat=='01' OR $cod_nat=='02'  or $cod_nat=='03'){  //  // ativo // passivo // patrimonio liquido
// if ($cod_nat=='01' OR $cod_nat=='02' ){  //  // ativo // passivo // patrimonio liquido
           $linha='|'.'I155'.'|'.$cod_cta.'|'.$cod_ccus.'|'.$vl_sld_ini.'|'.$ind_dc_ini.'|'.$vl_deb.'|'.$vl_cred.'|'.$vl_sld_fin.'|'.$ind_dc_fin.'|' ;
//ECHO $linha." <BR>";
           $escreve = fwrite($fp, "$linha\r\n");

           $tot_registro_bloco_I155=$tot_registro_bloco_I155+1;
           $tot_I155=$tot_registro_bloco;

	fcont_registro_I156($v['conta']);
   /*     
          // fcont_registro_I156($v['conta']);
 
foi ignorada por
Observações:
- Os valores deverão ser adaptados para permitir sua correta identificação com base no plano de contas referencial informado nos registros I051.
- Caso a conta contábil/centro de custo estejam mapeados apenas para uma conta referencial no registro I051, este registro não é obrigatório. Portanto, só haverá obrigatoriedade do registro I156 quanto houver o mapeamento de uma conta contábil/centro de custos para mais de uma conta referencial (1 para N).
*/
        }
      }
        $REG_BLC[]='|'.'I155'.'|'.$tot_registro_bloco_I155.'|';
        $REG_BLC[]='|'.'I156'.'|'.$tot_registro_bloco_I156.'|';


$dif=$deb-$cre;
// echo $deb. "  ".$cre. "   ".$dif;

        return;
}

 

//REGISTRO I156: MAPEAMENTO REFERENCIAL DOS TOTAIS DE DÉBITOS E CRÉDITOS
function fcont_registro_I156($conta){
	global $tbalanco_fcont_rfb,$fp,$REG_BLC,$tot_registro_bloco_I156;


       $sel_balanco=mysql_query("SELECT * from $tbalanco_fcont_rfb where conta='$conta'");

       while ($v=mysql_fetch_assoc($sel_balanco)) {

         $cod_cta_ref=$v[conta_ecd];
	//$cod_cta_ref=_apenas_numeros($cod_cta_ref);
	 $vd=abs($v['debito']);
         $vl_deb=number_format($vd, 2, ',', '');
	 $vc=abs($v['credito']);
         $vl_cred=number_format($vc, 2, ',', '');

         $linha='|'.'I156'.'|'.$cod_cta_ref.'|'.$vl_deb.'|'.$vl_cred.'|';
         $escreve = fwrite($fp, "$linha\r\n");

         $tot_registro_bloco_I156=$tot_registro_bloco_I156+1;
         $tot_I156=$tot_registro_bloco_I156;
         
       }
        return;
}

/*

5.6 Lançamentos (I200 e I250)
São dois tipos de lançamentos:

N => lançamentos normais. Lançamentos que existem na escrituração societária e que devem, no FCont, ser expurgados; e,

F => lançamentos fiscais. Lançamentos que não existem na escrituração societária e que devem, no FCont, ser incluídos.

Os lançamentos tipo N devem ser informados exatamente como constam da escrituração comercial (ou seja, devem ser mantidos os indicadores de débito e crédito da escrituração comercial). O PVA do Fcont fará a inversão dos indicadores no momento do cálculo do ajuste a ser transposto para o Lalur.

Não devem ser utilizados lançamentos F para expurgar (estornar) os lançamentos presentes na escrituração societária e que devam ser desconsiderados para fins do RTT.

Os lançamentos do tipo “E” (encerramento) da ECD não devem ser importados.

Quando apenas parte das partidas de um lançamento contábil deva ser expurgada, adotar um dos seguintes procedimentos:

a) informar o lançamento completo como N e, como F, retornar a parte que não deve ser expurgada; ou,

b) informar apenas as partidas que devam ser expurgadas, alterando o valor, também, do registro I200.

5.7 Bloco M

Registros destinados a informar os parâmetros da escrituração do livro. Devem ser informados antes da digitação do plano de contas referencial.

*/
//REGISTRO I200: LANÇAMENTOS
function fcont_registro_I200(){
global $info_segmento,$fp,$tot_I200,$REG_BLC,$tlandiario_fcont,$CONTPLANOCT,$tot_registro_bloco_I250,$tot_registro_bloco_I256;

	$sql="SELECT sum(valorc) as xvalorc, sum(valord) as xvalord ,id,data FROM $tlandiario_fcont group by data ";
        $sel_landiario = mysql_query($sql,$CONTPLANOCT) ;
        while ($v=mysql_fetch_assoc($sel_landiario) ) {
         
        	$num_lcto=$v[id];
		$data=$v['data'];
       	        $dt_lcto=_myfunc_ddmmaaaa(_myfunc_stod($data));
      
        	$valorc=$v[xvalorc];
        	$valord=$v[xvalord];
        	$vl=$valord;
        	$vl_0=abs($vl);
        	$vl_lcto=number_format($vl_0, 2, ',', '');
        	$ind_lcto='X';
        	$linha='|I200|'.$num_lcto.'|'.$dt_lcto.'|'.$vl_lcto.'|'.$ind_lcto.'|';
        
		//X - Informar somente os lançamentos da escrituração comercial que devem ser desconsiderados para apuração do resultado
		//F - Informar somente os lançamentos contábeis não efetuados na escrituração comercial que devem ser considerados para apuração do resultado
		//TR - Lançamento de tranferência da diferença entre saldos fiscais e societários no caso de implantação de um novo plano de contas.
		//TF - Transferência de saldo fiscal para uma conta referencial devido à extinção de conta rederencial de origem
		//TS - Transferência de saldo societário para uma conta referêncial devido à extinção da conta referencial de origem
		//EF - Lançamento de encerramento fiscal para ajuste do saldo fiscal sobre o saldo societário
		//IF - Lamçamento para alteração do saldo inicial fiscal, quando a forma de tributação do período anterior não for por Lucro Real
		//IS - Lançamento para alteração do saldo inicial societário,quando a forma de tributação do periodo anterior não for Lucro Real
        

 		$escreve = fwrite($fp, "$linha\r\n");

        	$tot_registro_bloco=$tot_registro_bloco+1;
        	$tot_I200=$tot_registro_bloco;
        
        	fcont_registro_I250($v[data]);

       }
        $REG_BLC[]='|'.'I200'.'|'.$tot_registro_bloco.'|';
        $REG_BLC[]='|'.'I250'.'|'.$tot_registro_bloco_I250.'|';
        $REG_BLC[]='|'.'I256'.'|'.$tot_registro_bloco_I256.'|';
        

        return;
}


//REGISTRO I250: PARTIDAS DO LANÇAMENTO
function fcont_registro_I250($datadia){
        global $tlandiario_fcont,$fp,$CONTPLANOCT,$qtd_lin_i,$REG_BLC,$tot_registro_250,$tot_registro_bloco_I256,$info_cnpj;//,$qtd_lin;
        
	$datadiax=_myfunc_stod($datadia);
 
	$sql="SELECT * FROM $tlandiario_fcont where FROM_UNIXTIME(data,'%d/%m/%Y')='$datadiax' order by conta" ;

 
        $sel_landiario = mysql_query($sql,$CONTPLANOCT) ;
        while ($v=mysql_fetch_assoc($sel_landiario) ) {
        	$reg='I250';
        	$cod_cta=_apenas_numeros($v[conta]);
        	$cod_ccus='';
        	$valorc=$v[valorc];
        	$valord=$v[valord];
        
        
		if ($valorc>0) {
		    $ind_dc='C';
		    $valor=$valorc;
		    $vl_dc=number_format($valor, 2, ',', '');
		    $num_arq=$v[id];
		    $cod_hist_pad='';
		    $hist=_myfunc_removeacentos(trim($v[historico]).trim($v[obs]).'.');
		    $hist=_myfunc_removeacentos_extras($hist);
		    $cod_part='';
		    $linha='|I250|'.$cod_cta.'|'.$cod_ccus.'|'.$vl_dc.'|'.$ind_dc.'|'.$num_arq.'|'.$cod_hist_pad.'|'.$hist.'|'.$cod_part.'|';
 
		    $escreve = fwrite($fp,"$linha\r\n");
		    $tot_registro_250=$tot_registro_250+1;
		}

		if ($valord>0) {
		    $ind_dc='D';
		    $valor=$valord;
		    $vl_dc=number_format($valor, 2, ',', '');
		    $num_arq=$v[id];
		    $cod_hist_pad='';
		    $hist=_myfunc_removeacentos(trim($v[historico]).trim($v[obs]).'.');
		    $hist=_myfunc_removeacentos_extras($hist);
		    //$cod_part=$v[cnpjcpf];
		    $cod_part='';
		    $linha='|I250|'.$cod_cta.'|'.$cod_ccus.'|'.$vl_dc.'|'.$ind_dc.'|'.$num_arq.'|'.$cod_hist_pad.'|'.$hist.'|'.$cod_part.'|';
 
		    $escreve = fwrite($fp,"$linha\r\n");
		    $tot_registro_250=$tot_registro_250+1;
		}


 fcont_registro_I256($conta);
        }
        return ;
}

//REGISTRO I256: MAPEAMENTO REFERENCIAL DAS PARTIDAS DO LANÇAMENTO
function fcont_registro_I256($conta){
global $fp,$info_cnpj_segmento,$tot_I256,$REG_BLC,$tot_registro_bloco_I255,$tot_registro_bloco_I256,$tbalanco_fcont_rfb;

       $graumaximo=strlen(_myfun_mascara_x($info_cnpj_segmento));
       $sel_balanco=mysql_query("SELECT * FROM $tbalanco_fcont_rfb where length(conta)='$graumaximo' AND (abs(saldo_ante)+debito+credito>0) and conta='$conta'");

       while ($v=mysql_fetch_assoc($sel_balanco)) {

	       $cod_cta_ref=$v['conta_ecd'];
	       $cod_cta_ref=_apenas_numeros($cod_cta_ref);
	       
	       $vl_dc=$v['saldo_ante'];
	       $vl_dc=number_format($vl_dc, 2, ',', '');

	       if (strlen($vl_dc<'0,00')){
		     $ind_dc='D';
		}
		else
		{
		     $ind_dc='C';
		}

 
       

       
       $linha='|'.'I256'.'|'.$cod_cta_ref.'|'.$vl_dc.'|'.$ind_dc.'|';
       $escreve = fwrite($fp, "$linha\r\n");

       $tot_registro_bloco_I256=$tot_registro_bloco_I256+1;
       $tot_I256=$tot_registro_bloco_I256;
       }

}

//REGISTRO I350: SALDOS DAS CONTAS DE RESULTADO ANTES DO ENCERRAMENTO   
function fcont_registro_I350(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$tot_I350,$REG_BLC;

       $dt_res=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo2));
       $linha='|'.'I350'.'|'.$dt_res.'|';
       $escreve = fwrite($fp, "$linha\r\n");

       $tot_registro_bloco=$tot_registro_bloco+1;
       $tot_I350=$tot_registro_bloco;
       
       $REG_BLC[]='|'.'I350'.'|'.$tot_registro_bloco.'|';

}

//REGISTRO I355: DETALHES DOS SALDOS DAS CONTAS DE RESULTADO ANTES DO ENCERRAMENTO
 function fcont_registro_I355(){
	global $infotitulo,$tbalanco_fcont_aencerramento,$info_segmento,$fp,$info_cnpj_segmento,$tot_I355,$REG_BLC,$tbalanco_fcont,$tot_registro_bloco_I355,$tot_registro_bloco_I356;

       $contas_encerramento=trim($infotitulo[contas_encerramento]);

       $graumaximo=strlen(_myfun_mascara_x($info_cnpj_segmento));
       $sel_balanco=mysql_query("SELECT * FROM $tbalanco_fcont_aencerramento where length(conta)='$graumaximo' and (abs(saldo_ante)+abs(debito)+abs(credito)>0)");

       while ($v=mysql_fetch_assoc($sel_balanco) ) {

             $contaprocurar=':'.trim($v[conta]);
 
             if (eregi($contaprocurar, $contas_encerramento)) {   // apenas as de encerramento
        	$cod_cta=$v['conta'];
 
        	$cod_cta=_apenas_numeros($cod_cta);
			$cod_cus='';
			$cod_nat=_myfunc_sped_cod_nat_plano_contas($v['conta']);
			 

			$vl_sld_fin=$v['saldo_ante']+$v['debito']-$v['credito'];
		 	if ($vl_sld_fin>0){  
			       $ind_dc_fin='D';  
			   }else{
			       $ind_dc_fin='C';  
			}

			$vl_sld_fin=number_format(abs($vl_sld_fin), 2, ",", "");
		 
		 
		
			
			   $linha='|'.'I355'.'|'.$cod_cta.'|'.$cod_ccus.'|'.$vl_sld_fin.'|'.$ind_dc_fin.'|' ;
			   $escreve = fwrite($fp, "$linha\r\n");
 
			   $tot_registro_bloco_I355=$tot_registro_bloco_I355+1;
			   $tot_I355=$tot_registro_bloco_I355;
				fcont_registro_I356($v['conta']);
		     
			//   fcont_registro_I356($v['conta']);
				 /*
				foi ignorada por
				Observações:
				- Os valores deverão ser adaptados para permitir sua correta identificação com base no plano de contas referencial informado nos registros I051.
				- Caso a conta contábil/centro de custo estejam mapeados apenas para uma conta referencial no registro I051, este registro não é obrigatório. Portanto, só haverá obrigatoriedade do registro I156 quanto houver o mapeamento de uma conta contábil/centro de custos para mais de uma conta referencial (1 para N).
				*/
			
		      }
                 }
        $REG_BLC[]='|'.'I355'.'|'.$tot_registro_bloco_I355.'|';
        $REG_BLC[]='|'.'I356'.'|'.$tot_registro_bloco_I356.'|';
        return;
}




//REGISTRO I356: MAPEAMENTO REFERENCIAL DOS SALDOS FINAIS DAS CONTAS DE RESULTAOD ANTES DO ENCERRAMENTO

function fcont_registro_I356($conta){
global $infotitulo,$fp,$info_cnpj_segmento,$tot_I356,$REG_BLC,$tot_registro_bloco_I355,$tot_registro_bloco_I356,$tbalanco_fcont_rfb_aencerramento;
       $contas_encerramento=trim($infotitulo[contas_encerramento]);
       $graumaximo=strlen(_myfun_mascara_x($info_cnpj_segmento));

       $sel_balanco=mysql_query("SELECT * FROM $tbalanco_fcont_rfb_aencerramento where conta='$conta'");

       while ($v=mysql_fetch_assoc($sel_balanco)) {
	      $contaprocurar=':'.trim($conta);
             if (eregi($contaprocurar,$contas_encerramento)) {   // apenas as de encerramento
        	
		       $cod_cta_ref=$v['conta_ecd'];
		      
		       
		       $vl_sld_fin=$v['saldo_ante']+$v['debito']-$v['credito'];
		 	if ($vl_sld_fin>0){  
			       $ind_dc_fin='D';  
			   }else{
			       $ind_dc_fin='C';  
			}

			$vl_cta=number_format(abs($vl_sld_fin), 2, ",", "");
		 

	 
	       

		       
		       $linha='|'.'I356'.'|'.$cod_cta_ref.'|'.$vl_cta.'|'.$ind_dc_fin.'|';
 
		       $escreve = fwrite($fp, "$linha\r\n");

		       $tot_registro_bloco_I356=$tot_registro_bloco_I356+1;
		       $tot_I356=$tot_registro_bloco_I356;
            }
       }

}
 
//REGISTRO I990: ENCERRAMENTO DO BLOCO I
function fcont_registro_I990(){
global $info_segmento,$fp,$info_cnpj_segmento,$tot_I990,$tot_I001,$tot_I050,$tot_registro_bloco_I051,$tot_I075,$tot_I100,$tot_I150,$tot_I151,$tot_I155,$tot_registro_bloco_I156,$tot_I200,$tot_registro_bloco_I250,$tot_registro_bloco_I256,$tot_I350,$tot_I355,$tot_registro_bloco_I356,$REG_BLC,$total_I990;

      $tot_registro_bloco=$tot_registro_bloco+1;
      $tot_I990=$tot_registro_bloco;
      
      $total_I990=$tot_I001+$tot_I050+$tot_registro_bloco_I051+$tot_I075+$tot_I100+$tot_I150+$tot_I155+$tot_registro_bloco_I156+$tot_I200+$tot_registro_bloco_I250+$tot_registro_bloco_I256+$tot_I350+$tot_I355+$tot_registro_bloco_I356+$tot_I990;

     
      $linha='|'.'I990'.'|'.$total_I990.'|';
      $escreve = fwrite($fp,"$linha\r\n");

      $REG_BLC[]='|'.'I990'.'|'.$tot_registro_bloco.'|';
      return;

}

//REGISTRO J001: ABERTURA DO BLOCO J
function fcont_registro_J001(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$perdtos1,$perdtos2,$info_cnpj_segmento,$tot_J001,$REG_BLC;

        $ind_dad='0';

        $linha='|'.'J001'.'|'.$ind_dad.'|';
        $escreve = fwrite($fp, "$linha\r\n");

        $tot_registro_bloco=$tot_registro_bloco+1;
        $tot_J001=$tot_registro_bloco;

        $REG_BLC[]='|'.'J001'.'|'.$tot_registro_bloco.'|';
        return;
}

//REGISTRO J930: IDENTIFICAÇÕA DOS SIGNATÁRIOS DA ESCRITURAÇÃO
function fcont_registro_J930(){
global $infotitulo,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$perdtos1,$perdtos2,$info_cnpj_segmento,$TCONTABILISTA,$TCNPJCPF,$TSEGMENTOS,$tot_J930,$REG_BLC;


   $m_matriz_signatarios = MATRIZ::m_matriz_signatarios();
   $dados_contabilista=_myfun_dados_contabilista();
   $ident_nom=$dados_contabilista[nome];
   $ident_cpf_cnpj=$dados_contabilista[cpf];
   $dadoscnpjcpf=_myfun_dados_cnpjcpf($ident_cpf_cnpj);
	   $ident_nom=$dadoscnpjcpf[razao];

   $cod_assin='900';
   $ident_qualif=$m_matriz_signatarios[$cod_assin];
   $ind_cr=$dados_contabilista[crc];
   $linha='|'.'J930'.'|'.$ident_nom.'|'.$ident_cpf_cnpj.'|'.$ident_qualif.'|'.$cod_assin.'|'.$ind_cr.'|';
   $escreve = fwrite($fp, "$linha\r\n");
   $tot_registro_bloco=$tot_registro_bloco+1;
   $tot_J930=$tot_registro_bloco;

	if (!(empty($infotitulo[codsignatar1]))) {   // existe signatario em parametros da empresa, caso contrario pega do contador
	   $cnpjcpfsignat1=$infotitulo[cnpjcpfsignat1];
	   $dados_signatario=_myfun_dados_cnpjcpf($cnpjcpfsignat1);
	   $ident_nom=$dados_signatario[razao];
	   $ident_cpf_cnpj=$cnpjcpfsignat1;
	   $cod_assin=$infotitulo[codsignatar1];   
	   $ident_qualif=$m_matriz_signatarios[$cod_assin];

	 
	}
     
         
          $linha='|'.'J930'.'|'.$ident_nom.'|'.$ident_cpf_cnpj.'|'.$ident_qualif.'|'.$cod_assin.'|'.$ind_cr.'|';
          $escreve = fwrite($fp, "$linha\r\n");

          $tot_registro_bloco=$tot_registro_bloco+1;
          $tot_J930=$tot_registro_bloco;
 
        $REG_BLC[]='|'.'J930'.'|'.$tot_registro_bloco.'|';
        return;
}

//REGISTRO J990: ENCERRAMENTO DO BLOCO J
function fcont_registro_J990(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$perdtos1,$perdtos2,$REG_BLC,$info_cnpj_segmento,$tot_J990,$tot_J001,$tot_J930,$total_J990;

      $tot_registro_bloco=$tot_registro_bloco+1;
      $tot_J990=$tot_registro_bloco;

      $total_J990=$tot_J001+$tot_J930+$tot_J990;

      
      $linha='|'.'J990'.'|'.$total_J990.'|';
      $escreve = fwrite($fp,"$linha\r\n");

      $REG_BLC[]='|'.'J990'.'|'.$tot_registro_bloco.'|';

return;
}

//REGSITRO M001: ABERTURA DO BLOCO M
function fcont_registro_M001(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$perdtos1,$perdtos2,$REG_BLC,$info_cnpj_segmento,$tot_M001;

        $ind_dad='0';

        $linha='|'.'M001'.'|'.$ind_dad.'|';
        $escreve = fwrite($fp, "$linha\r\n");

        $tot_registro_bloco=$tot_registro_bloco+1;
        $tot_M001=$tot_registro_bloco;

        $REG_BLC[]='|'.'M001'.'|'.$tot_registro_bloco.'|';
        return;
}

//REGISTRO M020: QUALIFICAÇÃO DA PESSOA JURÍDICA E RETIFICAÇÃO
function fcont_registro_M020(){
global $cod_ent_ref,$form_apur,$cod_finalidade,$info_segmento,$fp,$REG_BLC,$info_cnpj_segmento,$tot_M020;

 

        $quali_pj=$cod_ent_ref;  // 10 
$quali_pj=10;
        $tipo_escrit=$cod_finalidade;        
        $nro_rec_anterior="";        
        $id_escr_Per_ant='';        
        $slT_sLD_PER_ANT='';
        $Ind_lcto_ini_sld='';
        $form_apur=$form_apur;        
        $Form_tribut='1'; 
        
        $TRIM_Luc_Arb=''; 
        
        $Form_trib_tri='';
 



        $linha='|M020|'.$quali_pj.'|'.$tipo_escrit.'|'.$nro_rec_anterior.'|'.$id_escr_Per_ant.'|'.$slT_sLD_PER_ANT.'|'.$Ind_lcto_ini_sld.'|'.$form_apur.'|'.$Form_tribut.'|'.$TRIM_Luc_Arb.'|'.$Form_trib_tri.'|';
        $escreve = fwrite($fp, "$linha\r\n");

        $tot_registro_bloco=$tot_registro_bloco+1;
        $tot_M020=$tot_registro_bloco;

        $REG_BLC[]='|M020|'.$tot_registro_bloco.'|' ;
        return;
}

//REGISTRO M025: SALDOS INICIAIS DAS CONTAS PATRIMONIAIS RECUPARDOS/PREENCHIDOS
function fcont_registro_M025(){
	global $info_segmento,$fp,$REG_BLC,$info_cnpj_segmento,$tot_M025,$tbalanco_fcont_aencerramento;

   

        $sel_sql=mysql_query("select * from $tbalanco_fcont_aencerramento order by conta,conta_ecd");
        
       
        while($v=mysql_fetch_assoc($sel_sql)){
        
        	$cod_cta=$v['conta'];

       		if (strlen(_myfun_mascara_x($info_cnpj_segmento))==strlen($cod_cta)){

        		$cod_cta=_apenas_numeros($cod_cta);
        		$cod_ccus='';

        		$cod_cta_ref=$v['conta_ecd'];
        		$cod_cta_ref=_apenas_numeros($cod_cta_ref);
        
		        $vl_sld_fin_fc=$v['saldo_ante'];
        
			if($v['saldo_ante']>0){
			   $ind_dc_fin_fc='D';
			} else {
			   $ind_dc_fin_fc='C';
			}
        
         		$vl_sld_fin_fc=number_format(abs($vl_sld_fin_fc), 2, ',', '');


	        $vl_sld_fin_soc=$v['saldo_ante'];
		if(vl_sld_fin_soc>0){
			   $ind_dc_fin_soc='D';
			} else {
			   $ind_dc_fin_soc='C';
			}
		$vl_sld_fin_soc=number_format(abs($vl_sld_fin_soc), 2, ',', '');

        $linha='|'.'M025'.'|'.$cod_cta.'|'.$cod_ccus.'|'.$cod_cta_ref.'|'.$vl_sld_fin_fc.'|'.$ind_dc_fin_fc.'|'.$vl_sld_fin_soc.'|'.$ind_dc_fin_soc.'|';
        $escreve = fwrite($fp, "$linha\r\n");

        $tot_registro_bloco=$tot_registro_bloco+1;
        $tot_M025=$tot_registro_bloco;

       }

    }

        
    $REG_BLC[]='|'.'M025'.'|'.$tot_registro_bloco.'|' ;
    return;
}


//REGISTRO M030: IDENTIFICAÇÃO DO PERÍODO DE APURAÇÃO

 function fcont_registro_M030() {

	global $tbalanco_fcont_aencerramento,$infotitulo,$info_segmento,$fp,$REG_BLC,$info_cnpj_segmento,$tot_M030;
        	$ind_per='A00';
                $cta_resultado=$infotitulo['conta_resultado_encerra'];
		$sel_resultado=mysql_query("select * from $tbalanco_fcont_aencerramento where conta='$cta_resultado'");


		while ($v=mysql_fetch_assoc($sel_resultado)) {
			$vl_luc_liq=$v[saldo_ante]+$v[debito]-$v[credito];
		}
	        
  


			if ($vl_luc_liq>0)  {
			   $ind_luc_liq='D';
			}else{
			   $ind_luc_liq='C';
			}
		
			$vl_luc_liq=number_format($vl_luc_liq, 2, ',', '');
		       
		
			$linha='|'.'M030'.'|'.$ind_per.'|'.$vl_luc_liq.'|'.$ind_luc_liq.'|';
			$escreve = fwrite($fp, "$linha\r\n");

			$tot_registro_bloco=$tot_registro_bloco+1;
			$tot_M030=$tot_registro_bloco;

       			 $REG_BLC[]='|'.'M030'.'|'.$tot_registro_bloco.'|';

        return;
}

//REGISTRO M155: DETALHHE DOS SALDOS REFERENCIAIS DAS CONTAS PATRIMONIAIS
function  fcont_registro_M155(){
	global $info_segmento,$fp,$REG_BLC,$info_cnpj_segmento,$tot_M155,$tbalanco_fcont;

       $graumaximo=strlen(_myfun_mascara_x($info_cnpj_segmento));
       $sel_x=mysql_query("SELECT * FROM $tbalanco_fcont");

       while($v=mysql_fetch_assoc($sel_x)){

        	$cod_cta=$v['conta'];
      
        $linha='|'.'M155'.'|'.$cod_cta.'|'.$cod_ccus.'|'.$cod_cta_ref.'|'.$vl_sld_ini_soc_ant.'|'.$ind_dc_ini_soc_ant.'|'.$vl_is_deb.'|'.$vl_is_cred.'|'.$vl_sld_ini_soc.'|'.$ind_dc_ini_soc.'|'.$vl_sld_ini_fc_ant.'|'.$ind_dc_ini_fc_ant.'|'.$vl_if_deb.'|'.$vl_if_cred.'|'.$vl_sld_ini_fc.'|'.$ind_dc_ini_fc.'|'.$vl_deb_contabil.'|'.$vl_cred_contabil.'|'.$vl_deb_fcont_e.'|'.$vl_cred_fcont_e.'|'.$vl_deb_fcont_i.'|'.$vl_cred_fcont_i.'|'.$vl_tr_deb.'|'.$vl_tr_cred.'|'.$vl_tf_deb.'|'.$vl_tf_cred.'|'.$vl_ts_deb.'|'.$vl_ts_cred.'|'.$vl_ef_deb.'|'.$vl_ef_cred.'|'.$vl_sld_fin_fc.'|'.$ind_dc_fin_fc.'|'.$vl_sld_fin_soc.'|'.$ind_dc_fin_soc.'|';
        $escreve = fwrite($fp, "$linha\r\n");

        $tot_registro_bloco=$tot_registro_bloco+1;
        $tot_M155=$tot_registro_bloco;
        }
        
        $REG_BLC[]='|'.'M155'.'|'.$tot_registro_bloco.'|';
        return;

}

//REGISTRO M355: DETALHES DOS SALDOS REFERENCIAIS DAS CONTAS DE RESULTADO ANTES DO ENCERRAMENTO
function fcont_registro_M355(){
	global $info_segmento,$fp,$REG_BLC,$info_cnpj_segmento,$tot_M155,$tbalanco_fcont;

	       $graumaximo=strlen(_myfun_mascara_x($info_cnpj_segmento));
	       $sel_x=mysql_query("SELECT * FROM $tbalanco_fcont");

	       while($v=mysql_fetch_assoc($sel_x)){

		$cod_cta=$v['conta'];
	       
		
		$linha='|'.'M355'.'|'.$cod_cta.'|'.$cod_ccus.'|'.$cod_cta_ref.'|'.$vl_sld_fin_soc.'|'.$ind_dc_fin_soc.'|'.$vl_deb_fcont_e.'|'.$vl_cred_fcont_e.'|'.$vl_deb_fcont_i.'|'.$vl_cred_fcont_i.'|'.$vl_sld_fin_fc_al.'|'.$ind_dc_fin_al.'|';
		$escreve = fwrite($fp, "$linha\r\n");

		$tot_registro_bloco=$tot_registro_bloco+1;
		$tot_M355=$tot_registro_bloco;
	    }
	    $REG_BLC[]='|'.'M355'.'|'.$tot_registro_bloco.'|';
	    return;

}


//REGISTRO M990: ENCERRAMENTO DO BLOCO M
function fcont_registro_M990(){
global $info_segmento,$fp,$REG_BLC,$info_cnpj_segmento,$tot_M990,$tot_M001,$tot_M020,$tot_M025,$tot_M030,$tot_M155,$tot_M355,$total_M990;

      $tot_registro_bloco=$tot_registro_bloco+1;
      $tot_M990=$tot_registro_bloco;
      
      $total_M990=$tot_M001+$tot_M020+$tot_M025+$tot_M030+$tot_M155+$tot_M355+$tot_M990;
      
      $linha='|'.'M990'.'|'.$total_M990.'|';
      $escreve = fwrite($fp,"$linha\r\n");

      $REG_BLC[]='|'.'M990'.'|'.$tot_registro_bloco.'|';


return;

}

//REGISTRO 9001: ABERTURA DO BLOCO 9
function fcont_registro_9001(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$perdtos1,$perdtos2,$REG_BLC,$info_cnpj_segmento,$tot_9001;

        $ind_dad='0';

        $linha='|'.'9001'.'|'.$ind_dad.'|';
        $escreve = fwrite($fp, "$linha\r\n");

        $tot_registro_bloco=$tot_registro_bloco+1;
        $tot_9001=$tot_registro_bloco;
        
        $REG_BLC[]='|'.'9001'.'|'.$tot_registro_bloco.'|';

        return;

}
 
?>
