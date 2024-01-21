app.run(() => {
  const popup = document.getElementById("register");
  const btnClose = popup.querySelector(".closeBtn");
  const btnRegister = popup.querySelector('[name="btn-register"]');

  const pseudo = popup.querySelector('[name="pseudo"]');
  const email = popup.querySelector('[name="email"]');
  const pass = popup.querySelector('[name="pass"]');

  btnClose.onclick = onClosePopup;
  btnRegister.onclick = onRegister;

  function onRegister() {
    register(pseudo.value, email.value, pass.value);
  }
  async function register(pseudo, email, pass) {
    const result = await app.request("account/register", {
      pseudo,
      email,
      pass,
    });
    console.log(result);
  }
  function onClosePopup() {
    togglePopup("register");
  }
});
