<template>
    <a-typography-title :level="2">Home Page</a-typography-title>
    <a-card title="メニュー一覧" style="width: 300px">
        <template #extra><a href="#">more</a></template>
        <p>card content</p>
        <p>card content</p>
        <p>card content</p>
    </a-card>
    <br />
    <a-card title="最近選んだメニュー" style="width: 300px">
        <template #extra><a href="#">more</a></template>
        <p>card content</p>
        <p>card content</p>
        <p>card content</p>
    </a-card>
    {{ state.menus }}
</template>
   
<script>
import { defineComponent, reactive, ref } from 'vue';
import axios from 'axios';

export default defineComponent({
    setup(_props, context) {
        const state = reactive({
            menus: [],
            seachText: '',
            currentPage: 1,
        });
        const ROWS_PER_PAGE = 10; // 1ページあたりの表示行数

        const seach = (seachText, currentPage = 1) => {
            let offset = (currentPage - 1) * ROWS_PER_PAGE
            axios.get('api/menus', {
                params: {
                    offset: state.offset,
                    contents_limit: ROWS_PER_PAGE,
                    seach_text: state.seachText,
                },
            })
                .then(function (response) {
                    console.log(response);
                    state.menus = response.data;
                });
        }

        seach(state.seachText);
        return { state, }
    }
})
</script>

<style>

</style>