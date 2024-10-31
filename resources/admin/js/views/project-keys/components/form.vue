<template>
        <el-form :model="form" ref="form" label-position="top">
            <el-form-item prop="project_id" label="Проект" :error="errors.get('project_id')" v-if="!massEdit">
                <el-select v-model="form.project_id" placeholder="Выберите проект" style="width: 100%">
                    <el-option
                        v-for="item in projects"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value"
                    >
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item prop="targeturl" label="URL" :error="errors.get('targeturl')">
                <el-input v-model="form.targeturl" placeholder="URL"></el-input>
            </el-form-item>
            <el-form-item label="Ключи" v-if="massCreate" :error="errors.get('keywords')">
                <el-input
                    rows="8"
                    placeholder="Введите запросы -  каждый с новой строки"
                    type="textarea"
                    v-model="form.keywords"></el-input>
            </el-form-item>
            <el-form-item prop="keyword" label="Ключ" :error="errors.get('keyword')" v-if="!massCreate && !massEdit">
                <el-input
                    type="textarea"
                    v-model="form.keyword"
                    maxlength="256"
                    show-word-limit
                    placeholder="Ключ"></el-input>
            </el-form-item>


            <div class="row" v-if="!massCreate && !massEdit ">
            <!--
            <el-form-item class="col-md-3"
                          prop="position_up"
                          label="Позиция до (0 - 100)"
                          :error="errors.get('position_up')">
                <el-input-number v-model="form.position_up"
                                 style="width: 100%"
                                :step="1"
                                 :min="0"
                                 :max="100"></el-input-number>
            </el-form-item>
            <el-form-item class="col-md-3"
                          prop="target_position"
                          label="Позиция целевая (0 - 100)"
                          :error="errors.get('target_position')">
                <el-input-number v-model="form.target_position"
                                 style="width: 100%"
                                 :step="1"
                                 :min="0"
                                 :max="100"></el-input-number>
            </el-form-item>
            -->
            </div>
            <div class="row">
                <el-form-item class="col-md-3"
                              prop="frequency"
                              label="Частота (0 - 250 000 000)"
                              :error="errors.get('frequency')">
                <el-input-number v-model="form.frequency"
                                     style="width: 100%"
                                     :controls="false"
                                     :min="0"
                                     :max="250000000"></el-input-number>
                </el-form-item>
                <el-form-item class="col-md-3"
                              prop="coefficient"
                              label="Коэффициент (0.01 - 100)"
                              :error="errors.get('coefficient')">
                    <el-input-number v-model="form.coefficient"
                                     :controls="false"
                                     style="width: 100%"
                                     :min="0.01" :precision="2"  :max="100"></el-input-number>
                </el-form-item>
                <el-form-item class="col-md-6"
                               prop="frequency_of_cheating"
                               label="ДОЗа (Частота * Коэффициент / 30)"
                               :error="errors.get('frequency_of_cheating')">
                                <div class="el-input__inner" style="display: inline-block">
                                    {{frequencyOfCheating}}
                                </div>
                </el-form-item>
            </div>
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
                 <el-form-item
                               class="col-md-6"
                               prop="active"
                               label="Статус"
                               :error="errors.get('active')">
                     <el-switch v-model="form.active"
                                active-text="Активен"
                                inactive-text="Остановлен">
                     </el-switch>
                 </el-form-item>
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
export default {
    props:{
        saveMsg: {
            default: 'Ключ добавлен'
        },
        massEdit: {
            type:Boolean,
            default: false,
        },
        massCreate: {
            type:Boolean,
            default: false,
        },
        form: {
            type:Object
        },
        formAction: {
            type:Object
        }
    },
    computed: {
        frequencyOfCheating: function () {
          return Math.round((this.form.frequency * this.form.coefficient / 30) *10000) / 10000;
        },
        ...mapGetters([
            'userId',
        ]),
    },
    data() {
        return {
            projects:[],
            errors: new Errors(),
        }
    },
    methods: {

        closeModal(data) {
            this.$emit('close', data);
        },
        save() {
            this.form.frequency_of_cheating = this.frequencyOfCheating;
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
        getProject() {
            axios.get('/api/admin/projects/' + this.$route.params.project_id)
                .then((response) => {

                  let keys = ['targeturl', 'getparameters']
                    keys.forEach((key) => {
                        this.form[key] = response.data[key];
                    })

                })
        },
        getProjectGroupsOptionList(user_id) {
            axios.get('/api/admin/projects-options', {params: {group_id:this.$route.params.id}})
                .then((response) => {
                    this.projects = response.data;
                    this.form.project_id = parseInt(this.$route.params.project_id);
                })
                .catch((error) => {

                })
        },
    },
    mounted() {
        this.getProjectGroupsOptionList(this.userId);
        if(this.massCreate) {
            this.getProject();
        }
    }
}
</script>
