<script setup lang="ts">
import axios from "axios";
import Input from "@/components/Input.vue";
import Channel from "@/components/Channel.vue";
import { ref } from "vue";
import type { IUser } from "@/shared/types";
import ChannelJoin from "@/components/ChannelJoin.vue";

const users = ref<IUser[]>([]);
const isSearch = ref(false);
// одобренные пользователи, с которыми текущий создал чат
const approvedUsers = ref<number[]>([]);

const searchUsers = async (e: any) => {
    const form = e.currentTarget as HTMLFormElement;
    const formData = new FormData(form);
    const response = await axios.get(
        `/api/users/search/${formData.get("name")}`
    );
    users.value = response.data;
    isSearch.value = true;
};

const createChatWithUser = async (user_id: number) => {
    await axios.post(`/api/channels/local/${user_id}}`);
    approvedUsers.value.push(user_id);
};
</script>

<template>
    <div class="search-channels-container">
        <h2>Поиск людей</h2>
        <form @submit.prevent="searchUsers" class="search-form">
            <Input
                label="Поиск"
                id="search_people"
                name="name"
                type="text"
                placeholder="ivan254"
                required
            />
            <button type="submit" class="btn-md search-form-btn">Поиск</button>
        </form>
        <div class="channels">
            <ChannelJoin
                v-for="user in users"
                :title="user.name"
                :is_active="approvedUsers.includes(user.id)"
                @click="() => createChatWithUser(user.id)"
            />
            <h3 v-if="users.length == 0 && isSearch">Люди не найдены</h3>
        </div>
    </div>
</template>

<style scoped>
.search-channels-container {
    padding-top: 40px;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.search-form {
    display: flex;
    flex-direction: row;
}
.search-form-btn {
    align-self: end;
}
.channels {
    margin-top: 60px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    height: 100vh;
}
</style>
