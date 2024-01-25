class SocialNetworksConnection extends MagyDOMComponent {
    constructor() { super(); }
    render() {
        return new DOMElement('div', 'social-networks', '', 'socialNetworks', [
            new Button('playstation', '', [new Img("Playstation.png")]),
            new Button('xbox', '', [new Img("Xbox.png")]),
            new Button('epicGames', '', [new Img("EpicGames.png")]),
            new Button('facebook', '', [new Img("Facebook.png")]),
            new Button('google', '', [new Img("google.png")])
        ]);
    }
}