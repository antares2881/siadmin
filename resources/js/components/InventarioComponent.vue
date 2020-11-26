<template>
    <div>
        <!-- Modal creacion de inventario -->
        <div class="modal fade" id="modal-inventario" tabindex="-1" aria-labelledby="modalInventarioLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalInventarioLabel">Agregar Nuevo Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="producto">Producto</label>
                            <b-form-select v-model="inventario.producto_id" :options="productos"></b-form-select>
                        </div>
                        <div class="col-md-12">
                            <label for="stock">Stock</label>
                            <input type="number" class="form-control" v-model="inventario.stock">
                        </div>
                        <div class="col-md-12 mt-3">
                            <button class="btn btn-primary" @click="guardarProducto">Guardar</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between my-3">
            <div>
                <h1>Inventario</h1>
            </div>
            <div>
                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modal-inventario"><i class="fas fa-plus-square mr-2"></i>Agregar</button>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Fecha de ingreso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in inventarios" :key="index">
                    <td>{{item.productos.categoria_id}}</td>
                    <td>{{item.productos.nombre}}</td>
                    <td>{{item.productos.precio}}</td>
                    <td>{{item.stock}}</td>
                    <td>{{item.created_at}}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                inventario: {producto_id: '', stock: 0},
                inventarios: [],
                productos: []
            }
        },
        mounted() {
            this.getProductos();
            this.getInventario();
        },
        methods: {
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
                        console.log(res.data)
                        this.getInventario();
                    })
                    .catch(err => {
                        console.log(err)
                    })

            }
        },
    }
</script>