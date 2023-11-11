const req = new XMLHttpRequest();
req.open("GET", "index.php?action=getAllIngredients", true);
req.responseType = "text";
let arrayOfIngredients = [];
let ingredientNumber = 1;
req.onload = (event) => {
    arrayOfIngredients = req.response.split(",");
    arrayOfIngredients.sort();
    autocomplete(
        document.getElementById(`ingredient${ingredientNumber}`),
        arrayOfIngredients,
    );
};

function deleteAddedIngredient(event) {
    const target = event.target.parentNode;
    const input = target.querySelector("input");
    arrayOfIngredients.push(input.value);
    arrayOfIngredients.sort();
    target.remove();
}

document
    .getElementById(`ingredient${ingredientNumber}`)
    .addEventListener("itemSelected", (event) => {
        const target = event.target;
        try {
            (document.getElementById("nbIngredients")).value = ingredientNumber;
        } catch (error) {
            const nbIngredients = document.createElement("input");
            nbIngredients.setAttribute("id", "nbIngredients");
            nbIngredients.setAttribute("name", "nbIngredients");
            nbIngredients.setAttribute("type", "hidden");
            nbIngredients.setAttribute("value", ingredientNumber);
            const form = document.getElementById("re_form");
            form.appendChild(nbIngredients);
        }
        
        arrayOfIngredients.splice(arrayOfIngredients.indexOf(target.value), 1); // Retire l'ingrédient choisit de la liste des possibilités
        const ingredientInputId = target.id; // Récupère l'id de l'input réalisé
        ingredientNumber++; // Augmente le nombre d'ingrédients
        target.id = `ingredient${ingredientNumber}`; // Met à jour l'id de l'input à choix pour correspondre au nouvel ingrédient à mettre

        // Stocke dans le formulaire l'ingrédient choisit et l'ajoute à l'affichage en statique pour l'utilisateur
        const divForInputAndP = document.createElement("div");
        const inputHidden = document.createElement("input");
        inputHidden.setAttribute("id", ingredientInputId);
        inputHidden.setAttribute("name", ingredientInputId);
        inputHidden.setAttribute("type", "hidden");
        inputHidden.setAttribute("value", target.value);
        divForInputAndP.appendChild(inputHidden);
        const pIngredientSelected = document.createElement("p");
        pIngredientSelected.setAttribute("id", `paragraph${ingredientInputId}`);
        pIngredientSelected.setAttribute("class", `ingredient`);
        pIngredientSelected.textContent = target.value;
        divForInputAndP.appendChild(pIngredientSelected);
        const cross = document.createElement("em");
        cross.setAttribute("class", `fa-solid fa-xmark fa-2x`);
        divForInputAndP.appendChild(cross);
        divForInputAndP.setAttribute("class", "div-ingredient")
        target.value = "";
        target.parentNode.parentNode.insertBefore(
            divForInputAndP,
            target.parentNode,
        );
        divForInputAndP.addEventListener("click", event => deleteAddedIngredient(event))
    });

req.send(null);
