<template>
    <div class="flex justify-center items-center" style="height: 90vh;">
        <div class="login-form border py-4 px-10 w-96">
            <h1 class="font-bold text-3xl text-center mb-5">Login</h1>
            <div v-if="error" class="error-text my-5 text-red-500 bg-red-100 py-2 px-5">
                {{ errorText }}
            </div>
            <div class="email">
                <label for="email">Email<sup class="text-red-500">*</sup></label><br>
                <input class="input p-2 w-full border h-10" id="email" v-model="email" type="email" required >
            </div>
            <div class="password mt-3">
                <label for="password">Password<sup class="text-red-500">*</sup></label> <br>
                <input class="input w-full p-2 border h-10" id="password" v-model="password" type="password" required >
            </div>
            <div class="my-3 text-sm text-gray-500">Not registered? <router-link class="text-blue-600" to="/register">Register here</router-link></div>
            <div class="submit-btn text-center mt-5">
                <button @click="login" class="bg-blue-700 text-white px-5 py-2 ">Submit</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",
    data(){
        return {
            error: false,
            errorText: '',

            email: '',
            password: '',
        }
    },
    async created(){
        await axios.get('/sanctum/csrf-cookie');
    },
    methods: {
        errorHappened(){
            let mailFormat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if(!mailFormat.test(this.email)){
                this.error = true;
                this.errorText = 'Please insert a valid email';
                return true;
            }
            if(this.password.length === 0){
                this.error = true;
                this.errorText = 'Password must not be empty';
                return true;
            }
            return false;
        },
        async login(){
            this.error = false;
            this.errorText = '';
            if(!this.errorHappened()){
                // submit form
                try{
                    const resp = await axios.post('/api/login', {
                        email: this.email,
                        password: this.password
                    });

                    // setting the token in localstorage
                    localStorage.setItem('token', resp.data);

                    axios.defaults.headers.common['Authorization'] = `Bearer ${resp.data}`;
                    await this.$store.dispatch("getCurrentUser");
                    await this.$router.push('/');

                }catch (e) {
                    console.log(e);
                    this.error = true;
                    this.errorText = 'Email or password does not match';
                }
            }
        },
    }
}
</script>

<style scoped>
.input{
    outline: none;
}
</style>
