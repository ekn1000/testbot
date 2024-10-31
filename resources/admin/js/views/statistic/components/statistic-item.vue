<template>
    <el-dialog
         v-if="data"
        :title="'Ключ: ' + data.project_key.keyword  "
        :visible.sync="modalShow"
        :before-close="closeModal"
        width="40%">
        <div class="statistic-item">
            <label class="form-label statistic-item__label">
                Дата статистики:
            </label>
            <span class="statistic-item__value">
                {{data.date}}
            </span>
        </div>
        <div class="statistic-item">
            <label class="form-label statistic-item__label">
                ДОЗа :
            </label>
            <span class="statistic-item__value">
                {{data.frequency_of_cheating}}
            </span>
        </div>
        <div class="statistic-item">
            <label class="form-label statistic-item__label">
                Девайс:
            </label>
            <span class="statistic-item__value">
                {{data.device}}
            </span>
        </div>
        <div class="statistic-item">
            <label class="form-label statistic-item__label">
                Средняя позиция:
            </label>
            <span class="statistic-item__value" v-if="data.found > 0">
                {{Math.round(data.sum_position / data.found)}}
            </span>
        </div>
        <div class="statistic-item">
            <label class="form-label statistic-item__label">
                Средняя позиция за прошлый день:
            </label>
            <span class="statistic-item__value" v-if="data.has_yesterday">
                {{Math.round(data.avg_position_last)}}
            </span>
        </div>
        <div class="statistic-item">
            <label class="form-label statistic-item__label">
                Среднее значение cookies:
            </label>
            <span class="statistic-item__value" v-if="data.found > 0">
                {{Math.round(data.sum_cookies / data.found)}}
            </span>
        </div>
        <div class="statistic-item">
            <label class="form-label statistic-item__label">
                Среднее значение uniquedomains:
            </label>
            <span class="statistic-item__value" v-if="data.found > 0">
                {{Math.round(data.sum_uniquedomains / data.found)}}
            </span>
        </div>
        <div class="statistic-item">
            <label class="form-label statistic-item__label">
                Среднее значение ymdomains:
            </label>
            <span class="statistic-item__value" v-if="data.found > 0">
                {{Math.round(data.sum_ymdomains / data.found)}}
            </span>
        </div>
        <div class="statistic-item">
            <label class="form-label statistic-item__label">
                Среднее значение gadomains:
            </label>
            <span class="statistic-item__value" v-if="data.found > 0">
                {{Math.round(data.sum_gadomains / data.found)}}
            </span>
        </div>
        <div class="statistic-item">
            <label class="form-label statistic-item__label">
                Запросы к API:
            </label>
            <span class="statistic-item__value">
                {{data.received}}
            </span>
        </div>
        <div class="statistic-item">
            <label class="form-label statistic-item__label">
                Введён:
            </label>
            <span class="statistic-item__value">
                {{data.entered}}
            </span>
        </div>
        <div class="statistic-item">
            <label class="form-label statistic-item__label">
                Показы:
            </label>
            <span class="statistic-item__value">
                {{data.found}}
            </span>
        </div>
        <div class="statistic-item">
            <label class="form-label statistic-item__label">
                Посещения:
            </label>
            <span class="statistic-item__value">
                {{data.visited}}
            </span>
        </div>
        <div class="statistic-item">
            <label class="form-label statistic-item__label">
                Не найден:
            </label>
            <span class="statistic-item__value">
                {{data.notfound}}
            </span>
        </div>
        <div class="text-center">
            <el-button @click="closeModal">Закрыть</el-button>
        </div>
    </el-dialog>
</template>
<script>
    export default {
        props: {
            id: {
                type: Number
            }
        },
        data() {
            return {
                modalShow:false,
                data:null
            }
        },
        methods: {
            closeModal() {
              this.$emit('close');
            },
            getStatistic() {
                axios.get('/api/admin/project-key-statistics/' + this.id)
                    .then((response) => {
                        this.data = response.data;
                        this.modalShow = true;
                    })
            }
        },
        mounted() {
            this.getStatistic();
        }
    }
</script>
