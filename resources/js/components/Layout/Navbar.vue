<template>
  <div class="bg-white">
    <!-- Image and text -->
    <b-navbar variant="faded" type="light">
      <b-navbar-brand href="#" class="flex items-center">
        <img :src="'https://api.adorable.io/avatars/50/'+user.id+'.png'" class="d-inline-block align-top rounded-full" alt="Kitten" />
        <span class="ml-2">
        {{ user.name}}
        </span>
      </b-navbar-brand>
      <b-navbar-nav class="ml-auto">
       <b-nav-item-dropdown right>
          <!-- Using 'button-content' slot -->
          <template v-slot:button-content>
            <span>Opciones</span>
          </template>
          <b-dropdown-item @click="cerrarSesion">Cerrar sesión</b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>
    </b-navbar>
  </div>
</template>
<script>
export default {
  name: "Navbar",
  props: {
    user: Object
  },
  methods: {
    cerrarSesion(){
      User.logout();
    }
  }
};
</script>