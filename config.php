<?php 

//VARIAVEIS GLOBAIS
$nome_sistema = "ATUALIZA FPO";
$email_adm = 'jf.solucaoinf@hotmail.com';

 //é preciso configurar essa url para gerar os relatorios, ela deve apontar para a raiz do seu dominio (https://www.google.com/) com a barra no final e o protocolo http ou https de acordo com seu dominio no inicio.
$url_sistema = "http://$_SERVER[HTTP_HOST]/";
$url = explode("//", $url_sistema);
if($url[1] == 'localhost/'){
	$url_sistema = "http://$_SERVER[HTTP_HOST]/cnes/";
}



$telefone_sistema = "(31) 98739-1136";
$endereco_sistema = "Rua X Nº 200 Centro - BH - MG";
$rodape_relatorios = "Sistema Desenvolvido por Joseph Ferreira da JF SISTEMAS!";
$cnpj_sistema = '22.646.324/0001-34';


//VARIAVEIS PARA O BANCO DE DADOS LOCAL
$servidor = 'localhost';
$usuario = 'SYSDBA';
$senha = 'masterkey';
$banco = 'cnes';




/*
//VARIAVEIS PARA O BANCO HOSPEDAGEM HOSTGATOR
$servidor = 'localhost';
$usuario = '';
$senha = '';
$banco = '';
*/


$opcao1 = 15;
$opcao2 = 30;
$opcao3 = 60;

//VARIAVEIS DE CONFIGURAÇÕES DO SISTEMA


$relatorio_pdf = 'Sim'; //Se você utilizar sim ele vai gerar os relatórios utilizando a biblioteca do dompdf configurada para o PHP 8.0, se você utilizar outra versão do PHP ou do DOMPDF pode ser que ele não gere o relatório da forma correta, caso você utilize não ele vai gerar o relatório html.

$cabecalho_img_rel = 'Não'; // Se você optar por sim, os relatórios serão exibidos com uma imagem de cabeçalho, você precisará editar o arquivo PSD para poder alterar as informações referentes a sua empresa, caso não queira basta deixar como não e ele vai pegar os valores das variaveis globais declaradas acima.


 ?>