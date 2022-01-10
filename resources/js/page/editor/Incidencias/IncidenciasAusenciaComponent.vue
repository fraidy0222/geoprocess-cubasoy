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
      :items="ausencia"
      :headers="headers"
      :items-per-page="10"
      :footer-props="{
        'items-per-page-options': [10, 15, 20],
        'items-per-page-text': 'Incidencias por páginas',
      }"
    >
     <template v-slot:top class="mb-5">
        <v-toolbar flat>
          <v-toolbar-title>Incidencias Ausencias</v-toolbar-title>
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
                        :items="certificados_medicos"
                        v-model="editedItem.certificados_medicos"
                        label="Certificados Médicos"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                      <v-select
                        :items="lic_maternidad"
                        v-model="editedItem.lic_maternidad"
                        label="Licencia de maternidad"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                      <v-select
                        :items="vacaciones"
                        v-model="editedItem.vacaciones"
                        label="Vacaciones"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                       <v-select
                        :items="aus_autorizadas"
                        v-model="editedItem.aus_autorizadas"
                        label="Aus. autorizadas"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                      <v-select
                        :items="aus_injustificadas"
                        v-model="editedItem.aus_injustificadas"
                        label="Aus. injustificadas"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                       <v-select
                        :items="otras"
                        v-model="editedItem.otras"
                        label="Otros"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                     <v-col cols="6">
                       <v-select
                        :items="aislados"
                        v-model="editedItem.aislados"
                        label="Aislados"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                     <v-col cols="6">
                       <v-select
                        :items="positivos"
                        v-model="editedItem.positivos"
                        label="Positivos"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                       <v-select
                        :items="madres_ninnos"
                        v-model="editedItem.madres_ninnos"
                        label="Madres con niños"
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
    cultivo: [],
    certificados_medicos: [],
    lic_maternidad: [],
    vacaciones: [],
    aus_autorizadas: [],
    aus_injustificadas: [],
    otras: [],
    aislados: [],
    positivos: [],
    madres_ninnos: [],
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
      { text: "C.Médicos", value: "certificados_medicos" },
      { text: "Lic.Maternidad", value: "lic_maternidad" },
      { text: "Vacaciones", value: "vacaciones" },
      { text: "Aus.Autorizadas", value: "aus_autorizadas" },
      { text: "Aus.Injustificadas", value: "aus_injustificadas" },
      { text: "Otros", value: "otras" },
      { text: "Aislados", value: "aislados" },
      { text: "Positivos", value: "positivos" },
      { text: "Madres con niños", value: "madres_ninnos" },
      { text: "Acciones", value: "actions", sortable: false },
    ],
    ausencia: [],
    editedIndex: -1,
    editedItem: {
      id: "",
      ueb: "",
      certificados_medicos: "",
      lic_maternidad: "",
      vacaciones: "",
      aus_autorizadas: "",
      aus_jsutificadas: "",
      otros: "",
      aislados: "",
      positivos: "",
      madres_ninnos: "",
    },
    defaultItem: {
      id: "",
      ueb: "",
      certificados_medicos: "",
      lic_maternidad: "",
      vacaciones: "",
      aus_autorizadas: "",
      aus_jsutificadas: "",
      otros: "",
      aislados: "",
      positivos: "",
      madres_ninnos: "",
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo Incidencia de ausencia" : "Editar Incidencia de ausencia";
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
        .get("/api/incidencias_ausencia", {})
        .then((res) => {
          this.ausencia = res.data.ausencias;
          this.ueb = res.data.ueb;
          this.certificados_medicos = res.data.certificados_medicos
          this.lic_maternidad = res.data.lic_maternidad
          this.vacaciones = res.data.vacaciones
          this.aus_autorizadas = res.data.aus_autorizadas
          this.aus_injustificadas = res.data.aus_injustificadas
          this.otras = res.data.otras
          this.aislados = res.data.aislados
          this.positivos = res.data.positivos
          this.madres_ninnos = res.data.madres_ninnos
        })
        .catch((err) => console.log(err));
    },

    editItem(item) {
      this.editedIndex = this.ausencia.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.ausencia.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    // deleteItemConfirm() {
    //   axios
    //     .delete("/api/ausencia/" + this.editedItem.id)
    //     .then((res) => {
    //       this.ausencia.splice(this.editedIndex, 1);
    //       this.snackbar = true,
    //       this.text = "ausencia eliminado",
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
          .put("/api/incidencias_ausencia/" + this.editedItem.id, this.editedItem)
          .then((res) => {
            this.initialize();
            this.snackbar = true,
            this.text = "Incidencia de ausencia editada",
            this.snackColor = "success";
          })
          .catch((err) => {
            this.snackbar = true,
            this.text = "Ha occurido un error",
            this.snackColor = "error";
          });
      } else {
        axios
          .post("/api/incidencias_ausencia",  this.editedItem)
          .then((res) => {
            this.ausencia.push(res.data.incidencia_ausencia)
            this.snackbar = true,
            this.text = "Incidencia de ausencia añadida",
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
      let a = this.ausencia;
      let date = this.date
      this.loadFile("/documentos/ausencias.docx", function (error, content) {
        if (error) {
          throw error;
        }
        const zip = new PizZip(content);
        const doc = new Docxtemplater(zip, {
          paragraphLoop: true,
          linebreaks: true,
        });
        doc.setData({ a, date});
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
        saveAs(out, "ausencias.docx");
      });
    },
  },
};
</script>