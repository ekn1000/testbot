<template>
    <key-form
        :form="form"
        :formAction="formAction"
        :closeMsg="'Ключ добавлен'"
        @close="closeModal"
    ></key-form>

</template>
<script>
import KeyForm from './components/form'

export default {
    components: {
        KeyForm,
    },
    computed: {

    },
    data() {
        return {
            formAction: {
                url: '/api/admin/project-keys',
                method: 'post',
            },
            form: {
                keyword:"",
                targeturl:"",
                project_id:null,
                frequency: "",
                position_up: 0,
                target_position:0,
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
    mounted() {

    }
}
</script>
