//ZONE DE SABRINA

//TODO :
// Faire un fetch dans une fonction pour requêter l'API
// Le lien EST LE SUIVANT BAWI : http://localhost/dossier/account/getAccount
// Save le résultat JSON dans une variable
// Faire un console log du résultat

async function togglePopup(popupName) {
  var popup = document.getElementById(popupName);
  if (popup.style.display === "flex") {
    popup.setAttribute("hidden", "");
    await app.wait(250);
    popup.style.display = null;
  } else {
    popup.setAttribute("hidden", "");
    popup.style.display = "flex";
    await app.wait(0);
    popup.removeAttribute("hidden");
    await app.wait(250);

    if (popupName == "create_match" && !popup.hasAttribute("built")) {
      popup.setAttribute("built", "");
      buildCreateMatchPopup();
    }
  }
}

function buildCreateMatchPopup() {
  const choiceData = [
    {
      name: "platform",
      title: "Choix de la plateforme",
      list: ["steam", "xbox", "playstation", "epic games"],
    },
    {
      name: "games",
      title: "Choix du jeu",
      list: ["Fortnite", "Call of duty", "Rocket League"],
    },
    {
      name: "mode",
      title: "Choix du mode de jeu ",
      list: ["1v1", "3v3", "capture the flags"],
    },
    {
      name: "map",
      title: "Choix de la map  ",
      list: ["los angeles", "paris", "londres"],
    },
  ];

  const choiceList = document.getElementById("choices");
  choiceData.forEach((choiceData) => {
    const choiceName = document.createElement("p");
    choiceName.innerHTML = choiceData.title;

    const component = new Selector();
    component.setValues(choiceData.list);

    choiceList.appendChild(choiceName);
    choiceList.appendChild(component.container);
  });

  const btnFindMatch = document.createElement("button");
  btnFindMatch.innerHTML = "Trouver un match";
  btnFindMatch.className = "fermeture";
  choiceList.appendChild(btnFindMatch);
}

document.addEventListener("DOMContentLoaded", function () {
  var btnPlus = document.getElementById("btnPlus");
  var gameList = document.getElementById("gamesList");

  btnPlus.addEventListener("click", function (event) {
    if (!gameList.hasAttribute("hidden")) {
      return;
    }
    gameList.removeAttribute("hidden", "");
    var btnPlus = event.target;
    var bounds = btnPlus.getBoundingClientRect();

    var Y = bounds.y + bounds.height + 10;

    // Renvoie un rectangle avec x, y, width, height qui correspond à la box du bouton +. Attention les position x et y sont absolues
    gameList.style.top = Y + "px";
    var x = bounds.x + bounds.width / 2 - gameList.offsetWidth / 2;
    gameList.style.left = x + "px";
  });

  window.addEventListener("click", function (event) {
    if (event.target == btnPlus) {
      return;
    }
    if (!gameList.hasAttribute("hidden")) {
      gameList.setAttribute("hidden", "");
    }
  });
});
