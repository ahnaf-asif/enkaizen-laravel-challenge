<template>
  <div class="notification">
      <div class="notification-body px-5 py-3 bg-green-700 text-white">
          Your Image have been uploaded
      </div>
  </div>
</template>

<script>
export default {
    name: "Notification",
    data(){
        return {
            socketId: null,
        }
    },
    created(){
        window.Echo.connector.pusher.connection.bind('connected', function () {
            this.socketId = window.Echo.socketId();
            console.log(this.socketId)
        });
        window.Echo.channel('image-upload-notification').listen('ImageUploadNotification', (e)=>{
            console.log(e);
        })
    }
}
</script>

<style scoped>
.notification-body{
    position: absolute;
    bottom: 10px;
    right: 10px;
    opacity: 0;
    animation: animation 1s ease-in-out forwards;
}

@keyframes animation-up {
    from{
        opacity: 0;
    }
    to{
        opacity: 1;
    }
}

</style>
