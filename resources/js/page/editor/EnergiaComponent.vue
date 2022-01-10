<template>
  <div>
      <v-chip class="ma-2" color="primary" text-color="white">
        Plan mes Energia: {{ rowTotal("plan_mes_energia") }}
      <v-icon right> mdi-gauge-full </v-icon>
    </v-chip>
    <v-data-table
      item-key="id"
      class="elevation-1"
      disable-sort
      :search="search"
      no-results-text="No exite este elemento"
      :loading="loading"
      loading-text="Cargando... Por favor espere"
      :headers="headers"
      :items="energia"
      :items-per-page="10"
      :footer-props="{
        'items-per-page-options': [10, 15, 20],
        'items-per-page-text': 'Energía por páginas',
      }"
    >
   <template
      v-slot:header="{ props: { headers } }"
      >
        <thead>
          <tr>
            <th :colspan="headers.length" class="td-border-style">
              This is a header
            </th>
          </tr>
        </thead>
      </template>
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Energía y Combustible</v-toolbar-title>
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
                    <h3 class="text-uppercase text--primary">Energía</h3>
                    <v-row>
                      <v-col cols="12" sm="4" xs="6">
                        <v-text-field
                          v-model="editedItem.plan_mes_energia"
                          label="Plan Mes"
                          :rules="[rules.required]"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="4" xs="6">
                        <v-text-field
                          v-model="editedItem.plan_real_energia"
                          label="Plan Real"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="4" xs="6">
                        <v-text-field
                          v-model="editedItem.porciento_energia"
                          label="Porciento"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <h3 class="text-uppercase text--primary">Combustible</h3>
                    <v-row>
                      <v-col cols="12" sm="4" xs="6">
                        <v-text-field
                          v-model="editedItem.plan_mes_petroleo"
                          label="Plan Mes"
                          :rules="[rules.required]"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="4" xs="6">
                        <v-text-field
                          v-model="editedItem.plan_real_petroleo"
                          label="Plan Real"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="4" xs="6">
                        <v-text-field
                          v-model="editedItem.porciento_petroleo"
                          label="Porciento"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="4" xs="6">
                        <v-select
                          :items="ueb"
                          v-model="editedItem.ueb"
                          label="Selecione una ube"
                          :rules="[rules.required]"
                          no-data-text="No hay elementos"
                          append-icon="mdi-chevron-down"
                        ></v-select>
                      </v-col>
                    </v-row>
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
                >¿Estás seguro de borrar esta ausencia?</v-card-title
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
        <v-btn color="primary" @click="initialize"> Reiniciar </v-btn>
      </template>
    </v-data-table>
    <v-snackbar top v-model="snackbar" :color="snackColor" :timeout="timeout">
      <v-icon v-bind:class="[icon ? 'mdi-check-circle' : 'mdi-bell-cancel', 'mdi']"></v-icon>{{ text }}
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
      default: 2,
    },
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
    icon: true,
    valid: true,
    date: new Date().toISOString().substr(0, 10),
    rules: {
      required: (v) => !!v || "Este campo es requerido",
    },
    headers: [
      {
        text: "UEB",
        align: "start",
        value: "ueb",
      },
      { text: "Plan Mes Energía", value: "plan_mes_energia" },
      { text: "Plan Real Energía", value: "plan_real_energia" },
      { text: "% Energía", value: "porciento_energia" },
      { text: "Plan Mes Petróleo", value: "plan_mes_petroleo" },
      { text: "Plan Real Petróleo ", value: "plan_real_petroleo" },
      { text: "% Petróleo", value: "porciento_petroleo" },
      { text: "Acciones", value: "actions", sortable: false },
    ],
    energia: [],
    editedIndex: -1,
    editedItem: {
      id: "",
      ueb: "",
      plan_mes_energia: "",
      plan_real_energia: "",
      porciento_energia: "",
      plan_mes_petroleo: "",
      plan_real_petroleo: "",
      porciento_petroleo: "",
    },
    defaultItem: {
      id: "",
      ueb: "",
      plan_mes_energia: "",
      plan_real_energia: "",
      porciento_energia: "",
      plan_mes_petroleo: "",
      plan_real_petroleo: "",
      porciento_petroleo: "",
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1
        ? "Nueva energía y combustible"
        : "Editar energía y combustible";
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
        .get("/api/energias")
        .then((res) => {
          this.energia = res.data.energias;
          this.ueb = res.data.uebs;
        })
        .catch((err) => console.log(err));
    },

    editItem(item) {
      this.editedIndex = this.energia.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.energia.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      axios
        .delete("/api/energias/" + this.editedItem.id)
        .then((res) => {
          this.energia.splice(this.editedIndex, 1);
          (this.snackbar = true),
            (this.text = "Energía y Combustible añadido"),
            (this.snackColor = "success");
            this.icon = true
        })
        .catch((err) => {
          (this.snackbar = true),
            (this.text = "Ha occurido un error"),
            (this.snackColor = "error");
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
          .put("/api/energias/" + this.editedItem.id, this.editedItem)
          .then((res) => {
            this.initialize();
            this.snackbar = true,
            this.text = "Energía y Combustible añadido",
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
          .post("/api/energias", this.editedItem)
          .then((res) => {
            this.energia.push(res.data.energias);
            this.snackbar = true,
            this.text = "Energía y Combustible añadido",
            this.snackColor = "success";
            this.icon = true
          })
          .catch((err) => {
            this.snackbar = true,
            this.text = "Ha occurido un error",
            this.snackColor = "error";
            this.icon = false
          });
      }
      this.close();
    },
     rowTotal(base) {
      return this.energia.reduce((sum, cur) => (sum += cur[base]), 0);
    },
    loadFile(url, callback) {
      PizZipUtils.getBinaryContent(url, callback);
    },
    renderDoc() {
      let energia = this.energia;
      this.loadFile("/documentos/energia_combustible.docx", function(
        error,
        content
      ) {
        if (error) {
          throw error;
        }
        const zip = new PizZip(content);
        const doc = new Docxtemplater(zip, { paragraphLoop: true, linebreaks: true });
        doc.setData({ energia });
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
        saveAs(out, "energia_combustible.docx");
      });
    },
  },
};
</script>