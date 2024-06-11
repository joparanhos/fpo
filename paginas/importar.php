<?php 
@session_start();

require_once("conexao.php");


$pag = 'importar';

$agora = date('d-m-Y H:i:s');

$data_agenda_hj = date('d-m-Y');

$data_hoje = date('Y-m-d');
$data_ontem = date('Y-m-d', strtotime("-1 days",strtotime($data_hoje)));

$mes_atual = Date('m');
$ano_atual = Date('Y');
$data_inicio_mes = $ano_atual."-".$mes_atual."-01";

if($mes_atual == '4' || $mes_atual == '6' || $mes_atual == '9' || $mes_atual == '11'){
	$dia_final_mes = '30';
}else if($mes_atual == '2'){
	$dia_final_mes = '28';
}else{
	$dia_final_mes = '31';
}

$data_final_mes = $ano_atual."-".$mes_atual."-".$dia_final_mes;


?>

<div class="bs-example widget-shadow" style="padding:10px; margin: 0px;">

    <form method="post" id="form-arquivos">
        <small>
            <div class="row">

                <!--coluna de atualizar tabela-->

                <div class="col-md-4" style="margin-top:5px;" align="left">
                    <div class="row">
                        <h5>ATUALIZAR TABELA</h5>
                    </div>
                    <div class="row">
                        <input type="file" name="arquivo" id="arquivo" style="margin-top:5px;"><br>

                        <input type="submit" value="Importar">

                    </div>

                    <div class="row">

                        <div id="msg"></div>
                    </div>
                </div>

                <!--coluna de filtrar tabela-->


                <!--Filtrar Procedimento por Competências-->

                <div class="col-md-3" style="margin-top:10px;" align="left">
                    <label for="exampleInputEmail1">Filtrar Procedimento por Competências</label>
                    <select class="form-control sel2" id="competencia" name="competencia" style="width:100%;" required>

                        <option value="0">SELECIONE UMA COMPETÊNCIA</option>

                        <?php 

                            $query = $pdo->query("SELECT VPA_CMP, count(VPA_CMP)  FROM S_VPA GROUP BY VPA_CMP ORDER BY VPA_CMP desc");
                            $res = $query->fetchAll(PDO::FETCH_ASSOC);
                            $total_reg = @count($res);



                            if($total_reg > 0){
                                for($i=0; $i < $total_reg; $i++){
                                    foreach ($res[$i] as $key => $value){}
                                        echo '<option value="'.$res[$i]['VPA_CMP'].'">'.$res[$i]['VPA_CMP'].'</option>';
                                }
                            }else{
                                echo '<option value="0">Não Exite Competência</option>';
                            }
				        ?>
                    </select>

                    <div class="row" id="tipo_tela" style="margin-top:40px;" align="center"> </div>


                </div>
                <!--Filtrar Procedimento por Atualização-->

                <div class="col-md-3" style="margin-top:10px;" align="left">
                    <label for="exampleInputEmail1">Filtrar Procedimento por Atualização</label>
                    <select class="form-control sel2" id="data_atualizado" name="data_atualizado" style="width:100%;">

                        <option value="0">SELECIONE A DATA DE ATUALIZAÇÃO</option>


                    </select>

                    <div class="row" id="tipo_tela" style="margin-top:40px;" align="center"> </div>


                </div>



                <!--coluna para exportar consulta da tabela-->

                <div class="col-md-2" style="margin-top:5px;" align="right">
                    <button type="button" onclick="ExportarExcel()" style="margin-top:25px;">Exportar Consulta</button>
                </div>


            </div>

            <!--fim do cabeçalho-->


        </small>


    </form>


    <hr>

    <!--Listar a consulta na no GRID -->

    <small>
        <div class="bs-example widget-shadow" style="padding:10px" id="listar"></div>
        <div id="tabela_exportar" style="display:none"></div>
    </small>

</div>



<!--MODAL PARA EDITAR PROCEDIMENTO -->

<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Valor de Procedimento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                
                </button>
            </div>
            <form id="form-editar">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><small>VPA_CMP</small></label>
                                <input type="text" class="form-control" id="VPA_CMP" name="VPA_CMP"
                                    placeholder="VPA_CMP" readonly="readonly">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><small>VPA_PA</small></label>
                                <input type="text" class="form-control" id="VPA_PA" name="VPA_PA" placeholder="VPA_PA"
                                    readonly="readonly">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><small>VPA_TOTAL</small></label>
                                <input type="text" class="form-control" id="VPA_TOTAL" name="VPA_TOTAL"
                                    placeholder="VPA_TOTAL" readonly="readonly">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><small>VPA_SP</small></label>
                                <input type="text" class="form-control" id="VPA_SP" name="VPA_SP" placeholder="VPA_SP"
                                    readonly="readonly">
                            </div>
                        </div>

                    </div>



                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><small>VPA_SA_GESTOR</small></label>
                                <input type="text" class="form-control" id="VPA_SA_GESTOR" name="VPA_SA_GESTOR"
                                    placeholder="VPA_SA_GESTOR">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><small>VPA_SH_GESTOR</small></label>
                                <input type="text" class="form-control" id="VPA_SH_GESTOR" name="VPA_SH_GESTOR"
                                    placeholder="VPA_SH_GESTOR">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><small>VPA_SP_GESTOR</small></label>
                                <input type="text" class="form-control" id="VPA_SP_GESTOR" name="VPA_SP_GESTOR"
                                    placeholder="VPA_SP_GESTOR">
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><small>VPA_SA_FEDERAL</small></label>
                                <input type="text" class="form-control" id="VPA_SA_FEDERAL" name="VPA_SA_FEDERAL"
                                    placeholder="VPA_SA_FEDERAL">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><small>VPA_SH_FEDERAL</small></label>
                                <input type="text" class="form-control" id="VPA_SH_FEDERAL" name="VPA_SH_FEDERAL"
                                    placeholder="VPA_SH_FEDERAL">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><small>VPA_SP_FEDERAL</small></label>
                                <input type="text" class="form-control" id="VPA_SP_FEDERAL" name="VPA_SP_FEDERAL"
                                    placeholder="VPA_SP_FEDERAL">
                            </div>
                        </div>
                    </div>

                     <br>
                    <small>
                        <div id="msg_editar" align="center"></div>
                    </small>
                </div>

                <div class="modal-footer">

                    <button type="button" id="btn-fechar" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!--Nome da pagina -->

