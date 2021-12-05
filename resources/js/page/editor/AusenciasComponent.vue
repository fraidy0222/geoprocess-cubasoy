<template>
  <div>
    <v-data-table
      item-key="id"
      class="elevation-1"
      disable-sort
      :search="search"
      no-results-text="No exite este elemento"
      :loading="loading"
      loading-text="Cargando... Por favor espere"
      :headers="headers"
      :items="ausencias"
      :items-per-page="10"
      :footer-props="{
        'items-per-page-options': [10, 15, 20],
        'items-per-page-text': 'Ausencias por páginas',
      }"
    >
   /
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Ausencias</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-dialog persistent v-model="dialog" max-width="600px">
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
              </v-card-title>
              <v-form v-model="valid" @submit.stop.prevent="save">
                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.certificados_medicos"
                          label="Certificados médicos"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.lic_maternidad"
                          label="Licencia de maternidad"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.vacaciones"
                          label="Vacaciones"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.aus_autorizadas"
                          label="Ausencias autorizadas"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.aus_injustificadas"
                          label="Ausencias injustificadas"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.otras"
                          label="Otros"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.aislados"
                          label="Aislados"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.positivos"
                          label="Positivos"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.madres_ninnos"
                          label="Madres con niños"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6">
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
    count: [],
    total: [],
    icon: true,
    valid: true,
    rules: {
      required: (v) => !!v || "Este campo es requerido",
    },
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
    ausencias: [],
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
      return this.editedIndex === -1 ? "Nueva ausencia" : "Editar ausencia";
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
        .get("/api/ausencias")
        .then((res) => {
          this.ausencias = res.data.ausencias;
          this.ueb = res.data.uebs;
          this.count = res.data.count;
          this.total = res.data.total;
          // console.log(res.data.count)
          // console.log(res.data.total)
        })
        .catch((err) => console.log(err));
    },

    editItem(item) {
      this.editedIndex = this.ausencias.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.ausencias.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      axios
        .delete("/api/ausencias/" + this.editedItem.id)
        .then((res) => {
          this.ausencias.splice(this.editedIndex, 1);
          (this.snackbar = true),
          (this.text = "Ausencia eliminada"),
          (this.snackColor = "success");
          this.icon = true
          this.initialize();
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
          .put("/api/ausencias/" + this.editedItem.id, this.editedItem)
          .then((res) => {
            this.initialize();
            (this.snackbar = true),
            (this.text = "Ausencia editada"),
            (this.snackColor = "success");
            this.icon = true
          })
          .catch((err) => {
            (this.snackbar = true),
            (this.text = "Ha occurido un error"),
            (this.snackColor = "error");
            this.icon = false
          });
      } else {
        axios
          .post("/api/ausencias", this.editedItem)
          .then((res) => {
            this.ausencias.push(res.data.ausencias);
            this.initialize();
            (this.snackbar = true),
              (this.text = "Ausencia añadida"),
              (this.snackColor = "success");
              this.icon = true
          })
          .catch((err) => {
            (this.snackbar = true),
              (this.text = "Ha occurido un error"),
              (this.snackColor = "error");
              this.icon = false
          });
      }
      this.close();
    },
    loadFile(url, callback) {
      PizZipUtils.getBinaryContent(url, callback);
    },
    renderDoc() {
      let a = this.ausencias;
      let c = this.count;
      let t = this.total;
      this.loadFile("/documentos/ausencias.docx", function (error, content) {
        if (error) {
          throw error;
        }
        const zip = new PizZip(content);
        const doc = new Docxtemplater(zip, {
          paragraphLoop: false,
          linebreaks: false,
        });
        doc.setData({ a, c, t });
        console.log(doc)
        try {
          doc.render();
        } catch (error) {
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