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
                    <a-col>
                        <a-dropdown>
                            <div class="ant-dropdown-link" @click.prevent>
                                <a-avatar>
                                    <template #icon>
                                        <UserOutlined />
                                    </template>
                                    <DownOutlined />
                                </a-avatar>
                                {{ $page.props.auth.user.name }}
                            </div>
                            <template #overlay>
                                <a-menu>
                                    <a-menu-item>
                                        <a-button type="text" @click="logout">ログアウト</a-button>
                                    </a-menu-item>
                                </a-menu>
                            </template>
                        </a-dropdown>

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
import { UserOutlined } from '@ant-design/icons-vue';

export default defineComponent({
    components: {
        UserOutlined,
    },
    setup() {
        const pageList = [
            { name: 'home', content: 'ホーム' },
            { name: 'setting', content: '設定' },
            { name: 'lottery', content: '抽選' },
        ]
        const current = ref(['home'])
        const router = useRouter();
        router.afterEach((to) => {
            current.value[0] = to.name;
            console.log("current", current.value[0]);
        });

        //ログアウト処理
        const logout = () => {
            axios.post('/logout')
                .then(function () {
                    window.location.href = '/';
                });
        };

        return {
            pageList,
            current,
            logout,

        };
    }
})
</script>