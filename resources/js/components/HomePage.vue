<template>
    <a-typography-title :level="2">Home Page</a-typography-title>
    <a-row :gutter="16">
        <a-col :span="10">
            <a-card title="メニュー一覧" style="width: 300px">
            </a-card>
        </a-col>
        <a-col :span="8">
            <a-card title="最近選んだメニュー" style="width: 300px">
                <template #extra>
                    <div @click='showModal'>
                        <a href="#">more

                        </a>
                    </div>
                </template>
                <p>card content</p>
                <p>card content</p>
                <p>card content</p>
            </a-card>
        </a-col>


    </a-row>

    <a-modal v-model:visible="visible" title="Basic Modal" @ok="handleOk">
        <a-table :dataSource="state.menus" :columns="COLUMS" :pagination="false" :scroll="{ x: 800 }" />

        <a-row type="flex" justify="space-between" style="margin-top: 20px;">
            <a-col>
                <a-pagination :current="state.currentPage" :total="state.totalNum" :hideOnSinglePage="true"
                    @change="changePage()" />
            </a-col>
            <a-col>
                <slot name="actionArea"></slot>
            </a-col>
        </a-row>
    </a-modal>

</template>
   
<script>
import { defineComponent, reactive, ref } from 'vue';
import axios from 'axios';

export default defineComponent({
    setup(_props, context) {
        const visible = ref(false);

        const handleOk = e => {
            console.log("handleOK now");
            //console.log(e);
            visible.value = false;
        };
        const showModal = () => {
            console.log("showModal now");
            search(state.seachText);
            visible.value = true;
        };
        const state = reactive({
            menus: [1],
            seachText: '',
            currentPage: 1,
            totalNum: 0,
        });

        const ROWS_PER_PAGE = 5; // 1ページあたりの表示行数

        const COLUMS = [{
            title: 'メニュー名', dataIndex: 'menuName', ellipsis: true,
        }, {
            title: 'カテゴリ名', dataIndex: 'categoryName', ellipsis: true,
        },
        ];

        const search = (seachText, currentPage = 1) => {
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
                    state.menus = response.data.data;
                    state.totalNum = response.data.total_num;
                    state.currentPage = currentPage;
                });
        }
        search(state.seachText, 1);
        const changePage = (page) => {
            search(state.seachText, page);
        };

        //seach(state.seachText);

        return {
            state,
            COLUMS,
            showModal,
            handleOk,
            visible,
            changePage,
        }
    }
})
</script>

<style>

</style>