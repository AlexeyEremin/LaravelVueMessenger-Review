import { settings } from "./../config";
import "./assets/main.css";

import { createApp } from "vue";
import App from "./App.vue";

import { createWebHistory, createRouter } from "vue-router";
import Login from "./pages/Login.vue";
import Regiser from "./pages/Regiser.vue";
import Chat from "./pages/Chat.vue";
import axios from "axios";
import SearchChannels from "./pages/SearchChannels.vue";
import SearchPeople from "./pages/SearchPeople.vue";

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
axios.defaults.baseURL = settings.BACKEND_URL;

const routes = [
    { path: "/", redirect: "/login" },
    { path: "/login", component: Login },
    { path: "/register", component: Regiser },
    { path: "/chat", component: Chat },
    { path: "/search/channels", component: SearchChannels },
    { path: "/search/users", component: SearchPeople },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

createApp(App).use(router).mount("#app");
