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
</template>
   
<script>
import { defineComponent, reactive, ref } from 'vue';
import axios from 'axios';

export default defineComponent({
    setup(_props, context) {
        axios.get('api/menus')
            .then(function (response) {
                console.log(response.data);
            });
        return {}
    }
})
</script>

<style>

</style>