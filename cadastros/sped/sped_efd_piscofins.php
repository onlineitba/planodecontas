<?

/*
  Código do Leiaute	Versão do Leiaute	Data de Início	Data de Fim
002	101	01012011	30062012
003	101	01072012
versao 1.17 - Outubro de 2014

09/02/2015
	
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
 * @name      sped_efd_piscofins.php
 * @version   2.0  20121009
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL v.3
 * @copyright 2012 &copy; PLANO D/C
 * @link      http:planodecontas.net
 * @author    Walber S Sales <eng.walber at gmail dot com>

*        CONTRIBUIDORES (em ordem alfabetica):

 *        AUREO NEVES DE SOUZA JUNIOR <onlinesistema at hotmail.com.br>
 *	  PATRICIA BERNARDES BARCELOS <tyssa_bernardes at hotmail.com>


*/

 

 
include('segmentos_infotitulo.php');
$info_segmento=$infotitulo;
 

 
    $pcrazaosocial=$infotitulo['razaosocial'];
 
 
 
 
include('periodo.php');




if ($_POST[btfiltro_balancete]) {  //clicou em processar

     
 
	$xarq=$info_cnpj.'_'._myfunc_ddmmaaaa($lanperiodo1).'_'._myfunc_ddmmaaaa($lanperiodo2).'.txt'; 
	$nome_do_arquivo_dir='../nfefiles/'.$cnpjcpf_segmento.'/spedtxt/piscofins_'.$xarq;
	$nome_do_arquivo_down='../nfefiles/'.$cnpjcpf_segmento.'/spedtxt/piscofins_'.$xarq;
 
        $perdtos1=_myfunc_dtos($lanperiodo1);
        $perdtos2=_myfunc_dtos($lanperiodo2);
        $dt_ini=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo1));
        $dt_fin=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo2));
 
        $filtromovimento="where (cnpjcpfseg='$info_cnpj_segmento' )";

 
	// grava flag do pis-cofins
	$xcnpjcpfseg=$infocnpj_segmento;
	$cod_ver=$_POST[cod_ver];
	$tipo_escrit=$_POST[tipo_escrit];
	$ind_sit_esp=$_POST[ind_sit_esp];
	$ind_nat_pj=$_POST[ind_nat_pj];
	$ind_ativ=$_POST[ind_ativ];
        $num_rec_anterior=$_POST[num_rec_anterior];

	$cod_inc_trib=$_POST[cod_inc_trib];
	$ind_apro_cred=$_POST[ind_apro_cred];
	$cod_tipo_cont=$_POST[cod_tipo_cont];
	$ind_reg_cum=$_POST[ind_reg_cum];
 

	$sel_existe = mysql_query("SELECT *  FROM $TSPED_PISCOFINS WHERE cnpjcpfseg = '$info_cnpj_segmento'",$CONTSPED_PISCOFINS);
	if ( mysql_num_rows($sel_existe) ) { 						
		$sql = "update $TSPED_PISCOFINS set cnpjcpfseg='$info_cnpj_segmento',cod_ver='$cod_ver',tipo_escrit='$tipo_escrit',ind_sit_esp='$ind_sit_esp',ind_nat_pj='$ind_nat_pj',ind_ativ='$ind_ativ',num_rec_anterior='$num_rec_anterior',cod_inc_trib='$cod_inc_trib',ind_apro_cred='$ind_apro_cred',cod_tipo_cont='$cod_tipo_cont',ind_reg_cum='$ind_reg_cum' WHERE cnpjcpfseg = '$info_cnpj_segmento'";
	}else{
		$sql = "INSERT INTO $TSPED_PISCOFINS (cnpjcpfseg,cod_ver,tipo_escrit,ind_sit_esp,ind_nat_pj,ind_ativ,num_rec_anterior,cod_inc_trib,ind_apro_cred,cod_tipo_cont,ind_reg_cum) VALUES ('$info_cnpj_segmento','$cod_ver','$tipo_escrit','$ind_sit_esp','$ind_nat_pj','$ind_ativ','$num_rec_anterior','$cod_inc_trib','$ind_apro_cred','$cod_tipo_cont','$ind_reg_cum')";
	}

	if (mysql_query($sql,$CONTSPED_PISCOFINS)) {
	//ECHO "OK";
	}ELSE{
	ECHO "$sql -NO SQL";
	}


