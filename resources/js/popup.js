function togglePopup() {
  var popup = document.getElementById("popup");
  if (popup.style.display === "flex") {
    popup.style.display = null;
  } else {
    popup.style.display = "flex";
  }
}
