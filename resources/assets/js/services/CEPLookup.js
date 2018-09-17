import axios from "axios";
import API from "./API";
import Endpoints from "../config/Endpoints";

const LookupProviders = {
	postmon: {
		url: 'https://api.postmon.com.br/v1/cep/@cep@',
		map: {street: 'logradouro', neighborhood: 'bairro', city: 'cidade', uf: 'estado'}
	},
	viacep: {
		url: 'https://viacep.com.br/ws/@cep@/json/',
		map: {street: 'logradouro', neighborhood: 'bairro', city: 'localidade', uf: 'uf'}
	}
};


function getLookupURL(cep, provider) {
	if(!provider) provider = 'viacep';
	return LookupProviders[provider].url.replace(/@cep@/g, cep.replace(/[^0-9]+/g, ''))
}

function getLookupField(data, field, provider) {
	if(!provider) provider = 'viacep';
	return data[LookupProviders[provider].map[field]];
}


export function lookupCEP(cep) {

	let address = {};
	let headers = {};

	return axios.get(getLookupURL(cep), {headers: headers})
		.then((res) => {

			if(!res || !res.data) {
				return Promise.resolve({});
			}

			address = {
				street: getLookupField(res.data, 'street'),
				neighborhood: getLookupField(res.data, 'neighborhood'),
				city: getLookupField(res.data, 'city'),
				uf: getLookupField(res.data, 'uf'),
			};

			return axios.get(API.url(Endpoints.Cities.FindByName + '?name=' + address.city + '&uf=' + address.uf))

		})
		.then((res) => {

			if(!res || !res.data || !res.data.found) {
				return Promise.resolve(address);
			}

			address.city_id = res.data.city_id;
			address.city_object = res.data.city_object;

			return Promise.resolve(address);

		})
		.catch((err) => {
			return Promise.resolve({});
		})

}