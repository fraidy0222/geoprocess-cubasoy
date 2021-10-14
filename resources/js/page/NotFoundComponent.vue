<template>
  <v-row justify="center" align="center">
    <v-col cols="12" sm="6">
      <v-img
        :src="require('../../assets/notFound.svg')"
        max-width="700"
        max-height="500"
      >
        <template v-slot:placeholder>
          <v-row
            class="fill-height ma-0"
            align="center"
            justify="center"
          >
            <v-progress-circular
              indeterminate
              color="grey lighten-5"
            ></v-progress-circular>
          </v-row>
        </template>
      </v-img>
    </v-col>
  </v-row>
</template>

<script>
export default {
  
}
</script>