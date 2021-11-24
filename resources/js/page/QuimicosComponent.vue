<template>
  <div>
    <v-row>
      <v-col>
        <v-card class="mx-auto" :loading="loading">
          <template slot="progress">
            <v-progress-linear
              indeterminate
              color="primary"
            ></v-progress-linear>
          </template>

          <v-list>
            <v-list-item v-for="(c, index) in cc" :key="index">
              <v-list-item-content>
                <v-list-item-title>C/C</v-list-item-title>
              </v-list-item-content>

              <v-list-item-icon>
                <v-avatar color="primary">
                  <span class="white--text text-h6">{{ c.cc }}</span>
                </v-avatar>
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
            <v-list-item v-for="(a, index) in a" :key="index">
              <v-list-item-content>
                <v-list-item-title>Área Aplicada</v-list-item-title>
              </v-list-item-content>

              <v-list-item-icon>
                <v-avatar color="primary">
                  <span class="white--text text-h6">{{ a.a }}</span>
                </v-avatar>
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
                <v-list-item-title>Área acumulada</v-list-item-title>
              </v-list-item-content>

              <v-list-item-icon>
                <v-avatar color="primary">
                  <span class="white--text text-h6">{{ c.c }}</span>
                </v-avatar>
              </v-list-item-icon>
            </v-list-item>
          </v-list>
        </v-card>
      </v-col>
    </v-row>
    <v-data-table
      item-key="name"
      class="elevation-1"
      :search="search"
      no-results-text="No exite este elemento"
      :loading="loading"
      disable-sort
      loading-text="Cargando... Por favor espere"
      :items="quimicos"
      :headers="headers"
      :items-per-page="10"
      :footer-props="{
        'items-per-page-options': [10, 15, 20],
        'items-per-page-text': 'Usuarios por páginas',
      }"
    >
      <template v-slot:[`item.comienza`]="{ item }">
        {{ item.comienza }} - {{ item.termina }} am
      </template>

      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Químicos</v-toolbar-title>
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
                      <v-text-field
                        v-model="editedItem.tipo_aplicacion"
                        label="Tipo Aplicacioón"
                        :rules="[rules.required]"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                      <v-text-field
                        v-model="editedItem.tipo_producto"
                        label="Tipo Producto"
                        :rules="[rules.required]"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                      <v-text-field
                        v-model="editedItem.cc"
                        label="C/C"
                        :rules="[rules.required]"
                        type="number"
                        min="0"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                      <v-text-field
                        v-model="editedItem.area_aplicada"
                        label="Área aplicada"
                        :rules="[rules.required]"
                        type="number"
                        min="0"
                        suffix="ha"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                      <v-text-field
                        v-model="editedItem.area_acum"
                        label="Área acumulada"
                        :rules="[rules.required]"
                        type="number"
                        min="0"
                        suffix="ha"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                      <v-text-field
                        v-model="editedItem.cant"
                        label="Cantidad"
                        :rules="[rules.required]"
                        type="number"
                        min="0"
                        suffix="lts"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                      <v-text-field
                        v-model="editedItem.cant_equipos"
                        label="Cantidad Equipos"
                        :rules="[rules.required]"
                        type="number"
                        min="0"
                      ></v-text-field>
                    </v-col>
                    <v-col>
                     <v-menu
                        ref="menu"
                        v-model="menu1"
                        :close-on-content-click="false"
                        :nudge-right="40"
                    
                        transition="scale-transition"
                        offset-y
                        max-width="290px"
                        min-width="290px"
                      >
                        <template v-slot:activator="{ on, attrs }">
                          <v-text-field
                            v-model="editedItem.comienza"
                            label="Comienza"
                            append-icon="mdi-clock-time-four-outline"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                            :rules="[rules.required]"
                            clearable
                          ></v-text-field>
                        </template>
                        <v-time-picker
                          v-if="menu1"
                          v-model="editedItem.comienza"
                          full-width
                          scrollable
                          @click:minute="$refs.menu.save(editedItem.comienza)"
                        ></v-time-picker>
                      </v-menu>
                    </v-col>
                    <v-col>
                       <v-menu
                        ref="menu"
                        v-model="menu2"
                        :close-on-content-click="false"
                        :nudge-right="40"
                    
                        transition="scale-transition"
                        offset-y
                        max-width="290px"
                        min-width="290px"
                      >
                        <template v-slot:activator="{ on, attrs }">
                          <v-text-field
                            v-model="editedItem.termina"
                            label="Termina"
                            append-icon="mdi-clock-time-four-outline"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                            :rules="[rules.required]"
                            clearable
                          ></v-text-field>
                        </template>
                        <v-time-picker
                          v-if="menu2"
                          v-model="editedItem.termina"
                          full-width
                          scrollable
                          @click:minute="$refs.menu.save(editedItem.termina)"
                        ></v-time-picker>
                      </v-menu>
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
                >¿Estás seguro de borrar este químico?</v-card-title
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
  props: {
    spaces: {
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
    icon: true,
    ueb: [],
    cc: [],
    a: [],
    c: [],
    menu1: false,
    menu2: false,
    time: null,
    rules: {
      required: (v) => !!v || "Este campo es requerido",
    },
    valid: true,
    headers: [
      {
        text: "Granja Productora",
        align: "start",
        sortable: false,
        value: "ueb",
      },
      { text: "C/C", value: "cc" },
      { text: "Área Aplicada", value: "area_aplicada" },
      { text: "Áreac Acum", value: "area_acum" },
      { text: "Tipo Aplicacion", value: "tipo_aplicacion" },
      { text: "Tipo Producto", value: "tipo_producto" },
      { text: "Cant", value: "cant" },
      { text: "Horario de aplicación", value: "comienza" },
      { text: "Cantidad de Equipos", value: "cant_equipos" },
      { text: "Acciones", value: "actions", sortable: false },
    ],
    quimicos: [],
    editedIndex: -1,
    editedItem: {
      cc: "",
      area_aplicada: "",
      area_acum: "",
      tipo_aplicacion: "",
      tipo_producto: "",
      cant: "",
      ueb: "",
      termina: "",
      comienza: "",
    },
    defaultItem: {
      cc: "",
      area_aplicada: "",
      area_acum: "",
      tipo_aplicacion: "",
      tipo_producto: "",
      cant: "",
      ueb: "",
      termina: "",
      comienza: "",
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo Químico" : "Editar Químico";
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
        .get("/api/quimicos", {})
        .then((res) => {
          this.quimicos = res.data.quimicos;
          this.ueb = res.data.uebs;
          this.cc = res.data.cc;
          this.a = res.data.area_aplicada;
          this.c = res.data.area_acum;
        })
        .catch((err) => console.log(err));
    },

    editItem(item) {
      this.editedIndex = this.quimicos.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.quimicos.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      axios
        .delete("/api/quimicos/" + this.editedItem.id)
        .then((res) => {
          this.quimicos.splice(this.editedIndex, 1);
          this.snackbar = true,
          this.text = "Químico eliminado",
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
          .put("/api/quimicos/" + this.editedItem.id, this.editedItem)
          .then((res) => {
            this.initialize();
            this.snackbar = true,
            this.text = "Químico editado",
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
          .post("/api/quimicos", this.editedItem)
          .then((res) => {
            console.dir(res);
            this.quimicos.push(res.data.quimicos);
            this.snackbar = true,
            this.text = "Químico añadido",
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
      }
      this.close();
    },
    loadFile(url, callback) {
      PizZipUtils.getBinaryContent(url, callback);
    },
    renderDoc() {
      let quimicos = this.quimicos;
      let cc = this.cc;
      let a = this.a;
      let c = this.c;
      this.loadFile("/documentos/quimicos.docx", function (error, content) {
        if (error) {
          throw error;
        }
        const zip = new PizZip(content);
        const doc = new Docxtemplater(zip, {
          paragraphLoop: true,
          linebreaks: true,
        });
        doc.setData({ quimicos, cc, a, c });
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
        saveAs(out, "quimicos.docx");
      });
    },
  },
};
</script>