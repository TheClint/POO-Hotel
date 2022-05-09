<?php

    class Chambre{

        //Attribut
        private int $_numeroDeChambre;
        private int $_nombreDeLit;
        private bool $_aLeWifi;
        private bool $_estReserve;
        private array $_tableauDeReservations;
        private float $_prix;
        private Hotel $_hotelProprietaire;
    

        //constructeur
        public function __construct(int $numeroDeChambre, int $nombreDeLit, bool $aLeWifi, bool $estReserve, Hotel $hotelProprietaire)
        {
            $this->_numeroDeChambre=$numeroDeChambre;
            $this->_nombreDeLit=$nombreDeLit;
            $this->_aLeWifi=$aLeWifi;
            $this->_estReserve=$estReserve;
            $this->_tableauDeReservations = [];
            $this->_prix=$nombreDeLit*60+$aLeWifi*20;
            $this->_hotelProprietaire=$hotelProprietaire;
        }

        //getter

        public function getALeWifi(){
            return $this->_aLeWifi;
        }

        public function getEstReserve(){
            return $this->_estReserve;
        }

        public function getNumeroDeChambre(){
            return $this->_numeroDeChambre;
        }

        public function  getNombreDeLit(){
            return $this->_nombreDeLit;
        }

        public function  getTableauDeReservation(){
            return $this->_tableauDeReservations;
        }

        public function getPrix(){
            return $this->_prix;
        }

        public function getHotelProprietaire(){
            return $this->_hotelProprietaire;
        }

        //setter

        public function setALeWifi(bool $aLeWifi){
            $this->_aLeWifi=$aLeWifi;
        }

        public function setEstReserve(bool $estReserve){
            $this->_estReserve=$estReserve;
        }

        public function setNumeroDeLaChambre(int $numeroDeChambre){
            $this->_numeroDeChambre=$numeroDeChambre;
        }

        public function  setNombreDeLit(int $nombreDeLit){
            $this->_nombreDeLit=$nombreDeLit;
        }

        public function setPrix(float $prix){
            $this->_prix=$prix;
        }

        public function setHotelPropriétaire($hotelProprietaire){
            $this->_hotelProprietaire=$hotelProprietaire;
        }

        //reserver cette chambre retourne un booléen pour dire si la chambre a été réservée ou non
        public function reserverCetteChambre(Client $client, bool $avecWifi, DateTime $dateDEntree, Datetime $dateDeSortie){
            $estDejaReserve = false;
            foreach($this->_tableauDeReservations as $reservation){
                if($reservation->estReservable($dateDEntree, $dateDeSortie)){
                    $estDejaReserve = true;
                    break;
                }
            }
            if($estDejaReserve)
                return false; // retourne false si la chambre est déjà réservée
            else{
                // reservation de la chambre
                $nouvelleReservation = new Reservation($this, $client, $dateDEntree, $dateDeSortie, $avecWifi&&$this->_aLeWifi);
                $this->_tableauDeReservations[] = $nouvelleReservation;
                $client->ajouterReservation($nouvelleReservation);
                return true;
            }
        }

        public function affichageReservation(){
            foreach($this->_tableauDeReservations as $reservation){
                echo "<br>".$reservation."<br>";
            }
        }
    }

?>