<template>
    <div>
         <!-- Modal creacion de clientes -->
        <b-modal ref="modal-cliente" hide-footer no-close-on-backdrop :title="tituloModal" size="lg">        
            <div class="row">
                
                <div class="col-md-12">
                    <label for="id">Identificacion</label>
                    <input type="text" class="form-control" v-model="cliente.id" v-show="btnCrear">
                    <input type="text" class="form-control" v-model="cliente.id" v-show="btnCrear === false" readonly>
                    <span class="text-danger text-small">{{errores.id}}</span>
                </div>
                <div class="col-md-12">
                    <label for="nombres">Nombres</label>
                    <input type="text" class="form-control" v-model="cliente.nombres">
                </div>
                <div class="col-md-12">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" class="form-control" v-model="cliente.apellidos">
                </div>
                <div class="col-md-12">
                    <label for="direccion">Direccion</label>
                    <input type="text" class="form-control" v-model="cliente.direccion">
                </div>
                <div class="col-md-12">
                    <label for="telefono">Telefono</label>
                    <input type="number" class="form-control" v-model.number="cliente.telefono">
                </div>
                <div class="col-md-12">
                    <label for="email">Correo electronico</label>
                    <input type="email" class="form-control" v-model="cliente.email">
                    <span class="text-danger text-small">{{errores.email}}</span>
                </div>
                <div class="col-md-12 mt-3">
                    <button class="btn btn-primary" @click="guardarcliente" v-if="btnCrear">Guardar</button>
                    <button class="btn btn-warning" @click="editarcliente" v-else>Editar</button>
                </div>
            </div>
            <div class="row my-3" v-if="mensajeOk">
                <div class="col-md-12">
                    <p class="alert alert-info">Agregado correctamente</p>
                </div>
            </div>
        </b-modal>
        <div class="d-flex justify-content-between my-3">
            <div>
                <h1>clientes</h1>
            </div>
            <div>
                <button class="btn btn-success" @click="crearcliente" ><i class="fas fa-plus-square mr-2"></i>Agregar</button>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in clientes" :key="index">
                    <td>{{item.id}}</td>
                    <td>{{item.nombres}}</td>
                    <td>{{item.apellidos}}</td>
                    <td>{{item.direccion}}</td>
                    <td>{{item.telefono}}</td>
                    <td>{{item.email}}</td>
                    <td>
                        <button class="btn btn-warning" title="Editar" @click="mostrarCliente(item.id)"><i class="fas fa-edit"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
        
    </div>
</template>
<script>
    export default {
        data() {
            return {
                btnCrear: true,
                cliente: {id: '', nombres: '', apellidos: '', direccion: '', telefono: '', email: ''},
                clientes: [],
                errores: '',
                mensajeOk: false,
                tituloModal: ''
            }
        },
        mounted() {
            this.getClientes()
        },
        methods: {
            crearcliente(){

                this.cliente.id = '';
                this.cliente.nombres = '';
                this.cliente.apellidos = '';
                this.cliente.direccion = '';
                this.cliente.telefono = '';
                this.cliente.email = '';

                this.mensajeOk = false;
                this.btnCrear = true;
                this.tituloModal = 'Crear cliente';
                this.errores = '';
                this.$refs['modal-cliente'].show();
            },
            editarcliente(){
                if(this.cliente.id === '' || this.cliente.nombres === '' || this.cliente.apellidos === '' || this.cliente.direccion === '' || this.cliente.telefono === '' || this.cliente.email === ''){
                    alert('Hay campos vacios');
                    return;
                }

                axios.put(`/clientes/${this.cliente.id}`, this.cliente)
                    .then(res => {
                        if(res.data === 'ok'){
                            this.mensajeOk = true;
                            this.getClientes();
                        }else{
                            this.errores = res.data;
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            getClientes(){
                axios.get('/clientes')
                    .then(res => {
                        this.clientes = res.data
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            guardarcliente(){
                if(this.cliente.id === '' || this.cliente.nombres === '' || this.cliente.apellidos === '' || this.cliente.direccion === '' || this.cliente.telefono === '' || this.cliente.email === ''){
                    alert('Hay campos vacios');
                    return;
                }

                axios.post('/clientes', this.cliente)
                    .then(res => {
                        if(res.data === 'ok'){
                            this.mensajeOk = true;
                            this.getClientes();
                        }else{
                            this.errores = res.data;
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            mostrarCliente(id){

                axios.get(`/clientes/${id}`)
                    .then(res => {
                        this.cliente.id = res.data.id;
                        this.cliente.nombres = res.data.nombres;
                        this.cliente.apellidos = res.data.apellidos;
                        this.cliente.direccion = res.data.direccion;
                        this.cliente.telefono = res.data.telefono;
                        this.cliente.email = res.data.email;

                        this.mensajeOk = false;
                        this.btnCrear = false;
                        this.tituloModal = 'Editar cliente';
                        this.errores = '';
                        this.$refs['modal-cliente'].show();

                    })
                    .catch(err => {
                        console.log(err)
                    })

            }
        },
    }
</script>