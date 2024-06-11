<?php 
require_once("../../conexao.php");
date_default_timezone_set('America/Sao_Paulo');


		$DATA_ATU = date('Y-m-d H:i:s');	
			
		$VPA_CMP = $_POST['VPA_CMP'];
		$VPA_PA = $_POST['VPA_PA'];		

		$VPA_SA_GESTOR = $_POST['VPA_SA_GESTOR'];
		$VPA_SH_GESTOR = $_POST['VPA_SH_GESTOR'];
		$VPA_SP_GESTOR = $_POST['VPA_SP_GESTOR'];

		$VPA_SA_FEDERAL = $_POST['VPA_SA_FEDERAL'];
		$VPA_SH_FEDERAL = $_POST['VPA_SH_FEDERAL'];	
		$VPA_SP_FEDERAL = $_POST['VPA_SP_FEDERAL'];	

		$VPA_SA_GESTOR = (float)str_replace(',', '.', $VPA_SA_GESTOR);
		$VPA_SH_GESTOR = (float)str_replace(',', '.', $VPA_SH_GESTOR);
		$VPA_SP_GESTOR = (float)str_replace(',', '.', $VPA_SP_GESTOR);		

		$VPA_SA_FEDERAL = (float)str_replace(',', '.', $VPA_SA_FEDERAL);
		$VPA_SH_FEDERAL = (float)str_replace(',', '.', $VPA_SH_FEDERAL);
		$VPA_SP_FEDERAL = (float)str_replace(',', '.', $VPA_SP_FEDERAL);

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

			//Calculando o 400% do valor do procedimento no SIGTAP

			$valor_sigtap_sh_400_f = $valor_sigtap_sh_400_f*4;
			$valor_sigtap_sp_400_f = $valor_sigtap_sp_400_f*4;			

			
				if(($valor_sigtap_sh_400_f >= $VPA_SH_FEDERAL_f)&&($valor_sigtap_sp_400_f >= $VPA_SP_FEDERAL_f)){


				$STATUS = "Atualizado";

				$res_atualiza = $pdo->prepare("UPDATE S_VPA SET  VPA_SA_GESTOR = :VPA_SA_GESTOR,VPA_SH_GESTOR = :VPA_SH_GESTOR,VPA_SP_GESTOR = :VPA_SP_GESTOR, VPA_SA_FEDERAL = :VPA_SA_FEDERAL, VPA_SH_FEDERAL = :VPA_SH_FEDERAL, VPA_SP_FEDERAL = :VPA_SP_FEDERAL  WHERE VPA_CMP = :VPA_CMP AND VPA_PA = :VPA_PA ");

				$res_atualiza->bindValue(":VPA_CMP", $VPA_CMP);
				$res_atualiza->bindValue(":VPA_PA", $VPA_PA);		
				
				$res_atualiza->bindValue(":VPA_SA_GESTOR", $VPA_SA_GESTOR);	
				$res_atualiza->bindValue(":VPA_SH_GESTOR", $VPA_SH_GESTOR);	
				$res_atualiza->bindValue(":VPA_SP_GESTOR", $VPA_SP_GESTOR);	

				$res_atualiza->bindValue(":VPA_SA_FEDERAL", $VPA_SA_FEDERAL);	
				$res_atualiza->bindValue(":VPA_SH_FEDERAL", $VPA_SH_FEDERAL);	
				$res_atualiza->bindValue(":VPA_SP_FEDERAL", $VPA_SP_FEDERAL);	
						
				$res_atualiza->execute();


				$res_historico = $pdo_historico->prepare("INSERT INTO HISTORICO_ATU_S_VPA (VPA_CMP, VPA_PA , VPA_SA_GESTOR, VPA_SH_GESTOR,VPA_SP_GESTOR, VPA_SA_FEDERAL,VPA_SH_FEDERAL, VPA_SP_FEDERAL, VPA_STATUS, DATA_ATU) values (:VPA_CMP,:VPA_PA, :VPA_SA_GESTOR, :VPA_SH_GESTOR,:VPA_SP_GESTOR, :VPA_SA_FEDERAL, :VPA_SH_FEDERAL, :VPA_SP_FEDERAL, :VPA_STATUS, :DATA_ATU )");

				$res_historico->bindValue(":VPA_CMP", $VPA_CMP);
				$res_historico->bindValue(":VPA_PA", $VPA_PA);


				$res_historico->bindValue(":VPA_SA_GESTOR", $VPA_SA_GESTOR);		
				$res_historico->bindValue(":VPA_SH_GESTOR", $VPA_SH_GESTOR);	
				$res_historico->bindValue(":VPA_SP_GESTOR", $VPA_SP_GESTOR);	

				$res_historico->bindValue(":VPA_SA_FEDERAL", $VPA_SA_FEDERAL);		
				$res_historico->bindValue(":VPA_SH_FEDERAL", $VPA_SH_FEDERAL);	
				$res_historico->bindValue(":VPA_SP_FEDERAL", $VPA_SP_FEDERAL);			
				
				$res_historico->bindValue(":VPA_STATUS", $STATUS);								
				$res_historico->bindValue(":DATA_ATU", $DATA_ATU);

				$res_historico->execute();

			}
			else {
				echo "valor maior que o permitido";
				exit();
			}
		}else {
			echo "procedimento não encontrado";
			exit();
		}

		echo "Salvo com Sucesso!"."%".$DATA_ATU;

?>