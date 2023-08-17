<!DOCTYPE html>
<html>
<head>
    <title>Picaretas Bank - Retirada</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <?php
    // Iniciar a sessão
    session_start();
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $numeroConta = $_GET['numero_conta'];
        echo '<h2>Retirada na Conta ' . $numeroConta . '</h2>';
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $numeroConta = $_POST['numero_conta'];
        $valorRetirada = floatval($_POST['valor']);
        
        // Recuperar os dados das contas da sessão
        $contas = $_SESSION['contas'];
        
        // Encontrar a conta
        $contaEncontrada = null;
        foreach ($contas as &$conta) {
            if ($conta['numero'] === $numeroConta) {
                $contaEncontrada = &$conta;
                break;
            }
        }
        
        if ($contaEncontrada) {
            $saldoAtual = $contaEncontrada['saldo'];
            $chequeEspecial = $contaEncontrada['cheque_especial'];
            
            if ($valorRetirada <= $saldoAtual) {
                $contaEncontrada['saldo'] -= $valorRetirada;
                $novoSaldo = $contaEncontrada['saldo'];
                $_SESSION['contas'] = $contas;
                
                echo '<p>Retirada de R$ ' . $valorRetirada . ' realizada com sucesso na Conta ' . $numeroConta . '.</p>';
                echo '<p>Novo saldo: R$ ' . $novoSaldo . '</p>';
            } elseif ($valorRetirada <= ($saldoAtual + $chequeEspecial)) {
                $contaEncontrada['saldo'] = 0;
                $contaEncontrada['cheque_especial'] -= ($valorRetirada - $saldoAtual);
                $novoSaldo = $contaEncontrada['saldo'];
                $_SESSION['contas'] = $contas;
                
                echo '<p>Retirada de R$ ' . $valorRetirada . ' realizada com sucesso na Conta ' . $numeroConta . ' (usando cheque especial).</p>';
                echo '<p>Novo saldo: R$ ' . $novoSaldo . '</p>';
            } else {
                echo '<p>Saldo insuficiente e limite de cheque especial ultrapassado.</p>';
            }
        } else {
            echo '<p>Conta não encontrada.</p>';
        }
        
        
    }
    ?>
    
    <form method="post">
        <input type="hidden" name="numero_conta" value="<?php echo $numeroConta; ?>">
        <label for="valor">Valor da Retirada:</label>
        <input type="text" id="valor" name="valor" required>
        <button type="submit">Retirar</button>
    </form>

    <a href="index.php">Voltar à página principal</a>;
</body>
</html>
