export default{
    state: {
        user: null,
    },
    getters: {
        auth(state){
            return state.user;
        }
    },
    actions: {
        async getCurrentUser(context){
            if(localStorage.getItem('token')){
                try{
                    const resp = await axios.get('/api/user');
                    context.commit("setAuth", resp.data);
                }catch(e){
                    console.log(e);
                }
            }else{
                context.commit("setAuth", null);
            }
        }
    },
    mutations: {
        setAuth(state, data){
            return state.user = data;
        }
    }
}
