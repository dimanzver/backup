export default {
    namespaced: true,
    state: {
        get token(){
            return localStorage.getItem('access_token');
        },

        set token(access_token){
            if(!access_token){
                localStorage.removeItem('access_token');
            }else{
                localStorage.setItem('access_token', access_token);
            }
        },
    },

    getters: {
        isAuthenticated(state){
            return !!state.token;
        },
    },

    mutations: {
        AUTH_SUCCESS(state, token){
            state.token = token;
        },

        AUTH_LOGOUT(state){
            state.token = null;
        },
    },

    actions: {
        async login(context, data){
            let response = await apiRequest.post('/api/auth/login', data);
            context.commit('AUTH_SUCCESS', response.token);
        },

        async logout(context){
            await fetch('/api/auth/logout',  {
                method: 'POST',
                cache: 'no-cache',
                headers: {
                    'Content-Type': 'application/json',
                },
                Authorization: 'Bearer ' + context.state.token,
                body: '{}',
            });
            context.commit('AUTH_LOGOUT');
        },
    },
};