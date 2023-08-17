<!DOCTYPE html>
<html>
<head>
    <title>Picaretas Bank - Depósito</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <?php
    //Iniciar a Sessão
    session_start();


     if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $numeroConta = $_GET['numero_conta'];
        echo '<h2>Depósito na Conta ' . $numeroConta . '</h2>';
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $numeroConta = $_POST['numero_conta'];
        $valorDeposito = floatval($_POST['valor']);

    // Recuperar os dados das contas da sessão
    $contas = $_SESSION['contas'];
        
        // Encontrar a conta e adicionar o valor ao saldo
        foreach ($contas as &$conta) {
            if ($conta['numero'] === $numeroConta) {
                $conta['saldo'] += $valorDeposito;
                $novoSaldo = $conta['saldo']; // Capturar novo saldo
                break;
            }
        }

    // Atualizar os dados das contas na sessão
    $_SESSION['contas'] = $contas;
        
        // Mensagem de sucesso
        echo '<p>Depósito de R$ ' . $valorDeposito . ' realizado com sucesso na Conta ' . $numeroConta . '.</p>';
        echo '<p>Novo Saldo: R$ ' . $novoSaldo . '<p>';
    }

    
    
    ?>
    
    <form method="post">
        <input type="hidden" name="numero_conta" value="<?php echo $numeroConta; ?>">
        <label for="valor">Valor do Depósito:</label>
        <input type="text" id="valor" name="valor" required>
        <button type="submit">Depositar</button>
    </form>

    <a href="index.php">Voltar à página principal</a>

    
</body>
</html>
