<template>
    <section>
        <h1 class="page-title">Статистика</h1>

        <div class="page-heading row align-items-end  mb-3" >
            <div class="form-group col-lg-3" v-if="project_id === 0">
                <label class="form-label">Проект:</label>
                <el-select
                    style="width: 100%"
                    filterable
                    v-model="filters.project_id" placeholder="Выбрать проект"
                    @change="getStatistic">

                    <el-option-group
                        v-for="group in projects"
                        :key="group.id"
                        :label="'Название группы / ' + group.name">
                        <el-option
                            v-for="item in group.projects"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                        </el-option>
                    </el-option-group>
                </el-select>
            </div>
            <div class="form-group col-lg-2">
                <label class="form-label">Девайс:</label>
                <el-select
                    style="width: 100%"
                    v-model="filters.device_id" placeholder="Выбрать девайс"
                    @change="getStatistic">
                    <el-option
                        v-for="item in devices"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                    </el-option>
                </el-select>
            </div>
            <div class="form-group col-lg-2">
                <label class="form-label">Сортировка запросов:</label>
                <el-select
                    style="width: 100%"
                    v-model="filters.order_by" placeholder="Сортировка запросов"
                    @change="getStatistic">
                    <el-option
                        v-for="item in sorts"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                    </el-option>
                </el-select>
            </div>
            <div class="form-group col-lg-4 statistic-calendar">
                <label class="form-label">Выбрать период</label>
                <el-date-picker
                    style="min-width: 400px; width: 100%"
                    v-model="filters.date_range"
                    :picker-options="pickerOptions"
                    value-format="yyyy-MM-dd"
                    type="daterange"
                    @change="getStatistic"
                    start-placeholder="Дата начала"
                    end-placeholder="Дата окончания">
                </el-date-picker>
            </div>
            <div class="form-group col-lg-3">
                <el-dropdown >
                    <el-button icon="el-icon-film" type="default" style="width: 100%">
                        Настройки вида <i class="el-icon-arrow-down el-icon--right"></i>
                    </el-button>
                    <el-dropdown-menu slot="dropdown" style="width: 260px; padding: 20px">
                        <label class="statistic-view-settings__label">Цветовая схема</label>
                        <el-radio-group v-model="colorScheme">
                            <el-radio style="width: 100%; margin-bottom: 10px" :label="'top-progress'">Топ, прогресс</el-radio>
                            <el-radio style="width: 100%; " :label="'up-down'">Рост / Падение</el-radio>
                        </el-radio-group>
                        <label class="statistic-view-settings__label">Показывать доп. информацию</label>
                        <div style="margin-bottom: 7px" v-for="(value,key) in additionalFields">
                            <el-checkbox v-model="additionalFields[key]" :label="additionalFieldsCheckboxLabels[key]" ></el-checkbox>
                        </div>

                    </el-dropdown-menu>
                </el-dropdown>
            </div>
        </div>
        <div class="table-responsive">
        <table class="statistic-table table table-bordered">
            <thead>
            <tr class="statistic-table__first-row">
                <th class="statistic-table__first-col statistic-table__sticky-col">
                    Запросы
                </th>
                <th class="statistic-table__second-col statistic-table__sticky-col">
                    Частота
                </th>
                <th class="statistic-table__third-col statistic-table__sticky-col">
                    ДОЗа
                </th>
                <th v-for="(date, index) in dates">
                    {{date}}
                </th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="(item, index) in statistic"
                :key="index"
            >
                <td class="statistic-table__first-col statistic-table__sticky-col">
                    {{item.keyword}}
                </td>
                <td class="statistic-table__second-col statistic-table__sticky-col">
                    {{item.frequency}}
                </td>
                <td class="statistic-table__third-col statistic-table__sticky-col">
                    {{item.frequency_of_cheating}}
                </td>
                <template v-for="(date, index) in dates">
                    <statistic-row
                        :additional-fields-labels="additionalFieldsLabels"
                        :color-scheme="colorScheme"
                        :additional-fields-arr="additionalFieldsArr"
                        v-if="item.statistic[date]"
                        :item-data="item.statistic[date]"
                        @show-item="openStatisticItemModal"
                    ></statistic-row>
                    <td v-else class="statistic-data-row statistic-data-row--none">
                        <span class="statistic-data-row__position">--</span>
                    </td>
                </template>


            </tr>
            </tbody>

        </table>
        </div>
        <statistic-item
            :id="statisticItemId"
            v-if="statisticItemId"
            @close="statisticItemId = 0"
        ></statistic-item>
    </section>

