<template>
    <td class="statistic-data-row"
        @click.prevent ="showStatisticItem"
        :class="selectBgClassName()"
        :style="position !== 0 ? 'cursor:pointer' : ''">
        <template v-if="position > 0" >
        <span class="statistic-data-row__position">
             {{position}}
        </span>
            <sup style="font-weight: bold; font-size: 14px">
                <template v-if="avg_position_diff < 0">
                    <i class="el-icon-top" style="color: #20b805"></i>
                    <span style="color: #20b805">
                      {{avg_position_diff * -1}}
                    </span>
                </template>
                <template v-else-if="avg_position_diff > 0">
                    <i class="el-icon-bottom" style="color:#f56c6c"></i>
                    <span style="color:#f56c6c">
                      {{avg_position_diff}}
                    </span>
                </template>
            </sup>
            <hr style="margin: 10px 0" v-if="additionalFieldsArr.length > 0">
            <div
                class="statistic-data-row__additional"
                v-if="additionalFieldsArr.length > 0"
                v-for="key in additionalFieldsArr">
                <span class="statistic-data-row__additional-label">
                    {{additionalFieldsLabels[key]}}:
                </span>

                <span class="statistic-data-row__additional-value"
                      v-if="(key !== 'received') && (key !== 'found')  && (key !== 'visited') && (key !== 'entered') && (key !== 'notfound')">
                    {{avgData(itemData[key])}}
                </span>
                <span v-else>
                    {{itemData[key]}}
                </span>

            </div>
        </template>
        <template v-else>
            <span class="statistic-data-row__position">--</span><sup><i class="el-icon-close" style="color:#f56c6c"></i></sup>
        </template>

    </td>
</template>
<script>
import postcss from "postcss";

export default
{

    data() {
        return {
            itemsPerPage: 10,
        }
    },
    props: {
        additionalFieldsLabels: {
            type:Object
        },
        additionalFieldsArr:{
            type: Array
        },
        itemData: {
            type:Object
        },
        colorScheme: {
            type:String,
            default: "top-progress"
        }
    },
    computed: {
        position: function () {
            let avg_position = this.itemData.sum_position / this.itemData.found;
            return avg_position ? Math.round(avg_position) : 0;
        },
        avg_position_diff:function () {
            let avg_diff = 0;
            if(this.position > 0 && this.itemData.avg_position_last > 0) {
                avg_diff = this.position - Math.round(this.itemData.avg_position_last);
            }
            return avg_diff;
        }
    },
     methods: {
        avgData(item) {
            let avg = item / this.itemData.found;
            return avg ? Math.round(avg) : 0;
        },
        showStatisticItem() {
            if(this.position > 0) {
                this.$emit('show-item', this.itemData.id)
            }

        },
        selectBgClassName() {
            let tdClassName = '';
               if(this.colorScheme === 'top-progress') {
                  tdClassName = this.topProgress();
               } else if(this.colorScheme === 'up-down') {
                   tdClassName = this.upDown();
               }

            return tdClassName;
        },
         topProgress() {
             let tdClassName = '';
             if (this.position > 0 && this.position < 11) {
                 tdClassName = 'statistic-data-row--' + this.position;
             }  else  {
                 let currentPage = this.getPageNumber(this.position);
                 let prevPage = this.getPageNumber(this.itemData.avg_position_last);
                 if(this.avg_position_diff > 0) {
                     if(currentPage !== prevPage) {
                         tdClassName = 'statistic-data-row--progress-fall';
                     }
                 } else if(this.avg_position_diff < 0) {
                     if(currentPage !== prevPage) {
                         tdClassName = 'statistic-data-row--progress-up-page';
                     } else {
                         tdClassName = 'statistic-data-row--progress-up';
                     }
                 }
             }
             return tdClassName;
         },
         upDown() {
             let tdClassName = '';
             let currentPage = this.getPageNumber(this.position);
             let prevPage = this.getPageNumber(this.itemData.avg_position_last);
             if (this.avg_position_diff > 0) {
                 if(currentPage !== prevPage) {
                     tdClassName = 'statistic-data-row--down-' + (currentPage-prevPage);
                 } else {
                     tdClassName = 'statistic-data-row--down-0';
                 }
             } else if(this.avg_position_diff < 0) {
                 if(currentPage !== prevPage) {
                     tdClassName = 'statistic-data-row--upper-' + (prevPage - currentPage);
                 } else {
                     tdClassName = 'statistic-data-row--upper-0'
                 }

             }
             return tdClassName;
         },
         getPageNumber(position) {
           return  Math.ceil(position / this.itemsPerPage)
         }

     },
    mounted() {
        this.selectBgClassName()
    }
}
</script>
