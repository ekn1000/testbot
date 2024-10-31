<template>
    <section>
        <key-form
            :save-msg="'Ключ обновлен'"
            v-if="loaded"
            :form="form"
            :formAction="formAction"
            @close="closeModal"
        ></key-form>
    </section>

</template>
<script>
import KeyForm from "./components/form";
export default {
    components:{
        KeyForm
    },
    props:['id'],
    data() {
        return {
            loaded:false,
            form: {

            },
            formAction: {
                url: '/api/admin/project-keys/' + this.id,
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
            return axios.get('/api/admin/project-keys/' + this.id)
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
