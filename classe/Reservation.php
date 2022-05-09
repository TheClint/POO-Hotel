<?php
    class Reservation{

        //attributs
        private Chambre $_chambre;
        private Client $_client;
        private DateTime $_dateEntree;
        private DateTime $_dateSortie;
        private bool $_avecWifi;

        //constructeur
        public function __construct(Chambre $chambre, Client $client, DateTime $dateEntree, DateTime $dateSortie, bool $avecWifi)
        {
            $this->_chambre=$chambre;
            $this->_client=$client;
            $this->_dateEntree=$dateEntree;
            // entree à 16h
            $this->_dateEntree->setTime(16, 0);
            $this->_dateSortie=$dateSortie;
            // sortie à 12h
            $this->_dateSortie->setTime(12, 0);
            if($chambre->getALeWifi())
                $this->_avecWifi=$avecWifi;
        }

        //getter
        public function getChambre(){
            return $this->_chambre;
        }

        public function getClient(){
            return $this->_client;
        }

        public function getDateEntree(){
            return $this->_dateEntree;
        }

        public function getDateSortie(){
            return $this->_dateSortie;
        }

        public function getAvecWifi(){
            return $this->_avecWifi;
        }

        //setter
        public function setChambre($chambre){
            $this->_chambre=$chambre;
        }

        public function setClient($client){
            $this->_client=$client;
        }

        public function setDateEntree($dateEntree){
            $this->_dateEntree=$dateEntree;
            // entree à 16h
            $this->_dateEntree->setTime(16, 0);
        }

        public function setDateSortie($dateSortie){
            $this->_dateSortie=$dateSortie;
            // sortie à 12h
            $this->_dateSortie->setTime(12, 0);
        }

        public function setAvecWifi($avecWifi){
            if($this->_chambre->getALeWifi())
                $this->_avecWifi=$avecWifi;
        }


        //methodes


        // fonction pour savoir si une date est inclus dans l'intervalle de la reservation
        public function estInclusDansLaPeriodeDeReservation(DateTime $date){
            return ($this->_dateEntree->getTimestamp()<$date->getTimestamp() && $date->getTimestamp()<$this->_dateSortie->getTimestamp()) ?  true : false;
        }

        // fonction qui retourne vrai si les dates en paramètre sont toutes deux inférieures à la date d'entrée de la reservation, ou toutes deux supérieures à la date de sortie de la réservation.
        public function estReservable(DateTime $dateEntree, DateTime $dateSortie){
            return (($dateEntree->getTimestamp()<$this->_dateEntree->getTimestamp()&&$dateSortie->getTimestamp()<$this->_dateEntree->getTimestamp())||($dateEntree->getTimestamp()>$this->_dateSortie->getTimestamp()&&$dateSortie->getTimestamp()>$this->_dateSortie->getTimestamp())) ?  true : false;
        }

        //retourne le nombre de jour de la reservation
        public function dureeDeSejour(){
            return (int)(($this->_dateSortie->getTimestamp()-$this->_dateEntree->getTimestamp())/(60*60*24))+1;
        }

        //tostring
        public function __toString()
        {
            return $this->getClient()." - Chambre ".$this->_chambre->getNumeroDeChambre()." - du ".$this->getDateEntree()->format('Y-m-d')." au ".$this->getDateSortie()->format('Y-m-d');
        }

    }
?>