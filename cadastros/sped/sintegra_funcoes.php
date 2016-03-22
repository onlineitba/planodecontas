<?
// 20102015

set_time_limit(0);

$box_inventario=$_POST[box_flag01];
$retificado=$_POST[box_flag02];

//$PRODUTOS_INVENTARIO='produtos_inventario_'.$info_cnpj;

global $chkinventario,$REG_BLC;

if($retificado=='on'){
   $finalidade='2';
}else{
   $finalidade='1';
}

if($box_inventario=='on'){
    $data_inventario=$_POST[data_inventario];
    if (!(_myfuncoes_validata($data_inventario))) {
        echo " $data_inventario - Data para invent&aacute;rio  inv&aacute;lida!!";
        echo _myfuncoes_voltar_pagina();
        exit;
    }

    $motivo_inventario='01';

    $sdata_inventario=_myfunc_dtos($data_inventario);
    $dt_periodo2=_myfunc_dtos($dt_periodo2);
    
    echo "<br> Gerando invent&aacute;rio na data: ".$data_inventario;
    $m_motivo_inventario = MATRIZ::m_motivo_inventario(); 
    echo "&nbsp;&nbsp;Motivo:".$m_motivo_inventario[$motivo_inventario];
    flush();

    $old_dtos=$dtos;
    $id_data=$sdata_inventario;
    $dtos=$id_data;    
    
    //echo '<br><br>|'.$old_dtos.'|'.$id_data.'|'.$dtos.'|'.$sdata_inventario.'|'.$dt_periodo2.'|';

    //include('produtos_tabela_inventario.php');

    //$arq_inventario='produtos_inventario_'.$info_cnpj.'_'.$cnpjcpf_segmento; 
    $arq_inventario='produtos_inventario_'.$cnpjcpf_segmento; 

    echo "<br> Tabela $arq_inventario invent&aacute;rio gerada com sucesso! <br>";
    flush();
    $dtos=$old_dtos;

    $PRODUTOS_INVENTARIO=$arq_inventario;

 
}
include('mysql_performace.php');

$tabela_61 = _myfunc_sql_61($lanperiodo1,$lanperiodo2,'');
$tabela_60D = _myfunc_sql_60D($lanperiodo1,$lanperiodo2,'');
$tabela = _myfunc_sql($lanperiodo1,$lanperiodo2,'');
$tabela_item = _myfunc_sql_item($lanperiodo1,$lanperiodo2,'');
if($box_inventario=='on'){
  $tabela_75 = _myfunc_sql_75($lanperiodo1,$lanperiodo2,'');
}

//REGISTRO TIPO 10  MESTRE DO ESTABELECIMENTO
sintegra_registro_10();

//REGISTRO TIPO 11  DADOS COMPLEMENTARES DO INFORMANTE
sintegra_registro_11();

//REGISTRO TIPO 50
//Nota fiscal, modelo 1 ou 1A (c?digo 01) , quanto ao ICMS.
//Nota fiscal conta de energia el?trica, modelo 6 (c?digo 06).
//Nota fiscal de servi?o de comunica??o, modelo 21(c?digo 21), nas aquisi??es.
//Nota fiscal de servi?o de telecomunica??o, modelo 22 (c?digo 22), nas aquisi??es.
sintegra_registro_50();

//REGISTROS TIPO 51  NOTA FISCAL DE MERCADORIAS ENTRADAS NO ESTABELECIMENTO DO INFORMANTE ? DOCUMENTO EMITIDO POR OUTRO CONTRIBUINTE
//sintegra_registro_51();

//REGISTROS TIPO 53  NOTA FISCAL DE MERCADORIA SA?DA DO ESTABELECIMENTO DO INFORMANTE
//sintegra_registro_53();

//REGISTROS TIPO 54  Produto
sintegra_registro_54();

//REGISTROS TIPO 55  GUIA NACIONAL DE RECOLHIMENTO DE TRIBUTOS ESTADUAIS
//sintegra_registro_55();

//REGISTROS TIPO 56 OPERA??ES COM VE?CULOS AUTOMOTORES NOVOS
//sintegra_registro_56();

//REGGISTRO TIPO 60  MESTRE (60M) IDENTIFICADOR DO EQUIPAMENTO
sintegra_registro_60M();

//REGISTRO TIPO 60  ANAL?TICO (60A) IDENTIFICADOR DE CADA SITUA??O TRIBUT?RIA NO FINAL DO DIA DE CADA EQUIPAMENTO EMISSOR DE CUPOM FISCAL
//sintegra_registro_60A();

//REGISTRO TIPO 60 RESUMO DI?RIO (60D) REGISTRO DE MERCADORIA/PRODUTO OU SERVI?O CONSTANTE EM DOCUMENTO FISCAL EMITIDO POR TERMINAL PONTO DE VENDA (PDV) OU EQUIPAMENTO EMISSOR DE CUPOM FISCAL (ECF)
//sintegra_registro_60D();

//REGSITRO TIPO 60 ITEM (60I) ITEM DO DOCUMENTOS FISCAL EMITIDO POR TERMINAL PONTO DE VENDA (PDV) OU EQUIPAMENTO EMISSOR DE CUPOM FISCAL (ECF)
//sintegra_registro_60I();

//REGISTRO TIPO 60 RESUMO MENSAL (60R) REGISTRO DE MERCADORIA/PRODUTO OU SERVI?O PROCESSADO EM EQUIPAMENTOS EMISSOR DE CUPOM FISCAL.
//sintegra_registro_60R();

sintegra_registro_61();

//REGISTRO TIPO 70
//Nota Fiscal de Servi?o de Transporte
//Conhecimento de Transporte Rodovi?rio de Cargas
//Conhecimento de Transporte Aquavi?rio de Cargas
//Conhecimento de Transporte Ferrovi?rio de Cargas
//Conhecimento A?reo
sintegra_registro_70();

//REGISTROS TIPO 74  REGISTRO DE INVENT?RIO
if($box_inventario=='on'){
  sintegra_registro_74();
}

//REGISTROS TIPO 75  C?DIGO DE PRODUTO OU SERVI?O
sintegra_registro_75();

//REGISTROS TIPO 90  TOTALIZA??O DO ARQUIVO
sintegra_registro_90();


//REGISTRO TIPO 10  MESTRE DO ESTABELECIMENTO
function sintegra_registro_10() {
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$qtde_linha_bloco_10,$tot_10,$info_cnpj_segmento,$finalidade;

        $data=$lanperiodo1;
        $data=_myfunc_stod($data);
        $data=_myfunc_aaaammdd($data);
        $tamanho8=8;
        $data=_myfunc_zero_a_esquerda($data,$tamanho8) ;

        $data2=$lanperiodo2;
        $data2=_myfunc_stod($data2);
        $data2=_myfunc_aaaammdd($data2);
        $tamanho8=8;
        $data2=_myfunc_zero_a_esquerda($data2,$tamanho8) ;

        $cnpjmf=$info_segmento['cnpjcpf'];
        $tamanho14=14;
        $cnpjmf=_myfunc_zero_a_esquerda($cnpjmf,$tamanho14) ;

        $ie=$info_segmento['ie'];
        $tamanho14=14;
        $ie=_myfunc_espaco_a_direita($ie,$tamanho14) ;


        $contribuinte=substr($info_segmento['razaosocial'], 0, 34);
        $tamanho35=35;
        $contribuinte=_myfunc_espaco_a_direita($contribuinte,$tamanho35);

        $cidade=$info_segmento['cidade'];
        $tamanho30=30;
        $cidade=_myfunc_espaco_a_direita($cidade,$tamanho30);

        $uf=$info_segmento['uf'];
        $tamanho2=2;
        $uf=_myfunc_espaco_a_direita($uf,$tamanho2);

        $fax=$info_segmento['fax'];
        $tamanho10=10;
        $fax=_myfunc_zero_a_esquerda($fax,$tamanho10) ;

        //ABRIR CAMPOS DEPOIS (PARAMETRIZA??O)
        $cod_arq_magnetico_entreg='3';// 1 - Estrutura conforme Conv?nio ICMS 57/95 na vers?o do Conv?nio ICMS 31/99; 2 - Estrutura conforme Conv?nio ICMS 57/95 na vers?o atual;
        $cod_nat_operacao='3';//1 - Interestaduais somente opera??es sujeitas ao regime de Substitui??o Tribut?ria; 2 - Interestaduais ? opera??es com ou sem Substitui??o Tribut?ria; 3 - Totalidade das opera??es do informante;
        $finalid_arq_magnetico=$finalidade;

        $qtde_linha_bloco_10++ ;

        $linha='10'.$cnpjmf.$ie.$contribuinte.$cidade.$uf.$fax.$data.$data2.$cod_arq_magnetico_entreg.$cod_nat_operacao.$finalid_arq_magnetico;
        $escreve = fwrite($fp, "$linha\r\n");

        $tot_registro_bloco=$tot_registro_bloco+1;
        $tot_10=$tot_registro_bloco;


        for ($i = strlen($tot_registro_bloco); $i < 8; $i++) {
          $tot_registro_bloco="0".$tot_registro_bloco;
          }

          $REG_BLC[10]='10'.$tot_registro_bloco;
          return;
          }




//REGISTRO TIPO 11  DADOS COMPLEMENTARES DO INFORMANTE
function sintegra_registro_11() {
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$qtde_linha_bloco_11,$tot_11,$TCONTABILISTA,$CONTCONTABILISTA,$TCNPJCPF; 


       $logradouro=$info_segmento['endereco'];
       $tamanho34=34;
       $logradouro=_myfunc_espaco_a_direita($logradouro,$tamanho34);


       $numero=$info_segmento['num'];
       $tamanho5=5;
       $numero=_myfunc_zero_a_esquerda($numero,$tamanho5) ;


       $complemento=$info_segmento['compl'];
       $tamanho22=22;
       $complemento=_myfunc_espaco_a_direita($complemento,$tamanho22);


       $bairro=$info_segmento['bairro'];
       $tamanho15=15;
       $bairro=_myfunc_espaco_a_direita($bairro,$tamanho15);

       $cep=$info_segmento['cep'];
       $tamanho8=8;
       $cep=_myfunc_zero_a_esquerda($cep,$tamanho8) ;


       $sel_contato = mysql_query("SELECT a.cpf,b.razao FROM $TCONTABILISTA as a,$TCNPJCPF as b WHERE a.cpf=b.cnpj",$CONTCONTABILISTA); 
       if ( mysql_num_rows($sel_contato) ) { 
            $info_contador = mysql_fetch_assoc($sel_contato); 
       } 
       $contato=substr(_myfunc_removeacentos($info_contador[razao]),0,27);


       //$contato='Patricia';
       $tamanho28=28;
       $contato=_myfunc_espaco_a_direita($contato,$tamanho28);


       $telefone=$info_segmento['tel'];
       $tamanho12=12;
       $telefone=_myfunc_zero_a_esquerda($telefone,$tamanho12) ;

        $qtde_linha_bloco_11++ ;

        $linha='11'.$logradouro.$numero.$complemento.$bairro.$cep.$contato.$telefone;
        $escreve = fwrite($fp, "$linha\r\n");

        $tot_registro_bloco=$tot_registro_bloco+1;
        $tot_11=$tot_registro_bloco;

        for ($i = strlen($tot_registro_bloco); $i < 8; $i++) {
           $tot_registro_bloco="0".$tot_registro_bloco;
           }

           $REG_BLC[11]='11'.$tot_registro_bloco;

           return;
}

//REGISTRO TIPO 50
//Nota fiscal, modelo 1 ou 1-A (c?digo 01) , quanto ao ICMS.
//Nota fiscal/conta de energia el?trica, modelo 6 (c?digo 06).
//Nota fiscal de servi?o de comunica??o, modelo 21(c?digo 21), nas aquisi??es.
//Nota fiscal de servi?o de telecomunica??o, modelo 22 (c?digo 22), nas aquisi??es.
function sintegra_registro_50() {
global $info_segmento,$fp,$TLANCAMENTOS,$TCNPJCPF,$TITEM_FLUXO,$TPRODUTOS,$info_cnpj_segmento,$REG_BLC,$qtde_linha_bloco_50,$tot_50,$lanperiodo1,$lanperiodo2,$tabela;


$crt=$info_segmento['crt'];
if($crt=='3'){
    $sql_lancamentos= mysql_query("SELECT * FROM $tabela where modelo='01' or modelo='06' or modelo='21' or modelo='22' or modelo='55' GROUP BY dono,cfop,picms ORDER BY data,documento"); //and serie<>'D'and (modelo='01' or modelo='06' or modelo='55') and data BETWEEN $lanperiodo1 AND $lanperiodo2
    //*,c.dono,c.cfop,sum(c.vicms) as vicms,c.cprod,sum(c.vbc) as vbc,c.picms,sum(c.vprod)+sum(c.vipi)+sum(c.vicmsst)+sum(c.voutro)+sum(c.vfrete) as             vprod,sum(c.vdesc) as vdesc,c.predbc,c.flag_mult,sum((c.vprod-c.vdesc)*c.predbc)/100 as isenta FROM $tabela as a,$TITEM_FLUXO as c WHERE             a.dono=c.dono  and a.serie<>'A' and a.serie<>'D' GROUP BY dono,cfop,c.picms");    // and a.serie<>'B'
}else{
    $svsub_contabil="sum(svprod) as svprod,sum(svbcst) as svbcst,sum(svicmsst) as svicmsst,sum(svfrete) as svfrete,sum(svseg) as svseg,sum(svdesc) as svdesc ,sum(svbc) as svbc,sum(svicms) as svicms,sum(svissqn) as svissqn,sum(svoutro) as svoutro,sum(svpis) as svpis,sum(svcofins) as svcofins";
    $svsub_isent_ntri="sum(svbcipi) as svbcipi, sum(svipi) as svipi,sum(svisent) as svisent";

    $sql_lancamentos= mysql_query("SELECT *,$svsub_contabil, $svsub_isent_ntri FROM $tabela where modelo='01' or modelo='06' or modelo='21' or modelo='22' or modelo='55' GROUP BY dono,cfop,picms ORDER BY data,documento"); 

}
$tot_registro_bloco=0;


  while ($v=mysql_fetch_assoc($sql_lancamentos)) {

              $data=$v['data'];
              $data=_myfunc_stod($data);
              $data=_myfunc_aaaammdd($data);
              $tamanho8=8;
              $data=_myfunc_zero_a_esquerda($data,$tamanho8) ;

              $uf=$v['uf'];
              $tamanho2=2;
              $uf=_myfunc_espaco_a_direita($uf,$tamanho2);

              if($uf=='EX') {
                 $cnpjcpf='0';
              }else{
                 $cnpjcpf=$v['cnpjcpf'];
              }

              $ie=$v['inscricao'];
              $ie=_apenas_numeros($ie);
              if(strlen($cnpjcpf)<=11 or $ie=='') {
                 $ie='ISENTO';
              }else{
                 $ie=$ie;
              }

              $tamanho14=14;
              $cnpjcpf=_myfunc_zero_a_esquerda($cnpjcpf,$tamanho14) ;

              $ie=_myfunc_espaco_a_direita($ie,$tamanho14);

              $modelo=$v['modelo'];
              $tamanho2=2;
              $modelo=_myfunc_zero_a_esquerda($modelo,$tamanho2) ;

              $serie=strtoupper($v['serie']);
              if ($serie=='U' or $serie=='E'){
                  $serie='1';
              }

              $tamanho3=3;
              $serie=_myfunc_espaco_a_direita($serie,$tamanho3);


              $documento=$v['documento'];
              if(substr($documento,0,2)=='NF'){
                 $documento=substr($documento,2);
              }

              $documento=$v['documento'];
              $documento = trim($documento);
              $documento=strtoupper($documento);
              $tamanho6=6;
              $documento=_myfunc_zero_a_esquerda($documento,$tamanho6) ;
              $documento = substr($documento,-6);

              $cfop=$v['cfop'];
              $tamanho4=4;
              $cfop=_myfunc_zero_a_esquerda($cfop,$tamanho4) ;

              $cfop2=substr($cfop,0,1);

              if($cfop2=='5' or $cfop2=='6') {
                 $emitente='P';
              }else{
                 $emitente='T';
              }

             
              $vprod=$v['svprod'];
              $vicmsst=$v['svicmsst'];
              $vfrete=$v['svfrete'];
              $vseg=$v['svseg'];
              $vdesc=$v['svdesc'];
              $vipi=$v['svipi'];
              $voutro=$v['svoutro'];
              $vbc=$v['svbc'];


              $visent=$v['svisent'];
              if($visent>0){     
                $visent=$v['svisent']-$v['svdesc']; 
              }    

              $xcst=$v['cst'];
              $csosn=$v['csosn'];

              $vsub_contabil=($vprod+$vicmsst+$vfrete+$vseg+$vipi+$voutro)-$vdesc;

              $vsub_isent_ntri=$vicmsst;  // +$vipi;
              //$vsub_outras=abs($vsub_contabil-$vbc-$vsub_isent_ntri);
              //$vsub_outras=abs($vsub_contabil-$vprod-$vfrete-$vseg-$vsub_isent_ntri);



            if($crt=='3'){ // Regime normal

                  if($xcst=='010' or $xcst=='060' or $xcst=='000' or $xcst=='070' or $xcst=='090'){
                         $outras= $vsub_contabil-$vbc;
                         $isenta_naotribut='0.00';
                    }else{
                         $outras= $vsub_contabil-($vbc+$vsub_isent_ntri);
                         $isenta_naotribut=$vsub_contabil-($vbc+$outras+$isenta_naotribut);
                  }

            }else{
            // Regime crt = 1 - Simples nacional

                  if($csosn=='102' or $csosn=='201' or $csosn=='202' or $csosn=='203' or $csosn=='500' or $csosn=='900'){
                         $outras= $vsub_contabil-($vbc+$visent);
                         $isenta_naotribut=$visent; //'0.00'; 
                    }else{
                         $isenta_naotribut=$visent; //$vsub_contabil-($vbc+$visent);
                         $outras= $vsub_contabil-($vbc+$isenta_naotribut);
                  }

          }
             //echo '<br>'.$crt.'|'.$cfop.'|'.$xcst.'|'.$csosn.'|'.$modelo.'|'.$documento.'|'.$isenta_naotribut.'|'.$outras.'|';


        
              $valor=$vsub_contabil;
              $bcicms=$vbc;

              $bcicms=_apenas_numeros($bcicms);
              $tamanho13=13;
              $bcicms=_myfunc_zero_a_esquerda($bcicms,$tamanho13) ;

              $valor= number_format($valor, 2, '.', '');
              $valor=_apenas_numeros($valor);
              $tamanho13=13;
              $valor=_myfunc_zero_a_esquerda($valor,$tamanho13) ;

              $vicms=$v['svicms'];
              $vicms=_apenas_numeros($vicms);
              $tamanho13=13;
              $vicms=_myfunc_zero_a_esquerda($vicms,$tamanho13) ;

              $isenta_naotribut= number_format($isenta_naotribut, 2, '.', '');
              $isenta_naotribut=_apenas_numeros($isenta_naotribut);
              $tamanho13=13;
              $isenta_naotribut=_myfunc_zero_a_esquerda($isenta_naotribut,$tamanho13) ;

              $outras= number_format($outras, 2, '.', '');
              $outras=_apenas_numeros($outras);
              $tamanho13=13;
              $outras=_myfunc_zero_a_esquerda($outras,$tamanho13) ;


              $aliq=$v['picms'];
              $aliq=_apenas_numeros($aliq);
              $tamanho4=4;
              $aliq=_myfunc_zero_a_esquerda($aliq,$tamanho4) ;

             $situacao= $v['cod_sit'];
              switch ($situacao) {
                  case "00": // Normal
                       $situacao='N';
                       break;
                  case "02": // Cancelada
                       $situacao='S';
                       break;
                  case "04": //Denegada
                       $situacao='2';
                       break;
                  case "05": // Inutilizada
                       $situacao='4';
                       break;

              }

              $dono=$v['dono'];
              $qtde_linha_bloco_50++ ;

             //if ($modelo=='01' or $modelo=='06' or $modelo=='55'){

              $linha='50'.$cnpjcpf.$ie.$data.$uf.$modelo.$serie.$documento.$cfop.$emitente.$valor.$bcicms.$vicms.$isenta_naotribut.$outras.$aliq.$situacao;
              $escreve = fwrite($fp, "$linha\r\n");
              $tot_registro_bloco=$tot_registro_bloco+1;
              $tot_50=$tot_registro_bloco;

            //}
     }


     for ($i = strlen($tot_registro_bloco); $i < 8; $i++) {
     $tot_registro_bloco="0".$tot_registro_bloco;
     }

     $REG_BLC[50]='50'.$tot_registro_bloco;
return;
}


