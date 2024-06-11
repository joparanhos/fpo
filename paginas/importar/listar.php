<?php 
require_once("../../conexao.php");

@session_start();

$data_atual = date('Y-m-d');
$competencia = @$_POST['competencia'];

if(isset($competencia)){

$query = $pdo->query("SELECT * FROM S_VPA WHERE VPA_CMP ='$competencia' ORDER BY VPA_PA desc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if($total_reg > 0){

	echo <<<HTML
	<small>
	<table class="table table-hover" id="tabela">
	<thead> 
	<tr>
	<th class="esc">VPA_CMP</th> 
	<th class="esc">VPA_PA</th> 		
	<th class="esc">VPA_TOTAL</th> 	
	<th class="esc">VPA_SP</th> 
	<th class="esc">VPA_SA_GESTOR</th> 
	<th class="esc">VPA_SH_GESTOR</th> 
	<th class="esc">VPA_SP_GESTOR</th> 
	<th class="esc">VPA_SA_FEDERAL</th> 
	<th class="esc">VPA_SH_FEDERAL</th> 
	<th class="esc">VPA_SP_FEDERAL</th> 
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
	HTML;

	for($i=0; $i < $total_reg; $i++){
		foreach ($res[$i] as $key => $value){}
		$VPA_CMP = $res[$i]['VPA_CMP'];
		$VPA_PA = $res[$i]['VPA_PA'];
		$VPA_TOTAL = $res[$i]['VPA_TOTAL'];	
		$VPA_SP= $res[$i]['VPA_SP'];	
		$VPA_SA_GESTOR= $res[$i]['VPA_SA_GESTOR'];	
		$VPA_SH_GESTOR= $res[$i]['VPA_SH_GESTOR'];	
		$VPA_SP_GESTOR= $res[$i]['VPA_SP_GESTOR'];	
		$VPA_SA_FEDERAL= $res[$i]['VPA_SA_FEDERAL'];	
		$VPA_SH_FEDERAL= $res[$i]['VPA_SH_FEDERAL'];	
		$VPA_SP_FEDERAL = $res[$i]['VPA_SP_FEDERAL'];	

		$VPA_TOTAL = number_format($VPA_TOTAL, 2, ',', '.');
		$VPA_SP = number_format($VPA_SP, 2, ',', '.');
		$VPA_SA_GESTOR = number_format($VPA_SA_GESTOR, 2, ',', '.');
		$VPA_SH_GESTOR = number_format($VPA_SH_GESTOR, 2, ',', '.');	
		$VPA_SP_GESTOR = number_format($VPA_SP_GESTOR, 2, ',', '.');	
		$VPA_SA_FEDERAL = number_format($VPA_SA_FEDERAL, 2, ',', '.');
		$VPA_SH_FEDERAL = number_format($VPA_SH_FEDERAL, 2, ',', '.');
		$VPA_SP_FEDERAL = number_format($VPA_SP_FEDERAL, 2, ',', '.');		

	

	echo <<<HTML
	<tr class="">
	<td>{$VPA_CMP}</td>
	<td class="esc">{$VPA_PA}</td>
	<td class="esc">{$VPA_TOTAL}</td>
	<td class="esc">{$VPA_SP}</td>
	<td class="esc">{$VPA_SA_GESTOR}</td>
	<td class="esc">{$VPA_SH_GESTOR}</td>
	<td class="esc">{$VPA_SP_GESTOR}</td>
	<td class="esc">{$VPA_SA_FEDERAL}</td>
	<td class="esc">{$VPA_SH_FEDERAL}</td>
	<td class="esc">{$VPA_SP_FEDERAL}</td>

	<td>


	<big><a href="#" title="Editar"onclick="editar('{$VPA_CMP}','{$VPA_PA}','{$VPA_TOTAL}','{$VPA_SP}','{$VPA_SA_GESTOR}','{$VPA_SH_GESTOR}','{$VPA_SP_GESTOR}','{$VPA_SA_FEDERAL}','{$VPA_SH_FEDERAL}','{$VPA_SP_FEDERAL}')"><i class="fa-regular fa-pen-to-square fa-xl" ></i></a></big>


	</td>
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
	echo '<small>SELECIONE UMA COMPETÊNCIA</small>';
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

<script type="text/javascript">
	function editar(VPA_CMP,VPA_PA,VPA_TOTAL,VPA_SP,VPA_SA_GESTOR,VPA_SH_GESTOR,VPA_SP_GESTOR,VPA_SA_FEDERAL,VPA_SH_FEDERAL,VPA_SP_FEDERAL){


		$('#VPA_CMP').val(VPA_CMP);
		$('#VPA_PA').val(VPA_PA);
		$('#VPA_TOTAL').val(VPA_TOTAL);
		$('#VPA_SP').val(VPA_SP);

		$('#VPA_SA_GESTOR').val(VPA_SA_GESTOR);
		$('#VPA_SH_GESTOR').val(VPA_SH_GESTOR);
		$('#VPA_SP_GESTOR').val(VPA_SP_GESTOR);

		$('#VPA_SA_FEDERAL').val(VPA_SA_FEDERAL);
		$('#VPA_SH_FEDERAL').val(VPA_SH_FEDERAL);
		$('#VPA_SP_FEDERAL').val(VPA_SP_FEDERAL);
		
		$('#modalEditar').modal('show');
		
	}
</script>

