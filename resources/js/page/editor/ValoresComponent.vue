<template>
  <div>
     <v-row class="mb-3">
      <v-col>
        <v-card class="mx-auto" :loading="loading">
          <template slot="progress">
            <v-progress-linear
              indeterminate
              color="primary"
            ></v-progress-linear>
          </template>

          <v-list>
            <v-list-item v-for="(c, index) in c" :key="index">
              <v-list-item-content>
                <v-list-item-title class="text-">Ventas Diarias en CUP</v-list-item-title>
              </v-list-item-content>

              <v-list-item-icon>
                <h2>{{ c.diaria }}</h2>
              </v-list-item-icon>
            </v-list-item>
          </v-list>
        </v-card>
      </v-col>
      <v-col>
        <v-card class="mx-auto" :loading="loading">
          <template slot="progress">
            <v-progress-linear
              indeterminate
              color="primary"
            ></v-progress-linear>
          </template>

          <v-list>
            <v-list-item v-for="(c, index) in c" :key="index">
              <v-list-item-content>
                <v-list-item-title class="text-">Ventas Diarias en CUP</v-list-item-title>
              </v-list-item-content>

              <v-list-item-icon>
                <h2>{{ c.acumu }}</h2>
              </v-list-item-icon>
            </v-list-item>
          </v-list>
        </v-card>
      </v-col>
    </v-row>
    <v-data-table
      item-key="id"
      class="elevation-1"
      disable-sort
      :search="search"
      no-results-text="No exite este elemento"
      :loading="loading"
      loading-text="Cargando... Por favor espere"
      :headers="headers"
      :items="valores"
      :items-per-page="10"
      :footer-props="{
        'items-per-page-options': [10, 15, 20],
        'items-per-page-text': 'Valores por páginas',
      }"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Valores</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-dialog persistent v-model="dialog" max-width="600px">
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                <v-icon>mdi-plus</v-icon>
                Añadir
              </v-btn>
               <!-- <v-btn @click="renderDoc" color="success" dark class="mb-2 mr-2">
                Exportar a Word
              </v-btn> -->
            </template>
            <v-card>
              <v-card-title>
                <span class="headline">{{ formTitle }}</span>
              </v-card-title>
              <v-form v-model="valid" @submit.stop.prevent="save">
                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.venta_diaria_cup"
                          label="Ventas diarias en cup"
                          :rules="[rules.required, rules.length]"
                          type="number"
                          min="0"
                          required
                          counter="6"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.venta_mes_cup"
                          label="Ventas del mes en cup"
                          :rules="[rules.required, rules.length]"
                          type="number"
                          min="0"
                          required
                          counter="6"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.acumulado"
                          label="Acumulado hasta la fecha"
                          :rules="[rules.required, rules.length]"
                          required
                          counter="6"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6">
                        <v-select
                          :items="cultivos"
                          v-model="editedItem.cultivo"
                          label="Selecione un cultivo"
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
              </v-form>
            </v-card>
          </v-dialog>
          <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="headline"
                >¿Estás seguro de borrar esta ausencia?</v-card-title
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
      <v-icon v-bind:class="[icon ? 'mdi-check-circle' : 'mdi-bell-cancel', 'mdi']"></v-icon>  {{ text }}
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
// docxtemplater
import Docxtemplater from "docxtemplater";
import PizZip from "pizzip";
import PizZipUtils from "pizzip/utils/index.js";

