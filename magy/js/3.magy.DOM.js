/**
 * Provide functions to build some HTML elements
 */
class MagyDOMBuilder {
    /**
     * @param {Array} domStructure An array containing all childs
     * @return builts childs
     */
    toHtml(domStructure, parent = null) {
        const childs = [];
        if (domStructure instanceof Array) {
            domStructure.forEach((element) => {
                if (element instanceof DOMElement) {
                    element = this.toHtml(element);
                    childs.push(element);
                }
                else if (element instanceof MagyDOMComponent) {
                    if (element.container) {
                        childs.push(element.container);
                    }
                    else if (element.render) {
                        const builtElement = this.toHtml(element.render());
                        if (builtElement instanceof Array) {
                            childs.push(...builtElement);
                        }
                        else {
                            builtElement.rootComponent = element;
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
                this.toHtml(domStructure.childs, domStructure),
                domStructure.name,
                domStructure.attributes,
                domStructure
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
        attributes = {},
        component = null
    ) {
        const element = document.createElement(tagName);
        element.component = component;
        component.container = element;
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
                x = this.createElement(x.tagName, x.className, x.text, x.childs, x.name, x);
            }
            if (x.qualifiedName && x.qualifiedName != '') {
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
class MagyDOMComponent extends EventHandler {
    container;
    #updateMethod;

    constructor(linkChilds = true) {
        super();
        if (!this.render) {
            return;
        }

        this.container = app.DOM.toHtml(this.render());
        this.container.isRootComponent = true;
        this.#attachChildsToRoot(this.container);

        if (linkChilds) {
            app.wait(0).then(() => this.#linkEvents());
        }
    }

    /**
     * Attach html childs to the root component
     */
    #attachChildsToRoot(parent) {
        if (parent.rootComponent) {
            return;
        }
        parent.rootComponent = this;

        for (let i = 0; i < parent.childNodes.length; i++) {
            if (parent.childNodes[i].nodeType == 1) {
                this.#attachChildsToRoot(parent.childNodes[i]);
            }
        }
    }

    /**
     * Link event to functions automatically
     */
    #linkEvents() {
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
                lowerName = lowerName.substr(child.qualifiedName.length);
                if (child.rootComponent.hasAutoLinkEvent(lowerName)) {
                    this.attachEvent(lowerName, child.rootComponent, this.__proto__[method]);
                }
                else {
                    this.attachHTMLEvent(lowerName, child, this.__proto__[method]);
                }
            }
        });
    }

    /**
     * Retrieve a child by his qualified name in a collection of childs
     * @param {String} name the qualified name of the child
     * @param {Array} childs A collection of childs
     */
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
     * Listen an event on a target. After the execution of the given method, it calls his this.update() method if it's available
     * @param {String} eventName the name of the event (can be click, mousemove, etc)
     * @param {MagyDOMComponent} target The component attached to the event
     * @param {Function} method the method executed when the event is dispatched
     */
    attachEvent(eventName, target, method) {
        target.addListener(eventName, method);
    }

    /**
     * Listen an HTML event on a target. After the execution of the given method, it calls his this.update() method if it's available
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
    constructor(tagName, className = "", text = "", name = "", childs = [], attributes = {}, linkChilds = true) {
        super(linkChilds);
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
        super('img', className, '', name, [], { src }, false);
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
        super('button', className, (!content || content instanceof Array) ? '' : content, name, content instanceof Array ? content : [], {}, false);
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
        super('div', className, (!content || content instanceof Array) ? '' : content, name, content instanceof Array ? content : [], {}, false);
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
        super('header', className, (!content || content instanceof Array) ? '' : content, name, content instanceof Array ? content : [], {}, false);
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
        super('div', className, (!content || content instanceof Array) ? '' : content, name, content instanceof Array ? content : [], {}, false);
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
        super('h1', className, (!content || content instanceof Array) ? '' : content, name, content instanceof Array ? content : [], {}, false);
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
        super('h2', className, (!content || content instanceof Array) ? '' : content, name, content instanceof Array ? content : [], {}, false);
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
        super('h3', className, (!content || content instanceof Array) ? '' : content, name, content instanceof Array ? content : [], {}, false);
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
        super('h4', className, (!content || content instanceof Array) ? '' : content, name, content instanceof Array ? content : [], {}, false);
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
        super('h5', className, (!content || content instanceof Array) ? '' : content, name, content instanceof Array ? content : [], {}, false);
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
        super('h6', className, (!content || content instanceof Array) ? '' : content, name, content instanceof Array ? content : [], {}, false);
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
        super('p', className, (!content || content instanceof Array) ? '' : content, name, content instanceof Array ? content : [], {}, false);
    }
}


/**
 * Creates an <input> element
 */
class Input extends DOMElement {
    constructor(name = "", className = "", type = "text", placeholder = '', required = false, minLength = null, maxLength = null) {
        super('input', className, '', name, [], {
            placeholder, required, minLength, maxLength
        }, false);
    }
}