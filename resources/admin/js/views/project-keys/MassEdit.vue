<template>
    <key-form
        :form="form"
        :formAction="formAction"
        :selected-items-ids="selectedItemsIds"
        :mass-edit="true"
        :status="status"
        @close="closeModal"
    ></key-form>
</template>
<script>
import KeyForm from './components/MassEditForm.vue'
    export default {
        components: {
            KeyForm,
        },
        props: {
            status: {
                type:String,
                default: 'mass-edit'
            },
            selectedItemsIds: {
                type: Array,
                default() {
                 return [];
                },
            }
        },
        data() {
            return {

                formAction: {
                    url: '/api/admin/project-key/mass-edit',
                    method: 'post',
                },
                form: {
                    targeturl:"",
                    project_id:null,
                    frequency: "",
                    coefficient: "",
                    frequency_of_cheating: "",
                    getparameters:'',
                    active:false
                }
            }
        },
        methods: {

            closeModal(data) {

                this.$emit('close', data)
            },

        },
        mounted() {
        }
    }
</script>
