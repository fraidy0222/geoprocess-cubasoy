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
      :items="energia"
      :headers="headers"
      :items-per-page="10"
      :footer-props="{
        'items-per-page-options': [10, 15, 20],
        'items-per-page-text': 'Incidencias por páginas',
      }"
    >
     <template v-slot:top class="mb-5">
        <v-toolbar flat>
          <v-toolbar-title>Incidencias Energía</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-dialog persistent v-model="dialog" max-width="700px">
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                <v-icon>mdi-plus</v-icon>
                Añadir
              </v-btn>
               <v-btn @click="renderDoc" color="success" dark class="mb-2 mr-2">
                Exportar a Word
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="headline">{{ formTitle }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
              </v-card-title>
              <v-form v-model="valid" @submit.stop.prevent="save">
                <v-card-text>
                  <h3 class="text-uppercase text--primary">Energía</h3>
                  <v-row>
                    <v-col cols="12" sm="4" xs="6">
                      <v-select
                        :items="plan_mes_energia"
                        v-model="editedItem.plan_mes_energia"
                        label="Plan Mes"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4" xs="6">
                      <v-select
                        :items="plan_real_energia"
                        v-model="editedItem.plan_real_energia"
                        label="Plan Real"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4" xs="6">
                      <v-select
                        :items="porciento_energia"
                        v-model="editedItem.porciento_energia"
                        label="Porciento"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                  </v-row>
                   <h3 class="text-uppercase text--primary">Combustible</h3>
                  <v-row>
                    <v-col cols="12" sm="4" xs="6">
                      <v-select
                        :items="plan_mes_petroleo"
                        v-model="editedItem.plan_mes_petroleo"
                        label="Plan Mes"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4" xs="6">
                      <v-select
                        :items="plan_real_petroleo"
                        v-model="editedItem.plan_real_petroleo"
                        label="Plan Real"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4" xs="6">
                      <v-select
                        :items="porciento_petroleo"
                        v-model="editedItem.porciento_petroleo"
                        label="Porciento"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
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
        </v-toolbar>
        <!-- Buscar -->
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Buscar..."
          single-line
          hide-details
          class="mx-4 mb-3"
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

<style scoped>
  .theme--light.v-data-table>.v-data-table__wrapper>table>thead>tr>th {
    border: 1px solid rgba(0, 0, 0, .12);
  }
</style>

<script>
// docxtemplater
import Docxtemplater from "docxtemplater";
import PizZip from "pizzip";
import PizZipUtils from "pizzip/utils/index.js";

import { saveAs } from "file-saver";

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
    ueb: [],
    plan_mes_energia: [],
    plan_real_energia: [],
    porciento_energia: [],
    plan_mes_petroleo: [],
    plan_real_petroleo: [],
    porciento_petroleo: [],
    date: new Date().toLocaleDateString(),
    rules: {
      required: (v) => !!v || "Este campo es requerido",
    },
    valid: true,
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
      return this.editedIndex === -1 ? "Nuevo Incidencia de energía" : "Editar Incidencia de energía";
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
        .get("/api/incidencias_energia", {})
        .then((res) => {
          this.energia = res.data.energia;
          this.ueb = res.data.ueb;
          this.plan_mes_energia = res.data.plan_mes_energia
          this.plan_real_energia = res.data.plan_real_energia
          this.porciento_energia = res.data.porciento_energia
          this.plan_mes_petroleo = res.data.plan_mes_petroleo
          this.plan_real_petroleo = res.data.plan_real_petroleo
          this.porciento_petroleo = res.data.porciento_petroleo
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

    // deleteItemConfirm() {
    //   axios
    //     .delete("/api/energia/" + this.editedItem.id)
    //     .then((res) => {
    //       this.energia.splice(this.editedIndex, 1);
    //       this.snackbar = true,
    //       this.text = "energia eliminado",
    //       this.snackColor = "success";
    //       this.initialize()
    //     })
    //     .catch((err) => {
    //       this.snackbar = true,
    //      this.text = "Ha occurido un error",
    //       this.snackColor = "error";
    //     });
    //   this.closeDelete();
    // },
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
          .put("/api/incidencias_energia/" + this.editedItem.id, this.editedItem)
          .then((res) => {
            this.initialize();
            this.snackbar = true,
            this.text = "Incidencia de energía editada",
            this.snackColor = "success";
          })
          .catch((err) => {
            this.snackbar = true,
            this.text = "Ha occurido un error",
            this.snackColor = "error";
          });
      } else {
        axios
          .post("/api/incidencias_energia",  this.editedItem)
          .then((res) => {
            this.energia.push(res.data.incidencia_energia)
            this.snackbar = true,
            this.text = "Incidencia de energía añadida",
            this.snackColor = "success";
            this.initialize()
          })
          .catch((err) => {
            console.log(err)
            this.snackbar = true,
            this.text = "Ha occurido un error",
            this.snackColor = "error";
          });
      }
      this.close();
    },
    loadFile(url, callback) {
      PizZipUtils.getBinaryContent(url, callback);
    },
    renderDoc() {
      let e = this.energia;
      let date = this.date
      this.loadFile("/documentos/energia_combustible.docx", function (error, content) {
        if (error) {
          throw error;
        }
        const zip = new PizZip(content);
        const doc = new Docxtemplater(zip, {
          paragraphLoop: true,
          linebreaks: true,
        });
        doc.setData({ e, date});
        console.log(doc)
        try {
          // render the document (replace all occurences of {first_name} by John, {last_name} by Doe, ...)
          doc.render();
        } catch (error) {
          // The error thrown here contains additional information when logged with JSON.stringify (it contains a properties object containing all suberrors).
          function replaceErrors(key, value) {
            if (value instanceof Error) {
              return Object.getOwnPropertyNames(value).reduce(function (
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
              .map(function (error) {
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
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        });
        // Output the document using Data-URI
        saveAs(out, "energia.docx");
      });
    },
  },
};
</script>