<template>
    <a-typography-title :level="2">Home Page</a-typography-title>
    <a-row :gutter="50">
        <a-col :span="10">
            <a-card title="メニュー一覧" style="width: 300px">
                <template #extra>
                    <div @click='showModal'>
                        <a href="#">more</a>
                    </div>
                </template>
            </a-card>
        </a-col>
        <a-col :span="8">
            <a-card title="最近選んだメニュー" style="width: 300px">
                <template #extra>
                    <div @click='showModal'>
                        <a href="#">more</a>
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
                <a-pagination :current="state.currentPage" :total="state.totalNum" :pageSize="ROWS_PER_PAGE"
                    :hideOnSinglePage="true" @change="changePage($event)" />
            </a-col>
            <a-col>
                <a-input-search v-model:value="state.searchText" placeholder="キーワードで検索" enter-button
                    @search="onSearch()" />
            </a-col>

        </a-row>
    </a-modal>

</template>
   
<script>
import { defineComponent, reactive, ref } from 'vue';
import axios from 'axios';

let tmpPage = 1
let tmpSearchText = ''
export default defineComponent({
    setup(_props, context) {
        const visible = ref(false);

        const handleOk = e => {
            visible.value = false;
        };
        const showModal = () => {
            console.log("showModal now");
            search(state.searchText);
            visible.value = true;
        };
        const state = reactive({
            menus: [],
            searchText: '',
            currentPage: 1,
            totalNum: 0,
        });

        const ROWS_PER_PAGE = 5; // 1ページあたりの表示行数
        let lastSearchText = ''; // ページング時はテキストボックスの内容に依らず検索させるため、別に保持させる
        const COLUMS = [{
            title: 'メニュー名', dataIndex: 'menu_name', ellipsis: true,
        }, {
            title: 'カテゴリ名', dataIndex: 'category_name', ellipsis: true,
        },
        ];

        const search = (searchText, currentPage = 1) => {
            let offset = (currentPage - 1) * ROWS_PER_PAGE;
            //console.log(offset, currentPage, searchText);
            axios.get('api/menus', {
                params: {
                    offset: offset,
                    contents_limit: ROWS_PER_PAGE,
                    search_text: searchText,
                },
            })
                .then(function (response) {
                    //console.log(offset, ROWS_PER_PAGE, searchText);
                    state.menus = response.data.data;
                    state.totalNum = response.data.total_num;
                    state.currentPage = currentPage;
                    tmpPage = currentPage;
                    tmpSearchText = searchText;
                    console.log(response.data);
                    // テキストボックスが変更された状態でページネーションされた場合を考慮し、
                    // 検索処理で使用された条件に上書きしておく
                    state.searchText = searchText;
                    lastSearchText = searchText;
                });
        };

        //テーブルのページ切り替え時
        const changePage = (page) => {
            search(state.searchText, page);
        };

        //直接seachを検索ボックスでは呼び出せなかったのでonSearch経由
        const onSearch = () => {
            console.log(state.searchText);
            search(state.searchText);
        };

        //seach(state.seachText);

        return {
            state,
            COLUMS,
            showModal,
            handleOk,
            visible,
            changePage,
            ROWS_PER_PAGE,
            onSearch,
        }
    }
})
</script>

<style>

</style>