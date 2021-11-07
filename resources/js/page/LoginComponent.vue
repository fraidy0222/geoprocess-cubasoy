<template>
  <v-row align="center" justify="center" class="mx-4">
    <v-card class="elevation-6 rounded-lg" width="500">
      <v-card-text class="mt-12">
        <h2 class="text-center">Inicia sesión con tu cuenta</h2>
        <h4 class="text-center grey--text mt-10">
          <v-avatar size="72">
            <img :src="myImage" alt="Faro" />
          </v-avatar>
        </h4>
        <v-form
          ref="form"
          v-model="valid"
          lazy-validation
          @submit.prevent="login"
        >
          <v-text-field
            v-model="email"
            :rules="emailRules"
            required
            label="Correo"
            name="email"
            outlined
            append-icon="mdi-email-outline"
            type="email"
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
      </v-card-text>
    </v-card>
    <v-snackbar v-model="snackbar" color="error">
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
  props: {
    source: String,
  },
  data: () => ({
    email: "",
    password: "",
    loading: false,
    pregresColor: "",
    snackbar: false,
    text: "",
    valid: true,
    myImage: require("../../assets/img/faro.svg"),
    passwordRules: {
      length: (len) => (v) =>
        (v || "").length >= len ||
        `Inválido el tamaño de caracteres, requeridos ${len}`,
      password: (v) =>
        !!(v || "").match(
          /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/
        ) ||
        "La contraseña debe tener letras en mayúsculas, números y carateres especiales como(*#$)",
    },
    emailRules: [
      (v) => !!v || "E-mail is required",
      (v) => /.+@.+\..+/.test(v) || "El correo debe ser válido",
    ],
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
        .post("api/login", { email: this.email, password: this.password })
        .then((res) => {
          localStorage.setItem("token", res.data.token);
          if (res.data.isAdmin) {
            this.$router.push("/admin");
          }
          if (res.data.editor) {
            this.$router
              .push("/test")
              .then((res) => {
                console.log(res.data.editor);
              })
              .catch((error) => {
                // console.log(error.response)
              });
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