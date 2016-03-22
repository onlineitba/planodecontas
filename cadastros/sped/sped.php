
<br>
 <fieldset style="<?=$style_fieldset;?> width: 450px;">
    <legend style="<?=$style_fieldset_legend ;?>" align=top>
     <FONT COLOR=BLUE>
      &nbsp; <img src="../imagens/sped.jpg" border="0"> &nbsp;<BR>
     </FONT>


    </legend>

<?
$tam_letra='5';
$fonte_letra='Times New Roman';
$cor_letra='green';
echo "<br><br> ";
?>
<table BORDER=0 cellspacing="0" cellpadding="6">

<?						// ECD
	   				if ((eregi(':034.602',$contasacesso_user)) and (!(eregi(':034.602',$log_off_news)))) {           
                     	echo '<TR><TD>';
								echo "<a href=logado.php?ac=sped_ecd >ECD - CONTÁBIL</a>";
								echo '</TD></TR>';
                  }
 
 
 
  					  if ((eregi(':034.601',$contasacesso_user)) and (!(eregi(':034.601',$log_off_news)))) {

                  		 echo '<TR><TD>';
								echo "<a href=logado.php?ac=sped_efd >EFD - FISCAL </a>";
								echo '</TD></TR>';

                  }
                  
              
 						 if ((eregi(':034.605',$contasacesso_user)) and (!(eregi(':034.605',$log_off_news))) ) {
  
                   		 echo '<TR><TD>';
								echo "<a href=logado.php?ac=sped_efd_piscofins >EFD -  CONTRIBUIÇÕES</a>";
								echo '</TD></TR>';

                  }
                  
                   if ((eregi(':034.606',$contasacesso_user)) and (!(eregi(':034.606',$log_off_news)))) {

                
                   
                    echo '<TR><TD>';
								echo "<a href=logado.php?ac=sped_fcont >FCONT</a>";
								echo '</TD></TR>';

                  }
                  
                   if ((eregi(':034.603',$contasacesso_user))) {
  								echo '<TR><TD>';
								echo "<a href=logado.php?ac=sintegra >SINTEGRA</a>";
								echo '</TD></TR>';

                  }

 

?>

</TD></TR>
</TABLE> <br><br>
</fieldset> 