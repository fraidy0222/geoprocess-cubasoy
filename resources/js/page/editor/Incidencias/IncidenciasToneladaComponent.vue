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
      :items="tonelada"
      :headers="headers"
      :items-per-page="10"
      :footer-props="{
        'items-per-page-options': [10, 15, 20],
        'items-per-page-text': 'Incidencias por páginas',
      }"
    >
     <template v-slot:top class="mb-5">
        <v-toolbar flat>
          <v-toolbar-title>Incidencias Toneladas</v-toolbar-title>
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
                        :items="cultivo"
                        v-model="editedItem.cultivo"
                        label="Cultivo"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                      <v-select
                        :items="venta_d"
                        v-model="editedItem.venta_d"
                        label="Venta Diaria"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                      <v-select
                        :items="acum_mes"
                        v-model="editedItem.acum_mes"
                        label="Acumulado del mes"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                      <v-select
                        :items="acum_fecha"
                        v-model="editedItem.acum_fecha"
                        label="Acumulado hasta la fecha"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                       <v-select
                        :items="acopio"
                        v-model="editedItem.acopio"
                        label="Acopio"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                      <v-select
                        :items="eam"
                        v-model="editedItem.eam"
                        label="EAM"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                       <v-select
                        :items="encarg_estatal"
                        v-model="editedItem.encarg_estatal"
                        label="Encargado estatal"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                     <v-col cols="6">
                       <v-select
                        :items="industria"
                        v-model="editedItem.industria"
                        label="Industria"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                     <v-col cols="6">
                       <v-select
                        :items="cayo_cruz"
                        v-model="editedItem.cayo_cruz"
                        label="Cayo Cruz"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                       <v-select
                        :items="i_ceballos"
                        v-model="editedItem.i_ceballos"
                        label="I.Ceballos"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                       <v-select
                        :items="fruta_select"
                        v-model="editedItem.fruta_select"
                        label="Fruta Selecta"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                       <v-select
                        :items="otros"
                        v-model="editedItem.otros"
                        label="Otros"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                       <v-select
                        :items="semilla"
                        v-model="editedItem.semilla"
                        label="Semilla"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                       <v-select
                        :items="es_camaguey"
                        v-model="editedItem.es_camaguey"
                        label="E.S Camagüey"
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
    cultivo: [],
    venta_d: [],
    acum_mes: [],
    acum_fecha: [],
    acopio: [],
    eam: [],
    encarg_estatal: [],
    industria: [],
    cayo_cruz: [],
    i_ceballos: [],
    fruta_select: [],
    otros: [],
    semilla: [],
    es_camaguey: [],
    date: new Date().toLocaleDateString(),
    rules: {
      required: (v) => !!v || "Este campo es requerido",
    },
    valid: true,
    headers: [
      {
        text: "Cultivo",
        align: "start",
        value: "cultivo",
      },
      { text: "Venta Diaria", value: "venta_d"},
      { text: "Acum. Mes", value: "acum_mes" },
      { text: "Acum. Fecha", value: "acum_fecha" },
      { text: "Acopio", value: "acopio" },
      { text: "EAM", value: "eam" },
      { text: "Encarg. Estatal", value: "encarg_estatal" },
      { text: "Industria", value: "industria" },
      { text: "Cayo Cruz", value: "cayo_cruz" },
      { text: "I. Ceballos", value: "i_ceballos" },
      { text: "Fruta Selecta", value: "fruta_select" },
      { text: "Otros", value: "otros" },
      { text: "Semilla", value: "semilla" },
      { text: "E.S Camagüey", value: "es_camaguey" },
      { text: "Acciones", value: "actions", sortable: false },
    ],
    tonelada: [],
    editedIndex: -1,
    editedItem: {
      id: "",
      cultivo: "",
      venta_d: "",
      acum_mes: "",
      acum_fecha: "",
      acopio: "",
      eam: "",
      encarg_estatal: "",
      industria: "",
      cayo_cruz: "",
      i_ceballos: "",
      fruta_select: "",
      otros: "",
      semilla: "",
      es_camaguey: ""
    },
    defaultItem: {
      id: "",
      cultivo: "",
      venta_d: "",
      acum_mes: "",
      acum_fecha: "",
      acopio: "",
      eam: "",
      encarg_estatal: "",
      industria: "",
      cayo_cruz: "",
      i_ceballos: "",
      fruta_select: "",
      otros: "",
      semilla: "",
      es_camaguey: ""
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nueva Incidencia de tonelada" : "Editar Incidencia de tonelada";
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
        .get("/api/incidencias_tonelada", {})
        .then((res) => {
          this.tonelada = res.data.tonelada;
          this.cultivo = res.data.cultivo; 
          this.venta_d = res.data.venta_d
          this.acum_mes = res.data.acum_mes
          this.acum_fecha = res.data.acum_fecha
          this.acopio = res.data.acopio
          this.eam = res.data.eam
          this.encarg_estatal = res.data.encarg_estatal
          this.industria = res.data.industria
          this.cayo_cruz = res.data.cayo_cruz
          this.i_ceballos = res.data.i_ceballos
          this.fruta_select = res.data.fruta_select
          this.otros = res.data.otros
          this.semilla = res.data.semilla
          this.es_camaguey = res.data.es_camaguey
          //console.log(res.data.cultivo)
        })
        .catch((err) => console.log(err));
    },

    editItem(item) {
      this.editedIndex = this.tonelada.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.tonelada.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    // deleteItemConfirm() {
    //   axios
    //     .delete("/api/tonelada/" + this.editedItem.id)
    //     .then((res) => {
    //       this.tonelada.splice(this.editedIndex, 1);
    //       this.snackbar = true,
    //       this.text = "tonelada eliminado",
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
          .put("/api/incidencias_tonelada/" + this.editedItem.id, this.editedItem)
          .then((res) => {
            this.initialize();
            this.snackbar = true,
            this.text = "Incidencia de tonelada editada",
            this.snackColor = "success";
          })
          .catch((err) => {
            this.snackbar = true,
            this.text = "Ha occurido un error",
            this.snackColor = "error";
          });
      } else {
        axios
          .post("/api/incidencias_tonelada",  this.editedItem)
          .then((res) => {
            this.tonelada.push(res.data.incidencia_tonelada)
            this.snackbar = true,
            this.text = "Incidencia de tonelada añadida",
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
      let t = this.tonelada;
      let date = this.date
      this.loadFile("/documentos/toneladas.docx", function (error, content) {
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
        saveAs(out, "tonelada.docx");
      });
    },
  },
};
</script>