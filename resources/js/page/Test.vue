<template>
 <div>
    <h1>Role Editor</h1>
    <v-btn   
    outlined
    color="blue"
    @click="logout">
    Cerrar Sesión
  </v-btn>
 </div>
</template>

<script>
export default {
  methods: {
    logout: function () {
      localStorage.removeItem('token')
      this.$router.push('/login')
    },
  }
}
</script>