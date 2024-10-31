<template>
    <section class="page">
        <input type="hidden" id="task_url" :value="taskUrl">
        <div class="page-heading d-flex align-items-center justify-content-between mb-3" style="gap:20px;">
            <el-input
                v-model="filters[0].value"
                size="large"
                placeholder="Поиск: Название"/>
            <el-button type="primary" icon="el-icon-plus" @click="modalOpen('create')">Добавить проект</el-button>
        </div>
        <data-tables style="width: 100%" :data="projects"  :filters="filters" >

            <el-table-column

                fixed
                label="Название проекта"
                prop="name"
                sortable
                min-width="155px"
            >
            </el-table-column>
            <el-table-column
                min-width="120px"
                label="Домен"
                prop="targeturl"
                sortable
            >
            </el-table-column>

            <el-table-column
                label="Дата"
                prop="created_at"
                min-width="100px"
                sortable
            >
            </el-table-column>
            <el-table-column
                min-width="190px"

                label="Дневной объем заданий"
                prop="daily_volume_of_keys"
                sortable
            >
            </el-table-column>
            <!--
            <el-table-column
                label="% повторных заходов"
                sortable
                min-width="180px"
            >
                <template slot-scope="scope">
                    {{scope.row.percentage_of_repeat_visits}}%
                </template>
            </el-table-column>
            -->
            <el-table-column
                min-width="200px"
                label="Параметры"
                prop="getparameters"
            >
            </el-table-column>
            <el-table-column
                label="Ключи"
                min-width="240px"
            >
                <template slot-scope="scope">
                    <div class="d-flex align-items-center" style="column-gap: 8px">
                        <div style="white-space: nowrap">
                            <span style="color: green">
                            {{scope.row.active_keys}}
                            </span>
                                /
                                <span style="color:darkred;">
                                {{scope.row.stopped_keys}}
                            </span>
                        </div>
                        <div style="display: flex">
                            <el-tooltip class="item" effect="dark"
                                        content="Редактировать список ключей"
                                        placement="bottom">
                                <router-link style="margin-left: 10px; margin-right: 10px" :to="'/project-groups/' + $route.params.id + '/' + scope.row.id">
                                    <el-button
                                        style="min-width: 28px"

                                        type="info" icon="el-icon-setting" circle></el-button>
                                </router-link>
                            </el-tooltip>
                            <el-tooltip class="item" effect="dark"
                                        content="Запустить все ключи проекта"
                                        placement="bottom">
                            <el-button
                                style="min-width: 28px"
                                @click.prevent="handleKeyBatchStatus(scope.row.id, true)"
                                type="success" icon="el-icon-video-play" circle></el-button>
                            </el-tooltip>

                            <el-tooltip class="item" effect="dark"
                                        content="Остановить все ключи проекта"
                                        placement="bottom">
                                <el-button
                                    style="min-width: 28px"
                                    @click.prevent="handleKeyBatchStatus(scope.row.id, false)"
                                    type="warning" icon="el-icon-video-pause" circle></el-button>
                            </el-tooltip>


                        </div>

                    </div>
                </template>
            </el-table-column>
            <el-table-column
                fixed="right"
                label="Статус"
                min-width="100px"
                prop="active"
            >
                <template slot-scope="scope">
                    <span style="color:green;" v-if="scope.row.active">
                        Активен
                    </span>
                    <span style="color: darkred" v-else>
                        Остановлен
                    </span>

                </template>
            </el-table-column>
            <el-table-column
                label="Действия"
                fixed="right"
                width="205px"
            >

            <template slot-scope="scope" >
                    <el-tooltip class="item" effect="dark"
                                content="Остановить/Запустить проект"
                                placement="bottom">
                        <el-button
                            :icon="stopOrPauseIcon(scope.row.active)" circle
                            :type="scope.row.active ? 'info' : 'success'"
                            @click="handleProjectStatus(scope.row)"></el-button>
                    </el-tooltip>

                    <el-tooltip class="item" effect="dark"
                                content="Копировать api url проекта"
                                placement="bottom">
                        <el-button
                            type="info"
                            icon="el-icon-copy-document"
                            circle
                            @click.prevent="copyTaskUrl(scope.row)"
                        >
                        </el-button>
                    </el-tooltip>

                    <el-tooltip class="item" effect="dark"
                                content="Редактировать проект"
                                placement="bottom">
                        <el-button
                            icon="el-icon-edit" circle
                            type="primary"
                            @click="handleEdit(scope.row.id)"></el-button>
                    </el-tooltip>

                    <el-tooltip class="item" effect="dark"
                                content="Удалить проект"
                                placement="bottom">
                        <el-button
                            icon="el-icon-delete" circle
                            type="danger"
                            @click="handleDelete(scope.row)"
                        >

                        </el-button>
                    </el-tooltip>
                </template>
            </el-table-column>
        </data-tables>
        <el-dialog
            :visible.sync="modalVisible"
            width="70%"
            :title="modalTitle"
        >
            <create
                @close="closeModal"
                v-if="modalVisible && modalStatus === 'create'"></create>
            <edit
                :id="id"
                @close="closeModal"
                v-if="modalVisible && modalStatus === 'edit'"></edit>
        </el-dialog>
    </section>
