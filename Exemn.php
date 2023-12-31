<?php
//Creation d'une class Personnage avec differents attribut
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
//Creation de la class Heros qui herite de la class Personnage
class Heros extends Personnage{
    public $liste_attaque;
    public $Liste;
    public function __construct($N, $NV, $PA, $A){
        $this->liste_attaque = array($A, $PA);
        $this->Liste = array($this->liste_attaque);
        print_r($this->Liste);
        parent::__construct($N, $NV, $PA, $A);
    }
    //Creation de la methode debloquer permet d'ajouter une nouvelle attaque et ses dégâts à la liste des attaques pour un héros. 
    public function debloquer ($nouvelle_attaque, $nouveau_degat) {
        // Crée un tableau contenant la nouvelle attaque et ses dégâts
        array_push($this -> Liste, array($nouvelle_attaque, $nouveau_degat));
    }
     //Creation de la methode attaquer qui permet à un héros d'effectuer une attaque contre un vilain 
    public function attaquer($nom_vilain)
    { //Cela va afficher le nom du vilain que le heros souhaite attaquer
        echo $this->nom . " attaque " . $nom_vilain;
        echo "\n";
    }
    //Creation de la methode prendre_degat permet au héros de subir des dégâts causés par un vilain à partir d'une attaque que le vilain a choisi.
    public function prendre_degat($puissance_vilain, $attaque_choisie)
    {
        foreach ($this->Liste as $attaque) {
            if ($attaque[0] === $attaque_choisie) { // Comparer le nom de l'attaque
                $this->niveau_de_vie -= (int) $puissance_vilain;
                return $this->niveau_de_vie;
            }
        }
    }
    


    //Creation de la methode qui fais que si le niveau de vie du Vilain est egal a 0 le Hero a gagné
    public function mourir()
    {
        if($this -> niveau_de_vie == 0){
            echo $this -> nom . "est mort";
            return "true";
        }
    }
}
//Creation de la class Vilain qui herite de la class Personnage
class Vilain extends Personnage{
    public function __construct($N,$NV,$PA,$A){
        parent::__construct($N,$NV,$PA,$A);
    }
    //Creation de la methode attaquer qui permet à un vilain d'effectuer une attaque contre un hero
    public function attaquer($nom_hero)
    {
        echo $this->nom . " attaque " . $nom_hero;
        echo "\n";
    }
     //Creation de la methode prendre_degat qui permet au vilain de subir des dégâts lorsque le héros l'attaque avec une attaque qu'aura choisi
    public function prendre_degat($puissance_hero, $attaque_choisie)
    {
        $this->niveau_de_vie -= (int) $puissance_hero;
        return $this->niveau_de_vie;
    }
    //Creation de la methode mourir qui quand le Vilain a 0 de point de vie il meurt
    public function mourir()
    {
        if($this -> niveau_de_vie == 0){
            echo $this -> nom . "est mort";
            return "true";
        }
    }
}
//Creation de la class Jeu qui permet de gerer le combat
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
    //Creation de methode afficher_heros qui affiche les stats des heros et leur heros
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
    // Permet de créer u objet héro en fonction de l'hero entré par le jouer
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
    //Choisir un héro aléatoirement
    public function choix_vilain(){
        $aleatoire = rand(0,count($this->liste_vilains)-1);
        $resultat = $this->liste_vilains[$aleatoire];
        $vilain = new Vilain($resultat[0],$resultat[1],$resultat[2],$resultat[3]);
        return $vilain;
    }
    //De gérer attaque du vilain vers l'hero
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
    
    // Gérer l'attaque de l'hero vers le vilain
    public function gerer_attaque_hero($hero, $vilain){
        $hero->attaquer($vilain->nom); // Le héros attaque le vilain
        $vilain->prendre_degat($hero->puissances_attaque, $hero->attaque); // Le vilain prend des dégâts du héros
        return $vilain->niveau_de_vie;
    }
    
    
    // Permet de gérer l'attaque entre l'héro et le vilain
    public function gerer_attaque($hero, $vilain){
        $s = 0;
        $paire = 0;
        while ($hero->niveau_de_vie > 0 && $vilain->niveau_de_vie > 0){
            if($paire % 2 == 0){
                $this->gerer_attaque_vilain($hero, $vilain);
                echo "Point de vie de l'Heros : " . $hero->niveau_de_vie . "\n";
                echo "Point de vie du Vilain : " . $vilain->niveau_de_vie . "\n";
                $paire++;
            }
            else{
                $this->gerer_attaque_hero($hero, $vilain);
                echo "Point de vie de l'Heros : " . $hero->niveau_de_vie . "\n";
                echo "Point de vie du Vilain : " . $vilain->niveau_de_vie . "\n";
                $paire++;
            }
        }
    }
