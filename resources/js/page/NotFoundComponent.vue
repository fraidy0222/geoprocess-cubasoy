<template>
  <v-container class="fill-height" fluid>
    <v-row justify="center" align="center">
      <v-col sm="6">
        <v-img
          :src="require('../../assets/img/404.svg')"
          max-width="700"
          max-height="500"
        />
      </v-col>
    </v-row>
    <div class="mx-auto">
      <v-btn class="mb-10" color="primary" link @click="$router.go(-1)"
        >Regresar</v-btn>
    </div>
  </v-container>
</template>

<script>
export default {};
</script>