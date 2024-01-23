class CreateMatchPopup extends Popup {
    constructor() {
        super();
    }
    onPlatformChanged(platform) {
        console.log("=> " + platform);
    }
    renderPopupContent() {
        return new Div('create-match', '', [
            new Div('head', '', [
                new Img('logo_small.png'),
                new H2('', 'Créer un match')
            ]),
            new Selector('platform'),
            new Selector('game'),
            new Selector('mode'),
            new Selector('map'),
            new Button('btnClose', 'closeBtn', 'x')
        ]);
    }
}