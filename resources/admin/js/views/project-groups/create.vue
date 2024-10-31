<template>
    <group-form
        :form="form"
        :formAction="formAction"
        :closeMsg="'Группа проектов добавлена'"
        @close="closeModal"
    ></group-form>

</template>
<script>
import GroupForm from './components/form'
import { mapGetters } from 'vuex';
export default {
    components: {
        GroupForm,
    },
    computed: {
        ...mapGetters([
            'userId',
        ]),
    },
    data() {
        return {
            formAction: {
                url: '/api/admin/project-groups',
                method: 'post',
            },
            form: {
                name:"",
                comment:"",
                user_id:null,
            }
        }
    },
    methods: {
        closeModal(data) {
            this.$emit('close', data)
        },
    },
    mounted() {
        this.form.user_id = this.userId;
    }
}
</script>
