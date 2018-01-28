'use srict';

/**
 * Performs inheritence, returns a new "sudo-class"
 * with an empty constructor whose prototype inherits
 * from the inputted prototype.
 *
 * @param {Object.prototype} proto The prototype of
 * the Parent sudo-class.
 *
 * @returns {Function} A "sudo-class" inheriting inputted
 * prototype.
 */
function inherit(proto) {
	function F() {}
	F.prototype = proto;
	return new F;
}

/**
 * Preforms extend, like other classical Object-Oriented
 * programming languages such as C++, Java, and PHP.
 *
 * @param {Function} Child The "sudo-class" to prform "extends".
 * @param {Function} Parent The "sudo-class" to be "extended".
 */
function extend(Child, Parent) {
	Child.prototype = inherit(Parent.prototype);
	Child.prototype.constructor = Child;
	Child.parent = Parent.prototype;
}