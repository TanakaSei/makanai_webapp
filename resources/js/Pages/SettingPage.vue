<template>
    <a-typography-title :level="2">Setting Page</a-typography-title>
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
            <a-col :span="6">
                カテゴリ別の設定
            </a-col>
        </a-row>
        <div v-for="i in category_state.category_data.length">
            <a-row>
                <a-col :span="6">
                    {{ category_state.category_data[i - 1]["category_name"] }}
                </a-col>
                <a-col>
                    <a-switch v-model:checked="category_select_flg[i - 1]" @change="onSettingChange()">
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
        <a-row>
            <a-col>
                <a-button type="primary" @click="save_change()">変更を保存</a-button>
            </a-col>
        </a-row>
    </div>

</template>
<script>
import { defineComponent, ref, reactive, toRefs } from 'vue';
import { CheckOutlined, CloseOutlined } from '@ant-design/icons-vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
export default defineComponent({
    props: {
        user_status: { type: Array, required: true },
        category_status: { type: Array, required: true },
    },
    components: {
        CheckOutlined,
        CloseOutlined,
    },
    setup(props) {
        const router = useRouter()

        const visible = ref(false);

        const category_state = reactive({
            selectedRowKeys: [],
            // Check here to configure the default column
            loading: false,
            category_data: [],
        });

        const handleOk = e => {
            visible.value = false;
        };

        //この方式だと変更して保存後リロードしないと別ページから戻ってきても変更が反映されていない
        //appでのpropsの変更が反映されていないため
        const state = reactive({
            duplication_checked: props.user_status.duplication_flg,
            category_select_flg: props.category_status.category_select_flg,
        });

        const onChange = () => {
            console.log("onChange", state.duplication_checked);
        };
        const onSettingChange = () => {
            //props.category_status.category_select_flg
        };
        const showModal = () => {
            console.log("showModal now");
            visible.value = true;
        };
        const save_change = () => {
            console.log("save_change!!", props.user_status.select_num);
            axios.post('api/setting/save', {
                params: {
                    id: props.user_status.user_id,
                    select_num: props.user_status.select_num,
                    duplication_checked: state.duplication_checked,
                    category_state: state.category_select_flg,
                },
            })
                .then(function (response) {
                    if (response.data == -1) {
                        console.log("保存に失敗しました");
                    }
                    else {
                        //保存後，再読み込み
                        router.go({ path: '/setting', force: true });
                    }
                });
        };
        const category_list = () => {
            axios.get('api/setting/list').then(function (response) {
                category_state.category_data = response.data;
            });
        }

        category_list();
        console.log('category_state', props.category_status.category_select_flg);
        //setupSettingValue(props.user_status.user_id);
        return {
            category_state,

            visible,
            ...toRefs(state),
            onChange,
            showModal,
            handleOk,
            save_change,
            category_list,
            onSettingChange,
        };
    },
});
</script>