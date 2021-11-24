<template>
  <div>
    <v-data-table
      item-key="id"
      class="elevation-1"
      :search="search"
      disable-sort
      no-results-text="No exite este elemento"
      :loading="loading"
      loading-text="Cargando... Por favor espere"
      :headers="headers"
      :items="uebs"
      :items-per-page="10"
      :footer-props="{
        'items-per-page-options': [10, 15, 20],
        'items-per-page-text': 'Ueb por páginas',
      }"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>UEB</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="600px" persistent>
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                <v-icon>mdi-plus</v-icon>
                Añadir
              </v-btn>
            </template>
            <v-form ref="form" v-model="valid" @submit.prevent="save">
              <v-card>
                <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
                </v-card-title>
                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col cols="12">
                        <v-text-field
                          v-model="editedItem.name"
                          label="Nombre"
                          required
                          :rules="Rules"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                 <v-btn 
                    color="red darken-1" 
                    outlined
                    @click="close">
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
              </v-card>
            </v-form>
          </v-dialog>
          <v-dialog persistent v-model="dialogDelete" max-width="500px">
            <v-card >
              <v-card-title class="headline"
                >¿Estás seguro de borrar esta UEB?</v-card-title
              >
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn outlined  @click="closeDelete">Cancelar</v-btn>
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
        <v-btn color="primary" @click="initialize"> Reiniciar </v-btn>
      </template>
    </v-data-table>
    <v-snackbar top v-model="snackbar" :color="snackColor" :timeout="timeout">
       <v-icon v-bind:class="[icon ? 'mdi-check-circle' : 'mdi-bell-cancel', 'mdi']"></v-icon> {{ text }}
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

export default {
  data: () => ({
    valid: true,
    search: "",
    dialog: false,
    loading: false,
    dialogDelete: false,
    text: "",
    snackbar: false,
    snackColor: "",
    timeout: 2000,
    icon: true,
    modal: false,
    date: new Date().toISOString().substr(0, 10),
    headers: [
      {
        text: "ID",
        align: "start",
        sortable: false,
        value: "id",
      },
      { text: "Nombre", value: "name" },
      { text: "Creada", value: "created_at" },
      { text: "Actualizda", value: "updated_at" },
      { text: "Acciones", value: "actions", sortable: false },
    ],
    uebs: [],
    editedIndex: -1,
    Rules: [(v) => !!v || "Este campo es requerido"],
    editedItem: {
      id: "",
      name: "",     
    },
    defaultItem: {
      id: "",
      name: "",
    },
  }),
  computed: {
    formTitle() {
      return this.editedIndex === -1
        ? "Nueva UEB"
        : "Editar UEB";
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
        .get("/api/ueb", {})
        .then((res) => {
          this.uebs = res.data.ueb;
        })
        .catch((err) => {
          if (err.response.status == 401) {
            localStorage.removeItem("token");
            this.$router.push("/login");
          }
        });
    },

    editItem(item) {
      this.editedIndex = this.uebs.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.uebs.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      axios
        .delete("/api/ueb/" + this.editedItem.id)
        .then((res) => {
          this.uebs.splice(this.editedIndex, 1);
          this.snackbar = true,
          this.text = "UEB eliminada",
          this.snackColor = "success";
          this.icon = true
        })
        .catch((err) => {
          this.snackbar = true,
          this.text = "Ha occurido un error",
          this.snackColor = "error";
          this.icon = false
          //console.log(err.response);
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
          .put("/api/ueb/" + this.editedItem.id, {
            name: this.editedItem.name,
          })
          .then((res) => {
            this.initialize();
            this.snackbar = true,
            this.text = "UEB editada",
            this.snackColor = "success";
            this.icon = true
          })
          .catch((err) => {
            this.snackbar = true,
            this.text = "Ha occurido un error",
            this.snackColor = "error";
            this.icon = false
          });
      } else {
        axios
          .post("/api/ueb", {
            name: this.editedItem.name,
          })
          .then((res) => {
            console.log(res)
            this.uebs.push(res.data.ueb);
            this.snackbar = true,
             this.text = "UEB añadida",
            this.snackColor = "success";
            this.icon = true
          })
          .catch((err) => {
            this.snackbar = true,
            this.text = "Ha occurido un error",
            this.snackColor = "error";
            this.icon = false
            //console.log(err.response);
          });
      }
      this.close();
    },
  },
};
</script>