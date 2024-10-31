<template>
    <el-tabs type="card">
        <el-tab-pane label="Ключи">
            <keys :project_id="project_id"></keys>
        </el-tab-pane>
        <el-tab-pane label="Статистика">
            <statistic :project_id="Number(project_id)"></statistic>
        </el-tab-pane>
    </el-tabs>
</template>
<script>
import Keys from "./keys.vue";
import Statistic from "@/admin/js/views/statistic/index";
export default {
    components: {
        Keys, Statistic
    },
    props: {
        project_id: [String, Object]
    },
    data() {
        return {

        };
    },
    methods: {

    }
};
</script>
