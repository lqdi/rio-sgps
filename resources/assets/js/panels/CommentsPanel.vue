<template>
	<div class="comments__panel">

		<loading-feedback :is-loading="isLoading"></loading-feedback>

		<table class="table">
			<thead>
				<tr>
					<th>Data e hora</th>
					<th>Operador</th>
					<th colspan="2">Anotação</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="comment in comments">
					<td width="10">{{comment.created_at | moment('DD/MM/YYYY HH:mm:ss')}}</td>
					<td width="15"><i class="fa fa-user"></i> {{comment.user.name}}</td>
					<td width="70">
						<div v-if="!comment.is_editing" style="white-space: pre-line">{{comment.message}}</div>

						<form method="post" @submit.prevent="saveEditedComment(comment)" v-if="comment.is_editing">
							<div>
								<textarea :id="'editCommentFld_' + comment.id" v-model="comment.updated_message" placeholder="Digite sua anotação aqui ... " class="form-control" style="height: 100px"></textarea>
							</div>
							<div class="mt-1 text-right">
								<div class="btn-group btn-group-sm">
									<button type="button" @click="cancelEdit(comment)" class="btn btn-sm btn-light text-primary pull-right">Cancelar <i class="fa fa-arrow-left"></i></button>
									<button type="submit" class="btn btn-sm btn-primary pull-right">Salvar <i class="fa fa-save"></i></button>
								</div>
							</div>
						</form>
					</td>
					<td width="5">
						<div v-if="!comment.is_editing && (comment.is_owned_by_me || isAdmin)">
							<a @click="beginEditComment(comment)" class="btn btn-light btn-sm"><i class="fa fa-edit"></i></a>
							<a @click="deleteComment(comment)" class="btn btn-light text-danger btn-sm"><i class="fa fa-trash"></i></a>
						</div>
					</td>
				</tr>
				<tr v-if="!comments || comments.length <= 0" class="text-center text-danger">
					<td colspan="4">Nenhuma anotação registrada!</td>
				</tr>
			</tbody>
		</table>

		<form v-on:submit.prevent="postNewComment()" class="card">
			<div class="card-header"><i class="fa fa-plus"></i> Nova anotação</div>
			<div class="card-body">
				<textarea v-model="newComment.message" placeholder="Digite sua anotação aqui ... " class="form-control" style="height: 100px"></textarea>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-sm btn-primary pull-right">Registrar anotação <i class="fa fa-edit"></i></button>
			</div>
		</form>

	</div>
</template>
<script>

	import API from "../services/API";
	import Endpoints from "../config/Endpoints";
	import axios from "axios";

	export default {
		props: ['entityType', 'entityId', 'isAdmin'],

		data: () => { return {
			newComment: {message: ''},
			comments: [],
			isLoading: false,
		}},

		mounted: function() {
			this.refreshThread();
		},

		methods: {

			refreshThread() {

				this.isLoading = true;

				axios.get(
					API.url(Endpoints.Comments.FetchThread, {type: this.entityType, id: this.entityId}),
					API.headers()
				).then((res) => {
					this.isLoading = false;
					this.comments = res.data.comments;
					this.newComment.message = '';
				}).catch((err) => {
					this.isLoading = false;
					console.error("CommentsPanel -> failed to fetch thread: ", err);
				})

			},

			beginEditComment(comment) {
				comment.updated_message = comment.message;
				comment.is_editing = true;

				this.$forceUpdate();
				this.$nextTick(() => document.getElementById('editCommentFld_' + comment.id).focus());
			},

			cancelEdit(comment) {
				comment.updated_message = null;
				comment.is_editing = false;

				this.$forceUpdate();
			},

			saveEditedComment(comment) {
				comment.is_editing = false;
				this.$forceUpdate();

				if(comment.updated_message === comment.message) {
					return;
				}

				this.isLoading = true;

				axios.post(
					API.url(Endpoints.Comments.UpdateComment, {id: comment.id}),
					{message: comment.updated_message},
					API.headers()
				).then((res) => {
					this.isLoading = false;
					this.refreshThread();
				}).catch((err) => {
					this.isLoading = false;
					console.error("CommentsPanel -> failed to save comment: ", err, comment);
				})
			},

			deleteComment(comment) {

				if(!confirm('Tem certeza que deseja excluir a mensagem?')) {
					return;
				}

				this.isLoading = true;

				axios.delete(
					API.url(Endpoints.Comments.DeleteComment, {id: comment.id}),
					API.headers()
				).then((res) => {
					this.isLoading = false;
					this.refreshThread();
				}).catch((err) => {
					this.isLoading = false;
					console.error("CommentsPanel -> failed to delete comment: ", err, comment);
				})
			},

			postNewComment() {

				axios.post(
					API.url(Endpoints.Comments.PostComment, {type: this.entityType, id: this.entityId}),
					this.newComment,
					API.headers()
				).then((res) => {
					this.isLoading = false;
					this.refreshThread();
				}).catch((err) => {
					this.isLoading = false;
					console.error("CommentsPanel -> failed to post comment: ", err);
				})

			}

		}

	}

</script>