<template>
  <div>
    <v-navigation-drawer
      v-model="drawer"
      :clipped="$vuetify.breakpoint.lgAndUp"
      app
    >
      <v-list dense>
        <v-list-group :value="true" prepend-icon="mdi-shield">
          <template v-slot:activator>
            <v-list-item-title>Seguridad</v-list-item-title>
          </template>
          <v-list nav dense>
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
          </v-list>
        </v-list-group>
      </v-list>
      <v-list dense>
        <v-list-group prepend-icon="mdi-cog-outline">
          <template v-slot:activator>
            <v-list-item-title>Admnistración</v-list-item-title>
          </template>
          <v-list nav dense>
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
          </v-list>
        </v-list-group>
      </v-list>
      <v-list dense>
        <v-list-group prepend-icon="mdi-circle-edit-outline">
          <template v-slot:activator>
            <v-list-item-title>Gestión</v-list-item-title>
          </template>
          <v-list nav dense>
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
          </v-list>
        </v-list-group>
      </v-list>

      <template v-slot:append>
        <div class="pa-2">
          <v-btn outlined color="blue" block @click="logout">
            Cerrar Sesión
          </v-btn>
        </div>
      </template>
    </v-navigation-drawer>

    <v-app-bar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      app
      color="blue darken-3"
      dark
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title style="width: 300px" class="ml-0 pl-4">
        <span class="hidden-sm-and-down">Goeprocess</span>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn icon>
        <v-icon>mdi-apps</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon>mdi-bell</v-icon>
      </v-btn>
    </v-app-bar>
    <v-main>
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-main>
  </div>
</template>

<script>
export default {
  data: () => ({
    drawer: null,
    theme: false,
    items: [
      { text: "Cultivos (OK)", icon: "mdi-tree", action: "/admin/cultivos" },
      { text: "UEB (OK)", icon: "mdi-city", action: "/admin/ueb" },
      { text: "Reporte General", icon: "mdi-clipboard-text-outline" },
    ],
    gestion: [
      { text: "Máquinas de Riego", icon: "mdi-watering-can-outline" },
      { text: "Siembra (Me falta algunas cosas)", icon: "mdi-upload" },
      {
        text: "Químicos(Falta)",
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
        action: "/admin/valores",
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
  methods: {
    logout: function () {
      localStorage.removeItem("token");
      this.$router.push("/login");
    },
  },
};
</script>


