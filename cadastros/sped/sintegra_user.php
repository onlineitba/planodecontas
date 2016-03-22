<?
session_start();
if ( !$_SESSION['ADMIN']['logado'] ) {
   header("Location: ..\index.php");
  exit;
}

 

?>
 

<head>
<script language="javascript">

function _CloseOnEsc() {
    if (event.keyCode == 27) { window.close(); return; }
}

function Init() {
    document.body.onkeypress = _CloseOnEsc;
}


</script>

</head>
<body bgcolor="#000000" topmargin=0 leftmargin=0 onload="Init()">

 
 <?

 


        $title='SINTEGRA registros';
   
                  $campomestre='sintegra_registros';
                  
      

$contasplano='SINTEGRA registros';

$oquelistar="<center><font size=2><u>$contasplano</u></font></center>";
        ?>
<html STYLE="width: 350px; height: 120px">
<head>



<link rel="stylesheet" type="text/css" href="estilo.css" />
</head>
<body bgcolor="#000000" topmargin=0 leftmargin=0 >



<center>

  <?


// Remover
$contasdefinidas='';
if ( $_POST ) {

        // limpar todas
         $sql = "UPDATE $TSEGMENTOS SET $campomestre='' WHERE cnpjcpf='$info_cnpj_segmento' ";
         $ok=mysql_query($sql,  $CONTSEGMENTOS);



        $contasdefinidas='';
		if ( count($_POST['del_chk']) > 0 ) {

				foreach ($_POST['del_chk'] as $var)
						$ids[] = BASICO::trata_var($var, string);

  			$n = count($ids);
				if ( ($n > 0) && is_array($ids) ) {

						for ($i = 0; $i < $n; $i++) {

                            $contasdefinidas=':'.$ids[$i].':'.$contasdefinidas;

						}

				}

				}
				 if (strlen($contasdefinidas)>200) {
				 
				     	BASICO::aviso('Favor conferir se realmente a empresa utiliza todas estas aliquotas. Caso afirmativo favor entrar em contato com suporte.<br>PS: Escolha apenas a que a empresa usar, isto facilita para entrada de documentos na hora de escolher a aliquota desejada.');
				 }else{
				 
		                  $sql = "UPDATE $TSEGMENTOS SET $campomestre='$contasdefinidas'  WHERE cnpjcpf='$info_cnpj_segmento'";
		                   	// Atualização Realizada
					    	if ( mysql_query($sql,  $CONTSEGMENTOS) ) {
						 		BASICO::aviso("Atualização das aliquotas de $qual_aliquota realizada com sucesso!", "Aviso");
						        // Atualização não pôde ser realizada
						    } else {
								BASICO::aviso('Problemas ao realizar a Atualização!<br>Tente submeter o Formulário novamente.');
						    }
		
		    }


}



 
//  ler de segmentos , quais contas definidas em
// SINTEGRA_REGISTROS

$sel_contas = mysql_query("SELECT $campomestre FROM $TSEGMENTOS  WHERE cnpjcpf='$info_cnpj_segmento'",$CONTSEGMENTOS);
if ( mysql_num_rows($sel_contas) > 0 ) {
   $contasdefinidas = mysql_result($sel_contas, 0, "$campomestre");
}
 

?>





<link rel="stylesheet" type="text/css" href="estilo.css" />





<table width='600' align='LEFT' class='tab_main'  >


<form action=logado.php?<?=$_SERVER["QUERY_STRING"];?> name="fdeleta"  method="post">

	<tr>
	  <td colspan='2' align='LEFT' class='cel_tit'> <? echo $oquelistar; ?> </td>

	</tr>
	<tr align='center'>
	    <td width='5'  class='cel_subtit'></td>
		<td width='590'   class='cel_subtit'>REGISTROS</td>

	</tr>



	<?
 
 



		 $m_sintegra_user = MATRIZ::m_sintegra_registros();
 		 $br="";
  		

 foreach ($m_sintegra_user as $k => $v) {



                           $xchecked='';
       				  $contaprocurar=':'.trim($k).':';
                         
                           $class = ( $class == 'cel_par' ) ? 'cel_impar' : 'cel_par';
                           if (eregi($contaprocurar,$contasdefinidas)) {
                              $xchecked='checked';
                           }
                           echo "<tr class='$class' align='left'>";
                           echo "&nbsp;<td>";
                           echo "<input type='checkbox' name='del_chk[]' value='$k'  $xchecked > $k ";
                           echo "</td><td align=LEFT>  ";
                           echo  $v;;
                           echo "</td></tr>";
                           $ki=$ki+$incrementar_aliquota;
                   }
                   
                   ?>
	<tr>
	  <td colspan='1' class='cel_par'><input type='checkbox' name='br' id='marca_todos' onclick='checkaTodos();'><label for='marca_todos'> <b>Selecionar todos</b></label></td>
		<td colspan='1' class='cel_par' align='right'>
         <input type='button' onclick='confirma_definecontas();' value='Definir contas selecionadas' class='botao'></td>
	</tr>

</table>
</FORM>
</body></html>













