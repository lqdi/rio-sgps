import { create } from 'vue-modal-dialogs'
import FilterFlagsModal from '../modals/FlagsFilterModal';

const selectFilterFlags = create(FilterFlagsModal, 'selectedFlags');

export default {

	props: ['activeFilters'],

	data: () => { return {
		isLoading: false,
		filters: {}
	}},

	mounted: function() {
		if(!this.activeFilters) return;
		this.filters = Object.assign(this.filters, this.activeFilters);
	},

	methods: {
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