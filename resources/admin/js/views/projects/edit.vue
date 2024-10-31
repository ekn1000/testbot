<template>
    <section>
        <project-form
            :save-msg="'Проект обновлен'"
            v-if="loaded"
            :form="form"
            :formAction="formAction"
            @close="closeModal"
        ></project-form>
    </section>

</template>
<script>
import ProjectForm from "./components/form";
export default {
    components:{
        ProjectForm
    },
    props:['id'],
    data() {
        return {
            loaded:false,
            form: {

            },
            formAction: {
                url: '/api/admin/projects/' + this.id,
                method: 'put',
            },
        }
    },
    methods:{
        closeModal(data) {
            this.$emit('close',data)
        },
        getFormData() {
            this.$root.isLoading = true;
            return axios.get('/api/admin/projects/' + this.id)
                .then((response) => {
                    this.form = response.data;
                    this.loaded = true;
                    this.$root.isLoading = false;

                })
        }
    },
    async mounted() {
        await this.getFormData();
    }
}
</script>
