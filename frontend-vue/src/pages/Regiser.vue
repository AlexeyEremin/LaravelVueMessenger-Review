<script setup lang="ts">
import FormButton from "@/components/FormButton.vue";
import Input from "@/components/Input.vue";
import axios from "axios";
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const is_loading = ref(false);

const handleLogin = async (e: Event) => {
    is_loading.value = true;
    const form = e.currentTarget as HTMLFormElement;
    const data = new FormData(form);
    let response;
    try {
        response = await axios.post("/api/register", data);
    } catch (e) {
        alert("Произошла ошибка");
        is_loading.value = false;
        return;
    }
    if (response.status == 201) {
        router.push("/chat");
    }
    is_loading.value = false;
};

const choiceAnother = () => {
    router.push("/login");
};
</script>

<template>
    <div class="form_container">
        <h1>Регистрация</h1>
        <h4>Создайте новый аккаунт</h4>
        <form @submit.prevent="handleLogin" class="form">
            <Input
                label="Имя"
                id="login_name"
                name="name"
                type="text"
                placeholder="Иван"
                required
            />
            <Input
                label="Email"
                id="login_email"
                name="email"
                type="text"
                placeholder="example@mail.ru"
                required
            />
            <Input
                label="Пароль"
                id="login_password"
                name="password"
                type="password"
                placeholder="•••••••••"
                required
            />
            <Input
                label="Повторите пароль"
                id="login_password_confirmation"
                name="password_confirmation"
                type="password"
                placeholder="•••••••••"
                required
            />
            <FormButton type="submit" class="form-btn" :is_loading="is_loading"
                >Войти</FormButton
            >
            <div>
                Есть аккаунт?
                <span @click="choiceAnother" class="another-choice">Войти</span>
            </div>
        </form>
    </div>
</template>

<style scoped></style>
