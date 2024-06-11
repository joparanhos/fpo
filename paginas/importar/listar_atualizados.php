<?php 
require_once("../../conexao.php");
date_default_timezone_set('America/Sao_Paulo');

@session_start();

$data_atu = trim(@$_POST['data_atu']);

if($data_atu != 0){
	$query = $pdo_historico->query("SELECT * FROM HISTORICO_ATU_S_VPA WHERE DATA_ATU = '$data_atu' ORDER BY VPA_ERRO desc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if($total_reg > 0){

	echo <<<HTML
	<small>
	<table class="table table-hover" id="tabela">
	<thead> 
	<tr>
	<th class="esc">CMP</th> 
	<th class="esc">PROC</th>

	<th class="esc">SH_SIGTAP</th> 
	<th class="esc">SP_SIGTAP</th>
	<th class="esc">TOTAL_SIGTAP</th> 	 	

	<th class="esc">SH_FEDERAL</th>
	<th class="esc">SH(%)</th>

	<th class="esc">SP_FEDERAL</th> 
	<th class="esc">SP(%)</th>

	<th class="esc">TOTAL_FEDERAL</th>
	<th class="esc">TOTAL(%)</th>

	<th class="esc">STATUS</th> 
	<th class="esc">ERRO</th> 
	<th class="esc">DATA_ATU</th> 
	</tr> 
	</thead> 
	<tbody>	
	HTML;

	for($i=0; $i < $total_reg; $i++){
		foreach ($res[$i] as $key => $value){}
		$VPA_CMP = $res[$i]['VPA_CMP'];
		$VPA_PA = $res[$i]['VPA_PA'];			
		$VPA_SH_FEDERAL= $res[$i]['VPA_SH_FEDERAL'];	
		$VPA_SP_FEDERAL = $res[$i]['VPA_SP_FEDERAL'];	
		$VPA_STATUS = $res[$i]['VPA_STATUS'];
		$VPA_ERRO = $res[$i]['VPA_ERRO'];
		$DATA_ATU = $res[$i]['DATA_ATU'];

		$VPA_TOTAL_FEDERAL = $VPA_SH_FEDERAL + $VPA_SP_FEDERAL;

			// PEGANDO O VALOR DO PROCEDIMENTO NA TABELA DO SIGTAP
			$query_vsigtap = $pdo->query("SELECT * FROM S_PROCED WHERE PA_CMP = '$VPA_CMP' AND PA_ID = '$VPA_PA'");
			$res_vsigtap = $query_vsigtap->fetchAll(PDO::FETCH_ASSOC);
			$total_reg_sigtap = @count($res_vsigtap);

			if($total_reg_sigtap >0){
			$valor_sigtap_sh = $res_vsigtap[0]['PA_SH'];
			$valor_sigtap_sp = $res_vsigtap[0]['PA_SP'];

			$VPA_TOTAL_SIGTAP = $valor_sigtap_sh + $valor_sigtap_sp;

			if($VPA_TOTAL_FEDERAL > 0){
				$VPA_TOTAL_FEDERAL_percentual = $VPA_TOTAL_FEDERAL/$VPA_TOTAL_SIGTAP;
				$VPA_TOTAL_FEDERAL_percentual_f = round($VPA_TOTAL_FEDERAL_percentual,2);				
			}else {
				$VPA_TOTAL_FEDERAL_percentual = 0;
				$VPA_TOTAL_FEDERAL_percentual_f = 0;
			}

			if($VPA_SH_FEDERAL > 0){
				$VPA_SH_FEDERAL_percentual= $VPA_SH_FEDERAL/$valor_sigtap_sh;
				$VPA_SH_FEDERAL_percentual_f= round($VPA_SH_FEDERAL_percentual,2);
			}else{
				$VPA_SH_FEDERAL_percentual=0;
				$VPA_SH_FEDERAL_percentual_f= 0;
				
			}

			if($VPA_SP_FEDERAL >0){
				$VPA_SP_FEDERAL_percentual= $VPA_SP_FEDERAL/$valor_sigtap_sp;
				$VPA_SP_FEDERAL_percentual_f = round($VPA_SP_FEDERAL_percentual,2);
			}else{
				$VPA_SP_FEDERAL_percentual= 0;
				$VPA_SP_FEDERAL_percentual_f = 0;
			}					

			$valor_sigtap_sh = number_format($valor_sigtap_sh, 2, ',', '.');
			$valor_sigtap_sp = number_format($valor_sigtap_sp, 2, ',', '.');					
			

			}else{
				$valor_sigtap_sh = "Não Encontrado";
				$valor_sigtap_sp = "Não Encontrado";
				$VPA_SH_FEDERAL_percentual_f = "";
				$VPA_SP_FEDERAL_percentual_f = "";
				$VPA_TOTAL_FEDERAL_percentual_f = "";
				$VPA_TOTAL_SIGTAP = "";
			}

			
			$VPA_SH_FEDERAL = number_format($VPA_SH_FEDERAL, 2, ',', '.');
			$VPA_SP_FEDERAL = number_format($VPA_SP_FEDERAL, 2, ',', '.');		
			

	echo <<<HTML
	<tr class="">
	<td>{$VPA_CMP}</td>
	<td class="esc">{$VPA_PA}</td>

	<td class="esc">{$valor_sigtap_sh}</td>
	<td class="esc">{$valor_sigtap_sp}</td>
	<td class="esc">{$VPA_TOTAL_SIGTAP}</td>

	<td class="esc">{$VPA_SH_FEDERAL}</td>
	<td class="esc">{$VPA_SH_FEDERAL_percentual_f}</td>

	<td class="esc">{$VPA_SP_FEDERAL}</td>
	<td class="esc">{$VPA_SP_FEDERAL_percentual_f}</td>

	<td class="esc">{$VPA_TOTAL_FEDERAL}</td>
	<td class="esc">{$VPA_TOTAL_FEDERAL_percentual_f}</td>

	<td class="esc">{$VPA_STATUS}</td>
	<td class="esc">{$VPA_ERRO}</td>
	<td class="esc">{$DATA_ATU}</td>

	
	</tr>
	HTML;

}

echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>
</table>
</small>
HTML;


}


}

else{
	echo '<small>SELECIONE UMA DATA DE ATUALIZAÇÃO</small>';
}

?>

<script type="text/javascript">
$(document).ready(function() {
    $('#tabela').DataTable({
		destroy: true,
        "ordering": false,
        "stateSave": true
    });
    $('#tabela_filter label input').focus();
	
});
</script>

