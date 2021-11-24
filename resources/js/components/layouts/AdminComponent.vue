<template>
  <div>
    <v-navigation-drawer
      v-model="drawer"
      :clipped="$vuetify.breakpoint.lgAndUp"
      app
    >
      <v-list-group :value="true">
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

      <v-list-group :value="true">
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

      <v-list-group :value="true">
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
        <router-link :to="{ name: 'home' }" class="nombre"
          >GeoProcess</router-link
        >
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-menu transition="scale-transition" offset-y min-width="200px">
        <template v-slot:activator="{ on, attrs }">
          <v-btn icon v-bind="attrs" v-on="on">
            <v-icon>mdi-cog-outline</v-icon>
          </v-btn>
        </template>
        <v-card>
          <v-list-item-content class="justify-center">
            <div class="mx-auto text-center">
              <v-btn text @click="toggle_dark_mode"
                ><v-icon class="mr-2">mdi-brightness-4</v-icon> Cambiar
                Tema</v-btn
              >
            </div>
          </v-list-item-content>
          <v-list-item-content>
            <div class="mx-auto text-center">
              <v-btn text class="mb-5" @click="logout"
                ><v-icon>mdi-logout</v-icon>Cerrar Sesión</v-btn
              >
            </div>
          </v-list-item-content>
        </v-card>
      </v-menu>
    </v-app-bar>
    <v-main>
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-main>
  </div>
</template>

<style scoped>
.nombre {
  color: rgba(0, 0, 0, 0.87);
  text-decoration: none;
}
</style>
<script>
export default {
  data: () => ({
    drawer: null,
    items: [
      { text: "Cultivos (OK)", icon: "mdi-tree", action: "/admin/cultivos" },
      { text: "UEB (OK)", icon: "mdi-city", action: "/admin/ueb" },
      { text: "Reporte General", icon: "mdi-clipboard-text-outline" },
    ],
    gestion: [
      {
        text: "Máquinas de Riego (OK)",
        icon: "mdi-watering-can-outline",
        action: "/admin/maquinas_riego",
      },
      { text: "Siembra (OK)", icon: "mdi-tractor", action: "/admin/siembra" },
      {
        text: "Químicos(OK)",
        icon: "mdi-flask-empty-outline",
        action: "/admin/quimicos",
      },
      {
        text: "Ausencias (OK)",
        icon: "mdi-account-multiple-check-outline",
        action: "/admin/ausencias",
      },
      {
        text: "Valores (OK)",
        icon: "mdi-cash-usd-outline",
        action: "/admin/diaria_acumuladas_por_valores",
      },
      {
        text: "Toneladas (OK)",
        icon: "mdi-scale",
        action: "/admin/diaria_acumuladas_por_toneladas",
      },
      {
        text: "Energía-Combustible",
        icon: "mdi-fuel",
        action: "/admin/energia_combustible",
      },
    ],
    security: [
      {
        text: "Roles (OK)",
        icon: "mdi-shield-account-outline",
        action: "/admin/roles",
      },
      {
        text: "Usuarios (OK)",
        icon: "mdi-account-outline",
        action: "/admin/users",
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


