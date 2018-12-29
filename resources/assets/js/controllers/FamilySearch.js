import { create } from 'vue-modal-dialogs'
import FilterFlagsModal from '../modals/FlagsFilterModal';
import ExportModal from '../modals/ExportModal';

const selectFilterFlags = create(FilterFlagsModal, 'selectedFlags');
const exportResults = create(ExportModal, 'filters');

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

		exportResults: async function() {
			await exportResults(this.filters);
		},

		setFilter: function (filterName, value) {
			this.filters[filterName] = value;
			this.filters = Object.assign({}, this.filters);

			this.$nextTick(() => this.doSearch());
		},

		selectFlagsToFilter: async function() {
			let selectedFlags = await selectFilterFlags(this.filters.flags);

			if(!selectedFlags) return;

			this.setFilter('flags', selectedFlags);
			this.doSearch();
		},

		doSearch: function() {
			this.isLoading = true;
			this.$forceUpdate();

			this.$nextTick(() => this.$refs.filterForm.submit());
		}
	}


}