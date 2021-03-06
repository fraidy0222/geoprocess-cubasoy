<template>
  <div>
    <v-data-table
      item-key="name"
      class="elevation-1"
      :search="search"
      no-results-text="No exite este elemento"
      :loading="loading"
      disable-sort
      loading-text="Cargando... Por favor espere"
      :headers="headers"
      :items="users"
      :items-per-page="10"
      :footer-props="{
        'items-per-page-options': [10, 15, 20],
        'items-per-page-text': 'Usuarios por páginas',
      }"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Usuarios</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-dialog persistent v-model="dialog" max-width="500px">
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                <v-icon>mdi-plus</v-icon>
                Añadir
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="headline">{{ formTitle }}</span>
              </v-card-title>
              <v-form v-model="valid" @submit.stop.prevent="save">
                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col cols="12">
                        <v-text-field
                          v-model="editedItem.name"
                          label="Nombre"
                          :rules="[rules.required]"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12">
                        <v-text-field
                          type="email"
                          v-model="editedItem.email"
                          label="Correo"
                          :success-messages="success"
                          :error-messages="error"
                          @blur="checkEmail"
                          :rules="[rules.required, rules.email]"
                          hint="ejemplo.@ejemplo.com"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12">
                        <v-text-field
                          v-model="editedItem.password"
                          label="Contraseña"
                          :rules="[rules.required]"
                          :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                          @click:append="show = !show"
                          :type="show ? 'text' : 'password'"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12">
                        <v-text-field
                          v-model="editedItem.repite_password"
                          label="Repita la contraseña"
                          :rules="[rules.required, passwordMatch]"
                          :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                          @click:append="show1 = !show1"
                          :type="show1 ? 'text' : 'password'"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12">
                        <v-select
                          :items="roles"
                          v-model="editedItem.role"
                          label="Selecione un rol"
                          :rules="[rules.required]"
                          no-data-text="No hay elementos"
                          append-icon="mdi-chevron-down"
                        ></v-select>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="red darken-1" outlined @click="close">
                    Cancelar
                  </v-btn>
                  <v-btn
                    color="primary"
                    :disabled="!valid"
                    type="submit"
                    @click.prevent="save"
                  >
                    Guardar
                  </v-btn>
                </v-card-actions>
              </v-form>
            </v-card>
          </v-dialog>
          <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="headline"
                >¿Estás seguro de borrar este usuario?</v-card-title
              >
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn outlined @click="closeDelete">Cancelar</v-btn>
                <v-btn depressed color="error" @click="deleteItemConfirm"
                  >Borrar</v-btn
                >
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
        <!-- Buscar -->
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Buscar..."
          single-line
          hide-details
          class="mx-4"
        ></v-text-field>
        <!-- end Buscar -->
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        <v-tooltip bottom>
          <template v-slot:activator="{ on, attrs }">
            <v-btn v-bind="attrs" v-on="on" icon>
              <v-icon color="warning" class="mr-2" @click="editItem(item)">
                mdi-pencil
              </v-icon>
            </v-btn>
          </template>
          <span>Editar</span>
        </v-tooltip>
        <v-tooltip bottom>
          <template v-slot:activator="{ on, attrs }">
            <v-btn v-bind="attrs" v-on="on" icon>
              <v-icon color="error" @click="deleteItem(item)">
                mdi-delete
              </v-icon>
            </v-btn>
          </template>
          <span>Eliminar</span>
        </v-tooltip>
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="initialize"> Reinicar </v-btn>
      </template>
    </v-data-table>
    <v-snackbar top v-model="snackbar" :color="snackColor" :timeout="timeout">
      <v-icon
        v-bind:class="[icon ? 'mdi-check-circle' : 'mdi-bell-cancel', 'mdi']"
      ></v-icon>
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
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data: () => ({
    search: "",
    dialog: false,
    loading: false,
    dialogDelete: false,
    text: "",
    snackbar: false,
    snackColor: "",
    timeout: 2000,
    success: "",
    error: "",
    roles: [],
    icon: true,
    show: false,
    show1: false,
    rules: {
      required: (v) => !!v || "Este campo es requerido",
      email: (v) => /.+@.+\..+/.test(v) || "El correo debe ser válido",
    },
    valid: true,
    headers: [
      {
        text: "ID",
        align: "start",
        sortable: false,
        value: "id",
      },
      { text: "Nombre", value: "name" },
      { text: "Rol", value: "role" },
      { text: "Correo", value: "email" },
      { text: "Creado", value: "created_at" },
      { text: "Actualizado", value: "updated_at" },
      { text: "Acciones", value: "actions", sortable: false },
    ],
    users: [],
    editedIndex: -1,
    editedItem: {
      id: "",
      name: "",
      role: "",
      email: "",
      password: "",
      repite_password: "",
      created_at: "",
      updated_at: "",
    },
    defaultItem: {
      id: "",
      name: "",
      role: "",
      email: "",
      password: "",
      repite_password: "",
      created_at: "",
      updated_at: "",
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo Rol" : "Editar Rol";
    },
    passwordMatch() {
      return this.editedItem.password != this.editedItem.repite_password
        ? "Las contraseñas no coinciden"
        : true;
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  created() {
    this.initialize();
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
        .get("/api/user", {})
        .then((res) => {
          this.users = res.data.user;
          this.roles = res.data.roles;
          //console.dir(res.data.user)
        })
        .catch((err) => console.log(err));
    },

    editItem(item) {
      this.editedIndex = this.users.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.users.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      axios
        .delete("/api/user/" + this.editedItem.id)
        .then((res) => {
          this.users.splice(this.editedIndex, 1);
          (this.snackbar = true),
            (this.text = "Usuario eliminado"),
            (this.snackColor = "success");
          this.icon = true;
        })
        .catch((err) => {
          (this.snackbar = true),
            (this.text = "Ha occurido un error"),
            (this.snackColor = "error");
          this.icon = false;
        });
      this.closeDelete();
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    save() {
      if (this.editedIndex > -1) {
        axios
          .put("/api/user/" + this.editedItem.id, this.editedItem)
          .then((res) => {
            this.initialize();
            (this.snackbar = true),
              (this.text = "Usuario editado"),
              (this.snackColor = "success");
            this.icon = true;
          })
          .catch((err) => {
            (this.snackbar = true),
              (this.text = "Ha occurido un error"),
              (this.snackColor = "error");
            this.icon = false;
          });
      } else {
        axios
          .post("/api/user", this.editedItem)
          .then((res) => {
            this.users.push(res.data.user);
            (this.snackbar = true),
              (this.text = "Usuario añadido"),
              (this.snackColor = "success");
            this.icon = true;
          })
          .catch((err) => {
            (this.snackbar = true),
              (this.text = "Ha occurido un error"),
              (this.snackColor = "error");
            this.icon = false;
          });
      }
      this.close();
    },
    checkEmail() {
      if (/.+@.+\..+/.test(this.editedItem.email)) {
        axios
          .post("/api/email/verify", { email: this.editedItem.email })
          .then((res) => {
            this.success = res.data.messages;
            this.error = "";
          })
          .catch((error) => {
            this.success = "";
            this.error = "El correo ya existe";
          });
      }
    },
  },
};
</script>