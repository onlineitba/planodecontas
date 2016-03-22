<?
// release 14082012
echo "<br><b> <FONT SIZE=4 color=blue>$menu_escolhido </FONT></b>";
      
 
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

if (!($_POST[data_inventario])) {
	$dt_periodo2=$lanperiodo2;
}else{
        $dt_periodo2=$_POST[data_inventario];
}


$box_flag01="Incluir inventário ref. a data <input type=text name=data_inventario value=$dt_periodo2 size=10>";
$box_flag02="Retificado";
$inputs_menu='periodo,box_flag01,box_flag02';

$filtro_opcoes_inputmenus_form_name='flancamento';
include('filtro_opcoes_inputmenus.php');




?>
</form>
<?
   
$chklink=_myfuncoes_chklink('CNPJCPF',$info_cnpj);
?>



<!-- <a title="Click e defina os registros do SINTEGRA" href="logado.php?ac=sintegra_user&chklink=<?=$chklink;?>&site=@ACESSOS" onclick="NewWindow(this.href,'name','750','550','yes');return false;">SINTEGRA Registros</a> -->


<?

if (!($_POST)) {
exit;
}


echo $lanperiodo1;
echo " a ";
echo $lanperiodo2;
echo " <br><br> ";
$retorna_error=$retorna_error. _myfunc_valida_periodo_vaziok($lanperiodo1,$lanperiodo2);


// tabela segmentos, dados da empresa
$sel_segmento = mysql_query("SELECT * FROM $TSEGMENTOS  WHERE cnpjcpf='$info_cnpj_segmento'",$CONTSEGMENTOS);
If (mysql_num_rows($sel_segmento)) {
    $info_segmento= mysql_fetch_assoc($sel_segmento);
}

// período

$per1=_myfunc_dtos($lanperiodo1)  ;
$per2=_myfunc_dtos($lanperiodo2) ;



$perdtos1=_myfunc_dtos($lanperiodo1);
$perdtos2=_myfunc_dtos($lanperiodo2);

require_once("$PASTA_INICIAL/nfefiles/nfe_nfefiles_pastas_nfe.php");
$nome_txt='sintegra_'.$cnpjcpf_segmento.'_'.$info_cnpj.'_'._myfunc_ddmmaaaa($lanperiodo1).'_'._myfunc_ddmmaaaa($lanperiodo2).'.txt';
$nome_do_arquivo_dir=$spedDir.'ecd_'.$info_cnpj.'_'._myfunc_ddmmaaaa($lanperiodo1).'_'._myfunc_ddmmaaaa($lanperiodo2).'.txt';
$nome_do_arquivo_down=$spedDir.'ecd_'.$info_cnpj.'_'._myfunc_ddmmaaaa($lanperiodo1).'_'._myfunc_ddmmaaaa($lanperiodo2).'.zip';

$nome_do_arquivo_dir='../nfefiles/'.$cnpjcpf_segmento.'/spedtxt/sintegra_'.$cnpjcpf_segmento.'_'.$info_cnpj.'_'._myfunc_ddmmaaaa($lanperiodo1).'_'._myfunc_ddmmaaaa($lanperiodo2).'.txt';
$nome_do_arquivo_down='../nfefiles/'.$cnpjcpf_segmento.'/spedtxt/sintegra_'.$cnpjcpf_segmento.'_'.$info_cnpj.'_'._myfunc_ddmmaaaa($lanperiodo1).'_'._myfunc_ddmmaaaa($lanperiodo2).'.txt';
 

// abe arquivo para w-gravaçao
$fp = fopen("$nome_do_arquivo_dir", "w");

// script / rotina que gera as linhas txt

$lanperiodo1=$perdtos1;
$lanperiodo2=$perdtos2;

include('sintegra_funcoes.php');


fclose($fp);  // fecha arquivo

/*
// zipar arquivo
$zip = new ZipArchive();
$filename = "$nome_do_arquivo_down";

if ($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE) {
    exit("cannot open <$filename>\n");
}

//$zip->addFromString("$nome_do_arquivo_dir" . time(), "#1 This is a test string added as testfilephp.txt.\n");
//$zip->addFromString("testfilephp2.txt" . time(), "#2 This is a test string added as testfilephp2.txt.\n");
$zip->addFile("$nome_do_arquivo_txt");
//echo "numfiles: " . $zip->numFiles . "\n";
//echo "status:" . $zip->status . "\n";
$zip->close();

*/

 
if (file_exists("$nome_do_arquivo_dir")) {
  echo "Arquivo $nome_txt gerado com sucesso!<br><br>";
  echo "<a href=$nome_do_arquivo_down target=_blank> Download </a>";
}else{
  echo "Arquivo   não gerado!";
}
?>














 
