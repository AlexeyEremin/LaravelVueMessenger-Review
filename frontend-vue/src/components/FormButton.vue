<script setup lang="tsx">
const props = defineProps(["class", "is_loading"]);
</script>

<template>
    <button class="form-btn">
        <div v-if="props.is_loading" class="spinner" />
        <slot v-else />
    </button>
</template>

<style lang="css" scoped>
.form-btn {
    border: none;
    height: 32px;
    width: 100%;
    background-color: var(--primary);
    border-radius: 6px;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 16px;
}

.spinner {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid #fff;
    border-top: 2px solid transparent;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}
</style>
