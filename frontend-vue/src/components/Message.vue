<script setup lang="tsx">
import IconX from "./icons/IconX.vue";

const props = defineProps([
    "author",
    "content",
    "created_at",
    "deleteCallback",
    "isMy",
]);
</script>

<template>
    <div class="message">
        <div class="author">
            {{ author }}
        </div>
        <div class="description">
            {{ content }}
        </div>
        <div class="addition">
            <div class="date">
                {{
                    new Intl.DateTimeFormat("ru-RU", {
                        day: "numeric",
                        month: "long",
                        hour: "2-digit",
                        minute: "2-digit",
                    }).format(new Date(created_at))
                }}
            </div>
            <div v-if="isMy" @click="props.deleteCallback" class="delete">
                <IconX />
            </div>
        </div>
    </div>
</template>

<style lang="css" scoped></style>

<style scoped>
.message {
    background-color: #dde0f2;
    border-radius: 12px;
    width: 100%;
    padding: 8px 12px;
    display: flex;
    flex-direction: column;
    justify-items: start;
    position: relative;
}
.author {
    font-weight: 600;
}
.addition {
    position: absolute;
    right: 15px;
    top: 5px;
    display: flex;
    flex-direction: row;
    gap: 6px;
}
.delete {
    cursor: pointer;
}
</style>
