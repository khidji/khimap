class PixelArt {
  // le container principal
  containerElement = document.createElement('div');
  gridContainer = document.createElement('div');

  // cette propriété va nous permettre de configurer la grille
  // rows = lignes
  // cells = colonnes (cellules)
  // pixelSize = taille des pixels
  grid = {
    rows: 8,
    cells: 8,
    pixelSize: 64,
  };

  // la couleur active
  currentColor = 'rgb(0, 0, 0)';

  // la couleur par defaut des cellules
  DEFAULT_COLOR = '#888';

  constructor() {
    this.containerElement.className = 'container';
    this.gridContainer.className = 'grid-container';

    document.body.append(this.containerElement);

    this.createConfigForm();
    this.drawGrid();
    this.createColorPicker();
  }

  /**
   *
   * Cette méthode nous permettra de créer le formulaire de configuration de la grille
   *
   */
  createConfigForm() {
    // on crée le formulaire de configuration
    const formElement = document.createElement('form');
    formElement.className = 'config-form';
    formElement.addEventListener('submit', this.formSubmitHandler);

    const gridSizeElement = this.createConfigInput({
      min: 4,
      max: 12,
      text: 'Taille de la grille',
      className: 'grid-size',
    });

    const pixelSizeElement = this.createConfigInput({
      min: 30,
      max: 100,
      text: 'Taille des pixels',
      className: 'pixel-size',
    });

    // on crée le boutton de validation du formulaire
    const validateButtonElement = document.createElement('button');
    validateButtonElement.type = 'submit';
    validateButtonElement.textContent = 'Valider';

    formElement.append(gridSizeElement, pixelSizeElement, validateButtonElement);
    this.containerElement.append(formElement);
  }

  /**
   *
   * Cette methode va empêcher le rechargement de la page et prendra en compte les valeurs des champs du formulaire pour configurer la nouvelle grille lors de la regeneration de la grille
   *
   * @param {FormEvent} event c'est l'évènement natif qui est déclenché lors de la soumission du formulaire
   * @returns void
   */
  formSubmitHandler = (event) => {
    event.preventDefault();
    const target = event.target;

    const gridSizeElement = target.querySelector('.grid-size');
    const gridSizeValue = +gridSizeElement.value;

    const pixelSizeElement = target.querySelector('.pixel-size');
    const pixelSizeValue = +pixelSizeElement.value;

    if (!gridSizeValue || !pixelSizeValue) {
      alert("Au moins un des champs n'est pas valide !");
      return;
    }

    this.grid.cells = gridSizeValue;
    this.grid.rows = gridSizeValue;

    this.grid.pixelSize = pixelSizeValue;

    this.draw();
  };

  /**
   * Cette méthode va se contenter de vider (effacer) la grille et par la suite la redessiner
   */
  draw() {
    this.clearGrid();
    this.drawGrid();
  }

  /**
   * Cette méthode éfface la grille
   */
  clearGrid() {
    this.gridContainer.innerHTML = '';
  }

  /**
   *
   * Cette méthode nous permet de dessiner la grille et de l'ajouter dans notre container principal
   *
   */
  drawGrid() {
    // boucle exterieur pour créer les lignes
    for (let i = 0; i < this.grid.rows; i++) {
      // on crée la div qui servira de ligne
      const rowElement = document.createElement('div');
      rowElement.className = 'row';

      // boucle interieure pour créer les colonnes/cellules
      for (let i = 0; i < this.grid.cells; i++) {
        // on crée la div qui servira de cellule dans la ligne
        // on ajoute la cellule dans la ligne crée précédement
        const cellElement = document.createElement('div');
        cellElement.className = 'cell';
        cellElement.style.width = `${this.grid.pixelSize}px`;
        cellElement.style.height = `${this.grid.pixelSize}px`;

        // on aurait pu changer la taille des pixels via une class -> plus contraignant
        // cellElement.className = `cell pixel-${this.grid.pixelSize}`;

        // on ajoute un evenement au click sur la cellule pour affecter une couleur à celle ci lors du click
        cellElement.addEventListener('click', this.colorizeCell);

        rowElement.append(cellElement);
      }

      // on ajoute la ligne dans un container
      this.gridContainer.append(rowElement);
      this.containerElement.append(this.gridContainer);
    }
  }

  /**
   *
   * Cette méthode va permettre de changer la couleur d'une cellule clickée en fonction de la couleur déjà appliquée sur celle ci et de la couleur selectionée
   *
   * @param {MouseEvent} event l'évènement natif qui est renvoyé lors du click
   */
  colorizeCell = (event) => {
    const target = event.target;

    if (target.style.background === this.currentColor) {
      target.style.background = this.DEFAULT_COLOR;
    } else {
      target.style.background = this.currentColor;
    }
  };

  /**
   *
   * Cette méthode permet de créer un champ de type input qui servira à configurer la grille
   *
   * @param {{min: number, max: number, text: string, className:string}} params c'est l'objet de configuration d'un champ du formulaire
   * @returns HTMLInputElement
   */
  createConfigInput(params) {
    // ici je récupère les propriétés qui m'interessent depuis mon objet params
    const { min, max, text, className } = params;

    const inputElement = document.createElement('input');
    inputElement.className = className;
    // on peut ajouter un attribut natif ou personnalisé de cette façon
    // inputElement.setAttribute('type', 'number');
    // on peut ajouter un attribut natif de cette façon
    inputElement.type = 'number';
    inputElement.min = min;
    inputElement.max = max;
    inputElement.placeholder = text;

    return inputElement;
  }

  /**
   * Cette méthode va créer une palette de couleur avec différents bouttons cliquables qui permettront de modifier la couleur des cellules lorsqu'elles seront cliquées
   */
  createColorPicker() {
    const colorPickerContainerElement = document.createElement('form');
    colorPickerContainerElement.className = 'color-picker-container';

    const redButtonElement = this.createColorPickerButton('rgb(139, 19, 19)');
    const greenButtonElement = this.createColorPickerButton('rgb(7, 110, 7)');
    const blueButtonElement = this.createColorPickerButton('rgb(21, 21, 98)');

    const customColorElement = this.createColorPickerButton();

    colorPickerContainerElement.append(
      redButtonElement,
      greenButtonElement,
      blueButtonElement,
      customColorElement,
    );
    this.containerElement.append(colorPickerContainerElement);
  }

  /**
   *
   * Cette méthode permet de créer un boutton pour la palette de couleur en fonction d'une couleur. Un évènement au click sera affecté à l'élément nouvellement créer pour changer la couleur active.
   *
   * @param {string | null} color Une chaine de caractères au format rgb() qui par defaut si aucun paramètre n'a été passé lors de l'appel de la fonction prendra la valeur null
   * @returns HTMLInputElement | HTMLButtonElement
   */
  createColorPickerButton(color = null) {
    if (!color) {
      const customColorElement = document.createElement('input');
      customColorElement.className = 'custom-color';
      customColorElement.type = 'color';
      customColorElement.addEventListener('change', this.changeColor);
      customColorElement.addEventListener('click', this.changeColor);

      return customColorElement;
    }

    const buttonElement = document.createElement('button');
    buttonElement.type = 'button';
    buttonElement.style.background = color;
    buttonElement.addEventListener('click', this.changeColor);

    return buttonElement;
  }

  /**
   *
   * Cette méthode permet de changer la couleur active en fonction soit de la couleur de fond du boutton, soit de la valeur dans le cas d'un champ couleur personnalisé. La couelur active sera une couleur au format rgb().
   *
   * @param {MouseEvent | Event} event événement natif lors du click ou lors de la perte de focus du champ (si quelque a changé dans ce champ).
   * @returns void
   */
  changeColor = (event) => {
    // ici on aurait le cas ou l'élément clické n'est pas un champ de type color (couleur personnalisée)
    if (!event.target.value) {
      this.currentColor = event.target.style.background;
      return;
    }

    const rgbObj = this.hexToRgb(event.target.value);

    if (!rgbObj) throw new Error('Valeur couleur incorrecte !');

    // const r = rgbObj.r;
    // const g = rgbObj.g;
    // const b = rgbObj.b;

    // équivalent à

    const { r, g, b } = rgbObj;

    this.currentColor = `rgb(${r}, ${g}, ${b})`;
  };

  /**
   *
   * Cette méthode va convertir une chaine de caractères qui représente une couleur au format héxadécimal en chaine de caractères qui représente une couelur au format rgb().
   *
   * @param {string} hex la couleur hexadécimale à convertir au format rgb().
   * @returns {{r: number, g:number, b:number}} - la chaine de caractères convertie au format rgb() sous la forme d'un objet
   *
   */
  hexToRgb(hex) {
    // expression régulière qui permet de vérifier si hex est bien une chaine de caractères au format héxédécimal
    /**
     * @description resultat de la vérification de l'expression régulière sous form de tableau
     */
    const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);

    return result
      ? {
          // on transforme le resultat en nombre au format héxadécimal
          r: parseInt(result[1], 16),
          g: parseInt(result[2], 16),
          b: parseInt(result[3], 16),
        }
      : null;
  }
}

const pixelArt = new PixelArt();
