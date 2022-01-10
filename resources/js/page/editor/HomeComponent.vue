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
                <v-list-item-title>UEB</v-list-item-title>
              </v-list-item-content>

              <v-list-item-icon>
                <h2 class="text-h6">{{ uebs }}</h2>
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
                <v-list-item-title>Toneladas</v-list-item-title>
              </v-list-item-content>

              <v-list-item-icon>
                 <h2 class="text-h6">{{ toneladas }}</h2>
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
                <v-list-item-title>Valores</v-list-item-title>
              </v-list-item-content>

              <v-list-item-icon>
                 <h2 class="text-h6">{{ valores }}</h2>
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
     uebs: [],
     toneladas: [],
     valores: [],
     loading: false,
     myImage: require("../../../assets/img/dashboard.svg"),
   }),

  created() {
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
        .get("/api/editor", {})
        .then((res) => {
          this.uebs = res.data.uebs;
          this.toneladas = res.data.toneladas;
          this.valores = res.data.valores;
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