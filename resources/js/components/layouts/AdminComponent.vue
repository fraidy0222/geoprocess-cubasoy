<template>
  <div>
    <v-navigation-drawer
      v-model="drawer"
      :clipped="$vuetify.breakpoint.lgAndUp"
      app
    >
      <v-list-group :value="true" v-if="Admin">
        <template v-slot:activator>
          <v-list-item-title>Seguridad</v-list-item-title>
        </template>
        <v-list-item-group color="primary">
          <v-list-item
            v-for="(item, i) in security"
            :key="i"
            link
            :to="item.action"
          >
            <v-list-item-action>
              <v-icon v-text="item.icon"></v-icon>
            </v-list-item-action>

            <v-list-item-content>
              <v-list-item-title v-text="item.text"></v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>

      <v-list-group :value="true" v-if="Admin">
        <template v-slot:activator>
          <v-list-item-title>Administración</v-list-item-title>
        </template>

        <v-list-item-group color="primary">
          <v-list-item
            v-for="(item, i) in items"
            :key="i"
            link
            :to="item.action"
          >
            <v-list-item-action>
              <v-icon v-text="item.icon"></v-icon>
            </v-list-item-action>

            <v-list-item-content>
              <v-list-item-title v-text="item.text"></v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>

      <v-list-group>
        <template v-slot:activator>
          <v-list-item-title>Gestión</v-list-item-title>
        </template>

        <v-list-item-group color="primary">
          <v-list-item
            v-for="(item, i) in gestion"
            :key="i"
            link
            :to="item.action"
          >
            <v-list-item-action>
              <v-icon v-text="item.icon"></v-icon>
            </v-list-item-action>

            <v-list-item-content>
              <v-list-item-title v-text="item.text"></v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list-group>


    </v-navigation-drawer>

    <v-app-bar :clipped-left="$vuetify.breakpoint.lgAndUp" app>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>
        <span>Goeprocess</span>
      </v-toolbar-title>
      <v-spacer></v-spacer>
        <v-tooltip bottom>
        <template v-slot:activator="{ on, attrs }">
          <v-btn 
          icon 
          @click="toggle_dark_mode"
          v-on="on"
          v-bind="attrs"
          >
        <v-icon>mdi-brightness-4</v-icon>
      </v-btn>
        </template>
        <span>Cambiar Tema</span>
      </v-tooltip>
      
      <v-tooltip bottom>
        <template v-slot:activator="{ on, attrs }">
          <v-btn v-bind="attrs" v-on="on" icon @click="logout">
            <v-icon>mdi-logout</v-icon>
          </v-btn>
        </template>
        <span>Cerrar Sesión</span>
      </v-tooltip>
    </v-app-bar>
    <v-main>
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-main>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data: () => ({
    drawer: null,
    items: [
      { text: "Cultivos (OK)", icon: "mdi-tree", action: "/cultivos" },
      { text: "UEB (OK)", icon: "mdi-city", action: "/ueb" },
      { text: "Reporte General", icon: "mdi-clipboard-text-outline" },
    ],
    gestion: [
      { text: "Máquinas de Riego", icon: "mdi-watering-can-outline", action:'/maquinas_riego' },
      { text: "Siembra (Me falta algunas cosas)", icon: "mdi-upload" },
      {
        text: "Químicos(Falta)",
        icon: "mdi-flask-empty-outline",
        action: "/quimicos",
      },
      {
        text: "Ausencias (OK)",
        icon: "mdi-account-multiple-check-outline",
        action: "/ausencias",
      },
      {
        text: "Valores (OK)",
        icon: "mdi-cash-usd-outline",
        action: "/valores",
      },
      {
        text: "Energía y Combustible",
        icon: "mdi-corn",
        action: "/energia_combustible",
      },
    ],
    security: [
      {
        text: "Roles (OK)",
        icon: "mdi-shield-account-outline",
        action: "/roles",
      },
      {
        text: "Usuarios (OK)",
        icon: "mdi-account-outline",
        action: "/users",
      },
    ],
  }),
  mounted() {
    const theme = localStorage.getItem("dark_theme");
    if (theme) {
      if (theme === "true") {
        this.$vuetify.theme.dark = true;
      } else {
        this.$vuetify.theme.dark = false;
      }
    } else if (
      window.matchMedia &&
      window.matchMedia("prefers-color-scheme: dark").matches
    ) {
      this.$vuetify.theme.dark = true;
      localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString);
    }
  },

  computed: {
    ...mapGetters(['Admin'])
  },

  methods: {
    logout: function () {
      localStorage.removeItem("token");
      this.$router.push("/login");
    },
    toggle_dark_mode() {
      this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
      localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString());
    },
  },
};
</script>


