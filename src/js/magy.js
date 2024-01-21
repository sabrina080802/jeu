const app = new Magy();

class Magy {
    #waitingCalls = [];
    #isReady = false;

    constructor() {
        document.addEventListener('DOMContentLoaded', onDOMContentLoaded);
        this.http = new MagyHttpBuilder();
    }
    onDOMContentLoaded() {
        this.#isReady = true;
        this.#waitingCalls.forEach(callback => callback());
    }
    run(callback) {
        if (this.#isReady) {
            callback();
        }
        else {
            this.#waitingCalls.push(callback);
        }
    }
}

class MagyHttpBuilder {
    async request(url, data, method = "POST") {
        try {
            const formData = new FormData();
            for (const key in data) {
                formData.append(key, data[key]);
            }

            // Options de la requête
            const requestOptions = {
                method: method,
                body: formData,
            };

            // Utilisation de fetch pour envoyer la requête POST
            const response = await fetch(url, requestOptions);
            if (!response.ok) {
                throw new Error("La requête a échoué.");
            }

            return await response.json();
        } catch (error) {
            return null;
        }
    }
}

class EventHandler {
    #storedEvents = [];

    addListener(eventName, callback, options) {
        if (!this.#storedEvents[eventName]) {
            this.#storedEvents[eventName] = [];
        }
        this.#storedEvents[eventName].push({ callback, options });
    }
    removeListener(eventName, callback) {
        if (!this.#storedEvents[eventName]) return;
        const eList = this.#storedEvents[eventName];
        for (let i = 0; i < eList.length; i++) {
            if (eList[i].callback == callback) {
                eList.splice(i, 1);
                return;
            }
        }
    }
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

class Point {
    x = 0;
    y = 0;

    constructor(x = 0, y = 0) {
        this.x = x;
        this.y = y;
    }
    distanceTo(point) {
        return Math.sqrt(
            (point.x - this.x) * (point.x - this.x) +
            (point.y - this.y) * (point.y - this.y)
        );
    }
}