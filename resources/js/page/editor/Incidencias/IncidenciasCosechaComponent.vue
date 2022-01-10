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
      :items="cosecha"
      :headers="headers"
      :items-per-page="10"
      :footer-props="{
        'items-per-page-options': [10, 15, 20],
        'items-per-page-text': 'Incidencias por páginas',
      }"
    >
     <template v-slot:top class="mb-5">
        <v-toolbar flat>
          <v-toolbar-title>Incidencias Cosechas</v-toolbar-title>
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
                        label="Selecione una ube"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                      <v-select
                        :items="cultivo"
                        v-model="editedItem.cultivo"
                        label="Selecione un cultivo"
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
                        :items="area_total"
                        v-model="editedItem.area_total"
                        label="Área total"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                      <v-select
                        :items="a_c_diario"
                        v-model="editedItem.a_c_diario"
                        label="Área Cosechada Diario"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                       <v-select
                        :items="a_c_acum"
                        v-model="editedItem.a_c_acum"
                        label="Área Cosechada Acumulado"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                      <v-select
                        :items="a_c_pendiente"
                        v-model="editedItem.a_c_pendiente"
                        label="Área Cosechada Pendiente"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                       <v-select
                        :items="t_diario"
                        v-model="editedItem.t_diario"
                        label="Toneladas Diario"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                     <v-col cols="6">
                       <v-select
                        :items="t_acum"
                        v-model="editedItem.t_acum"
                        label="Toneladas Acumulado"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                     <v-col cols="6">
                       <v-select
                        :items="t_rend"
                        v-model="editedItem.t_rend"
                        label="Toneladas Rendimiento"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                       <v-select
                        :items="rend_acum"
                        v-model="editedItem.rend_acum"
                        label="Rendimiento Acumulado"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                       <v-select
                        :items="arranque_m"
                        v-model="editedItem.arranque_m"
                        label="Arranque Manual"
                        :rules="[rules.required]"
                        no-data-text="No hay elementos"
                        append-icon="mdi-chevron-down"
                      ></v-select>
                    </v-col>
                    <v-col cols="6">
                       <v-select
                        :items="cant_equipos"
                        v-model="editedItem.cant_equipos"
                        label="Cantidad de Equipos"
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
    cc: [],
    area_total: [],
    a_c_diario: [],
    a_c_acum: [],
    a_c_pendiente: [],
    t_diario: [],
    t_acum: [],
    t_rend: [],
    rend_acum: [],
    arranque_m: [],
    cant_equipos: [],
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
      { text: "C/C", value: "cc" },
      { text: "Área Total", value: "area_total" },
      { text: "Cultivo", value: "cultivo" },
      { text: "Área Cosechada diario", value: "a_c_diario" },
      { text: "Área Cosechada acum", value: "a_c_acum" },
      { text: "Área Cosechada pendiente", value: "a_c_pendiente" },
      { text: "Toneladas diario", value: "t_diario" },
      { text: "Toneladas acum", value: "t_acum" },
      { text: "Toneladas rend", value: "t_rend" },
      { text: "Rend Acum", value: "rend_acum" },
      { text: "Arranque manuel", value: "arranque_m" },
      { text: "Cant Equipos", value: "cant_equipos" },
      { text: "Acciones", value: "actions", sortable: false },
    ],
    cosecha: [],
    editedIndex: -1,
     editedItem: {
      id: "",
      ueb: "",
      cultivo: "",
      cc: "",
      area_total: "",
      a_c_diario: "",
      a_c_acum: "",
      a_c_pendiente: "",
      t_diario: "",
      t_acum: "",
      t_rend: "",
      rend_acum: "",
      cant_equipos: "",
    },
    defaultItem: {
      id: "",
      ueb: "",
      cultivo: "",
      cc: "",
      area_total: "",
      a_c_diario: "",
      a_c_acum: "",
      a_c_pendiente: "",
      t_diario: "",
      t_acum: "",
      t_rend: "",
      rend_acum: "",
      cant_equipos: "",
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nueva Incidencia de cosecha" : "Editar Incidencia de cosecha";
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
        .get("/api/incidencias_cosecha", {})
        .then((res) => {
          this.cosecha = res.data.cosecha;
          this.ueb = res.data.ueb
          this.cultivo = res.data.cultivo; 
          this.cc = res.data.cc
          this.area_total = res.data.area_total
          this.a_c_diario = res.data.a_c_diario
          this.a_c_acum = res.data.a_c_acum
          this.a_c_pendiente = res.data.a_c_pendiente
          this.t_diario = res.data.t_diario
          this.t_acum = res.data.t_acum
          this.t_rend = res.data.t_rend
          this.rend_acum = res.data.rend_acum
          this.arranque_m = res.data.arranque_m
          this.cant_equipos = res.data.cant_equipos
          //console.log(res.data.cultivo)
        })
        .catch((err) => console.log(err));
    },

    editItem(item) {
      this.editedIndex = this.cosecha.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.cosecha.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    // deleteItemConfirm() {
    //   axios
    //     .delete("/api/cosecha/" + this.editedItem.id)
    //     .then((res) => {
    //       this.cosecha.splice(this.editedIndex, 1);
    //       this.snackbar = true,
    //       this.text = "cosecha eliminado",
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
          .put("/api/incidencias_cosecha/" + this.editedItem.id, this.editedItem)
          .then((res) => {
            this.initialize();
            this.snackbar = true,
            this.text = "Incidencia de cosecha editada",
            this.snackColor = "success";
          })
          .catch((err) => {
            this.snackbar = true,
            this.text = "Ha occurido un error",
            this.snackColor = "error";
          });
      } else {
        axios
          .post("/api/incidencias_cosecha",  this.editedItem)
          .then((res) => {
            this.cosecha.push(res.data.incidencia_cosecha)
            this.snackbar = true,
            this.text = "Incidencia de cosecha añadida",
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
      let c = this.cosecha;
      let date = this.date
      this.loadFile("/documentos/cosechas.docx", function (error, content) {
        if (error) {
          throw error;
        }
        const zip = new PizZip(content);
        const doc = new Docxtemplater(zip, {
          paragraphLoop: true,
          linebreaks: true,
        });
        doc.setData({ c, date});
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
        saveAs(out, "cosecha.docx");
      });
    },
  },
};
</script>