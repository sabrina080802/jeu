class Selector extends MagyDOMComponent {
  #values;
  #valueIndex = 0;

  constructor(values) {
    super();

    this.#values = values;
    this.container.valueContainer.innerHTML = this.#values[0];
  }
  onBtnNextClick() {
    if (valueIndex < values.length - 1) valueIndex++;
  }
  onBtnPreviousClick() {
    if (valueIndex > 0) valueIndex--;
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
    return new DOMElement(
      "div",
      (className = "user-select"),
      (childs = [
        new DOMElement("button", (text = "&gt;"), (name = "btnNext")),
        new DOMElement("button", (text = "&lt;"), (name = "btnPrevious")),
        new DOMElement("div", (name = "valueContainer")),
      ])
    );
  }
}