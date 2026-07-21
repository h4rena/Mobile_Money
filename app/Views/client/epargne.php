<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <form action="/epargne/store" method="POST">
        <input type="hidden" name="id_client" value="<?= $client['id_client'] ?>">
        <input type="number" name="pourcentage_ep" id="pourcentage_ep" min="1" placeholder="Entrez le pourcentage epargne" required>
         <button type="submit" >
              <i></i>valider
            </button>

    </form>
</body>
</html>