/*
  Código do Leiaute	Versão do Leiaute	Data de Início	Data de Fim
002	101	01012011	30062012
003	101	01072012	
versao 1.17 - Outubro de 2014
*/
	
	$per1_ver_02=_myfunc_dtos('01/01/2011');
	$per2_ver_02=_myfunc_dtos('30/06/2012');

	$per1_ver_03=_myfunc_dtos('01/07/2012');
	$per2_ver_03=_myfunc_dtos('31/12/2016');
 
	$cod_ver='';


	if ($perdtos1>=$per1_ver_02 and $perdtos2<=$per2_ver_02) {
		$cod_ver='002';

	}
	if ($perdtos1>=$per1_ver_03 and $perdtos2<=$per2_ver_03) {
		$cod_ver='003';

	}
 
	if ($cod_ver=='') {
	   echo "<br><font size=2 color=red>Período informado não contempla esta versão</font>";
		ECHO _myfuncoes_voltar_pagina();
		EXIT;	

}else{
						

	// abe arquivo para w-gravaçao

	_myfunc_liga_id_processando("P R O C E S S A N D O ");

	flush();

	$fp = fopen("$nome_do_arquivo_dir", "w"); 
	include('sped_efd_piscofins_funcoes.php');
	fclose($fp);
	 _myfunc_desliga_id_processando(''); 
	_myfunc_desliga_id_processando('Final de processamento!');
	flush();
   }
}


$dados_sped_piscofins=_myfunc_dados_sped_piscofis() ;
    
 ?>
 
 
 


<form action=logado.php?<?=$_SERVER["QUERY_STRING"];?>#ancora_link method=post name='fcontlancamento'>
 
<table border=3 cellspacing="2" cellpadding="4" >
<tr>
<td colspan=2 align=center>
<br>
<font color=blue size='4'>SPED - EFD CONTRIBUIÇÕES</font><br> <font color=blue>
<br>
</td>
</tr>

<tr>
	  <td align='right'>Código da versão do leiaute</td>
		<td>
		<?
		$cod_ver=$dados_sped_piscofins[cod_ver];

		if (empty($cod_ver)) {
			$cod_ver='003';
		}
		?>

		<input type='text'  readonly  name='cod_ver' value='<?=$cod_ver;?>'  style='width: 40px; font: normal 12 verdana;' maxlength='3'>
          </td>
</tr>

<tr>
<td align=right>
Tipo de escrituração &nbsp;&nbsp;
</td>
<td>

<?
$tipo_escrit=$dados_sped_piscofins['tipo_escrit'];
IF (EMPTY($tipo_escrit)) {
   $tipo_escrit='0';
}
$num_rec_anterior=$dados_sped_piscofins[num_rec_anterior];
 
?>
            <? $chk_x[$tipo_escrit] = 'checked'; ?>
		    <input type="radio" name="tipo_escrit" value='0' <?=$chk_x['0'];?>> 0 - Remessa do arquivo original;
            <br>
            <input type="radio" name="tipo_escrit" value='1' <?=$chk_x['1'];?>> 1 - Remessa do arquivo retificadora.
            &nbsp;
	    N.R.A <input type='text' name='num_rec_anterior' value='<?=$num_rec_anterior;?>'  style='width: 190px; font: normal 12 verdana;' maxlength='41'>
</td>
</tr>

<tr>
	  <td align='right'>Indicador de situação especial</td>
		<td>

   <? $chk_ind_sit_esp[$dados_sped_piscofins[ind_sit_esp]] = 'selected'; ?>
		  <? $m_ind_sit_esp = MATRIZ::m_ind_sit_esp(); ?>
			<select name='ind_sit_esp'   >
			        <?
			        foreach ($m_ind_sit_esp as $k => $v) {
			        ?>
			        <option value=<?=$k;?> <?=$chk_ind_sit_esp[$k];?> ><?=$k. ' - '. $v;?></option>
			        <?

                    }
                    ?>

			</select>

 
			</td>
	</tr>
 
<tr>

<tr>
	  <td align='right'>Indicador da natureza da pessoa jurídica
</td>
		<td>

   <? $chk_ind_nat_pj[$dados_sped_piscofins[ind_nat_pj]] = 'selected'; ?>
		  <? $m_ind_nat_pj = MATRIZ::m_ind_nat_pj(); ?>
			<select name='ind_nat_pj'   >
			        <?
			        foreach ($m_ind_nat_pj as $k => $v) {
			        ?>
			        <option value=<?=$k;?> <?=$chk_ind_nat_pj[$k];?> ><?=$k. ' - '. $v;?></option>
			        <?

                    }
                    ?>

			</select>

 
			</td>
	</tr>
 
<tr>