//REGISTRO TIPO 53 NOTA FISCAL DE MERCADORIA SA?DA DO ESTABELECIMENTO DO INFORMANTE
function sintegra_registro_53() {
global $info_segmento,$fp,$TLANCAMENTOS,$TCNPJCPF,$TITEM_FLUXO,$REG_BLC,$qtde_linha_bloco_53,$tot_53,$info_cnpj_segmento,$lanperiodo1,$lanperiodo2,$tabela ;


$sql_lancamentos= mysql_query("SELECT * FROM $tabela where movimento='RECEITAS' and  svicmsst<> 0 GROUP BY dono,cfop,picms");

//$sql_lancamentos= mysql_query("SELECT a.*,c.dono,c.cfop,sum(c.vicmsst) as vicmsst,c.cprod,sum(c.vbcst) as vbcst,c.picms,sum(c.vprod) as vprod,c.predbc,c.vfrete,c.vseg,c.flag_mult FROM tabela_lan_cnpj_50 as a,$TITEM_FLUXO as c WHERE a.dono=c.dono and c.movimento='RECEITAS' and  c.vicmsst<>'0' GROUP BY c.dono,c.cprod,c.cfop");

                  $tot_registro_bloco=0;
                  while ($v= mysql_fetch_assoc($sql_lancamentos)){


                          $ie=$v['inscricao'];
                          $ie=_apenas_numeros($ie);
                          if ($ie==''){
                              $ie='ISENTO';
                          }
                          $tamanho14=14;
                          $ie=_myfunc_espaco_a_direita($ie,$tamanho14);

                          $data=$v['data'];
                          $data=_myfunc_stod($data);
                          $data=_myfunc_aaaammdd($data);
                          $tamanho8=8;
                          $data=_myfunc_zero_a_esquerda($data,$tamanho8) ;

                          if($uf=='EX') {
                             $cnpjcpf='0';
                          }else{
                             $cnpjcpf=$v['cnpjcpf'];
                          }
                          $tamanho14=14;
                          $cnpjcpf=_myfunc_zero_a_esquerda($cnpjcpf,$tamanho14) ;


                          $uf=$v['uf'];
                          $tamanho2=2;
                          $uf=_myfunc_espaco_a_direita($uf,$tamanho2);

                          $modelo=$v['modelo'];
                          $tamanho2=2;
                          $modelo=_myfunc_zero_a_esquerda($modelo,$tamanho2) ;

                          $serie=strtoupper($v['serie']);
                          $tamanho3=3;
                          $serie=_myfunc_espaco_a_direita($serie,$tamanho3);

                          $documento=$v['documento'];
                          $documento = trim($documento);
                          $documento=strtoupper($documento);
                          $tamanho6=6;
                          $documento=_myfunc_zero_a_esquerda($documento,$tamanho6) ;
                          $documento = substr($documento,-6);


                          $cfop=$v['cfop'];
                          $tamanho4=4;
                          $cfop=_myfunc_zero_a_esquerda($cfop,$tamanho4) ;

                          $cfop2=substr($cfop,0,1);


                          if($cfop2=='5' or $cfop2=='6') {
                             $emitente='P';
                             }else{
                             $emitente='T';
                          }

                          $vbcst=$v['svbcst'];
                          $vbcst=_apenas_numeros($vbcst);
                          $tamanho13=13;
                          $vbcst=_myfunc_zero_a_esquerda($vbcst,$tamanho13) ;

                          $icms_retido=$v['vicmsst'];;
                          $icms_retido=_apenas_numeros($icms_retido);
                          $tamanho13=13;
                          $icms_retido=_myfunc_zero_a_esquerda($icms_retido,$tamanho13) ;

                          $frete=$v['svfrete'];
                          $seguro=$v['svseg'];
                          $despesas=$frete+$vseg;
                          $despesas=_apenas_numeros($despesas);
                          $tamanho13=13;
                          $despesas=_myfunc_zero_a_esquerda($despesas,$tamanho13) ;

                          $vprod=$v['svprod'];
                          $vicmsst=$v['svicmsst'];
                          $vfrete=$v['svfrete'];
                          $vseg=$v['svseg'];
                          $vdesc=$v['svdesc'];
                          $vipi=$v['svipi'];
                          $voutro=$v['svoutro'];

                          //11/08/2011
                          $vsub_contabil=$vprod+$vicmsst+$vfrete+$vseg-$vdesc+$vipi+$voutro;
                          $valor=$vsub_contabil;
                          $valor=_apenas_numeros($valor);
                          $tamanho13=13;
                          $valor=_myfunc_zero_a_esquerda($valor,$tamanho13) ;

                          //if($valor<='0000000000000'){
                          //$situacao='S';
                          //}else{
                          $situacao='N';
                          //}
                          //11/08/2011

                          $cod_antecipacao=' ';

                          $branco=' ';
                          $tamanho29=29;
                          $branco=_myfunc_espaco_a_direita($branco,$tamanho29);


                          $qtde_linha_bloco_53++ ;

                    $linha='53'.$cnpjcpf.$ie.$data.$uf.$modelo.$serie.$documento.$cfop.$emitente.$vbcst.$icms_retido.$despesas.$situacao.$cod_antecipacao.$branco;
                    $escreve = fwrite($fp, "$linha\r\n");
                    $tot_registro_bloco=$tot_registro_bloco+1;
                    $tot_53=$tot_registro_bloco;
                    }
                    for ($i = strlen($tot_registro_bloco); $i < 8; $i++) {
                    $tot_registro_bloco="0".$tot_registro_bloco;
                    }

                    $REG_BLC[53]='53'.$tot_registro_bloco;
return;
}


//REGISTRO TIPO 54  PRODUTO
function sintegra_registro_x54() {

global $info_segmento,$fp,$TLANCAMENTOS,$TCNPJCPF,$TITEM_FLUXO,$TPRODUTOS,$info_cnpj_segmento,$REG_BLC,$qtde_linha_bloco_54,$tot_54,$lanperiodo1,$lanperiodo2,$tabela_item;
 global $qtd_lin_C,$tot_registro_bloco_C170,$info_segmento,$fp,$lanperiodo1,$lanperiodo2,$REG_BLC,$TLANCAMENTOS,$TNFDOCUMENTOS,$TITEM_FLUXO;
    global $TNFDOCUMENTOS_TMP,$TNFDOCUMENTOS,$CONTNFDOCUMENTOS;
ECHO $TLANCAMENTOS. "UUU";
$registro=1;
$vnum='';

    $filtro_lancamentos=" and POSITION(modelo IN ':01:06:55:') > 0";
    //$filtro_item_fluxo=" and vpis>0 ";
        $sql_lancamentos= _myfunc_sql_receitas_despesas_itens('',"$filtro_lancamentos",'','','');

                  $tot_registro_bloco=0;
    while ($v=mysql_fetch_assoc($sql_lancamentos)) {



// $sql_lancamentos= mysql_query("SELECT * FROM $tabela_item where modelo='01' or modelo='06' or modelo='55'"); //and data BETWEEN $lanperiodo1 AND $lanperiodo2
 
                  

                           $dono=$v['dono'];

                          //$dono56=$v['dono'];


                          if($uf=='EX') {
                             $cnpjcpf='0';
                          }else{
                             $cnpjcpf=$v['cnpjcpf'];
                          }
                          $tamanho14=14;
                          $cnpjcpf=_myfunc_zero_a_esquerda($cnpjcpf,$tamanho14) ;

                          $modelo=$v['modelo'];
                          $tamanho2=2;
                          $modelo=_myfunc_zero_a_esquerda($modelo,$tamanho2) ;

                          $serie=strtoupper($v['serie']);
                          if ($serie=='U' or $serie=='E'){
                              $serie='1';
                          }

                          $tamanho3=3;
                          $serie=_myfunc_espaco_a_direita($serie,$tamanho3);


                          $documento=$v['documento'];
                          if(substr($documento,0,2)=='NF'){      //documento que come?am com NF
                             $documento=substr($documento,2);
                          }

                          $documento=$v['documento'];
                          $documento = trim($documento);
                          $documento=strtoupper($documento);
                          $tamanho6=6;
                          $documento=_myfunc_zero_a_esquerda($documento,$tamanho6) ;
                          $documento = substr($documento,-6);


                          $numero=$documento;
                          if ($numero<>$vnum){
                             $vnum=$numero;
                             $registro=1;
                          }else{
                             $registro++;
                          }

                          $cfop=$v['cfop'];
                          $tamanho4=4;
                          $cfop=_myfunc_zero_a_esquerda($cfop,$tamanho4) ;

                          $cst=$v['cst'];
                          $tamanho3=3;
                          $cst=_myfunc_zero_a_esquerda($cst,$tamanho3) ;

                    $csosn=$v['csosn'];
                    $csosn=_apenas_numeros($csosn);
                    $tamanho3=3;
                    $csosn=_myfunc_espaco_a_direita($csosn,$tamanho3) ;

                   $crt=$info_segmento['crt'];


                   if($crt=='1'){
                      $cst=$csosn;
                   } else{
                      $cst=$cst;
                   }




                          $num_item=$registro;
                          $tamanho3=3;
                          $num_item=_myfunc_zero_a_esquerda($num_item,$tamanho3) ;

                          $conta=$v['cprod'];
                          $conta = trim($conta);
                          $conta=strtoupper($conta);
                          $tamanho14=14;
                          $conta=_myfunc_espaco_a_direita($conta,$tamanho14);
                          $conta = substr($conta,-14);

                          //$conta56=$v['cprod'];//?para pegar o registro 56


                          $qtd=$v['qcom'];
                          $qtd=$qtd*1000;

                          $qtd=_apenas_numeros($qtd);
                          $tamanho11=11;
                          $qtd=_myfunc_zero_a_esquerda($qtd,$tamanho11) ;

                          $vprod=$v['vprod'];
                          $produto=$vprod;
                          $produto=_apenas_numeros($produto);
                          $tamanho12=12;

                  

                          $vdesc=$v['vdesc'];
                          $vdesc=_apenas_numeros($vdesc);
                          $tamanho12=12;
                          $vdesc=_myfunc_zero_a_esquerda($vdesc,$tamanho12) ;

                          $bcicms=$v['vbc'];
                          $bcicms=_apenas_numeros($bcicms);
                          $tamanho12=12;
                          $bcicms=_myfunc_zero_a_esquerda($bcicms,$tamanho12) ;

                          $vicmsst=$v['vicmsst'];
                          $vicmsst=_apenas_numeros($vicmsst);
                          $tamanho12=12;
                          $vicmsst=_myfunc_zero_a_esquerda($vicmsst,$tamanho12) ;

                          $vipi=$v['vipi'];
                          $vipi=_apenas_numeros($vipi);
                          $tamanho12=12;
                          $vipi=_myfunc_zero_a_esquerda($vipi,$tamanho12) ;

                          $aliq_icms=$v['picms'];
                          $aliq_icms=_apenas_numeros($aliq_icms);
                          $tamanho4=4;
                          $aliq_icms=_myfunc_zero_a_esquerda($aliq_icms,$tamanho4) ;

                          //$genero=$v['genero'];

                          //if ($modelo=='01' or $modelo=='06' or $modelo=='21' or $modelo=='22' or $modelo=='55'){

                                 $linha='54'.$cnpjcpf.$modelo.$serie.$documento.$cfop.$cst.$num_item.$conta.$qtd.$produto.$vdesc.$bcicms.$vicmsst.$vipi.$aliq_icms;
                                 $escreve = fwrite($fp, "$linha\r\n");
                                 $tot_registro_bloco=$tot_registro_bloco+1;
                                 $tot_54=$tot_registro_bloco;
                                 $qtde_linha_bloco_54++ ;
                         //}

                         //if($genero=='87'){
                         //sintegra_registro_56($conta56,$dono56);
                         //}




            }

                  for ($i = strlen($tot_registro_bloco); $i < 8; $i++) {
                  $tot_registro_bloco="0".$tot_registro_bloco;
                  }


                  $REG_BLC[54]='54'.$tot_registro_bloco;



return;
}


