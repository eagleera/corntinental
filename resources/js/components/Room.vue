<template>
    <div class="card rounded-sm p-4">
        <div class>este es mi room</div>
        <p>{{ prueba }} </p>
    </div>
</template>
<script>
export default {
    name: "room",
    data(){
        return {
            prueba: 10
        }
    },
    mounted(){
        Echo.channel('joinChannel')
        .listen('JoinEvent', (e) => {
            console.log(e, this.$route.params.id);
           if(this.$route.params.id == e.id){
                this.prueba += 10;
           }
        });
    }
}
</script>