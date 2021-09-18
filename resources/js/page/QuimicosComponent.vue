<template>
  <div>
    <v-row>
      <v-col cols="12" xs="4" sm="4">
        <v-chip class="ma-2" color="primary" text-color="white">
         C/C: {{ rowTotal("cc") }}
        </v-chip>
      </v-col>
      <v-col cols="12" xs="4" sm="4">
        <v-chip class="ma-2" color="primary" text-color="white">
         Área Aplicada: {{ rowTotal("area_aplicada") }}
        </v-chip>
      </v-col>
      <v-col cols="12" xs="4" sm="4">
        <v-chip class="ma-2" color="primary" text-color="white">
          Área Acum: {{ rowTotal("area_acum") }}
        </v-chip>
      </v-col>
    </v-row>
    <v-data-table
      item-key="name"
      class="elevation-1"
      :search="search"
      no-results-text="No exite este elemento"
      :loading="loading"
      disable-sort
      loading-text="Cargando... Por favor espere"
      :items="quimicos"
      :headers="headers"
      :items-per-page="10"
      :footer-props="{
        'items-per-page-options': [10, 15, 20],
        'items-per-page-text': 'Usuarios por páginas',
      }"
    >
    
    <template
        v-slot:[`item.comienza`]="{ item }"
      >
        {{ item.comienza }} - {{ item.termina }} am
      </template>

      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Químicos</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-dialog persistent v-model="dialog" max-width="1000px">
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
                 <v-row>
                      <v-col cols="6">
                        <v-select
                          :items=ueb
                          v-model="editedItem.ueb"
                          label="UEB"
                          :rules="[rules.required]"
                          no-data-text="No hay elementos"
                          append-icon="mdi-chevron-down"
                        ></v-select>
                      </v-col>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.tipo_aplicacion"
                          label="Tipo Aplicacioón"
                          :rules="[rules.required]"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.tipo_producto"
                          label="Tipo Producto"
                          :rules="[rules.required]"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.cc"
                          label="C/C"
                          :rules="[rules.required]"
                        ></v-text-field>
                      </v-col>
                       <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.area_aplicada"
                          label="Área aplicada"
                          :rules="[rules.required]"
                        ></v-text-field>
                      </v-col>
                        <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.area_acum"
                          label="Área acumulada"
                          :rules="[rules.required]"
                        ></v-text-field>
                      </v-col>
                       <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.cant"
                          label="Cantidad"
                          :rules="[rules.required]"
                        ></v-text-field>
                      </v-col>
                       <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.cant_equipos"
                          label="Cantidad Equipos"
                          :rules="[rules.required]"
                        ></v-text-field>
                      </v-col>
                      <v-col>
                        <v-time-picker
                          v-model="editedItem.comienza"
                          full-width
                          use-seconds
                        ></v-time-picker>
                      </v-col>
                      <v-col>
                        <v-time-picker
                          v-model="editedItem.termina"
                          full-width
                          use-seconds
                        ></v-time-picker>
                      </v-col>
                    </v-row>
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
                    @click.prevent="save"
                  >
                    Guardar
                  </v-btn>
                </v-card-actions>
              </v-form>
            </v-card>
          </v-dialog>
          <v-dialog persistent v-model="dialogDelete" max-width="500px">
            <v-card color="error" dark>
              <v-card-title class="headline"
                >¿Estás seguro de borrar este químico?</v-card-title
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
  props: {
    spaces: {
      type: Number,
      default: 2
    }
  },
  data: () => ({
    search: "",
    dialog: false,
    loading: false,
    dialogDelete: false,
    text: "",
    snackbar: false,
    snackColor: "",
    timeout: 2000,
    ueb: [],
    rules: {
      required: (v) => !!v || "Este campo es requerido",
    },
    valid: true,
    headers: [
      {
        text: "Granja Productora",
        align: "start",
        sortable: false,
        value: "ueb",
      },
      { text: "C/C", value: "cc" },
      { text: "Área Aplicada", value: "area_aplicada" },
      { text: "Áreac Acum", value: "area_acum" },
      { text: "Tipo Aplicacion", value: "tipo_aplicacion" },
      { text: "Tipo Producto", value: "tipo_producto" },
      { text: "Cant", value: "cant" },
      { text: "Comienza", value: "comienza" },
      { text: "Cantidad de Equipos", value: "cant_equipos" },
      { text: "Acciones", value: "actions", sortable: false },
    ],
    quimicos: [],
    editedIndex: -1,
    editedItem: {
      cc: "",
      area_aplicada: "",
      area_acum: "",
      tipo_aplicacion: "",
      tipo_producto: "",
      cant: '',
      ueb: "",
      termina: "",
      comienza: "",
    },
    defaultItem: {
      cc: "",
      area_aplicada: "",
      area_acum: "",
      tipo_aplicacion: "",
      tipo_producto: "",
      cant: '',
      ueb: "",
      termina: "",
      comienza: "",
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo Químico" : "Editar Químico";
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
        .get("api/quimicos", {})
        .then((res) => {
          this.quimicos = res.data.quimicos;
          this.ueb = res.data.uebs
          console.log(res.data.quimicos)
        })
        .catch((err) => console.log(err));
    },

    editItem(item) {
      this.editedIndex = this.quimicos.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.quimicos.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      axios
        .delete("api/quimicos/" + this.editedItem.id)
        .then((res) => {
          this.quimicos.splice(this.editedIndex, 1);
          this.snackbar = true,
          this.text = "Químico eliminado",
          this.snackColor = "success";
        })
        .catch((err) => {
          this.snackbar = true,
          this.text = "Ha occurido un error",
          this.snackColor = "error";
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
          .put("api/quimicos/" + this.editedItem.id, this.editedItem)
          .then(res => {
            this.initialize();
            this.snackbar = true,
            this.text = "Químico editado",
             this.snackColor = "success";
          })
          .catch(err => {
            this.snackbar = true,
            this.text = "Ha occurido un error",
            this.snackColor = "error";
           
          });
      } else {
        axios
          .post("api/quimicos", this.editedItem)
          .then(res => {
            console.dir(res)
            this.quimicos.push(res.data.quimicos);
            this.snackbar = true,
            this.text = "Químico añadido",
            this.snackColor = "success";
          })
          .catch(err => {
            this.snackbar = true,
            this.text = "Ha occurido un error",
            this.snackColor = "error";
          });
      }
      this.close();
    },
    rowTotal(base) {
      return this.quimicos.reduce((sum, cur) => (sum += cur[base]), 0);
    },
  },
};
</script>