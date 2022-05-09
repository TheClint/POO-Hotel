<?php

    class Hotel{

        //Attributs

        private string $_nom;
        private int $_nombreEtage;
        private int $_chambreParEtage;
        private array $_TabChambres;

        //Addresse
        private string $_numeroDeLaVoie;
        private string $_intituleDeLaVoie;
        private string $_codePostal;
        private string $_ville;
       

        // Constructeur
        public function __Construct(string $nom, string $numeroDeLaVoie, string $intituleDeLaVoie, string $codePostal, string $ville, int $nombreEtage, int $chambreParEtage){
            $this->_nom=$nom;
            $this->_numeroDeLaVoie=$numeroDeLaVoie;
            $this->_intituleDeLaVoie=$intituleDeLaVoie;
            $this->_codePostal=$codePostal;
            $this->_ville=$ville;
            $this->_nombreEtage=$nombreEtage;
            $this->_chambreParEtage=$chambreParEtage;

            // génération automatique des chambres de l'hotel, de 0 à n pour le numéro des étages, de 1 à m+1 pour le numéro des chambres, initiatilisation aléatoire du wifi et du nombre de lit dans les chambres
            for($i=0; $i<$nombreEtage; $i++){
                for($j=1; $j<$chambreParEtage+1; $j++){
                    $this->_TabChambres[$i.$j]=new Chambre($i.$j, random_int(1,4), (bool)random_int(0,1), false, $this);
                }
            }
        }

        //getter

        public function getNom(){
            return $this->_nom;
        }

        public function getNombreEtage(){
            return $this->_nombreEtage;
        }

        public function getChambreParEtage(){
            return $this->_chambreParEtage;
        }

        public function getAdresse(){
            return $this->_numeroDeLaVoie." ".$this->_intituleDeLaVoie." ".$this->_codePostal." ".strtoupper($this->_ville);
        }

        //setter

        public function setNom(string $nom){
            $this->_nom=$nom;
        }



        public function nombreDeChambreReserve(){
            $this->actualisationChambreReservee();
            $compteur=0;
            foreach($this->_TabChambres as $numero => $chambre){
                if($chambre->getEstReserve())
                    $compteur++;
            }
        return $compteur;
        }

        public function reserverUneChambre(Client $client, bool $avecWifi, DateTime $dateDEntree, DateTime $dateDeSortie){
            foreach($this->_TabChambres as $numero => $chambre){
                if($chambre->reserverCetteChambre($client, $avecWifi, $dateDEntree, $dateDeSortie))
                    break;
            }
        }

        public function affichageReservation(){
            echo "<h2> Reservation  de l'hôtel $this->_nom **** $this->_ville</h2>";
            if($this->nombreDeChambreReserve()!=0){
                echo $this->nombreDeChambreReserve()." réservations<br>";
                foreach($this->_TabChambres as $numero => $chambre){
                    $chambre->affichageReservation();
                }
            }
            else
                echo "Aucune reservation !<br>";
            

        }

        //fonction pour actualiser si les chambres sont réservées sur le jour en cour
        public function actualisationChambreReservee(){
            $dateDuJour = new DateTime('now');
            foreach($this->_TabChambres as $numero => $chambre){
                foreach($chambre->getTableauDeReservation() as $reservation){
                    if($reservation->estInclusDansLaPeriodeDeReservation($dateDuJour))
                        $chambre->setEstReserve("true");
                    else
                        $chambre->setEstReserve("false");
                }
            }
        }

        public function affichageStatutDesChambre(){
            $this->actualisationChambreReservee();
            echo "<table>
                    <thead>
                        <tr>
                            <th>CHAMBRE</th>
                            <th>PRIX</th>
                            <th>WIFI</th>
                            <th>ETAT</th>
                        </tr>
                    </thead>
                    <tbody>";
            foreach($this->_TabChambres as $numero => $chambre){
                echo "<tr>
                        <td> Chambre $numero</td>
                        <td>".$chambre->getPrix()."</td>
                        <td>";
                if($chambre->getaLeWifi())
                        echo "<i class=\"fa-solid fa-wifi\"></i>";
                echo    "</td>
                        <td>";
                if(!$chambre->getEstReserve())
                    echo "<div class=\"disponible\">DISPONIBLE</div>";
                else
                echo "<div class=\"reservee\">RESERVEE</div>";
                echo    "</td>
                        </tr>";
            }
            echo "</tbody>
                  </table>";
        }



        public function affichageEtatReservation()
        {
            echo $this."<br>".$this->getAdresse()."<br>
            Nombre de chambres : ".$this->_nombreEtage*$this->_chambreParEtage."<br>
            Nombre de chambres réservées : ".$this->nombreDeChambreReserve()."<br>
            Nombre de chambres dispo : ".(($this->_nombreEtage*$this->_chambreParEtage)-$this->nombreDeChambreReserve());
        }

        public function __toString(){
            return "<strong>$this->_nom **** $this->_ville</strong>";
        }
    }

?>