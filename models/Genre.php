<?php
class Genre extends Objet {

    // Properties
    protected $numGenre;
    protected $intitule;
    protected static $cle = "numGenre";
    protected static $objet = "Genre";

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

    public function afficher(){
        return $this->get('intitule');
    }
}