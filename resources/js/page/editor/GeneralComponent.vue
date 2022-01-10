<template>
  <div>
   <v-card
     :loading="loading"
      class="mx-auto"
   >
   <template slot="progress">
      <v-progress-linear
        indeterminate
      ></v-progress-linear>
    </template>
    <v-card-title>
      <h2 class="mt-2">Reporte General {{date}}</h2>
      <v-spacer></v-spacer>
      <v-btn class="mt-2" color="success" dark @click="renderDoc">Exportar a Word</v-btn>
    </v-card-title>
    <v-card-text>
      <v-row>
        <v-col cols="12" sm="6" xs="4">
          <v-list>
            <v-subheader>DIARIA Y ACUMULADAS TONELADA</v-subheader>
            <v-list-item
            >
              <v-list-item
                v-for="(item, i) in tonelada"
                :key="i"
              >
                <v-list-item-content>
                  <v-list-item-title>{{item.mes}}T</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-item>
          </v-list>
        </v-col>
        <v-col cols="12" sm="6" xs="4">
           <v-list>
            <v-subheader>DIARIA Y ACUMULADAS VALORES</v-subheader>
            <v-list-item
            >
              <v-list-item
                v-for="(item, i) in valores"
                :key="i"
              >
                <v-list-item-content>
                  <v-list-item-title>${{item.venta}} CUP</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-item>
          </v-list>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12" sm="6" xs="4">
          <v-list>
            <v-subheader class="text-uppercase">Aplicaciones Químicas o Fertilizante</v-subheader>
            <v-list-item
            >
              <v-list-item
                v-for="(item, i) in quimicos"
                :key="i"
              >
                <v-list-item-content>
                  <v-list-item-title>{{item.aplicada}} ha</v-list-item-title>
                  <v-list-item-title>{{item.c}} Máquinas</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-item>
          </v-list>
        </v-col>
        <v-col cols="12" sm="6" xs="4">
            <v-list>
              <v-subheader class="text-uppercase">Cosechas</v-subheader>
              <v-list-item
              >
                <v-list-item
                  v-for="(item, i) in cosecha"
                  :key="i"
                >
                  <v-list-item-content>
                    <v-list-item-title>{{ item.t_diario}}T Tonelada Diario </v-list-item-title>
                    <v-list-item-title>{{ item.name}}</v-list-item-title>
                    <v-list-item-title>{{ item.a_c_diario}}ha Área de Cosecha Diario</v-list-item-title>
                    <v-list-item-title>{{ item.arranque_m}}ha Arranque manual(ha)</v-list-item-title>
                    <v-list-item-title>{{ item.cc}} C/C</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </v-list-item>
            </v-list>
        </v-col>
      </v-row>
        <v-row>
        <v-col cols="12" sm="6" xs="4">
          <v-list>
            <v-subheader class="text-uppercase">Tierra</v-subheader>
            <v-list-item
            >
              <v-list-item
                v-for="(item, i) in tierra"
                :key="i"
              >
                <v-list-item-content>
                  <v-list-item-title>{{item.grada}} ha</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-item>
          </v-list>
        </v-col>
         <v-col cols="12" sm="6" xs="4">
            <v-list>
              <v-subheader class="text-uppercase">Parte Energético</v-subheader>
              <v-list-item
              >
                <v-list-item
                  v-for="(item, i) in energia"
                  :key="i"
                >
                  <v-list-item-content>
                    <v-list-item-title v-text="item.text"></v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </v-list-item>
            </v-list>
        </v-col>
      </v-row>
    </v-card-text>
   </v-card>
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
    loading: true,
    ueb: [],
    cultivo: [],
    tonelada: [],
    valores: [],
    quimicos: [],
    cosecha: [],
    culturale: [],
    general: [],
    tierra: [],
    energia: [
      { text: 'Enegía KW' },
      { text: 'Combustible LT'},    
    ],
    date: new Date().toLocaleDateString(),
  }),

  created() {
    this.initialize();
  },

  // computed: {
  //     date() {
  //       const fecha = new Date();
        
  //       const formatDate = {
  //         dd: fecha.getDate(),
  //         mm: fecha.getMonth(),
  //         yy: fecha.getFullYear()
  //       }
  //       return actual;
  //     },
  //   },

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
        .get("/api/general")
        .then((res) => {
          this.general = res.data.general;
          // this.ueb = res.data.uebs;
          this.cultivo = res.data.cultivo;
          this.tonelada = res.data.tonelada
          this.valores = res.data.valores
          this.quimicos = res.data.quimicos
          this.cosecha = res.data.cosecha
          this.culturale = res.data.culturale
          this.tierra = res.data.tierra
          // console.log(res.data.cosecha)
        })
        .catch((err) => console.log(err));
    },
    loadFile(url, callback) {
      PizZipUtils.getBinaryContent(url, callback);
    },
    renderDoc() {
      let to = this.tonelada;
      let v = this.valores;
      let c = this.cosecha;
      let q = this.quimicos;
      let cu = this.culturale;
      let ti = this.tierra;
      let date = this.date
      this.loadFile("/documentos/general.docx", function (error, content) {
        if (error) {
          throw error;
        }
        const zip = new PizZip(content);
        const doc = new Docxtemplater(zip, {
          paragraphLoop: false,
          linebreaks: false,
        });
        doc.setData({ to,v,c,q,cu,ti,date });
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
        saveAs(out, "general.docx");
      });
    },
  },
};
</script>