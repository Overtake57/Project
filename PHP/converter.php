<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $amount = floatval($_POST['amount']);
    $from_currency = $_POST['from_currency'];
    $to_currency = $_POST['to_currency'];

    // Vérification que les données sont valides
    if ($amount <= 0) {
        $error_message = "Le montant doit être supérieur à zéro.";
    } elseif ($from_currency == $to_currency) {
        $error_message = "Les devises de départ et d'arrivée ne peuvent pas être identiques.";
    } else {
        // Conversion de devise
        $exchange_rate = get_exchange_rate($from_currency, $to_currency);
        $converted_amount = $amount * $exchange_rate;
    }
}

// Fonction pour récupérer le taux de change entre deux devises
function get_exchange_rate($from_currency, $to_currency)
{
    $exchange_rates = array(
        'EUR' => array('USD' => 1.19, 'GBP' => 0.86, 'JPY' => 129.16),
        'USD' => array('EUR' => 0.84, 'GBP' => 0.72, 'JPY' => 108.39),
        'GBP' => array('EUR' => 1.16, 'USD' => 1.38, 'JPY' => 151.57),
        'JPY' => array('EUR' => 0.0077, 'USD' => 0.0092, 'GBP' => 0.0066)
    );
    return $exchange_rates[$from_currency][$to_currency];
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <h1>Convertisseur de devises</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php } ?>
            <div class="form-group">
                <label for="amount">Montant à convertir :</label>
                <input type="number" class="form-control" id="amount" name="amount"
                    value="<?php echo isset($amount) ? $amount : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="from_currency">Devise de départ :</label>
                <select class="form-control" id="from_currency" name="from_currency" required>
                    <option value="EUR"
                        <?php echo isset($from_currency) && $from_currency == 'EUR' ? ' selected' : ''; ?>>Euro</option>
                    <option value="USD"
                        <?php echo isset($from_currency) && $from_currency == 'USD' ? ' selected' : ''; ?>>Dollar
                        américain</option>
                    <option value="GBP"
                        <?php echo isset($from_currency) && $from_currency == 'GBP' ? ' selected' : ''; ?>>
                        Livre sterling</option>
                    <option value="JPY"
                        <?php echo isset($from_currency) && $from_currency == 'JPY' ? ' selected' : ''; ?>>Yen japonais
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="to_currency">Devise d'arrivée :</label>
                <select class="form-control" id="to_currency" name="to_currency" required>
                    <option value="EUR" <?php echo isset($to_currency) && $to_currency == 'EUR' ? ' selected' : ''; ?>>
                        Euro</option>
                    <option value="USD" <?php echo isset($to_currency) && $to_currency == 'USD' ? ' selected' : ''; ?>>
                        Dollar américain</option>
                    <option value="GBP" <?php echo isset($to_currency) && $to_currency == 'GBP' ? ' selected' : ''; ?>>
                        Livre sterling</option>
                    <option value="JPY" <?php echo isset($to_currency) && $to_currency == 'JPY' ? ' selected' : ''; ?>>
                        Yen japonais</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Convertir</button>
        </form>
        <?php if (isset($converted_amount)) { ?>
        <div class="alert alert-success mt-3">
            <?php echo $amount . ' ' . $from_currency . ' = ' . $converted_amount . ' ' . $to_currency; ?></div>
        <?php } ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>