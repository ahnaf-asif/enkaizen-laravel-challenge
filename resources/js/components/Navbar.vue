<template>
  <nav class="flex bg-slate-600 text-white items-center justify-between py-2 px-5">
      <div class="home text-xl font-bold">
          <router-link to="/">Home</router-link>
      </div>
      <ul v-if="this.$store.getters.auth" class="navbar flex gap-4">
          <li>
              <span class="cursor-pointer" @click="logout">Logout</span>
          </li>
      </ul>
      <ul v-else class="navbar flex gap-4">
          <li>
              <router-link to="/login">Login</router-link>
          </li>
          <li>
              <router-link to="/register">Register</router-link>
          </li>
      </ul>
  </nav>
</template>

<script>
export default {
    name: "Navbar",

    async created(){
        axios.defaults.headers.common['Authorization'] = `Bearer ${this.authToken}`;
    },
    methods: {
        async logout(){

            await axios.post('/api/logout');

            localStorage.removeItem('token');

            await this.$store.dispatch("getCurrentUser");

            if(this.$router.currentRoute.path !== '/'){
                await this.$router.push('/');
            }
        }
    }
}
</script>

<style scoped>

</style>
