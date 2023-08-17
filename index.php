<!DOCTYPE html>
<html>
<head>
    <title>Picaretas Bank</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <h1>Picaretas Bank</h1>
    
    <?php
    //iniciar a sessão
    session_start();


    // Definindo as contas bancárias como arrays associativos
    $contas = [
        ['numero' => '001', 'saldo' => 1500, 'cheque_especial' => 500],
        ['numero' => '002', 'saldo' => 3000, 'cheque_especial' => 1000],
        ['numero' => '003', 'saldo' => 500, 'cheque_especial' => 200],
    ];

    //Armazenar os Dados das contas na Sessão
    $_SESSION['contas'] = $contas;

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $numeroContaPesquisada = $_POST['numero_conta'];
        
        // Procurar a conta no array
        $contaEncontrada = null;
        foreach ($contas as $conta) {
            if ($conta['numero'] === $numeroContaPesquisada) {
                $contaEncontrada = $conta;
                break;
            }
        }
        
        if ($contaEncontrada) {
            echo '<h2>Dados da Conta</h2>';
            echo 'Número da Conta: ' . $contaEncontrada['numero'] . '<br>';
            echo 'Saldo: R$ ' . $contaEncontrada['saldo'] . '<br>';
            echo 'Limite de Cheque Especial: R$ ' . $contaEncontrada['cheque_especial'] . '<br>';
            
            echo '<h2>Opções</h2>';
            echo '<a href="deposito.php?numero_conta=' . $contaEncontrada['numero'] . '">Depósito</a><br>';
            echo '<a href="retirada.php?numero_conta=' . $contaEncontrada['numero'] . '">Retirada</a><br>';
            echo '<a href="desconto_cheque.php?numero_conta=' . $contaEncontrada['numero'] . '">Desconto de Cheques</a><br>';
            echo '<a href="pagamento_fatura.php?numero_conta=' . $contaEncontrada['numero'] . '">Pagamento de Faturas</a><br>';
        } else {
            echo '<p>Conta não encontrada.</p>';
        }
    }
    ?>
    
    <h2>Buscar Conta</h2>
    <form method="post">
        <label for="numero_conta">Número da Conta:</label>
        <input type="text" id="numero_conta" name="numero_conta" required>
        <button type="submit">Buscar</button>
    </form>
</body>
</html>
