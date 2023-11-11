const req = new XMLHttpRequest();
req.open("GET", "index.php?action=getAllIngredients", true);
req.responseType = "text";
let arrayOfIngredients = [];
let ingredientNumber = 1;

function checkExistingIngredients() {
    const nbIngredientsInput = document.getElementById("nbIngredients");
    if (parseInt(nbIngredientsInput.value) === 0) return;
    ingredientNumber += parseInt(nbIngredientsInput.value);
    for (let i=1; i<ingredientNumber; i++) {
        const ingredient = document.getElementById(`ingredient${i}`);
        arrayOfIngredients.splice(arrayOfIngredients.indexOf(ingredient.value), 1);
        ingredient.parentNode.addEventListener("click", event => deleteAddedIngredient(event));
    }
}

req.onload = (event) => {
    arrayOfIngredients = req.response.split(",");
    arrayOfIngredients.sort();
    autocomplete(
        document.getElementById(`ingredient`),
        arrayOfIngredients,
    );
    checkExistingIngredients();
};

function deleteAddedIngredient(event) {
    // Remove the stored ingredient and put it in the list to make it available
    const target = event.target.parentNode;
    const input = target.querySelector("input");
    arrayOfIngredients.push(input.value);
    arrayOfIngredients.sort();
    target.remove();
}

document
    .getElementById(`ingredient`)
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
        
        arrayOfIngredients.splice(arrayOfIngredients.indexOf(target.value), 1); // Remove the ingredient in the list
        

        // Store in the form the chosen ingredient
        const divForInputAndP = document.createElement("div");
        const inputHidden = document.createElement("input");
        inputHidden.setAttribute("id", `ingredient${ingredientNumber}`);
        inputHidden.setAttribute("name", `ingredient${ingredientNumber}`);
        inputHidden.setAttribute("type", "hidden");
        inputHidden.setAttribute("value", target.value);
        divForInputAndP.appendChild(inputHidden);

        // Create a paragraph to display the ingredient taken to the user
        const pIngredientSelected = document.createElement("p");
        pIngredientSelected.setAttribute("class", `ingredient`);
        pIngredientSelected.textContent = target.value;
        divForInputAndP.appendChild(pIngredientSelected);

        // Create the cross to discard the ingredient
        const cross = document.createElement("em");
        cross.setAttribute("class", `fa-solid fa-xmark fa-2x`);
        divForInputAndP.appendChild(cross);
        divForInputAndP.setAttribute("class", "div-ingredient")
        target.value = "";
        target.parentNode.parentNode.insertBefore(
            divForInputAndP,
            target.parentNode,
        );
        ingredientNumber++; // Increaser ingredient number
        divForInputAndP.addEventListener("click", event => deleteAddedIngredient(event));
    });

req.send(null);
