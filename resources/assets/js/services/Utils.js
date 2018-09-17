import AccentASCIIMap from "../config/AccentASCIIMap";

export default {

	foldAccentToASCII(s) {
		if (!s) {
			return '';
		}

		let ret = '';

		for (let i = 0; i < s.length; i++) {
			ret += AccentASCIIMap[s.charAt(i)] || s.charAt(i);
		}

		return ret;
	},

	 sortAlphabeticallyBy(property, isDesc) {

		isDesc = isDesc ? -1 : 1;

		return (a, b) => {
			let sa = ("" + a[property]).toLowerCase();
			let sb = ("" + b[property]).toLowerCase();
			return ((sa < sb) ? -1 : (sa > sb) ? 1 : 0) * isDesc;
		}
	}

}