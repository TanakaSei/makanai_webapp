<template>
    <a-layout id="app-layout" style="background: #fff;">
        <a-layout-header style="background: #ebc320;">
            <a-row type=" flex">
                <a-col justify="start">
                    <a-typography-text strong style="color: #af1e23;">まかないセレクター</a-typography-text>
                </a-col>

            </a-row>
        </a-layout-header>
    </a-layout>
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