//Permet de gérer le combat entre les deux
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
                popen("cls", "w");
                echo "\nVous avez gagné ton deuxième combat, félicitations à vous\n";
                echo "Bonne chance pour le prochain match\n";
                $v = $this->choix_vilain();
                $h->debloquer("Kameya avancé", 65);
                $this->gerer_attaque($h, $v); // Correction ici
                $f = $this->fin_combat($h, $v);
                $r++;
            }
            elseif($r==2){
                   popen("cls", "w");
                   echo "\nVous avez gagné ton troisième combat, félicitations à vous\n";
                   echo "La partie est fini ";
                   $this -> sauvegarder($h);
                   return ; 
            }
        }
        echo "Vous avez perdu votre". $r. "eme combat contre ". $v->nom ."\n";
        echo "Mise à jour à venir pour la demande de rejouer ";
    }
//Permet de dire qui a gagné et qui a perdu 
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
    //Sauvegarde les informations du joueur dans un fichier
public function sauvegarder($hero) {
        $donnees_sauvegarde = array(
            'nom' => $hero->nom,
            'niveau_de_vie' => $hero->niveau_de_vie,
            'niveau_puissance' => $hero->puissances_attaque,
            'attaque' => $hero->attaque
        );

        $nom_du_fichier_sauvegarde = 'sauvegarde.txt';

        // Sauvegardez le tableau de sauvegarde dans un fichier
        file_put_contents($nom_du_fichier_sauvegarde, serialize($donnees_sauvegarde));
    }





}


//Gère le menu et les parties du joueur avec des niveaux
$Menu = readline("1. Jouer \n 2. Quitter");
popen("cls", "w");
switch ($Menu) {
    case "1":
        $nom_utilisateur = readline("Entrez votre nom \n");
    function niveau1(){
    // $Menu = readline("1) Jouer \n 2) Quitter \n");
         popen("cls", "w");
        $Hero1 = new Heros("Goku",200,40,"Boule de feu");
        $Hero2 = new Heros("Vegeta", 200,40,"Boule de feu");
        $Vilain1 = new Vilain("Freezer",100,30,"Boule de feu");
        $Vilain2 = new Vilain("Broli",100,60,"Boule de feu");

        $Game = new Jeu(array($Hero1 -> nom, $Hero1 -> niveau_de_vie, $Hero1 -> puissances_attaque, $Hero1 -> attaque),
        array($Hero2 -> nom, $Hero2 -> niveau_de_vie, $Hero2 -> puissances_attaque, $Hero2 -> attaque),
        array($Vilain1 -> nom, $Vilain1 -> niveau_de_vie, $Vilain1 -> puissances_attaque, $Vilain1 -> attaque),
        array($Vilain2 -> nom, $Vilain2 -> niveau_de_vie, $Vilain2 -> puissances_attaque, $Vilain2 -> attaque));

        $Game -> combat();
        // return ;
    }
        function niveau2(){
            $Hero1 = new Heros("Trunk",200,45,"Boule de feu");
            $Hero2 = new Heros("Gohan", 200,45,"Boule de feu");
            $Vilain1 = new Vilain("Boo",100,50,"Boule de feu");
            $Vilain2 = new Vilain("Cell",100,40,"Boule de feu");   
            $Game = new Jeu(array($Hero1 -> nom, $Hero1 -> niveau_de_vie, $Hero1 -> puissances_attaque, $Hero1 -> attaque),
            array($Hero2 -> nom, $Hero2 -> niveau_de_vie, $Hero2 -> puissances_attaque, $Hero2 -> attaque),
            array($Vilain1 -> nom, $Vilain1 -> niveau_de_vie, $Vilain1 -> puissances_attaque, $Vilain1 -> attaque),
            array($Vilain2 -> nom, $Vilain2 -> niveau_de_vie, $Vilain2 -> puissances_attaque, $Vilain2 -> attaque));
            $Game -> combat();
            $Game -> sauvegarder();
        }

        function jeu(){
        niveau1();
        $demander = readline("Voulez-vous continuer? ");
        if($demander=="oui"){
            niveau2();
        }
        }
        file_put_contents('sauvegarde.txt', serialize($donnees_sauvegarde));
        jeu();
    case "2":
        echo "Au revoir à la prochaine ";


}

?>
