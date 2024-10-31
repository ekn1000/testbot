<template>
    <section>
        <el-form
            class="disabled-form"
            :model="data" label-position="top" :disabled="true">
            <div class="row">
                <el-form-item class="col-md-4" label="Скрипт" >
                    <el-input v-model="data.script"></el-input>
                </el-form-item>
                <el-form-item class="col-md-4" label="Версия скрипта">
                    <el-input v-model="data.version">
                    </el-input>
                </el-form-item>
                <el-form-item class="col-md-4" label="Лицензия">
                    <el-input v-model="data.user">
                    </el-input>
                </el-form-item>
            </div>
            <el-form-item  label="Название проекта" >
                <el-input v-model="data.projectname"></el-input>
            </el-form-item>
            <div class="row">
                <el-form-item class="col-md-4" label="ip сервера">
                    <el-input v-model="data.ip">
                    </el-input>
                </el-form-item>
                <el-form-item class="col-md-4" label="OC" >
                    <el-input v-model="data.os_name"></el-input>
                </el-form-item>

                <el-form-item class="col-md-4" label="Статус работы копии">
                    <el-input
                        :value="data.status == 'works' ? 'Работает' : data.status == 'starts' ? 'Запускается' : 'Не работает'"
                    >
                    </el-input>
                </el-form-item>
            </div>
            <div class="row">
                <el-form-item  class="col-md-3" label="Количество потоков">
                    <el-input v-model="data.threads">
                    </el-input>
                </el-form-item>
                <el-form-item  class="col-md-2" label="Количество выполнений">
                    <el-input
                        :value="data.limits == '-1' ? 'Бесконечно' : data.limits"
                    >
                    </el-input>
                </el-form-item>
                <el-form-item  class="col-md-2" label="Успешных выполнений">
                    <el-input v-model="data.success">
                    </el-input>
                </el-form-item>
                <el-form-item  class="col-md-2" label="Ошибок">
                    <el-input v-model="data.fail">
                    </el-input>
                </el-form-item>
                <el-form-item  class="col-md-3" label="Среднее время выполнения одного потока">
                    <el-input v-model="data.success_time">
                        <template slot="append">сек.</template>
                    </el-input>
                </el-form-item>
            </div>
            <el-form-item   label="Алгоритм работы (Конструктор поведения)">
                <el-input type="textarea"
                    :rows="data.selectalgo.split(',').length"
                    :value="data.selectalgo.replace(/\,/g, '\r\n')"
                >
                </el-input>
            </el-form-item>
            <div class="row">
                <el-form-item  class="col-md-3" label="Дата запуска">
                    <el-input :value="formatDate(data.created_at)">
                    </el-input>
                </el-form-item>
                <el-form-item  class="col-md-3" label="Дата обновления">
                    <el-input :value="formatDate(data.updated_at)">
                    </el-input>
                </el-form-item>
                <el-form-item  class="col-md-3" label="Время работы">
                    <el-input :value="timeDuration">
                    </el-input>
                </el-form-item>
            </div>
            <section v-if="report.captcha">
                <h4>Капчи</h4>
                <div v-for="(item, key) in report.captcha">
                    <div class="row">
                        <el-form-item  class="col-md-3" label="Капча">
                            <el-input :value="key">
                            </el-input>
                        </el-form-item>
                        <el-form-item  class="col-md-3" label="Показано" v-if="item.show">
                            <el-input :value="item.show">
                            </el-input>
                        </el-form-item>
                        <el-form-item  class="col-md-3" label="Решено" v-if="item.solved">
                            <el-input :value="item.solved">
                            </el-input>
                        </el-form-item>
                        <el-form-item  class="col-md-3" label="Попыток" v-if="item.attempt">
                            <el-input :value="item.attempt">
                            </el-input>
                        </el-form-item>
                    </div>
                </div>
            </section>
        </el-form>

    </section>
</template>
<script>
import dayjs from "dayjs";
import duration from 'dayjs/plugin/duration';
dayjs.extend(duration);
require('dayjs/plugin/duration')
    export default {
        computed: {
            timeDuration: function () {
                let start = dayjs(this.data.created_at);
                let end = dayjs(this.data.updated_at);
                let duration = dayjs.duration(end.diff(start))
                return duration.locale('ru').format('DD д. HH ч. mm мин.');
            },
        },
        props: {
            data: {
                type:Object
            }
        },
        data() {
            return {
                report: {},
            }
        },
        methods: {
            formatDate(date) {
                return dayjs(date).locale('ru').format('DD MMM YYYY HH:mm')
            },
            formatReport() {
                this.report = JSON.parse(this.data.report);
            }

        },
        mounted() {
            this.formatReport();
        }
    }
</script>