</template>
<script>
    import StatisticRow from "./components/statistic-row.vue";
    import StatisticItem from "./components/statistic-item.vue";
    export default {
        components: {
            StatisticRow, StatisticItem
        },
        props: {
            project_id: {
                type: Number,
                default: 0,
            }
        },
        computed: {
            additionalFieldsArr() {
                let arr = [];
                for (let key in this.additionalFields) {
                    if(this.additionalFields[key]) {
                        arr.push(key)
                    }


                }
                return arr;
            }
        },
        data() {
            return {
                additionalFieldsCheckboxLabels: {
                    sum_cookies: 'Среднее значение cookies',
                    sum_uniquedomains:'Среднее значение uniquedomains',
                    sum_ymdomains:'Среднее значение ymdomains',
                    sum_gadomains:'Среднее значение gadomains',
                    received:'Запросы к API',
                    entered:'Введён',
                    found:'Показы',
                    visited:'Посещения',
                    notfound:'Не найден',

                },
                additionalFieldsLabels: {
                    sum_cookies: 'cookies',
                    sum_uniquedomains:'uniquedomains',
                    sum_ymdomains:'ymdomains',
                    sum_gadomains:'gadomains',
                    received:'Запросы к API',
                    entered:'Введён',
                    found:'Показы',
                    visited:'Посещения',
                    notfound:'Не найден',

                },
                additionalFields: {
                    sum_cookies: false,
                    sum_uniquedomains:false,
                    sum_ymdomains:false,
                    sum_gadomains:false,
                    received:false,
                    entered:false,
                    found:false,
                    visited:false,
                    notfound:false,
                },
                colorScheme: "top-progress",
                pickerOptions: {
                    shortcuts: [{
                        text: 'Сегодня',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: 'Вчера',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: '1 Неделя',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: '1 Месяц',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: 'Текущий месяц',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date(end.getFullYear(), end.getMonth(), 1);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: 'Прошлый месяц',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date(end.getFullYear(), end.getMonth() - 1, 1);
                            end.setMonth(end.getMonth() - 1);
                            end.setDate(0);
                            picker.$emit('pick', [start, end]);
                        }
                    }]
                },
                statisticItemId:0,
                dates: [],
                statistic: [],
                projects: [],

                devices: [
                    {
                        value: 0,
                        label: 'All',
                    },
                    {
                        value: 1,
                        label: 'Mobile',
                    },
                    {
                        value: 2,
                        label: 'Desktop',
                    }
                ],
                sorts: [
                    {
                        value: 'keyword|asc',
                        label: 'Запросы от А до Я',
                    },
                    {
                        value: 'keyword|desc',
                        label: 'Запросы от Я до A',
                    },
                    {
                        value: 'frequency|desc',
                        label: 'Частота по убыванию',
                    },
                    {
                        value: 'frequency|asc',
                        label: 'Частота по возрастанию',
                    },
                    {
                        value: 'frequency_of_cheating|desc',
                        label: 'ДОЗа по убыванию',
                    },
                    {
                        value: 'frequency_of_cheating|asc',
                        label: 'ДОЗа по возрастанию',
                    },
                    {
                        value: null,
                        label: 'По умолчанию',
                    },
                ],
                filters: {
                    project_id:null,
                    device_id: 0,
                    date_range: [],
                    order_by: null
                },
            }
        },
         methods: {
            openStatisticItemModal(id) {
                console.log(id);
                this.statisticItemId = id;
            },
             getFilterOptions() {
                 axios.get('/api/admin/project-key-task/filter-options')
                     .then((response) => {
                         this.projects = response.data.projects;
                     })
             },
             getStatistic() {
                 axios.get('/api/admin/project-key-statistics' ,{params: this.filters})
                     .then((response) => {
                         console.log(response.data);
                         this.statistic = response.data.project_keys_statistic;
                         this.dates = response.data.dates;
                     })
             }
         },
        mounted() {
            this.getFilterOptions();
            if(this.project_id !==0) {
                this.filters.project_id = this.project_id
                this.getStatistic()
            }

        }
    }
</script>