//REGISTRO TIPO 54  PRODUTO
function sintegra_registro_54() {
global $info_segmento,$fp,$TLANCAMENTOS,$TCNPJCPF,$TITEM_FLUXO,$TPRODUTOS,$CONTNFDOCUMENTOS,$info_cnpj_segmento,$REG_BLC,$qtde_linha_bloco_54,$tot_54,$lanperiodo1,$lanperiodo2,$tabela_item,$tabela;
//$tot_registro_bloco=0;
//$tot_registro_bloco56=0;
$registro=1;
$vnum='';
$xdoc=''; 
$donoant='';
// Buscar valor de frete e despesas

$soma_frete=0.00;
$soma_seguro=0.00;
$soma_despes=0.00;
$soma_piscofins=0.00;


                  $sql_lancamentos= mysql_query("SELECT * FROM $tabela_item where modelo='01' or modelo='06' or modelo='55'"); //and data BETWEEN $lanperiodo1 AND $lanperiodo2
                  //$sql_lancamentos= mysql_query("SELECT a.*,c.dono,c.cfop,sum(c.vicmsst) as vicmsst,c.cprod,sum(c.vbcst) as vbcst,c.picms,sum(c.vprod) as vprod,c.predbc,c.vfrete,c.vseg,c.flag_mult FROM tabela_lan_cnpj_50 as a,$TITEM_FLUXO as c WHERE a.dono=c.dono and c.movimento='RECEITAS' and  c.vicmsst<>'0' GROUP BY c.dono,c.cprod,c.cfop");
                  $vsub_contabil=$movimento_periodo[svprod]+$movimento_periodo[svicmsst]+ $movimento_periodo[svfrete] + $movimento_periodo[svseg] - $movimento_periodo[svdesc]+ $movimento_periodo[svipi]+ $movimento_periodo[svoutro];
                  $tot_registro_bloco=0;
                  $soma_frete=0.00;
                  $soma_seguro=0.00;
                  while ($v= mysql_fetch_assoc($sql_lancamentos)){

                          $dono=$v['dono'];

                          $documento=$v['documento'];
                          if(substr($documento,0,2)=='NF'){      //documento que come?am com NF
                             $documento=substr($documento,2);
                          }
                          $documento=$v['documento'];
                          $documento = trim($documento);
                          $documento=strtoupper($documento);
                          $tamanho6=6;
                          $documento=_myfunc_zero_a_esquerda($documento,$tamanho6) ;
                          $documento = substr($documento,-6);

                          if($xdoc<>$documento){ 

                                //$xdoc=$documento;

                                $cst='   ';
                                $conta='              ';
                                $qtd='00000000000';
                                $produto='000000000000';
                                $bcicms='000000000000';
                                $vicmsst='000000000000';
                                $vipi='000000000000';
                                $aliq_icms='0000';

                             if($soma_frete>0){
                                $num_item='991';
                                $vinfo=$soma_frete;
                                $vinfo=_apenas_numeros($vinfo);
                                $tamanho12=12;
                                $vinfo=_myfunc_zero_a_esquerda($vinfo,$tamanho12) ;

                                $linha='54'.$cnpjcpf.$modelo.$serie.$xdoc.$cfop.$cst.$num_item.$conta.$qtd.$produto.$vinfo.$bcicms.$vicmsst.$vipi.$aliq_icms;
                                $escreve = fwrite($fp, "$linha\r\n");
                                $tot_registro_bloco=$tot_registro_bloco+1;
                                $tot_54=$tot_registro_bloco;
                                $qtde_linha_bloco_54++ ;
                                $soma_frete=0.00;
                             }

                             if($soma_seguro>0){
                                $num_item='992';
                                $vinfo=$soma_seguro;
                                $vinfo=_apenas_numeros($vinfo);
                                $tamanho12=12;
                                $vinfo=_myfunc_zero_a_esquerda($vinfo,$tamanho12) ;
                                $linha='54'.$cnpjcpf.$modelo.$serie.$xdoc.$cfop.$cst.$num_item.$conta.$qtd.$produto.$vinfo.$bcicms.$vicmsst.$vipi.$aliq_icms;
                                $escreve = fwrite($fp, "$linha\r\n");
                                $tot_registro_bloco=$tot_registro_bloco+1;
                                $tot_54=$tot_registro_bloco;
                                $qtde_linha_bloco_54++ ;
                                $soma_seguro=0.00;

                             }

                             if($soma_piscofins>0){
                                $num_item='993';
                                $vinfo=$soma_piscofins;
                                $vinfo=_apenas_numeros($vinfo);
                                $tamanho12=12;
                                $vinfo=_myfunc_zero_a_esquerda($vinfo,$tamanho12) ;
                                $linha='54'.$cnpjcpf.$modelo.$serie.$xdoc.$cfop.$cst.$num_item.$conta.$qtd.$produto.$vinfo.$bcicms.$vicmsst.$vipi.$aliq_icms;
                                $escreve = fwrite($fp, "$linha\r\n");
                                $tot_registro_bloco=$tot_registro_bloco+1;
                                $tot_54=$tot_registro_bloco;
                                $qtde_linha_bloco_54++ ;
                                $soma_piscofins=0.00;

                             }

                             if($soma_despes>0){
                                $num_item='999';
                                $vinfo=$soma_despes;
                                $vinfo=_apenas_numeros($vinfo);
                                $tamanho12=12;
                                $vinfo=_myfunc_zero_a_esquerda($vinfo,$tamanho12) ;
                                $linha='54'.$cnpjcpf.$modelo.$serie.$xdoc.$cfop.$cst.$num_item.$conta.$qtd.$produto.$vinfo.$bcicms.$vicmsst.$vipi.$aliq_icms;
                                $escreve = fwrite($fp, "$linha\r\n");
                                $tot_registro_bloco=$tot_registro_bloco+1;
                                $tot_54=$tot_registro_bloco;
                                $qtde_linha_bloco_54++ ;
                                $soma_despes=0.00;

                             }

                            // Buscar valor de frete e despesas
                            $soma_frete=0.00;
                            $soma_seguro=0.00;
                            $soma_despes=0.00;
                            $soma_piscofins=0.00;
                            $xdoc=$documento;

                         }
    

                          $sel_tabela = mysql_query("SELECT dono,svfrete,svseg,svoutro,svpis,svcofins FROM $tabela WHERE dono='$dono'",$CONTNFDOCUMENTOS);

                          while ($vardono = mysql_fetch_assoc($sel_tabela)){
                              $soma_frete=$vardono[svfrete];
                              $soma_seguro=$vardono[svseg];
                              $soma_despes=$vardono[svoutro];
                              $soma_piscofins=$vardono[svpis]+$vardono[svcofins];

                          }
                          // FIM buscar valor de frete e despesas

                          if($uf=='EX') {
                             $cnpjcpf='0';
                          }else{
                             $cnpjcpf=$v['cnpjcpf'];
                          }
                          $tamanho14=14;
                          $cnpjcpf=_myfunc_zero_a_esquerda($cnpjcpf,$tamanho14) ;

                          $modelo=$v['modelo'];
                          $tamanho2=2;
                          $modelo=_myfunc_zero_a_esquerda($modelo,$tamanho2) ;

                          $serie=strtoupper($v['serie']);
                          if ($serie=='U' or $serie=='E'){
                              $serie='1';
                          }
                          $tamanho3=3;
                          $serie=_myfunc_espaco_a_direita($serie,$tamanho3);


                          $numero=$documento;
                          if ($numero<>$vnum){
                             $vnum=$numero;
                             $registro=1;
                          }else{
                             $registro++;
                          }

                          $cfop=$v['cfop'];
                          $tamanho4=4;
                          $cfop=_myfunc_zero_a_esquerda($cfop,$tamanho4) ;

                          $cst=$v['cst'];
                          $tamanho3=3;
                          $cst=_myfunc_zero_a_esquerda($cst,$tamanho3) ;

                          $csosn=$v['csosn'];
                          $csosn=_apenas_numeros($csosn);
                          $tamanho3=3;
                          $csosn=_myfunc_espaco_a_direita($csosn,$tamanho3) ;

                          $crt=$info_segmento['crt'];

                          $xcst=$cst;
                          if($crt=='1'){
                             if($modelo=='55'){
                               if($csosn<>'   '){ // tem que ser com espaço pois já esta formatado acima
                                  $cst=$csosn;
                                  //echo '<br>'.$xcst.'|'.$csosn.'|'.$modelo.'|'.$numero;
                              }
                             }
                          }

                          $num_item=$registro;
                          $tamanho3=3;
                          $num_item=_myfunc_zero_a_esquerda($num_item,$tamanho3) ;

                          $conta=$v['cprod'];
                          $conta = trim($conta);
                          $conta=strtoupper($conta);
                          $tamanho14=14;
                          $conta=_myfunc_espaco_a_direita($conta,$tamanho14);
                          $conta = substr($conta,-14);

                          //$conta56=$v['cprod'];//?para pegar o registro 56

                          $qtd=$v['qcom'];
                          $qtd=$qtd*1000;

                          $qtd=_apenas_numeros($qtd);
                          $tamanho11=11;
                          $qtd=_myfunc_zero_a_esquerda($qtd,$tamanho11) ;

                          $vprod=$v['vprod'];
                          $produto=$vprod;
                          $produto=_apenas_numeros($produto);
                          $tamanho12=12;
                          $produto=_myfunc_zero_a_esquerda($produto,$tamanho12) ;

                          $vdesc=$v['vdesc'];
                          $vdesc=_apenas_numeros($vdesc);
                          $tamanho12=12;
                          $vdesc=_myfunc_zero_a_esquerda($vdesc,$tamanho12) ;

                          $bcicms=$v['vbc'];
                          $bcicms=_apenas_numeros($bcicms);
                          $tamanho12=12;
                          $bcicms=_myfunc_zero_a_esquerda($bcicms,$tamanho12) ;

                          $vicmsst=$v['vicmsst'];
                          $vicmsst=_apenas_numeros($vicmsst);
                          $tamanho12=12;
                          $vicmsst=_myfunc_zero_a_esquerda($vicmsst,$tamanho12) ;

                          $vipi=$v['vipi'];
                          $vipi=_apenas_numeros($vipi);
                          $tamanho12=12;
                          $vipi=_myfunc_zero_a_esquerda($vipi,$tamanho12) ;

                          $aliq_icms=$v['picms'];
                          $aliq_icms=_apenas_numeros($aliq_icms);
                          $tamanho4=4;
                          $aliq_icms=_myfunc_zero_a_esquerda($aliq_icms,$tamanho4) ;

                          $vcontabil=$v[vprod]+$v[vicmsst]+ $v[vfrete] + $v[vseg] - $v[vdesc]+ $v[vipi]+ $v[voutro];
                          $vcontabil=$v[vprod]+$v[vicmsst]+$v[vfrete]+$v[vipi]+$v[vseg]+$v[voutro]-$v[vdesc];

                          $vcontabil=number_format($vcontabil, 2, ',', '');
                          $produto=$vcontabil;

                          $produto=_apenas_numeros($produto);
                          $tamanho12=12;
                          $produto=_myfunc_zero_a_esquerda($produto,$tamanho12) ;


                          $linha='54'.$cnpjcpf.$modelo.$serie.$documento.$cfop.$cst.$num_item.$conta.$qtd.$produto.$vdesc.$bcicms.$vicmsst.$vipi.$aliq_icms;
                          $escreve = fwrite($fp, "$linha\r\n");
                          $tot_registro_bloco=$tot_registro_bloco+1;
                          $tot_54=$tot_registro_bloco;
                          $qtde_linha_bloco_54++ ;


            }

            for ($i = strlen($tot_registro_bloco); $i < 8; $i++) {
                 $tot_registro_bloco="0".$tot_registro_bloco;
            }

            $REG_BLC[54]='54'.$tot_registro_bloco;



return;
}


//REGISTROS TIPO 56  OPERA??ES COM VE?CULOS AUTOMOTORES NOVOS
function sintegra_registro_56($conta56,$dono56) {
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$qtde_linha_bloco_56,$REG_BLC,$TLANCAMENTOS,$TVEICULOS,$TCNPJCPF,$TITEM_FLUXO,$tot_56,$tot_registro_bloco56;
$sql_lancamentos= mysql_query("SELECT a.*,c.cfop,c.cst,c.dono,c.cprod,c.pipi,c.genero,b.chassi,b.renavam FROM tabela_lan_cnpj_50 as a,$TITEM_FLUXO as c,$TVEICULOS as b WHERE c.dono='$dono56' and c.dono=a.dono and b.renavam='' and c.cprod='$conta56' GROUP BY c.dono,c.cprod,c.cfop order by c.dono,c.cprod,c.cfop");
$registro=1;
$vnum='';
                  while ($v= mysql_fetch_assoc($sql_lancamentos) ) {

                          $cnpjcpf=$v['cnpj'];
                          $tamanho14=14;
                          $cnpjcpf=_myfunc_zero_a_esquerda($cnpjcpf,$tamanho14) ;

                          $modelo=$v['modelo'];
                          $tamanho2=2;
                          $modelo=_myfunc_zero_a_esquerda($modelo,$tamanho2) ;

                          $serie=strtoupper($v['serie']);
                          if ($serie=='U' or $serie=='E'){
                              $serie='1';
                          }

                          $tamanho3=3;
                          $serie=_myfunc_espaco_a_direita($serie,$tamanho3);

                          $documento=$v['documento'];
                          if(substr($documento,0,2)=='NF'){      //documento que come?am com NF
                             $documento=substr($documento,2);
                          }

                          $documento=$v['documento'];
                          $documento = trim($documento);
                          $documento=strtoupper($documento);
                          $tamanho6=6;
                          $documento=_myfunc_zero_a_esquerda($documento,$tamanho6) ;
                          $documento = substr($documento,-6);



                          $numero=$documento;

                          if ($numero<>$vnum){
                             $vnum=$numero;
                             $registro=1;
                          }else{
                            $registro++;
                          }

                          $cfop=$v['cfop'];
                          $tamanho4=4;
                          $cfop=_myfunc_zero_a_esquerda($cfop,$tamanho4) ;

                          $cst=$v['cst'];
                          $tamanho3=3;
                          $cst=_myfunc_zero_a_esquerda($cst,$tamanho3) ;

                          $num_item=$registro;
                          $tamanho3=3;
                          $num_item=_myfunc_zero_a_esquerda($num_item,$tamanho3) ;


                          $cod_prod=$v['cprod'];
                          $cod_prod = trim($cod_prod);
                          $cod_prod=strtoupper($cod_prod);
                          $tamanho14=14;
                          $cod_prod=_myfunc_espaco_a_direita($cod_prod,$tamanho14);
                          $cod_prod = substr($cod_prod,-14);


                          $tipo_oper='3'; //Tipo de opera??o: 1 ? venda para concession?ria; 2 ? ?Faturamento Direto? ? Conv?nio ICMS 51/00; 3 ? Venda direta)

                          $cnpj='';//colocar o cnpjcpf da CONCESSIONARIA
                          $tamanho14=14;
                          $cnpj=_myfunc_zero_a_esquerda($cnpj,$tamanho14) ;

                          $aliq_ipi=$v['pipi'];
                          $aliq_ipi=_apenas_numeros($aliq_ipi);
                          $tamanho4=4;
                          $aliq_ipi=_myfunc_zero_a_esquerda($aliq_ipi,$tamanho4) ;

                          $chassi=$v['chassi'];
                          $tamanho17=17;
                          $chassi=_myfunc_zero_a_esquerda($chassi,$tamanho17) ;


                          $branco='';
                          $tamanho39=39;
                          $branco=_myfunc_espaco_a_direita($branco,$tamanho39) ;

                          $qtde_linha_bloco_56++ ;


                             $linha='56'.$cnpjcpf.$modelo.$serie.$documento.$cfop.$cst.$num_item.$cod_prod.$tipo_oper.$cnpj.$aliq_ipi.$chassi.$branco;
                             $escreve = fwrite($fp, "$linha\r\n");
                             $tot_registro_bloco56=$tot_registro_bloco56+1;
                             $tot_56=$tot_registro_bloco56;



                  }
                  for ($i = strlen($tot_registro_bloco56); $i < 8; $i++) {
                  $tot_registro_bloco56="0".$tot_registro_bloco56;
                  }

                  $REG_BLC[56]='56'.$tot_registro_bloco56;

return;
}


//REGGISTRO TIPO 60 - MESTRE (60M) IDENTIFICADOR DO EQUIPAMENTO
function sintegra_registro_60M(){
global $info_segmento,$info_cnpj_segmento,$fp,$lanperiodo1,$lanperiodo2,$qtde_linha_bloco_60M,$REG_BLC,$tot_60M,$TMAPA_RESUMO;
$sql_lancamentos= mysql_query("select * from $TMAPA_RESUMO where cnpjcpfseg='$info_cnpj_segmento' and dt_mapa BETWEEN $lanperiodo1 AND $lanperiodo2 order by dt_mapa");
$tot_registro_bloco=0;
            while ( $v = mysql_fetch_assoc($sql_lancamentos) ) {

                    $dt_mapa=$v['dt_mapa'];
                    $dts_mapa=$v['dt_mapa'];
                    $dt_mapa=_myfunc_stod($dt_mapa);
                    $dt_mapa=_myfunc_aaaammdd($dt_mapa);
                    $tamanho8=8;
                    $dt_mapa=_myfunc_zero_a_esquerda($dt_mapa,$tamanho8) ;

                    $numif=$v['numif'];
                    $tamanho3=3;
                    $numif=_myfunc_zero_a_esquerda($numif,$tamanho3) ;

                    $modelo='2D';

                    $cpi=$v['cpi'];
                    $tamanho6=6;
                    $cpi=_myfunc_zero_a_esquerda($cpi,$tamanho6) ;

                    $cpf=$v['cpf'];
                    $tamanho6=6;
                    $cpf=_myfunc_zero_a_esquerda($cpf,$tamanho6) ;

                    $reducao=$v['reducao'];
                    $tamanho6=6;
                    $reducao=_myfunc_zero_a_esquerda($reducao,$tamanho6) ;

                    $cro='001';

                    $vdia=$v['vdia'];
                    $vdia=_apenas_numeros($vdia);
                    $tamanho16=16;
                    $vdia=_myfunc_zero_a_esquerda($vdia,$tamanho16) ;

                    $gtf=$v['gtf'];
                    $gtf=_apenas_numeros($gtf);
                    $tamanho16=16;
                    $gtf=_myfunc_zero_a_esquerda($gtf,$tamanho16) ;

                    $branco='';
                    $tamanho37=37;
                    $branco=_myfunc_espaco_a_direita($branco,$tamanho37) ;

                    $mapa=$v['mapa'];

                    //$serial_imp=_apenas_numeros($v['serial_imp']);
                    //$serial_imp = substr($serial_imp,-15);

                    $serial_imp=$v['serial_imp'];
                    $ecf_numimp= $serial_imp ;

                    //echo "<BR>".$ecf_numimp;
                    //exit;
                    $tamanho20=20;
                    $serial_imp=_myfunc_espaco_a_direita($serial_imp,$tamanho20) ;

                    $qtde_linha_bloco_60M++ ;

                    $linha='60'.'M'.$dt_mapa.$serial_imp.$numif.$modelo.$cpi.$cpf.$reducao.$cro.$vdia.$gtf.$branco;
                    $escreve = fwrite($fp, "$linha\r\n");
                    $tot_registro_bloco=$tot_registro_bloco+1;
                    $tot_60M=$tot_registro_bloco;

                    sintegra_registro_60A($mapa,$ecf_numimp);
                    sintegra_registro_60D($dts_mapa,$ecf_numimp);
                    sintegra_registro_60I($dts_mapa,$ecf_numimp);



              }
                    for ($i = strlen($tot_registro_bloco); $i < 8; $i++) {
                         $tot_registro_bloco="0".$tot_registro_bloco;
                    }

                    $REG_BLC[60]='60M'.$tot_registro_bloco;
return;
}

