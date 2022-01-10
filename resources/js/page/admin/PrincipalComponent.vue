<template>
 <div>
  <v-row class="mb-3">
      <v-col>
        <v-card class="mx-auto" :loading="loading">
          <template slot="progress">
            <v-progress-linear
              color="primary"
              indeterminate
            ></v-progress-linear>
          </template>
          <v-list>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>Roles</v-list-item-title>
              </v-list-item-content>

              <v-list-item-icon>
                <h2 class="text-h6">{{ roles }}</h2>
              </v-list-item-icon>
            </v-list-item>
          </v-list>
        </v-card>
      </v-col>
      <v-col>
        <v-card class="mx-auto" :loading="loading">
          <template slot="progress">
            <v-progress-linear
              color="primary"
              indeterminate
            ></v-progress-linear>
          </template>
          <v-list>
            <v-list-item >
              <v-list-item-content>
                <v-list-item-title>Usuarios</v-list-item-title>
              </v-list-item-content>

              <v-list-item-icon>
                 <h2 class="text-h6">{{ users }}</h2>
              </v-list-item-icon>
            </v-list-item>
          </v-list>
        </v-card>
      </v-col>
  </v-row>
  <v-row justify="center" align="center">
    <v-img 
    :src="myImage"
    max-height="550"
    max-width="750"
    ></v-img>
  </v-row>
 </div>
</template>

<script>
export default {
   data: () => ({
     roles: [],
     users: [],
     loading: false,
     myImage: require("../../../assets/img/dashboard.svg"),
   }),

  created () {
    // // Leer la información de estado en sessionStorage cuando se carga la página
    // if (localStorage.getItem("role") ) {
    //     this.$store.replaceState(Object.assign({}, this.$store.state,JSON.parse(sessionStorage.getItem("role"))))
    // } 
 
    //      // Guarde la información en vuex en sessionStorage cuando se actualice la página
    // window.addEventListener("beforeunload",()=>{
    //     sessionStorage.setItem("store",JSON.stringify(this.$store.state))
    // })
    this.initialize()
  },
   methods: {
      initialize() {
      axios.interceptors.request.use(
        (config) => {
          this.loading = true;
          return config;
        },
        (error) => {
          // Do something with request error
          return Promise.reject(error);
        }
      );

      // Add a response interceptor
      axios.interceptors.response.use(
        (response) => {
          this.loading = false;
          return response;
        },
        (error) => {
          this.loading = false;
          return Promise.reject(error);
        }
      );
      axios
        .get("/api/admin", {})
        .then((res) => {
          this.roles = res.data.roles;
          this.users = res.data.users;
        })
        .catch((err) => {
          if (err.response.status == 401) {
            localStorage.removeItem("token");
            this.$router.push("/login");
          }
        });
    },
   }
}
</script>