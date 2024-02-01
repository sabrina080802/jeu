class Popup extends MagyDOMComponent {
    constructor() {
        super();
    }
    onBtnCloseClick() {
        this.hide();
    }

    /**
     * Show the popup. Awaiting it for animations ends
     */
    async show() {
        document.body.appendChild(this.container);
        this.container.setAttribute('hidden', '');
        await app.wait(0);
        this.container.removeAttribute('hidden');
        await app.wait(250);
    }

    /**
     * Hides the popup. Awaiting it for animations ends
     */
    async hide() {
        this.container.setAttribute('hidden', '');
        await app.wait(250);
        this.container.remove();
    }
    render() {
        const content = this.renderPopupContent();
        content.name = 'content';
        return new DOMElement('div', 'popup', '', 'popupContent', [content]);
    }
}