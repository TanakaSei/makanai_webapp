<template>
    <a-layout id="app-layout" style="background: #fff;">
        <a-layout-header style="background: #ebc320;">
            <a-row type=" flex">
                <a-col justify="start">
                    <a-typography-text strong style="color: #af1e23;">まかないセレクター</a-typography-text>
                </a-col>
                <a-card style="width: 100%;
                    color:#af1e23" title="まかないセレクター" :tab-list="tabList" :active-tab-key="key"
                    @tabChange="key => onTabChange(key, 'key')">
                </a-card>

            </a-row>
        </a-layout-header>
    </a-layout>
</template>
<script>
import { defineComponent, reactive, ref } from 'vue'
export default defineComponent({
    setup() {
        const tabList = [{
            key: 'home',
            tab: 'home',
        }, {
            key: 'setting',
            tab: 'setting',
        }, {
            key: 'hoge',
            tab: 'hoge',
        }];
        return {
            tabList,
        };
    }
})
</script>