<template>
    <div class="image-upload">
        <h1 class="text-center text-4xl my-10 font-bold">Upload an image</h1>
        <div class="w-96 m-auto">
            <div v-if="notification" class="error-text my-5 text-green-700 bg-green-100 py-2 px-5">
                {{ notificationText }}
            </div>
            <div class="url">
                <label for="url">Image Url<sup class="text-red-500">*</sup></label><br>
                <input class="input p-2 w-full border h-10" id="url" v-model="url" type="text" required >
            </div>
            <div class="submit my-5 text-center">
                <button @click="uploadImage" class="bg-blue-700 text-white px-5 py-2 ">Upload</button>
            </div>
            <img :src="url"/>
        </div>
    </div>
</template>

<script>
export default {
    name: "ImageUpload",
    data(){
        return {
            url: '',
            user: '',
            notification: false,
            notificationText: '',
        }
    },
    async created(){
        if(!localStorage.getItem('token')){
            return this.$router.push({name: 'login'})
        }
        else{
            try{
              // getting the current user
                axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
                const getUser = await axios.get('/api/user');
                this.user = getUser.data;
            }catch (e) {
                console.log('user not found');
            }
        }
    },
    methods: {
        async uploadImage(){
            this.notification = false;
            this.notificationText = null;

            try{
                const resp = await axios.post('/api/images/upload', {
                    url: this.url,
                    user_id: this.user.id,
                });
                this.notification = true;
                this.notificationText = resp.data.msg;
                // console.log(resp);
            }catch(e){
                console.log('error')
            }
        }
    }
}
</script>

<style scoped>
.input{
    outline: none;
}
</style>
