<template>
  <v-container>
    <v-data-table :items="data" class="elevation-1">
      <template v-slot:header>
        <thead>
          <tr>
            <th>Granja Productora</th>
            <th>C/C</th>
            <th>Cultivo</th>
            <th>Area</th>
            <th colspan="3" class="text-center">Siembra</th>
            <th colspan="2" class="text-center">Semilla</th>
            <th colspan="2">Cant.Fertili</th>
          </tr>
          <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>Real</th>
            <th>Plan</th>
            <th>Acum</th>
            <th>Diaria</th>
            <th>Acum</th>
            <th>Diaria</th>
            <th>Acum</th>
          </tr>
        </thead>
      </template>
    <template v-slot:body="{ items }">
      <tbody>
        <tr
          v-for="item in items"
          :key="item.name"
        >
          <td>{{ item.name }}</td>
          <td>{{item.calories}}</td>
          <td>{{item.fat}}</td>
          <td>{{item.carbs}}</td>
          <td>{{item.protein}}</td>
          <td>{{item.iron}}</td>
          <td>{{item.iron}}</td>
          <td>{{item.iron}}</td>
          <td>{{item.iron}}</td>
          <td>{{item.iron}}</td>
          <td>{{item.iron}}</td>

        </tr>
      </tbody>
    </template>
    </v-data-table>
    <h1>Role Editor</h1>
    <v-btn outlined color="blue" @click="logout"> Cerrar Sesión </v-btn>
  </v-container>
</template>


<style scoped>
  .theme--light.v-data-table>.v-data-table__wrapper>table>thead>tr>th {
    border-bottom: 1px solid rgba(0, 0, 0, .12);
    border-right: 1px solid rgba(0, 0, 0, .12);
  }
</style>
<script>
export default {
  data: () => ({
    name: "",
    headers: [
      {
        text: "Dessert (100g serving)",
        align: "start",
        sortable: false,
        value: "name",
      },
      { text: "Calories", value: "calories" },
      { text: "Fat (g)", value: "fat" },
      { text: "Carbs (g)", value: "carbs" },
      { text: "Protein (g)", value: "protein" },
      { text: "Iron (%)", value: "iron" },
    ],
    data: [
      {
        name: "Frozen Yogurt",
        calories: 159,
        fat: 6.0,
        carbs: 24,
        protein: 4.0,
        iron: "1%",
      },
      {
        name: "Ice cream sandwich",
        calories: 237,
        fat: 9.0,
        carbs: 37,
        protein: 4.3,
        iron: "1%",
      },
      {
        name: "Eclair",
        calories: 262,
        fat: 16.0,
        carbs: 23,
        protein: 6.0,
        iron: "7%",
      },
      {
        name: "Cupcake",
        calories: 305,
        fat: 3.7,
        carbs: 67,
        protein: 4.3,
        iron: "8%",
      },
      {
        name: "Gingerbread",
        calories: 356,
        fat: 16.0,
        carbs: 49,
        protein: 3.9,
        iron: "16%",
      },
      {
        name: "Jelly bean",
        calories: 375,
        fat: 0.0,
        carbs: 94,
        protein: 0.0,
        iron: "0%",
      },
      {
        name: "Lollipop",
        calories: 392,
        fat: 0.2,
        carbs: 98,
        protein: 0,
        iron: "2%",
      },
      {
        name: "Honeycomb",
        calories: 408,
        fat: 3.2,
        carbs: 87,
        protein: 6.5,
        iron: "45%",
      },
      {
        name: "Donut",
        calories: 452,
        fat: 25.0,
        carbs: 51,
        protein: 4.9,
        iron: "22%",
      },
      {
        name: "KitKat",
        calories: 518,
        fat: 26.0,
        carbs: 65,
        protein: 7,
        iron: "6%",
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