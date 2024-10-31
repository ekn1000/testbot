<template>
    <section class="page">

        <div class="page-heading" style="gap:20px;">
            <div class="row ">
                <div class="col-lg-6 mb-3">
                    <el-input
                        v-model="filters[0].value"
                        size="large"
                        placeholder="Поиск: Ключ"/>
                </div>
                <div class="col-lg-6 mb-3">
                    <el-button type="primary" icon="el-icon-plus" @click="modalOpen('create')">
                        Добавить ключ
                    </el-button>
                    <el-button type="primary" icon="el-icon-folder-add" @click="modalOpen('mass-create')">
                        Добавить список ключей
                    </el-button>
                </div>
            </div>
            <div class="d-flex flex-wrap mb-3" style="gap:20px">
                <el-button type="primary" icon="el-icon-edit" @click="modalOpen('mass-edit-selection')">
                    Редактировать выбранные
                </el-button>
                <el-button type="primary" icon="el-icon-edit" @click="modalOpen('mass-edit')">
                    Редактировать по условию
                </el-button>
                <el-button type="danger" icon="el-icon-delete" @click="handleMassDelete('mass-delete-selection')">
                    Удалить выбранные ключи
                </el-button>
                <el-button type="danger" icon="el-icon-delete" @click="handleMassDelete('mass-delete')">
                    Удалить все ключи
                </el-button>
            </div>


        </div>
        <import @imported="getProjectKeys"></import>

        <data-tables
            :data="project_keys"
            :filters="filters"
            @selection-change="handleSelection"
            style="width: 100%;"
            :pagination-props="{ pageSizes: [20, 50, 100, 250, 500] }"
        >
            <el-table-column type="selection" width="55">
            </el-table-column>
            <el-table-column
                label="Ключ"
                min-width="170px"
                prop="keyword"
                sortable
            >
            </el-table-column>
            <el-table-column
                min-width="140px"
                label="Ссылка"
                prop="targeturl"
                sortable
            >
            </el-table-column>

            <el-table-column
                min-width="160px"
                label="Параметры"
                prop="getparameters"
            >
            </el-table-column>
            <el-table-column
                label="Частота"
                min-width="125px"
                prop="frequency"
                sortable
            >
                <template slot-scope="scope">
                    {{scope.row.frequency.toLocaleString("ru-RU")}}
                </template>
            </el-table-column>
            <el-table-column
                label="Коэффициент"
                min-width="140px"

                prop="coefficient"
                sortable
            >
            </el-table-column>

            <el-table-column
                min-width="180px"
                label="ДОЗа"
                prop="frequency_of_cheating"
                sortable
            >

                <template slot-scope="scope">
                    {{formatNumber(scope.row.frequency_of_cheating)}}
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
                width="160px"

            >

                <template slot-scope="scope">
                    <el-tooltip class="item" effect="dark"
                                content="Остановить/Запустить ключ"
                                placement="bottom">
                        <el-button
                            :icon="stopOrPauseIcon(scope.row.active)" circle
                            :type="scope.row.active ? 'info' : 'success'"
                            @click="handleKeyStatus(scope.row)"></el-button>
                    </el-tooltip>

                    <el-tooltip class="item" effect="dark"
                                content="Редактировать ключ"
                                placement="bottom">
                        <el-button
                            icon="el-icon-edit" circle
                            type="primary"
                            @click="handleEdit(scope.row.id)"></el-button>
                    </el-tooltip>
                    <el-tooltip class="item" effect="dark"
                                content="Удалить ключ"
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
            width="80%"
            :title="modalTitle"
        >
            <create
                @close="closeModal"
                v-if="modalVisible && modalStatus === 'create'"></create>
            <mass-create
                @close="closeModal"
                v-if="modalVisible && modalStatus === 'mass-create'"></mass-create>
            <mass-edit
                :selected-items-ids="selectedItemsIds"
                :status="modalStatus"
                @close="closeModal"
                v-if="modalVisible && (modalStatus === 'mass-edit' || modalStatus ===  'mass-edit-selection')"
            >
            </mass-edit>
            <edit
                :id="id"
                @close="closeModal"
                v-if="modalVisible && modalStatus === 'edit'"></edit>
        </el-dialog>
    </section>
