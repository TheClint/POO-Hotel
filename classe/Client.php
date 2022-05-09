<?php
    class Client{

        //attribut
        private string $_nom;
        private string $_prenom;
        private array $_tableauDeReservations;

        //constructeur

        public function __construct(string $nom, string $prenom)
        {
            $this->_nom=$nom;
            $this->_prenom=$prenom;
            $this->_tableauDeReservations = [];
        }

        //getter
        public function getNom(){
            return $this->_nom;
        }

        public function getPrenom(){
            return $this->_prenom;
        }

        public function getTableauDeReservations(){
            return$this->_TableauDeReservations;
        }

        //setter

        public function setNom(string $nom){
            $this->_nom=$nom;
        }

        public function setPrenom(string $prenom){
            $this->_prenom=$prenom;
        }

        public function ajouterReservation(Reservation $reservation){
            $this->_tableauDeReservations[] = $reservation;
        }

        public function affichageReservationParClient(){
            $prixTotal = 0;
            echo "Réservation de $this->_prenom $this->_nom <br>
            <div class=\"reservation\">".count($this->_tableauDeReservations)." reservation(s)</div> <br>";
            foreach($this->_tableauDeReservations as $reservation){
                $prixTotal+=$reservation->getChambre()->getPrix()*$reservation->dureeDeSejour()
                ;
                if($reservation->getChambre()->getALeWifi())
                    $aLeWifi = "oui";
                else
                    $aLeWifi = "non";
                echo "<strong>Hotel : </strong>".$reservation->getChambre()->getHotelProprietaire()." / Chambre : ".$reservation->getChambre()->getNumeroDeChambre()." (".$reservation->getChambre()->getNombreDeLit()." lit(s) - ".$reservation->getChambre()->getPrix()." € - Wifi : ".$aLeWifi.") du ".$reservation->getDateEntree()->format('Y-m-d')." au ".$reservation->getDateSortie()->format('Y-m-d')."<br>";
            }
            echo "Total : $prixTotal €";
        }


        //toString
        public function __toString()
        {
            return $this->_prenom." ".strtoupper($this->_nom);
        }
    }
?>