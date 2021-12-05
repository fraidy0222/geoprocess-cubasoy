<template>
  <div>
    <v-navigation-drawer
      v-model="drawer"
      :clipped="$vuetify.breakpoint.lgAndUp"
      app
    >
      <v-list-group :value="true" class="mt-3">
        <template v-slot:activator>
          <v-list-item-title>Generar</v-list-item-title>
        </template>

        <v-list-item-group color="primary">
          <v-list-item
            v-for="(item, i) in reportes"
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

      <v-btn text @click="logout">
        <v-icon>mdi-logout</v-icon>
        Cerrar Sesión
      </v-btn>
      <!-- <v-menu transition="scale-transition" offset-y min-width="200px">
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
              <v-btn text @click="logout"
                ><v-icon>mdi-logout</v-icon>Cerrar Sesión</v-btn
              >
            </div>
          </v-list-item-content>
        </v-card>
      </v-menu> -->
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
    reportes: [
      {
        text: "Máquinas de Riego ",
        icon: "mdi-watering-can-outline",
        action: "/usuario_ueb/maquinas_riego",
      },
      { text: "Siembra ", icon: "mdi-tractor", action: "/usuario_ueb/siembra" },
      {
        text: "Químicos",
        icon: "mdi-flask-empty-outline",
        action: "/usuario_ueb/quimicos",
      },
      {
        text: "Ausencias ",
        icon: "mdi-account-multiple-check-outline",
        action: "/usuario_ueb/ausencias",
      },
      {
        text: "Valores ",
        icon: "mdi-cash-usd-outline",
        action: "/usuario_ueb/diaria_acumuladas_por_valores",
      },
      {
        text: "Toneladas ",
        icon: "mdi-scale",
        action: "/usuario_ueb/diaria_acumuladas_por_toneladas",
      },
      {
        text: "Energía-Combustible",
        icon: "mdi-fuel",
        action: "/usuario_ueb/energia_combustible",
      },
    ],
  }),
  // mounted() {
  //   const role = localStorage.getItem("role");
  //   if (role !== "Administrator") {
  //     this.$router.push("/");
  //   }
  // },
  // mounted() {
  //   const theme = localStorage.getItem("dark_theme");
  //   if (theme) {
  //     if (theme === "true") {
  //       this.$vuetify.theme.dark = true;
  //     } else {
  //       this.$vuetify.theme.dark = false;
  //     }
  //   } else if (
  //     window.matchMedia &&
  //     window.matchMedia("prefers-color-scheme: dark").matches
  //   ) {
  //     this.$vuetify.theme.dark = true;
  //     localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString);
  //   }
  // },

  methods: {
    logout: function () {
      localStorage.removeItem("token");
      localStorage.removeItem("role");
      this.$router.push("/login");
    },
    // toggle_dark_mode() {
    //   this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
    //   localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString());
    // },
  },
};
</script>


