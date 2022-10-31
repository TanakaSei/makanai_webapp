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
    setup(_props, context) {
        const lotteryResult = reactive({
            resultMenus: [],
            resultCategories: [],
        });
        const lotteryConfig = reactive({
            ignoreCategories: [],
            ignoreMenus: [],
            lotteryNum: 3,
        });

        const onClick = e => {
            console.log("clicked")
            lottery();
        };

        const lottery = () => {
            axios.get('api/lottery', {
                params: {
                    select_num: lotteryConfig.lotteryNum,
                    ignore_category: lotteryConfig.ignoreCategories
                },
            }).then(function (response) {
                console.log(response.data);
                for (let i = 0; i < lotteryConfig.lotteryNum; i++) {
                    lotteryResult.resultMenus[i] = response.data[i].menuName;
                    lotteryResult.resultCategories[i] = response.data[i].categoryName;
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