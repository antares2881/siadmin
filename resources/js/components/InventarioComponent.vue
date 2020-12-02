<template>
    <div>
        <!-- Modal creacion de inventario -->
        <b-modal ref="modal-inventario" hide-footer no-close-on-backdrop :title="tituloModal" size="lg">        
            <div class="row">
                <div class="col-md-12">
                    <label for="producto">Producto</label>
                    <b-form-select v-model="inventario.producto_id" :options="productos"></b-form-select>
                    <span class="text-danger text-small">{{errores.producto_id}}</span>
                </div>
                <div class="col-md-12">
                    <label for="stock">Stock</label>
                    <input type="number" class="form-control" v-model="inventario.stock">
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
                <h1>Inventario</h1>
            </div>            
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Producto</th>
                    <th>Stock</th>
                    <th>Fecha de actualizacion</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in inventarios" :key="index">
                    <td>{{item.productos.categoria_id}}</td>
                    <td>{{item.productos.nombre}}</td>
                    <td>{{item.stock}}</td>
                    <td>{{item.updated_at}}</td>
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
                inventario: {producto_id: '', stock: 0},
                inventarios: [],
                productos: [],
                respuestaOk: false,
                tituloModal: ''
            }
        },
        mounted() {
            this.getProductos();
            this.getInventario();
        },
        methods: {
            crearProducto(){
                this.errores = '';
                this.tituloModal = 'Nuevo inventario';
                this.btnCrear = true;
                this.inventario = {producto_id: '', stock: 0};
                this.$refs['modal-inventario'].show();
            },
            editarProducto(){

            },
            getInventario(){
                axios.get('/inventario')
                    .then(res => {
                        console.log(res.data)
                        this.inventarios = res.data;
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            getProductos(){
                axios.get('/productos')
                    .then(res => {
                        console.log(res.data)
                        for (let i = 0; i < res.data.length; i++) {
                            this.productos.push({
                                value: res.data[i].id,
                                text: res.data[i].nombre
                            })                          
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            guardarProducto(){

                if(this.inventario.producto_id === '' || this.inventario.stock === 0){
                    alert('Hay campos vacios');
                    return;
                }

                axios.post('/inventario', this.inventario)
                    .then(res => {
                        // console.log(res.data)
                        this.inventario.stock = 0;

                        if(res.data === 'ok'){
                            this.inventario.producto_id = '';
                            this.respuestaOk = true;
                            this.getInventario();
                        }else{
                            this.errores = res.data;
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })

            },
            
            showProducto(id){
                axios.get(`/inventario/${id}`)
                    .then(res => {
                        this.inventario.producto_id = res.data.producto_id;
                        this.inventario.stock = res.data.stock;
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
        },
    }
</script>