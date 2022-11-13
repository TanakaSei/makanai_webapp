<template>
    <a-typography-title :level="2">Setting Page</a-typography-title>
    <div style="margin-left: 16px">
        <a-typography-title :level="3">一般</a-typography-title>
        <a-row>
            <a-col>
                選択数
            </a-col>
            <a-col :span="6">
                <a-slider v-model:value="inputValue1" :min="1" :max="3" />
            </a-col>
            <a-col :span="4">
                <a-input-number v-model:value="inputValue1" :min="1" :max="3" />
            </a-col>
        </a-row>
        <a-row>
            <a-col :span="6">
                重複
            </a-col>
            <a-col>
                <a-switch v-model:checked="checked1" @change="onchange()">
                    <template #checkedChildren>
                        <check-outlined />
                    </template>
                    <template #unCheckedChildren>
                        <close-outlined />
                    </template>
                </a-switch>
            </a-col>
        </a-row>
    </div>
    <br>
    <div style="margin-left: 16px">
        <a-typography-title :level="3">詳細設定</a-typography-title>
        <a-row>
            <a-col>
                カテゴリ別の設定
            </a-col>
            <a-col>
                <a-button type="primary" @click="showModal">開く</a-button>
            </a-col>
        </a-row>
    </div>

    <a-modal v-model:visible="visible" title="Basic Modal" @ok="handleOk">
    </a-modal>
</template>
<script>
import { defineComponent, ref, reactive, toRefs } from 'vue';
import { CheckOutlined, CloseOutlined } from '@ant-design/icons-vue';
export default defineComponent({
    components: {
        CheckOutlined,
        CloseOutlined,
    },
    setup() {
        const inputValue = ref(0);
        const inputValue1 = ref(1);

        const visible = ref(false);
        const handleOk = e => {
            visible.value = false;
        };

        const state = reactive({
            checked1: true,
        });

        const onchange = () => {
            console.log(state.checked1);
        };
        const showModal = () => {
            console.log("showModal now");
            visible.value = true;
        };
        return {
            inputValue,
            inputValue1,
            visible,
            ...toRefs(state),
            onchange,
            showModal,
            handleOk,
        };
    },
});
</script>