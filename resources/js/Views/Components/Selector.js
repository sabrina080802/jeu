class Selector extends MagyDOMComponent {
    qualifiedName;
    #values;
    #valueIndex = 0;

    constructor(name, values = []) {
        super();
        this.createEvent('changed');

        this.qualifiedName = name;
        this.#values = values;
        if (this.#values.length > 0) {
            this.container.valueContainer.innerHTML = this.#values[0];
        }
    }
    onBtnNextClick() {
        if (this.#valueIndex < this.#values.length - 1) {
            this.#valueIndex++;
            this.dispatchEvent('changed', this.#values[this.#valueIndex]);
        }
    }
    onBtnPreviousClick() {
        if (this.#valueIndex > 0) {
            this.#valueIndex--;
            this.dispatchEvent('changed', this.#values[this.#valueIndex]);
        }
    }
    async update() {
        this.container.valueContainer.style.filter = 'blur(7px)';
        await app.wait(150);
        this.container.valueContainer.innerHTML = this.#values[this.#valueIndex];
        await app.wait(0);
        this.container.valueContainer.style.filter = null;

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
                new Div('', "valueContainer"),
                new Button('btnNext', '', "&gt;")
            ]);
    }
}
