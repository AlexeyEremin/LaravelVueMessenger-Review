<script setup lang="tsx">
import axios from "axios";
import { useAttrs } from "vue";

const props = defineProps(["uiAddChannel"]);
const attrs = useAttrs();

const createChannel = async () => {
    //создание канала
    const entered_data = prompt("Создание чата", "Название");
    console.log(entered_data);
    try {
        await axios.post("/api/channels", { title: entered_data });
    } catch (e) {
        alert("Произошла ошибка");
    }
    props.uiAddChannel();
};
</script>

<template>
    <div @click="createChannel" class="channel channel-icon" v-bind="attrs">
        +
    </div>
</template>
