<template>
  <div>
    <v-row>
      <v-col cols="12" sm="4" xs="12">
        <v-card>
          <v-card-text>
            Maquinas de Riego
          </v-card-text>
        </v-card>
      </v-col >
       <v-col cols="12" sm="4" xs="12">
        <v-card>
          <v-card-text>Máquinas Listas</v-card-text>
        </v-card>
      </v-col>
       <v-col cols="12" sm="4" xs="12">
        <v-card>
          <v-card-text>Máquinas Rotas</v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <!-- <ul v-for="(count, index) in counts" :key="index">
      <li>{{ count.total }}</li>
    </ul>
     <ul v-for="lista in listas" :key="lista.index">
      <li>{{ lista.listas }}</li>
    </ul> -->
    <!-- <v-row>
      <v-col cols="12" sm="3">
        <v-chip class="ma-2" color="primary" text-color="white">
          Máquinas de riego: {{ rowTotal("total_maquinas_riego") }}
          <v-icon right> mdi-gauge-full </v-icon>
        </v-chip>
      </v-col>
      <v-col cols="12" sm="3">
        <v-chip class="ma-2" color="success" text-color="white">
          Máquinas Listas: {{ rowTotal("maquinas_listas") }}
          <v-icon right> mdi-checkbox-marked-circle </v-icon>
        </v-chip>
      </v-col>
      <v-col cols="12" sm="3">
        <v-chip class="ma-2" color="error" text-color="white">
          Máquinas Rotas: {{ rotas("maquinas_rotas") }}
          <v-icon right> mdi-close-circle </v-icon>
        </v-chip>
      </v-col>
      <v-col cols="12" sm="3">
        <v-chip class="ma-2" color="warning" text-color="white">
          Fecha: {{ this.date }}
          <v-icon right> mdi-clock </v-icon>
        </v-chip>
      </v-col>
    </v-row> -->
    <v-data-table
      item-key="id"
      class="elevation-1"
      :search="search"
      disable-sort
      no-results-text="No exite este elemento"
      :loading="loading"
      loading-text="Cargando... Por favor espere"
      :headers="headers"
      :items="maquinas"
      :items-per-page="10"
      :footer-props="{
        'items-per-page-options': [10, 15, 20],
        'items-per-page-text': 'Máquinas de riego por páginas',
      }"
    >
      <template v-slot:[`item.maquinas_listas`]="{ item }">
        <v-chip color="success" dark>
          {{ item.maquinas_listas }}
        </v-chip>
      </template>
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Máquinas de Reigo</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="600px" persistent>
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                <v-icon>mdi-plus</v-icon>
                Añadir
              </v-btn>
              <v-btn @click="renderDoc" color="success" dark class="mb-2 mr-2">
                Exportar a Word
              </v-btn>
            </template>
            <v-form ref="form" v-model="valid" @submit.prevent="save">
              <v-card>
                <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
                </v-card-title>
                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col cols="12" md="6" >
                        <v-select
                          :items="ueb"
                          v-model="editedItem.ueb"
                          label="Selecione una ube"
                          :rules="Rules"
                          no-data-text="No hay elementos"
                          append-icon="mdi-chevron-down"
                        ></v-select>
                      </v-col>
                      <v-col cols="12" md="6" >
                        <v-text-field
                          v-model="editedItem.total_maquinas_riego"
                          label="Máquinas de Riego"
                          required
                          :rules="Rules"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" md="6" >
                        <v-text-field
                          v-model="editedItem.maquinas_listas"
                          label="Máquinas listas"
                          required
                          :rules="Rules"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" md="6" >
                        <v-textarea
                          v-model="editedItem.afectaciones"
                          auto-grow
                          label="Afectaciones"
                          required
                          :rules="Rules"
                          rows="1"
                        ></v-textarea>
                      </v-col>
                      <v-col cols="12" md="6" >
                        <v-autocomplete
                          v-model="editedItem.maquinas_rotas"
                          :items="options"
                          chips
                          clearable
                          multiple
                          item-text="name"
                          label="Máquinas rotas"
                          append-icon="mdi-chevron-down"
                        >
                          <template
                            v-slot:selection="{ attr, on, item, selected }"
                          >
                            <v-chip
                              v-bind="attr"
                              :input-value="selected"
                              color="red"
                              class="white--text"
                              v-on="on"
                            >
                              <span>{{ item }}</span>
                            </v-chip>
                          </template>
                        </v-autocomplete>
                      </v-col>
                       
                    </v-row>
                  </v-container>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                 <v-btn 
                    color="red darken-1" 
                    outlined
                    @click="close">
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
              </v-card>
            </v-form>
          </v-dialog>
          <v-dialog persistent v-model="dialogDelete" max-width="500px">
            <v-card >
              <v-card-title class="headline"
                >¿Estás seguro de borrar esta máquina de riego?</v-card-title
              >
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn outlined  @click="closeDelete">Cancelar</v-btn>
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

