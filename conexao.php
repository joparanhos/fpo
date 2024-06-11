<?php

$nome_banco = 'FPOMAG';
$servidor = '127.0.0.1';
$usuario = 'SYSDBA'; // Usuário do banco de dados
$senha = 'masterkey'; // Senha do usuário
//$caminhoBanco = 'C:/xampp/htdocs/fpo/banco/'.$nome_banco.'.gdb'; // Caminho do banco teste
$caminhoBanco = 'C:/Program Files (x86)/Datasus/FPO/'.$nome_banco.'.gdb'; // Caminho do banco em produção

//BANCO DE HISTORICO
$nome_banco_historico = 'HISTORICO_FPO';
//$caminhoBanco = 'C:/xampp/htdocs/fpo/banco/'.$nome_banco.'.gdb'; // Caminho do banco teste
$caminhoBanco_historico = 'C:/Program Files (x86)/Datasus/FPO/'.$nome_banco_historico.'.gdb'; // Caminho do banco em produção

try {
    // Criando a conexão com o banco de dados
   
    $pdo = new PDO("firebird:host=$servidor;dbname=$caminhoBanco;charset=UTF8", $usuario, $senha);

    // Configurando o modo de tratamento de erros
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     
} catch (PDOException $e) {
    echo 'Falha na conexão: ' . $e->getMessage();
}


try {
    
    $pdo_historico = new PDO("firebird:host=$servidor;dbname=$caminhoBanco_historico;charset=UTF8", $usuario, $senha);
    $pdo_historico->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
} catch (PDOException $ee) {
    echo 'Falha na conexão: ' . $ee->getMessage();
}

//finally {
    // Fechar a conexão com o Firebird
    //$pdo = null;
//}
?>