<template>
  <div class="container">
    <div class="h-full card rounded-md p-6 has-background-light">
      <div class="row h-full">
        <div class="col-12 col-md-6">
          <div class="row h-full">
            <div class="col-12 col-md-6 text-center">
              <b-button
                v-b-modal.create-room-modal
                class="btn btn-secondary btn-block h-full text-3xl font-bold flex items-center justify-center"
              >Crear un nuevo juego</b-button>
            </div>
            <div class="col-12 col-md-6 text-center ">
              <b-button
                v-b-modal.join-room-modal
                class="btn btn-primary btn-block h-full text-3xl font-bold flex items-center justify-center mt-4"
              >Unirse a una partida</b-button>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 p-16">
          <div class="border-4 border-gray-600 h-full rounded-md p-8 text-black">
            <div>
              <p class="font-bold text-4xl">Hola!</p>
              <p
                class="text-3xl text-black"
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
      </div>
    </div>
    <b-modal
      id="create-room-modal"
      ref="modal"
      title="Crear nueva sala"
      @show="resetModal"
      @hidden="resetModal"
      @ok="createOk"
    >
      <form ref="formcreate" @submit.stop.prevent="createSubmit">
        <b-form-group
          :state="nameState"
          label="Nombre"
          label-for="name-input"
          invalid-feedback="El nombre es obligatorio"
        >
          <b-form-input id="name-input" v-model="alias" :state="nameState" required></b-form-input>
        </b-form-group>
      </form>
    </b-modal>
    <b-modal
      id="join-room-modal"
      ref="modal"
      title="Unirse a una sala"
      @show="getRooms"
      @hidden="resetModal"
      @ok="joinOk"
    >
      <form ref="formjoin" @submit.stop.prevent="joinSubmit">
        <b-form-group
          :state="nameState"
          label="Nombre"
          label-for="name-input"
          invalid-feedback="El nombre es obligatorio"
        >
          <b-form-input id="name-input" v-model="alias" :state="nameState" required></b-form-input>
        </b-form-group>
        <b-form-group
          label="Número de sala"
          label-for="sala_id"
        >
          <b-form-select v-model="sala_id" :options="roomsAvailable"></b-form-select>
        </b-form-group>
        <b-form-group
          label="Contraseña"
          label-for="pwd"
        >
          <b-form-input id="pwd" v-model="password" required type="password"></b-form-input>
        </b-form-group>
      </form>
    </b-modal>
  </div>
</template>

<script>
export default {
    data(){
        return{
            nameState: null,
            alias: '',
            sala_id: null,
            password: '',
            rooms: []
        }
    },
    computed:{
      roomsAvailable(){
        if(this.rooms.length > 0){
          return this.rooms.map(room => {
            return {
              value: room,
              text: "Sala #" + room
            }
          });
        }
        return [];
      }
    },
    methods: {
      getRooms(){
        Room.getAvailable().then(rooms => {
          this.rooms = rooms;
        });
      },
      checkFormCreateValidity() {
        const valid = this.$refs.formcreate.checkValidity()
        this.nameState = valid
        return valid
      },
      checkFormJoinValidity() {
        const valid = this.$refs.formjoin.checkValidity()
        this.nameState = valid
        return valid
      },
      resetModal() {
        this.alias = ''
        this.sala_id = null
        this.password = null
        this.nameState = null
      },
      createOk(bvModalEvt) {
        bvModalEvt.preventDefault()
      
        this.createSubmit()
      },
      createSubmit() {
        if (!this.checkFormCreateValidity()) {
          return
        }
        this.$nextTick(() => {
          Room.create(this.alias);
          this.$bvModal.hide('modal-prevent-closing')
        })
      },
      joinOk(bvModalEvt) {
        // Prevent modal from closing
        // Trigger submit handler
        this.joinSubmit()
      },
      joinSubmit() {
        if (!this.checkFormJoinValidity()) {
          return
        }
        this.$nextTick(() => {
          let data = {
            alias: this.alias,
            password: this.password,
            room_id: this.sala_id
          }
          Room.join(data).then(() => {
            console.log(data);
            
          });
          this.$bvModal.hide('modal-prevent-closing')
        })
      }
    }
};
</script>

<style>
</style>