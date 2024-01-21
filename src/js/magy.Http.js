/**
 * Fetch Wrapper
 */
class MagyHttpBuilder {
    /**
     * Create a fetch request
     * @param {String} url Request URL
     * @param {Object} data An object containing all datas
     * @param {String} method Http method, can be GET / POST / PUT / DELETE
     * @returns Promise, await it to get result
     */
    async request(url, data, method = "POST") {
        try {
            const formData = new FormData();
            for (const key in data) {
                if (data[key] instanceof Object) {
                    formData.append(key, JSON.stringify(data[key]));
                }
                else formData.append(key, data[key]);
            }

            const requestOptions = {
                method: method,
                body: formData,
            };

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