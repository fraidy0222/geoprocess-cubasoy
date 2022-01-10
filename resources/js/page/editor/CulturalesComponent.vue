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
      :items="culturales"
      :headers="headers"
      :items-per-page="10"
      :footer-props="{
        'items-per-page-options': [10, 15, 20],
        'items-per-page-text': 'Culturales por páginas',
      }"
    >
     <template v-slot:top class="mb-5">
        <v-toolbar flat>
          <v-toolbar-title>Culturales</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-dialog persistent v-model="dialog" max-width="1000px">
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
                <v-spacer></v-spacer>
                <v-btn icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
              </v-card-title>
              <v-form v-model="valid" @submit.stop.prevent="save">
                <v-card-text>
                  <v-row>
                    <v-col cols="12" sm="6" xs="6">
                      <v-select
                        :items="ueb"
                        v-model="editedItem.ueb"
                        label="UEB"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="12" sm="6" xs="6">
                      <v-select
                        :items="cultivo"
                        v-model="editedItem.cultivo"
                        label="Cultivo"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4" xs="6">
                      <v-text-field
                      v-model="editedItem.cc"
                      label="C/C"
                      :rules="[rules.required]"
                      type="number"
                      min="0"
                    ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4" xs="6">
                      <v-text-field
                        v-model="editedItem.tipo_peloton"
                        label="Tipo de pelotón"
                        :rules="[rules.required]"
                        type="number"
                        min="0"
                      ></v-text-field>
                    </v-col>
                     <v-col cols="12" sm="4" xs="6">
                        <v-text-field
                          v-model="editedItem.d_d"
                          label="Deshije y Deshoje"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                  </v-row>
                    <h3 class="text-uppercase text--primary">1er y 2do Cultivo</h3>
                    <v-row>
                    <v-col cols="12" sm="4" xs="12">
                      <v-text-field
                        v-model="editedItem.c_plan"
                        label="Cultivo Plan"
                        :rules="[rules.required]"
                        type="number"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4" xs="12">
                      <v-text-field
                        v-model="editedItem.c_acum"
                        label="Cultivo Acumulado"
                        :rules="[rules.required]"
                        type="number"
                        min="0"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4" xs="12">
                      <v-text-field
                        v-model="editedItem.c_diario"
                        label="Cultivo Diario"
                        :rules="[rules.required]"
                        type="number"
                        min="0"
                       
                      ></v-text-field>
                    </v-col>
                    </v-row>
                     <h3 class="text-uppercase text--primary">Poda</h3>
                    <v-row>
                    <v-col cols="12" sm="4" xs="12">
                      <v-text-field
                        v-model="editedItem.p_plan"
                        label="Poda Plan"
                        :rules="[rules.required]"
                        type="number"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4" xs="12">
                      <v-text-field
                        v-model="editedItem.p_acum"
                        label="Poda Diario"
                        :rules="[rules.required]"
                        type="number"
                        min="0"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4" xs="12">
                      <v-text-field
                        v-model="editedItem.p_diario"
                        label="Poda Acumulado"
                        :rules="[rules.required]"
                        type="number"
                        min="0"
                       
                      ></v-text-field>
                    </v-col>
                    </v-row>
                      <h3 class="text-uppercase text--primary">Limpia Manual</h3>
                    <v-row>
                    <v-col cols="12" sm="4" xs="12">
                      <v-text-field
                        v-model="editedItem.l_plan"
                        label="Limpia Manual Plan"
                        :rules="[rules.required]"
                        type="number"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4" xs="12">
                      <v-text-field
                        v-model="editedItem.l_acum"
                        label="Limpia Manual Diario"
                        :rules="[rules.required]"
                        type="number"
                        min="0"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4" xs="12">
                      <v-text-field
                        v-model="editedItem.l_diario"
                        label="Limpia Manual Acumulado"
                        :rules="[rules.required]"
                        type="number"
                        min="0"
                       
                      ></v-text-field>
                    </v-col>
                    </v-row>
                      <h3 class="text-uppercase text--primary">Chapea</h3>
                    <v-row>
                    <v-col cols="12" sm="4" xs="12">
                      <v-text-field
                        v-model="editedItem.ch_plan"
                        label="Chapea Plan"
                        :rules="[rules.required]"
                        type="number"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4" xs="12">
                      <v-text-field
                        v-model="editedItem.ch_acum"
                        label="Chapea Diario"
                        :rules="[rules.required]"
                        type="number"
                        min="0"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4" xs="12">
                      <v-text-field
                        v-model="editedItem.ch_diario"
                        label="Chapea Acumulado"
                        :rules="[rules.required]"
                        type="number"
                        min="0"
                       
                      ></v-text-field>
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
          <v-dialog persistent v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="headline"
                >¿Estás seguro de borrar esta culturales?</v-card-title
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
    cc: [],
    a: [],
    c: [],
    datos: [],
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
      { text: "C/C", value: "cc"},
      { text: "Cultivo", value: "cultivo" },
      { text: "Área", value: "tipo_peloton" },
      { text: "Cultivo Plan", value: "c_plan" },
      { text: "Cultivo Acum", value: "c_acum" },
      { text: "Cultivo Diario", value: "c_diario" },
      { text: "Poda Plan", value: "p_plan" },
      { text: "Poda Acum", value: "p_acum" },
      { text: "Poda Diario", value: "p_diario" },
      { text: "Limpia Plan", value: "l_plan" },
      { text: "Limpia Acum", value: "l_acum" },
      { text: "Limpia Diario", value: "l_diario" },
      { text: "Chapea Plan", value: "ch_plan" },
      { text: "Chapea Acum", value: "ch_acum" },
      { text: "Chapea Diario", value: "ch_diario" },
      { text: "Deshije y Deshoje", value: "d_d" },
      { text: "Acciones", value: "actions", sortable: false },
    ],
    culturales: [],
    editedIndex: -1,
    editedItem: {
      id: "",
      ueb: "",
      cultivo: "",
      tipo_peloton: "",
      c_plan: "",
      c_acum: "",
      c_diario: "",
      p_plan: "",
      p_acum: "",
      p_diario: "",
      l_plan: "",
      l_acum: "",
      l_diario: "",
      ch_plan: "",
      ch_acum: "",
      ch_diario: "",
      d_d: ""
    },
    defaultItem: {
      id: "",
      ueb: "",
      cultivo: "",
      tipo_peloton: "",
      c_plan: "",
      c_acum: "",
      c_diario: "",
      p_plan: "",
      p_acum: "",
      p_diario: "",
      l_plan: "",
      l_acum: "",
      l_diario: "",
      ch_plan: "",
      ch_acum: "",
      ch_diario: "",
      d_d: ""
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo culturales" : "Editar culturales";
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
        .get("/api/culturales", {})
        .then((res) => {
          this.culturales = res.data.culturales;
          this.ueb = res.data.uebs;
          this.cultivo = res.data.cultivos;
          // this.datos = res.data.datos 
          // console.log(res.data.datos)
        })
        .catch((err) => console.log(err));
    },

    editItem(item) {
      this.editedIndex = this.culturales.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.culturales.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      axios
        .delete("/api/culturales/" + this.editedItem.id)
        .then((res) => {
          this.culturales.splice(this.editedIndex, 1);
          this.snackbar = true,
          this.text = "culturales eliminado",
          this.snackColor = "success";
          this.initialize()
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
          .put("/api/culturales/" + this.editedItem.id, this.editedItem)
          .then((res) => {
            this.initialize();
            this.snackbar = true,
            this.text = "culturales editado",
            this.snackColor = "success";
            this.initialize()
          })
          .catch((err) => {
            this.snackbar = true,
            this.text = "Ha occurido un error",
            this.snackColor = "error";
          });
      } else {
        axios
          .post("/api/culturales", this.editedItem)
          .then((res) => {
            console.dir(res);
            this.culturales.push(res.data.culturales);
            this.snackbar = true,
            this.text = "culturales añadido",
            this.snackColor = "success";
            this.initialize()
          })
          .catch((err) => {
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
      let s = this.culturales;
      this.loadFile("/documentos/culturales.docx", function (error, content) {
        if (error) {
          throw error;
        }
        const zip = new PizZip(content);
        const doc = new Docxtemplater(zip, {
          paragraphLoop: true,
          linebreaks: true,
        });
        doc.setData({ s,});
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
        saveAs(out, "culturales.docx");
      });
    },
  },
};
</script>