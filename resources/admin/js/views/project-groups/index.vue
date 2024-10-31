<template>
    <section class="page">
        <input type="hidden" id="task_url" :value="taskUrl">
        <h1 class="page-title">Группы проектов</h1>
        <div class="page-heading d-flex align-items-center justify-content-between mb-3" style="gap:20px;">
            <el-input
                v-model="search"
                size="large"

                placeholder="Поиск: Название"/>
            <el-button type="success" icon="el-icon-plus" @click="modalOpen('create')">Добавить группу проектов</el-button>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3" v-for="item in filteredList">
                <el-card class="box-card">
                    <div slot="header" class="d-flex justify-content-between align-items-center" style="gap: 15px;">
                        <span>{{item.name}}</span>
                        <el-tooltip class="item" effect="dark" placement="bottom">
                            <div slot="content">Открыть список проектов группы</div>
                            <router-link :to="'/project-groups/' + item.id">
                            <el-button
                                size="mini"
                                type="primary">
                                Перейти
                            </el-button>
                            </router-link>
                        </el-tooltip>


                    </div>
                    <ul class="inf-item-list">
                        <li class="inf-item-list__item">
                            <label class="inf-item-list__label">
                                Проектов
                            </label>
                            <div class="inf-item-list__values">
                                <!--<span>
                                    {{item.count_projects}}
                                </span>-->
                                <span style="color:green;">
                                    {{item.active_projects}}
                                </span>
                                <span style="color:darkred;">
                                    {{item.stopped_projects}}
                                </span>
                            </div>
                        </li>
                        <li class="inf-item-list__item">
                            <label class="inf-item-list__label">
                                Ключей
                            </label>
                            <div class="inf-item-list__values">
                                <!--<span>
                                    {{item.count_keys}}
                                </span>-->
                                <span style="color:green;">
                                     {{item.active_keys}}
                                </span>
                                <span style="color:darkred;">
                                     {{item.stopped_keys}}
                                </span>
                            </div>
                        </li>
                        <li class="inf-item-list__item">
                            <el-tooltip class="item" effect="dark" placement="right-start">
                                <div slot="content">Суммарная частота — это частота всех ключей за месяц</div>
                                <label class="inf-item-list__label">
                                    Σ Частота <i class="el-icon-question"></i>
                                </label>
                            </el-tooltip>
                            <div class="inf-item-list__values">
                                <!--<span>
                                    {{item.count_frequency}}
                                </span>-->
                                <span style="color:green;">
                                     {{item.active_frequency}}
                                </span>
                                <span style="color:darkred;">
                                         {{item.stopped_frequency}}
                                </span>
                            </div>
                        </li>
                        <li class="inf-item-list__item inf-item-list__item--progress-bar">
                            <el-tooltip class="item" effect="dark" placement="right-start">
                                <div slot="content">Дневной объем заданий<br>
                                    Считается как сумма значения 'ДОЗа' по всем активным ключам<br>
                                    Где 'ДОЗа' - дневной объём заданий по каждому ключу<br>
                                    'Частота' - статистика по ключу за месяц, например, из Вордстат<br>
                                    'Коэффициент' - CTR ключа в % / 100<br>
									'ДОЗа' = 'Частота' * 'Коэффициент' / 30<br>
                                </div>
                                <label class="inf-item-list__label">
                                    Заданий <i class="el-icon-question"></i>
                                </label>
                            </el-tooltip>
                            <div class="inf-item-list__values align-items-center">
                                <span>
                                      {{Math.round(item.projects_sum_daily_volume_of_keys)}}
                                </span>
                            </div>

                        </li>
                        <li class="inf-item-list__item inf-item-list__item--progress-bar">
                            <el-tooltip class="item" effect="dark" placement="right-start">
                                <div slot="content">Софт получил от API задание с запросом</div>
                                <label class="inf-item-list__label">
                                received <i class="el-icon-question"></i>
                                </label>
                            </el-tooltip>
                            <div class="inf-item-list__progress-bar">
                                <el-progress
                                    :stroke-width="15"
                                    :color="'#409eff'"
                                    :percentage="getPercentage(item.projects_sum_daily_volume_of_keys, item.statistics_sum_received)" ></el-progress>
                            </div>
                        </li>
                        <li class="inf-item-list__item inf-item-list__item--progress-bar">
                            <el-tooltip class="item" effect="dark" placement="right-start">
                                <div slot="content">Запрос ввели в строку поиска ПС<br>или открыли ПС с параметром text=...</div>
                                <label class="inf-item-list__label">
                                    entered <i class="el-icon-question"></i>
                                </label>
                            </el-tooltip>
                            <div class="inf-item-list__progress-bar">
                                <el-progress
                                    :stroke-width="15"
                                    :color="'#409eff'"
                                    :percentage="getPercentage(item.projects_sum_daily_volume_of_keys, item.statistics_sum_entered)" ></el-progress>
                            </div>
                        </li>
                        <li class="inf-item-list__item inf-item-list__item--progress-bar">
                            <el-tooltip class="item" effect="dark" placement="right-start">
                                <div slot="content">По запросу нашли целевой сайт</div>
                                <label class="inf-item-list__label">
                                    found <i class="el-icon-question"></i>
                                </label>
                            </el-tooltip>
                            <div class="inf-item-list__progress-bar">
                                <el-progress
                                    :stroke-width="15"
                                    :color = tasksColors
                                    :percentage="getPercentage(item.projects_sum_daily_volume_of_keys, item.statistics_sum_found)" ></el-progress>
                            </div>
                        </li>
                        <li class="inf-item-list__item inf-item-list__item--progress-bar">
                            <el-tooltip class="item" effect="dark" placement="right-start">
                                <div slot="content">Сделали переход из ПС на целевой сайт</div>
                                <label class="inf-item-list__label">
                                    visited <i class="el-icon-question"></i>
                                </label>
                            </el-tooltip>
                            <div class="inf-item-list__progress-bar">
                                <el-progress
                                    :stroke-width="15"
                                    :color = tasksColors
                                    :percentage="getPercentage(item.projects_sum_daily_volume_of_keys, item.statistics_sum_visited)" ></el-progress>
                            </div>
                        </li>
                        <li class="inf-item-list__item inf-item-list__item--progress-bar">
                            <el-tooltip class="item" effect="dark" placement="right-start">
                                <div slot="content">По запросу не нашли целевой сайт<br>с указанной в настройках глубиной</div>
                                <label class="inf-item-list__label">
                                    notfound <i class="el-icon-question"></i>
                                </label>
                            </el-tooltip>
                            <div class="inf-item-list__progress-bar">
                                <el-progress
                                    :stroke-width="15"
                                    :color="notFoundTasksColors"
                                    :percentage="getPercentage(item.projects_sum_daily_volume_of_keys, item.statistics_sum_notfound)" ></el-progress>
                            </div>
                        </li>

                    </ul>

                    <div v-if="item.comment">
                        <label class="project-group-card__label">
                            Комментарий
                        </label>
                        <div class="project-group-card__comment">
                            {{item.comment}}
                        </div>
                    </div>
                    <div class="project-group-card__actions">
                        <el-tooltip class="item" effect="dark"
                                    content="Копировать API url группы проектов"
                                    placement="bottom">
                            <el-button type="info" icon="el-icon-copy-document"
                                @click.prevent="copyTaskUrlFromProjectGroup(item)"
                            ></el-button>
                        </el-tooltip>

                        <el-tooltip class="item" effect="dark"
                                    content="Остановить все проекты в группе"
                                    placement="bottom">
                            <el-button type="warning" icon="el-icon-video-pause"
                                       @click.prevent="handlePlayOrStop(item.id, false)">
                            </el-button>
                        </el-tooltip>

                        <el-tooltip class="item" effect="dark"
                                    content="Запустить все проекты в группе"
                                    placement="bottom">
                            <el-button type="success"
                                       icon="el-icon-video-play"
                                       @click.prevent="handlePlayOrStop(item.id, true)">
                            </el-button>
                        </el-tooltip>
                        <el-tooltip class="item" effect="dark"
                                    content="Редактировать группу проектов"
                                    placement="bottom">
                            <el-button type="primary"
                                       icon="el-icon-edit"
                                       @click.prevent="handleEdit(item.id)"></el-button>
                        </el-tooltip>

                        <el-tooltip class="item" effect="dark"
                                    content="Удалить группу проектов"
                                    placement="bottom">
                            <el-button type="danger"
                                       icon="el-icon-delete"
                                       @click.prevent="handleDelete(item)"></el-button>
                        </el-tooltip>
                    </div>
                </el-card>
            </div>
        </div>
        <el-dialog
            :visible.sync="modalVisible"
            width="60%"
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
import { mapGetters } from 'vuex';
import create from './create';
import edit from './edit';
    export default {
        components:{
            create, edit
        },
        data() {
            return {
                taskUrl: "",
                id: null,
                modalStatus: '',
                modalVisible:false,
                search: '',
                project_groups:[],
                tasksColors: [
                    {
                        color: '#9b2d30',
                        percentage: 20
                    },
                    {
                        color: '#f56c6c',
                        percentage: 40
                    },
                    {
                        color: '#e6a23c',
                        percentage:60
                    },
                    {
                        color: '#409eff',
                        percentage: 80
                    },
                    {
                        color: '#67c23a',
                        percentage: 100
                    },
                ],
                notFoundTasksColors: [
                    {
                        color: '#67c23a',
                        percentage: 20
                    },
                    {
                        color: '#409eff',
                        percentage: 40
                    },
                    {
                        color: '#e6a23c',
                        percentage: 60
                    },
                    {
                        color: '#f56c6c',
                        percentage: 80
                    },
                    {
                        color: '#9b2d30',
                        percentage: 100
                    },
                ]
            }
        },
        computed: {
            filteredList() {
                return this.project_groups.filter(item => {
                    return item.name.toLowerCase().includes(this.search.toLowerCase())
                })
            },
            modalTitle:function () {
                if(this.modalStatus === 'create') {
                    return 'Новая группа проектов';
                }
                if(this.modalStatus === 'edit') {
                    return 'Редактировать группу проктов';
                }
            },
            ...mapGetters([
                'userId',
            ]),
        },
        methods:{
            getPercentage(daily_volume_of_keys, tasks ) {
                return daily_volume_of_keys ?  Math.round(tasks / daily_volume_of_keys * 100) : 0;
            },
            tasksProgressBarColor(percentage) {

            },
            getProjectGroups() {
                axios.get('/api/admin/project-groups', {params:{'user_id': this.userId}})
                    .then((response) => {
                        this.project_groups = response.data;
                    })
            },
            modalOpen(status) {
                this.modalStatus = status;
                this.modalVisible= true;

            },
            closeModal(data) {
                this.modalVisible= false;
                this.id = null;
                this.getProjectGroups();
            },
            handleEdit(id) {
                this.id = id;
                this.modalStatus = 'edit';
                this.modalVisible = true;
            },
            handlePlayOrStop(id, action) {
               let msg =action ? 'Проекты в группе активированы' :  'Проекты в группе остановлены' ;

                axios.post('/api/admin/handle-batch-status', {
                    parent_id: id,
                    status:action,
                    type: 'project'
                })
                    .then((response) => {
                        this.getProjectGroups();
                        this.$message({
                            type: 'success',
                            message: msg,
                        })
                        })

            },
            handleDelete(item) {
                this.$confirm('Вы уверены что хотите удалить  Группу проектов', 'Удаление группы проектов', {
                    confirmButtonText: 'Удалить',
                    cancelButtonText: 'Отмена',
                    type: 'warning'
                }).then(() => {
                    axios.delete('/api/admin/project-groups/' + item.id)
                        .then((response) => {
                            let index = this.project_groups.findIndex(item => item.id === response.data.id);
                            this.project_groups.splice(index, 1);
                            this.$message({
                                type: 'success',
                                message: 'Группа проектов удалена'
                            });
                        });

                }).catch(() => {

                });
            },
            copyTaskUrlFromProjectGroup(item) {
                if (item.api_key) {
                    this.copyTaskUrl(item.api_key);
                } else {
                    axios.post('/api/admin/project-groups-generate-api-key/' + item.id)
                        .then((response) => {
                            this.copyTaskUrl(response.data);
                            console.log(response.data)
                        })
                }
            },
            copyTaskUrl(api_key) {
                const url = window.location.protocol + '//' + window.location.host + '/api/gettaskfromprojectgroup/' + api_key + '?';
                let taskUrlInput = document.querySelector('#task_url');
                taskUrlInput.setAttribute('type', 'text');
                taskUrlInput.setAttribute('value', url);
                taskUrlInput.select()

                try {
                    var successful = document.execCommand('copy');
                    var msg = successful ? 'successful' : 'unsuccessful';
                    this.$message({
                        type: 'success',
                        message: 'Ссылка для выдачи задания скопирована'
                    });
                } catch (err) {

                }

                /* unselect the range */
                taskUrlInput.setAttribute('type', 'hidden')
                window.getSelection().removeAllRanges()
            }
        },
        mounted() {
            this.getProjectGroups();

        }
    }
</script>
