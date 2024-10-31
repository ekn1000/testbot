<template>
    <div>

        <el-form :model="conditions" label-position="top" v-if="status === 'mass-edit'" style="margin-bottom: 30px">
            <div style="margin-bottom: 15px">
                <h4 style="display:block; margin-bottom: 25px">Выберите условие для редактирования:</h4>
                <el-checkbox
                    v-for="(item, key, index) in conditions"
                    :key = "key"
                    @change="errors.clear('conditions.' + key + '.value')"
                    v-model="item.state">{{item.label}}</el-checkbox>

            </div>
            <field-conditions
                v-show="item.state"
                :key="key"
                :index="index"
                ref="conditions"
                :condition-error="errors.get('conditions.' + key + '.value')"
                :item="item"
                :condition-keys="item.conditionKeys"
                v-for="(item, key, index) in conditions"></field-conditions>
        </el-form>
        <el-form :model="form" ref="form" label-position="top">
            <div style="margin-bottom: 15px">
                <h5 style="margin-bottom: 15px">Выберите поля для редактирования:</h5>
                <el-checkbox v-model="formFields.targeturl" @change="updateErrors">URL</el-checkbox>
                <el-checkbox v-model="formFields.frequency" @change="updateErrors">Частота</el-checkbox>
                <el-checkbox v-model="formFields.coefficient" @change="updateErrors"> Коэффициент</el-checkbox>
                <el-checkbox v-model="formFields.active">Статус</el-checkbox>
                <el-checkbox v-model="formFields.getparameters" @change="updateErrors">Параметры</el-checkbox>
            </div>
            <el-form-item prop="targeturl" label="URL" :error="errors.get('data.targeturl')" v-if="formFields.targeturl">
                <el-input v-model="form.targeturl" placeholder="URL"></el-input>
            </el-form-item>
            <div class="row" >
                <el-form-item
                    v-if="formFields.frequency"
                    class="col-md-3"
                    prop="frequency"
                    label="Частота (0 - 250 000 000)"
                    :error="errors.get('frequency')">
                    <el-input-number v-model="form.frequency"
                                     style="width: 100%"
                                     :controls="false"
                                     :min="0"
                                     :max="250000000"></el-input-number>
                </el-form-item>
                <el-form-item
                    v-if="formFields.coefficient"
                    class="col-md-3"
                    prop="coefficient"
                    label="Коэффициент (0.01 - 100)"
                    :error="errors.get('coefficient')">
                    <el-input-number v-model="form.coefficient"
                                     :controls="false"
                                     style="width: 100%"
                                     :min="0.01" :precision="2"  :max="100"></el-input-number>
                </el-form-item>
                <el-form-item v-if="formFields.active"
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
            <div class="row" v-if="formFields.getparameters">
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
            <div class="text-center">
                <el-button type="success" @click.prevent="save">Сохранить</el-button>
                <el-button  @click.prevent="closeModal">Отменить</el-button>
            </div>
        </el-form>
    </div>

</template>
<script>
import { Errors } from  '@/common/js/services/errors.js';

import { mapGetters } from 'vuex';
import FieldConditions from "./field-conditions.vue";
import {numWordsMixin} from "@/admin/js/mixins/numWordsMixin";
export default {

    components: {
        FieldConditions,

    },
    mixins: [ numWordsMixin ],
    props:{
        selectedItemsIds: {
            type:Array,
            default() {
                return [];
            },
        },

        massEdit: {
            type:Boolean,
            default: false,
        },
        status: {
            type:String,
            default: 'mass-edit'
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

            conditions: {
                keyword: {
                    state: false,
                    label: 'Ключ',
                    conditionKeys: ['equal', 'contains', 'notEmpty'],
                    type: '',
                    value:''
                },
                targeturl: {
                    state:false,
                    label: 'URL',
                    conditionKeys: ['equal', 'contains', 'notEmpty'],
                    type: '',
                    value:''
                },
                getparameters: {
                    state:false,
                    label: 'Параметры',
                    conditionKeys: ['equal', 'contains', 'notEmpty'],
                    type: '',
                    value:'',
                },
                frequency:{
                    state:false,
                    label: 'Частота',
                    conditionKeys: ['range'],
                    type: '',
                    value:'',
                },
                coefficient: {
                    state:false,
                    label: 'Коэффициент',
                    conditionKeys: ['range'],
                    type: '',
                    value:'',
                },
               active: {
                    state:false,
                    label: 'Статус',
                    conditionKeys: ['active'],
                    type: '',
                    value:'',
                }
            },
            formFields: {
                targeturl:false,
                getparameters: false,
                frequency:false,
                coefficient:false,
                active:false,
            },
            projects:[],
            errors: new Errors(),
        }
    },
    methods: {
        saveMsg(keys_count) {
           return this.numWords(keys_count, ['Обновлен','Обновлены','Обновлены'])
              + ' '  + keys_count + ' '
               + this.numWords(keys_count, ['ключ', 'ключа','ключей'])
        },
        updateErrors() {
            this.errors = new Errors;

        },
        closeModal(data) {
            this.$emit('close', data);
        },
        refItem(item) {
            return this.$refs.conditions.find((refItem) => {
                return refItem.item.key === item.key;
            })
        },
        save() {
           // this.form.frequency_of_cheating = this.frequencyOfCheating;
            let formData = {};
            formData.data = {};
            Object.keys(this.formFields).forEach((key) => {
                if(this.formFields[key]) {
                    formData['data'][key] = this.form[key];
                }
            })
            if(Object.keys(formData.data).length === 0) {
                this.$message({
                    message: 'Не выбраны поля для редактирования',
                    type: 'error'
                });
                return;
            }
            formData['data']['project_id'] = this.form.project_id;
            if(this.status === 'mass-edit') {
                formData.conditions = {};
                Object.keys(this.conditions).forEach((key, index) => {

                    if(this.conditions[key]['state']) {
                         this.conditions[key].value = this.$refs.conditions[index].handleConditionValue();
                         this.conditions[key].type = this.$refs.conditions[index].conditionType;
                         formData.conditions[key] = this.conditions[key];

                    }

                })
            } else if(this.status === 'mass-edit-selection') {
                formData.selectionIds = this.selectedItemsIds;
            }

            axios({
                method: this.formAction.method ,
                url: this.formAction.url,
                data: formData
            }).then((response) => {
                this.$message({
                    message: this.saveMsg(response.data),
                    type: 'success'
                });
                this.closeModal();
            })
                .catch((error) => {
                    this.errors.record(error.response.data.errors);
                });

        },

    },
    mounted() {
        this.form.project_id = this.$route.params.project_id;
        console.log(this.form.project_id)
    }
}
</script>
