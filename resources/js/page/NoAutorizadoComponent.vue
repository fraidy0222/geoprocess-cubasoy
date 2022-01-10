<template>
    <v-row justify="center" align="center" class="mx-4">
      <!-- <div>
        <p>403</p>
        <v-divider vertical></v-divider>
        <p>No tienes los permisos necesarios</p>
      </div> -->
      <v-card>
        <v-card-title> 
          403 
          <v-divider vertical class="mx-3"></v-divider>
          No tienes los permisos necesarios

          <v-spacer></v-spacer>
            <v-icon color="error" class="mx-3">
              mdi-alert-outline
            </v-icon>
          </v-card-title>
      </v-card>
    </v-row>
</template>

<script>
export default {
  
}
</script>