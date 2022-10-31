<template>
    <a-typography-title :level="2">Lottery Page</a-typography-title>
</template>
<script>
import { defineComponent, reactive, ref } from 'vue';
import axios from 'axios';

export default defineComponent({
    setup(_props, context) {
        const lotteryConfig = reactive({
            ignoreCategories: [2, 3, 4, 5],
            ignoreMenus: [],
            lotteryNum: 3,
        });

        const lottery = () => {
            axios.get('api/lottery', {
                params: {
                    select_num: lotteryConfig.lotteryNum,
                    ignore_category: lotteryConfig.ignoreCategories
                },
            }).then(function (response) {
                console.log(response.data);
            });
        }
        lottery();

        return {}
    }
})
</script>