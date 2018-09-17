<template>
	<div class="comments__panel">

		<loading-feedback :is-loading="isLoading"></loading-feedback>

		<table class="table">
			<thead>
				<tr>
					<th>Data e hora</th>
					<th>Operador</th>
					<th>Anotação</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="comment in comments">
					<td width="15">{{comment.created_at}}</td>
					<td width="15"><i class="fa fa-user"></i> {{comment.user.name}}</td>
					<td width="70">{{comment.message}}</td>
				</tr>
				<tr v-if="!comments || comments.length <= 0" class="text-center text-danger">
					<td colspan="3">Nenhuma anotação registrada!</td>
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
		props: ['entityType', 'entityId'],

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