<template>
    <div class="">
        <h1 class="text-4xl text-center font-bold mt-10">Image Uploader</h1>
        <p v-if="user" class="mb-10 text-center">Welcome, {{ user.name }}</p>
        <hr>

        <div  v-if="authToken" class="image-section px-5 py-5 ">
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
                authToken: null,
                uploadedImages: [],
                user: null,
            }
        },
        async created(){
            this.authToken = localStorage.getItem('token');
            if(this.authToken){

                try{
                    // getting the current user
                    const getUser = await axios.get('/api/user');
                    this.user = getUser.data;
                }catch (e) {
                    console.log('user not found');
                }

                try{
                    // getting user's uploaded images
                    const resp = await axios.get('/api/images');
                    // console.log(resp);
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
