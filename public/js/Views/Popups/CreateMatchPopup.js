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
                new H2('', '', 'Créer un match !')
            ]),
            new Div('form', '', [
                new P('', '', 'Quelle plateforme ?'),
                new Selector('platform', ['EpicGames', 'Steam', 'XBox', 'Playstation', 'Switch']),
                new P('', '', 'Sur quel jeu ?'),
                new Selector('game', ['Call of Duty', 'Fortnite', 'Rocket League']),
                new P('', '', 'Quel mode de jeu ?'),
                new Selector('mode', ['1 vs 1', '2 vs 2', '3 vs 3']),
                new Button('btnCreateMatch', '', 'Let\'s go !')
            ]),
            new Button('btnClose', 'closeBtn', 'x')
        ]);
    }
}