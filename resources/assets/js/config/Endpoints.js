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

	Flags: {
		FetchAll: 'api/flags',
	}

}