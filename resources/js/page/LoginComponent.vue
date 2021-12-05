<template>
  <v-row align="center" justify="center" class="mx-4">
    <v-card class="elevation-6 rounded-lg" width="760">
      <v-card-text class="mt-12">
        <v-row>
          <v-col cols="12" sm="6" xs="12">
            <h2 class="text-center">Inicia sesión</h2>
            <v-form
              ref="form"
              v-model="valid"
              lazy-validation
              @submit.prevent="login"
            >
              <v-text-field
                v-model="nameUser"
                required
                label="Usuario"
                name="email"
                outlined
                append-icon="mdi-account-outline"
                type="text"
                class="mt-8"
              ></v-text-field>
              <v-text-field
                v-model="password"
                :rules="[passwordRules.length(6)]"
                required
                id="password"
                label="Contraseña"
                name="password"
                outlined
                append-icon="mdi-lock-outline"
                type="password"
              ></v-text-field>
              <v-btn
                block
                :loading="loading"
                :disabled="!valid"
                color="primary"
                type="submit"
                class="mt-4"
              >
                Iniciar sesión
              </v-btn>
            </v-form>
          </v-col>
          <v-col cols="12" sm="6">
            <img
              class="d-none d-sm-flex"
              :src="myImage"
              alt="Faro"
              width="300"
            />
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
    <v-snackbar v-model="snackbar" color="error" top right>
      <v-icon>mdi-bell-cancel</v-icon>
      {{ text }}
      <template v-slot:action="{ attrs }">
        <v-btn
          color="white"
          text
          v-bind="attrs"
          icon
          dark
          @click="snackbar = false"
        >
          <v-icon>mdi-close-circle</v-icon>
        </v-btn>
      </template>
    </v-snackbar>
  </v-row>
</template>

<script>
export default {
  data: () => ({
    nameUser: "",
    password: "",
    loading: false,
    pregresColor: "",
    snackbar: false,
    text: "",
    valid: true,
    myImage: require("../../assets/img/git.gif"),
    passwordRules: {
      length: (len) => (v) =>
        (v || "").length >= len ||
        `Inválido el tamaño de caracteres, requeridos ${len}`,
      // password: (v) =>
      //   !!(v || "").match(
      //     /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/
      //   ) ||
      //   "La contraseña debe tener letras en mayúsculas, números y carateres especiales como(*#$)",
    },
    // emailRules: [
    //   (v) => !!v || "E-mail is required",
    //   (v) => /.+@.+\..+/.test(v) || "El correo debe ser válido",
    // ],
  }),
  methods: {
    login: function () {
      axios.interceptors.request.use(
        (config) => {
          this.loading = true;
          return config;
        },
        (error) => {
          this.loading = false;
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
        .post("api/login", { name: this.nameUser, password: this.password })
        .then((res) => {
          localStorage.setItem("token", res.data.user.api_token);
          this.$store.commit("login", res.data.user);
          localStorage.setItem("role", res.data.user.role.name);
          if (res.data.user.role.name == "Administrador") {
            this.$router.push("/admin/home");
          } else if (res.data.user.role.name == "Editor") {
            this.$router
              .push("/editor")
              .then((res) => {
                //console.log(res.data.editor);
              })
              .catch((error) => {
                // console.log(error.response)
              });
          }
          else if (res.data.user.role.name == "Usuario UEB") {
            this.$router.push('/usuario_ueb')
          }
        })
        .catch((error) => {
          this.text = error.response.data.status;
          this.snackbar = true;
        });
    },
  },
};
</script>