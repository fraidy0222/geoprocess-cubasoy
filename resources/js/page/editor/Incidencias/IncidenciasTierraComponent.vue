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
      :items="tierra"
      :headers="headers"
      :items-per-page="10"
      :footer-props="{
        'items-per-page-options': [10, 15, 20],
        'items-per-page-text': 'Incidencias por páginas',
      }"
    >
     <template v-slot:top class="mb-5">
        <v-toolbar flat>
          <v-toolbar-title>Incidencias Tierras</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-dialog persistent v-model="dialog" max-width="1000px">
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
                  <v-row>
                    <v-col cols="6">
                      <v-select
                        :items="ueb"
                        v-model="editedItem.ueb"
                        label="UEB"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                      <v-select
                        :items="cc"
                        v-model="editedItem.cc"
                        label="C/C"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                      <v-select
                        :items="tipo_peloton"
                        v-model="editedItem.tipo_peloton"
                        label="Acumulado del mes"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                      <v-select
                        :items="nivelacio_rail"
                        v-model="editedItem.nivelacio_rail"
                        label="Acumulado hasta la fecha"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                  </v-row>
                   <h3 class="text-uppercase text--primary">Rotura</h3>
                   <v-row>
                      <v-col cols="12" sm="4" xs="12">
                        <v-select
                          :items="r_plan"
                          v-model="editedItem.r_plan"
                          label="Rotura Plan"
                          :rules="[rules.required]"
                          no-data-text="No hay elementos"
                          append-icon="mdi-chevron-down"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4" xs="12">
                        <v-select
                          :items="r_acum"
                          v-model="editedItem.r_acum"
                          label="Rotura Acumulado"
                          :rules="[rules.required]"
                          no-data-text="No hay elementos"
                          append-icon="mdi-chevron-down"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4" xs="12">
                        <v-select
                          :items="r_diario"
                          v-model="editedItem.r_diario"
                          label="Rotura Diario"
                          :rules="[rules.required]"
                          no-data-text="No hay elementos"
                          append-icon="mdi-chevron-down"
                        ></v-select>
                    </v-col>
                   </v-row>
                    <h3 class="text-uppercase text--primary">Rotura</h3>
                   <v-row>
                      <v-col cols="12" sm="4" xs="12">
                        <v-select
                          :items="r_plan"
                          v-model="editedItem.r_plan"
                          label="Rotura Plan"
                          :rules="[rules.required]"
                          no-data-text="No hay elementos"
                          append-icon="mdi-chevron-down"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4" xs="12">
                        <v-select
                          :items="r_acum"
                          v-model="editedItem.r_acum"
                          label="Rotura Acumulado"
                          :rules="[rules.required]"
                          no-data-text="No hay elementos"
                          append-icon="mdi-chevron-down"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4" xs="12">
                        <v-select
                          :items="r_diario"
                          v-model="editedItem.r_diario"
                          label="Rotura Diario"
                          :rules="[rules.required]"
                          no-data-text="No hay elementos"
                          append-icon="mdi-chevron-down"
                        ></v-select>
                    </v-col>
                   </v-row>
                    <h3 class="text-uppercase text--primary">Grada</h3>
                   <v-row>
                      <v-col cols="12" sm="4" xs="12">
                        <v-select
                          :items="g_plan"
                          v-model="editedItem.g_plan"
                          label="Grada Plan"
                          :rules="[rules.required]"
                          no-data-text="No hay elementos"
                          append-icon="mdi-chevron-down"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4" xs="12">
                        <v-select
                          :items="g_acum"
                          v-model="editedItem.g_acum"
                          label="Grada Acumulado"
                          :rules="[rules.required]"
                          no-data-text="No hay elementos"
                          append-icon="mdi-chevron-down"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4" xs="12">
                        <v-select
                          :items="g_diario"
                          v-model="editedItem.g_diario"
                          label="Grada Diario"
                          :rules="[rules.required]"
                          no-data-text="No hay elementos"
                          append-icon="mdi-chevron-down"
                        ></v-select>
                    </v-col>
                   </v-row>
                    <h3 class="text-uppercase text--primary">Cruce</h3>
                   <v-row>
                      <v-col cols="12" sm="4" xs="12">
                        <v-select
                          :items="c_plan"
                          v-model="editedItem.c_plan"
                          label="Cruce Plan"
                          :rules="[rules.required]"
                          no-data-text="No hay elementos"
                          append-icon="mdi-chevron-down"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4" xs="12">
                        <v-select
                          :items="c_acum"
                          v-model="editedItem.c_acum"
                          label="Cruce Acumulado"
                          :rules="[rules.required]"
                          no-data-text="No hay elementos"
                          append-icon="mdi-chevron-down"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4" xs="12">
                        <v-select
                          :items="c_diario"
                          v-model="editedItem.c_diario"
                          label="Cruce Diario"
                          :rules="[rules.required]"
                          no-data-text="No hay elementos"
                          append-icon="mdi-chevron-down"
                        ></v-select>
                    </v-col>
                   </v-row>
                     <h3 class="text-uppercase text--primary">Surque</h3>
                   <v-row>
                      <v-col cols="12" sm="4" xs="12">
                        <v-select
                          :items="s_plan"
                          v-model="editedItem.s_plan"
                          label="Surque Plan"
                          :rules="[rules.required]"
                          no-data-text="No hay elementos"
                          append-icon="mdi-chevron-down"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4" xs="12">
                      <v-select
                        :items="s_acum"
                        v-model="editedItem.s_acum"
                        label="Surque Acumulado"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4" xs="12">
                      <v-select
                        :items="s_diario"
                        v-model="editedItem.s_diario"
                        label="Surque Diario"
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
    cc: [],
    tipo_peloton: [],
    nivelacio_rail: [],
    r_plan: [],
    r_acum: [],
    r_diario: [],
    g_plan: [],
    g_acum: [],
    g_diario: [],
    c_plan: [],
    c_acum: [],
    c_diario: [],
    s_plan: [],
    s_acum: [],
    s_diario: [],
    date: new Date().toLocaleDateString(),
    rules: {
      required: (v) => !!v || "Este campo es requerido",
    },
    valid: true,
    headers: [
      {
        text: "Granja Productora",
        align: "start",
        value: "ueb",
      },
      { text: "C/C", value: "cc"},
      { text: "Cultivo", value: "tipo_peloton" },
      { text: "Rotura Plan", value: "r_plan" },
      { text: "Rotura Acum", value: "r_acum" },
      { text: "Rotura Diario", value: "r_diario" },
      { text: "Grada Plan", value: "g_plan" },
      { text: "Grada Acum", value: "g_acum" },
      { text: "Grada Diario", value: "g_diario" },
      { text: "Cruce Plan", value: "c_plan" },
      { text: "Cruce Acum", value: "c_acum" },
      { text: "Cruce Diario", value: "c_diario" },
      { text: "Surque Plan", value: "s_plan" },
      { text: "Surque Acum", value: "s_acum" },
      { text: "Surque Diario", value: "s_diario" },
      { text: "Nivelación Rail", value: "nivelacio_rail" },
      { text: "Acciones", value: "actions", sortable: false },
    ],
    tierra: [],
    editedIndex: -1,
   editedItem: {
      id: "",
      ueb: "",
      cc: "",
      tipo_peloton: "",
      r_plan: "",
      r_acum: "",
      r_diario: "",
      g_plan: "",
      g_acum: "",
      g_diario: "",
      c_plan: "",
      c_acum: "",
      c_diario: "",
      s_plan: "",
      s_acum: "",
      s_diario: "",
      nivelacio_rail: "",
    },
    defaultItem: {
      id: "",
      ueb: "",
      cc: "",
      tipo_peloton: "",
      g_plan: "",
      g_acum: "",
      g_diario: "",
      c_plan: "",
      c_acum: "",
      c_diario: "",
      s_plan: "",
      s_acum: "",
      s_diario: "",
      nivelacio_rail: "",
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nueva Incidencia de tierras" : "Editar Incidencia de tierras";
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
        .get("/api/incidencias_tierra", {})
        .then((res) => {
          this.tierra = res.data.tierra;
          this.ueb = res.data.ueb; 
          this.cc = res.data.cc
          this.tipo_peloton = res.data.tipo_peloton
          this.nivelacio_rail = res.data.nivelacio_rail
          this.r_plan = res.data.r_plan
          this.r_acum = res.data.r_acum
          this.r_diario = res.data.r_diario
          this.g_plan = res.data.g_plan
          this.g_acum = res.data.g_acum
          this.g_diario = res.data.g_diario
          this.c_plan = res.data.c_plan
          this.c_acum = res.data.c_acum
          this.c_diario = res.data.c_diario
          this.s_plan = res.data.s_plan
          this.s_acum = res.data.s_acum
          this.s_diario = res.data.s_diario
        })
        .catch((err) => console.log(err));
    },

    editItem(item) {
      this.editedIndex = this.tierra.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.tierra.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    // deleteItemConfirm() {
    //   axios
    //     .delete("/api/tierra/" + this.editedItem.id)
    //     .then((res) => {
    //       this.tierra.splice(this.editedIndex, 1);
    //       this.snackbar = true,
    //       this.text = "tierra eliminado",
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
          .put("/api/incidencias_tierra/" + this.editedItem.id, this.editedItem)
          .then((res) => {
            this.initialize();
            this.snackbar = true,
            this.text = "Incidencia de tierra editada",
            this.snackColor = "success";
          })
          .catch((err) => {
            this.snackbar = true,
            this.text = "Ha occurido un error",
            this.snackColor = "error";
          });
      } else {
        axios
          .post("/api/incidencias_tierra",  this.editedItem)
          .then((res) => {
            this.tierra.push(res.data.incidencia_tierra)
            this.snackbar = true,
            this.text = "Incidencia de tierra añadida",
            this.snackColor = "success";
            this.initialize()
            console.log(res)
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
      let t = this.tierra;
      let date = this.date
      this.loadFile("/documentos/tierras.docx", function (error, content) {
        if (error) {
          throw error;
        }
        const zip = new PizZip(content);
        const doc = new Docxtemplater(zip, {
          paragraphLoop: true,
          linebreaks: true,
        });
        doc.setData({ t, date});
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
        saveAs(out, "tierras.docx");
      });
    },
  },
};
</script>