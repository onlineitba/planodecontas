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
 * @name      sped_efd.php
 * @version   2.0  20130310
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL v.3
 * @copyright 2012 &copy; PLANO D/C
 * @link      http:planodecontas.net
 * @author    Walber S Sales <eng.walber at gmail dot com>


*        CONTRIBUIDORES (em ordem alfabetica):

 * AUREO NEVES DE SOUZA JUNIOR <onlinesistema at hotmail.com.br>
 * PATRICIA BERNARDES BARCELOS <tyssa_bernardes at hotmail.com>



              

*/

 
include('segmentos_infotitulo.php');
$info_segmento=$infotitulo;
 
$versao_efd='006';
 
    $pcrazaosocial=$infotitulo['razaosocial'];
 
 
 
 
include('periodo.php');


 

if ($_POST[btfiltro_balancete]) {  //clicou em processar
 
 
	$xarq=$info_cnpj.'_'._myfunc_ddmmaaaa($lanperiodo1).'_'._myfunc_ddmmaaaa($lanperiodo2).'.txt'; 
	$nome_do_arquivo_dir='../nfefiles/'.$cnpjcpf_segmento.'/spedtxt/efd_icms_'.$xarq;
	$nome_do_arquivo_down='../nfefiles/'.$cnpjcpf_segmento.'/spedtxt/efd_icms_'.$xarq;
 
        $perdtos1=_myfunc_dtos($lanperiodo1);
        $perdtos2=_myfunc_dtos($lanperiodo2);
        $dt_ini=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo1));
        $dt_fin=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo2));
 

        $filtromovimento="where (cnpjcpfseg='$info_cnpj_segmento' )";
 
 
	// grava flag do efd_icms
	$xcnpjcpfseg=$infocnpj_segmento;
	$cod_ver=$_POST[cod_ver];
	$cod_finalidade=$_POST[cod_finalidade];
	$ind_perfil=$_POST[ind_perfil];
	$sped_efd_vl_sld_credor_ant=$_POST[sped_efd_vl_sld_credor_ant];
	$sped_efd_vl_sld_cred_ant_st=$_POST[sped_efd_vl_sld_cred_ant_st];
        $sped_efd_vl_sld_ant_ipi=$_POST[sped_efd_vl_sld_ant_ipi];
        $codigo_receita_obrigacao=$_POST[codigo_receita_obrigacao];

 
 
 

	$sel_existe = mysql_query("SELECT *  FROM $TSPED_EFD_ICMS WHERE cnpjcpfseg = '$info_cnpj_segmento'",$CONTSPED_EFD_ICMS);
	if ( mysql_num_rows($sel_existe) ) { 						
		$sql = "update $TSPED_EFD_ICMS set codigo_receita_obrigacao='$codigo_receita_obrigacao',sped_efd_vl_sld_ant_ipi='$sped_efd_vl_sld_ant_ipi',sped_efd_vl_sld_cred_ant_st='$sped_efd_vl_sld_cred_ant_st',sped_efd_vl_sld_credor_ant='$sped_efd_vl_sld_credor_ant',ind_perfil='$ind_perfil',cnpjcpfseg='$info_cnpj_segmento',cod_ver='$cod_ver', cod_finalidade='$cod_finalidade' WHERE cnpjcpfseg = '$info_cnpj_segmento'";

	}else{

		$sql = "INSERT INTO $TSPED_EFD_ICMS (codigo_receita_obrigacao,sped_efd_vl_sld_ant_ipi,sped_efd_vl_sld_cred_ant_st,sped_efd_vl_sld_credor_ant,ind_perfil,cnpjcpfseg,cod_ver,cod_finalidade) VALUES ('$codigo_receita_obrigacao','$sped_efd_vl_sld_ant_ipi','$sped_efd_vl_sld_cred_ant_st','$sped_efd_vl_sld_credor_ant','$ind_perfil','$info_cnpj_segmento','$cod_ver','$cod_finalidade')";

	}

	if (mysql_query($sql,$CONTSPED_PISCOFINS)) {
	//ECHO "OK";
	}ELSE{
	ECHO "$sql -NO SQL";
	}

		$dados_sped_efd_icms=_myfunc_dados_sped_efd_icms() ;	

// verifica data com versao efd
/*

  

 
Código do Leiaute	Versão do Leiaute	Data de Início	Data de Fim
002	1.01	01012009	31122009
003	1.02	01012010	31122010
004	1.03	01012011	31122011
005	1.04	01012012	30062012
006	1.05	01072012	31122012
007	1.06	01012013	31122013
008	1.07	01012014	31122014
009	1.08	01012015	31122015
010	1.09	01012016

*/

$per1_ver_04=_myfunc_dtos('01/01/2011');
$per2_ver_04=_myfunc_dtos('31/12/2011');

