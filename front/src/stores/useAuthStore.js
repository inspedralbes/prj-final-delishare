import { reactive } from 'vue';

const state = reactive({
    user: null,
    token: null,
});

const setUser = (user) => {
    state.user = user;
};

const setToken = (token) => {
    state.token = token;
};

const useAuthStore = () => {
    return {
        state,
        setUser,
        setToken,
    };
};

export { useAuthStore };
