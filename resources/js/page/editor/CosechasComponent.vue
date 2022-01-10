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
      :items="cosechas"
      :items-per-page="10"
      :footer-props="{
        'items-per-page-options': [10, 15, 20],
        'items-per-page-text': 'cosechas por páginas',
      }"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Cosechas</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-dialog persistent v-model="dialog" max-width="700px">
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
                        <v-text-field
                          v-model="editedItem.cc"
                          label="C/C"
                          :rules="[rules.required]"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.area_total"
                          label="Área total"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.a_c_diario"
                          label="Área Cosechada Diario"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.a_c_acum"
                          label="Área Cosechada Acumulado"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.a_c_pendiente"
                          label="Área Cosechada Pendiente"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.t_diario"
                          label="Toneladas Diario"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.t_acum"
                          label="Toneladas Acumulado"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.t_rend"
                          label="Toneladas Rendimiento"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.rend_acum"
                          label="Rendimiento Acumulado"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                       <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.arranque_m"
                          label="Arranque Manual"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                       <v-col cols="6">
                        <v-text-field
                          v-model="editedItem.cant_equipos"
                          label="Cantidad de Equipos"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
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
                >¿Estás seguro de borrar esta cosecha?</v-card-title
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
    cultivo: [],
    // count: [],
    // total: [],
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
    cosechas: [],
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
      return this.editedIndex === -1 ? "Nueva cosecha" : "Editar cosecha";
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
        .get("/api/cosechas")
        .then((res) => {
          this.cosechas = res.data.cosechas;
          this.ueb = res.data.uebs;
          this.cultivo = res.data.cultivo;
          //console.log(res.data.cultivo)
          // console.log(res.data.uebs)
        })
        .catch((err) => console.log(err));
    },

    editItem(item) {
      this.editedIndex = this.cosechas.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.cosechas.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      axios
        .delete("/api/cosechas/" + this.editedItem.id)
        .then((res) => {
          this.cosechas.splice(this.editedIndex, 1);
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
          .put("/api/cosechas/" + this.editedItem.id, this.editedItem)
          .then((res) => {
            this.initialize();
            (this.snackbar = true),
            (this.text = "Cosecha editada"),
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
          .post("/api/cosechas", this.editedItem)
          .then((res) => {
            this.cosechas.push(res.data.cosechas);
            this.initialize();
            (this.snackbar = true),
              (this.text = "Cosecha añadida"),
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
      let a = this.cosechas;
      let c = this.count;
      let t = this.total;
      this.loadFile("/documentos/cosechas.docx", function (error, content) {
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
        saveAs(out, "cosechas.docx");
      });
    },
  },
};
</script>