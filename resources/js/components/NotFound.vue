<template>
    <div class="">
        <div class="content" style="height: 90vh;display:flex;justify-content:center;align-items: center">
            <div class="404 text-center">
                <h1 class="text-6xl text-center my-10">404 Page Not Found</h1>
                <p class="text-center">Please go back to <router-link  to="/"><span class="text-blue-600">Home Page</span></router-link></p>
            </div>
        </div>
    </div>
</template>

<script>


export default {
    name: "NotFound",

}
</script>

<style scoped>

</style>
