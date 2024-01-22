/**
 * Provide methods to retrieve and manipulate class using reflection
 */
class MagyReflectionHelper {
    /**
     * @return An array containing all methods of this class, including parent and childs classes
     */
    getMethods() {
        let methods = [];
        let currentPrototype = this.__proto__;
        while (currentPrototype) {
            methods = methods.concat(Object.getOwnPropertyNames(currentPrototype));
            currentPrototype = Object.getPrototypeOf(currentPrototype);
        }

        return methods.filter(
            (method) => typeof this.__proto__[method] === "function"
        );
    }
}