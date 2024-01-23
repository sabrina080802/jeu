class Selector extends MagyDOMComponent {
    qualifiedName;
    #values;
    #valueIndex = 0;

    constructor(name, values = []) {
        super();

        this.createEvent('changed');

        setTimeout(() => {
            console.log('Dispatching');
            this.dispatchEvent('changed', 'xbox');
        }, 500);


        this.qualifiedName = name;
        this.#values = values;
        if (this.#values.length > 0) {
            this.container.valueContainer.innerHTML = this.#values[0];
        }
    }
    onBtnNextClick() {
        if (this.#valueIndex < this.#values.length - 1) this.#valueIndex++;
    }
    onBtnPreviousClick() {
        if (this.#valueIndex > 0) this.#valueIndex--;
    }
    update() {
        this.container.valueContainer.innerHTML = this.#values[this.#valueIndex];

        if (this.#valueIndex == 0) {
            this.container.btnPrevious.setAttribute("disabled", "");
        } else this.container.btnPrevious.removeAttribute("disabled");

        if (this.#valueIndex == this.#values.length - 1) {
            this.container.btnNext.setAttribute("disabled", "");
        } else this.container.btnNext.removeAttribute("disabled");
    }

    render() {
        return new Div("user-select", this.qualifiedName,
            [
                new Button('btnPrevious', '', "&lt;"),
                new Div("valueContainer"),
                new Button('btnNext', '', "&gt;")
            ]);
    }
}
