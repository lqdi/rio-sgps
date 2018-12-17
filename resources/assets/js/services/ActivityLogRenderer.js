import Strings from "../config/Strings";

export default {

	renderDescription: function (description) {
		return Strings[description] ? Strings[description] : description;
	},

	renderKey: function(key) {
		return Strings[key] ? Strings[key] : key;
	},

	renderValue: function(key, value) {

		switch(key) {
			case 'user': return this.renderUser(value);
			case 'assigned_user': return this.renderUser(value);
			case 'flag': return this.renderFlag(value);
			case 'member': return this.renderPerson(value);
			case 'entity': return this.renderEntity(value);
			case 'given_answers': return this.renderGivenAnswers(value);
			default: return (value.length <= 64 && Strings[value]) ? Strings[value] : value;
		}

	},

	renderPerson: function (person) {
		return `${person.name} (${person.shortcode})`;
	},

	renderUser: function (user) {
		return `${user.name} (${user.registration_number})`;
	},

	renderFlag: function (flag) {
		return `${flag.name} (${flag.shortcode})`;
	},

	renderEntity: function (entity) {
		switch(entity.type) {
			case 'family': return `Família: ${entity.name} (${entity.shortcode})`;
			case 'residence': return `Domicílio: ${entity.address} (${entity.shortcode})`;
			case 'person': return `Indivíduo: ${entity.name} (${entity.shortcode})`;
			default: return `Entidade: ${entity.type}:${entity.id}`;
		}
	},

	renderGivenAnswers: function (answers) {
		return Object.entries(answers)
			.map((kv) => `${kv[0]}: ${kv[1]}`)
			.join('; ')
	}

}