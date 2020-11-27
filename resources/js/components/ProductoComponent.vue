<template>
    <div>
        <!-- Modal creacion de productos -->
        <b-modal ref="modal-producto" hide-footer no-close-on-backdrop :title="tituloModal" size="lg">        
            <div class="row">
                <div class="col-md-12">
                    <label for="categoria">Categoria</label>
                    <b-form-select v-model="producto.categoria_id" :options="categorias"></b-form-select>
                </div>
                <div class="col-md-12">
                    <label for="producto">Nombre Producto</label>
                    <input type="text" class="form-control" v-model="producto.nombre">
                    <span class="text-danger text-small">{{errores.nombre}}</span>
                </div>
                <div class="col-md-12">
                    <label for="marca">Marca</label>
                    <input type="text" class="form-control" v-model="producto.marca">
                </div>
                <div class="col-md-12">
                    <label for="precio">Precio</label>
                    <input type="number" class="form-control" v-model="producto.precio">
                </div>
                <div class="col-md-12 mt-3">
                    <button class="btn btn-primary" @click="guardarProducto" v-if="btnCrear">Guardar</button>
                    <button class="btn btn-warning" @click="editarProducto" v-else>Editar</button>
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
                <h1>Productos</h1>
            </div>
            <div>
                <button class="btn btn-success" @click="crearProducto" ><i class="fas fa-plus-square mr-2"></i>Agregar</button>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Producto</th>
                    <th>Marca</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in productos" :key="index">
                    <td>{{item.categorias.categoria}}</td>
                    <td>{{item.nombre}}</td>
                    <td>{{item.marca}}</td>
                    <td>{{item.precio}}</td>
                    <td>
                        <button class="btn btn-warning" title="Editar" @click="showProducto(item.id)"><i class="fas fa-edit text-white"></i></button>
                        <!-- <button class="btn btn-danger" title="Eliminar" @click="eliminarProducto(item.id)"><i class="fas fa-trash-alt"></i></button> -->
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
                producto: {id: '', categoria_id: '', nombre: '', marca: '', precio: 0},
                categorias: [],
                productos: [],
                respuestaOk: false,
                tituloModal: ''
            }
        },
        mounted() {
            this.getProductos();
            this.getCategorias();
        },
        methods: {
            crearProducto(){
                this.errores = '';
                this.tituloModal = 'Nuevo producto';
                this.btnCrear = true;
                this.producto = {categoria_id: '', nombre: '', marca: '', precio: 0};
                this.$refs['modal-producto'].show();
            },
            editarProducto(){
                if(this.producto.categoria_id === '' || this.producto.nombre === '' || this.producto.marca === '' || this.producto.precio === 0){
                    alert('Hay campos vacios');
                    return;
                }

                axios.put(`/productos/${this.producto.id}`, this.producto)
                    .then(res => {
                        // console.log(res.data)

                        if(res.data === 'ok'){
                            this.respuestaOk = true;
                            this.getProductos();
                        }else{
                            this.errores = res.data;
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            eliminarProducto(id){
                let confirma = confirm('Estas seguro que deseas eliminar el producto?');
                if(confirma){
                    axios.delete(`/productos/${id}`)
                        .then(res => {
                            console.log(res.data)
                            location.reload();
                        })
                        .catch(err => {
                            console.log(err)
                        })
                }
            },
            getProductos(){
                axios.get('/productos')
                    .then(res => {
                        // console.log(res.data)
                        this.productos = res.data;
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            getCategorias(){
                axios.get('/categorias')
                    .then(res => {
                        // console.log(res.data)
                        for (let i = 0; i < res.data.length; i++) {
                            this.categorias.push({
                                value: res.data[i].id,
                                text: res.data[i].categoria
                            })                          
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            guardarProducto(){

                if(this.producto.categoria_id === '' || this.producto.nombre === '' || this.producto.marca === '' || this.producto.precio === 0){
                    alert('Hay campos vacios');
                    return;
                }

                axios.post('/productos', this.producto)
                    .then(res => {
                        // console.log(res.data)

                        if(res.data === 'ok'){
                            this.respuestaOk = true;
                            this.getProductos();
                        }else{
                            this.errores = res.data;
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })

            },
            
            showProducto(id){
                axios.get(`/productos/${id}`)
                    .then(res => {
                        // console.log(res.data)
                        this.producto.id = res.data.id;
                        this.producto.categoria_id = res.data.categoria_id;
                        this.producto.nombre = res.data.nombre;
                        this.producto.marca = res.data.marca;
                        this.producto.precio = res.data.precio;

                        this.respuestaOk = false,

                        this.errores = '';
                        this.tituloModal = 'Editar producto';
                        this.btnCrear = false;
                        this.$refs['modal-producto'].show();
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
        },
    }
</script>