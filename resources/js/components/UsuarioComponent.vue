<template>
    <div>
        <b-modal ref="modal-usuario" hide-footer no-close-on-backdrop :title="tituloModal" size="lg"> 
            <div class="row">
                <div class="col-md-6">
                    <label for="role_id">Rol</label>
                    <b-form-select v-model="usuario.role_id" :options="roles"></b-form-select>
                </div>
                <div class="col-md-6">
                    <label for="name">Nombres</label>
                    <input type="text" class="form-control" v-model="usuario.name">
                    <span class="text-danger text-small">{{errores.name}}</span>
                </div>
                <div class="col-md-6">
                    <label for="email">Correo electronico</label>
                    <input type="text" class="form-control" v-model="usuario.email">
                    <span class="text-danger text-small">{{errores.email}}</span>
                </div>
                <div class="col-md-6" v-if="btnCrear">
                    <label for="password">Clave</label>
                    <input type="password" class="form-control" v-model="usuario.password">
                    <span class="text-danger text-small">{{errores.password}}</span>
                </div>
                <div class="col-md-12 my-3">
                    <button class="btn btn-primary" v-if="btnCrear" @click="guardarUsuario">Guardar</button>
                    <button class="btn btn-warning" v-else @click="editarUsuario">Editar</button>
                </div>
                <div class="col-md-12" v-if="respuestaOk">                    
                    <p class="alert alert-info">Guardado correctamente</p>
                </div>
            </div>
        </b-modal>
        <div class="d-flex justify-content-between my-3">
            <div>
                <h1>Usuarios</h1>
            </div>
            <div>
                <button class="btn btn-success" @click="crearUsuario" ><i class="fas fa-plus-square mr-2"></i>Agregar</button>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombres</th>
                    <th>Correo electronico</th>
                    <th>Role</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in usuarios" :key="index">
                    <td>{{item.name}}</td>
                    <td>{{item.email}}</td>
                    <td>{{item.role}}</td>
                    <td>
                        <button class="btn btn-warning" @click="mostrarUsuario(item.id)">Editar</button>
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
                respuestaOk: false,            
                roles: [],
                tituloModal: '',
                usuario: {id: '', role_id: '', name: '', email: '', password: ''},
                usuarios: [],
            }
        },
        mounted() {
            this.getUsuarios();
            this.getRoles();
        },
        methods: {
            crearUsuario(){
                this.btnCrear = true;
                this.respuestaOk = false;
                this.usuario = {id: '', role_id: '', name: '', email: '', password: ''};
                this.tituloModal = 'Crear usuario';
                this.errores = '';
                this.$refs['modal-usuario'].show();
            },
            editarUsuario(){
                if(this.usuario.name === '' || this.usuario.role_id === '' || this.usuario.email === '' ){
                    alert('Hay campos vacios')
                    return;
                }

                axios.put(`/usuarios/${this.usuario.id}`, this.usuario)
                    .then(res => {
                        if(res.data === 'ok'){
                            this.respuestaOk = true;
                            this.getUsuarios();
                        }else{
                            this.errores = res.data;
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            getUsuarios(){
                axios.get('/usuarios')
                    .then(res => {
                        this.usuarios = res.data;
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            getRoles(){
                axios.get('/roles')
                    .then(res => {
                        // console.log(res.data)
                        for (let i = 0; i < res.data.length; i++) {
                            this.roles.push({
                                value: res.data[i].id,
                                text: res.data[i].role
                            });                            
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            guardarUsuario(){
                if(this.usuario.name === '' || this.usuario.role_id === '' || this.usuario.email === '' || this.usuario.password === ''){
                    alert('Hay campos vacios')
                    return;
                }

                axios.post('/usuarios', this.usuario)
                    .then(res => {
                        if(res.data === 'ok'){
                            this.respuestaOk = true;
                            this.getUsuarios();
                        }else{
                            this.errores = res.data;
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            mostrarUsuario(id){
                axios.get(`/usuarios/${id}`)
                    .then(res => {
                        this.usuario.id = res.data.id;
                        this.usuario.role_id = res.data.role_id;
                        this.usuario.name = res.data.name;
                        this.usuario.email = res.data.email;

                        this.btnCrear = false;
                        this.respuestaOk = false;
                        this.tituloModal = 'Editar usuario';
                        this.errores = '';
                        this.$refs['modal-usuario'].show();
                    })
                    .catch(err => {
                        console.log(err)
                    })
            }
        },
    }
</script>