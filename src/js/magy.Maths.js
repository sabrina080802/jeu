/**
 * An object representing a point, containing x and y coords
 * @property {Number} x X position
 * @property {Number} y Y position
 */
class Point {
    x = 0;
    y = 0;

    constructor(x = 0, y = 0) {
        this.x = x;
        this.y = y;
    }
    /**
     * Calculate the distance between this point to another
     * @param {Point} point The other point
     * @returns {Number} Returns the distance
     */
    distanceTo(point) {
        return Math.sqrt(
            (point.x - this.x) * (point.x - this.x) +
            (point.y - this.y) * (point.y - this.y)
        );
    }
}