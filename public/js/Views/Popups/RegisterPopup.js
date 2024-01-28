/*app.run(() => {
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
*/
class RegisterPopup extends Popup {
  constructor() {
    super();
  }
  onBtnRegisterClick() {
    const connectPopup = new ConnectPopup();
    this.hide();
    connectPopup.show();
  }
  onBtnConnectClick() {

  }
  renderPopupContent() {
    return new Div('auth-popup', '', [
      new H4('connexion', '', ' Inscription'),
      new P('', '', 'Adresse email :'),
      new Input('email', '', 'email', 'abc@example.fr', true, 4, 255),
      new P('', '', 'Pseudo :'),
      new Input('text', '', 'pseudo', '', true),
      new P('', '', 'Mot de passe :'),
      new Input('password', '', 'password', '0123456', true),
      new Div('register-menu', '', [
        new Button('btnRegister', 'inscri', 'Déjà un compte ? '),
        new Button('btnConnect', 'co', 'S\'inscrire')
      ]),
      new Button('btnClose', 'closeBtn', 'x'),
      new SocialNetworksConnection()
    ]);
  }
}