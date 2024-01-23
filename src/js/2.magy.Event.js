/**
 * An event manager assignable to an object
 */
class EventHandler extends MagyReflectionHelper {
    #storedEvents = [];
    #autoLinkEvents = [];

    /**
     * Check if the given event if an auto linked event
     * @param {String} eventName the name of the event
     * @returns {Boolean}
     */
    hasAutoLinkEvent(eventName) {
        eventName = eventName.toLowerCase();
        for (let i = 0; i < this.#autoLinkEvents.length; i++) {
            if (this.#autoLinkEvents[i] == eventName) {
                return true;
            }
        }
        return false;
    }

    /**
     * Declare an event. Declaring an event enables auto linking on functions
     * For example : onMyPopupClosed is autolinked to "closed" event
     * @param {String} eventName the name of the event
     */
    createEvent(eventName) {
        this.#autoLinkEvents.push(eventName.toLowerCase());
    }

    /**
     * Link a callable to an event name to be called when dispatchEvent(eventName) is called
     * @param {String} eventName The name of the event
     * @param {Function} action The callable to link
     * @param {Boolean} once Specify true if you wan't to remove your listener when the event is dispatched
     */
    addListener(eventName, action, once = false) {
        eventName = eventName.toLocaleLowerCase();
        if (!this.#storedEvents[eventName]) {
            this.#storedEvents[eventName] = [];
        }
        this.#storedEvents[eventName].push({ action, options: { once } });
    }

    /**
     * Remove the link made between the event name and the callable
     * @param {String} eventName The name of the event
     * @param {Function} action The linked callable
     */
    removeListener(eventName, action) {
        eventName = eventName.toLocaleLowerCase();
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
        eventName = eventName.toLocaleLowerCase();
        if (!this.#storedEvents[eventName]) return;

        const awaiters = [];
        const eList = this.#storedEvents[eventName];
        for (let i = 0; i < eList.length; i++) {
            if (!eList[i].action) continue;
            const value = eList[i].action(...args);
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
