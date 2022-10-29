<template>
    <a-typography-title :level="2">Home Page</a-typography-title>
    <a-card title="メニュー一覧" style="width: 300px">
        <template #extra>
            <div @click='showModal'>
                <a href="#">more
                    <a-modal v-model:visible="visible" title="Basic Modal" @ok="handleOk">
                        <a-table :dataSource="state.menus" :columns="COLUMS" />
                    </a-modal>
                </a>
            </div>
        </template>
    </a-card>
    <br />
    <a-card title="最近選んだメニュー" style="width: 300px">
        <template #extra>
            <div @click='showModal'>
                <a href="#">more
                    <a-modal v-model:visible="visible" title="Basic Modal" @ok="handleOk">
                        <a-table :dataSource="state.menus" :columns="COLUMS" />
                    </a-modal>
                </a>
            </div>
        </template>
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
        const visible = ref(false);

        const handleOk = e => {
            console.log(e);
            visible.value = false;
        };
        const showModal = () => {
            visible.value = true;
        };
        const state = reactive({
            menus: [],
            seachText: '',
            currentPage: 1,
        });
        const ROWS_PER_PAGE = 10; // 1ページあたりの表示行数

        const COLUMS = [{
            title: 'メニュー名', dataIndex: 'menuName', ellipsis: true,
        }, {
            title: 'カテゴリ名', dataIndex: 'categoryName', ellipsis: true,
        },
        ];

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
                    console.log(response.data);
                    state.menus = response.data;
                });
        }

        seach(state.seachText);

        return {
            state,
            COLUMS,
            showModal,
            handleOk,
            visible,
        }
    }
})
</script>

<style>

</style>