//REGISTRO TIPO 60  ANAL?TICO (60A) IDENTIFICADOR DE CADA SITUA??O TRIBUT?RIA NO FINAL DO DIA DE CADA EQUIPAMENTO EMISSOR DE CUPOM FISCAL
function sintegra_registro_60A($mapa,$ecf_numimp){
global $info_segmento,$info_cnpj_segmento,$fp,$lanperiodo1,$lanperiodo2,$qtde_linha_bloco_60A,$REG_BLC,$tot_60A,$TMAPA_RESUMO,$tot_registro_bloco60A;
$sql_lancamentos= mysql_query("select * from $TMAPA_RESUMO where cnpjcpfseg='$info_cnpj_segmento' and dt_mapa BETWEEN $lanperiodo1 AND $lanperiodo2 and mapa='$mapa' and serial_imp='$ecf_numimp' order by dt_mapa");
$tot_registro_bloco=0;
            while ( $v = mysql_fetch_assoc($sql_lancamentos) ) {

                    $dt_mapa=$v['dt_mapa'];
                    $dt_mapa=_myfunc_stod($dt_mapa);
                    $dt_mapa=_myfunc_aaaammdd($dt_mapa);
                    $tamanho8=8;
                    $dt_mapa=_myfunc_zero_a_esquerda($dt_mapa,$tamanho8) ;

                    //$serial_imp=_apenas_numeros($v['serial_imp']);
                    $serial_imp=$ecf_numimp; //$v['serial_imp'];
                    //$serial_imp = substr($serial_imp,-15);
                    $tamanho20=20;
                    $serial_imp=_myfunc_espaco_a_direita($serial_imp,$tamanho20) ;

                    $branco='';
                    $tamanho79=79;
                    $branco=_myfunc_espaco_a_direita($branco,$tamanho79) ;

                    $subst=$v['subst'];
                    $subst=_apenas_numeros($subst);
                    $tamanho12=12;
                    $subst=_myfunc_zero_a_esquerda($subst,$tamanho12) ;

                    $isen=$v['isen'];
                    $isen=_apenas_numeros($isen);
                    $tamanho12=12;
                    $isen=_myfunc_zero_a_esquerda($isen,$tamanho12) ;

                    $b1=$v['b1'];
                    $b1=_apenas_numeros($b1);
                    $tamanho12=12;
                    $b1=_myfunc_zero_a_esquerda($b1,$tamanho12) ;

                    $canc=$v['canc'];
                    $canc=_apenas_numeros($canc);
                    $tamanho12=12;
                    $canc=_myfunc_zero_a_esquerda($canc,$tamanho12) ;

                    $des=$v['desconto'];
                    $des=_apenas_numeros($des);
                    $tamanho12=12;
                    $des=_myfunc_zero_a_esquerda($des,$tamanho12) ;

                    $pb2=$v['pb2'];
                    $tamanho4=4;
                    $pb2=_myfunc_espaco_a_direita($pb2,$tamanho4) ;

                    $pb3=$v['pb3'];
                    $tamanho4=4;
                    $pb3=_myfunc_espaco_a_direita($pb3,$tamanho4) ;

                    $pb4=$v['pb4'];
                    $tamanho4=4;
                    $pb4=_myfunc_espaco_a_direita($pb4,$tamanho4) ;

                    $pb5=$v['pb5'];
                    $tamanho4=4;
                    $pb5=_myfunc_espaco_a_direita($pb5,$tamanho4) ;

                    $pb6=$v['pb6'];
                    $tamanho4=4;
                    $pb6=_myfunc_espaco_a_direita($pb6,$tamanho4) ;

                    $pb7=$v['pb7'];
                    $tamanho4=4;
                    $pb7=_myfunc_espaco_a_direita($pb7,$tamanho4) ;

                    $pb8=$v['pb8'];
                    $tamanho4=4;
                    $pb8=_myfunc_espaco_a_direita($pb8,$tamanho4) ;

                    $pb9=$v['pb9'];
                    $tamanho4=4;
                    $pb9=_myfunc_espaco_a_direita($pb9,$tamanho4) ;

                    $pb10=$v['pb10'];
                    $tamanho4=4;
                    $pb10=_myfunc_espaco_a_direita($pb10,$tamanho4) ;

                    $pb11=$v['pb11'];
                    $tamanho4=4;
                    $pb11=_myfunc_espaco_a_direita($pb11,$tamanho4) ;

                    $pb12=$v['pb12'];
                    $tamanho4=4;
                    $pb12=_myfunc_espaco_a_direita($pb12,$tamanho4) ;

                    $pb13=$v['pb13'];
                    $tamanho4=4;
                    $pb13=_myfunc_espaco_a_direita($pb13,$tamanho4) ;

                    $pb14=$v['pb14'];
                    $tamanho4=4;
                    $pb14=_myfunc_espaco_a_direita($pb14,$tamanho4) ;

                    $pb15=$v['pb15'];
                    $tamanho4=4;
                    $pb15=_myfunc_espaco_a_direita($pb15,$tamanho4) ;

                    $pb16=$v['pb16'];
                    $tamanho4=4;
                    $pb16=_myfunc_espaco_a_direita($pb16,$tamanho4) ;

                    $pb17=$v['pb17'];
                    $tamanho4=4;
                    $pb17=_myfunc_espaco_a_direita($pb17,$tamanho4) ;

                    $b2=$v['b2'];
                    $b2=_apenas_numeros($b2);
                    $tamanho12=12;
                    $b2=_myfunc_zero_a_esquerda($b2,$tamanho12) ;

                    $b3=$v['b3'];
                    $b3=_apenas_numeros($b3);
                    $tamanho12=12;
                    $b3=_myfunc_zero_a_esquerda($b3,$tamanho12) ;

                    $b4=$v['b4'];
                    $b4=_apenas_numeros($b4);
                    $tamanho12=12;
                    $b4=_myfunc_zero_a_esquerda($b4,$tamanho12) ;

                    $b5=$v['b5'];
                    $b5=_apenas_numeros($b5);
                    $tamanho12=12;
                    $b5=_myfunc_zero_a_esquerda($b5,$tamanho12) ;

                    $b6=$v['b6'];
                    $b6=_apenas_numeros($b6);
                    $tamanho12=12;
                    $b6=_myfunc_zero_a_esquerda($b6,$tamanho12) ;

                    $b7=$v['b7'];
                    $b7=_apenas_numeros($b7);
                    $tamanho12=12;
                    $b7=_myfunc_zero_a_esquerda($b7,$tamanho12) ;

                    $b8=$v['b8'];
                    $b8=_apenas_numeros($b8);
                    $tamanho12=12;
                    $b8=_myfunc_zero_a_esquerda($b8,$tamanho12) ;

                    $b9=$v['b9'];
                    $b9=_apenas_numeros($b9);
                    $tamanho12=12;
                    $b9=_myfunc_zero_a_esquerda($b9,$tamanho12) ;

                    $b10=$v['b10'];
                    $b10=_apenas_numeros($b10);
                    $tamanho12=12;
                    $b10=_myfunc_zero_a_esquerda($b10,$tamanho12) ;

                    $b11=$v['b11'];
                    $b11=_apenas_numeros($b11);
                    $tamanho12=12;
                    $b11=_myfunc_zero_a_esquerda($b11,$tamanho12) ;

                    $b12=$v['b12'];
                    $b12=_apenas_numeros($b12);
                    $tamanho12=12;
                    $b12=_myfunc_zero_a_esquerda($b12,$tamanho12) ;

                    $b13=$v['b13'];
                    $b13=_apenas_numeros($b13);
                    $tamanho12=12;
                    $b13=_myfunc_zero_a_esquerda($b13,$tamanho12) ;

                    $b14=$v['b14'];
                    $b14=_apenas_numeros($b14);
                    $tamanho12=12;
                    $b14=_myfunc_zero_a_esquerda($b14,$tamanho12) ;

                    $b15=$v['b15'];
                    $b15=_apenas_numeros($b15);
                    $tamanho12=12;
                    $b15=_myfunc_zero_a_esquerda($b15,$tamanho12) ;

                    $b16=$v['b16'];
                    $b16=_apenas_numeros($b16);
                    $tamanho12=12;
                    $b16=_myfunc_zero_a_esquerda($b16,$tamanho12) ;

                    $b17=$v['b17'];
                    $b17=_apenas_numeros($b17);
                    $tamanho12=12;
                    $b17=_myfunc_zero_a_esquerda($b17,$tamanho12) ;


                    $linha60A='60'.'A'.$dt_mapa.$serial_imp;

                    if($subst>0) {
                       $linha=$linha60A.'F   '.$subst.$branco;
                       $escreve = fwrite($fp,"$linha\r\n");
                       $tot_registro_bloco60A=$tot_registro_bloco60A+1;
                       $tot_60A=$tot_registro_bloco60A;
                    }

                    if($isen>0) {
                       $linha=$linha60A.'I   '.$isen.$branco;
                       $escreve = fwrite($fp,"$linha\r\n");
                       $tot_registro_bloco60A=$tot_registro_bloco60A+1;
                       $tot_60A=$tot_registro_bloco60A;
                    }

                    if($b1>0) {
                       $linha=$linha60A.'N   '.$b1.$branco;
                       $escreve = fwrite($fp,"$linha\r\n");
                       $tot_registro_bloco60A=$tot_registro_bloco60A+1;
                       $tot_60A=$tot_registro_bloco60A;
                    }

                    if($canc>0) {
                       $linha=$linha60A.'CANC'.$canc.$branco;
                       $escreve = fwrite($fp,"$linha\r\n");
                       $tot_registro_bloco60A=$tot_registro_bloco60A+1;
                       $tot_60A=$tot_registro_bloco60A;
                    }

                    if($des>0) {
                       $linha=$linha60A.'DESC'.$des.$branco;
                       $escreve = fwrite($fp,"$linha\r\n");
                       $tot_registro_bloco60A=$tot_registro_bloco60A+1;
                       $tot_60A=$tot_registro_bloco60A;
                    }

                    if($b2>0) {
                       $linha=$linha60A.$pb2.$b2.$branco;
                       $escreve = fwrite($fp,"$linha\r\n");
                       $tot_registro_bloco60A=$tot_registro_bloco60A+1;
                       $tot_60A=$tot_registro_bloco60A;
                    }

                    if($b3>0) {
                       $linha=$linha60A.$pb3.$b3.$branco;
                       $escreve = fwrite($fp,"$linha\r\n");
                       $tot_registro_bloco60A=$tot_registro_bloco60A+1;
                       $tot_60A=$tot_registro_bloco60A;
                    }

                    if($b4>0) {
                       $linha=$linha60A.$pb4.$b4.$branco;
                       $escreve = fwrite($fp,"$linha\r\n");
                       $tot_registro_bloco60A=$tot_registro_bloco60A+1;
                       $tot_60A=$tot_registro_bloco60A;
                    }

                    if($b5>0) {
                       $linha=$linha60A.$pb5.$b5.$branco;
                       $escreve = fwrite($fp,"$linha\r\n");
                       $tot_registro_bloco60A=$tot_registro_bloco60A+1;
                       $tot_60A=$tot_registro_bloco60A;
                    }

                    if($b6>0) {
                       $linha=$linha60A.$pb6.$b6.$branco;
                       $escreve = fwrite($fp,"$linha\r\n");
                       $tot_registro_bloco60A=$tot_registro_bloco60A+1;
                       $tot_60A=$tot_registro_bloco60A;
                    }

                    if($b7>0) {
                       $linha=$linha60A.$pb7.$b7.$branco;
                       $escreve = fwrite($fp,"$linha\r\n");
                       $tot_registro_bloco60A=$tot_registro_bloco60A+1;
                       $tot_60A=$tot_registro_bloco60A;
                   }

                    if($b8>0) {
                       $linha=$linha60A.$pb8.$b8.$branco;
                       $escreve = fwrite($fp,"$linha\r\n");
                       $tot_registro_bloco60A=$tot_registro_bloco60A+1;
                       $tot_60A=$tot_registro_bloco60A;
                   }

                    if($b9>0) {
                       $linha=$linha60A.$pb9.$b9.$branco;
                       $escreve = fwrite($fp,"$linha\r\n");
                       $tot_registro_bloco60A=$tot_registro_bloco60A+1;
                       $tot_60A=$tot_registro_bloco60A;
                   }

                    if($b10>0) {
                       $linha=$linha60A.$pb10.$b10.$branco;
                       $escreve = fwrite($fp,"$linha\r\n");
                       $tot_registro_bloco60A=$tot_registro_bloco60A+1;
                       $tot_60A=$tot_registro_bloco60A;
                   }

                    if($b11>0) {
                       $linha=$linha60A.$pb11.$b11.$branco;
                       $escreve = fwrite($fp,"$linha\r\n");
                       $tot_registro_bloco60A=$tot_registro_bloco60A+1;
                       $tot_60A=$tot_registro_bloco60A;
                   }

                    if($b12>0) {
                       $linha=$linha60A.$pb12.$b12.$branco;
                       $escreve = fwrite($fp,"$linha\r\n");
                       $tot_registro_bloco60A=$tot_registro_bloco60A+1;
                       $tot_60A=$tot_registro_bloco60A;
                   }

                    if($b13>0) {
                       $linha=$linha60A.$pb13.$b13.$branco;
                       $escreve = fwrite($fp,"$linha\r\n");
                       $tot_registro_bloco60A=$tot_registro_bloco60A+1;
                       $tot_60A=$tot_registro_bloco60A;
                   }

                    if($b14>0) {
                       $linha=$linha60A.$pb14.$b14.$branco;
                       $escreve = fwrite($fp,"$linha\r\n");
                       $tot_registro_bloco60A=$tot_registro_bloco60A+1;
                       $tot_60A=$tot_registro_bloco60A;
                   }

                    if($b15>0) {
                       $linha=$linha60A.$pb15.$b15.$branco;
                       $escreve = fwrite($fp,"$linha\r\n");
                       $tot_registro_bloco60A=$tot_registro_bloco60A+1;
                       $tot_60A=$tot_registro_bloco60A;
                   }

                    if($b16>0) {
                       $linha=$linha60A.$pb16.$b16.$branco;
                       $escreve = fwrite($fp,"$linha\r\n");
                       $tot_registro_bloco60A=$tot_registro_bloco60A+1;
                       $tot_60A=$tot_registro_bloco60A;
                   }

                    if($b17>0) {
                       $linha=$linha60A.$pb17.$b17.$branco;
                       $escreve = fwrite($fp,"$linha\r\n");
                       $tot_registro_bloco60A=$tot_registro_bloco60A+1;
                       $tot_60A=$tot_registro_bloco60A;
                  }



                    $qtde_linha_bloco_60A++ ;

                  }
                    for ($i = strlen($tot_registro_bloco60A); $i < 8; $i++) {
                         $tot_registro_bloco60A="0".$tot_registro_bloco60A;
                    }

                    $REG_BLC[601]='60A'.$tot_registro_bloco60A;
return;
}

