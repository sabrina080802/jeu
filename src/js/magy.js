/** Magy instance */
const app = new Magy();

/**
 * Object framework
 */
class Magy {
    //Privates
    #waitingCalls = [];
    #isReady = false;
    http = null;
    DOM = null;

    constructor() {
        document.addEventListener('DOMContentLoaded', onDOMContentLoaded);
        this.http = new MagyHttpBuilder();
        this.DOM = new MagyDOMBuilder();
    }
    //Waits DOM to be ready
    #onDOMContentLoaded() {
        this.#isReady = true;
        this.#waitingCalls.forEach(callback => callback());
    }
    /**
     * Run a function when Magy is ready
     * Consider DOM to be ready too
     * @param {CallableFunction} action A function called when Magy is ready
     */
    run(action) {
        if (this.#isReady) {
            action();
        }
        else {
            this.#waitingCalls.push(action);
        }
    }
}