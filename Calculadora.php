<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
    body,
    form,
    input,
    select,
    button {
        margin: 0;
        padding: 0;
        font-family: 'Montserrat', sans-serif;
       
    }

    body {
        background-color: #141414;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #2e7d32;
    }

    .calculadora {
        background-color: #1c1c1c;
        border-radius: 15px;
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        padding: 30px;
        max-width: 400px;
        width: 100%;
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
        color: #f0f0f0;
    }

    form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-gap: 15px;
    }

    input,
    select,
    button {
        padding: 12px 16px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        background-color: lightcoral;
    }

    input[type="text"] {
        grid-column: 1 / 3;
        background-color: #2c2c2c;
        color: #f0f0f0;
    }

    select {
        background-color: #2c2c2c;
        color: #f0f0f0;
    }

    button {
        grid-column: 1 / 3;
        background-color: #2962ff;
        color: #f0f0f0;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #0039cb;
    }

    button[name="historico"] {
        background-color: #2e7d32;
    }

    button[name="historico"]:hover {
        background-color: #1b5e20;
    }

    button[name="limpar"] {
        background-color: #c62828;
    }

    button[name="limpar"]:hover {
        background-color: #8e0000;
    }

    #history {
        margin-top: 30px;
        padding: 15px;
        background-color: #2c2c2c;
        border-radius: 8px;
        color: lightblue;
    }
    </style>
</head>

<body>
    <div class="calculadora">
        <h1>Calculadora PHP</h1>
        <form action="" method="post">
            <label for="num1"></label>
            <input name="num1" type="text" id="num1" placeholder="Numero 1">

            <select name="operador" id="operador">
                <option value="+">+</option>
                <option value="-">-</option>
                <option value="*">*</option>
                <option value="/">/</option>
                <option value="^">^</option>
                <option value="!">!</option>
            </select>

            <label for="num2"></label>
            <input name="num2" type="text" id="num2" placeholder="Numero2">

            <button type="submit">Calcular</button>
            <button type="submit" name="historico">Histórico</button>
            <input type="submit" name="limpar" value="Limpar Histórico">
        </form>

        <?php
        session_start();

        // Serve para mostrar o histórico
        if (isset($_POST['historico'])) {
            if (!empty($_SESSION['historico'])) {
                echo "<div id=\"history\"><h2>Histórico:</h2>";
                foreach ($_SESSION['historico'] as $op) {
                    echo "<p>$op</p>";
                }
                echo "</div>";
            }
        }

        //serve para limpar o histórico
        if (isset($_POST['limpar'])) {
            unset($_SESSION['historico']);
        }

        //if para mudar os numeros para inteiros, pois sempre dava erro no resultado, pesquisei muito mas so consegui achar essa solucao
        if (isset($_POST['num1']) && isset($_POST['num2']) && isset($_POST['operador'])) {
            $num1 = intval($_POST['num1']);
            $num2 = intval($_POST['num2']);
            $operador = $_POST['operador'];

            //Iniciando a function
            $resultado = conta($operador, $num1, $num2);
            echo "<div id=\"history\"><p>Resultado: $resultado</p></div>";
        }

        //aqui criei uma function para fazer as contas pedidas
        function conta($operador, $num1, $num2) {
            switch ($operador) {
                case '+':
                    $resultado = $num1 + $num2;
                    break;
                case '-':
                    $resultado = $num1 - $num2;
                    break;
                case '*':
                    $resultado = $num1 * $num2;
                    break;
                case '/':
                    $resultado = $num1 / $num2;
                    break;
                case '^':
                    $resultado = pow($num1, $num2);
                    break;
                case '!':
                    $resultado = calcularFatorial($num1);
                    break;
                default:
                    $resultado = "Digite novamente";
                    break;
            }

            if ($num1 == 0 || $num2 == 0) {
                return $resultado;
            } else {
                $_SESSION['historico'][] = "$num1 $operador $num2 = $resultado";
                return $resultado;
            }
        }

        //function para calcular o fatorial achei mais facil fazer assim do que deixar uma bagunça la dentro do switch
        function calcularFatorial($num) {
            if ($num == 0) {
                return 1;
            } else {
                return $num * calcularFatorial($num - 1);
            }
        }
        ?>
    </div>
</body>

</html>