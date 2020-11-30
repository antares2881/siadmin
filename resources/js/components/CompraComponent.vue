<template>
    <div>
        <b-modal ref="modal-productos" hide-footer no-close-on-backdrop title="Detalle productos" size="lg">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in detalleCompra" :key="index">
                        <td>{{item.productos.nombre}}</td>
                        <td>{{item.productos.precio}}</td>
                        <td>{{item.cantidad}}</td>
                        <td>{{item.cantidad * item.productos.precio}}</td>                        
                    </tr>
                </tbody>
            </table>
        </b-modal>
        <b-modal ref="modal-compra" hide-footer no-close-on-backdrop :title="tituloModal" size="xl"> 
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-success my-3" @click="agregarNuevaCompra"><i class="fas fa-plus-square mr-2"></i>Agregar compra</button>
                </div>                
                <div class="col-md-4">
                    <label for="factura">No. factura</label>
                    <input type="text" class="form-control" v-model="compra.factura">
                    <span class="text-danger text-small">{{errores.factura}}</span>
                </div>
                <div class="col-md-4">
                    <label for="producto">Producto</label>
                    <b-form-select v-model="datosCompra.producto_id" :options="productos" @input="agregaPrecioProducto"></b-form-select>
                </div>                
                <div class="col-md-4">
                    <label for="">Precio del producto</label>
                    <input type="number" class="form-control" v-model="compra.precioproducto" readonly>
                </div>
                <div class="col-md-4">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" class="form-control" v-model.number="datosCompra.cantidad">
                </div>
                <div class="col-md-4">
                    <label for="">Valor de la compra</label>
                    <input type="number" class="form-control" :value="calculaPrecioCompra" >
                </div>
                <div class="col-md-6 mb-2">
                    <label for="total">Total compra</label>
                    <input type="number" class="form-control" v-model="compra.total" readonly>
                    <input type="hidden" class="form-control" v-model="compra.total">
                </div>
                <div class="col-md-12" v-for="(item, index) in compra.compras" :key="index">
                    <p class="alert alert-info">Producto: {{item.desc_producto}}  Cantidad: {{item.cantidad}} = ${{item.precio * item.cantidad}}</p>
                </div>
                <div class="mt-2 col-md-12">
                    <button class="btn btn-primary" v-if="btnCrear" @click="guardarCompra">Guardar compra</button>
                </div>
                <div class="col-md-12 mt-2" v-if="respuestaOk">
                    <p class="alert alert-success">Compra guardada</p>
                </div>
            </div>
        </b-modal>
        <div class="d-flex justify-content-between my-3">
            <div>
                <h1>Compras</h1>
            </div>
            <div>
                <button class="btn btn-success" @click="nuevaCompra" ><i class="fas fa-plus-square mr-2"></i>Nueva compra</button>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Productos</th>
                    <th>No. factura</th>
                    <th>Total compra</th>
                    <th>Fecha compra</th>
                    <td>Eliminar</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in compras" :key="index">
                    <td>
                        <button class="btn btn-secondary" @click="detalleProductos(item.id)">Ver productos</button>
                    </td>
                    <td>{{item.factura}}</td>
                    <td>{{item.total}}</td>
                    <td>{{item.created_at}}</td>
                    <td>
                        <button class="btn btn-danger" @click="eliminarCompra(item.id)"><i class="fas fa-trash-alt"></i></button>
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
                compra: {id: '', compras: [], factura: '', total: 0},
                compras: [],
                datosCompra: {producto_id: '', cantidad: 0},
                detalleCompra: [],
                errores: '',
                productos: [],
                proveedores: [],
                respuestaOk: false,
                tituloModal: ''
            }
        },
        mounted() {
            this.getCompras();
            this.getProveedores();
            this.getProductos();
        },
        methods: {
            agregarNuevaCompra(){
                this.compra.compras.push({
                    producto_id: this.datosCompra.producto_id.id,
                    desc_producto: this.datosCompra.producto_id.desc,
                    precio: this.datosCompra.producto_id.precio,
                    cantidad: this.datosCompra.cantidad
                });

                let total = 0;

                for (let i = 0; i < this.compra.compras.length; i++) {
                    total += parseInt(this.compra.compras[i].precio) * parseInt(this.compra.compras[i].cantidad);   
                }

                this.compra.total = total;

                this.datosCompra.producto_id = '';
                this.datosCompra.cantidad = 0;
                this.datosCompra.proveedore_id = '';
                this.compra.precioproducto = 0;                
                
            },
            agregaPrecioProducto(){
                this.compra.precioproducto = this.datosCompra.producto_id.precio;
            },
            detalleProductos(id){
                axios.get(`/compraproductos/${id}`)
                    .then(res => {
                        this.detalleCompra = res.data;
                        this.$refs['modal-productos'].show();
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            eliminarCompra(id){
                let confirmar = confirm('¿Estas seguro de eliminar la compra?')
                if(confirmar){
                    axios.delete(`/compras/${id}`)
                        .then(res => {
                            location.reload();
                        })
                        .catch(err => {
                            console.log(err)
                        })
                }
                    
            },
            getCompras(){
                axios.get('/compras')
                    .then(res => {
                        console.log(res.data)
                        this.compras = res.data;
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            getProducto(id){
                axios.get(`/productos/${id}`)
                    .then(res => {
                        console.log(res.data)
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            getProductos(){
                axios.get('/productos')
                    .then(res => {
                        // console.log(res.data)
                        for (let i = 0; i < res.data.length; i++) {
                            this.productos.push({
                                value: {id: res.data[i].id, precio: res.data[i].precio, desc: res.data[i].nombre},
                                text: res.data[i].nombre,
                            });
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            getProveedores(){
                axios.get('/proveedores')
                    .then(res => {
                        for (let i = 0; i < res.data.length; i++) {
                            this.proveedores.push({
                                value: res.data[i].id,
                                text: res.data[i].nombres +' '+ res.data[i].apellidos
                            });
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            guardarCompra(){
                if(this.compra.factura === '' || this.compra.compras.length === 0 || this.compra.total === 0){
                    alert('Hay campos vacios');
                    return;
                }

                // console.log(this.compra.compras)

                axios.post('/compras', this.compra)
                    .then(res => {
                        if(res.data === 'ok'){
                            this.respuestaOk = true;
                            this.getCompras();
                        }else{
                            this.errores = res.data;
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            nuevaCompra(){
                this.btnCrear = true;
                this.tituloModal = 'Nueva compra';
                this.compra = {id: '', compras: [], factura: '', total: 0};
                this.errores = '';
                this.repuestaOk = false;
                this.$refs['modal-compra'].show();
            }
        },
        computed: {
            calculaPrecioCompra(){
                return this.datosCompra.producto_id.precio * this.datosCompra.cantidad;
            },
            totalCompra(){

            }
        },
    }
</script>