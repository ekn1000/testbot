<template>
<section>
    <data-tables
        :data="testbots"
        style="width: 100%;"
        :pagination-props="{ pageSizes: [20, 50, 100] }"
    >
        <el-table-column width="130"
            label="ip сервера"
            prop="ip"
            sortable
        >
        </el-table-column>
        <!--
        <el-table-column
            label="Скрипт"
            prop="script"
            sortable
        >
        </el-table-column>
        -->
        <el-table-column width="130"
            label="Версия"
            prop="version"
            sortable
        >
            <template slot-scope="scope">
                {{scope.row.script + ' - ' + scope.row.version}}
            </template>
        </el-table-column>
        <el-table-column width="200"
            label="Лицензия"
            prop="user"
            sortable
        >
        </el-table-column>
        <el-table-column width="200"
            label="Проект"
            prop="projectname"
            sortable
            show-overflow-tooltip
        >
        </el-table-column>
        <el-table-column width="80"
            label="План."
        >
            <template slot-scope="scope">
                <i
                :class="scope.row.taskscheduler ? 'el-icon-date' : 'el-icon-close'"
                ></i>
            </template>
        </el-table-column>
        <!--
        <el-table-column
            label="Дата обновления"
            sortable
        >
            <template slot-scope="scope">
                {{formatDate(scope.row.updated_at)}}
            </template>
        </el-table-column>
        -->
        <el-table-column
            label="Потоков"
            prop="threads"
            sortable
        >
        </el-table-column>
        <!--
        <el-table-column
            label="Выполнять"
            prop="limits"
            sortable
        >
        </el-table-column>
        -->
        <el-table-column
            label="Успешно"
            prop="success"
            sortable
        >
        </el-table-column>
        <el-table-column
            label="Ошибок"
            prop="fail"
            sortable
        >
        </el-table-column>
        <el-table-column
            label="% успешных"
        >
            <template slot-scope="scope">
                {{(scope.row.success+scope.row.fail) > 0 ? Math.ceil(100*scope.row.success/(scope.row.success+scope.row.fail)) + ' %' : '-'}}
            </template>
        </el-table-column>
        <el-table-column width="145"
            label="Ср. время потока"
            prop="success_time"
            sortable
        >
            <template slot-scope="scope">
                {{scope.row.success_time + ' сек.'}}
            </template>
        </el-table-column>
        <!--
        <el-table-column
            label="Статус"
            prop="status"
            sortable
        >
        </el-table-column>
        -->
        <el-table-column label="Статус" width="150">
            <template #default="scope">
                <el-popover effect="light" trigger="hover" placement="top" width="auto">
                    <template #default>
                        <div>Дата запуска: {{ formatDate(scope.row.created_at) }}</div>
                        <div>Дата обновления: {{ formatDate(scope.row.updated_at) }}</div>
                    </template>
                    <template #reference>
                        <el-tag
                            :type="scope.row.status === 'works' ? 'success' : scope.row.status === 'starts' ? '' : 'danger'"
                            disable-transitions
                        >
                        <i class="el-icon-caret-right"></i>
                        <span style="margin-left: 8px">{{ scope.row.status === 'works' ? 'Работает' : scope.row.status === 'starts' ? 'Запускается' : 'Не работает' }}
                        </span>
                        </el-tag>
                    </template>
                </el-popover>
            </template>
        </el-table-column>
        <el-table-column>
            <template slot-scope="scope">
                <el-button
                    icon="el-icon-view"
                    size="mini"
                    type="primary"
                    @click="handlePreview(scope.$index, scope.row.id)">Подробнее</el-button>
            </template>
        </el-table-column>
    </data-tables>
    <el-dialog
        :visible.sync="modalVisible"
        width="80%"
        :title="modalTitle"
    >
    <Detail
        :data="testbotItem"
    ></Detail>
    </el-dialog>
</section>
</template>
<script>
import Detail from "./detail.vue";
import dayjs from "dayjs";
require('dayjs/locale/ru');
    export default {
        components: {
            Detail,
        },
        data() {
            return {
                testbots: [],
                modalVisible:false,
                modalTitle: 'Копия testbot',
                testbotItem: {},
            }
        },
        methods: {
            handlePreview(index, id) {
                this.modalVisible =true;
                this.testbotItem = this.testbots[index]
            },
            gettestbotStatistic() {
                axios.get('/api/admin/i-bot-statistics')
                    .then((response) => {
                        this.testbots = response.data;
                    })
            },
            formatDate(date) {
                return dayjs(date).locale('ru').format('DD MMM YYYY HH:mm')
            }
        },
        mounted() {
            this.gettestbotStatistic();
        }
    }
</script>