$per1_ver_05=_myfunc_dtos('01/01/2012');
$per2_ver_05=_myfunc_dtos('30/06/2012');

$per1_ver_06=_myfunc_dtos('01/07/2012');
$per2_ver_06=_myfunc_dtos('31/12/2012');

$per1_ver_07=_myfunc_dtos('01/01/2013');
$per2_ver_07=_myfunc_dtos('31/12/2013');

$per1_ver_08=_myfunc_dtos('01/01/2014');
$per2_ver_08=_myfunc_dtos('31/12/2014');

$per1_ver_09=_myfunc_dtos('01/01/2015');
$per2_ver_09=_myfunc_dtos('31/12/2015');


$per1_ver_10=_myfunc_dtos('01/01/2016');
$per2_ver_10=_myfunc_dtos('31/12/2016');
$cod_ver='';


if ($perdtos1>=$per1_ver_04 and $perdtos2<=$per2_ver_04) {
	$cod_ver='004';

}
if ($perdtos1>=$per1_ver_05 and $perdtos2<=$per2_ver_05) {
	$cod_ver='005';

}
if ($perdtos1>=$per1_ver_06 and $perdtos2<=$per2_ver_06) {
	$cod_ver='006';

}			

if ($perdtos1>=$per1_ver_07 and $perdtos2<=$per2_ver_07) {
	$cod_ver='007';

}

if ($perdtos1>=$per1_ver_08 and $perdtos2<=$per2_ver_08) {
	$cod_ver='008';

}			
if ($perdtos1>=$per1_ver_09 and $perdtos2<=$per2_ver_09) {
	$cod_ver='009';

}

if ($perdtos1>=$per1_ver_10 and $perdtos2<=$per2_ver_10) {
	$cod_ver='010';

}

	if ($cod_ver=='') {
	   echo "<br><font size=2 color=red>Período informado não contempla esta versão</font>";
ECHO _myfuncoes_voltar_pagina();
EXIT;
	}else{
		// abe arquivo para w-gravaçao

		_myfunc_liga_id_processando("P R O C E S S A N D O : Ver. $cod_ver");
		flush();
		$fp = fopen("$nome_do_arquivo_dir", "w"); 
		//$arq_efd='sped_efd_funcoes_'.$cod_ver.'.php';

		$arq_efd='sped_efd_funcoes.php';

		if ($cod_ver=='007') {
			$arq_efd='sped_efd_funcoes_007.php';
		}
		if ($cod_ver=='008') {
			$arq_efd='sped_efd_funcoes_008.php';
		}
		if ($cod_ver=='009') {
			$arq_efd='sped_efd_funcoes_009.php';
		}
		if ($cod_ver=='010') {
			$arq_efd='sped_efd_funcoes_010.php';
		}
	
	 
	 
		include("$arq_efd");
		fclose($fp);
		 _myfunc_desliga_id_processando(''); 
		_myfunc_desliga_id_processando('Final de processamento!');
		flush();

	}
}


$dados_sped_efd_icms=_myfunc_dados_sped_efd_icms() ;
    
 ?>
 
 
 
<br>

<form action=logado.php?<?=$_SERVER["QUERY_STRING"];?>#ancora_link method=post name='fcontlancamento'>
 
<table border=3 cellspacing="2" cellpadding="10" >
<tr>
<td colspan=2 align=center>
 
<font size='3' color=blue>EFD - ESCRITURAÇÃO FISCAL DIGITAL  </font><br>
 
</td>
</tr>
<tr>
<td align=right>
Código da finalidade do arquivo &nbsp;&nbsp;
</td>
<td>

<?php
$cod_finalidade=$dados_sped_efd_icms[cod_finalidade];
IF (EMPTY($cod_finalidade)) {
   $cod_finalidade='0';
}
?>
            <? $chk_x[$cod_finalidade] = 'checked'; ?>
            <input type="radio" name="cod_finalidade" value=0 <?=$chk_x['0'];?>> 0 - Remessa do arquivo original;
            <br>
            <input type="radio" name="cod_finalidade" value=1 <?=$chk_x['1'];?>> 1 - Remessa do arquivo substituto.
</td>
</tr>
<!--
<tr>
	  <td align='right'>Código da versão do leiaute conforme a tabela indicada
no Ato COTEPE.
</td>
		<td>

   <? $chk_cod_ver[$dados_sped_efd_icms[cod_ver]] = 'selected'; ?>
   <? // $chk_cod_ver[$versao_efd] = 'selected'; ?>

 
		  <? $m_cod_ver = MATRIZ::m_cod_ver_efd(); ?>
			<select name='cod_ver'   >
			        <?
			        foreach ($m_cod_ver as $k => $v) {
			        ?>
			        <option value=<?=$k;?> <?=$chk_cod_ver[$k];?> ><?=$k. ' - '. $v;?></option>
			        <?

                    }
                    ?>

			</select>

 
			</td>
	</tr>

