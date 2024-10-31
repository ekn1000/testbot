<template>
    <section>
        <h1 class="page-title">Статистика</h1>
        <div class="page-heading row align-items-end  mb-3" >
            <div class="form-group col-lg-3">
                <label class="form-label">Проект:</label>
                <el-select
                    style="width: 100%"
                    v-model="filters.project_id" placeholder="Выбрать проект" @change="getProjectKeyTasks">
                    <el-option
                        v-for="item in filterOptions.projects"
                        :key="item.id"
                        :label="item.name"
                        :value="item.id">
                    </el-option>
                </el-select>
            </div>
            <div class="form-group col-lg-3 col-xl-2">
                <label class="form-label">pid:</label>
                <el-input
                    v-model="tableFilters[1].value"
                    size="large"
                    placeholder="Поиск: pid"/>
            </div>
            <div class="form-group col-lg-5">
                <label class="form-label">Ключевая фраза:</label>
                <el-input
                    v-model="tableFilters[0].value"
                    size="large"
                    placeholder="Поиск: keyword"/>
            </div>
        </div>
        <data-tables-server :data="project_key_tasks"
                            @query-change="getProjectKeyTasks"
                            :total="total"
                            :pagination-props="{ pageSizes: [50, 100, 200] }"  :filters="tableFilters" style="width: 100%">
            <el-table-column type="expand">
                <template slot-scope="props">
                    <div class="table-expand-body">
                        <p><b>projectname:</b> {{ props.row.projectname }}</p>
                        <p><b>getparameters:</b> {{ props.row.getparameters }}</p>
                        <p><b>device:</b> {{ props.row.device }}</p>
                        <p><b>cookies:</b> {{ props.row.cookies }}</p>
                        <p><b>uniquedomains:</b> {{ props.row.uniquedomains }}</p>
                        <p><b>ymdomains:</b> {{ props.row.ymdomains }}</p>
                        <p><b>gadomains: </b>{{ props.row.gadomains }}</p>
                        <p><b>proxy: </b>{{ props.row.proxy }}</p>
                        <p><b>ip:</b> {{ props.row.ip }}</p>
                    </div>

                </template>
            </el-table-column>
            <el-table-column
                label="Дата"
                prop="created_at"
                min-width="120px"
                sortable
            >
            </el-table-column>
            <el-table-column
                min-width="120px"
                label="taskid"
                prop="taskid"
                sortable
            >
            </el-table-column>
            <el-table-column
                min-width="100px"
                label="pid"
                prop="pid"
                sortable
            >
            </el-table-column>
            <el-table-column
                min-width="120px"
                label="projectid"
                prop="project_id"
                sortable
            >
            </el-table-column>
            <el-table-column
                min-width="200px"
                label="keyword"
                prop="keyword"
                sortable
            >
            </el-table-column>
            <el-table-column
                min-width="150px"
                label="targetdomain"
                prop="targetdomain"
                sortable
            >
            </el-table-column>
            <el-table-column
                min-width="160px"
                label="targeturl"
                prop="targeturl"
                sortable
            >
            </el-table-column>
            <el-table-column
                min-width="120px"
                label="ПЗЯ/ПЗГ"
                prop="tasktype"
                sortable
            >
            </el-table-column>
            <el-table-column
                min-width="120px"
                label="position"
                prop="position"
                sortable
            >
            </el-table-column>
            <el-table-column
                min-width="160px"
                label="relevant_url"
                prop="relevant_url"
                sortable
            >
            </el-table-column>
        </data-tables-server>
    </section>
</template>
<script>
export default {
    data() {
        return {
            total:0,
            project_key_tasks: [],
            filterOptions: {},
            filters: {
                project_id:null,

            },
            tableFilters: [
                {
                    prop: 'keyword',
                    value: ""
                },
                {
                    prop: 'pid',
                    value: ""
                },
            ],
        }
    },
    methods: {
        getProjectKeyTasks(query) {

            axios.get('/api/admin/project-key-tasks',{params:
                    {
                        page:query.page,
                        limit: query.pageSize,
                        filters: this.tableFilters,
                        project_id: this.filters.project_id,

                    }})
                .then((response) => {
                    this.project_key_tasks = response.data.data;
                    this.total = response.data.total
                })
        },
        getFilterOptions() {
            axios.get('/api/admin/project-key-task/filter-options')
                .then((response) => {
                    this.filterOptions = response.data;
                })
        }
    },
    mounted() {

        this.getFilterOptions();
    }
}
</script>
