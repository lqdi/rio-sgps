export default {

	Comments: {
		FetchThread: 'api/comments/thread/@type@/@id@',
		PostComment: 'api/comments/thread/@type@/@id@',
		DeleteComment: 'api/comments/comment/@id@',
		UpdateComment: 'api/comments/comment/@id@',
	},

	Questions: {
		FetchCategories: 'api/questions/categories',
		SaveAnswers: 'api/questions/answers/@type@/@id@',
		FetchQuestionsByCategory: 'api/questions/categories/@category@',
		FetchQuestionsByEntity: 'api/questions/@category@/@type@/@id@',
	},

	Export: {
		Residences: 'api/export/residences.xls',
		Persons: 'api/export/persons.xls',
		Families: 'api/export/families.xls',
	},

	Family: {
		AddMember: 'api/families/@id@/add_member',
		ArchiveMember: 'api/families/@family_id@/members/@member_id@/archive',
	},

	ActivityLog: {
		FetchThread: 'api/activity_log/@entity@/entries'
	},

	Flags: {
		FetchAll: 'api/flags',
		AddToEntity: 'api/flags/on_entity/@entity@/',
		Cancel: 'api/flags/on_entity/@entity@/@flag_id@/cancel',
		Complete: 'api/flags/on_entity/@entity@/@flag_id@/complete',
	},

	Assignments: {
		FetchAssignableUsers: 'api/assignments/@entity@/assignable_users',
		AssignUserToEntity: 'api/assignments/@entity@/assign',
		UnassignUserFromEntity: 'api/assignments/@entity@/unassign',
	},

	Reports: {
		AllMetrics: 'api/reports/all_metrics',
	}

}