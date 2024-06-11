<?php 
require_once("../../conexao.php");
date_default_timezone_set('America/Sao_Paulo');

ini_set('max_execution_time','-1');
session_start();

//Receber os dados do formulário

$arquivo_tmp = $_FILES['arquivo']['tmp_name'];
$nome_arquivo = $_FILES['arquivo']['name'];

//ler todo o arquivo para um array
$dados = file($arquivo_tmp);

//Não ler cabeçalho da planilha

array_shift($dados);

// TOTALIZANDO LINHAS

$total_reg = @count($dados);

// IMPORTAR TABELA DE PROCEDIMENTOS

if($total_reg > 0){

	foreach($dados as $key => $linha){

		/* Ler cabeçalho

		if($key == 0 ){

			echo $linha;
			exit();

		}*/
		
		$DATA_ATU = date('Y-m-d H:i:s');		

		$linha= utf8_encode($linha);

		$valor = explode(';', $linha);

		$VPA_CMP = $valor[0];		
		$VPA_PA = '0'.$valor[1];		
		$VPA_SH_FEDERAL = $valor[2];		
		$VPA_SP_FEDERAL = $valor[3];		
		$VPA_SH_FEDERAL = (float)str_replace(',', '.', $VPA_SH_FEDERAL);
		$VPA_SP_FEDERAL = (float)str_replace(',', '.', $VPA_SP_FEDERAL);
		
		
		//SE UM DOS VALORES FOR MAIOR QUE 0 FAÇA
		
		if(($VPA_SH_FEDERAL > 0)||($VPA_SP_FEDERAL > 0)){
			
		//CONFERINDO SE COMPETENCIA E O PROCEDIMENTO EXISTE NO BANCO DE DADOS

		$query = $pdo->query("SELECT * FROM S_VPA WHERE VPA_CMP = '$VPA_CMP' AND VPA_PA = '$VPA_PA'");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$total_registro = @count($res);		
		
		

		//ATUALIZANDO NO BANCO DE DADOS

		if($total_registro > 0){	
			
			

			//Buscando o valor do procedimento na tabela do sigtap
			
			$query_vsigtap = $pdo->query("SELECT * FROM S_PROCED WHERE PA_CMP = '$VPA_CMP' AND PA_ID = '$VPA_PA'");
			$res_vsigtap = $query_vsigtap->fetchAll(PDO::FETCH_ASSOC);
			$encotrado_sigtap = @count($res_vsigtap);		


			// SE ENCONTRAR O PROCEDIMENTO NA TABELA DO SIGTAP
			
			if($encotrado_sigtap > 0){

			$valor_sigtap_sh = $res_vsigtap[0]['PA_SH'];
			$valor_sigtap_sp = $res_vsigtap[0]['PA_SP'];		
			

			
			$valor_sigtap_sh_400_f = (float)str_replace(',', '.', $valor_sigtap_sh);
			$valor_sigtap_sp_400_f = (float)str_replace(',', '.', $valor_sigtap_sp);


			$VPA_SH_FEDERAL_f = (float)str_replace(',', '.', $VPA_SH_FEDERAL);
			$VPA_SP_FEDERAL_f = (float)str_replace(',', '.', $VPA_SP_FEDERAL);

			//Calculando o percentual de alteração sobre o valor do procedimento no SIGTAP

			$VPA_SH_FEDERAL_percentual = $VPA_SH_FEDERAL_f/$valor_sigtap_sh_400_f;
			$VPA_SP_FEDERAL_percentual = $VPA_SP_FEDERAL_f/$valor_sigtap_sp_400_f;


			

			//Calculando o 400% do valor do procedimento no SIGTAP

			$valor_sigtap_sh_400_f = $valor_sigtap_sh_400_f*4;
			$valor_sigtap_sp_400_f = $valor_sigtap_sp_400_f*4;			

			
				if(($valor_sigtap_sh_400_f >= $VPA_SH_FEDERAL_f)&&($valor_sigtap_sp_400_f >= $VPA_SP_FEDERAL_f)){

				$STATUS = "Atualizado";

				$res_atualiza = $pdo->prepare("UPDATE S_VPA SET  VPA_SH_FEDERAL = :VPA_SH_FEDERAL, VPA_SP_FEDERAL = :VPA_SP_FEDERAL  WHERE VPA_CMP = :VPA_CMP AND VPA_PA = :VPA_PA ");

				$res_atualiza->bindValue(":VPA_CMP", $VPA_CMP);	
				$res_atualiza->bindValue(":VPA_SH_FEDERAL", $VPA_SH_FEDERAL);	
				$res_atualiza->bindValue(":VPA_SP_FEDERAL", $VPA_SP_FEDERAL);	
				$res_atualiza->bindValue(":VPA_PA", $VPA_PA);				
				$res_atualiza->execute();


				$res_historico = $pdo_historico->prepare("INSERT INTO HISTORICO_ATU_S_VPA (VPA_CMP, VPA_SH_FEDERAL, VPA_SP_FEDERAL, VPA_PA,VPA_STATUS, DATA_ATU) values (:VPA_CMP, :VPA_SH_FEDERAL, :VPA_SP_FEDERAL, :VPA_PA,:VPA_STATUS, :DATA_ATU )");

				$res_historico->bindValue(":VPA_CMP", $VPA_CMP);	
				$res_historico->bindValue(":VPA_SH_FEDERAL", $VPA_SH_FEDERAL);	
				$res_historico->bindValue(":VPA_SP_FEDERAL", $VPA_SP_FEDERAL);	
				$res_historico->bindValue(":VPA_PA", $VPA_PA);
				$res_historico->bindValue(":VPA_STATUS", $STATUS);								
				$res_historico->bindValue(":DATA_ATU", $DATA_ATU);

				$res_historico->execute();

			}
			else{

				$ERRO = "Valor do procedimento maior que 400% sobre o valor do SIGTAP";
				$STATUS = "Nao atualizado";

				$res_historico = $pdo_historico->prepare("INSERT INTO HISTORICO_ATU_S_VPA (VPA_CMP, VPA_SH_FEDERAL, VPA_SP_FEDERAL, VPA_PA, VPA_ERRO,VPA_STATUS, DATA_ATU) values (:VPA_CMP, :VPA_SH_FEDERAL, :VPA_SP_FEDERAL, :VPA_PA,:VPA_ERRO,:VPA_STATUS,:DATA_ATU )");

				$res_historico->bindValue(":VPA_CMP", $VPA_CMP);	
				$res_historico->bindValue(":VPA_SH_FEDERAL", $VPA_SH_FEDERAL);	
				$res_historico->bindValue(":VPA_SP_FEDERAL", $VPA_SP_FEDERAL);	
				$res_historico->bindValue(":VPA_PA", $VPA_PA);								
				$res_historico->bindValue(":DATA_ATU", $DATA_ATU);	
				$res_historico->bindValue(":VPA_STATUS", $STATUS);
				$res_historico->bindValue(":VPA_ERRO", $ERRO);							
				$res_historico->execute();

			}				
				

			}

			// SE NÃO ENCONTRAR O PROCEDIMENTO NA TABELA DO SIGTAP
			else{
				
				
				$ERRO = "Procedimento não encontrado na tabela do SIGTAP";
				$STATUS = "Nao atualizado";

				$res_historico = $pdo_historico->prepare("INSERT INTO HISTORICO_ATU_S_VPA (VPA_CMP, VPA_SH_FEDERAL, VPA_SP_FEDERAL, VPA_PA, VPA_ERRO,VPA_STATUS, DATA_ATU) values (:VPA_CMP, :VPA_SH_FEDERAL, :VPA_SP_FEDERAL, :VPA_PA,:VPA_ERRO,:VPA_STATUS,:DATA_ATU )");

				$res_historico->bindValue(":VPA_CMP", $VPA_CMP);	
				$res_historico->bindValue(":VPA_SH_FEDERAL", $VPA_SH_FEDERAL);	
				$res_historico->bindValue(":VPA_SP_FEDERAL", $VPA_SP_FEDERAL);	
				$res_historico->bindValue(":VPA_PA", $VPA_PA);								
				$res_historico->bindValue(":DATA_ATU", $DATA_ATU);	
				$res_historico->bindValue(":VPA_STATUS", $STATUS);
				$res_historico->bindValue(":VPA_ERRO", $ERRO);							
				$res_historico->execute();
			}
					
				
			}
			
			else{

				



				$ERRO = "Procedimento não encontrado";
				$STATUS = "Nao atualizado";

				$res_historico = $pdo_historico->prepare("INSERT INTO HISTORICO_ATU_S_VPA (VPA_CMP, VPA_SH_FEDERAL, VPA_SP_FEDERAL, VPA_PA, VPA_ERRO,VPA_STATUS, DATA_ATU) values (:VPA_CMP, :VPA_SH_FEDERAL, :VPA_SP_FEDERAL, :VPA_PA,:VPA_ERRO,:VPA_STATUS,:DATA_ATU )");

				$res_historico->bindValue(":VPA_CMP", $VPA_CMP);	
				$res_historico->bindValue(":VPA_SH_FEDERAL", $VPA_SH_FEDERAL);	
				$res_historico->bindValue(":VPA_SP_FEDERAL", $VPA_SP_FEDERAL);	
				$res_historico->bindValue(":VPA_PA", $VPA_PA);								
				$res_historico->bindValue(":DATA_ATU", $DATA_ATU);	
				$res_historico->bindValue(":VPA_STATUS", $STATUS);
				$res_historico->bindValue(":VPA_ERRO", $ERRO);							
				$res_historico->execute();
			}

		}


		else{

			$ERRO = "Valor de SH E SP zerado";
			$STATUS = "Nao atualizado";

			$res_historico = $pdo_historico->prepare("INSERT INTO HISTORICO_ATU_S_VPA (VPA_CMP, VPA_SH_FEDERAL, VPA_SP_FEDERAL, VPA_PA, VPA_ERRO,VPA_STATUS, DATA_ATU) values (:VPA_CMP, :VPA_SH_FEDERAL, :VPA_SP_FEDERAL, :VPA_PA,:VPA_ERRO,:VPA_STATUS,:DATA_ATU )");

			$res_historico->bindValue(":VPA_CMP", $VPA_CMP);	
			$res_historico->bindValue(":VPA_SH_FEDERAL", $VPA_SH_FEDERAL);	
			$res_historico->bindValue(":VPA_SP_FEDERAL", $VPA_SP_FEDERAL);	
			$res_historico->bindValue(":VPA_PA", $VPA_PA);								
			$res_historico->bindValue(":DATA_ATU", $DATA_ATU);	
			$res_historico->bindValue(":VPA_STATUS", $STATUS);
			$res_historico->bindValue(":VPA_ERRO", $ERRO);							
			$res_historico->execute();
		}
		


		}

		echo "Atualizaçã Concluída!"."%".$DATA_ATU;
				
	}


?>