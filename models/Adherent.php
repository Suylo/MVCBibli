<?php

class Adherent extends Objet
{

    protected static $objet = "Adherent";
    protected static $cle = "login";
    protected $login;
    protected $mdp;
    public $nomAdherent;
    public $prenomAdherent;
    protected $email;
    protected $dateAdhesion;
    public $isAdmin;
    protected $numCategorie;
    protected $champValidationEmail;

    public function isAdmin() {
        return $this->isAdmin == 1;
    }

    public function affichable()
    {
        return !$this->isAdmin; // TODO: Change the autogenerated stub
    }

    public function afficher(){
        return $this->get('nomAdherent') . " " . $this->get('prenomAdherent') . " : " . $this->get('dateAdhesion');
    }

    public function __construct($data = NULL)
    {
        parent::__construct($data);
    }

    public function get($attribut)
    {
        return parent::get($attribut); // TODO: Change the autogenerated stub
    }

    public function set($attribut, $valeur)
    {
        parent::set($attribut, $valeur); // TODO: Change the autogenerated stub
    }

    /**
     * @param $login
     * @param $mdp
     * @param $nom
     * @param $prenom
     * @param $email
     * @param $dateAdhesion
     * @return bool
     */
    public static function addAdherent($login, $mdp, $nom, $prenom, $email, $dateAdhesion){
        $ch = bin2hex(openssl_random_pseudo_bytes(16));
        $requete = "INSERT INTO Adherent VALUES (:login, :mdp, :nomAdherent, :prenomAdherent, :email, :dateAdhesion, 1, 0, :ch)";
        $req_prep = Connexion::pdo()->prepare($requete);
        $tab = array(
            "login" => $login,
            "mdp" => $mdp,
            "nomAdherent" => $nom,
            "prenomAdherent" => $prenom,
            "email" => $email,
            "dateAdhesion" => $dateAdhesion,
            "ch" => $ch
        );
        try {
            $req_prep->execute($tab);
            return true;
        } catch (PDOException $e) {
            echo "Erreur d'ajout : " . $e->getMessage();
            return false;
        }
    }

    public static function updateAdherent($login, $mdp, $nom, $prenom, $email, $dateAdhesion){
        $requete = "UPDATE Adherent SET mdp = :mdp, nomAdherent = :nomAdherent, prenomAdherent = :prenomAdherent, email = :email, dateAdhesion = :dateAdhesion, numCategorie = 1 WHERE login = :login";
        $req_prep = Connexion::pdo()->prepare($requete);
        $tab = array(
            "login" => $login,
            "mdp" => $mdp,
            "nomAdherent" => $nom,
            "prenomAdherent" => $prenom,
            "email" => $email,
            "dateAdhesion" => $dateAdhesion,
        );
        try {
            $req_prep->execute($tab);
            return true;
        } catch (PDOException $e) {
            echo "Erreur de modification : " . $e->getMessage();
            return false;
        }
    }

    public static function checkMDP($l, $m)
    {
        // if $l & $m return 1 from adherent table
        $query = "SELECT * FROM Adherent WHERE login = :login AND mdp = :mdp";
        $req_prep = Connexion::pdo()->prepare($query);
        $tab = [
            "login" => $l,
            "mdp" => $m
        ];
        try {
            $req_prep->execute($tab);
            $req_prep->setFetchmode(PDO::FETCH_CLASS, 'Adherent');
            $return = $req_prep->fetch();
            if ($return != null){
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e){
            echo "Erreur get ; " . $e->getMessage();
            return false;
        }
    }
}