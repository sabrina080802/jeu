/**
 * Provide methods to retrieve and manipulate class using reflection
 */
class MagyReflectionHelper {
  constructor() {
    console.log(this.constructor.prototype);
  }
  /**
   * @return An array containing all methods of this class, including parent and childs classes
   */
  getMethods() {
    let methods = [];
    let currentPrototype = this.prototype;
    while (currentPrototype) {
      methods = methods.concat(Object.getOwnPropertyNames(currentPrototype));
      currentPrototype = Object.getPrototypeOf(currentPrototype);
    }
    return methods.filter(
      (method) => typeof this.prototype[method] === "function"
    );
  }
}
const reflectionHelper = new MagyReflectionHelper();
const methods = reflectionHelper.getMethods();
console.log(methods);