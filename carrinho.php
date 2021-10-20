<!DOCTYPE html>
<?php 
   require_once "../CRUD-01-R-novo/conf/Conexao.php";
   $title = "Lista de carros";
   $procurar = isset($_POST["procurar"]) ? $_POST["procurar"] : ""; 
   $consultavel = isset($_POST["consultavel"]) ? $_POST["consultavel"] : "nome"; 
?>
<html>
<head>
    <meta charset="UTF-8">
    <title> <?php echo $title; ?> </title>
	<link rel="stylesheet" href="carroscss.css" />
</head>
<body>
    <form method="post">
		<fieldset>
			<legend>Metodo de consulta</legend>
		<input type="radio" name="consultavel" id="consultavel" value="nome" <?php if($consultavel == "nome")echo "checked"; ?>>nome 
		<input type="radio" name="consultavel" id="consultavel" value="valor" <?php if($consultavel == "valor") echo "checked"; ?>>valor 
		<input type="radio" name="consultavel" id="consultavel" value="km" <?php if($consultavel == "km") echo "checked"; ?>>km 	
		</fieldset>
    <fieldset>
        <legend>Procurar carros</legend>
        <input type="text"   name="procurar" id="procurar" size="37" value="<?php echo $procurar;?>">
        <input type="submit" name="acao"     id="acao">
        <br><br>
        <table>
	    <tr>
			<td><b>ID</b></td>
			<td><b>nome</b></td>
			<td><b>valor</b></td>
			<td><b>km</b></td>
			<td><b>fabricação</b></td>
			<td><b>anos utilizados</b></td>
			<td><b>média KM por ano</b></td>
			<td><b>desconto</b></td>
		</tr>
        <?php
			if($consultavel == "nome"){ 
				echo $consultavel;
				$pdo = Conexao::getInstance();
            $consulta = $pdo->query("SELECT * FROM carro 
                                     WHERE nome LIKE '$procurar%' 
                                     ORDER BY nome");}
			if($consultavel == "valor"){ 
				echo $consultavel;
				$pdo = Conexao::getInstance();
            $consulta = $pdo->query("SELECT * FROM carro 
                                     WHERE valor <= '$procurar' 
                                     ORDER BY valor");}
			elseif($consultavel == "km"){ 
				echo $consultavel;
				$pdo = Conexao::getInstance();
            $consulta = $pdo->query("SELECT * FROM carro 
                                     WHERE km <= '$procurar' 
                                     ORDER BY km");}
            while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) { 
				
				$idade = date("Y") - date("Y",strtotime($linha['fabricação']));
				$mediaano = $linha['km'] / $idade;
				
				$porcentagem = 0;
				if ($linha['km'] > 100000 & $idade > 10) $porcentagem = 20;
				elseif ($linha['km'] > 100000) $porcentagem = 10;
				elseif ($idade > 10) $porcentagem = 10;
				$desconto = $linha['valor'] * $porcentagem / 100;
				$precofinal = $linha['valor'] - $desconto;
        ?>
	    <tr><td><?php echo $linha['ID'];?></td>
            <td><?php echo $linha['nome'];?></td>
			<td><?php echo number_format($linha['valor'], 1, ',', '.');?></td>
			<td <?php if ($linha['km'] > 100000){ echo "id ='cor'";} ?>><?php echo number_format($linha['km'], 1, ',', '.');?></td>
			<td><?php echo date("d/m/Y",strtotime($linha['fabricação']));?></td>
			<td <?php if ($idade > 10){ echo "id ='cor'";} ?>><?php echo $idade;?></td>
			<td><?php echo number_format($mediaano, 1, ',', '.');; ?></td>
			<td><?php echo $precofinal ?></td>
	    </tr>
            <?php } ?>       
        </table>
    </fieldset>
    </form>
</body>
</html>