//REGISTRO TIPO 60 RESUMO DI?RIO (60D) REGISTRO DE MERCADORIA/PRODUTO OU SERVI?O CONSTANTE EM DOCUMENTO FISCAL EMITIDO POR TERMINAL PONTO DE VENDA (PDV) OU EQUIPAMENTO EMISSOR DE CUPOM FISCAL (ECF)
function sintegra_registro_60D($dts_mapa,$ecf_numimp){
global $info_segmento,$info_cnpj_segmento,$fp,$lanperiodo1,$lanperiodo2,$qtde_linha_bloco_60D,$REG_BLC,$tot_60D,$TMAPA_RESUMO,$TITEM_FLUXO,$tot_registro_bloco60D,$tabela_60D;

        $svsub_contabil="sum(vprod) as svprod,sum(vbcst) as svbcst,sum(vicmsst) as svicmsst,sum(vfrete) as svfrete,sum(vseg) as svseg,sum(vdesc) as svdesc ,sum(vbc) as svbc,sum(vicms) as svicms,sum(vissqn) as svissqn,sum(voutro) as svoutro,sum(vcredicmssn) as vcredicmssn,pcredsn";
        $svsub_isent_ntri="sum(vbcipi) as svbcipi, sum(vipi) as svipi";

$xsql="SELECT $svsub_contabil,$svsub_isent_ntri,data,ecf_numimp,sum(qcom) as sqcom,picms,cprod,cst,csosn FROM $tabela_60D where data='$dts_mapa' and ecf_numimp='$ecf_numimp' group by cprod,data order by cprod,data";
$sql_lancamentos= mysql_query($xsql);

//echo "<br>".$xsql;
//exit;


//$sql_lancamentos= mysql_query("select a.*,b.documento,b.dono,b.modelo,c.dono,c.cprod,c.cst,sum(c.qcom) as qcom,sum(c.vprod)as vprod,sum(c.vbc) as vbc,c.vicms,c.picms from $TMAPA_RESUMO as a,tabela_lan_cnpj_50 as b,$TITEM_FLUXO as c where a.cnpjcpfseg='$info_cnpj_segmento' and b.documento BETWEEN a.cpi AND a.cpf and b.dono=c.dono and b.modelo='2D'and a.mapa='$mapa' and a.dt_mapa BETWEEN $lanperiodo1 AND $lanperiodo2 group by c.cprod order by a.dt_mapa");
$tot_registro_bloco=0;

            while ( $v = mysql_fetch_assoc($sql_lancamentos) ) {
            
                    $crt=$info_segmento['crt'];

                    $dt_mapa=$v['data'];
                    $dt_mapa=_myfunc_stod($dt_mapa);
                    $dt_mapa=_myfunc_aaaammdd($dt_mapa);
                    $tamanho8=8;
                    $dt_mapa=_myfunc_zero_a_esquerda($dt_mapa,$tamanho8) ;

                    $serial_imp=$v['ecf_numimp'];
                    $tamanho20=20;
                    $serial_imp=_myfunc_espaco_a_direita($serial_imp,$tamanho20) ;

                    $cprod=$v['cprod'];
                    $cprod = trim($cprod);
                    $cprod=strtoupper($cprod);
                    $tamanho14=14;
                    $cprod=_myfunc_espaco_a_direita($cprod,$tamanho14) ;
                    $cprod = substr($cprod,-14);


                    $qcom=$v['sqcom'];
                    $qcom=$qcom*1000;  
                    $qcom=intval($qcom);
                    $qcom=_apenas_numeros($qcom);
                    $tamanho13=13;
                    $qcom=_myfunc_zero_a_esquerda($qcom,$tamanho13) ;

                    $branco='';
                    $tamanho19=19;
                    $branco=_myfunc_espaco_a_direita($branco,$tamanho19) ;

                    $vprod=$v['svprod']-$v['svdesc']; 

                    $picms=$v['picms'];
                    $pcredsn=$v['pcredsn'];

                    $vicms=$v['svicms'];
                    $vcredicmssn=$v['vcredicmssn'];

                    $vbc=$v['svbc'];

                    $vprod=_apenas_numeros($vprod);
                    $tamanho16=16;
                    $vprod=_myfunc_zero_a_esquerda($vprod,$tamanho16) ;

                    $picms=_apenas_numeros($picms);
                    $tamanho4=4;
                    $picms=_myfunc_zero_a_esquerda($picms,$tamanho4) ;

                    $pcredsn=_apenas_numeros($pcredsn);
                    $tamanho4=4;
                    $pcredsn=_myfunc_zero_a_esquerda($pcredsn,$tamanho4) ;

                    $vicms=_apenas_numeros($vicms);
                    $tamanho13=13;
                    $vicms=_myfunc_zero_a_esquerda($vicms,$tamanho13) ;

                    $vcredicmssn=_apenas_numeros($vcredicmssn);
                    $tamanho13=13;
                    $vcredicmssn=_myfunc_zero_a_esquerda($vcredicmssn,$tamanho13) ;


                    $vbc=_apenas_numeros($vbc);
                    $tamanho16=16;
                    $vbc=_myfunc_zero_a_esquerda($vbc,$tamanho16) ;

                    $cst=$v['cst'];
                    $cst=_apenas_numeros($cst);
                    $tamanho3=3;
                    $cst=_myfunc_espaco_a_direita($cst,$tamanho3) ;
                    //echo $cst.'<br>';

                    $csosn=$v['csosn'];
                    $csosn=_apenas_numeros($csosn);
                    $tamanho3=3;
                    $csosn=_myfunc_espaco_a_direita($csosn,$tamanho3) ;


                   if($crt=='1'){
                      $xcst=$csosn;
                   } else{
                      $xcst=$cst;
                   }

                   if($xcst=='030' or $xcst=='300'){
                      $picms='I   ';
                      $vicms='0000000000000';

                      $linha='60'.'D'.$dt_mapa.$serial_imp.$cprod.$qcom.$vprod.$vbc.$picms.$vicms.$branco;

                   }

                   if($xcst=='010' or $xcst=='070' or $xcst=='201' or $xcst=='202' or $xcst=='203'){
                      $picms='I   ';
                      $vicms='0000000000000';

                      $linha='60'.'D'.$dt_mapa.$serial_imp.$cprod.$qcom.$vprod.$vbc.$picms.$vicms.$branco;

                   }

                   if($xcst=='040' or $xcst=='400' or $xcst=='102' or $xcst=='103'){
                      $picms='N   ';
                      $vicms='0000000000000';

                      $linha='60'.'D'.$dt_mapa.$serial_imp.$cprod.$qcom.$vprod.$vbc.$picms.$vicms.$branco;
                   }


                   if($xcst=='060' or $xcst=='500' ){ 
                       $picms='F   ';
                       $vicms='0000000000000';

                       $linha='60'.'D'.$dt_mapa.$serial_imp.$cprod.$qcom.$vprod.$vbc.$picms.$vicms.$branco;


                   }

                   if($xcst=='000' or $xcst=='020' or $xcst=='101' or $xcst=='090' or $xcst=='900'){
                       //$picms=$picms;
                       //$vicms=$vicms;
                       if($vicms=='0000000000000'){

                          $picms=$pcredsn;
                          $vbc=$vprod;
                          $vicms=$vcredicmssn;

                       }


                       $linha='60'.'D'.$dt_mapa.$serial_imp.$cprod.$qcom.$vprod.$vbc.$picms.$vicms.$branco;
                   }

                       $qtde_linha_bloco_60D++ ;

                       $escreve = fwrite($fp, "$linha\r\n");
                       $tot_registro_bloco60D=$tot_registro_bloco60D+1;
                       $tot_60D=$tot_registro_bloco60D;


              }
                    for ($i = strlen($tot_registro_bloco60D); $i < 8; $i++) {
                         $tot_registro_bloco60D="0".$tot_registro_bloco60D;
                    }

                    $REG_BLC[602]='60D'.$tot_registro_bloco60D;
return;
}

//REGSITRO TIPO 60 ITEM (60I) ITEM DO DOCUMENTOS FISCAL EMITIDO POR TERMINAL PONTO DE VENDA (PDV) OU EQUIPAMENTO EMISSOR DE CUPOM FISCAL (ECF)
function sintegra_registro_60I($dts_mapa,$ecf_numimp){
global $info_segmento,$info_cnpj_segmento,$fp,$lanperiodo1,$lanperiodo2,$qtde_linha_bloco_60I,$REG_BLC,$tot_60I,$TMAPA_RESUMO,$TITEM_FLUXO,$tot_registro_bloco60I,$tabela_60D;

$svsub_contabil="vprod as svprod,vbcst as svbcst,vicmsst as svicmsst,vfrete as svfrete,vseg as svseg,vdesc as svdesc ,vbc as svbc,vicms as svicms,vissqn as svissqn,voutro as svoutro,vcredicmssn as svcredicmssn,pcredsn";
$svsub_isent_ntri="vbcipi as svbcipi,vipi as svipi";


$xsql="SELECT $svsub_contabil,$svsub_isent_ntri,data,ecf_numimp,qcom as sqcom,picms,cprod,cst,csosn,modelo,documento FROM $tabela_60D where data='$dts_mapa' and ecf_numimp='$ecf_numimp' order by documento,cprod";
$sql_lancamentos= mysql_query($xsql);

//$sql_lancamentos= mysql_query("select a.*,b.documento,b.dono,b.modelo,c.dono,c.cprod,c.qcom,c.vprod,c.vdesc,c.cst,c.vicms,c.picms,c.vbc from $TMAPA_RESUMO as a,tabela_lan_cnpj_50 as b,$TITEM_FLUXO as c where a.cnpjcpfseg='$info_cnpj_segmento' and a.dt_mapa BETWEEN $lanperiodo1 AND $lanperiodo2 and b.dono=c.dono and b.modelo='2D' and a.mapa='$mapa' group by c.cprod order by c.cprod,a.dt_mapa");

$tot_registro_bloco=0;
$registro=1;
$vnum='';
            while ( $v = mysql_fetch_assoc($sql_lancamentos) ) {

                    $crt=$info_segmento['crt'];

                    $dt_mapa=$v['data'];
                    $dt_mapa=_myfunc_stod($dt_mapa);
                    $dt_mapa=_myfunc_aaaammdd($dt_mapa);
                    $tamanho8=8;
                    $dt_mapa=_myfunc_zero_a_esquerda($dt_mapa,$tamanho8) ;

                    $serial_imp=$v['ecf_numimp'];
                    $tamanho20=20;
                    $serial_imp=_myfunc_espaco_a_direita($serial_imp,$tamanho20) ;

                    $modelo=$v['modelo'];
                    $tamanho2=2;
                    $modelo=_myfunc_espaco_a_direita($modelo,$tamanho2) ;

                    $numero=$v['documento'];
                    $numero = trim($numero);
                    $numero=strtoupper($numero);
                    $tamanho6=6;
                    $numero=_myfunc_zero_a_esquerda($numero,$tamanho6) ;
                    $numero = substr($numero,-6);


                    if ($numero<>$vnum){
                        $vnum=$numero;
                        $registro=1;
                    }else{
                        $registro++;
                    }

                    $num_item=$registro;
                    $tamanho3=3;
                    $num_item=_myfunc_zero_a_esquerda($num_item,$tamanho3) ;

                    $cprod=$v['cprod'];
                    $cprod = trim($cprod);
                    $cprod=strtoupper($cprod);
                    $tamanho14=14;
                    $cprod=_myfunc_espaco_a_direita($cprod,$tamanho14) ;
                    $cprod = substr($cprod,-14);

                    $qcom=$v['sqcom'];
                    $qcom=$qcom*1000;
                    $qcom=intval($qcom);
                    $qcom=_apenas_numeros($qcom);
                    $tamanho13=13;
                    $qcom=_myfunc_zero_a_esquerda($qcom,$tamanho13) ;

                    $vdesc=$v['svdesc'];
                    $vprod=$v['svprod'];

                    $vmerc=$vprod-$vdesc;
                    $vmerc=_apenas_numeros($vmerc);
                    $tamanho13=13;
                    $vmerc=_myfunc_zero_a_esquerda($vmerc,$tamanho13) ;
                    $vmerc = substr($vmerc,-13); // devido a alguns valores apresentarem mais de 13 casas

                    $vbc=$v['svbc'];
                    $vbc=_apenas_numeros($vbc);
                    $tamanho12=12;
                    $vbc=_myfunc_zero_a_esquerda($vbc,$tamanho12) ;

                    $cst=$v['cst'];
                    $cst=_apenas_numeros($cst);
                    $tamanho3=3;
                    $cst=_myfunc_espaco_a_direita($cst,$tamanho3) ;

                    $csosn=$v['csosn'];
                    $csosn=_apenas_numeros($csosn);
                    $tamanho3=3;
                    $csosn=_myfunc_espaco_a_direita($csosn,$tamanho3) ;


                    $branco='';
                    $tamanho16=16;
                    $branco=_myfunc_espaco_a_direita($branco,$tamanho16) ;


                    $picms=$v['picms'];
                    $picms=_apenas_numeros($picms);
                    $tamanho4=4;
                    $picms=_myfunc_zero_a_esquerda($picms,$tamanho4) ;

                    $pcredsn=$v['pcredsn'];
                    $pcredsn=_apenas_numeros($pcredsn);
                    $tamanho4=4;
                    $pcredsn=_myfunc_zero_a_esquerda($pcredsn,$tamanho4) ;


                    $vicms=$v['svicms'];
                    $vicms=_apenas_numeros($vicms);
                    $tamanho12=12;
                    $vicms=_myfunc_zero_a_esquerda($vicms,$tamanho12) ;

                    $vcredicmssn=$v['svcredicmssn'];
                    $vcredicmssn=_apenas_numeros($vcredicmssn);
                    $tamanho12=12;
                    $vcredicmssn=_myfunc_zero_a_esquerda($vcredicmssn,$tamanho12) ;


                   if($crt=='1'){
                      $xcst=$csosn;
                   } else{
                      $xcst=$cst;
                   }


                   if($xcst=='030' or $xcst=='300'){
                      $picms='I   ';
                      $vicms='000000000000';
                      //$linha=$linha2.$vbc.$picms.$vicms.$branco;
                      $linha='60'.'I'.$dt_mapa.$serial_imp.$modelo.$numero.$num_item.$cprod.$qcom.$vmerc.$vbc.$picms.$vicms.$branco;
                   }

                   if($xcst=='010' or $xcst=='070' or $xcst=='201' or $xcst=='202' or $xcst=='203'){
                      $picms='I   ';
                      $vicms='000000000000';
                      //$linha=$linha2.$vbc.$picms.$vicms.$branco;
                      $linha='60'.'I'.$dt_mapa.$serial_imp.$modelo.$numero.$num_item.$cprod.$qcom.$vmerc.$vbc.$picms.$vicms.$branco;

                   }

                   if($xcst=='040' or $xcst=='400' or $xcst=='102' or $xcst=='103'){
                      $picms='N   ';
                      $vicms='000000000000';
                      //$linha=$linha2.$vbc.$picms.$vicms.$branco;
                      $linha='60'.'I'.$dt_mapa.$serial_imp.$modelo.$numero.$num_item.$cprod.$qcom.$vmerc.$vbc.$picms.$vicms.$branco;
                   }


                   if($xcst=='060' or $xcst=='500' ){
                       $picms='F   ';
                       $vicms='000000000000';
                       //$linha=$linha2.$vbc.$picms.$vicms.$branco;
                       $linha='60'.'I'.$dt_mapa.$serial_imp.$modelo.$numero.$num_item.$cprod.$qcom.$vmerc.$vbc.$picms.$vicms.$branco;
                   }



                   if($xcst=='000' or $xcst=='020' or $xcst=='101' or $xcst=='090' or $xcst=='900'){
                       $picms=$picms;
                       $vicms=$vicms;
                       if($vicms=='0'){
                          $picms=$pcredsn;
                          $vicms=$vcredicmssn;

                          $vbc=$vprod-$vdesc;
                          $vbc=_apenas_numeros($vbc);
                          $tamanho12=12;
                          $vbc=_myfunc_zero_a_esquerda($vbc,$tamanho12);
                       }

                       //$linha=$linha2.$vbc.$picms.$vicms.$branco;
                       $linha='60'.'I'.$dt_mapa.$serial_imp.$modelo.$numero.$num_item.$cprod.$qcom.$vmerc.$vbc.$picms.$vicms.$branco;
                   }

                   $qtde_linha_bloco_60I++ ;

                   $escreve = fwrite($fp, "$linha\r\n");
                   $tot_registro_bloco60I=$tot_registro_bloco60I+1;
                   $tot_60I=$tot_registro_bloco60I;


              }
                    for ($i = strlen($tot_registro_bloco60I); $i < 8; $i++) {
                         $tot_registro_bloco60I="0".$tot_registro_bloco60I;
                    }

                    $REG_BLC[603]='60I'.$tot_registro_bloco60I;
return;
}


