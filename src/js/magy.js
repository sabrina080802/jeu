const app = new Magy();

function Magy() {
  const self = this;
  new EventHandler(self);

  document.addEventListener("DOMContentLoaded", onDOMContentLoaded);

  this.request = async (url, data, method = "POST") => {
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
  };

  this.loadEntity = (name) => {};

  function onDOMContentLoaded() {
    const scriptList = document.head.querySelectorAll("preload");
  }
}

function EventHandler(target) {
  const self = this;
  const storedEvents = [];

  this.addListener = (eventName, callback, options) => {
    if (!storedEvents[eventName]) {
      storedEvents[eventName] = [];
    }
    storedEvents[eventName].push({ callback, options });
  };

  this.removeListener = (eventName, callback) => {
    if (!storedEvents[eventName]) return;

    const eList = storedEvents[eventName];
    for (let i = 0; i < eList.length; i++) {
      if (eList[i].callback === callback) {
        eList.splice(i, 1);
        return;
      }
    }
  };

  this.dispatchEvent = (eventName, ...data) => {
    if (!storedEvents[eventName]) return;

    const awaiters = [];
    const eList = storedEvents[eventName];
    for (let i = 0; i < eList.length; i++) {
      if (!eList[i].callback) continue;

      const value = eList[i].callback(...data);
      if (value instanceof Promise) {
        awaiters.push(value);
      }
    }

    return awaiters;
  };
}

function Point(x = 0, y = 0) {
  const self = this;
  this.x = x;
  this.y = y;

  this.distanceTo = function (point) {
    return Math.sqrt(
      (point.x - self.x) * (point.x - self.x) +
        (point.y - self.y) * (point.y - self.y)
    );
  };
}