<tr>
	  <td align='right'>Indicador de tipo de atividade preponderante
</td>
		<td>


   <? $chk_ind_ativ[$dados_sped_piscofins[ind_ativ]] = 'selected'; ?>
		  <? $m_ind_ativ = MATRIZ::m_ind_ativ(); ?>
			<select name='ind_ativ'   >
			        <?
			        foreach ($m_ind_ativ as $k => $v) {
			        ?>
			        <option value=<?=$k;?> <?=$chk_ind_ativ[$k];?> ><?=$k. ' - '. $v;?></option>
			        <?

                    }
                    ?>

			</select>

 
			</td>
	</tr>
 
 
<tr>
	  <td align='right'>Código indicador da incidencia tributária no período
</td>
		<td>


   <? $chk_cod_inc_trib[$dados_sped_piscofins[cod_inc_trib]] = 'selected'; ?>
		  <? $m_cod_inc_trib = MATRIZ::m_cod_inc_trib(); ?>
			<select name='cod_inc_trib'   >
			        <?
			        foreach ($m_cod_inc_trib as $k => $v) {
			        ?>
			        <option value=<?=$k;?> <?=$chk_cod_inc_trib[$k];?> ><?=$k. ' - '. $v;?></option>
			        <?

                    }
                    ?>

			</select>

 
			</td>
	</tr>

<tr>
	  <td align='right'>Código indicador de método de apropriação de créditos comuns 
</td>
		<td>


   <? $chk_ind_apro_cred[$dados_sped_piscofins[ind_apro_cred]] = 'selected'; ?>
		  <? $m_ind_apro_cred = MATRIZ::m_ind_apro_cred(); ?>
			<select name='ind_apro_cred'   >
			        <?
			        foreach ($m_ind_apro_cred as $k => $v) {
			        ?>
			        <option value=<?=$k;?> <?=$chk_ind_apro_cred[$k];?> ><?=$k. ' - '. $v;?></option>
			        <?

                    }
                    ?>

			</select>

 
			</td>
	</tr>
 
  <tr>
	  <td align='right'>Código indicador do Tipo de Contribuição Apurada no Período
</td>
		<td>


   <? $chk_cod_tipo_cont[$dados_sped_piscofins[cod_tipo_cont]] = 'selected'; ?>
		  <? $m_cod_tipo_cont = MATRIZ::m_cod_tipo_cont(); ?>
			<select name='cod_tipo_cont'   >
			        <?
			        foreach ($m_cod_tipo_cont as $k => $v) {
			        ?>
			        <option value=<?=$k;?> <?=$chk_cod_tipo_cont[$k];?> ><?=$k. ' - '. $v;?></option>
			        <?

                    }
                    ?>

			</select>

 
			</td>
	</tr>

<tr>
	  <td align='right'>Código indicador do critério de escrituração e apuração
                adotado, no caso de incidência exclusivamente no
                regime cumulativo (COD_INC_TRIB = 2), pela pessoa
                jurdica submetida ao regime de tributação com base no
                lucro presumido
	  </td>
		<td>


   		     <? $chk_ind_reg_cum[$dados_sped_piscofins[ind_reg_cum]] = 'selected'; ?>
		     <? $m_ind_reg_cum = MATRIZ::m_ind_reg_cum(); ?>
			<select name='ind_reg_cum'   >
			        <?
			        foreach ($m_ind_reg_cum as $k => $v) {
			        ?>
			        <option value=<?=$k;?> <?=$chk_ind_reg_cum[$k];?> ><?=$k. ' - '. $v;?></option>
			        <?

                                }
                    ?>

			</select>

 
	  </td>
</tr>
 
 
 

</table>
<br><br>


    <?
include('periodo.php');
      include('filtro_balancete.php');

    ?>
</form>
<a name='ancora_link'>
<? 
if ($_POST[btfiltro_balancete]) {  //clicou em processar
echo "<BR><BR><table border=1>";
 echo "<tr><td ALIGN=CENTER>";
 ECHO '<H3>SPED CONTRIBUIÇÕES<br> Registros gerados com sucesso!</H3>';
 echo "</td></tr>";
 echo "<tr><td ALIGN=CENTER>";
 if (file_exists("$nome_do_arquivo_dir")) {
            echo "Arquivo gerado com sucesso!";
            echo "<a href=$nome_do_arquivo_dir target=_blank> Download </a>";
            }else{
            echo "Arquivo não foi gerado!";
            }
            echo "</td></tr>";
           
            echo "</table>";

 
}
 
?>
</a>
<br><br><br>

 