</template>
<script>
import edit from "./edit.vue";
import create from "./create.vue";
import {activeIconMixin} from '@/admin/js/mixins/activeIconMixin';
import {copyProjectApiUrlMixin} from "@/admin/js/mixins/copyProjectApiUrlMixin";
import {touchScroll} from '@/admin/js/directive/el-table/tableScroll';
export default {
    components: {create, edit},
props: {
    group_id: [String, Object]
},
    mixins: [activeIconMixin, copyProjectApiUrlMixin],
    data() {
    return {
        taskUrl: "",
        id: null,
        modalStatus: '',
        modalVisible:false,
        projects: [],
        filters: [
            {
                prop: ['name'],
                value: ""
            }
        ],
        }
    },
    computed: {
        modalTitle:function () {
            if(this.modalStatus === 'create') {
                return 'Новый проект';
            }
            if(this.modalStatus === 'edit') {
                return 'Редактировать проект';
            }
        },
    },
    methods: {
        handleKeyBatchStatus(id, status) {
            let msg = status ? 'Ключи в проекте активированы' :  'Ключи в проекте остановлены' ;
            axios.post('/api/admin/handle-batch-status', {parent_id: id, status:status, type: 'key'})
                .then((response) => {
                    this.$message({
                        type: 'success',
                        message:msg
                    });
                })
        },
        handleProjectStatus(item) {
            axios.post('/api/admin/handle-status', {id: item.id, status: !item.active, type:'project'})
                .then((response) => {
                    let index = this.projects.findIndex(project => project.id === item.id);
                    this.projects[index].active = response.data;
                    this.$message({
                        message: 'Статус Проекта изменен',
                        type: 'success'
                    });
                })
                .catch((error) => {

                })
        },
        getProjects() {
            axios.get('/api/admin/projects', {params: {'group_id': this.group_id}})
                .then((response) => {
                    this.projects = response.data;
                })
                .catch((error) => {
                    console.log(error)
                    if (error.message === 'Request failed with status code 403') {
                        this.$router.push('/404');
                    }
                })
        },
        modalOpen(status) {
            this.modalStatus = status;
            this.modalVisible= true;

        },
        closeModal(data) {
            this.modalVisible= false;
            this.id = null;
            this.getProjects();
        },
        handleEdit(id) {
            this.id = id;
            this.modalStatus = 'edit';
            this.modalVisible = true;
        },
        handleDelete(item) {
            this.$confirm('Вы уверены что хотите удалить проект', 'Удаление проекта', {
                confirmButtonText: 'Удалить',
                cancelButtonText: 'Отмена',
                type: 'warning'
            }).then(() => {
                axios.delete('/api/admin/projects/' + item.id)
                    .then((response) => {
                        let index = this.projects.findIndex(item => item.id === response.data.id);
                        this.projects.splice(index, 1);
                        this.$message({
                            type: 'success',
                            message: 'Проект удален'
                        });
                    });

            }).catch(() => {

            });
        },

    },
    mounted() {
    touchScroll('.el-table__body-wrapper')
    this.getProjects();
       // this.modalOpen('create');

    }
}
</script>
