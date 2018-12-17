import { create } from 'vue-modal-dialogs'
import FilterFlagsModal from '../modals/FlagsFilterModal';
import Endpoints from "../config/Endpoints";
import API from "../services/API";

const selectFilterFlags = create(FilterFlagsModal, 'selectedFlags');

export default {

	props: ['activeFilters'],

	data: () => { return {
		isLoading: false,
		filters: {q: ''}
	}},

	mounted: function() {
		if(!this.activeFilters) return;
		this.filters = Object.assign(this.filters, this.activeFilters);
	},

	methods: {

		exportResults: function() {

			this.isLoading = true;

			axios.post(
				API.url(Endpoints.Family.Export),
				{},
				API.headers()
			).then((res) => {
				console.log('Exported: ', res);

				if(!res.data.download_url);

				window.open(res.data.download_url);

				this.isLoading = false;
			})

		},

		setFilter: function (filterName, value) {
			this.filters[filterName] = value;
			this.filters = Object.assign({}, this.filters);
			this.doSearch();
		},

		selectFlagsToFilter: async function() {
			let selectedFlags = await selectFilterFlags(this.filters.flags);

			if(!selectedFlags) return;

			this.setFilter('flags', selectedFlags);
			this.doSearch();
		},

		doSearch: function() {
			this.isLoading = true;
			this.$nextTick(() => this.$refs.filterForm.submit());
		}
	}


}