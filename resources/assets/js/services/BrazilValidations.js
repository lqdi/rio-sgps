export const CPFValidator = {
	getMessage: field => 'O CPF informado não é válido!',
	validate: value => !!("" + value).match(/\d\d\d\.\d\d\d\.\d\d\d-\d\d/g)
};

export const CEPValidator = {
	getMessage: field => 'O CEP informado não é válido!',
	validate: value => !!("" + value).match(/\d\d\d\d\d-\d\d\d/g)
};

export const PhoneWithDDDValidator = {
	getMessage: field => 'O número de telefone informado não é válido!',
	validate: value => !!("" + value).match(/\(\d\d\) \d\d\d\d-\d\d\d\d(\d)?/g)
};
