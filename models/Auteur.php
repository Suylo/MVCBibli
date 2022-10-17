<?php

class Auteur extends Objet {

// attributs
	protected static $objet = "Auteur";
	protected static $cle = "numAuteur";
	protected $numAuteur;
	protected $nom;
	protected $prenom;
	protected $anneeNaissance;

	public function get($attribut)
	{
		return parent::get($attribut); // TODO: Change the autogenerated stub
	}

	public function set($attribut, $valeur)
	{
		parent::set($attribut, $valeur); // TODO: Change the autogenerated stub
	}

	public function __construct($data = NULL)
	{
		parent::__construct($data);
	}

	public static function addAuteur($nom, $prenom, $naissance){
		$requete = "INSERT INTO Auteur (nom, prenom, anneeNaissance) VALUES (:nom, :prenom, :anneeNaissance)";
		$req_prep = Connexion::pdo()->prepare($requete);
		$tab = array(
			"nom" => $nom,
			"prenom" => $prenom,
			"anneeNaissance" => $naissance
		);
		try {
			$req_prep->execute($tab);
			return true;
		} catch (PDOException $e) {
			echo "Erreur d'ajout : " . $e->getMessage();
			return false;
		}
	}

	// update auteur
	public static function updateAuteur($numAuteur, $nom, $prenom, $anneeNaissance){
		$requete = "UPDATE Auteur SET nom = :nom, prenom = :prenom, anneeNaissance = :anneeNaissance WHERE numAuteur = :numAuteur";
		$req_prep = Connexion::pdo()->prepare($requete);
		$tab = array(
			"numAuteur" => $numAuteur,
			"nom" => $nom,
			"prenom" => $prenom,
			"anneeNaissance" => $anneeNaissance
		);
		try {
			$req_prep->execute($tab);
			return true;
		} catch (PDOException $e) {
			echo "Erreur de modification : " . $e->getMessage();
			return false;
		}
	}

	public static function getNationalitesByNumAuteur($i){
		$requete = "select * from nationalite inner join estdenationalite e on nationalite.numNationalite = e.numNationalite where numAuteur = :numAuteur";
		$req_prep = Connexion::pdo()->prepare($requete);
		$tab = array(
			"numAuteur" => $i
		);
		try {
			$req_prep->execute($tab);
			$req_prep->setFetchMode(PDO::FETCH_CLASS, 'Nationalite');
			$tab = $req_prep->fetchAll();
			return $tab;
		} catch (PDOException $e) {
			echo "Erreur de récupération : " . $e->getMessage();
			return false;
		}
	}

	public static function getNonNationalitesByNumAuteur($i){
		$requete = "select * from nationalite where numNationalite not in (select numNationalite from estdenationalite where numAuteur = :numAuteur)";
		$req_prep = Connexion::pdo()->prepare($requete);
		$tab = array(
			"numAuteur" => $i
		);
		try {
			$req_prep->execute($tab);
			$req_prep->setFetchMode(PDO::FETCH_CLASS, 'Nationalite');
			$tab = $req_prep->fetchAll();
			return $tab;
		} catch (PDOException $e) {
			echo "Erreur de récupération : " . $e->getMessage();
			return false;
		}
	}

	public static function addNationaliteForAuteur($numAuteur, $numNationalite)
	{
		$requete = "INSERT INTO estdenationalite (numAuteur, numNationalite) VALUES (:numAuteur, :numNationalite)";
		$req_prep = Connexion::pdo()->prepare($requete);
		$tab = array(
			"numAuteur" => $numAuteur,
			"numNationalite" => $numNationalite
		);
		try {
			$req_prep->execute($tab);
			return true;
		} catch (PDOException $e) {
			echo "Erreur d'ajout : " . $e->getMessage();
			return false;
		}
	}

	public static function deleteNationaliteForAuteur($numAuteur, $numNationalite)
	{
		$requete = "DELETE FROM estdenationalite WHERE numAuteur = :numAuteur AND numNationalite = :numNationalite";
		$req_prep = Connexion::pdo()->prepare($requete);
		$tab = array(
			"numAuteur" => $numAuteur,
			"numNationalite" => $numNationalite
		);
		try {
			$req_prep->execute($tab);
			return true;
		} catch (PDOException $e) {
			echo "Erreur de suppression : " . $e->getMessage();
			return false;
		}
	}
}
?>
