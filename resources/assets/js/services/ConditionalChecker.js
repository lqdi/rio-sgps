import moment from "moment";

const CHILDREN_MAX_AGE = 14;

let calculateAgeInYears = function (dob) {
	if(!dob) return 0;
	return moment().diff(dob, 'years');
};

export let ConditionRules = {

	is_true: (fieldValue) => !!fieldValue,
	is_false: (fieldValue) => ! fieldValue,
	is_filled: (fieldValue) => (fieldValue !== null && ("" + fieldValue) !== ""),
	is_not_filled: (fieldValue) => !(fieldValue !== null && ("" + fieldValue) !== ""),
	eq: (fieldValue, param) => ("" + fieldValue) === ("" + param),
	ieq: (fieldValue, param) => ("" + fieldValue) !== ("" + param),
	is_one_of: (fieldValue, params) => params.map((p) => ("" + p)).indexOf("" + fieldValue) !== -1,
	before_today: (fieldValue) => moment(fieldValue).isBefore(moment()),
	age_between: (fieldValue, paramA, paramB) => {
		let age = calculateAgeInYears(fieldValue);
		return age >= paramA && age <= paramB;
	},
	age_gt: (fieldValue, param) => calculateAgeInYears(fieldValue) >= param,
	age_lt: (fieldValue, param) => calculateAgeInYears(fieldValue) <= param,
	is_children: (fieldValue) => calculateAgeInYears(fieldValue) <= CHILDREN_MAX_AGE,

};

export function checkConditions(conditions, answers) {

	if(!conditions || conditions.length <= 0) return true;

	return conditions.every((condition) => {

		let fieldCode = condition[0];
		let ruleName = condition[1];

		let fieldValue = answers[fieldCode];
		let rule = ConditionRules[ruleName];

		return rule.apply(rule, [fieldValue, ...condition.slice(2)])
	})

}