-->
<tr>
	  <td align='right'>Perfil Arquivo Fiscal</td>
		<td>
		

   <? $chk_ind_perfil[$dados_sped_efd_icms[ind_perfil]] = 'selected'; ?>
		  <? $m_ind_perfil = MATRIZ::m_ind_perfil(); ?>
			<select name='ind_perfil'   >
			        <?
			        foreach ($m_ind_perfil as $k => $v) {
			        ?>
			        <option value=<?=$k;?> <?=$chk_ind_perfil[$k];?> ><?=$k. ' - '. $v;?></option>
			        <?

                    }
                    ?>

			</select>
</td></tr>

<tr>
	  <td align='right'>Código de receita referente à obrigação<br>

		<?
			$detalhes_m_codigo_receita_ref_obrigacao='Esta tabela também é gerada pela existência do arquivo \n \n    m_codigo_receita_ref_obrigacao.txt \n \n - Na pasta ../nfefiles , para todos segmentos \n \n - Na pasta ../nfefiles/'.$info_cnpj_segmento.', exclusivo. \n \n Formato: \n \n codigo01|descrição 01 \n codigo02|descrição 02';

		?>

		<a href='#' onclick="_myjava_mostra_detalhamento('<?=$detalhes_m_codigo_receita_ref_obrigacao;?>');return false;" > Nota! </a></font>
		</td>
		<td>
		

   <? $chk_codigo_receita_obrigacao[$dados_sped_efd_icms[codigo_receita_obrigacao]] = 'selected'; ?>
		  <? $m_codigo_receita_obrigacao = MATRIZ::m_codigo_receita_ref_obrigacao(); ?>
			<select name='codigo_receita_obrigacao'  style='width: 360px; ' >
			        <?
			        foreach ($m_codigo_receita_obrigacao as $k => $v) {
			        ?>
			        <option value=<?=$k;?> <?=$chk_codigo_receita_obrigacao[$k];?> ><?=$k. ' - '. $v;?></option>
			        <?

                    }
                    ?>

			</select>
</td></tr>

 
 


<tr>
<td align=right>
<br>
&nbsp;Saldo credor anterior <i><b>ICMS</b></i> <?=$moeda;?> &nbsp;&nbsp;
</td>
<td align=right>
<br><input type='text' name='sped_efd_vl_sld_credor_ant' value="<?=$dados_sped_efd_icms[sped_efd_vl_sld_credor_ant];?>" onKeyup="Formata_valor_real(this,20,event,2)" style='width: 160px; font: normal 18px verdana;' maxlength='12'>
</td></tr>

<tr>
<td align=right>
<br>
&nbsp;Saldo credor anterior <i><b>ICMS ST</b></i> <?=$moeda;?> &nbsp;&nbsp;
</td>
<td align=right>
<br><input type='text' name='sped_efd_vl_sld_cred_ant_st' value="<?=$dados_sped_efd_icms[sped_efd_vl_sld_cred_ant_st];?>" onKeyup="Formata_valor_real(this,20,event,2)" style='width: 160px; font: normal 18px verdana;' maxlength='12'>
</td></tr>


<tr>
<td align=right>
<br>
&nbsp;Saldo credor anterior <i><b>IPI</b></i> <?=$moeda;?> &nbsp;&nbsp;
</td>
<td align=right>
<br><input type='text' name='sped_efd_vl_sld_ant_ipi' value="<?=$dados_sped_efd_icms[sped_efd_vl_sld_ant_ipi];?>" onKeyup="Formata_valor_real(this,20,event,2)" style='width: 160px; font: normal 18px verdana;' maxlength='12'>
</td></tr>

<tr >
<td colspan=2>
 
<input type="checkbox" name="box_inventario" >
&nbsp; Incluir INVENTÁRIO neste período:  
&nbsp;&nbsp;Data base inventário: <input onfocus="displayCalendar(data_inventario,'dd/mm/yyyy',this);this.value='';" name="data_inventario" type="text" value="<?=$data_inventario;?>" style='width: 90px; font: normal 13px verdana;' maxlength='10' onkeyup="closeCalendar();this.value = mascara_global('##/##/####', this.value);" onblur="formataData(this);">

<br><br>

Motivo do inventário:		  <? $m_motivo_inventario = MATRIZ::m_motivo_inventario(); ?>
			<select name='motivo_inventario'   >
			        <?
			        foreach ($m_motivo_inventario as $k => $v) {
			        ?>
			        <option value=<?=$k;?> <?=$chk_motivo_inventario[$k];?> ><?=$k. ' - '. $v;?></option>
			        <?

                    }
                    ?>

			</select>

</td></tr>

</table>

 

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
 ECHO '<H3>EFD <br> Registros gerados com sucesso!</H3>';
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

 

