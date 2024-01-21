/**
 * Provide functions to build some HTML elements
 */
class MagyDOMBuilder {
    /**
     * @param {Array} domStructure An array containing all childs
     * @return builts childs
     */
    toHtml(domStructure) {
        const childs = [];
        domStructure.forEach((data) => {
            if (data instanceof DOMElement) {
                childs.push(this.createElement(
                    data.tagName,
                    data.className,
                    qualifiedName = data.name
                ));
            }
            else if (data instanceof MagyDOMComponent) {
                const builtElement = this.toHtml(data.render());
                if (builtElement instanceof Array) {
                    childs.push(...builtElement);
                }
                else {
                    childs.push(builtElement);
                }
            }
            else throw new Exception("A component must be an instance of MagyDOMComponent");
        });

        return childs;
    }

    /**
     * Generate an HTML element
     * @param {String} tagName The element tag name
     * @param {String} className The CSS class name of the generated element
     * @param {Array} childs DOMElement collection of childs
     * @param {String} qualifiedName The name of the element (accessible via builtElement.your_qualified_name)
     * @return {HTMLElement} An html element built from your specifications
     */
    createElement(tagName = "div", className = "", childs = [], qualifiedName = null) {
        const element = document.createElement(tagName);
        element.className = className;
        element.qualifiedChilds = [];
        childs.forEach(x => {
            if (x.qualifiedName) {
                element[x.qualifiedName] = x;
                element.qualifiedChilds[x.qualifiedName] = x;
            }
            element.appendChild(element);
        });
        element.qualifiedName = qualifiedName;

        return element;
    }
}

/**
 * Represents a DOM Component
 */
class MagyDOMComponent extends MagyReflectionHelper {
    container;
    #updateMethod;

    constructor() {
        this.container = app.DOM.toHtml(this.render());

        this.getMethods().forEach((method) => {
            if (method.name == 'update') {
                this.#updateMethod = method;
                return;
            }

            let lowerName = method.name.toLowerCase();
            if (lowerName.startsWith("on")) {
                lowerName = lowerName.substr(2);
            }

            for (let elementName in this.container.qualifiedChilds) {
                const elementLowerName = elementName.toLowerCase();
                if (lowerName.startsWith(elementLowerName)) {
                    lowerName = lowerName.substr(elementName.length);

                    this.attachHTMLEvent(lowerName, this.container.qualifiedChilds[elementName], method);
                }
            }
        });
    }

    /**
     * Listen an HTML event on a target. After the execution of the given method, it calls this this.update() method if it's available
     * @param {String} eventName the name of the event (can be click, mousemove, etc)
     * @param {HTMLElement} target The HTML element attached to the event
     * @param {Function} method the method executed when the event is dispatched
     */
    attachHTMLEvent(eventName, target, method) {
        target.addEventListener(eventName, (event) => {
            method(event);

            if (this.#updateMethod != null) {
                this.#updateMethod();
            }
        });
    }
}

/**
 * Default DOMElement
 */
class DOMElement extends MagyDOMComponent {
    tagName, className, text, name, childs;

    constructor(tagName, className = "", text = "", name = "", childs = []) {
        this.tagName = tagName;
        this.className = className;
        this.text = text;
        this.name = name;
        this.childs = childs;
    }
}

