<?php
require_once("../../conexao.php");

@session_start();


$query_atu = $pdo_historico->query("SELECT DATA_ATU, count(DATA_ATU)  FROM HISTORICO_ATU_S_VPA GROUP BY DATA_ATU ORDER BY DATA_ATU desc");
$res_atu = $query_atu->fetchAll(PDO::FETCH_ASSOC);
$total_reg_atu = @count($res_atu);

if($total_reg_atu > 0){
    for($i=0; $i < $total_reg_atu; $i++){
        foreach ($res_atu[$i] as $key => $value){}
            echo '<option value="'.$res_atu[$i]['DATA_ATU'].'">'.$res_atu[$i]['DATA_ATU'].'</option>';
    }
}else{
    echo '<option value="0">Não Exite Atualização</option>';
}

?>