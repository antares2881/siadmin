<template>
    <div>
        <!-- Modal creacion de proveedors -->
        <b-modal ref="modal-proveedor" hide-footer no-close-on-backdrop :title="tituloModal" size="lg">        
            <div class="row">
                <div class="col-md-6">
                    <label for="id">Identificacion</label>
                    <input type="number" class="form-control" v-model.number="proveedor.id" v-show="btnCrear">
                    <input type="number" class="form-control" v-model.number="proveedor.id" v-show="btnCrear === false" readonly>
                    <span class="text-danger text-small">{{errores.id}}</span>
                </div>
                <div class="col-md-6">
                    <label for="nombres">Nombres</label>
                    <input type="text" class="form-control" v-model="proveedor.nombres">
                    <span class="text-danger text-small">{{errores.nombres}}</span>
                </div>
                <div class="col-md-6">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" class="form-control" v-model="proveedor.apellidos">
                    <span class="text-danger text-small">{{errores.apellidos}}</span>
                </div>
                <div class="col-md-6">
                    <label for="direccion">Dirección</label>
                    <input type="text" class="form-control" v-model="proveedor.direccion">
                    <span class="text-danger text-small">{{errores.direccion}}</span>
                </div>
                <div class="col-md-6">
                    <label for="telefono">Telefono</label>
                    <input type="number" class="form-control" v-model.number="proveedor.telefono">
                    <span class="text-danger text-small">{{errores.telefono}}</span>
                </div>
                <div class="col-md-6">
                    <label for="email">Correo electronico</label>
                    <input type="email" class="form-control" v-model="proveedor.email">
                    <span class="text-danger text-small">{{errores.email}}</span>
                </div>
                <div class="col-md-12 mt-3">
                    <button class="btn btn-primary" @click="guardarProveedor" v-if="btnCrear">Guardar</button>
                    <button class="btn btn-warning" @click="editarProveedor" v-else>Editar</button>
                </div>
            </div>
            <div class="row my-3" v-if="respuestaOk">
                <div class="col-md-12">
                    <p class="alert alert-info">Agregado correctamente</p>
                </div>
            </div>
        </b-modal>
        <div class="d-flex justify-content-between my-3">
            <div>
                <h1>Proveedors</h1>
            </div>
            <div>
                <button class="btn btn-success" @click="crearProveedor" ><i class="fas fa-plus-square mr-2"></i>Agregar</button>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Identificacion</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in proveedores" :key="index">
                    <td>{{item.id}}</td>
                    <td>{{item.nombres}}</td>
                    <td>{{item.apellidos}}</td>
                    <td>{{item.direccion}}</td>
                    <td>{{item.telefono}}</td>
                    <td>{{item.email}}</td>
                    <td>
                        <button class="btn btn-warning" title="Editar" @click="mostrarProveedor(item.id)"><i class="fas fa-edit text-white"></i></button>
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
                errores: '',
                proveedor: {id: '', nombres: '', apellidos: '', direccion: '', telefono: '', email: ''},
                proveedores: [],
                respuestaOk: false,
                tituloModal: ''
            }
        },
        mounted() {
            this.getProveedores()
        },
        methods: {
            crearProveedor(){
                this.respuestaOk = false;
                this.btnCrear = true;
                this.tituloModal = 'Crear proveedor';
                this.proveedor = {id: '', nombres: '', apellidos: '', direccion: '', telefono: '', email: ''};
                this.errores = '';
                this.$refs['modal-proveedor'].show();
            },
            editarProveedor(){

                if(this.proveedor.id === '' || this.proveedor.nombres === '' || this.proveedor.apellidos === '' || this.proveedor.direccion === '' || this.proveedor.telefono === '' || this.proveedor.email === ''){
                    alert('Hay campos vacios');
                    return;
                }

                axios.put(`/proveedores/${this.proveedor.id}`, this.proveedor)
                    .then(res => {
                        if(res.data === 'ok'){
                            this.respuestaOk = true;
                            this.getProveedores();
                        }else{
                            this.errores = res.data;
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            getProveedores(){
                axios.get('/proveedores')
                    .then(res => {
                        this.proveedores = res.data
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            guardarProveedor(){

                if(this.proveedor.id === '' || this.proveedor.nombres === '' || this.proveedor.apellidos === '' || this.proveedor.direccion === '' || this.proveedor.telefono === '' || this.proveedor.email === ''){
                    alert('Hay campos vacios');
                    return;
                }

                axios.post('/proveedores', this.proveedor)
                    .then(res => {
                        if(res.data === 'ok'){
                            this.respuestaOk = true;
                            this.getProveedores();
                        }else{
                            this.errores = res.data;
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            mostrarProveedor(id){
                axios.get(`/proveedores/${id}`)
                    .then(res => {
                        this.proveedor.id = res.data.id;
                        this.proveedor.nombres = res.data.nombres;
                        this.proveedor.apellidos = res.data.apellidos;
                        this.proveedor.direccion = res.data.direccion;
                        this.proveedor.telefono = res.data.telefono;
                        this.proveedor.email = res.data.email;

                        this.respuestaOk = false;
                        this.btnCrear = false;
                        this.errores = '';
                        this.tituloModal = 'Editar proveedor';
                        this.$refs['modal-proveedor'].show();

                    })
                    .catch(err => {
                        console.log(err)
                    })
            }
        },
    }
</script>