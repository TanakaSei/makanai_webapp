<template>
    <a-typography-title :level="2">Setting Page</a-typography-title>
    {{ $page.props.auth.user.name }}
    {{ $page.props.auth.user.id }}
    {{ $page.props.auth.user.select_num }}
    <div style="margin-left: 16px">
        <a-typography-title :level="3">一般</a-typography-title>
        <a-row>
            <a-col>
                選択数
            </a-col>
            <a-col :span="6">
                <a-slider v-model:value="$page.props.auth.user.select_num" :min="1" :max="3" />
            </a-col>
            <a-col :span="4">
                <a-input-number v-model:value="$page.props.auth.user.select_num" :min="1" :max="3" />
            </a-col>
        </a-row>
        <a-row>
            <a-col :span="6">
                重複
            </a-col>
            <a-col>
                <a-switch v-model:checked="duplication_checked" @change="onChange()">
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
            <a-col :span="3">
                カテゴリ別の設定
            </a-col>
            <a-col :span="5">
                <a-button type="primary" @click="showModal">開く</a-button>
            </a-col>
            <a-col>
                <a-button type="primary" @click="save_change()">変更を保存</a-button>
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
    props: {
        user_status: { type: Array, required: true },
    },
    components: {
        CheckOutlined,
        CloseOutlined,
    },
    setup(props) {
        console.log(props.user_status);

        const visible = ref(false);
        const handleOk = e => {
            visible.value = false;
        };

        const state = reactive({
            duplication_checked: props.user_status.duplication_flg,
        });

        const onChange = () => {
            console.log(state.duplication_checked);
        };
        const showModal = () => {
            console.log("showModal now");
            visible.value = true;
        };
        const setupSettingValue = (user_id) => {
            axios.get('api/setting', {
                params: {
                    id: 3,
                },
            })
                .then(function (response) {
                    console.log(response.data.data);
                    state.menus = response.data.data;
                    state.totalNum = response.data.total_num;
                    state.currentPage = currentPage;
                    // テキストボックスが変更された状態でページネーションされた場合を考慮し、
                    // 検索処理で使用された条件に上書きしておく
                    state.searchText = searchText;
                });
        };
        const save_change = () => {
            console.log("sava_change!!", props.user_status.select_num);
            axios.post('api/setting/save', {
                params: {
                    id: props.user_status.user_id,
                    select_num: props.user_status.select_num,
                    duplication_checked: state.duplication_checked,
                },
            })
                .then(function (response) {
                    if (response.data == -1) {
                        console.log("保存に失敗しました");
                    }
                });
        };
        return {
            visible,
            ...toRefs(state),
            onChange,
            showModal,
            handleOk,
            save_change,
        };
    },
});
</script>