<?php
class Personnage{
    public $nom;
    public $niveau_de_vie;
    public $puissances_attaque;
    public $attaque;

    public function __construct($N,$NV,$PA,$A){
        $this->nom = $N;
        $this->niveau_de_vie = $NV;
        $this->puissances_attaque = $PA;
        $this->attaque = $A;
    }
    //public function AfficherStatistique($niveau_de_vie,$puissances_attaque){
        //echo "Niveau de vie :".$this->$niveau_de_vie;
        //echo "Puissanc de l'attaque :".$this->$puissances_attaque;
    //}
}
class Heros extends Personnage{
    public function __construct($N,$NV,$PA,$A){
        parent::__construct($N,$NV,$PA,$A);
    }

    public function getNom()
    {
        return $this->nom;
    }
    public function getNV()
    {
        return $this->niveau_de_vie;
    }
    public function getPuissancesAttaque()
    {
        return $this->attaque;
    }
    public function getAttaque(){
        return $this->attaque;
    }
    public function attaquer($nom_vilain)
    {
        echo $this -> nom . " attaque " . $nom_vilain. " avec". $this -> attaque; 
        echo "\n";
    }
    public function prendre_degat($vie_Vilain)
    {
        (int) $this -> puissances_attaque -= (int) $vie_Vilain;
    }

    public function mourir()
    {
        if($this -> niveau_de_vie == 0){
            echo $this -> nom . "est mort";
            return "true";
        }
    }

}

class Vilain extends Personnage{
    public function __construct($N,$NV,$PA,$A){
        parent::__construct($N,$NV,$PA,$A);
    }
    public function getNom()
    {
        return $this->nom;
    }
    public function getNV()
    {
        return $this->niveau_de_vie;
    }
    public function getPuissancesAttaque()
    {
        return $this->attaque;
    }
    public function getAttaque()
    {
        return $this->attaque;
    }
    public function attaquer($nom_hero)
    {
        echo $this -> nom . " attaque " . $nom_hero. " avec ". $this -> attaque; 
        echo "\n";
    }
    public function prendre_degat($vie_hero)
    {
        (int) $this -> puissances_attaque -=(int) $vie_hero;
    }

    public function mourir()
    {
        if($this -> niveau_de_vie == 0){
            echo $this -> nom . "est mort";
            return "true";
        }
    }
}

class Jeu{
    public $hero1;
    public $hero2;
    public $vilain1;
    public $vilain2;
    public $liste_heros;
    public $liste_vilains;
    public function __construct($H1,$H2,$V1,$V2)
    {
        $this -> hero1 = $H1;
        $this -> hero2 = $H2;
        $this -> vilain1 = $V1;
        $this -> vilain2 = $V2;
        $this -> liste_heros = array($H1,$H2);
        $this -> liste_vilains = array($V1,$V2);

    }

    public function afficher_heros()
    {
        echo "Voici les héros avec leurs stats \n";
        foreach($this->liste_heros as $k => $v) 
        {
            foreach($v as $k2 => $v2)
            {
                print_r($v2);
                echo "\n";

            }
        }
    }
    public function test_hero($hero_user){
        foreach($this->liste_heros as $k => $v){
            foreach($v as $k2 => $v2){
                if($v2 == $hero_user){
                    $hero = new Heros($v[0],$v[1],$v[2],$v[3]);
                    return $hero;
                }
            }
    }
}
    public function choix_vilain(){
        $aleatoire = rand(0,count($this->liste_vilains)-1);
        $resultat = $this->liste_vilains[$aleatoire];
        $vilain = new Vilain($resultat[0],$resultat[1],$resultat[2],$resultat[3]);
        return $vilain;
    }

public function gerer_attaque_hero($hero,$vilain){
        $hero -> attaquer($vilain -> nom);
        $hero -> prendre_degat($vilain -> puissances_attaque);
        return $vilain -> niveau_de_vie;
    }

public function gerer_attaque_vilain($hero,$vilain){
    $vilain -> attaquer($hero -> nom);
    $vilain -> prendre_degat($hero -> puissances_attaque);
    return $hero -> niveau_de_vie;
    }

public function gerer_attaque($attaque1,$attaque2,$hero,$vilain){
    $s = 0;
    $attaque1 = $this -> gerer_attaque_vilain($hero,$vilain);
    $attaque2 = $this -> gerer_attaque_hero($hero,$vilain);
    while ($s <1){
        echo "Voici le point de vie de l'Heros ". $attaque1;
        echo "\n";
        echo "Voici le point de vie du Vilain ".$attaque2;
        echo "\n";
        $s++;
    }
}


public function fin_combat($hero,$vilain){
    $aleatoir = rand(0,1);
    if($hero -> niveau_de_vie > $vilain -> niveau_de_vie){
       echo $hero -> nom. " a gagné ";
    }
    elseif($hero -> niveau_de_vie > $vilain -> niveau_de_vie){
        echo $vilain -> nom. " a gagné ";
    }
    else{
        if($aleatoir == 0){
            echo $vilain -> nom ." a gagné ";
        }
        else{
            echo $hero -> nom." a gagné ";
        }
    }
    return $hero->niveau_de_vie;
}
 public function nouveau_combat($nouveau_vilain,$niveau_de_vie_hero,$hero){
        echo "\n Bien joué vous passez au second combat ";
        // $nouveau_vilain = $this -> choix_vilain();
        if($niveau_de_vie_hero > 0){
            $r1 = $this -> gerer_attaque_hero($hero,$nouveau_vilain);
            $r2 = $this -> gerer_attaque_vilain($hero,$nouveau_vilain);
            $this -> gerer_attaque($r1,$r2,$hero,$nouveau_vilain);
        }
    }
}

$Hero1 = new Heros("Goku",3,5,"Boule de feu");
$Hero2 = new Heros("Vegeta",3,4,"Boule de feu");
$Vilain1 = new Vilain("Freezer",3,3,"Boule de feu");
$Vilain2 = new Vilain("Broli",2,6,"Boule de feu");

$Game = new Jeu(array($Hero1 -> nom, $Hero1 -> niveau_de_vie, $Hero1 -> puissances_attaque, $Hero1 -> attaque),
array($Hero2 -> nom, $Hero2 -> niveau_de_vie, $Hero2 -> puissances_attaque, $Hero2 -> attaque),
array($Vilain1 -> nom, $Vilain1 -> niveau_de_vie, $Vilain1 -> puissances_attaque, $Vilain1 -> attaque),
array($Vilain2 -> nom, $Vilain2 -> niveau_de_vie, $Vilain2 -> puissances_attaque, $Vilain2 -> attaque));

$Game -> afficher_heros();
// $Game -> gerer_game($Game -> choix_hero(),$Game -> choix_vilain());
$choix = readline("Entre le nom de votre hero ");
$h = $Game -> test_hero($choix);
$v = $Game -> choix_vilain();
$Game->gerer_attaque($Game -> gerer_attaque_hero($h, $v),
$Game -> gerer_attaque_vilain($h, $v),$h,$v);
//$Hero1 ->AfficherStatistique($niveau_de_vie,$puissances_attaque);

// echo "\n";
echo "Voici votre nouveau combat ";
$nouveau_vilain = $Game -> choix_vilain();
$Game -> nouveau_combat($nouveau_vilain,$Game -> fin_combat($h,$v),$h);












?>
