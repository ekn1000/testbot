<template>
    <key-form
        :form="form"
        :formAction="formAction"
        :closeMsg="'Ключи добавлены'"
        :mass-create="true"
        @close="closeModal"
    ></key-form>
</template>
<script>
import KeyForm from './components/form'
    export default {
        components: {
            KeyForm,
        },
        data() {
            return {
                formAction: {
                    url: '/api/admin/project-key/mass-create',
                    method: 'post',
                },
                form: {
                    keywords:"",
                    targeturl:"",
                    project_id:null,
                    frequency: "",
                    coefficient: "",
                    frequency_of_cheating: "",
                    getparameters:'',
                    active:false,
                }
            }
        },
        methods: {
            closeModal(data) {
                this.$emit('close', data)
            },

        },
    }
</script>
