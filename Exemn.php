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
}
class Heros extends Personnage{
    public $liste_attaque;
    public $Liste;
    public function __construct($N, $NV, $PA, $A){
        $this->liste_attaque = array($A, $PA);
        $this->Liste = array($this->liste_attaque);
        print_r($this->Liste);
        parent::__construct($N, $NV, $PA, $A);
    }
    
    public function debloquer ($nouvelle_attaque, $nouveau_degat) {
        array_push($this -> Liste, array($nouvelle_attaque, $nouveau_degat));
    }

    public function attaquer($nom_vilain)
    {
        echo $this->nom . " attaque " . $nom_vilain;
        echo "\n";
    }

    public function prendre_degat($puissance_vilain, $attaque_choisie)
    {
        foreach ($this->Liste as $attaque) {
            if ($attaque[0] === $attaque_choisie) { // Comparer le nom de l'attaque
                $this->niveau_de_vie -= (int) $puissance_vilain;
                return $this->niveau_de_vie;
            }
        }
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

    public function attaquer($nom_hero)
    {
        echo $this->nom . " attaque " . $nom_hero;
        echo "\n";
    }

    public function prendre_degat($puissance_hero, $attaque_choisie)
    {
        $this->niveau_de_vie -= (int) $puissance_hero;
        return $this->niveau_de_vie;
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

    public function gerer_attaque_vilain($hero, $vilain){
        $vilain->attaquer($hero->nom); // Le vilain attaque le héros
        // var_dump($hero -> Liste);
        foreach($hero -> Liste as $valeur){
            echo "Nom d'attaque: ". $valeur[0] . "\n";
            echo "Puissace d'attaque: ". $valeur[1]. "\n";
        }
        $attaque_choisie = readline("Entrez l'attaque que l'hero veut utiliser ");
        $hero->prendre_degat($vilain->puissances_attaque, $attaque_choisie); // Le héros prend des dégâts du vilain
        return $hero->niveau_de_vie;
    }
    
    
    public function gerer_attaque_hero($hero, $vilain){
        $hero->attaquer($vilain->nom); // Le héros attaque le vilain
        $vilain->prendre_degat($hero->puissances_attaque, $hero->attaque); // Le vilain prend des dégâts du héros
        return $vilain->niveau_de_vie;
    }
    
    

public function gerer_attaque($hero,$vilain){
    $s = 0;
    $paire = 0;
    while ($hero -> niveau_de_vie > 0 && $vilain -> niveau_de_vie > 0){
        if($paire %2==0)
        {
            $this -> gerer_attaque_hero($hero,$vilain);
            echo "Point de vie de l'Heros : " . $hero->niveau_de_vie . "\n";
            echo "Point de vie du Vilain : " . $vilain->niveau_de_vie . "\n";
            $paire++;
        }
        else
        {
            $this -> gerer_attaque_vilain($hero,$vilain);
            echo "Point de vie de l'Heros : " . $hero->niveau_de_vie . "\n";
            echo "Point de vie du Vilain : " . $vilain->niveau_de_vie . "\n";
            $paire++;
        }


    }
}
public function combat(){
    $this -> afficher_heros();
    $choix = readline("Entre le nom de votre hero ");
    $h = $this->test_hero($choix);
    $v = $this->choix_vilain();

    $this->gerer_attaque($h, $v); // Correction ici

    $f = $this->fin_combat($h, $v);
    $r = 0;
    while ($f == "gagné"){
            if($r == 0)
            {
                // popen("cls", "w");
                echo "\nVous avez gagné le premier combat, félicitations à vous\n";
                echo "Bonne chance pour le prochain match\n";
                $v = $this->choix_vilain();
                $h->debloquer("Kameya", 60);
                $this->gerer_attaque($h, $v); // Correction ici
                $f = $this->fin_combat($h, $v);
                $r++;
            }
            elseif($r ==1)
            {
                // popen("cls", "w");
                echo "\nVous avez gagné ton deuxième combat, félicitations à vous\n";
                echo "Bonne chance pour le prochain match\n";
                $v = $this->choix_vilain();
                $h->debloquer("Kameya avancé", 65);
                $this->gerer_attaque($h, $v); // Correction ici
                $f = $this->fin_combat($h, $v);
                $r++;
            }
            elseif($r==2){
                   // popen("cls", "w");
                   echo "\nVous avez gagné ton troisième combat, félicitations à vous\n";
                   echo "La partie est fini ";
                   echo "Le niveau 2 arrive bientôt préparez-vous";
                   echo "Bonne chance pour le prochain match\n";
                   $v = $this->choix_vilain();
                   $h->debloquer("Kameya avancé", 65);
                   $this->gerer_attaque($h, $v); // Correction ici
                   $f = $this->fin_combat($h, $v);
                   $r++;
                   break; 
            }
        }
        echo "Vous avez perdu votre". $r. "eme combat contre ". $v->nom ."\n";
        echo "Mise à jour à venir pour la demande de rejouer ";
    }


public function menu(){
    $Menu = readline("1) Jouer \n 2) Quitter \n");
    $s = 3;
    $this -> combat();
}

public function fin_combat($hero, $vilain) {
    if ($hero->niveau_de_vie > $vilain->niveau_de_vie) {
        echo $hero->nom . " a gagné\n";
        return "gagné";
    } elseif ($hero->niveau_de_vie < $vilain->niveau_de_vie) {
        echo $vilain->nom . " a gagné\n";
        echo "GAME OVER\n";
    } else {
        $question = readline("Combien d'auteurs y a-t-il pour le manga DBZ? ");
        if ($question == 2) {
            echo $vilain->nom . " a gagné\n";
            echo "GAME OVER\n";
        } else {
            echo $hero->nom . " a gagné\n";
            return "gagné";
        }
    }
}

}

$nom_utilisateur = readline("Entrez votre nom \n");
// $Menu = readline("1) Jouer \n 2) Quitter \n");
$Hero1 = new Heros("Goku",200,40,"Boule de feu");
$Hero2 = new Heros("Vegeta", 200,40,"Boule de feu");
$Vilain1 = new Vilain("Freezer",100,30,"Boule de feu");
$Vilain2 = new Vilain("Broli",100,60,"Boule de feu");

$Game = new Jeu(array($Hero1 -> nom, $Hero1 -> niveau_de_vie, $Hero1 -> puissances_attaque, $Hero1 -> attaque),
array($Hero2 -> nom, $Hero2 -> niveau_de_vie, $Hero2 -> puissances_attaque, $Hero2 -> attaque),
array($Vilain1 -> nom, $Vilain1 -> niveau_de_vie, $Vilain1 -> puissances_attaque, $Vilain1 -> attaque),
array($Vilain2 -> nom, $Vilain2 -> niveau_de_vie, $Vilain2 -> puissances_attaque, $Vilain2 -> attaque));

$Game -> combat();

?>
