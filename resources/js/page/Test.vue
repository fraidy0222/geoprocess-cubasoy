<template>
  <div>
    <v-form id="formData"  @submit.prevent='document'>
      <v-container>
        <v-row>
          <v-col cols="12" md="4">
            <v-text-field
              v-model="name"
              label="Name"
              name="name"
            ></v-text-field>
          </v-col>
        </v-row>
      </v-container>
      <v-btn :disabled="isDisable" type="submit">Submit</v-btn>
    </v-form>
    <!-- <form id="formData" enctype="multipart/form-data" @submit.prevent="document">
      <input type="text" v-model="name" name="name" placeholder="Name">
      <button type="submit">Save</button>
    </form> -->
    <h1>Role Editor</h1>
    <v-btn outlined color="blue" @click="logout"> Cerrar Sesión </v-btn>
  </div>
</template>

<script>
export default {
  data: () => ({
    name: "",
    isDisable: false
  }),

  methods: {
    logout: function () {
      localStorage.removeItem("token");
      this.$router.push("/login");
    },

    document() {
      var vm = this
      var formdata = new FormData(document.getElementById('formData'));

      vm.isDisable = true

      axios.post('api/document', formdata, {responseType: 'blob'})
      .then(function(response) {
        var headers = response.headers
        console.log(headers)
        var blob = new Blob([response.data], {type: headers['content-type']});
        var link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = vm.name;
        link.click();
        link.remove()
        vm.isDisable = false
      })
      .catch(error => {
        if(error) {
          vm.isDisable = false
        }
      })
    }
  },
};
</script>