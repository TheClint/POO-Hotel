<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POO Hotel</title>
    <link href="CSS/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/490620123f.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        spl_autoload_register(function($classe){
            require  "classe\\".$classe. '.php';
        });


        //création des hotels
        $hotel1 = new Hotel("Hilton", "10", "route de la Gare", "67000", "Strasbourg", 2, 10);
        $hotel2 = new Hotel("Régent", "10", "route de la Gare", "75000", "Paris", 2, 10);


        //création des clients
        $client1 = new Client("GIBELLO", "Virgile");
        $client2 = new Client("MURMANN", "Micka");

        //création de réservation
        $hotel1->reserverUneChambre($client1, true, new DateTime("2022/05/03"), new DateTime("2022/05/09"));
        $hotel1->reserverUneChambre($client1, true, new DateTime("2022/05/07"), new DateTime("2022/05/08"));
        $hotel1->reserverUneChambre($client2, true, new DateTime("2022/05/07"), new DateTime("2022/05/08"));
        $hotel1->reserverUneChambre($client1, true, new DateTime("2022/06/07"), new DateTime("2022/07/08"));
        $hotel1->reserverUneChambre($client2, true, new DateTime("2022/05/07"), new DateTime("2022/05/20"));

        $hotel1->affichageEtatReservation();
        $hotel1->affichageReservation();
        $hotel2->affichageReservation();
        $client1->affichageReservationParClient();
        $hotel1->affichageStatutDesChambre();


    ?>
    
</body>
</html>