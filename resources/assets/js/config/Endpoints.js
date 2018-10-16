export default {

	Comments: {
		FetchThread: 'api/comments/thread/@type@/@id@',
		PostComment: 'api/comments/thread/@type@/@id@',
	},

	Questions: {
		FetchCategories: 'api/questions/categories',
		SaveAnswers: 'api/questions/answers/@type@/@id@',
		FetchQuestionsByCategory: 'api/questions/categories/@category@',
		FetchQuestionsByEntity: 'api/questions/@category@/@type@/@id@',
	},

	Family: {
		AddMember: 'api/families/@id@/add_member',
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
	}

}