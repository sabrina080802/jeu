function Selector() {
  const self = this;
  let values,
    valueIndex = 0;

  const btnNext = document.createElement("button");
  const btnPrevious = document.createElement("button");
  const valueContainer = document.createElement("div");
  const container = document.createElement("div");

  container.appendChild(btnPrevious);
  container.appendChild(valueContainer);
  container.appendChild(btnNext);
  btnNext.innerHTML = "&gt;";
  btnPrevious.innerHTML = "&lt;";

  btnNext.addEventListener("click", () => {
    if (valueIndex < values.length - 1) {
      valueIndex++;
    }
    checkState();
  });
  btnPrevious.addEventListener("click", () => {
    if (valueIndex > 0) {
      valueIndex--;
    }
    checkState();
  });
  container.className = "user-select";

  this.__defineGetter__("container", () => container);
  this.setValues = (valueList) => {
    values = valueList;
    if (values.length > 0) {
      valueContainer.innerHTML = values[0];
      checkState();
    }
  };

  function checkState() {
    valueContainer.innerHTML = values[valueIndex];
    function checkState() {
      if (valueContainer.innerHTML == values[0]) {
        btnPrevious.setAttribute("disabled", "");
      } else btnPrevious.removeAttribute("disabled");

      if (valueContainer.innerHTML == values[values.length - 1]) {
        btnNext.setAttribute("disabled", "");
      } else btnNext.removeAttribute("disabled");
    }
  }
}
