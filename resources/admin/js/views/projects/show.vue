<template>
    <router-view :project_id="$route.params.project_id"></router-view>
</template>
<script>
export default {
    methods: {
        getBreadcrumbName() {
            this.$root.isLoading = true;
            return axios.get('/api/admin/projects/' + this.$route.params.project_id)
                .then((response) => {
                    this.$route.meta.title = response.data.name;
                    this.$root.isLoading = false;
                })
        }
    },
    mounted() {
        //this.getBreadcrumbName();
    }
}
</script>
