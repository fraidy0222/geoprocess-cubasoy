<template>
  <div>
    <v-navigation-drawer
      v-model="drawer"
      :clipped="$vuetify.breakpoint.lgAndUp"
      app
    >
      <v-list-group :value="true" class="mt-3">
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
    </v-navigation-drawer>

    <v-app-bar :clipped-left="$vuetify.breakpoint.lgAndUp" app>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>
        <router-link :to="{ path: 'inicio' }" class="nombre"
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
    security: [
      {
        text: "Roles",
        icon: "mdi-shield-account-outline",
        action: "/admin/roles",
      },
      {
        text: "Usuarios",
        icon: "mdi-account-outline",
        action: "/admin/usuarios",
      },
    ],
  }),
  // mounted() {
  //   role: () => {
  //     const role = '';
  //     return  role = localStorage.getItem('role');
  //     console.log(role);
  //   }
  // },

  created() {
    return window.localStorage.getItem('role');
  },
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


