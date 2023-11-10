const req = new XMLHttpRequest();
req.open("GET", "index.php?action=getAllIngredients", true);
req.responseType = "text";

req.onload = (event) => {
  const arrayOfIngredients = req.response.split(",");
  autocomplete(document.getElementById('ingredient1'), arrayOfIngredients);
};

req.send(null);
