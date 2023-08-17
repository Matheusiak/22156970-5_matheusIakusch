<!DOCTYPE html>
<html>
<head>
    <title>Picaretas Bank - Desconto de Cheque Especial</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <?php
    // Iniciar a sessão
    session_start();
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $numeroConta = $_GET['numero_conta'];
        echo '<h2>Desconto de Cheque Especial na Conta ' . $numeroConta . '</h2>';
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $numeroConta = $_POST['numero_conta'];
        $valorDesconto = floatval($_POST['valor']);
        
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
            $chequeEspecial = $contaEncontrada['cheque_especial'];
            
            if ($valorDesconto <= $chequeEspecial) {
                $contaEncontrada['cheque_especial'] -= $valorDesconto;
                $_SESSION['contas'] = $contas;
                
                echo '<p>Desconto de cheque especial de R$ ' . $valorDesconto . ' realizado com sucesso na Conta ' . $numeroConta . '.</p>';
                echo '<p>Novo limite de cheque especial: R$ ' . $contaEncontrada['cheque_especial'] . '</p>';
            } else {
                echo '<p>Valor do desconto excede o limite de cheque especial.</p>';
            }
        } else {
            echo '<p>Conta não encontrada.</p>';
        }
        
        
    }
    ?>
    
    <form method="post">
        <input type="hidden" name="numero_conta" value="<?php echo $numeroConta; ?>">
        <label for="valor">Valor do Desconto:</label>
        <input type="text" id="valor" name="valor" required>
        <button type="submit">Realizar Desconto</button>
    </form>

    <a href="index.php">Voltar à página principal</a>;
</body>
</html>
