<?
 //SELECT * FROM `fcont_sql_123`  WHERE campo1 = 'I050' oRDER BY campo6, campo20
// SELECT * FROM `fcont_sql_123`  WHERE campo1 = 'I156' ORDER BY campo2,campo20 
// SELECT sum( campo3 ) , sum( campo4 ) FROM `fcont_sql_123` WHERE campo1 = 'I156' AND campo20 = 'wss'  
// 98464258  	97841580

// SELECT sum( campo3 ) , sum( campo4 ) FROM `fcont_sql_123` WHERE campo1 = 'I156' AND campo20 = '' 
//104003865  	104003868
// SELECT   campo3  ,  campo4 ,campo20  FROM `fcont_sql_123` WHERE campo1 = 'I156'  


//  SELECT sum(campo4),sum(campo6),sum(campo7),sum(campo8)  FROM `fcont_sql_123` WHERE campo1 = 'I155' AND campo20 = 'wss'

// 16785737  	104003865  	104003868  	22465316

// SELECT sum(campo4),sum(campo6),sum(campo7),sum(campo8)  FROM `fcont_sql_123` WHERE campo1 = 'I155' AND campo20 = ''
// 16785737  	104003865  	104003868  	22465316

// Resumo do período:    R$ [ Debito: 142.639.236,88 - Credito: 142.639.236,88 = -0,00 ]     # Geral: -0,00

echo "Planodecontas.net";
exit;
$file=file("/var/www/cadastros/nfefiles/66192634000100/spedtxt/fcont_123_01012010_31122010.txt");

$nelementos=count($file);
echo '<br><br>';
$tfcont_sql='fcont_sql_'.$info_cnpj;

$linha_sql='';
$qtde_campos=20;
	for ($si=1;$si<=$qtde_campos;$si++) {

            $linha_sql=$linha_sql."campo$si varchar(100)";
            if ($si<>$qtde_campos) {
               $linha_sql=$linha_sql.",";
	    }
         }
$linha_sql=$linha_sql." NOT NULL";
     $sql="drop table IF EXISTS $tfcont_sql";  // apaga anterior
          if ( mysql_query($sql) or die (mysql_error()) ) {
        }
$sql_fcont="CREATE  TABLE  $tfcont_sql ($linha_sql)";  
 
  
 if ( mysql_query($sql_fcont) or die (mysql_error()) ) {
 }

for($i =1; $i < $nelementos; $i++) {
   $linha=$file[$i];
   $conteudo_linha=explode("|", $linha);
	$linha_ins='';
        $linha_val='';
	for ($k=1;$k<=count($conteudo_linha);$k++) {

            $linha_ins=$linha_ins."campo$k";
            $cc=$k;
            $linha_val=$linha_val."'".$conteudo_linha[$cc]."'";
 
            if ($k<>count($conteudo_linha)) {
               $linha_ins=$linha_ins.",";
               $linha_val=$linha_val.",";
	    }
         }

  
     
     $sql="insert into $tfcont_sql ($linha_ins) values ($linha_val)";

    if (mysql_query($sql,$CONTPLANOCT_REFERENCIAL)) {
	//echo "sucesso";
	 }else{
	//echo "falha";
    
    }
 


}


$sql_fcontx="update $tfcont_sql set campo20='wss'";
 
  
 if ( mysql_query($sql_fcontx) or die (mysql_error()) ) {
 }









//$file=file("/var/www/cadastros/nfefiles/66192634000100/spedtxt/fcont_123_01012010_31122010.txt");
 $file=file("/home/online/fcont_motozum_2010_ok.txt");
$nelementos=count($file);
echo '<br><br>';
$tfcont_sql='fcont_sql_'.$info_cnpj;

$linha_sql='';
$qtde_campos=20;
	for ($si=1;$si<=$qtde_campos;$si++) {

            $linha_sql=$linha_sql."campo$si varchar(100)";
            if ($si<>$qtde_campos) {
               $linha_sql=$linha_sql.",";
	    }
         }
     $sql="drop table IF EXISTS $tfcont_sql";  // apaga anterior
        //  if ( mysql_query($sql) or die (mysql_error()) ) {
       // }
$sql_fcont="CREATE  TABLE  $tfcont_sql ($linha_sql)";  
 
  
 //if ( mysql_query($sql_fcont) or die (mysql_error()) ) {
// }

for($i =1; $i < $nelementos; $i++) {
   $linha=$file[$i];
   $conteudo_linha=explode("|", $linha);
	$linha_ins='';
        $linha_val='';
	for ($k=1;$k<=count($conteudo_linha);$k++) {

            $linha_ins=$linha_ins."campo$k";
            $cc=$k;
            $linha_val=$linha_val."'".$conteudo_linha[$cc]."'";
 
            if ($k<>count($conteudo_linha)) {
               $linha_ins=$linha_ins.",";
               $linha_val=$linha_val.",";
	    }
         }

  
     
     $sql="insert into $tfcont_sql ($linha_ins) values ($linha_val)";
 //ECHO $sql."<BR>";
    if (mysql_query($sql,$CONTPLANOCT_REFERENCIAL)) {
	//echo "sucesso";
	 }else{
	//echo "falha";
    
    }
 


}

// procura i155  de '' to wss
echo "I155 <BR>";
 $xsql="SELECT *,count(1) as qtde from  fcont_sql_123 WHERE campo1 = 'I155' AND campo20=''  ";
			 $sel_procura=mysql_query($xsql);

       while ($v=mysql_fetch_assoc($sel_procura)) {
		 
 
                     $xcampo2=$v[campo2];
                     $qtde=$v[qtde];
			$xsql2="SELECT * from  fcont_sql_123 WHERE campo1 = 'I155' AND campo20='wss' and campo2='$xcampo2'";
			 $sel_procura2=mysql_query($xsql2);
                               echo " ( $qtde ) procuro em wss ".$v[campo2];
		       if (mysql_num_rows($sel_procura2)>0) {
       				while ($z=mysql_fetch_assoc($sel_procura2)) {
                               		echo " achei: ".$z[campo2];
				}
                       }else{
echo "<font color=red> nao achei </font>";
			}
                        echo "<br>";

	}
 


	 
 







?>
