<?php 
@session_start();

require_once("../../conexao.php");
$data_atual = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');

 ?>
<div class="main-page">


    


	<div class="col_3">

        <a href="index.php?pag=importar">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-users icon-rounded"></i>
				<div class="stats">
                        <h5><strong><big><big><?php echo $total_pacientes ?></big></big></strong></h5>

                    </div>
                    <hr style="margin-top:10px">
                    <div align="center" style="font-size:12px"><span><span>Total de Pacientes</span></span></div>
			</div>
		</div>
        </a>

	

         <a href="index.php?pag=agendados">
        <div class="col-md-3 widget widget1">
            <div class="r3_counter_box">
              
                 
                   <i class="pull-left fa fa-stethoscope user1 icon-rounded"></i>


                <div class="stats">
                        <h5><strong><big><big><?php echo $total_exames ?></big></big></strong></h5>

                    </div>
                    <hr style="margin-top:10px">
                    <div align="center" style="font-size:12px"><span><span>Total de Exames Diário</span></span></div>
            </div>
        </div>
        </a>

       		<div class="clearfix"> </div>
	   </div>



	<div class="row-one widgettable">

        <!--GRAFICO-->

    <input type="hidden" id="dados_grafico_exames">  
		<div class="col-md-12 content-top-2 card ">

			<div class="agileinfo-cdr">
					<div class="card-header">
                        <h3>Exames Realizados</h3>
                    </div>
					
						<div id="Linegraph" style="width: 98%; height: 350px">
						</div>
						
				</div>

		</div>
		
		<div class="clearfix"> </div>
	</div>


	
	<!-- for amcharts js -->

	<script src="js/amcharts.js"></script>
	<script src="js/serial.js"></script>
	<script src="js/export.min.js"></script>
	<link rel="stylesheet" href="css/export.css" type="text/css" media="all" />
	<script src="js/light.js"></script>
	<!-- for amcharts js -->

	<script  src="js/index1.js"></script>
	

</div>



<div class="clearfix"> </div>
</div>
<div class="clearfix"> </div>

</div>

</div>


<script src="js/SimpleChart.js"></script>