import {saveAs} from 'file-saver';  
export default {
  props: {
    number: {
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
    cultivos: [],
    icon: true,
    valid: true,
    c: [],
    acumu: [],
    date: new Date().toISOString().substr(0, 10),
    rules: {
      required: (v) => !!v || "Este campo es requerido",
      length: v => v.length <= 6 || 'El número tiene que ser menor de 6 dígitos',
    },
    headers: [
      {
        text: "#",
        align: "start",
        value: "id",
      },
      { text: "Cultivo", value: "cultivo"},
      { text: "Venta Diaria CUP", value: "venta_diaria_cup" },
      { text: "Venta del Mes CUP", value: "venta_mes_cup" },
      { text: "Acumulado fecha CUP", value: "acumulado" },
      { text: "Acciones", value: "actions", sortable: false },
    ],
    valores: [],
    editedIndex: -1,
    editedItem: {
      id: "",
      cultivo: "",
      venta_diaria_cup: "",
      venta_mes_cup: "",
      acumulado: "",
    },
    defaultItem: {
      id: "",
      cultivo: "",
      venta_diaria_cup: "",
      venta_mes_cup: "",
      acumulado: "",
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo valores" : "Editar valores";
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
        .get("/api/valores")
        .then((res) => {
          this.valores = res.data.valores;
          this.cultivos = res.data.cultivos;
          this.c = res.data.count;
          //console.log(res.data.count)
        })
        .catch((err) => console.log(err));
    },

    editItem(item) {
      this.editedIndex = this.valores.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.valores.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      axios
        .delete("/api/valores/" + this.editedItem.id)
        .then(res => {
          this.valores.splice(this.editedIndex, 1);
          this.snackbar = true,
          this.text = "Valores eliminada",
          this.snackColor = "success";
          this.icon = true
          this.initialize()
        })
        .catch(err => {
          this.snackbar = true,
          this.text = "Ha occurido un error",
          this.snackColor = "error";
          this.icon = false
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
          .put("/api/valores/" + this.editedItem.id, this.editedItem)
          .then((res) => {
            this.initialize();
            this.snackbar = true,
            this.text = "Valores editada",
            this.snackColor = "success";
            this.icon = true
            this.initialize()
          })
          .catch((err) => {
            this.snackbar = true,
            this.text = "Ha occurido un error",
            this.snackColor = "error";
            this.icon = false
          });
      } else {
        axios
          .post("/api/valores", this.editedItem)
          .then((res) => {
            this.valores.push(res.data.valores);
            this.snackbar = true,
            this.text = "Valores añadida",
            this.snackColor = "success";
            this.icon = true
            this.initialize()
          })
          .catch(err => {
            this.snackbar = true,
            this.text = "Ha occurido un error",
            this.snackColor = "error";
            this.icon = false
          });
      }
      this.close();
    },
    loadFile(url, callback) {
      PizZipUtils.getBinaryContent(url, callback);
    },
    renderDoc() {
      let valores = this.valores;
      let c = this.c
      this.loadFile("/documentos/valores.docx", function(
        error,
        content
      ) {
        if (error) {
          throw error;
        }
        const zip = new PizZip(content);
        const doc = new Docxtemplater(zip, { paragraphLoop: true, linebreaks: true });
        doc.setData({ valores, c });
        try {
          // render the document (replace all occurences of {first_name} by John, {last_name} by Doe, ...)
          doc.render();
        } catch (error) {
          // The error thrown here contains additional information when logged with JSON.stringify (it contains a properties object containing all suberrors).
          function replaceErrors(key, value) {
            if (value instanceof Error) {
              return Object.getOwnPropertyNames(value).reduce(function(
                error,
                key
              ) {
                error[key] = value[key];
                return error;
              },
              {});
            }
            return value;
          }
          console.log(JSON.stringify({ error: error }, replaceErrors));

          if (error.properties && error.properties.errors instanceof Array) {
            const errorMessages = error.properties.errors
              .map(function(error) {
                return error.properties.explanation;
              })
              .join("\n");
            console.log("errorMessages", errorMessages);
            // errorMessages is a humanly readable message looking like this :
            // 'The tag beginning with "foobar" is unopened'
          }
          throw error;
        }
        const out = doc.getZip().generate({
          type: "blob",
          mimeType:
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
        });
        // Output the document using Data-URI
        saveAs(out, "valores.docx");
      });
    },
  },
};
</script>