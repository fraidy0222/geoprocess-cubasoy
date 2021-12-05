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
      :items="toneladas"
      :items-per-page="10"
      :footer-props="{
        'items-per-page-options': [10, 15, 20],
        'items-per-page-text': 'Toneladas por páginas',
      }"
    >
     <template v-slot:body="{ items }">
        <tbody>
          <tr v-for="item in items" :key="item.id">
            <td>{{ item.cultivo }}</td>
            <td>{{ item.venta_d }}</td>
            <td>{{ item.acum_mes }}</td>
            <td>{{ item.acum_fecha }}</td>
            <td>{{ item.acopio }}</td>
            <td>{{ item.eam }}</td>
            <td>{{ item.encarg_estatal }}</td>
            <td>{{ item.industria }}</td>
            <td>{{ item.cayo_cruz }}</td>
            <td>{{ item.i_ceballos }}</td>
            <td>{{ item.fruta_select }}</td>
            <td>{{ item.otros }}</td>
            <td>{{ item.semilla }}</td>
            <td>{{ item.es_camaguey }}</td>
            <td>
              <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                  <v-btn v-bind="attrs" v-on="on" icon>
                    <v-icon
                      color="warning"
                      class="mr-2"
                      @click="editItem(item)"
                    >
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
            </td>
          </tr>
          <tr v-for="item in sum" :key="item.id">
            <td class="font-weight-black">Total</td>
            <td class="font-weight-black">{{ item.venta }}</td>
            <td class="font-weight-black">{{ item.mes }}</td>
            <td class="font-weight-black">{{ item.fecha }}</td>
            <td class="font-weight-black">{{ item.aco }}</td>
            <td class="font-weight-black">{{ item.eam }}</td>
            <td class="font-weight-black">{{ item.estatal }}</td>
            <td class="font-weight-black">{{ item.indus }}</td>
            <td class="font-weight-black">{{ item.cayo }}</td>
            <td class="font-weight-black">{{ item.i }}</td>
            <td class="font-weight-black">{{ item.frutas }}</td>
            <td class="font-weight-black">{{ item.otros }}</td>
            <td class="font-weight-black">{{ item.semilla }}</td>
            <td class="font-weight-black">{{ item.camaguey }}</td>
            <td></td>
          </tr>
        </tbody>
      </template>
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Toneladas</v-toolbar-title>
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
              </v-card-title>
              <v-form v-model="valid" @submit.stop.prevent="save">
                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col cols="4">
                        <v-select
                          :items="cultivos"
                          v-model="editedItem.cultivo"
                          label="Selecione un producto"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                          no-data-text="No hay elementos"
                          append-icon="mdi-chevron-down"
                        ></v-select>
                      </v-col>
                      <v-col cols="4">
                        <v-text-field
                          v-model="editedItem.venta_d"
                          label="Ventas diarias"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="4">
                        <v-text-field
                          v-model="editedItem.acum_mes"
                          label="Acumulado del mes"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="4">
                        <v-text-field
                          v-model="editedItem.acum_fecha"
                          label="Acum hasta la fecha"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                       <v-col cols="4">
                        <v-text-field
                          v-model="editedItem.acopio"
                          label="Acopio"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="4">
                        <v-text-field
                          v-model="editedItem.eam"
                          label="EAM"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="4">
                        <v-text-field
                          v-model="editedItem.encarg_estatal"
                          label="Encargado Estatal"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="4">
                        <v-text-field
                          v-model="editedItem.industria"
                          label="Industria"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="4">
                        <v-text-field
                          v-model="editedItem.cayo_cruz"
                          label="Cayo Cruz"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="4">
                        <v-text-field
                          v-model="editedItem.i_ceballos"
                          label="I.Ceballos"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="4">
                        <v-text-field
                          v-model="editedItem.fruta_select"
                          label="Fruta Selecta"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                        <v-col cols="4">
                        <v-text-field
                          v-model="editedItem.otros"
                          label="Otros"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="4">
                        <v-text-field
                          v-model="editedItem.semilla"
                          label="Semilla"
                          :rules="[rules.required]"
                          type="number"
                          min="0"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="4">
                        <v-text-field
                          v-model="editedItem.es_camaguey"
                          label="E.S Camagüey"
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
              </v-form>
            </v-card>
          </v-dialog>
          <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="headline"
                >¿Estás seguro de borrar esta tonelada?</v-card-title
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
          class="mx-4 mb-4"
        ></v-text-field>
        <!-- end Buscar -->
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
    search: "",
    dialog: false,
    loading: false,
    dialogDelete: false,
    text: "",
    snackbar: false,
    snackColor: "",
    timeout: 2000,
    cultivos: [],
    valid: true,
    sum: [],
    date: new Date().toISOString().substr(0, 10),
    rules: {
      required: (v) => !!v || "Este campo es requerido",
    },
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
    toneladas: [],
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
      return this.editedIndex === -1 ? "Nueva toneladas" : "Editar toneladas";
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
        .get("/api/toneladas")
        .then((res) => {
          this.toneladas = res.data.toneladas;
          this.cultivos = res.data.cultivos;
          this.sum = res.data.sum
          //console.log( res.data.sum)
        })
        .catch((err) => console.log(err));
    },

    editItem(item) {
      this.editedIndex = this.toneladas.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.toneladas.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      axios
        .delete("/api/toneladas/" + this.editedItem.id)
        .then(res => {
          this.toneladas.splice(this.editedIndex, 1);
          this.snackbar = true,
          this.text = "Toneladas eliminada",
          this.snackColor = "success";
          this.initialize()
        })
        .catch(err => {
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
          .put("/api/toneladas/" + this.editedItem.id, this.editedItem)
          .then((res) => {
            this.initialize();
            this.snackbar = true,
            this.text = "Toneladas editada",
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
          .post("/api/toneladas", this.editedItem)
          .then((res) => {
            this.toneladas.push(res.data.toneladas);
            this.snackbar = true,
            this.text = "Toneladas añadida",
            this.snackColor = "success";
            this.initialize()
            console.log(res)
          })
          .catch(err => {
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
      let t = this.toneladas;
      let s = this.sum;
      this.loadFile("/documentos/toneladas.docx", function(
        error,
        content
      ) {
        if (error) {
          throw error;
        }
        const zip = new PizZip(content);
        const doc = new Docxtemplater(zip, { paragraphLoop: true, linebreaks: true });
        doc.setData({ t, s });
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
        saveAs(out, "toneladas.docx");
      });
    },
  },
};
</script>