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
        if (domStructure instanceof Array) {
            domStructure.forEach((element) => {
                if (element instanceof DOMElement) {
                    childs.push(this.toHtml(element));
                }
                else if (element instanceof MagyDOMComponent) {
                    if (element.render) {
                        const builtElement = this.toHtml(element.render());
                        if (builtElement instanceof Array) {
                            childs.push(...builtElement);
                        }
                        else {
                            childs.push(builtElement);
                        }
                    }
                }
                else throw new Exception("A component must be an instance of MagyDOMComponent");
            });
        } else if (domStructure instanceof DOMElement) {
            return this.createElement(
                domStructure.tagName,
                domStructure.className,
                domStructure.text,
                this.toHtml(domStructure.childs),
                domStructure.name,
                domStructure.attributes
            );
        }
        else if (domStructure instanceof HTMLElement)
            childs.push(domStructure);

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
    createElement(
        tagName = "div",
        className = "",
        text = "",
        childs = [],
        qualifiedName = null,
        attributes = {}
    ) {
        const element = document.createElement(tagName);
        if (className && className.length > 0) {
            element.className = className;
        }
        if (attributes) {
            for (const key in attributes) {
                element.setAttribute(key, attributes[key]);
            }
        }
        element.innerHTML = text;
        element.qualifiedChilds = [];
        childs.forEach((x) => {
            if (x instanceof DOMElement) {
                x = this.createElement(x.tagName, x.className, x.text, x.childs, x.name);
            }
            if (x.qualifiedName) {
                element[x.qualifiedName] = x;
                element.qualifiedChilds[x.qualifiedName] = x;
            }
            else {
                this.exploreChildsOf(x, element);
            }
            element.appendChild(x);
        });
        element.qualifiedName = qualifiedName;

        return element;
    }
    exploreChildsOf(target, parent) {
        for (let i = 0; i < target.childNodes.length; i++) {
            const key = target.childNodes[i].qualifiedName;
            if (key) {
                parent.qualifiedChilds[key] = target.childNodes[i];
                parent[key] = target.childNodes[i];
            }
            else if (target.nodeType == 1) {
                this.exploreChildsOf(target.childNodes[i], parent);
            }
        }
    }
}

/**
 * Represents a DOM Component
 */
class MagyDOMComponent extends MagyReflectionHelper {
    container;
    #updateMethod;

    constructor() {
        super();
        if (!this.render) {
            return;
        }
        this.container = app.DOM.toHtml(this.render());

        this.getMethods().forEach((method) => {
            if (method == "update") {
                this.#updateMethod = this.__proto__[method];
                return;
            }

            let lowerName = method.toLowerCase();
            if (!lowerName.startsWith("on"))
                return;

            lowerName = lowerName.substr(2);
            const child = this.#getQualifiedChild(lowerName, this.container.qualifiedChilds);
            if (child) {
                this.attachHTMLEvent(lowerName.substr(child.qualifiedName.length), child, this.__proto__[method]);
            }
        });
    }
    #getQualifiedChild(name, childs) {
        for (let elementName in childs) {
            const element = childs[elementName];
            if (element.qualifiedChilds) {
                const qualifiedChild = this.#getQualifiedChild(name, element.qualifiedChilds);
                if (qualifiedChild) {
                    return qualifiedChild;
                }
            }
            const elementLowerName = elementName.toLowerCase();
            if (name.startsWith(elementLowerName)) {
                return element;
            }
        }
        return null;
    }
    /**
     * Listen an HTML event on a target. After the execution of the given method, it calls this this.update() method if it's available
     * @param {String} eventName the name of the event (can be click, mousemove, etc)
     * @param {HTMLElement} target The HTML element attached to the event
     * @param {Function} method the method executed when the event is dispatched
     */
    attachHTMLEvent(eventName, target, method) {
        target.addEventListener(eventName, (event) => {
            method.apply(this, event);

            if (this.#updateMethod != null) {
                this.#updateMethod.apply(this);
            }
        });
    }
}

/**
 * Default DOMElement
 */
class DOMElement extends MagyDOMComponent {
    constructor(tagName, className = "", text = "", name = "", childs = [], attributes = {}) {
        super();
        this.tagName = tagName;
        this.className = className;
        this.text = text;
        this.name = name;
        this.childs = childs;
        this.attributes = attributes;
    }
}

/**
 * Creates an <img> element
 * @returns {HTMLImageElement}
 */
