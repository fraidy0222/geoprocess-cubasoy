<template>
  <div>
    <v-row>
      <v-col cols="12" sm="3">
        <v-chip class="ma-2" color="primary" text-color="white">
          Máquinas de riego: {{ rowTotal("total_maquinas_riego") }}
          <v-icon right> mdi-gauge-full </v-icon>
        </v-chip>
      </v-col>
      <v-col cols="12" sm="3">
        <v-chip class="ma-2" color="success" text-color="white">
          Máquinas Listas: {{ rowTotal("maquinas_listas") }}
          <v-icon right> mdi-checkbox-marked-circle </v-icon>
        </v-chip>
      </v-col>
      <v-col cols="12" sm="3">
        <v-chip class="ma-2" color="error" text-color="white">
          Máquinas Rotas: {{ rotas("maquinas_rotas") }}
          <v-icon right> mdi-close-circle </v-icon>
        </v-chip>
      </v-col>
      <v-col cols="12" sm="3">
        <v-chip class="ma-2" color="warning" text-color="white">
          Fecha: {{ this.date }}
          <v-icon right> mdi-clock </v-icon>
        </v-chip>
      </v-col>
    </v-row>
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
      <template v-slot:[`item.maquinas_listas`]="{ item }">
        <v-chip color="success" dark>
          {{ item.maquinas_listas }}
        </v-chip>
      </template>
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
                      <v-col cols="12" md="6" sm="4">
                        <v-text-field
                          v-model="editedItem.name"
                          label="Nombre"
                          required
                          :rules="Rules"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" md="6" sm="4">
                        <v-text-field
                          v-model="editedItem.total_maquinas_riego"
                          label="Máquinas de Riego"
                          required
                          :rules="Rules"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" md="6" sm="4">
                        <v-text-field
                          v-model="editedItem.maquinas_listas"
                          label="Máquinas listas"
                          required
                          :rules="Rules"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" md="6" sm="4">
                        <v-textarea
                          v-model="editedItem.afectaciones"
                          auto-grow
                          label="Afectaciones"
                          required
                          :rules="Rules"
                          rows="1"
                        ></v-textarea>
                      </v-col>
                      <v-col cols="12" md="6" sm="4">
                        <v-autocomplete
                          v-model="editedItem.maquinas_rotas"
                          :items="options"
                          chips
                          clearable
                          multiple
                          item-text="name"
                          label="Máquinas rotas"
                          append-icon="mdi-chevron-down"
                        >
                          <template
                            v-slot:selection="{ attr, on, item, selected }"
                          >
                            <v-chip
                              v-bind="attr"
                              :input-value="selected"
                              color="red"
                              class="white--text"
                              v-on="on"
                            >
                              <span>{{ item }}</span>
                            </v-chip>
                          </template>
                        </v-autocomplete>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="close">
                    Cancelar
                  </v-btn>
                  <v-btn
                    color="blue darken-1"
                    text
                    type="submit"
                    :disabled="!valid"
                  >
                    Guardar
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-form>
          </v-dialog>
          <v-dialog persistent v-model="dialogDelete" max-width="500px">
            <v-card color="error" dark>
              <v-card-title class="headline"
                >¿Estás seguro de borrar esta UEB?</v-card-title
              >
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="dark" text @click="closeDelete">Cancelar</v-btn>
                <v-btn color="dark" text @click="deleteItemConfirm"
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
    options: [],
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
      { text: "Máquinas de Riego", value: "total_maquinas_riego" },
      { text: "Listas", value: "maquinas_listas" },
      { text: "Rotas", value: "maquinas_rotas" },
      { text: "Afectaciones", value: "afectaciones" },
      { text: "Acciones", value: "actions", sortable: false },
    ],
    uebs: [],
    editedIndex: -1,
    Rules: [(v) => !!v || "Este campo es requerido"],
    editedItem: {
      id: "",
      name: "",
      total_maquinas_riego: "",
      maquinas_listas: "",
      maquinas_rotas: "",
      afectaciones: "",
    },
    defaultItem: {
      id: "",
      name: "",
      total_maquinas_riego: "",
      maquinas_listas: "",
      maquinas_rotas: "",
    },
  }),
  computed: {
    formTitle() {
      return this.editedIndex === -1
        ? "Nueva Máquina de Riego"
        : "Editar Máquina de Riego";
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
    this.listado();
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
        .get("api/ueb", {})
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
        .delete("api/ueb/" + this.editedItem.id)
        .then((res) => {
          this.uebs.splice(this.editedIndex, 1);
          (this.snackbar = true),
            (this.text = "UEB eliminada"),
            (this.snackColor = "success");
        })
        .catch((err) => {
          (this.snackbar = true),
            (this.text = "Ha occurido un error"),
            (this.snackColor = "error");
          console.log(err.response);
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
          .put("api/ueb/" + this.editedItem.id, {
            name: this.editedItem.name,
            total_maquinas_riego: this.editedItem.total_maquinas_riego,
            maquinas_listas: this.editedItem.maquinas_listas,
            maquinas_rotas: this.editedItem.maquinas_rotas,
            afectaciones: this.editedItem.afectaciones,
          })
          .then((res) => {
            this.initialize();
            this.snackbar = true,
            this.text = "UEB editada",
            this.snackColor = "success";
          })
          .catch((err) => {
            this.snackbar = true,
            this.text = "Ha occurido un error",
            this.snackColor = "error";
          });
      } else {
        axios
          .post("api/ueb", {
            name: this.editedItem.name,
            total_maquinas_riego: this.editedItem.total_maquinas_riego,
            maquinas_listas: this.editedItem.maquinas_listas,
            maquinas_rotas: this.editedItem.maquinas_rotas,
            afectaciones: this.editedItem.afectaciones,
          })
          .then((res) => {
            this.uebs.push(res.data.ueb);
            (this.snackbar = true),
              (this.text = "UEB añadida"),
              (this.snackColor = "success");
          })
          .catch((err) => {
            (this.snackbar = true),
              (this.text = "Ha occurido un error"),
              (this.snackColor = "error");
            console.log(err.response);
          });
      }
      this.close();
    },
    listado() {
      for (let index = 0; index < 1000; index++) {
        this.options.push(`${index}`);
      }
    },
    rowTotal(base) {
      return this.uebs.reduce((sum, cur) => (sum += cur[base]), 0);
    },
    rotas(base) {
      return this.uebs.reduce((sum, cur) => (sum += cur[base].length), 0);
    },
  },
};
</script>