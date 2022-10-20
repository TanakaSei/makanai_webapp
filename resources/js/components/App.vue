<template>
    <h1>App page</h1>
    hoge
    <br>
    {{hoge}}
    <br>
    <a-button type="primary">Primary Button</a-button>

</template>
<script>
import { defineComponent, reactive, ref } from 'vue'

export default defineComponent({
    setup() {
        return {
            hoge: '変数表示'
        };
    }
})
</script>