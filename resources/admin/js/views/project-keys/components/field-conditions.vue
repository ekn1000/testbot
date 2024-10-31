<template>
    <section>

        <h5>{{fieldName}}:</h5>
        <div style="margin-bottom: 15px"  v-if="conditionKeys.length > 1">
            <el-radio
                v-if="item.visible"
                v-for="(item, key, index) in conditions"
                v-model="conditionType"
                :key="key"
                :label="key"

                @change="selectConditionKey"
                border
                size="medium">{{item.label}}</el-radio>
        </div>
        <el-form-item class="" :error="conditionError">
            <div class="d-flex column-gap-2" v-if="conditions.range.state">
                <el-form-item  label="От" >
                    <el-input-number :controls="false" v-model="conditions.range.value.from" size="small">
                    </el-input-number>
                </el-form-item>
                <el-form-item label="До">
                    <el-input-number :controls="false" v-model="conditions.range.value.to"  size="small">
                    </el-input-number>
                </el-form-item>
            </div>
            <el-form-item class="col-lg-4" label="Содержит" v-if="conditions.contains.state">
                <el-input size="small" v-model="conditions.contains.value"></el-input>
            </el-form-item>
            <el-form-item class="col-lg-4" label="Равно" v-if="conditions.equal.state">
                <el-input size="small" v-model="conditions.equal.value"></el-input>
            </el-form-item>
            <el-form-item  label="Пустое / Не пустое" v-if="conditions.notEmpty.state">
                <el-switch v-model="conditions.notEmpty.value"
                           active-text="Не пустое"
                           inactive-text="Пустое">
                </el-switch>
            </el-form-item>
            <el-form-item  label="Статус" v-if="conditions.active.state">
                <el-switch v-model="conditions.active.value"
                           active-text="Активен"
                           inactive-text="Остановлен">
                </el-switch>
            </el-form-item>
        </el-form-item>
    </section>

</template>
<script>


    export default {

        props: {
            index: {
                type:Number
            },
            conditionKeys: {
                type:Array
            },
            item: {
                type:Object
            },
            conditionError: {
                type:String
            }
        },
        data() {
            return {
                fieldName: '',
                conditionType: '',
                conditions: {
                    equal: {
                        label: "Равно",
                        visible:false,
                        state:false,
                        value: '',
                    },
                    contains: {
                        label: "Содержит",
                        visible:false,
                         state:false,
                         value: '',
                    },
                    notEmpty: {
                        label: "Пустое / Не пустое",
                        visible:false,
                        state:false,
                        value: false,
                    },
                    range: {
                        label: "От - До",
                        state:false,
                        visible:false,
                        value: {
                            from: 0,
                            to: 0,
                        }
                    },
                    active: {
                        label: "Статус",
                        visible:false,
                        state: false,
                        value:false
                    }
                },
            }
        },
        methods: {
            selectConditionKey(label) {
                this.conditionType = label;
                Object.keys(this.conditions).forEach((key) => {
                    this.conditions[key]['state'] = false;
                })
                this.conditions[label]['state'] = true;
            },
            handleKeys() {
                let firstItem = true;
                this.conditionKeys.forEach((item) => {
                    this.conditions[item]['visible'] = true;
                    if(firstItem) {
                        this.conditions[item]['state'] = true;
                        this.conditionType = item;
                        firstItem = false;
                    }
                })
            },
            handleConditionValue()
            {

                return this.conditions[this.conditionType]['value'];
            }
        },
        mounted() {
            this.handleKeys();
            this.fieldName = this.item.label;
        }
    }
</script>
