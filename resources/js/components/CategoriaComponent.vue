<template>
    <div>
        <!-- Modal creacion de categorias -->
        <b-modal ref="modal-categoria" hide-footer no-close-on-backdrop :title="tituloModal" size="lg">        
            <div class="row">
                
                <div class="col-md-12">
                    <label for="categoria">Categoria</label>
                    <input type="text" class="form-control" v-model="categoria.categoria">
                    <span class="text-danger text-small">{{errores.categoria}}</span>
                </div>
                <div class="col-md-12 mt-3">
                    <button class="btn btn-primary" @click="guardarCategoria" v-if="btnCrear">Guardar</button>
                    <button class="btn btn-warning" @click="editarCategoria" v-else>Editar</button>
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
                <h1>Categorias</h1>
            </div>
            <div>
                <button class="btn btn-success" @click="crearCategoria" ><i class="fas fa-plus-square mr-2"></i>Agregar</button>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Categoria</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in categorias" :key="index">
                    <td>{{item.id}}</td>
                    <td>{{item.categoria}}</td>
                    <td>
                        <button class="btn btn-warning" @click="mostrarCategoria(item.id)">Editar</button>
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
                categoria: {id: '', categoria: ''},
                categorias: [],
                errores: '',
                respuestaOk: false,
                tituloModal: ''
            }
        },
        mounted() {
            this.getCategorias()
        },
        methods: {
            crearCategoria(){
                this.respuestaOk = false;
                this.errores = '';
                this.tituloModal = 'Nueva categoria';
                this.btnCrear = true;
                this.categoria = {id: '', categoria: ''};
                this.$refs['modal-categoria'].show();
            },
            editarCategoria(){
                axios.put(`/categorias/${this.categoria.id}`, this.categoria)
                    .then(res => {
                        console.log(res.data)
                        if(res.data === 'ok'){
                            this.respuestaOk = true;
                            this.getCategorias();
                        }else{
                            errores = res.data;
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            getCategorias(){
                axios.get('/categorias')
                    .then(res => {
                        this.categorias = res.data;
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            guardarCategoria(){
                axios.post('/categorias', this.categoria)
                    .then(res => {
                        console.log(res.data)
                        if(res.data === 'ok'){
                            this.respuestaOk = true;
                            this.getCategorias();
                        }else{
                            errores = res.data;
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            mostrarCategoria(id){
                axios.get(`/categorias/${id}`, this.categoria)
                    .then(res => {
                        this.categoria.id = res.data.id;
                        this.categoria.categoria = res.data.categoria;

                        this.respuestaOk = false;
                        this.errores = '';
                        this.tituloModal = 'Editar categoria';
                        this.btnCrear = false;
                        this.$refs['modal-categoria'].show();
                    })
                    .catch(err => {
                        console.log(err)
                    })
            }
        },
    }
</script>