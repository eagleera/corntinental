<template>
  <b-container class="h-full card rounded-md md:p-6 has-background-light pt-4">
      <p>Inicia sesión</p>
    <b-row>
      <div class="col-12">
        <div class="h-full rounded-md px-8 py-4 text-black">
          <div>
            <p class="font-bold text-4xl">Hola!</p>
            <p
              class="text-2xl text-black"
            >Para empezar a llevar la cuenta de tus juegos y puntuaciones inicia sesión o crea una cuenta!</p>
          </div>
          <div class="columns mt-16 is-multiline">
            <div class="column is-12">
              <a class="btn btn-primary btn-block text-xl font-bold" href="/login">Iniciar sesión</a>
            </div>
            <div class="column is-12 mt-3">
              <a
                class="btn btn-secondary btn-block h-full text-xl font-bold"
                href="/register"
              >Crear una cuenta</a>
            </div>
          </div>
        </div>
      </div>
    </b-row>
    <b-modal
      id="create-room-modal"
      ref="modal"
      title="Crear nueva mesa"
      @show="resetModal"
      @hidden="resetModal"
      @ok="createSubmit"
    >
      <form ref="formcreate" @submit.stop.prevent="createSubmit">
        <b-form-group label="Nombre de la mesa" label-for="name-input">
          <b-form-input id="name-input" v-model="room_name" required></b-form-input>
        </b-form-group>
        <b-form-group label="Tu nombre" label-for="name-input">
          <b-form-input id="name-input" v-model="alias" required></b-form-input>
        </b-form-group>
      </form>
    </b-modal>
    <b-modal
      id="join-room-modal"
      ref="modal"
      title="Unirse a una sala"
      @show="getRooms"
      @hidden="resetModal"
      @ok="joinSubmit"
    >
      <form ref="formjoin" @submit.stop.prevent="joinSubmit">
        <b-form-group label="Nombre" label-for="name-input">
          <b-form-input id="name-input" v-model="alias" required></b-form-input>
        </b-form-group>
        <b-form-group label="Número de sala" label-for="sala_id">
          <b-form-select v-model="sala_id" :options="roomsAvailable"></b-form-select>
        </b-form-group>
        <b-form-group label="Contraseña" label-for="pwd">
          <b-form-input id="pwd" v-model="password" required type="password"></b-form-input>
        </b-form-group>
      </form>
    </b-modal>
  </b-container>
</template>

<script>
export default {
    name: "Login"
}
</script>