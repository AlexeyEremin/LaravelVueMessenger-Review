<script setup lang="ts">
import { onMounted, onUnmounted, ref, watch, nextTick } from "vue";
import { useRouter } from "vue-router";
import { useEchoPublic } from "@laravel/echo-vue";
import type { IChannel, IMessage } from "@/shared/types";
import Input from "@/components/Input.vue";
import Channel from "@/components/Channel.vue";
import Message from "@/components/Message.vue";
import axios from "axios";
import ChannelCreate from "@/components/ChannelCreate.vue";
import ChannelSearch from "@/components/ChannelSearch.vue";
import IconSend from "@/components/icons/IconSend.vue";
import UserSearch from "@/components/UserSearch.vue";

const router = useRouter();
const channels = ref<IChannel[]>([]);
const messages = ref<IMessage[] | undefined>(undefined);
const currentChatId = ref<number | undefined>(undefined);
// блок с сообщениями (для скрола)
const messagesContainer = ref<HTMLElement | null>(null);
// имя пользователя
const myName = ref<string | null>(null);

const getMe = async () => {
    // получение информации о себе
    const response = await axios.get("/api/users/me");
    myName.value = response.data.name;
};

const getMyChannels = async () => {
    // получение моих каналов
    try {
        const response = await axios.get("/api/channels/me");
        channels.value = response.data;
    } catch (e) {
        router.push("/login");
    }
};

const sendMessage = async (e: Event) => {
    // отправка сообщения
    if (!currentChatId.value) return;
    const formData = new FormData(e.currentTarget as HTMLFormElement);
    const data = {
        message: formData.get("message"),
        channel_id: currentChatId.value,
    };
    await axios.post("/api/messages", data);
};

const deleteMessage = async (message_id: number) => {
    // удаление сообщения
    await axios.delete(`/api/messages/${message_id}`);
    // поиск индекса сообщения
    // для изменения текущего ui
    const index_message = messages.value?.findIndex((i) => i.id == message_id);

    if (index_message !== undefined) {
        messages.value?.splice(index_message, 1);
    }
};
let echoListener: any = null;

const scrollDown = () => {
    // прокрутка в конец сообщений
    if (messagesContainer.value) {
        messagesContainer.value.scrollTop =
            messagesContainer.value.scrollHeight;
    }
};
// прокрутка в конец сообщений при открытии страницы
watch(messages, () => nextTick(scrollDown), { deep: true });
watch(currentChatId, async (newId, oldId) => {
    if (!newId) return;

    if (echoListener && oldId) {
        echoListener.stopListening(`channels.${oldId}`);
    }
    // получение сообщений канала
    const response = await axios.get(
        `/api/channels/${currentChatId.value}/messages`
    );
    messages.value = response.data;

    // запуск прослушивания сообщений
    echoListener = useEchoPublic(
        `channels.${currentChatId.value}`,
        ".MessageBroadcast",
        (payload: any) => {
            console.log(payload), messages.value?.push(payload);
        }
    );
    // без этой строки почему то не работает калбек сверху
    echoListener.listen(".MessageBroadcast");
});

onMounted(() => {
    getMe();
    getMyChannels();
    scrollDown();
});

onUnmounted(() => {
    if (echoListener && currentChatId.value) {
        echoListener.stopListening(`channels.${currentChatId.value}`);
    }
});
</script>

<template>
    <div class="chat-container">
        <div class="channels">
            <ChannelSearch />
            <UserSearch />
            <Channel
                v-for="channel in channels"
                :title="channel.title"
                :is_active="currentChatId == channel.id"
                @click="() => (currentChatId = channel.id)"
            />
            <ChannelCreate :uiAddChannel="getMyChannels" />
        </div>

        <div v-if="currentChatId" class="chat">
            <div ref="messagesContainer" class="messages">
                <Message
                    v-for="message in messages"
                    :content="message.content"
                    :author="message.author"
                    :created_at="message.created_at"
                    :isMy="myName == message.author"
                    :delete-callback="() => deleteMessage(message.id)"
                />
            </div>

            <form @submit.prevent="sendMessage" class="message-input">
                <Input
                    ref="sendMessageInput"
                    id="chat_input"
                    style-type="lg"
                    name="message"
                    @keydown.enter="sendMessage"
                    required
                />
                <button type="submit" class="btn-lg-icon">
                    <IconSend />
                </button>
            </form>
        </div>

        <div v-else class="center">Выберите чат</div>
    </div>
</template>

<style scoped>
.chat-container {
    height: 100vh;
    display: flex;
    flex-direction: row;
}

.channels {
    display: flex;
    height: 80vh;
    flex-direction: column;
    gap: 12px;
    height: 100vh;
    border-right: 1px solid var(--primary);
    padding-top: 24px;
    padding-right: 24px;
    padding-left: 24px;
}

.chat {
    display: flex;
    flex: 1;
    flex-direction: column;
    align-items: center;
    justify-content: end;
    padding: 40px;
}

.message-input {
    display: flex;
    flex-direction: row;
}

.messages {
    display: flex;
    flex-direction: column;
    width: 40%;
    justify-self: start;
    gap: 12px;
    margin-bottom: 20px;
    overflow-y: auto;
}

.center {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
}
</style>
