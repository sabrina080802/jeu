class PageHeader extends MagyDOMComponent {
    constructor() {
        super();
    }

    onBtnOpenAuthClick() {
        const popup = new ConnectPopup();
        popup.show();
    }
    onBtnCreateMatchClick() {
        const popup = new CreateMatchPopup();
        popup.show();
    }
    render() {
        return new Header([
            new Div('match', '', [
                new Img("logo_small.png"),
                new Button('btnCreateMatch', '', 'Créer un match')
            ]),
            new Div('games', '', [
                new Div('game', '', 'Call of Duty'),
                new Nav('', '', []),
            ]),
            new Button('btnOpenAuth', '', 'Connexion')
        ]);
    }
}