<script>
// docxtemplater
import Docxtemplater from "docxtemplater";
import PizZip from "pizzip";
import PizZipUtils from "pizzip/utils/index.js";

import {saveAs} from 'file-saver';
export default {
  data: () => ({
    valid: true,
    search: "",
    dialog: false,
    loading: false,
    dialogDelete: false,
    text: "",
    snackbar: false,
    snackColor: "",
    timeout: 2000,
    options: [],
    modal: false,
    counts: [],
    listas: [],
    ueb: [],
    date: new Date().toISOString().substr(0, 10),
    headers: [
      {
        text: "ID",
        align: "start",
        sortable: false,
        value: "id",
      },
      { text: "UEB", value: "ueb" },
      { text: "Máquinas de Riego", value: "total_maquinas_riego" },
      { text: "Listas", value: "maquinas_listas" },
      { text: "Rotas", value: "maquinas_rotas" },
      { text: "Afectaciones", value: "afectaciones" },
      { text: "Acciones", value: "actions", sortable: false },
    ],
    maquinas: [],
    editedIndex: -1,
    Rules: [(v) => !!v || "Este campo es requerido"],
    editedItem: {
      id: "",
      ueb: "",
      total_maquinas_riego: "",
      maquinas_listas: "",
      maquinas_rotas: "",
      afectaciones: "",
    },
    defaultItem: {
      id: "",
      ueb: "",
      total_maquinas_riego: "",
      maquinas_listas: "",
      maquinas_rotas: "",
    },
  }),
  computed: {
    formTitle() {
      return this.editedIndex === -1
        ? "Nueva Máquina de Riego"
        : "Editar Máquina de Riego";
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
    this.listado();
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
        .get("api/maquinas", {})
        .then((res) => {
          this.maquinas = res.data.maquina;
          this.ueb = res.data.uebs
        })
        .catch((err) => {
          if (err.response.status == 401) {
            localStorage.removeItem("token");
            this.$router.push("/login");
          }
        });
    },

    editItem(item) {
      this.editedIndex = this.maquinas.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.maquinas.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      axios
        .delete("api/maquinas/" + this.editedItem.id)
        .then((res) => {
          this.maquinas.splice(this.editedIndex, 1);
          (this.snackbar = true),
            (this.text = "Maquina de reigo eliminada"),
            (this.snackColor = "success");
              this.initialize()
        })
        .catch((err) => {
          (this.snackbar = true),
            (this.text = "Ha occurido un error"),
            (this.snackColor = "error");
          console.log(err.response);
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
          .put("api/maquinas/" + this.editedItem.id, this.editedItem)
          .then((res) => {
            this.initialize();
            this.snackbar = true,
            this.text = "Maquina de riego editada",
            this.snackColor = "success";
          })
          .catch((err) => {
            this.snackbar = true,
            this.text = "Ha occurido un error",
            this.snackColor = "error";
          });
      } else {
        axios
          .post("api/maquinas", this.editedItem)
          .then((res) => {
            this.maquinas.push(res.data.maquina);
            this.snackbar = true,
            this.text = "Maquina de riego añadida",
            this.snackColor = "success";
          })
          .catch(err => {
            this.snackbar = true,
            this.text = "Ha occurido un error",
            this.snackColor = "error";
          });
      }
      this.close();
    },
    listado() {
      for (let index = 0; index < 1000; index++) {
        this.options.push(`${index}`);
      }
    },
    loadFile(url, callback) {
      PizZipUtils.getBinaryContent(url, callback);
    },
    renderDoc() {
      let maquina = this.maquinas;
      this.loadFile("/documentos/maquinas.docx", function(
        error,
        content
      ) {
        if (error) {
          throw error;
        }
        const zip = new PizZip(content);
        const doc = new Docxtemplater(zip, { paragraphLoop: true, linebreaks: true });
        doc.setData({ maquina });
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
        saveAs(out, "maquinas.docx");
      });
    },
  },
};
</script>