class Img extends DOMElement {
    constructor(src, className = "", name = "") {
        super('img', className, '', name, [], { src });
    }
}

/**
 * Creates a <button> element
 * @returns {Button}
 */
class Button extends DOMElement {
    /**
     * @param {String|Array} content The specified content can be either null, a String containing innerHTML, a DOMElementCollection
     */
    constructor(name = "", className = "", content = null) {
        super('button', className, (!content || content instanceof Array) ? '' : content, name, content instanceof Array ? content : []);
    }
}

/**
 * Creates a <div> element
 * @returns {HTMLDivElement}
 */
class Div extends DOMElement {
    /**
     * @param {String|Array} content The specified content can be either null, a String containing innerHTML, a DOMElementCollection
     */
    constructor(className = "", name = "", content = null) {
        super('div', className, (!content || content instanceof Array) ? '' : content, name, content instanceof Array ? content : []);
    }
}

/**
 * Creates a <header> element
 */
class Header extends DOMElement {
    /**
     * @param {String|Array} content The specified content can be either null, a String containing innerHTML, a DOMElementCollection
     */
    constructor(content = null, className = "", name = "") {
        super('header', className, (!content || content instanceof Array) ? '' : content, name, content instanceof Array ? content : []);
    }
}

/**
 * Creates a <nav> element
 */
class Nav extends DOMElement {
    /**
     * @param {String|Array} content The specified content can be either null, a String containing innerHTML, a DOMElementCollection
     */
    constructor(className = "", name = "", content = null) {
        super('div', className, (!content || content instanceof Array) ? '' : content, name, content instanceof Array ? content : []);
    }
}

/**
 * Creates a <h1> element
 */
class H1 extends DOMElement {
    /**
     * @param {String|Array} content The specified content can be either null, a String containing innerHTML, a DOMElementCollection
     */
    constructor(className = "", name = "", content = null) {
        super('h1', className, (!content || content instanceof Array) ? '' : content, name, content instanceof Array ? content : []);
    }
}

/**
 * Creates a <h2> element
 */

class H2 extends DOMElement {
    /**
     * @param {String|Array} content The specified content can be either null, a String containing innerHTML, a DOMElementCollection
     */
    constructor(className = "", name = "", content = null) {
        super('h2', className, (!content || content instanceof Array) ? '' : content, name, content instanceof Array ? content : []);
    }
}

/**
 * Creates a <h3> element
 */
class H3 extends DOMElement {
    /**
     * @param {String|Array} content The specified content can be either null, a String containing innerHTML, a DOMElementCollection
     */
    constructor(className = "", name = "", content = null) {
        super('h3', className, (!content || content instanceof Array) ? '' : content, name, content instanceof Array ? content : []);
    }
}

/**
 * Creates a <h4> element
 */
class H4 extends DOMElement {
    /**
     * @param {String|Array} content The specified content can be either null, a String containing innerHTML, a DOMElementCollection
     */
    constructor(className = "", name = "", content = null) {
        super('h4', className, (!content || content instanceof Array) ? '' : content, name, content instanceof Array ? content : []);
    }
}

/**
 * Creates a <h5> element
 */
class H5 extends DOMElement {
    /**
     * @param {String|Array} content The specified content can be either null, a String containing innerHTML, a DOMElementCollection
     */
    constructor(className = "", name = "", content = null) {
        super('h5', className, (!content || content instanceof Array) ? '' : content, name, content instanceof Array ? content : []);
    }
}


/**
 * Creates a <h6> element
 */
class H6 extends DOMElement {
    /**
     * @param {String|Array} content The specified content can be either null, a String containing innerHTML, a DOMElementCollection
     */
    constructor(className = "", name = "", content = null) {
        super('h6', className, (!content || content instanceof Array) ? '' : content, name, content instanceof Array ? content : []);
    }
}

/**
 * Creates a <p> element
 */
class P extends DOMElement {
    /**
     * @param {String|Array} content The specified content can be either null, a String containing innerHTML, a DOMElementCollection
     */
    constructor(className = "", name = "", content = null) {
        super('p', className, (!content || content instanceof Array) ? '' : content, name, content instanceof Array ? content : []);
    }
}


/**
 * Creates an <input> element
 */
class Input extends DOMElement {
    constructor(name = "", className = "", type = "text", placeholder = '', required = false, minLength = null, maxLength = null) {
        super('input', className, '', name, [], {
            placeholder, required, minLength, maxLength
        });
    }
}