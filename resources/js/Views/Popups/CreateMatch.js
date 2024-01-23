class CreateMatch extends Popup {
    constructor() {
        super();
    }
    renderPopupContent() {
        return new Div('create-match', '', [
            new Div('head', '', [
                new Img('logo_small.png'),
                new H2('', 'Créer un match')
            ])
        ]);
    }
}