//REGISTRO TIPO 60 RESUMO MENSAL (60R) REGISTRO DE MERCADORIA/PRODUTO OU SERVI?O PROCESSADO EM EQUIPAMENTOS EMISSOR DE CUPOM FISCAL.
function sintegra_registro_60R($dts_mapa,$ecf_numimp){
global $info_segmento,$info_cnpj_segmento,$fp,$lanperiodo1,$lanperiodo2,$qtde_linha_bloco_60R,$REG_BLC,$tot_60R,$TMAPA_RESUMO,$TITEM_FLUXO,$tot_registro_bloco60I,$tabela_60D;

$svsub_contabil="sum(vprod) as svprod,sum(vbcst) as svbcst,sum(vicmsst) as svicmsst,sum(vfrete) as svfrete,sum(vseg) as svseg,sum(vdesc) as svdesc ,sum(vbc) as svbc,sum(vicms) as svicms,sum(vissqn) as svissqn,sum(voutro) as svoutro,sum(vcredicmssn) as svcredicmssn,pcredsn";
$svsub_isent_ntri="sum(vbcipi) as svbcipi, sum(vipi) as svipi";

$xsql="SELECT $svsub_contabil,$svsub_isent_ntri,data,ecf_numimp,sum(qcom) as sqcom,picms,cprod,cst,csosn,modelo,documento,substring(FROM_UNIXTIME(data,'%d/%m/%Y'),-7) as mes FROM $tabela_60D where data='$dts_mapa' and ecf_numimp='$ecf_numimp' group by cprod,mes order by cprod";
//echo "SELECT $svsub_contabil,$svsub_isent_ntri,data,ecf_numimp,sum(qcom) as sqcom,picms,cprod,cst,csosn,modelo,documento,substring(FROM_UNIXTIME(data,'%d/%m/%Y'),-7) as mes FROM $tabela_60D where data='$dts_mapa' and ecf_numimp='$ecf_numimp' group by cprod,mes order by cprod";
$sql_lancamentos= mysql_query($xsql);

$tot_registro_bloco=0;
$registro=1;
$vnum='';
            while ( $v = mysql_fetch_assoc($sql_lancamentos) ) {

                    $crt=$info_segmento['crt'];

                    $mes=$v['mes'];
                    $tamanho8=6;
                    $mes=_myfunc_zero_a_esquerda($mes,$tamanho6) ;

                    $serial_imp=$v['ecf_numimp'];
                    $tamanho20=20;
                    $serial_imp=_myfunc_espaco_a_direita($serial_imp,$tamanho20) ;

                    $cprod=$v['cprod'];
                    $cprod = trim($cprod);
                    $cprod=strtoupper($cprod);
                    $tamanho14=14;
                    $cprod=_myfunc_espaco_a_direita($cprod,$tamanho14) ;
                    $cprod = substr($cprod,-14);

                    $qcom=$v['sqcom'];
                    $qcom=_apenas_numeros($qcom);
                    $tamanho13=13;
                    $qcom=_myfunc_zero_a_esquerda($qcom,$tamanho13) ;

                    $vdesc=$v['svdesc'];
                    $vprod=$v['svprod'];

                    $vbc=$v['svbc'];
                    $vbc=_apenas_numeros($vbc);
                    $tamanho12=12;
                    $vbc=_myfunc_zero_a_esquerda($vbc,$tamanho12) ;

                    $cst=$v['cst'];
                    $cst=_apenas_numeros($cst);
                    $tamanho3=3;
                    $cst=_myfunc_espaco_a_direita($cst,$tamanho3) ;

                    $csosn=$v['csosn'];
                    $csosn=_apenas_numeros($csosn);
                    $tamanho3=3;
                    $csosn=_myfunc_espaco_a_direita($csosn,$tamanho3) ;

                    $branco='';
                    $tamanho54=54;
                    $branco=_myfunc_espaco_a_direita($branco,$tamanho54) ;

                    $picms=$v['picms'];
                    $picms=_apenas_numeros($picms);
                    $tamanho4=4;
                    $picms=_myfunc_zero_a_esquerda($picms,$tamanho4) ;

                    $pcredsn=$v['pcredsn'];
                    $pcredsn=_apenas_numeros($pcredsn);
                    $tamanho4=4;
                    $pcredsn=_myfunc_zero_a_esquerda($pcredsn,$tamanho4) ;

                    $vicms=$v['svicms'];
                    $vicms=_apenas_numeros($vicms);
                    $tamanho12=12;
                    $vicms=_myfunc_zero_a_esquerda($vicms,$tamanho12) ;


                   if($crt=='1'){
                      $xcst=$csosn;
                   } else{
                      $xcst=$cst;
                   }


                   if($xcst=='030' or $xcst=='300'){
                      $picms='I   ';
                      $vicms='000000000000';
                       $linha='60'.'R'.$mes.$cprod.$qcom.$vbc.$vicms.$picms.$branco;
                   }

                   if($xcst=='010' or $xcst=='070' or $xcst=='201' or $xcst=='202' or $xcst=='203'){
                      $picms='I   ';
                      $vicms='000000000000';
                       $linha='60'.'R'.$mes.$cprod.$qcom.$vbc.$vicms.$picms.$branco;

                   }

                   if($xcst=='040' or $xcst=='400' or $xcst=='102' or $xcst=='103'){
                      $picms='N   ';
                      $vicms='000000000000';
                       $linha='60'.'R'.$mes.$cprod.$qcom.$vbc.$vicms.$picms.$branco;
                   }


                   if($xcst=='060' or $xcst=='500' ){
                       $picms='F   ';
                       $vicms='000000000000';
                       $linha='60'.'R'.$mes.$cprod.$qcom.$vbc.$vicms.$picms.$branco;
                   }



                   if($xcst=='000' or $xcst=='020' or $xcst=='101'){
                       $picms=$picms;
                       $vicms=$vicms;
                       if($vicms=='0'){
                          $picms=$pcredsn;
                          $vicms=$vcredicmssn;

                          $vbc=$vprod-$vdesc;
                          $vbc=_apenas_numeros($vbc);
                          $tamanho12=12;
                          $vbc=_myfunc_zero_a_esquerda($vbc,$tamanho12);
                       }

                       $linha='60'.'R'.$mes.$cprod.$qcom.$vbc.$vicms.$picms.$branco;
                   }

                   $qtde_linha_bloco_60R++ ;

                   $escreve = fwrite($fp, "$linha\r\n");
                   $tot_registro_bloco60R=$tot_registro_bloco60R+1;
                   $tot_60R=$tot_registro_bloco60R;


              }
                    for ($i = strlen($tot_registro_bloco60R); $i < 8; $i++) {
                         $tot_registro_bloco60R="0".$tot_registro_bloco60R;
                    }

                    $REG_BLC[604]='60R'.$tot_registro_bloco60R;
return;
}


//Registro tipo 61
//Bilhete de Pasagem Aquaviário(modelo14)
//Bilhete de Passagem e Nota de Bagagem(modelo 15)
//Bilhete de Passagem Ferroviário(modelo 16)
//Bilhete de Passagem Rodoviário(modelo 13)
//Nota Fiscal de Venda a Consumidor(modelo 2)
//Nota Fiscal de Produtor(modelo 4)
function sintegra_registro_61(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$qtde_linha_bloco_61,$REG_BLC,$tot_61,$info_cnpj_segmento,$info_cnpj,$tabela_61;

$sum="sum(vprod) as svprod,sum(vbc) as svbc,sum(vuntrib) as svuntrib,sum(vicms) as svimcs,sum(voutro) as svoutro,max(documento) as final,min(documento) as inicial,sum(vdesc) as desconto";

$sql_lancamentos=mysql_query("select *,$sum from $tabela_61 group by data");

//echo "select *,$sum from $tabela_61 group by documento";exit;


$tot_registro_bloco=0;

        while ( $v = mysql_fetch_assoc($sql_lancamentos) ) {
                
                $brancos='';
                $tamanho28=28;
                $brancos=_myfunc_espaco_a_direita($brancos,$tamanho28);
                
                $data=$v['data'];
                   $data=_myfunc_stod($data);
                $data=_myfunc_aaaammdd($data);
                $tamanho8=8;
                $data=_myfunc_zero_a_esquerda($data,$tamanho8);
                
                $modelo=$v['modelo'];
                $tamanho2=2;
                $modelo=_myfunc_zero_a_esquerda($modelo,$tamanho2);

                
                $serie=strtoupper($v['serie']);
                $tamanho3=3;
                $serie=_myfunc_espaco_a_direita($serie,$tamanho3) ;

                $subserie='';
                $tamanho2=2;
                $subserie=_myfunc_espaco_a_direita($subserie,$tamanho2);
                
                $numero_inicial=$v['inicial'];
                $tamanho6=6;
                $numero_inicial=_myfunc_zero_a_esquerda($numero_inicial,$tamanho6);
                $numero_inicial = substr($numero_inicial,-6);

                
                $numero_final=$v['final'];
                $tamanho6=6;
                $numero_final=_myfunc_zero_a_esquerda($numero_final,$tamanho6);
                $numero_final = substr($numero_final,-6);

                          
                          $sum_prod=$v['svprod'];
                          $sum_prod=_apenas_numeros($sum_prod);
                          //echo $sum_prod;exit;
                          $sum_desconto=$v['desconto'];
                          $sum_desconto=_apenas_numeros($sum_desconto);
                          //echo $sum_desconto;exit;
                $valor_total=($sum_prod-$sum_desconto);
                          //echo $valor_total;exit;
                          $tamanho13=13;
                          $valor_total=_myfunc_zero_a_esquerda($valor_total,$tamanho13);
                          //echo $valor_total;exit;
                
                $base_icms=$v['svbc'];
                $base_icms=_apenas_numeros($base_icms);
                $tamanho13=13;
                $base_icms=_myfunc_zero_a_esquerda($base_icms,$tamanho13);
                
                $valor_icms=$v['svicms'];
                $valor_icms=_apenas_numeros($valor_icms);
                $tamanho12=12;
                $valor_icms=_myfunc_zero_a_esquerda($valor_icms,$tamanho12);
                



                $datamov=$v['data']; // Para registro 61R
                $xcst=$v['cst'];
                $csosn=$v['csosn'];

                $isenta_nao_tributada='0.00';
                $isenta_nao_tributada= sprintf("%01.2f", $isenta_nao_tributada);
                $isenta_nao_tributada=_apenas_numeros($isenta_nao_tributada);
                $tamanho13=13;
                $isenta_nao_tributada=_myfunc_zero_a_esquerda($isenta_nao_tributada,$tamanho13);
                
                //$outras=$v['svoutro'];
                $outras= $valor_total-$vbase_icms;
                $tamanho13=13;
                $outras=_myfunc_zero_a_esquerda($outras,$tamanho13);



                $aliquota='';//não está incluido no select, verificar a função do mysql
                $tamanho4=4;
                $aliquota=_myfunc_zero_a_esquerda($aliquota,$tamanho4);
                
                $brancos2='';
                $tamanho1=1;
                $brancos2=_myfunc_espaco_a_direita($brancos2,$tamanho1);
                
                $qtde_linha_bloco_61++ ;
             $tot_61++;

                
                  $linha='61'.$brancos.$data.$modelo.$serie.$subserie.$numero_inicial.$numero_final.$valor_total.$base_icms.$valor_icms.$isenta_nao_tributada.$outras.$aliquota.$brancos2;
                  $escreve = fwrite($fp, "$linha\r\n");
                  $tot_registro_bloco=$tot_registro_bloco+1;

                  

                 sintegra_registro_61R($datamov);

                 }
                  for ($i = strlen($tot_registro_bloco); $i < 8; $i++) {
                       $tot_registro_bloco="0".$tot_registro_bloco;
                 }


                 $REG_BLC[61]='61'.$tot_registro_bloco;
                 
                 
return;
}



// - Resumo Mensal por Item (61R): Registro de mercadoria/produto ou serviço comercializados através de Nota Fiscal de Produtor ou Nota Fiscal de Venda a Consumidor não emitida por ECF.
function sintegra_registro_61R($datamov){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$qtde_linha_bloco_61,$tot_registro_bloco,$REG_BLC,$tot_61,$info_cnpj_segmento,$info_cnpj,$tabela_61,$tabela_61R;

$sum="sum(qcom) as sqcom,sum(vprod) as svprod,sum(vbc) as svbc,sum(vuntrib) as svuntrib,sum(vicms) as svimcs,sum(voutro) as svoutro,sum(vdesc) as desconto";
$sql_lancamentos=mysql_query("select *,$sum from $tabela_61 where data=$datamov group by cprod,picms,data");

        //echo "select *,$sum from $tabela_61 group by cprod,picms,data";
        
        while ( $v = mysql_fetch_assoc($sql_lancamentos) ) {

                $data=$v['data'];
                   $data=_myfunc_stod($data);
                $data=_myfunc_aaaammdd($data);
                $tamanho8=8;
                $data=_myfunc_zero_a_esquerda($data,$tamanho8);
                $mesano=substr($data,4,2).substr($data,0,4);

                $cod_prod=$v['cprod'];
                $cod_prod = trim($cod_prod);
                $cod_prod=strtoupper($cod_prod);
                $tamanho14=14;
                $cod_prod=_myfunc_espaco_a_direita($cod_prod,$tamanho14) ;
                $cod_prod = substr($cod_prod,-14);

                
                $sqcom=$v['sqcom']; // Qtde total com 3 casas decimais
                $sqcom=$sqcom*1000;
                $sqcom=intval($sqcom);
                $sqcom=_apenas_numeros($sqcom);
                $tamanho13=13;
                $sqcom=_myfunc_zero_a_esquerda($sqcom,$tamanho13);


                $sum_prod=$v['svprod'];
                $sum_prod=_apenas_numeros($sum_prod);
                //$sum_desconto=$v['desconto'];
                //$sum_desconto=_apenas_numeros($sum_desconto);
                $valor_total=($sum_prod); //-$sum_desconto);
                $tamanho16=16;
                $valor_total=_myfunc_zero_a_esquerda($valor_total,$tamanho16);

                $base_icms=$v['svbc'];
                $base_icms=_apenas_numeros($base_icms);
                $tamanho16=16;
                $base_icms=_myfunc_zero_a_esquerda($base_icms,$tamanho16);

                $aliquota=$v['picms'];
                $aliquota=_apenas_numeros($aliquota);
                $tamanho4=4;
                $aliquota=_myfunc_zero_a_esquerda($aliquota,$tamanho4);

                $brancos='';
                $tamanho54=54;
                $brancos=_myfunc_espaco_a_direita($brancos,$tamanho54);

                $qtde_linha_bloco_61++ ;
                $tot_61++;
                
                $linha='61'.'R'.$mesano.$cod_prod.$sqcom.$valor_total.$base_icms.$aliquota.$brancos;
                $escreve = fwrite($fp, "$linha\r\n");
                $tot_registro_bloco=$tot_registro_bloco+1;
                }

return;
}

//REGISTRO TIPO 70
//Nota Fiscal de Servi?o de Transporte - 07
//Conhecimento de Transporte Rodovi?rio de Cargas - 08
//Conhecimento de Transporte Aquavi?rio de Cargas - 09
//Conhecimento de Transporte Ferrovi?rio de Cargas  - 11
//Conhecimento A?reo  - 10
//Conhecimento de Transporte de carga avulso  - 8B
function sintegra_registro_70(){
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS,$TCNPJCPF,$TITEM_FLUXO,$info_segmento,$qtde_linha_bloco_70,$REG_BLC,$tot_70,$info_cnpj_segmento,$tabela;

$sql_lancamentos= mysql_query("SELECT * FROM $tabela where modelo='07' or modelo='08' or modelo='09' or modelo='10' or modelo='11' or modelo='8B' or modelo='57' GROUP BY dono ORDER BY data,documento");

//$sql_lancamentos= mysql_query("select a.cnpj,a.inscricao,a.uf,b.cnpjcpf,b.data,b.modelo,b.serie,b.documento,b.valor,b.dono,c.dono,c.cfop,c.vicms,c.vbc,c.predbc from $TCNPJCPF as a, $TLANCAMENTOS as b, $TITEM_FLUXO as c where a.cnpj=b.cnpjcpf and b.cnpjcpfseg='$info_cnpj_segmento' and b.dono=c.dono and ( b.modelo='07' or b.modelo='08' or b.modelo='09' or b.modelo='10' or b.modelo='11' or b.modelo='8B' or b.modelo='57') and b.data BETWEEN $lanperiodo1 AND $lanperiodo2 group by c.dono order by a.data");
$tot_registro_bloco=0;
                  while ( $v = mysql_fetch_assoc($sql_lancamentos) ) {

                        $cnpj=$v['cnpjcpf'];
                        $tamanho14=14;
                        $cnpj=_myfunc_zero_a_esquerda($cnpj,$tamanho14) ;

                        $ie=$v['inscricao'];
                        $tamanho14=14;
                        if($ie==''){
                           $ie='ISENTO';
                        }
                        $ie=_myfunc_espaco_a_direita($ie,$tamanho14) ;

                        $data=$v['data'];
                        $data=_myfunc_stod($data);
                        $data=_myfunc_aaaammdd($data);
                        $tamanho8=8;
                        $data=_myfunc_zero_a_esquerda($data,$tamanho8) ;

                        $uf=$v['uf'];
                        $tamanho2=2;
                        $uf=_myfunc_espaco_a_direita($uf,$tamanho2) ;

                        $modelo=$v['modelo'];
                        $tamanho2=2;
                        $modelo=_myfunc_zero_a_esquerda($modelo,$tamanho2) ;

                        $serie=strtoupper($v['serie']);
                        $tamanho1=1;
                        $serie=_myfunc_espaco_a_direita($serie,$tamanho1) ;
              $serie=substr($serie,-1); 

                        if(($serie=='U' or $serie=='E' or $serie=='0') and ($modelo=='57')){
                           $serie='1';
                        }
                        $subserie='';
                        $tamanho2=2;
                        $subserie=_myfunc_espaco_a_direita($subserie,$tamanho2) ;

                        $numero=$v['documento'];
                        $numero = trim($numero);
                        $numero=strtoupper($numero);
                        $tamanho6=6;
                        $numero=_myfunc_zero_a_esquerda($numero,$tamanho6) ;
                        $numero = substr($numero,-6);

                        $cfop=$v['cfop'];
                        $tamanho4=4;
                        $cfop=_myfunc_zero_a_esquerda($cfop,$tamanho4) ;

                        $vdesc=$v['svdesc'];
                        $vprod=$v['svprod'];
                        $vicmsst=$v['svicmsst'];
                        $vfrete=$v['svfrete'];
                        $vseg=$v['svseg'];
                        $vdesc=$v['svdesc'];
                        $vipi=$v['svipi'];
                        $voutro=$v['svoutro'];
                        $vbc=$v['svbc'];

                        $vsub_contabil=$vprod+$vicmsst+$vfrete+$vseg-$vdesc+$vipi+$voutro;
                        $valor=$vsub_contabil;
                        $valor= number_format($valor, 2, '.', '');
                        $valor=_apenas_numeros($valor);
                        $tamanho13=13;
                        $valor=_myfunc_zero_a_esquerda($valor,$tamanho13) ;


                        $bcicms=$vbc;
                        $bcicms=_apenas_numeros($bcicms);
                        $tamanho14=14;
                        $bcicms=_myfunc_zero_a_esquerda($bcicms,$tamanho14) ;

                        $vicms=$v['svicms'];
                        $vicms=_apenas_numeros($vicms);
                        $tamanho14=14;
                        $vicms=_myfunc_zero_a_esquerda($vicms,$tamanho14) ;

                        $vsub_isent_ntri=0.00; //$vicmsst+$vipi;
                        $vsub_outras=abs($vsub_contabil-$vbc-$vsub_isent_ntri);
                        $vsub_outras= number_format($vsub_outras, 2, '.', '');
                        $outras=_apenas_numeros($vsub_outras);
                        $tamanho14=14;
                        $outras=_myfunc_zero_a_esquerda($outras,$tamanho14) ;

                        $isenta_naotribut=$vsub_isent_ntri;
                        $isenta_naotribut=_apenas_numeros($isenta_naotribut);
                        $tamanho14=14;
                        $isenta_naotribut=_myfunc_zero_a_esquerda($isenta_naotribut,$tamanho14) ;


                        $cif_fob='1';
                        $tamanho1=1;
                        $cif_fob=_myfunc_zero_a_esquerda($cif_fob,$tamanho1) ;

                        //if($valor<='0000000000000'){
                          //$situacao='S';
                          //}else{
                          $situacao='N';
                        //}




                  $qtde_linha_bloco_70++ ;

                  $linha='70'.$cnpj.$ie.$data.$uf.$modelo.$serie.$subserie.$numero.$cfop.$valor.$bcicms.$vicms.$isenta_naotribut.$outras.$cif_fob.$situacao;
                  $escreve = fwrite($fp, "$linha\r\n");
                  $tot_registro_bloco=$tot_registro_bloco+1;
                  $tot_70=$tot_registro_bloco;
                  }
                  for ($i = strlen($tot_registro_bloco); $i < 8; $i++) {
                       $tot_registro_bloco="0".$tot_registro_bloco;
                 }

                 $REG_BLC[70]='70'.$tot_registro_bloco;
return;
}

