/**
 * Object framework
 */
const app = new (class Magy {
    //Privates
    #waitingCalls = [];
    #isReady = false;
    http = null;
    DOM = null;

    constructor() {
        document.addEventListener("DOMContentLoaded", () => this.#onDOMContentLoaded());
    }
    //Waits DOM to be ready
    #onDOMContentLoaded() {
        this.http = new MagyHttpBuilder();
        this.DOM = new MagyDOMBuilder();

        this.#isReady = true;
        this.#waitingCalls.forEach((callback) => callback());
    }

    /**
     * Run a function when Magy is ready
     * Consider DOM to be ready too
     * @param {CallableFunction} action A function called when Magy is ready
     */
    run(action) {
        if (this.#isReady) {
            action();
        } else {
            this.#waitingCalls.push(action);
        }
    }

    /**
     * Wait time asynchronously
     * @param {Number} time The time to await
     */
    wait(time) {
        return new Promise((resolve) => {
            setTimeout(resolve, time);
        });
    }
})();
