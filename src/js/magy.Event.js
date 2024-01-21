/**
 * An event manager assignable to an object
 */
class EventHandler {
    #storedEvents = [];

    /**
     * Link a callable to an event name to be called when dispatchEvent(eventName) is called
     * @param {String} eventName The name of the event
     * @param {Function} action The callable to link
     * @param {Boolean} once Specify true if you wan't to remove your listener when the event is dispatched
     */
    addListener(eventName, action, once = false) {
        if (!this.#storedEvents[eventName]) {
            this.#storedEvents[eventName] = [];
        }
        this.#storedEvents[eventName].push({ action, options });
    }

    /**
     * Remove the link made between the event name and the callable
     * @param {String} eventName The name of the event
     * @param {Function} action The linked callable
     */
    removeListener(eventName, action) {
        if (!this.#storedEvents[eventName]) return;
        const eList = this.#storedEvents[eventName];
        for (let i = 0; i < eList.length; i++) {
            if (eList[i].callback == action) {
                eList.splice(i, 1);
                return;
            }
        }
    }

    /**
     * Execute all callables linked to the specified event name.
     * @param {String} eventName The name of the event
     * @param {*} args Arguments passed to each callables
     * @return {Array} Returns an array containing Promises for async callables
     */
    dispatchEvent(eventName, ...args) {
        if (!this.#storedEvents[eventName]) return;

        const awaiters = [];
        const eList = this.#storedEvents[eventName];
        for (let i = 0; i < eList.length; i++) {
            if (!eList[i].callback) continue;
            const value = eList[i].callback(...args);
            if (value instanceof Promise) {
                awaiters.push(value);
            }
            if (eList[i].options && eList[i].options.once === true) {
                eList.splice(i--, 1);
            }
        }

        return awaiters;
    }
}
