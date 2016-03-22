<?
 
include('segmentos_infotitulo.php');
$info_segmento=$infotitulo;
 

 
    $pcrazaosocial=$infotitulo['razaosocial'];
 
 
 
 
include('periodo.php');


 

if ($_POST[btfiltro_balancete]) {  //clicou em processar
 
     
 
	$xarq=$info_cnpj.'_'._myfunc_ddmmaaaa($lanperiodo1).'_'._myfunc_ddmmaaaa($lanperiodo2).'.txt'; 
	$nome_do_arquivo_dir='../nfefiles/'.$cnpjcpf_segmento.'/spedtxt/fcont_'.$xarq;
	$nome_do_arquivo_down='../nfefiles/'.$cnpjcpf_segmento.'/spedtxt/fcont_'.$xarq;
 
        $perdtos1=_myfunc_dtos($lanperiodo1);
        $perdtos2=_myfunc_dtos($lanperiodo2);
        $dt_ini=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo1));
        $dt_fin=_myfunc_ddmmaaaa(_myfunc_stod($lanperiodo2));
//        $mesini=
 //       $mesfin=

        $filtromovimento="where (cnpjcpfseg='$info_cnpj_segmento' )";

 
// abe arquivo para w-gravaçao

_myfunc_liga_id_processando("P R O C E S S A N D O ");
flush();
$fp = fopen("$nome_do_arquivo_dir", "w"); 
include('sped_fcont_funcoes.php');
fclose($fp);
 _myfunc_desliga_id_processando(''); 
_myfunc_desliga_id_processando('Final de processamento!');
flush();

}
    
 ?>
 
 
 


<form action=logado.php?<?=$_SERVER["QUERY_STRING"];?>#ancora_link method=post name='fcontlancamento'>
 
<table border=3 cellspacing="2" cellpadding="4" >
<tr>
<td colspan=2 align=center>
<br>
<font color=blue size='4'>FCONT</font><br> <font color=blue>&nbsp;&nbsp;&nbsp;&nbsp; Controle Fiscal Contábil de Transição &nbsp;&nbsp;&nbsp;&nbsp;</font><br>
<br>
</td>
</tr>



<tr>
<td align=right>
Código da finalidade do arquivo &nbsp;&nbsp;
</td>
<td>

<?
$cod_finalidade=$_POST['cod_finalidade'];
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

<tr>
	  <td align='right'>Indicador de situação especial</td>
		<td>

   <? $chk_ind_sit_esp[$infotitulo[ind_sit_esp]] = 'selected'; ?>
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
	  <td align='right'>Indicador de Início de Período</td>
		<td>

   <? $chk_ind_sit_ini_per[$_POST[ind_sit_ini_per]] = 'selected'; ?>
		  <? $m_ind_sit_ini_per = MATRIZ::m_ind_sit_ini_per(); ?>
			<select name='ind_sit_ini_per'   >
			        <?
			        foreach ($m_ind_sit_ini_per as $k => $v) {
			        ?>
			        <option value=<?=$k;?> <?=$chk_ind_sit_ini_per[$k];?> ><?=$k. ' - '. $v;?></option>
			        <?

                    }
                    ?>

			</select>

 
			</td>
	</tr>

<tr>
	  <td align='right'>Código da entidade responsável pela manutenção do plano de contas referencial</td>
		<td>

   <? $chk_cod_ent_ref[$infotitulo['cod_ent_ref'] ] = 'selected'; ?>
		  <? $m_cod_ent_ref = MATRIZ::m_cod_ent_ref(); ?>
			<select name='cod_ent_ref'   >
			        <?
			        foreach ($m_cod_ent_ref as $k => $v) {
			        ?>
			        <option value=<?=$k;?> <?=$chk_cod_ent_ref[$k];?> ><?=$k. ' - '. $v;?></option>
			        <?

                    }
                    ?>

			</select>
			</td>
	</tr>

 
 
<tr>
<td align=right>
Forma de Apuração &nbsp;&nbsp;
</td>
<td>
<?
$form_apur=$_POST['form_apur'];
IF (EMPTY($form_apur)) {
   $form_apur='A';
}
?>
            <? $chk_x[$form_apur] = 'checked'; ?>
            <input type="radio" name="form_apur" value=A <?=$chk_x['A'];?>> A - Anual;
            <br>
            <input type="radio" name="form_apur" value=T <?=$chk_x['T'];?>> T - Trimestral.
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
 ECHO '<H3>FCONT<br> Registros gerados com sucesso!</H3>';
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

 

