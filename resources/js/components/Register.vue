<template>
    <div class="flex justify-center items-center" style="height: 90vh;">
        <div class="login-form border py-4 px-10 w-96">
            <h1 class="font-bold text-3xl text-center mb-5">Register</h1>
            <div v-if="error" class="error-text my-5 text-red-500 bg-red-100 py-2 px-5">
                {{ errorText }}
            </div>
            <div class="name">
                <label for="name">Name<sup class="text-red-500">*</sup></label><br>
                <input class="input p-2 w-full border h-10" id="name" v-model="name" type="text" required >
            </div>
            <div class="email mt-3">
                <label for="email">Email<sup class="text-red-500">*</sup></label><br>
                <input class="input p-2 w-full border h-10" id="email" v-model="email" type="email" required >
            </div>
            <div class="password mt-3">
                <label for="password">Password<sup class="text-red-500">*</sup></label> <br>
                <input class="input w-full p-2 border h-10" id="password" v-model="password" type="password" required >
            </div>
            <div class="my-3 text-sm text-gray-500">Already registered? <router-link class="text-blue-600" to="/login">Login here</router-link></div>
            <div class="submit-btn text-center mt-5">
                <button @click="register" class="bg-blue-700 text-white px-5 py-2 ">Register</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Register",
    data(){
        return {
            error: false,
            errorText: 'The email is already taken',

            name: '',
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
            if(this.name.length === 0){
                this.error = true;
                this.errorText = 'Name must not be empty';
                return true;
            }if(name.length>128){
                this.error = true;
                this.errorText = 'Name is too long';
                return true;
            }
            return false;
        },
        async register(){
            this.error = false;
            this.errorText = '';
            if(!this.errorHappened()){
                try{
                    const resp = await axios.post('/api/register', {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                    });
                    if(resp.data.error){
                        // if the email is already taken
                        this.error = true;
                        this.errorText = 'The email is already taken';
                    }else {
                        // user is successfully registered
                        try{
                            // trying to login the user
                            const resp = await axios.post('/api/login', {
                                email: this.email,
                                password: this.password
                            });
                            // setting the token in localStorage and updating the auth by dispatching the vuex action
                            localStorage.setItem('token', resp.data);
                            axios.defaults.headers.common['Authorization'] = `Bearer ${resp.data}`;

                            await this.$store.dispatch("getCurrentUser");
                            await this.$router.push('/');
                        }catch(e){
                            console.log(e);
                        }
                    }
                }catch(e){
                    console.log(e);
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