//REGISTROS TIPO 74  REGISTRO DE INVENT?RIO
function sintegra_registro_74() {
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$PRODUTOS_INVENTARIO,$info_segmento,$qtde_linha_bloco_74,$REG_BLC,$tot_74,$info_cnpj_segmento;
$sql_lancamentos= mysql_query("SELECT * FROM $PRODUTOS_INVENTARIO");
                  $tot_registro_bloco=0;
                  while ( $v = mysql_fetch_assoc($sql_lancamentos) ) {


                          $conta=$v['cprod'];
                          $tamanho14=14;
                          $conta=_myfunc_espaco_a_direita($conta,$tamanho14);


                          $qtd=$v['sqtotal'];
                          $qtd=_apenas_numeros($qtd);

 
                 $vprod=$v['custo_medio'];  
                          if($vprod<=0){
                             $vprod=$v['custo_documento'];  
                          }


                          $produto=$vprod*$qtd;
               $produto=number_format($produto, 0, '', '');   // ????
                          $produto=_apenas_numeros($produto);
                          $tamanho13=13;
                          $produto=_myfunc_zero_a_esquerda($produto,$tamanho13);

                          $qtd=number_format($qtd, 1, '', '');
                          $tamanho13=13;
                          $qtd=_myfunc_zero_a_esquerda($qtd,$tamanho13);

                          $cod_posse='1';

                          $cnpj=$info_cnpj_segmento;
                          $tamanho14=14;
                          $cnpj=_myfunc_espaco_a_direita($cnpj,$tamanho14);

                          //$ie=$info_segmento['ie'];
                          $ie=' ';
                          $tamanho14=14;
                          $ie=_myfunc_espaco_a_direita($ie,$tamanho14);


                          $uf=$info_segmento['uf'];
                          $tamanho2=2;
                          $uf=_myfunc_espaco_a_direita($uf,$tamanho2);

                          $branco='';
                          $tamanho45=45;
                          $branco=_myfunc_espaco_a_direita($branco,$tamanho45);

                          $data=$lanperiodo1;
                          $data=_myfunc_stod($data);
                          $data=_myfunc_aaaammdd($data);
                          $tamanho8=8;
                          $data=_myfunc_zero_a_esquerda($data,$tamanho8) ;


                          $qtde_linha_bloco_74++ ;

                          $linha='74'.$data.$conta.$qtd.$produto.$cod_posse.$cnpj.$ie.$uf.$branco;
                          $escreve = fwrite($fp, "$linha\r\n");
                          $tot_registro_bloco=$tot_registro_bloco+1;
                          $tot_74=$tot_registro_bloco;
                          }
                          for ($i = strlen($tot_registro_bloco); $i < 8; $i++) {
                          $tot_registro_bloco="0".$tot_registro_bloco;
                          }

                          $REG_BLC[74]='74'.$tot_registro_bloco;
return;
}


//REGISTROS TIPO 75  C?DIGO DE PRODUTO OU SERVI?O
function sintegra_registro_75() {
      global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$TITEM_FLUXO,$TMAPA_RESUMO,$REG_BLC,$qtde_linha_bloco_75,$tot_75,$tabela_75,$tabela_item,$box_inventario;

       

   if($box_inventario==''){
          $sql_lancamentos= mysql_query("SELECT * FROM $tabela_item where (modelo='01' or modelo='06' or modelo='55' or modelo='2D' or modelo='13' or modelo='14' or modelo='15' or modelo='16' or modelo='02' or modelo='04') group by cprod order by cprod ");


       }else{
          $sql_lancamentos= mysql_query("SELECT * FROM $tabela_75 where modelo='01' or modelo='06' or modelo='55' or modelo='2D' or modelo='02' group by conta order by conta ");
       } 



                  $tot_registro_bloco=0;
                  while ($v = mysql_fetch_assoc($sql_lancamentos)) {

                          if($box_inventario==''){
                             $data_ini=$lanperiodo1;
                             $data_ini=_myfunc_stod($data_ini);
                             $data_ini=_myfunc_aaaammdd($data_ini);
                             $tamanho8=8;
                             $data_ini=_myfunc_zero_a_esquerda($data_ini,$tamanho8) ;

                             $data_fin=$lanperiodo2;
                             $data_fin=_myfunc_stod($data_fin);
                             $data_fin=_myfunc_aaaammdd($data_fin);
                             $tamanho8=8;
                             $data_fin=_myfunc_zero_a_esquerda($data_fin,$tamanho8) ;

                             $cod_prod=$v['cprod'];
                             $cod_prod = trim($cod_prod);
                             $cod_prod=strtoupper($cod_prod);
                             $tamanho14=14;
                             $cod_prod=_myfunc_espaco_a_direita($cod_prod,$tamanho14) ;
                             $cod_prod = substr($cod_prod,-14);


                             $cod_ncm=$v['ncm'];
                             $tamanho8=8;
                             $cod_ncm=_myfunc_espaco_a_direita($cod_ncm,$tamanho8) ;

                             $descricao=substr($v['xprod'], 0, 52);
                             $tamanho53=53;
                             $descricao=_myfunc_espaco_a_direita($descricao,$tamanho53) ;

                             $un=substr($v['ucom'], 0, 5);
                             $tamanho6=6;
                             $un=_myfunc_espaco_a_direita($un,$tamanho6) ;

                             $cst=$v['cst_icms'];
                             $tamanho3=3;
                             $cst=_myfunc_zero_a_esquerda($cst,$tamanho3) ;

                             $alq_ipi=$v['pipi'];
                             $alq_ipi=_apenas_numeros($alq_ipi);
                             $tamanho5=5;
                             $alq_ipi=_myfunc_zero_a_esquerda($alq_ipi,$tamanho5) ;

                             $aliq=$v['picms'];
                             $aliq=_apenas_numeros($aliq);
                             $tamanho4=4;
                             $aliq=_myfunc_zero_a_esquerda($aliq,$tamanho4) ;

                             $red_base_calc_icms=$v['predbc'];
                             $red_base_calc_icms=_apenas_numeros($red_base_calc_icms);
                             $tamanho4=5;
                             $red_base_calc_icms=_myfunc_zero_a_esquerda($red_base_calc_icms,$tamanho4) ;

                             $base_calc_icms_st=$v['vbcst'];
                             $base_calc_icms_st=_apenas_numeros($base_calc_icms_st);
                             $tamanho13=13;
                             $base_calc_icms_st=_myfunc_zero_a_esquerda($base_calc_icms_st,$tamanho13) ;

                             $modelo=$v['modelo'];
                             $tamanho2=2;
                             $modelo=_myfunc_zero_a_esquerda($modelo,$tamanho2) ;

                          }else{

                             $data_ini=$lanperiodo1;
                             $data_ini=_myfunc_stod($data_ini);
                             $data_ini=_myfunc_aaaammdd($data_ini);
                             $tamanho8=8;
                             $data_ini=_myfunc_zero_a_esquerda($data_ini,$tamanho8) ;

                             $data_fin=$lanperiodo2;
                             $data_fin=_myfunc_stod($data_fin);
                             $data_fin=_myfunc_aaaammdd($data_fin);
                             $tamanho8=8;
                             $data_fin=_myfunc_zero_a_esquerda($data_fin,$tamanho8) ;

                             $cod_prod=$v['conta'];
                             $cod_prod = trim($cod_prod);
                             $cod_prod=strtoupper($cod_prod);
                             $tamanho14=14;
                             $cod_prod=_myfunc_espaco_a_direita($cod_prod,$tamanho14) ;
                             $cod_prod = substr($cod_prod,-14);

                             $cod_ncm=$v['ncm'];
                             $tamanho8=8;
                             $cod_ncm=_myfunc_espaco_a_direita($cod_ncm,$tamanho8) ;

                             $descricao=substr($v['descricao'], 0, 52);
                             $tamanho53=53;
                             $descricao=_myfunc_espaco_a_direita($descricao,$tamanho53) ;

                             $un=substr($v['unidade'], 0, 5);
                             $tamanho6=6;
                             $un=_myfunc_espaco_a_direita($un,$tamanho6) ;

                             $cst=$v['cst_icms'];
                             $tamanho3=3;
                             $cst=_myfunc_zero_a_esquerda($cst,$tamanho3) ;

                             $alq_ipi=$v['pipi'];
                             $alq_ipi=_apenas_numeros($alq_ipi);
                             $tamanho5=5;
                             $alq_ipi=_myfunc_zero_a_esquerda($alq_ipi,$tamanho5) ;

                             $aliq=$v['picms'];
                             $aliq=_apenas_numeros($aliq);
                             $tamanho4=4;
                             $aliq=_myfunc_zero_a_esquerda($aliq,$tamanho4) ;

                             $red_base_calc_icms=$v['predbc'];
                             $red_base_calc_icms=_apenas_numeros($red_base_calc_icms);
                             $tamanho4=5;
                             $red_base_calc_icms=_myfunc_zero_a_esquerda($red_base_calc_icms,$tamanho4) ;

                             $base_calc_icms_st=$v['vbcst'];
                             $base_calc_icms_st=_apenas_numeros($base_calc_icms_st);
                             $tamanho13=13;
                             $base_calc_icms_st=_myfunc_zero_a_esquerda($base_calc_icms_st,$tamanho13) ;

                             $modelo=$v['modelo'];
                             $tamanho2=2;
                             $modelo=_myfunc_zero_a_esquerda($modelo,$tamanho2) ;
 

                          } 

                          $linha='75'.$data_ini.$data_fin.$cod_prod.$cod_ncm.$descricao.$un.$alq_ipi.$aliq.$red_base_calc_icms.$base_calc_icms_st;
                          $escreve = fwrite($fp,"$linha\r\n");

                          $tot_registro_bloco=$tot_registro_bloco+1;
                          $tot_75=$tot_registro_bloco;
                          $qtde_linha_bloco_75++ ;

                  }
                  for ($i = strlen($tot_registro_bloco); $i < 8; $i++) {
                       $tot_registro_bloco="0".$tot_registro_bloco;
                   }
                   $REG_BLC[75]='75'.$tot_registro_bloco;

return;
}



//REGISTROS TIPO 90  TOTALIZA??O DO ARQUIVO
function sintegra_registro_90() {
global $info_segmento,$fp,$lanperiodo1,$lanperiodo2,$TLANCAMENTOS,$TCNPJCPF,$TITEM_FLUXO,$TPRODUTOS,$qtde_linha_bloco_90,$REG_BLC,$tot_10,$tot_11,$tot_50,$tot_53,$tot_54,$tot_56,$tot_60M,$tot_60A,$tot_60D,$tot_60I,$tot_61,$tot_70,$tot_74,$tot_75,$tot_90;

$cnpjmf=$info_segmento['cnpjcpf'];
$tamanho14=14;
$cnpjmf=_myfunc_zero_a_esquerda($cnpjmf,$tamanho14) ;

$ie=$info_segmento['ie'];
$tamanho14=14;
$ie=_myfunc_espaco_a_direita($ie,$tamanho14) ;


$tot_registro_bloco++;
$qtde_linha_bloco_90++;

$REG_BLC[90]=$tot_registro_bloco;
$tot_90=$tot_registro_bloco;

$branco=' ';
$tamanho5=5;
$branco=_myfunc_espaco_a_direita($branco,$tamanho5) ;


$tot56=$tot_56;
for ($i = strlen($tot56); $i < 8; $i++) {
$tot56="0".$tot56;
}

$tot60=$tot_60M+$tot_60A+$tot_60D+$tot_60I+$tot_60R;
for ($i = strlen($tot60); $i < 8; $i++) {
$tot60="0".$tot60;
}

$tot61=$tot_61;
for ($i = strlen($tot61); $i < 8; $i++) {
$tot61="0".$tot61;
}

$tot70=$tot_70;
for ($i = strlen($tot70); $i < 8; $i++) {
$tot70="0".$tot70;
}

$tot74=$tot_74;
for ($i = strlen($tot74); $i < 8; $i++) {
$tot74="0".$tot74;
}

$tot75=$tot_75;
for ($i = strlen($tot75); $i < 8; $i++) {
$tot75="0".$tot75;
}


$REG_BLC[99]=$tot_10+$tot_11+$tot_50+$tot_53+$tot_54+$tot_56+$tot_60M+$tot_60A+$tot_60D+$tot_60I+$tot_60R+$tot_61+$tot_70+$tot_74+$tot_75+$tot_90;

for ($i = strlen($REG_BLC[99]); $i < 8; $i++) {
  $REG_BLC[99]="0".$REG_BLC[99];
}

$linha='90'.$cnpjmf.$ie.$REG_BLC[50].$REG_BLC[54].'56'.$tot56.'60'.$tot60.'61'.$tot61.'70'.$tot70.'74'.$tot74.'75'.$tot75.'99'.$REG_BLC[99].$branco.$REG_BLC[90];
$escreve = fwrite($fp,"$linha\r\n");


return;
}

