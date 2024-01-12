function togglePopup() {
  var popup = document.getElementById("popup");
  if (popup.style.display === "flex") {
    popup.style.display = null;
  } else {
    popup.style.display = "flex";
  }
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
    console.log(gameList);
  });

  // window.addEventListener("click", function (event) {
  //   if (!btnPlus.contains(event.target) && !gameList.contains(event.target)) {
  //     gamesList.classList.add("hidden");
  //   }
  // });

  window.addEventListener("click", function (event) {
    if (event.target == btnPlus) {
      return;
    }
    if (!gameList.hasAttribute("hidden")) {
      gameList.setAttribute("hidden", "");
    }
  });
});
