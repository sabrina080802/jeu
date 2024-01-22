/*app.run(() => {
    const popup = document.getElementById("connect");
    const email = popup.querySelector("[name='email']");
    const pwd = popup.querySelector('[name="password"]');

    const btnConnexion = popup.querySelector('[name="btn-connect"]');
    const btnOpenRegister = popup.querySelector('[name="btn-reg"]');
    const btnClose = popup.querySelector(".closeBtn");

    btnOpenRegister.onclick = onOpenRegister;
    btnClose.onclick = onClosePopup;
    btnConnexion.addEventListener("click", function (event) {
        authenticate(email.value, pwd.value);
    });

    async function authenticate(email, pass) {
        const result = await app.request("account/auth", {
            email,
            pass,
        });
        console.log(result);
    }

    async function onOpenRegister() {
        await togglePopup("connect");
        togglePopup("register");
    }
    function onClosePopup() {
        togglePopup("connect");
    }
});*/

class Connect extends Popup {
    constructor() {
        super();
    }
    onBtnRegisterClick() {

    }
    onBtnConnectClick() {

    }
    onBtnForgetPasswordClick() {

    }
    renderPopupContent() {
        return new Div('auth-popup', '', [
            new H4('connexion', '', 'Connexion'),
            new P('', '', 'Adresse email :'),
            new Input('email', '', 'email', 'abc@example.fr', true, 4, 255),
            new P('', 'password', 'Mot de passe :'),
            new Input('password', '', 'password', '0123456', true),

            new Button('btnForgetPassword', 'mdp', 'Mot de passe oublié ?'),
            new Div('register-menu', 'registerMenu', [
                new Button('btnRegister', 'inscri', 'Pas membre ?'),
                new Button('btnConnect', 'co', 'Se connecter')
            ]),
            new Button('btnClose', 'closeBtn', 'x'),
            new SocialNetworksConnection()
        ]);
    }
}