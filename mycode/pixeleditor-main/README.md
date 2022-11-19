# Pixel art

Au programme : concevoir une application JavaScript pour créer une ardoise de dessin en pixel art.

## <img src="./result/result-1.png">

<img src="./result/result-2.png">

## Étape 1 - Générer l'ardoise

On va d'abord créer des élements en Javascript pour créer une grille de 8 cases x 8 cases

Pour cela il faudra exploiter les boucles et ajouter des élements au DOM

On ajoute ensuite les styles qu'on souhaite

Il faut pouvoir visualiser toutes nos lignes et toutes nos colonnes

Pour l'instant tous les pixels ont la même couleur ;)

## Étape 2 - Gérer le clic sur un pixel

On va maintenant s'occuper de pouvoir changer la couleur des pixels

Si on clique sur un pixel on le fait passer en blanc

Si on reclique dessus il passe en noir

Si on reclique dessus il passe en blanc

Si on reclique dessus il passe en noir

etc ...

On doit réagir au clic sur les pixels ensuite on doit modifier la couleur d'arrière plan du pixel cliqué

On a par exemple dû voir un moyen de récupérer tout plein d'informations liées à l'événement dans la fonction de rappel de l'écouteur. Peut-être que l'une de ces informations est l'élement cliqué

## Étape 3 - Formulaire de configuration

On va ajouter (toujours en JS) des élements au formulaire

On ajoute un champ pour choisir la taille de la grille

On ajoute un bouton pour valider

Lorsqu'on soumet le formulaire on veut générer une nouvelle grille à la place de la grille actuelle, mais en tenant compte de la taille saisie dans le champ

Par exemple l'utilisateur saisit 10 dans le champ, il valide, une nouvelle grille de 10 cases x 10 cases est générée à la place de la grille existante

<details>
<summary>Bonus 1</summary>

### Rangement

On va devoir créer un objet unique app où toutes les variables deviennent des propriétés et toutes les fonctions deviennent des méthodes. Et toutes les fonctions que vous appelez pour "initialiser" l'application, vous allez les ranger dans une dernière méthode nommée init. Tout en bas de votre code, il restera à appeler cette fonction : app.init(). Et tout sera bien rangé

</details>

---

<details>
<summary>Bonus 2</summary>

### Taille des pixels

On ajoute un champ en plus pour choisir la taille des pixels
Exemple : on met 4 pour la taille de la grille, 25 pour la taille des pixels, on valide => on obtient une grille de 4 cases x 4 cases de 25 pixels de large et de haut chacune

</details>

---

<details>
<summary>Bonus 3</summary>

### Palette de couleurs

On veut désormais laisser l'utilisateur choisir la couleur qui sera appliquée au clic sur un pixel

On va gérer trois couleurs (styles)

- on créer un élément pour chaque couleur
- On doit permettre à l'utilisateur de choisir parmi ces 3 styles, une fois choisi, il peut cliquer sur des pixels pour leur appliquer une classe en fonction du style sélectionné.
- En CSS on associe une couleur à chaque style

</details>

---

<details>
<summary>
Bonus 4
</summary>

### Couleur perso

On va permettre à l'utilisateur d'utiliser une couleur personnalisée

- on créer un nouvel élément dans notre palette (peut être un type d'input ?)
- on adapte le comportement de ce nouvel élement pour qu'il applique la couleur séléctionnée lors d'un click sur une case
</details>
