import {create} from "vue-modal-dialogs";

import AlertModal from '../dialogs/AlertModal'
import ConfirmModal from '../dialogs/ConfirmModal'
import PromptModal from '../dialogs/PromptModal'

export default {

	alert: create(AlertModal, 'message', 'title'),
	confirm: create(ConfirmModal, 'message', 'title'),
	prompt: create(PromptModal, 'message', 'initialValue', 'type', 'placeholder', 'title'),

}