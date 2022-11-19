<template>
    <a-typography-title :level="2">Setting Page</a-typography-title>
    {{ $page.props.auth.user.name }}
    {{ $page.props.auth.user.id }}
    {{ $page.props.auth.user.select_num }}
    {{ send_user($page.props.auth.user.id, $page.props.auth.user.select_num) }}
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
                <a-switch v-model:checked="checked1" @change="onChange()">
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
                <a-button type="primary"
                    @click="save_change($page.props.auth.user.id, $page.props.auth.user.select_num)">変更を保存</a-button>
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
        let select_num = 0;
        let user_id;
        const send_user = (id, num) => {
            select_num = num;
            user_id = id;
        };

        const visible = ref(false);
        const handleOk = e => {
            visible.value = false;
        };

        const state = reactive({
            checked1: true,
        });

        const onChange = () => {
            console.log(state.checked1);
        };
        const showModal = () => {
            console.log("showModal now");
            visible.value = true;
        };
        const setupSettingValue = () => {
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
        const save_change = (user_id, select_num) => {
            console.log("sava_change!!", select_num, typeof select_num);
            axios.post('api/setting/save', {
                params: {
                    id: user_id,
                    select_num: select_num,
                },
            })
                .then(function (response) {
                    if (response.data == -1) {
                        console.log("保存に失敗しました");
                    }
                });
        };
        return {
            select_num,
            visible,
            ...toRefs(state),
            onchange,
            showModal,
            handleOk,
            save_change,
            send_user,
        };
    },
});
</script>