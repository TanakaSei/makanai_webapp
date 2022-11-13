<template>
    <AuthenticatedLayout>
        <a-layout id="app-layout" style="background: #fff;">
            <a-layout-header style="background: #ebc320;">
                <a-row type=" flex">
                    <a-col justify="start">
                        <a-typography-text strong style="color: #af1e23;">まかないセレクター</a-typography-text>
                    </a-col>
                    <a-col flex="auto" justify="end">
                        <a-row type="flex" justify="end">
                            <a-col>
                                <a-menu v-model:selectedKeys="current" mode="horizontal" style="border: 0;"
                                    justify="end">
                                    <a-menu-item v-for="page in pageList" :key="page.name" style="background: #ebc320;">
                                        <router-link :to="{ name: page.name }">{{ page.content }}</router-link>
                                    </a-menu-item>
                                </a-menu>
                            </a-col>
                        </a-row>
                    </a-col>
                </a-row>
            </a-layout-header>
            <router-view></router-view>
        </a-layout>
    </AuthenticatedLayout>
</template>
<script>
import { defineComponent, ref } from 'vue'
import { useRouter } from 'vue-router'
export default defineComponent({
    setup() {
        const pageList = [
            { name: 'home', content: 'ホーム' },
            { name: 'setting', content: '設定' },
            { name: 'lottery', content: '抽選' }
        ]
        const current = ref([])
        const router = useRouter();
        router.afterEach((to) => {
            current.value[0] = to.name;
        });
        return {
            pageList,
            current,
        };
    }
})
</script>