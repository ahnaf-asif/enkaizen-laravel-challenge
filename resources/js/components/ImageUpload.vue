<template>
    <div class="image-upload">
        <h1 class="text-center text-4xl my-10 font-bold">Upload an image</h1>
        <div class="w-96 m-auto">
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
        }
    },
    async created(){
        if(localStorage.getItem('token')){
            await this.$store.dispatch("getCurrentUser");
        }
        if(!this.$store.getters.auth){
            return this.$router.push({name: 'login'})
        }
    },
    methods: {
        async uploadImage(){
            try{
                const resp = await axios.post('/api/images/upload', {
                    url: this.url,
                    user_id: this.$store.getters.auth.id,
                });
                toastr.warning(resp.data.msg);
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
