<template>
    <div>
         <!-- Modal creacion de empresas -->
        <b-modal ref="modal-empresa" hide-footer no-close-on-backdrop :title="tituloModal" size="lg">        
            <div class="row">                
                <div class="col-md-6">
                    <label for="empresa">Usuario</label>
                    <b-form-select v-model="empresa.user_id" :options="usuarios"></b-form-select>
                    <span class="text-danger text-small">{{errores.user_id}}</span>
                </div>
                <div class="col-md-6">
                    <label for="nit">Nit</label>
                    <input type="text" class="form-control" v-model="empresa.nit">
                    <span class="text-danger text-small">{{errores.nit}}</span>

                </div>
                <div class="col-md-12">
                    <label for="razon_social">Razon social</label>
                    <input type="text" class="form-control" v-model="empresa.razon_social">
                    <span class="text-danger text-small">{{errores.razon_social}}</span>
                </div>
                <div class="col-md-12">
                    <label for="servicios">Servicios</label>
                    <textarea class="form-control" v-model="empresa.servicios"></textarea>
                </div>
                <div class="col-md-6">
                    <label for="direccion">Direccion</label>
                    <input type="text" class="form-control" v-model="empresa.direccion">
                </div>
                <div class="col-md-6">
                    <label for="telefono">Telefono</label>
                    <input type="text" class="form-control" v-model="empresa.telefono">
                    <span class="text-danger text-small">{{errores.telefono}}</span>
                </div>
                <div class="col-md-6">
                    <label for="email">Correo electronico</label>
                    <input type="email" class="form-control" v-model="empresa.email">
                    <span class="text-danger text-small">{{errores.email}}</span>
                </div>
                <div class="mt-3 col-md-12">
                    <button class="btn btn-primary" @click="guardarempresa" v-if="btnCrear">Guardar</button>
                    <button class="btn btn-warning" @click="editarempresa" v-else>Editar</button>
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
                <h1>empresas</h1>
            </div>
            <div>
                <button class="btn btn-success" @click="crearempresa" ><i class="fas fa-plus-square mr-2"></i>Agregar</button>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nit</th>
                    <th>Razon social</th>
                    <th>Servicios</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in empresas" :key="index">
                    <td>{{item.nit}}</td>
                    <td>{{item.razon_social}}</td>
                    <td>{{item.servicios}}</td>
                    <td>{{item.direccion}}</td>
                    <td>{{item.telefono}}</td>
                    <td>{{item.email}}</td>
                    <td>
                        <button class="btn btn-warning" @click="mostrarEmpresa(item.id)">Editar</button>
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
                empresa: {id: '', user_id: '', nit: '', razon_social: '', servicios: '', direccion: '', telefono: '', 
                email: '', logo: 'Sin avatar'},
                empresas: [],
                errores: '',
                respuestaOk: false,
                tituloModal: '',
                usuarios: []
            }
        },
        mounted() {
            this.getEmpresas();
            this.getUsuarios();
        },
        methods: {
            crearempresa(){
                this.respuestaOk = false;
                this.errores = '';
                this.tituloModal = 'Nueva empresa';
                this.btnCrear = true;
                this.empresa = {id: '', user_id: '', nit: '', razon_social: '', servicios: '', direccion: '', telefono: '', email: '', logo: 'Sin avatar'};
                this.$refs['modal-empresa'].show();
            },
            editarempresa(){

                if(this.empresa.user_id === '' || this.empresa.nit === '' || this.empresa.razon_social === '' || this.empresa.servicios === '' || this.empresa.direccion === '' || this.empresa.telefono === '' || this.empresa.email === ''){
                    alert('Hay campos vacios');
                    return;
                }

                axios.put(`/empresas/${this.empresa.id}`, this.empresa)
                    .then(res => {
                        if(res.data === 'ok'){
                            this.respuestaOk = true;
                            this.getEmpresas();
                        }else{
                            this.errores = res.data;
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            getEmpresas(){
                axios.get('/empresas')
                    .then(res => {
                        this.empresas = res.data;
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            getUsuarios(){
                axios.get('/usuarios')
                    .then(res => {
                        for (let i = 0; i < res.data.length; i++) {
                            this.usuarios.push({
                                value: res.data[i].id,
                                text: res.data[i].email
                            })
                        }
                        
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            guardarempresa(){

                if(this.empresa.user_id === '' || this.empresa.nit === '' || this.empresa.razon_social === '' || this.empresa.servicios === '' || this.empresa.direccion === '' || this.empresa.telefono === '' || this.empresa.email === ''){
                    alert('Hay campos vacios');
                    return;
                }

                axios.post('/empresas', this.empresa)
                    .then(res => {
                        if(res.data === 'ok'){
                            this.respuestaOk = true;
                            this.getEmpresas();
                        }else{
                            this.errores = res.data;
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })

            },
            mostrarEmpresa(id){
                axios.get(`/empresas/${id}`)
                    .then(res => {
                        this.empresa.id = res.data.id;
                        this.empresa.user_id = res.data.user_id;
                        this.empresa.nit = res.data.nit;
                        this.empresa.razon_social = res.data.razon_social;
                        this.empresa.servicios = res.data.servicios;
                        this.empresa.direccion = res.data.direccion;
                        this.empresa.telefono = res.data.telefono;
                        this.empresa.email = res.data.email;
                        this.empresa.logo = res.data.logo;

                        this.respuestaOk = false;
                        this.errores = '';
                        this.tituloModal = 'Editar empresa';
                        this.btnCrear = false;
                        this.$refs['modal-empresa'].show();

                    })
            }
        },
    }
</script>