<script type="text/javascript">
var pag = "<?=$pag?>"
</script>


<!--Caminho da pagina do ajax -->

<script src="js/ajax.js"></script>


<!--Evento do select para selecionar a competencia e chamar a função-->

<script>
$('#competencia').change(function() {

    listarCompetencia();
});
</script>

<!--Função para listar os dados por competencia-->

<script>
function listarCompetencia() {

    var competencia = $('#competencia').val();

    $.ajax({
        url: 'paginas/' + pag + "/listar.php",
        method: 'POST',
        data: {
            competencia
        },
        dataType: "html",

        success: function(result) {
            $("#listar").html(result);
            $("#tabela_exportar").html(result);

            $("#tipo_tela").text("PROCEDIMENTOS POR COMPETÊNCIA");

        }
    });
}
</script>


<!--Enviar dados para o banco-->

<script>
$("#form-arquivos").submit(function() {
    event.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        url: 'paginas/' + pag + "/processa.php",
        type: 'POST',
        data: formData,

        success: function(mensagem) {
            $('#mensagem').text('');
            $('#mensagem').removeClass()

            var array = mensagem.split("%");


            var mensagem_retorno = array[0];
            var data_atu = array[1];



            if (mensagem_retorno.trim() == "Atualizaçã Concluída!") {


                $('#msg').text(mensagem_retorno)

                // $('#btn-fechar').click();
                listar_data_atualizado();
                listar_atualizados(data_atu);
                

            } else {

                $('#msg').addClass('text-danger')
                $('#msg').text(mensagem)
            }

        },

        cache: false,
        contentType: false,
        processData: false,

    });

});
</script>

<!--Evento do select para selecionar a data atualizacao e chamar a função-->

<script>
$('#data_atualizado').change(function() {

    listar_atualizados_pordata();
});
</script>

<!--Função para listar os dados que foram atualizados-->


<script>
function listar_atualizados(data_atu) {

    $.ajax({
        url: 'paginas/' + pag + "/listar_atualizados.php",
        method: 'POST',
        data: {
            data_atu
        },
        dataType: "html",

        success: function(result) {
            $("#listar").html(result);
            $("#tabela_exportar").html(result);
            $("#tipo_tela").text("PROCEDIMENTOS ATUALIZADOS");
        }
    });
}
</script>

<!--Função para listar atualizados por data selecionada-->

<script>
function listar_atualizados_pordata() {
    var data_atu = $('#data_atualizado').val();
    $.ajax({
        url: 'paginas/' + pag + "/listar_atualizados.php",
        method: 'POST',
        data: {
            data_atu
        },
        dataType: "html",

        success: function(result) {
            $("#listar").html(result);
            $("#tabela_exportar").html(result);
            $("#tipo_tela").text("PROCEDIMENTOS ATUALIZADOS POR DATA SELECIONADA");
        }
    });
}


function listar_data_atualizado() {
    $.ajax({
        url: 'paginas/' + pag + "/listar_data_atu.php",
        method: 'POST',
        dataType: "html",

        success: function(result) {
            $("#data_atualizado").html(result);

        }
    });
}
</script>


<script type="text/javascript">
$(window).on("load", function listar_data_atu() {
    $.ajax({
        url: 'paginas/' + pag + "/listar_data_atu.php",
        method: 'POST',
        dataType: "html",

        success: function(result) {
            $("#data_atualizado").html(result);

        }
    });
})
</script>

<!--Enviar dados para o banco-->



<script>
function ExportarExcel() {
    var nomeArquivo = $('#tipo_tela').text();
    var htmltable = document.getElementById('tabela_exportar');
    var html = htmltable.outerHTML;
    //var blob = new Blob([html], { type: 'application/vnd.ms-excel' });
    var blob = new Blob([html], {
        type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    });
    var url = window.URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = nomeArquivo + '.xls'; // Nome do arquivo Excel
    a.click();
    window.URL.revokeObjectURL(url);
}
</script>



<script>
$("#form-editar").submit(function() {
    event.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        url: 'paginas/' + pag + "/editar.php",
        type: 'POST',
        data: formData,

        success: function(mensagem) {
            $('#msg_editar').text('');
            $('#msg_editar').removeClass()

            var array = mensagem.split("%");


            var mensagem_retorno = array[0];
            var data_atu = array[1];



            if (mensagem_retorno.trim() == "Salvo com Sucesso!") {  

                $('#msg_editar').text(mensagem_retorno)
             

                listar_atualizados(data_atu);
                listar_data_atualizado();
                //$('#btn-fechar').click();
                


            } else {

                $('#msg_editar').addClass('text-danger')
                $('#msg_editar').text(mensagem_retorno)
            }

        },

        cache: false,
        contentType: false,
        processData: false,

    });

});
</script>
