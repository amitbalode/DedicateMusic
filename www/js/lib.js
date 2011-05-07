/* Returns the class name of the argument or undefined if
   it's not a valid JavaScript object.
*/
function getObjectClass(obj) {
	   if (typeof obj != "object" || obj === null) return false;
	   else return /(\w+)\(/.exec(obj.constructor.toString())[1];

}