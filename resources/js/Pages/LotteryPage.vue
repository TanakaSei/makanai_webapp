<template>
    <a-typography-title :level="2">Lottery Page</a-typography-title>
    <a-button type="primary" @click="onClick">抽選開始（仮）</a-button>
    {{ lotteryResult.resultMenus }}
    <br>
    {{ lotteryResult.resultCategories }}
</template>
<script>
import { defineComponent, reactive, ref } from 'vue';
import axios from 'axios';

export default defineComponent({
    props: {
        user_status: { type: Array, required: true },
    },
    setup(props, context) {
        const lotteryResult = reactive({
            resultMenus: [],
            resultCategories: [],
        });
        const lotteryConfig = reactive({
            ignoreCategories: [],
            ignoreMenus: [],
            lotteryNum: props.user_status.select_num,
        });

        const onClick = e => {
            lottery();
        };

        const lottery = () => {
            axios.get('api/lottery', {
                params: {
                    select_num: lotteryConfig.lotteryNum,
                    ignore_category: lotteryConfig.ignoreCategories
                },
            }).then(function (response) {
                //console.log(response.data);
                for (let i = 0; i < lotteryConfig.lotteryNum; i++) {
                    lotteryResult.resultMenus[i] = response.data[i].menu_name;
                    lotteryResult.resultCategories[i] = response.data[i].category_name;
                }
            });
        }

        return {
            lotteryConfig,
            lotteryResult,
            onClick,
        }
    }
})
</script>