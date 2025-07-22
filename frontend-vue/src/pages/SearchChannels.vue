<script setup lang="ts">
import axios from "axios";
import Input from "@/components/Input.vue";
import Channel from "@/components/Channel.vue";
import { ref } from "vue";
import type { IChannel } from "@/shared/types";
import ChannelJoin from "@/components/ChannelJoin.vue";

const channels = ref<IChannel[]>([]);
const isSearch = ref(false);
const joinedGroups = ref<number[]>([]);

const searchChannels = async (e: any) => {
    const form = e.currentTarget as HTMLFormElement;
    const formData = new FormData(form);
    const response = await axios.get(
        `/api/channels/search/${formData.get("title")}`
    );
    channels.value = response.data;
    isSearch.value = true;
};

const joinChannel = async (channel_id: number) => {
    await axios.post(`/api/channels/join/${channel_id}}`);
    joinedGroups.value.push(channel_id);
};
</script>

<template>
    <div class="search-channels-container">
        <h2>Поиск групп</h2>
        <form @submit.prevent="searchChannels" class="search-form">
            <Input
                label="Поиск"
                id="search_group"
                name="title"
                type="text"
                placeholder="Группа"
                required
            />
            <button type="submit" class="btn-md search-form-btn">Поиск</button>
        </form>
        <div class="channels">
            <ChannelJoin
                v-for="channel in channels"
                :title="channel.title"
                :is_active="joinedGroups.includes(channel.id)"
                @click="() => joinChannel(channel.id)"
            />
            <h3 v-if="channels.length == 0 && isSearch">Группы не найдены</h3>
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