</template>
<script>
import {activeIconMixin} from '@/admin/js/mixins/activeIconMixin'
import Import from "./components/import.vue";
import edit from "./edit.vue";
import create from "./create.vue";
import MassCreate from "./MassCreate.vue";
import MassEdit from "./MassEdit.vue";
import {touchScroll} from '@/admin/js/directive/el-table/tableScroll';

export default {
    mixins: [activeIconMixin],
    components: {create, edit, MassCreate, Import, MassEdit},
    props: {
        project_id: [String, Object]
    },
    data() {
        return {
            selectedItemsIds: [],
            id: null,
            modalStatus: '',
            modalVisible:false,
            project_keys: [],
            filters: [
                {
                    prop: ['key'],
                    value: ""
                }
            ],
        }
    },
    computed: {
        modalTitle:function () {
            if(this.modalStatus === 'create') {
                return 'Новая задача';
            }
            if(this.modalStatus === 'edit') {
                return 'Редактировать задачу';
            }
        },
    },
    methods: {
        handleKeyStatus(item) {
            axios.post('/api/admin/handle-status', {id: item.id, status: !item.active, type:'key'})
                .then((response) => {
                    let index = this.project_keys.findIndex(task => task.id === item.id);
                    this.project_keys[index].active = response.data;
                    this.$message({
                        message: 'Статус задачи изменен',
                        type: 'success'
                    });
                })
                .catch((error) => {

                })
        },
        getProjectKeys() {
            axios.get('/api/admin/project-keys', {params: {'project_id': this.project_id}})
                .then((response) => {
                    this.project_keys = response.data;
                })
                .catch((error) => {
                    if (error.message === 'Request failed with status code 403') {
                        this.$router.push('/404');
                    }
                })
        },
        modalOpen(status) {
            if(status === 'mass-edit-selection' && this.selectedItemsIds.length === 0) {
                this.$message({
                    message: 'Выберите ключи для редактирования',
                    type: 'error'
                });
                return;
            }
            this.modalStatus = status;
            this.modalVisible= true;

        },
        handleSelection(selectedItems) {
            this.selectedItemsIds = [];
            this.selectedItemsIds = selectedItems.map(item => item.id);
        },
        closeModal(data) {
            this.modalVisible= false;
            this.id = null;
            this.getProjectKeys();
        },
        handleEdit(id) {
            this.id = id;
            this.modalStatus = 'edit';
            this.modalVisible = true;
        },
        formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ');
        },
        handleMassDelete(type){
            if(type === 'mass-delete-selection' && this.selectedItemsIds.length === 0) {
                this.$message({
                    message: 'Выберите ключи для удаления',
                    type: 'error'
                });
                return;
            }
            this.$confirm('Вы уверены что хотите удалить ключи', 'Удаление ключей',{
                confirmButtonText: 'Удалить',
                cancelButtonText: 'Отмена',
                type: 'warning'
            }).then(() => {
                let formData = {};
                formData.project_id = this.project_id;
                if (type === 'mass-delete-selection') {
                    formData.selectedItemIds = [];
                    formData.selectedItemIds = this.selectedItemsIds;
                }
                axios.post('/api/admin/project-key/mass-delete', formData)
                    .then((response) => {
                        this.$message({
                            type: 'success',
                            message: 'Ключи удалены'
                        });
                        if(type === 'mass-delete-selection') {
                            this.selectedItemsIds.forEach((id) => {
                                let index = this.project_keys.findIndex(item => item.id === id);
                                this.project_keys.splice(index, 1);
                            })
                        } else {
                            this.project_keys = [];
                        }
                    })
                    .catch((error) => {

                    })
            })
        },
        handleDelete(item) {
            this.$confirm('Вы уверены что хотите удалить ключ', 'Удаление ключа', {
                confirmButtonText: 'Удалить',
                cancelButtonText: 'Отмена',
                type: 'warning'
            }).then(() => {
                axios.delete('/api/admin/project-keys/' + item.id)
                    .then((response) => {
                        let index = this.project_keys.findIndex(item => item.id === response.data.id);
                        this.project_keys.splice(index, 1);
                        this.$message({
                            type: 'success',
                            message: 'Ключ удален'
                        });
                    });

            }).catch(() => {

            });
        },


    },
    mounted() {
        touchScroll('.el-table__body-wrapper');
        this.getProjectKeys();
    }
}
</script>
