<template>

            <el-form :model="form" ref="form" label-position="top">
                <el-form-item prop="group_id" label="Группа проектов" :error="errors.get('group_id')">
                    <el-select v-model="form.group_id" placeholder="Выберите группу проектов" style="width: 100%">
                        <el-option
                            v-for="item in groups"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                        >
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item prop="name" label="Название проекта" :error="errors.get('name')">
                    <el-input v-model="form.name" placeholder="Название группы проектов"></el-input>
                </el-form-item>
                <el-form-item prop="targeturl" label="Домен" :error="errors.get('targeturl')">
                    <el-input v-model="form.targeturl" placeholder="Домен"></el-input>
                </el-form-item>
                <div class="row">

                    <el-form-item class="col-md-6"
                                  prop="getparameters"
                                  label="Параметры"
                                  :error="errors.get('getparameters')">
                        <el-input
                            type="textarea"
                            placeholder="Введите параметры"
                            v-model="form.getparameters"
                            maxlength="128"
                            show-word-limit
                        >
                        </el-input>
                    </el-form-item>


                </div>
                <div class="row align-items-end" >
                    <!--
                    <el-form-item class="col-md-3"
                                  prop="percentage_of_repeat_visits"
                                  label="% повторных заходов (0-100%)"
                                  :error="errors.get('percentage_of_repeat_visits')">
                    <el-input-number v-model="form.percentage_of_repeat_visits"
                                    disabled: true
                                     style="width: 100%"
                                     :step="1"
                                     :min="0"
                                     :max="100"></el-input-number>
                    </el-form-item>
                    -->
                    <el-form-item class="col-md-3"  prop="active" label="Статус">
                        <el-switch v-model="form.active">
                        </el-switch>
                        <template v-if="form.active">
                            Активен
                        </template>
                        <template v-else>
                            Остановлен
                        </template>
                    </el-form-item>
                    <div class="col-md-3" style="margin-bottom: 22px;" v-if="form.id">
                        <el-button type="info" icon="el-icon-copy-document"
                            @click.prevent="copyTaskUrl(form)"
                        >Копировать URL</el-button>
                    </div>
                </div>
                <div class="text-center">
                    <el-button type="success" @click.prevent="save">Сохранить</el-button>
                    <el-button  @click.prevent="closeModal">Отменить</el-button>
                </div>
            </el-form>

</template>
<script>
import { Errors } from  '@/common/js/services/errors.js';
import { mapGetters } from 'vuex';

import {copyProjectApiUrlMixin} from "@/admin/js/mixins/copyProjectApiUrlMixin";
export default {
    props:{
        saveMsg: {
            default: 'Проект добавлен'
        },
        form: {
            type:Object
        },
        formAction: {
            type:Object
        }
    },
    mixins: [copyProjectApiUrlMixin],
    computed: {

        ...mapGetters([
            'userId',
        ]),
    },
    data() {
        return {
            groups:[],
            errors: new Errors(),
        }
    },
    methods: {

        closeModal(data) {
            this.$emit('close', data);
        },
        save() {
            axios({
                method: this.formAction.method ,
                url: this.formAction.url,
                data: this.form
            }).then((response) => {
                this.$message({
                    message: this.saveMsg,
                    type: 'success'
                });
                this.closeModal();
            })
                .catch((error) => {
                    this.errors.record(error.response.data.errors);
                });

        },
        getProjectGroupsOptionList(user_id) {
            axios.get('/api/admin/project-groups-options', {params: {user_id:user_id}})
                .then((response) => {
                    this.groups = response.data;
                    this.form.group_id = parseInt(this.$route.params.id);
                })
                .catch((error) => {

                })
        },
    },
    mounted() {
        this.getProjectGroupsOptionList(this.userId);
    }
}
</script>
