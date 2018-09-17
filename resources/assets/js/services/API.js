export default {

	getToken() {
		return window.SGPS_TOKEN || null;
	},

	getUserId() {
		return window.SGPS_USER_ID || null;
	},

	isLoggedIn() {
		return !!window.SGPS_USER_ID
	},

	headers() {
		if(!this.isLoggedIn()) return {};
		return {headers: {Authorization: 'Bearer ' + this.getToken()}}
	},

	connectUser(userId, token) {
		window.SGPS_USER_ID = userId;
		window.SGPS_TOKEN = token;
	},

	url(endpoint, params) {
		if(!params) {
			params = this.isLoggedIn() ? {user: this.getUserId()} : {};
		}

		Object.keys(params).forEach((key) => {
			endpoint = ("" + endpoint).replace(new RegExp('\@' + key + '\@', 'g'), params[key]);
		});

		return window.SGPS_API_URL + endpoint;
	}

}