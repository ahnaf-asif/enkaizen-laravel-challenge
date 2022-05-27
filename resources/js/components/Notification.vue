<template>
  <div class="notification">

  </div>
</template>

<script>
export default {
    name: "Notification",

    async created(){
        window.Echo.channel('image-upload-notification').listen('ImageUploadNotification', (e)=>{
            if(this.$store.getters.auth && e.user_id === this.$store.getters.auth.id)toastr.success(e.msg);
        })
    },
    methods: {
    }
}
</script>

<style scoped>
</style>