return;
exit;



  function  _myfunc_sql($lanperiodo1,$lanperiodo2,$movimento) {
        global $TLANCAMENTOS,$info_cnpj_segmento,$TITEM_FLUXO,$info_cnpj,$CONTITEM_FLUXO,$TCNPJCPF,$TNFDOCUMENTOS,$info_segmento; 
        $info_cnpj=$info_cnpj_segmento;
        $filtro_periodo=" and (a.data >= $lanperiodo1 and a.data <= $lanperiodo2)";
        $filtro_segmento_relatorios_a ="  and a.cnpjcpfseg='$info_cnpj_segmento' "; // filtro para consolidacao consolida??o balanco diario
        $filtro_modelos_canceladas="and a.serie<>'A' and a.serie<>'D' and POSITION(a.cod_sit IN ':02:04:05:') > 0"; 

                    $xsql_pdf="SELECT  dono,data,cnpjcpf,codnat,serie,modelo,documento,cnpjcpfseg,cod_sit FROM $TLANCAMENTOS as a WHERE lan_impostos<>'S' and serie<>'A' and serie<>'D'  $filtro_periodo  $filtro_segmento_relatorios_a group by dono";
                                                                                                   
                                                                                                  
                    //$xsql_pdf="SELECT dono,data,cnpjcpf,codnat,serie,modelo,documento,cnpjcpfseg FROM $TLANCAMENTOS as a WHERE lan_impostos<>'S' and serie<>'A' and serie<>'D'  $filtro_periodo  $filtro_segmento_relatorios_a UNION

                     $lanca_pdf='lanca_pdf_'.$info_cnpj;
                     $sql="drop table IF EXISTS $lanca_pdf";
                     if ( mysql_query($sql) or die (mysql_error()) ) {
                       }

                      $sql_tab_tmp="create table $lanca_pdf as $xsql_pdf";
                     if ( mysql_query($sql_tab_tmp) or die (mysql_error()) ) {
                     }else{
                        echo "error sql  <BR> $sql_tab_tmp";
                       }


                     $svsub_contabil="sum(vprod) as svprod,sum(vbcst) as svbcst,sum(vicmsst) as svicmsst,sum(vfrete) as svfrete,sum(vseg) as svseg,sum(vdesc) as svdesc ,sum(vbc) as svbc,sum(vicms) as svicms,sum(vissqn) as svissqn,sum(voutro) as svoutro,sum(vpis) as svpis,sum(vcofins) as svcofins";
                     $svsub_isent_ntri="sum(vbcipi) as svbcipi, sum(vipi) as svipi";


    $crt=$info_segmento['crt'];
    if($crt=='3'){    
            $xsql_pdf_lancamentos="SELECT movimento,serie,d.inscricao,d.uf,a.conta_plano,a.dono,cfop,a.data,a.cst,a.csosn,a.predbc,c.cnpjcpf,c.codnat,c.modelo,c.documento,c.cod_sit,c.cnpjcpfseg,picms,valiq_iss,0000.00 as svisent,$svsub_contabil, $svsub_isent_ntri  FROM $TITEM_FLUXO  as a ,$lanca_pdf as c ,$TCNPJCPF as d WHERE  a.cnpjcpf=d.cnpj and  a.dono=c.dono  $filtro_segmento_relatorios_a  group by a.dono,cfop,picms order by c.data,c.documento,cfop";
    }else{                                                                                                                                                                                                           
            $xsql_pdf_lancamentos="SELECT movimento,serie,d.inscricao,d.uf,a.conta_plano,a.dono,cfop,a.data,a.cst,a.csosn,a.predbc,c.cnpjcpf,c.codnat,c.modelo,c.documento,c.cod_sit,c.cnpjcpfseg,picms,valiq_iss,0000.00 as svisent,$svsub_contabil, $svsub_isent_ntri  FROM $TITEM_FLUXO  as a ,$lanca_pdf as c ,$TCNPJCPF as d WHERE  a.cnpjcpf=d.cnpj and  a.dono=c.dono  $filtro_segmento_relatorios_a  group by a.dono,cfop,csosn,picms order by c.data,c.documento,cfop";
                                                                                                                                                                                                                    
    }
                     $lancamentos_pdf='lancamentos_pdf_'.$info_cnpj;
                     $sql="drop table IF EXISTS     $lancamentos_pdf";
                     if ( mysql_query($sql) or die (mysql_error()) ) {
                     }

                     $sel_movimento_periodo = mysql_query("$xsql_pdf_lancamentos",$CONTITEM_FLUXO);
                     $sql_tab_tmp="create table $lancamentos_pdf as $xsql_pdf_lancamentos";
                     if ( mysql_query($sql_tab_tmp) or die (mysql_error()) ) {
                     }else{
                        echo "error sql  <BR> $sql_tab_tmp";
                       }


                     //$sql_canc=mysql_query("SELECT a.dono,a.data,b.cnpjcpf,b.codnat,a.serie,a.modelo,a.numero,b.cnpjcpfseg,d.inscricao,d.uf from $TNFDOCUMENTOS as a, $TLANCAMENTOS as b,$TCNPJCPF as d where cancela_cstat='101' and a.dono=b.dono and b.cnpjcpf=d.cnpj $filtro_periodo $filtro_segmento_relatorios_a $filtro_modelos_canceladas group by a.dono");
                     $sql_canc=mysql_query("SELECT a.dono,a.data,a.cnpjcpf,a.codnat,a.serie,a.modelo,a.documento,a.cnpjcpfseg,a.cod_sit,d.inscricao,d.uf FROM $TLANCAMENTOS as a,$TCNPJCPF as d WHERE lan_impostos<>'S' and a.cnpjcpf=d.cnpj $filtro_modelos_canceladas  $filtro_periodo  $filtro_segmento_relatorios_a group by a.dono");

                     //echo "SELECT  a.dono,a.data,a.cnpjcpf,a.codnat,a.serie,a.modelo,a.documento,a.cnpjcpfseg,a.cod_sit,d.inscricao,d.uf FROM $TLANCAMENTOS as a,$TCNPJCPF as d WHERE lan_impostos<>'S' and a.cnpjcpf=d.cnpj $filtro_modelos_canceladas  $filtro_periodo  $filtro_segmento_relatorios_a group by dono";

                     while ($vcanc = mysql_fetch_assoc($sql_canc)) {
                            $xdono=$vcanc['dono'];
                            $xdata=$vcanc['data'];
                            $xcnpjcpf=$vcanc['cnpjcpf'];
                            $xcodnat=$vcanc['codnat'];
                            $xserie=$vcanc['serie'];
                            $xmodelo=$vcanc['modelo'];
                            $xdocumento=$vcanc['documento'];
                            $xcnpjcpfseg=$vcanc['cnpjcpfseg'];
                            $xcod_sit=$vcanc['cod_sit'];
                            $xie=$vcanc['inscricao'];
                            $xuf=$vcanc['uf'];
                            if($xuf==$info_segmento['uf']){ // uf da empresa usuária
                               $xcfop='5102'; //Mesma UF
                            }else{
                               $xcfop='6102'; //Fora UF
                            }

                              $sql_reg="INSERT INTO $lancamentos_pdf (dono,data,cnpjcpf,codnat,serie,modelo,documento,cnpjcpfseg,cod_sit,inscricao,uf,cfop) value ('$xdono','$xdata','$xcnpjcpf','$xcodnat','$xserie','$xmodelo','$xdocumento','$xcnpjcpfseg','$xcod_sit','$xie','$xuf','$xcfop')";
                            if (mysql_query($sql_reg) or die (mysql_error()) ) {
                            }
                            
                    }



                       $sql_csosn="update $lancamentos_pdf set csosn='500' where csosn='102'";
                    if (mysql_query($sql_csosn) or die (mysql_error()) ) {
                    }
                       $sql_is="update $lancamentos_pdf set svisent=svprod where csosn='400'";
                    if (mysql_query($sql_is) or die (mysql_error()) ) {
                    }


                     $sql="drop table IF EXISTS $lanca_pdf";  // apaga anterior
                     if ( mysql_query($sql) or die (mysql_error()) ) {
                     }
                     return $lancamentos_pdf;
}


function  _myfunc_sql_item($lanperiodo1,$lanperiodo2,$movimento) {
        global $TLANCAMENTOS,$info_cnpj_segmento,$TITEM_FLUXO,$info_cnpj,$CONTITEM_FLUXO,$TCNPJCPF;
        $filtro_periodo=" and (a.data >= $lanperiodo1 and a.data <= $lanperiodo2)";
        $filtro_segmento_relatorios_a ="  and a.cnpjcpfseg='$info_cnpj_segmento' "; // filtro para consolidacao consolida??o balanco diario

        $xsql_pdf="SELECT dono,data,cnpjcpf,codnat,serie,modelo,documento,cnpjcpfseg FROM $TLANCAMENTOS as a WHERE lan_impostos<>'S' and serie<>'A' $filtro_periodo $filtro_pdf $filtro_segmento_relatorios_a group by dono";
        //$xsql_pdf="SELECT dono,data,cnpjcpf,codnat,serie,modelo,documento,cnpjcpfseg FROM $TLANCAMENTOS as a WHERE lan_impostos<>'S' and serie<>'A' and serie<>'D' $filtro_periodo $filtro_pdf $filtro_segmento_relatorios_a group by dono";

        //echo "<br>".$xsql_pdf;
        //exit;

        $lanca_pdf='lanca_pdf_item_'.$info_cnpj;
        $sql="drop table IF EXISTS $lanca_pdf";
        if ( mysql_query($sql) or die (mysql_error()) ) {
        }

        $sql_tab_tmp="create table $lanca_pdf as $xsql_pdf";
        if ( mysql_query($sql_tab_tmp) or die (mysql_error()) ) {
        }else{
            echo "error sql  <BR> $sql_tab_tmp";
        }

        $xsql_pdf_lancamentos="SELECT a.*,c.codnat,c.modelo,c.documento,c.serie FROM $TITEM_FLUXO as a ,$lanca_pdf as c WHERE  a.dono=c.dono  $filtro_segmento_relatorios_a order by c.data,c.documento,dono ";

//echo $xsql_pdf_lancamentos;
//exit;

        $lancamentos_pdf='lancamentos_pdf_item_'.$info_cnpj;
        $sql="drop table IF EXISTS     $lancamentos_pdf";
           if ( mysql_query($sql) or die (mysql_error()) ) {
          }
        $sel_movimento_periodo = mysql_query("$xsql_pdf_lancamentos",$CONTITEM_FLUXO);

        $sql_tab_tmp="create table $lancamentos_pdf as $xsql_pdf_lancamentos";
        if ( mysql_query($sql_tab_tmp) or die (mysql_error()) ) {
        }else{
            echo "error sql  <BR> $sql_tab_tmp";
        }

        $sql="drop table IF EXISTS $lanca_pdf";  // apaga anterior
        if ( mysql_query($sql) or die (mysql_error()) ) {
          }
        return $lancamentos_pdf;
}




 function  _myfunc_sql_60D($lanperiodo1,$lanperiodo2,$movimento) {

        global $TLANCAMENTOS,$info_cnpj_segmento,$TITEM_FLUXO,$info_cnpj,$CONTITEM_FLUXO,$TCNPJCPF,$TNFDOCUMENTOS;
        $filtro_periodo=" and (a.data >= $lanperiodo1 and a.data <= $lanperiodo2)";
        $filtro_segmento_relatorios_a ="  and a.cnpjcpfseg='$info_cnpj_segmento' "; // filtro para consolidacao consolida??o balanco diario

        $xsql_pdf="SELECT  a.dono,a.data,a.cnpjcpf,a.codnat,a.serie,a.modelo,a.documento,b.ecf_numcaixa,b.ecf_numimp FROM $TLANCAMENTOS as a, $TNFDOCUMENTOS as b WHERE a.dono=b.dono and a.lan_impostos<>'S' and a.movimento='RECEITAS' and a.modelo='2D'  $filtro_periodo   $filtro_pdf $filtro_segmento_relatorios_a group by dono";
        //echo "SELECT  a.dono,a.data,a.cnpjcpf,a.codnat,a.serie,a.modelo,a.documento,b.ecf_numcaixa,b.ecf_numimp FROM $TLANCAMENTOS as a, $TNFDOCUMENTOS as b WHERE a.dono=b.dono and a.lan_impostos<>'S' and a.movimento='RECEITAS' and a.modelo='2D'  $filtro_periodo   $filtro_pdf $filtro_segmento_relatorios_a group by dono";
        //exit;

        $lanca_pdf='lanca_pdf_60D_'.$info_cnpj;
        $sql="drop table IF EXISTS $lanca_pdf";
        if ( mysql_query($sql) or die (mysql_error()) ) {
        }

        $sql_tab_tmp="create table $lanca_pdf as $xsql_pdf";
        if ( mysql_query($sql_tab_tmp) or die (mysql_error()) ) {
        }else{
                echo "error sql  <BR> $sql_tab_tmp";
        }

        $xsql_pdf_lancamentos="SELECT a.*,c.codnat,c.modelo,c.documento,c.serie,c.ecf_numimp,c.ecf_numcaixa FROM $TITEM_FLUXO  as a ,$lanca_pdf as c WHERE  a.dono=c.dono  $filtro_segmento_relatorios_a ";
        //echo $xsql_pdf_lancamentos;
        //exit;

        $lancamentos_pdf='lancamentos_pdf_60D_'.$info_cnpj;

        $sql="drop table IF EXISTS     $lancamentos_pdf";
        if ( mysql_query($sql) or die (mysql_error()) ) {
        }
        $sel_movimento_periodo = mysql_query("$xsql_pdf_lancamentos",$CONTITEM_FLUXO);

        $sql_tab_tmp="create table $lancamentos_pdf as $xsql_pdf_lancamentos";
        if ( mysql_query($sql_tab_tmp) or die (mysql_error()) ) {
        }else{
            echo "error sql  <BR> $sql_tab_tmp";
        }

         $sql="drop table IF EXISTS $lanca_pdf";  // apaga anterior
           if ( mysql_query($sql) or die (mysql_error()) ) {
          }
        return $lancamentos_pdf;
}


function  _myfunc_sql_61($lanperiodo1,$lanperiodo2,$movimento) {

global $TLANCAMENTOS,$info_cnpj_segmento,$TITEM_FLUXO,$info_cnpj,$CONTITEM_FLUXO,$TCNPJCPF,$TNFDOCUMENTOS;
        $filtro_periodo=" and (data >= $lanperiodo1 and data <= $lanperiodo2)";
        $filtro_segmento_relatorios_a ="  and cnpjcpfseg='$info_cnpj_segmento' "; 
        

$xsql_pdf="select data,cnpjcpf,cnpjcpfseg,valor,documento,dono,movimento,serie,modelo from lancamentos where (modelo='13' or modelo='14' or modelo='15' or modelo='16' or modelo='02' or modelo='04') $filtro_periodo $filtro_segmento_relatorios_a and movimento='RECEITAS'  group by dono";
                                                                                                                                                                                                                           
//echo $xsql_pdf;
//exit; 


                                              $lanca_pdf='lanca_pdf_61_'.$info_cnpj;
                             $sql="drop table IF EXISTS $lanca_pdf";
                                if ( mysql_query($sql) or die (mysql_error()) ) {
                              }



                         $sql_tab_tmp="create table $lanca_pdf as $xsql_pdf";
                         //echo "create table $lanca_pdf as $xsql_pdf";

//exit;

                        if ( mysql_query($sql_tab_tmp) or die (mysql_error()) ) {
                               }else{
                            echo "error sql  <BR> $sql_tab_tmp";
                          }
                        


                        $xsql_pdf_lancamentos="select a.*,b.vprod,b.vuntrib,b.voutro,b.vbc,b.vicms,b.picms,b.vdesc,b.cprod,b.qcom,b.cst,b.csosn from $lanca_pdf as a,item_fluxo as b where a.dono=b.dono";

                                       //echo $xsql_pdf_lancamentos;exit;
                        
                        $lancamentos_pdf='lancamentos_pdf_61_'.$info_cnpj;

                             $sql="drop table IF EXISTS     $lancamentos_pdf";
                                if ( mysql_query($sql) or die (mysql_error()) ) {
                              }
                        $sel_movimento_periodo = mysql_query("$xsql_pdf_lancamentos",$CONTITEM_FLUXO);



                        $sql_tab_tmp="create table $lancamentos_pdf as $xsql_pdf_lancamentos";

                        if ( mysql_query($sql_tab_tmp) or die (mysql_error()) ) {
                               }else{
                            echo "error sql  <BR> $sql_tab_tmp";
                          }

                        $sql="drop table IF EXISTS $lanca_pdf";
                            if ( mysql_query($sql) or die (mysql_error()) ) {
                          }
                        return $lancamentos_pdf;
        
}



function  _myfunc_sql_61R($lanperiodo1,$lanperiodo2,$movimento) {
global $TLANCAMENTOS,$info_cnpj_segmento,$TITEM_FLUXO,$info_cnpj,$CONTITEM_FLUXO,$TCNPJCPF,$TNFDOCUMENTOS;
        $filtro_periodo=" and (data >= $lanperiodo1 and data <= $lanperiodo2)";
        $filtro_segmento_relatorios_a ="  and cnpjcpfseg='$info_cnpj_segmento' ";

$xsql_pdf="select data,cnpjcpf,cnpjcpfseg,valor,documento,dono,movimento,serie,modelo from lancamentos where (modelo='13' or modelo='14' or modelo='15' or modelo='16' or modelo='02' or modelo='04') $filtro_periodo $filtro_segmento_relatorios_a and movimento='RECEITAS'  group by dono";
         
                        $lanca_pdf='lanca_pdf_61R_'.$info_cnpj;
                        $sql="drop table IF EXISTS $lanca_pdf";
                        if ( mysql_query($sql) or die (mysql_error()) ) {
                          }

                         $sql_tab_tmp="create table $lanca_pdf as $xsql_pdf";

                        if ( mysql_query($sql_tab_tmp) or die (mysql_error()) ) {
                           }else{
                            echo "error sql  <BR> $sql_tab_tmp";
                          }

                        $xsql_pdf_lancamentos="select a.*,b.vprod,b.vuntrib,b.voutro,b.vbc,b.vicms,b.picms,b.vdesc,b.cprod,b.qcom,b.cst,b.csosn from $lanca_pdf as a,item_fluxo as b where a.dono=b.dono";

                        $lancamentos_pdf='lancamentos_pdf_61R_'.$info_cnpj;

                        $sql="drop table IF EXISTS     $lancamentos_pdf";
                        if ( mysql_query($sql) or die (mysql_error()) ) {
                          }
                        $sel_movimento_periodo = mysql_query("$xsql_pdf_lancamentos",$CONTITEM_FLUXO);

                        $sql_tab_tmp="create table $lancamentos_pdf as $xsql_pdf_lancamentos";

                        if ( mysql_query($sql_tab_tmp) or die (mysql_error()) ) {
                               }else{
                            echo "error sql  <BR> $sql_tab_tmp";
                          }

                        $sql="drop table IF EXISTS $lanca_pdf";
                        if ( mysql_query($sql) or die (mysql_error()) ) {
                          }
                        return $lancamentos_pdf;

}




function  _myfunc_sql_75($lanperiodo1,$lanperiodo2,$movimento) {

        global $TLANCAMENTOS,$info_cnpj_segmento,$TITEM_FLUXO,$info_cnpj,$CONTITEM_FLUXO,$TCNPJCPF,$PRODUTOS_INVENTARIO,$TPRODUTOS,$tabela_item,$tabela_61;
              //$filtro_periodo=" and (b.datamov >= $lanperiodo1 and b.datamov <= $lanperiodo2)";


                     
                            $xsql_pdf="SELECT a.*,b.cprod,b.datamov from $TPRODUTOS as a, $PRODUTOS_INVENTARIO as b where a.conta=b.cprod";

//echo $xsql_pdf;
//exit;

                             $lanca_pdf='lanca_pdf_75_'.$info_cnpj;
                             $sql="drop table IF EXISTS $lanca_pdf";
                                if ( mysql_query($sql) or die (mysql_error()) ) {
                              }



                         $sql_tab_tmp="create table $lanca_pdf as $xsql_pdf";

                        if ( mysql_query($sql_tab_tmp) or die (mysql_error()) ) {
                               }else{
                            echo "error sql  <BR> $sql_tab_tmp";
                          }



                         $xsql_pdf_lancamentos="select conta,descricao,unidade,ncm,cst_icms,00 as vbcst,00 as pipi,00 as picms,55 as modelo,00 as predbc from $lanca_pdf union (select cprod,xprod,ucom,ncm,cst,vbcst,pipi,picms,modelo,predbc from $tabela_item  group by cprod order by cprod)";



//echo $xsql_pdf_lancamentos;
//exit;


                        $lancamentos_pdf='lancamentos_pdf_75_'.$info_cnpj;

                             $sql="drop table IF EXISTS     $lancamentos_pdf";
                                if ( mysql_query($sql) or die (mysql_error()) ) {
                              }



                        $sql_tab_tmp="create table $lancamentos_pdf as $xsql_pdf_lancamentos";

                        if ( mysql_query($sql_tab_tmp) or die (mysql_error()) ) {
                               }else{
                            echo "error sql  <BR> $sql_tab_tmp";
                          }



                         $sql="drop table IF EXISTS $lanca_pdf";  // apaga anterior
                            if ( mysql_query($sql) or die (mysql_error()) ) {
                          }
                        return $lancamentos_pdf;

}


?> 
