app.run(() => {
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
});
