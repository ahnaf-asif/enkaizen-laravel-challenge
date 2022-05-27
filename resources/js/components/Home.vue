<template>
    <div class="">
        <h1 class="text-4xl text-center font-bold mt-10">Image Uploader</h1>
        <p v-if="$store.getters.auth" class="mb-10 text-center">Welcome, {{ $store.getters.auth.name }}</p>
        <hr>

        <div  v-if="$store.getters.auth" class="image-section px-5 py-5 ">
            <div class="new-image-btn">
                <button class="text-white bg-blue-700 py-2 px-5"><router-link to="/image/upload">Add new Image</router-link></button>
            </div>
            <div class="images mt-10">
                <div v-for="img in uploadedImages" class="individual-image">
                    <img :key="img.id" :src="img.url" alt="something">
                </div>
            </div>
        </div>
        <p v-else class="text-center text-gray-500 text-lg my-10">Please <router-link class="text-blue-600" to="/login">Login</router-link> to view and upload images</p>

    </div>
</template>

<script>
    export default {
        name : "Home",
        components: {

        },
        data(){
            return {
                uploadedImages: [],
                user: null,
            }
        },
        async created(){
            await this.getImages();
            window.Echo.channel('image-upload-notification').listen('ImageUploadNotification', async (e)=>{
                if(this.$store.getters.auth && e.user_id===this.$store.getters.auth.id){
                    await this.getImages();
                }
            });
            if(localStorage.getItem('token')){
                await this.$store.dispatch("getCurrentUser");
            }
        },
        methods: {
            async getImages(){
                try{
                    const resp = await axios.get('/api/images');
                    this.uploadedImages = resp.data;
                }catch(e){
                    console.log('images not found');
                }
            }
        }
    }
</script>

<style scoped>
.images{
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 30px;
}
.image-section{
    width: 80%;
    margin: auto;
}
.individual-image{
    width: 31%;
}

@media(max-width: 760px){
    .images{
        justify-content: space-around;
    }
    .image-section{
        width: 100%;
        margin: auto;
    }
    .individual-image{
        width: 90%;
    }
}
</style>
