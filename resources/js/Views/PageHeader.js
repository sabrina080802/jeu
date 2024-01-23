class PageHeader extends MagyDOMComponent {
    constructor() { super(); }

    onBtnOpenAuthClick() {
        const popup = new ConnectPopup();
        popup.show();
    }
    onBtnCreateMatchClick() {
        console.log('click');
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